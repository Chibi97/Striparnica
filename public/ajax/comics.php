<?php
  require_once "../../database.php";
  require_once "../php/utilities.php";

  $status = 200;
  if(isset($_POST['ids'])) {
    $ids = $_POST['ids'];
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

    $query = "select c.* from comics c
            join comics_sub_filters filter on c.id = filter.id_comic
            join sub_filters sf on filter.id_sub_filter = sf.id
            where sf.id in ". $array;
    try {
      $result = bindAndSelect($conn, $query, $bindings, false);
      echo json_encode($result);
    } catch(Exception $e) {
      $status = 500;
    }
  } else {
    $upit = "SELECT c.*, p.alt, p.path FROM comics c INNER JOIN pictures p ON c.id = p.id_comic WHERE p.primary = 1";
    echo json_encode($conn->query($upit)->fetchAll());
  }
  http_response_code($status);