<?php
  require_once "../../database.php";
  require_once "../php/utilities.php";

  define("PER_PAGE", 4);
  header("Content-type: application/json");

  $status = 200;
  if(isset($_POST['ids'])) {
    $ids = $_POST['ids'];
    $page = 1;
    if(isset($_POST['page'])) {
      $page = $_POST['page'];
    }
    $array = "(";
    $count = count($ids);
    $bindings = [];

    foreach($ids as $index => $id) {
      $array .= ":a$index";
      $bindings["a$index"] = $id;
      if($index < $count - 1) {
        $array .= ",";
      }
    }
    $array .= ")";

    $query = "select c.* as total from comics c
            join comics_sub_filters filter on c.id = filter.id_comic
            join sub_filters sf on filter.id_sub_filter = sf.id
            where sf.id in ". $array;
    
    try {
      $pages = bindAndSelect($conn, $query, $bindings, false);
      $resp = [
        "total" => $pages
      ];
      echo json_encode($resp);
    } catch(Exception $e) {
      $status = 500;
    }
  } else {
    $page = 1;
    if(isset($_POST['page'])) $page = $_POST['page'];
    $od = ($page-1) * PER_PAGE; 
    // page=1 0 * 3 = 1 // 0, 3 -> 1,2,3
    // page=2 1 * 3 = 3 // 3, 3 -> 4,5,6
    // ...
    // page=5 4 * 3 = 12 // 12, 3 -> 13, 14, 15
    // page=6 
    $koliko = PER_PAGE;
    $upit = "SELECT c.*, p.alt, p.path FROM comics c 
            INNER JOIN pictures p ON c.id = p.id_comic
            LIMIT :od, $koliko";
    $count = $conn->query("SELECT COUNT(*) AS num FROM comics")->fetch()->num;
    $pages = ceil($count / PER_PAGE);
    $stmt = $conn->prepare($upit);
    $stmt->bindParam(":od", $od, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll();
    
    $resp = [
      "total" => $pages,
      "page"  => $page,
      "data" => $data
    ];
    echo json_encode($resp);
  }
  http_response_code($status);