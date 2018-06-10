<?php
  function error_for($key) {
    if(isset($_SESSION['greske'][$key])) {
      return $_SESSION['greske'][$key];
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
    $result->execute();
    return $result;
  }

  function bindAndSelect($conn, $upit, $bindings, $fetchOne) {
    $result = bind($conn, $upit, $bindings);
    // echo $result->rowCount() . "<br>";
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