<?php
  define('PROJECT_ROOT', dirname(dirname(dirname(__FILE__))));
  define('DS', DIRECTORY_SEPARATOR);

  function relativeToProjectOS($path) {
    $final = PROJECT_ROOT . $path; 
    if(DS != '/') {
      return str_replace('/', "\\", $final);
    }
    return $final;
  }

  function error_for($key, $arr) {
    if(isset($_SESSION["$arr"][$key])) {
      return $_SESSION["$arr"][$key];
    }
    return "";
  }

  function multi_error_for($key, $arr, $subKey) {
    if(isset($_SESSION["$arr"][$key][$subKey])) {
      return $_SESSION["$arr"][$key][$subKey];
    }
    return "";
  }

  function selectMultipleRows($conn, $upit) {
    $result = $conn->query($upit);
    return $result->fetchAll();
  }

  function bind($conn, $upit, $bindings) {
    $result = $conn->prepare($upit);
 
    foreach($bindings as $label => &$value) {
      ${"$label"} = $value; 
      $result->bindParam(":$label", $$label);
    }
    try {
      $result->execute();
    } catch (PDOException $e) {
      var_dump($e->getMessage());
      return null;
    }
    return $result;
  }

  /**
   * @param $conn
   * @param $upit
   * @param $bindings
   * @return mixed
   * @throws PDOException
   */
  function bindWithException($conn, $upit, $bindings) {
    $result = $conn->prepare($upit);

    foreach($bindings as $label => &$value) {
      ${"$label"} = $value;
      $result->bindParam(":$label", $$label);
    }
    $result->execute();
    return $result;
  }

  /**
   * @throws Exception
   */
  function bindAndSelect($conn, $upit, $bindings, $fetchOne) {
    $result = bind($conn, $upit, $bindings);
    $selected = null;

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

  function uploadPicture($picture, $lastInsertId, $conn, Callable $callback, $target) {
    $tmpPath = $picture['tmp_name'];
    $picName = strstr($picture['name'], "." , true);
    $targetPath = relativeToProjectOS("/public/images/comics/") . time() . "_" . $picture['name'];
    $targetDB = "images/comics/" . time() . "_" . $picture['name'];
    try {
      resize_image($tmpPath, $target, $callback);
      move_uploaded_file($tmpPath, $targetPath);
      $upit = "INSERT INTO pictures(path, alt, id_comic) VALUES (:putanja, :alt, :idComic)";
      /*if($target == 355) {
        $primary = 1;
      } else if($target == 500) {
        $primary = 2;
      }*/
      $uploaded = bind($conn, $upit, [
        "putanja" => $targetDB,
        "alt" => $picName,
        "idComic" => $lastInsertId
      ]);
      return $uploaded;
    } catch(Exception $e) {
      echo "Slika nije u dobrom formatu";
    }
  }

  function validatePicture($picture, &$errors, $value) {
    $type = $picture['type'];
    $size = $picture['size'];

    $formats = ['image/jpg', 'image/jpeg'];
    if(!in_array($type, $formats)) {
      $errors[$value]['type'] = "Picture must be jpg / jpeg";
    }

    if($size > 2000000) {
      $errors[$value]['size'] = "You need to upload a picture lighter than 2MB";
    }
  }

  function resize_image_by_width($ratio, $targetWidth) {
    if($ratio > 1) {
      $targetHeight = $targetWidth / $ratio;
    } else {
      throw new Exception("Wrong image form suplied");
      return;
    }

    return [$targetWidth, $targetHeight];
  }

  function resize_image_by_height($ratio, $targetHeight) {
    if($ratio < 1) {
      $targetWidth = $targetHeight * $ratio;
    } else {
      throw new Exception("Wrong image format supplied");
      return;
    }

    return [$targetWidth, $targetHeight];
  }

  function resize_image($file, $target, Callable $callback) {
    list($originalWidth, $originalHeight) = getimagesize($file);
    echo "Original width: $originalWidth <br>";
    echo "Original height: $originalHeight <br>";
    $ratio = $originalWidth / $originalHeight;

    list($targetWidth, $targetHeight) = $callback($ratio, $target);

    $originalImage = imagecreatefromjpeg($file);
    $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);
    imagecopyresampled($targetImage, $originalImage,
        0, 0, 0, 0,
        $targetWidth, $targetHeight,
      $originalWidth, $originalHeight);
      imagejpeg($targetImage, $file, 100);
  }
