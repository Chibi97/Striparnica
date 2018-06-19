<?php
  session_start();
  require_once "../../database.php";
  require_once "../php/utilities.php";

  define("PER_PAGE", 8);
  header("Content-type: application/json");

  $status = 200;
  $role   = $_SESSION['user']->role;
  $userId = $_SESSION['user']->id;

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
    if(isset($_POST['page'])) {
      $page = $_POST['page'];
    }
    $od = ($page-1) * PER_PAGE;
    $koliko = PER_PAGE;
    
    $upit = "SELECT c.*,p.path, p.alt,l.id AS postoji, l.id_user AS ulogovan FROM comics c LEFT JOIN list l ON l.id_comic=c.id INNER JOIN pictures p ON p.id_comic = c.id LIMIT :od, $koliko";

    $count = $conn->query("SELECT COUNT(*) AS num FROM comics")->fetch()->num;
    $pages = ceil($count / PER_PAGE);

    $stmt = $conn->prepare($upit);
    $stmt->bindParam(":od", $od, PDO::PARAM_INT);
    $stmt->execute();
    $svi = $stmt->fetchAll();

    $query = "SELECT c.*, l.id_user 
    FROM comics c 
    LEFT JOIN list l ON c.id = l.id_comic 
    WHERE l.id_user=$userId OR l.id_user IS NULL";
    $comicPerUser = selectMultipleRows($conn, $query);

    $resp = [
      "total" => $pages,
      "page"  => $page,
      "role"  => $role,
      "svi" => $svi
    ];
    echo json_encode($resp);
  }
  http_response_code($status);