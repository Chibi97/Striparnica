<?php
  session_start();
  require_once "../../database.php";
  require_once "../php/utilities.php";

  define("PER_PAGE", 8);
  header("Content-type: application/json");

  $status = 200;
  $userId = isset($_SESSION['user']) ? $_SESSION['user']->id : null;

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

    $query = "SELECT DISTINCT c.*,p.path, p.alt FROM comics c INNER JOIN comics_sub_filters cf ON c.id = cf.id_comic INNER JOIN pictures p ON c.id = p.id_comic WHERE cf.id_sub_filter IN ". $array; 

    try {
      $result = bindAndSelect($conn, $query, $bindings, false);
      $resp = [
        "svi" => $result
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
    
    $upit = "SELECT DISTINCT c.*,p.path, p.alt,l.id AS postoji, l.id_user AS ulogovan FROM comics c LEFT JOIN list l ON l.id_comic=c.id INNER JOIN pictures p ON p.id_comic = c.id LIMIT :od, $koliko";

    $count = $conn->query("SELECT COUNT(*) AS num FROM comics")->fetch()->num;
    $pages = ceil($count / PER_PAGE);

    $stmt = $conn->prepare($upit);
    $stmt->bindParam(":od", $od, PDO::PARAM_INT);
    $stmt->execute();
    $svi = $stmt->fetchAll();

    /*$query = "SELECT c.*, l.id_user 
    FROM comics c 
    LEFT JOIN list l ON c.id = l.id_comic 
    WHERE l.id_user=$userId OR l.id_user IS NULL";
    $comicPerUser = selectMultipleRows($conn, $query);*/

    /*$query = "SELECT DISTINCT c.*, l.id_user FROM comics c LEFT JOIN list l ON c.id = l.id_comic WHERE l.id_user=$userId OR l.id_user IS NULL OR l.id_comic IS NOT NULL";
    $comicPerUser = selectMultipleRows($conn, $query);*/

    $resp = [
      "total" => $pages,
      "page"  => $page,
      "svi" => $svi
    ];
    echo json_encode($resp);
  }
  http_response_code($status);