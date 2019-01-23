<?php
  session_start();
  require_once "../../database.php";
  require_once "../php/utilities.php";


  define("PER_PAGE", 6);
  header("Content-type: application/json");

  $status = 200;
  $userId = isset($_SESSION['user']) ? $_SESSION['user']->id : 0;
  $loggedIn = isset($_SESSION['user']) ? true : false;

  // PAGINACIJA
  $page = 1;
  if(isset($_POST['page'])) {
    $page = $_POST['page'];
  }
  $od = ($page-1) * PER_PAGE;
  $koliko = PER_PAGE;

  $limit = "LIMIT :od, $koliko";

  $base_query = "SELECT DISTINCT c.*,p.path, p.alt, l.id_user FROM comics c 
  LEFT JOIN list l ON c.id = l.id_comic AND l.id_user=$userId
  JOIN pictures p ON c.id = p.id_comic 
  JOIN comics_sub_filters cf ON c.id = cf.id_comic";
   
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
    $stmt = $conn->prepare("SELECT COUNT(distinct csf.id_comic) AS num FROM comics c
    JOIN comics_sub_filters csf ON c.id = csf.id_comic 
    WHERE csf.id_sub_filter IN $array");
    foreach($bindings as $index => &$val) {
      $stmt->bindParam("$index", $val, PDO::PARAM_INT);
    }
    $stmt->execute();
    $count = $stmt->fetch()->num;
    $pages = ceil($count / PER_PAGE);
    $base_query .= " AND cf.id_sub_filter IN $array " . $limit;
    try {
      $stmt = $conn->prepare($base_query);
      $stmt->bindParam(":od", $od, PDO::PARAM_INT);
      foreach($bindings as $index => &$val) {
        $stmt->bindParam("$index", $val, PDO::PARAM_INT);
      }
      $stmt->execute();
      $result = $stmt->fetchAll();

      $final = [];
      foreach($result as $row) {
        $novi = [];
        $novi["id"] = $row->id;
        $novi["name"] = $row->name;
        $novi["description"] = $row->description;
        $novi["issues"] = $row->issues;
        $novi["path"] = $row->path;
        $novi["alt"] = $row->alt;
        $novi["flag"] = $row->id_user;

        if($novi["flag"] == $userId) {
          $novi["flag"] = true;
        } else {
          $novi["flag"] = false;
        }
        $final[] = (object) $novi;
       }

      $resp = [
        "total" => $pages,
        "page"  => $page,
        "data" => $final,
        "loggedIn" => $loggedIn
      ];
      echo json_encode($resp);
    } catch (Exception $e) {
      $status = 500;
    }
  } else {
    $count = $conn->query("SELECT COUNT(*) AS num FROM comics")->fetch()->num;
    $pages = ceil($count / PER_PAGE);

    try {
      $stmt = $conn->prepare($base_query . " " . $limit);
      $stmt->bindParam(":od", $od, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll();

      $final = [];
      foreach($result as $row) {
        $novi = [];
        $novi["id"] = $row->id;
        $novi["name"] = $row->name;
        $novi["description"] = $row->description;
        $novi["issues"] = $row->issues;
        $novi["path"] = $row->path;
        $novi["alt"] = $row->alt;
        $novi["flag"] = $row->id_user;

        if($novi["flag"] == $userId) {
          $novi["flag"] = true;
        } else {
          $novi["flag"] = false;
        }
        $final[] = $novi;
       }

      $resp = [
        "total" => $pages,
        "page"  => $page,
        "data" => $final,
        "loggedIn" => $loggedIn
      ];
      echo json_encode($resp);
    } catch (Exception $e) {
      $status = 500;
    }
  }

http_response_code($status);
