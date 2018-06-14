<?php
  function error_for($key, $arr) {
    if(isset($_SESSION["$arr"][$key])) {
      return $_SESSION["$arr"][$key];
    }
    return "";
  }

  function multi_error_for($key, $arr, $i) {
    // $_SESSION['comicErrors']['comic-por-pic'][type]
    // ........................................ [size]
    if(isset($_SESSION["$arr"][$key][$i])) {
      return $_SESSION["$arr"][$key][$i];
    }
    return "";
  }

  function selectMultipleRows($conn, $upit) {
    $result = $conn->query($upit);
    return $result->fetchAll();
  }

  function bind($conn, $upit, $bindings) {
    $result = $conn->prepare($upit);
 
    foreach($bindings as $label => $value) {
      ${"$label"} = $value; 
      $result->bindParam(":$label", $$label);
    }
    try {
      $result->execute();
    } catch (PDOException $e) {
      return null;
    }
    return $result;
  }

  function bindAndSelect($conn, $upit, $bindings, $fetchOne) {
    $result = bind($conn, $upit, $bindings);
    // echo $result->debugDumpParams();

    if($fetchOne) {
      if($result->rowCount() > 1) {
        throw new Exception("Rezultat je vratio vise od jednog!!");
      }
      $selected = $result->fetch();
    } else {
      $selected = $result->fetchAll();
    }
    return $selected;
  } 

  function selectFiltersWithSubfilter($conn) {
    $final = [];
    $records = $conn->query("
      SELECT f.id AS filter_id, f.name AS filter_name, 
      sf.id AS sf_id, sf.name AS sf_name FROM filters f
      JOIN sub_filters sf ON f.id=sf.id_filter
    ")->fetchAll();
    foreach($records as $record) {
      $idFilter = $record->filter_id;
      if(!array_key_exists($idFilter, $final)) {
        $single = [
          "id"         => $idFilter,
          "name"       => $record->filter_name,
          "subfilters" => []
        ];
        $single['subfilters'][] = (object)[
            "id"   => $record->sf_id,
            "name" => $record->sf_name
        ];
        $final[$idFilter] = (object)$single;
      } else {
        $final[$idFilter]->subfilters[] = (object)[
          "id"   => $record->sf_id,
          "name" => $record->sf_name
        ];
      }
    }
    
    return $final;
  }


  function validatePicture($picture, &$errors, $value) {
    $name = $picture['name'];
    $type = $picture['type'];
    $originPath = $picture['tmp_name'];
    $size = $picture['size'];

    $formats = ['image/jpg', 'image/png', 'image/jpeg'];
    if(!in_array($type, $formats)) {
      $errors[$value]['type'] = "Picture must be jpg / jpeg or png";
    }

    if($size > 0) {
      $errors[$value]['size'] = "You need to upload a picture lighter than 5MB";
    }
  }




