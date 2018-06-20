<?php
  session_start();
  require_once "../../database.php";
  require_once "../php/utilities.php";


  define("PER_PAGE", 8);
  header("Content-type: application/json");

  $status = 200;
  $userId = isset($_SESSION['user']) ? $_SESSION['user']->id : null;

  // PAGINACIJA
  $page = 1;
  if(isset($_POST['page'])) {
    $page = $_POST['page'];
  }
  $od = ($page-1) * PER_PAGE;
  $koliko = PER_PAGE;

  $count = $conn->query("SELECT COUNT(*) AS num FROM comics")->fetch()->num;
  $pages = ceil($count / PER_PAGE);
  
  $limit = "LIMIT :od, $koliko";
  $base_query = "SELECT DISTINCT c.*,p.path, p.alt, ( CASE WHEN l.id_user=$userId THEN 1 WHEN l.id_user <> $userId THEN NULL END ) AS flag FROM comics c LEFT JOIN list l ON c.id = l.id_comic INNER JOIN pictures p ON c.id = p.id_comic LEFT JOIN comics_sub_filters cf ON c.id = cf.id_comic WHERE (l.id_user=$userId OR l.id_user IS NULL OR l.id_comic IS NOT NULL)";

  // FILTRIRANJE - proslednjeni ID-evi
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
        $array .= ", ";
      }
    }
    $array .= ")";

   $base_query .= " AND cf.id_sub_filter IN $array " . $limit;
   try {
    $stmt = $conn->prepare($base_query);
    $stmt->bindParam(":od", $od, PDO::PARAM_INT);
    foreach($bindings as $index => &$val) {
      $stmt->bindParam("$index", $val, PDO::PARAM_INT);
    }
    $stmt->execute();
    $svi = $stmt->fetchAll();

    $resp = [
    "total" => $pages,
    "page"  => $page,
    "data" => $svi
    ];
    echo json_encode($resp);
    } catch (Exception $e) {
      $status = 500;
    }
  } else {
    try {
    $stmt = $conn->prepare($base_query . " " . $limit);
    $stmt->bindParam(":od", $od, PDO::PARAM_INT);
    $stmt->execute();
    $svi = $stmt->fetchAll();

    $resp = [
    "total" => $pages,
    "page"  => $page,
    "data" => $svi
    ];
    echo json_encode($resp);
    } catch (Exception $e) {
      $status = 500;
    }
  }

http_response_code($status);


   /* try {
      $result = bindAndSelect($conn, $query, $bindings, false);
      $resp = [
        "svi" => $result
      ];
      echo json_encode($resp);
    } catch(Exception $e) {
      $status = 500;
    } */ 
    
    //$upit = "SELECT DISTINCT c.*,p.path, p.alt, l.id_user FROM comics c LEFT JOIN list l ON l.id_comic=c.id INNER JOIN pictures p ON p.id_comic = c.id LIMIT :od, $koliko"; // FILTERI

    
    /*$query = "SELECT c.*, l.id_user 
    FROM comics c 
    LEFT JOIN list l ON c.id = l.id_comic 
    WHERE l.id_user=$userId OR l.id_user IS NULL";
    $comicPerUser = selectMultipleRows($conn, $query);*/

  /*  $query = "SELECT DISTINCT c.*, ( CASE WHEN l.id_user=2 THEN 1 WHEN l.id_user <> 2 THEN NULL END ) AS flag FROM comics c LEFT JOIN list l ON c.id = l.id_comic WHERE l.id_user=2 OR l.id_user IS NULL OR l.id_comic IS NOT NULL"; */
 // $comicPerUser = selectMultipleRows($conn, $query);

     /* $query = "SELECT DISTINCT c.*,p.path, p.alt FROM comics c INNER JOIN comics_sub_filters cf ON c.id = cf.id_comic INNER JOIN pictures p ON c.id = p.id_comic WHERE cf.id_sub_filter IN ". $array; */