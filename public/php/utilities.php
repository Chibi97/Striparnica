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

  function uploadPicture($picture) {
    $targetPath = "../images/comics" . basename($picture['name']) ."_" .  time();
    try {
      resize_image($picture['tmp_name'], 355);
      $uploaded = move_uploaded_file($tmpPath, $targetPath);
      return $uploaded;
    } catch(Exception $e) {
      echo "Slika nije u dobrom formatu";
    }
  }

  function validatePicture($picture, &$errors, $value) {
    $type = $picture['type'];
    $size = $picture['size'];

    $formats = ['image/jpg', 'image/png', 'image/jpeg'];
    if(!in_array($type, $formats)) {
      $errors[$value]['type'] = "Picture must be jpg / jpeg or png";
    }

    if($size > 2000000) {
      $errors[$value]['size'] = "You need to upload a picture lighter than 2MB";
    }
  }

  function resize_image($file, $targetHeight) {
    list($originalWidth, $originalHeight) = getimagesize($file);

    $ratio = $originalWidth / $originalHeight;

    if($ratio < 1) {
      $targetWidth = $targetHeight * $ratio;
    } else {
      throw new Exception("Wrong image format supplied");
      return;
    }
    $originalImage = imagecreatefromjpeg($file);
    $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);
    imagecopyresampled($targetImage, $originalImage,
        0, 0, 0, 0,
        $targetWidth, $targetHeight,
      $originalWidth, $originalHeight);
      imagejpeg($targetImage, $file, 100);
  }
