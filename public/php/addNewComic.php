<?php
  session_start();
  include "../php/utilities.php";
  include "../../database.php";

  function updateRecord($conn, $comicId, $name, $desc, $issues, $tags) {
    $upit = "UPDATE comics SET name=:name, description=:desc, issues=:issues WHERE id=:id";
    bind($conn, $upit, [
      "name" => $name,
      "desc" => $desc,
      "issues" => $issues,
      "id" => $comicId
    ]);
    $oldState = bindAndSelect($conn,
      "SELECT id_sub_filter as id FROM comics_sub_filters WHERE id_comic=:id", ["id" => $comicId], false);
    $oldStateIds = array_map(function($e) {
      return $e->id;
    }, $oldState);
    $toDelete = [];
    $toInsert = [];

    foreach($oldStateIds as $id) {
      if(!in_array($id, $tags)) $toDelete[] = $id;
    }

    foreach($tags as $newId) {
      if(!in_array($newId, $oldStateIds)) $toInsert[] = $newId;
    }

    foreach($toDelete as $idSub) {
      $query = "DELETE FROM comics_sub_filters WHERE id_comic=:comic AND id_sub_filter=:sub";
      bind($conn, $query, ["comic" => $comicId, "sub" => $idSub]);
    }

    foreach($toInsert as $idSub) {
      $query = "INSERT INTO comics_sub_filters(id_comic,id_sub_filter) VALUES (:idComic, :subFilter)";
      bind($conn, $query, ["idComic" => $comicId, "subFilter" => $idSub]);
    }
  }

  function insertRecord($conn, $name, $desc, $issues, $picPor, $tags) {
    $upit = "INSERT INTO comics(name, description, issues) VALUES (:name, :desc, :issues)";
    $inserted = bind($conn, $upit, [
      "name" => $name,
      "desc" => $desc,
      "issues" => $issues
    ]);

    if($inserted) {
      $idComic = $conn->lastInsertId();
      if(uploadPicture($picPor, $idComic, $conn, 'resize_image_by_height', 355)) {
        $upit = "INSERT INTO comics_sub_filters(id_comic,id_sub_filter) VALUES (:idComic, :subFilter)";
        foreach($tags as $tag) {
          bind($conn, $upit, [
            "idComic" => $idComic,
            "subFilter" => $tag
          ]);
        }
        $_SESSION['upload'] = "Successfully inserted comic!";
      } else $_SESSION['upload'] = "Error, not inserted";
    }
  }


  if(isset($_POST['insert'])) {
    $name    = trim($_POST['comicName']);
    $desc    = trim($_POST['desc']);
    $issues  = $_POST['issues'];
    $tags    = isset($_POST['tags']) ? $_POST['tags'] : [];
    $picPor  = $_FILES['comic-por-pic'];
    $method = $_POST['_method'];
    $errors = [];

    $nameError = "Every first letter of a word must be a capital letter";
    $descError = "You need to write more than 10 characters";
    $issuesError = "Number of issues cannot be zero or less";
    $tagsError = "You must choose at least one subfilter";

    $reName = '/^[A-Z][a-z]{2,48}(\s([A-Z][a-z]{1,48}|[0-9]{1,4}(\.)*))*$/';

    if(!preg_match($reName, $name)) {
      $errors['comicName'] = $nameError;
    }

    if(strlen($desc) < 10) {
      $errors['description'] = $descError;
    }

    if($issues < 1 || $issues > 1000) {
      $errors['issues'] = $issuesError;
    }

    if(empty($tags)) {
      $errors['tags'] = $tagsError;
    }

    if($method == "POST") {
      validatePicture($picPor, $errors, "comic-por-pic");
    }

    if(empty($errors)) {
      if($method == "UPDATE") {
        $id = $_POST['comicID'];
        updateRecord($conn, $id, $name, $desc, $issues, $tags);
      } else {
        insertRecord($conn, $name, $desc, $issues, $picPor, $tags);
      }
    } else {
      $_SESSION['comicErrors'] = $errors;
    }
    header("Location: ../index.php?page=panel");
  } else {
    header("Location: ../index.php");
  }
  