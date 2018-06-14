<?php
  session_start();
  include "../php/utilities.php";
  include "../../database.php";

  if(isset($_POST['insert'])) {
    $name    = trim($_POST['comicName']);
    $desc    = trim($_POST['desc']);
    $issues  = $_POST['issues'];
    $tags    = isset($_POST['tags']) ? $_POST['tags'] : null;
    $picPor  = $_FILES['comic-por-pic'];
    $picLand = $_FILES['comic-land-pic'];
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

    if($issues < 1 || $issues > 2000) {
      $errors['issues'] = $issuesError;
    }

    if(empty($tags)) {
      $errors['tags'] = $tagsError;
    }

    // picture validation
    validatePicture($picPor, $errors, "comic-por-pic");
    validatePicture($picLand, $errors, "comic-land-pic");

    if(empty($errors)) {
      // upis u bazu
      if(uploadPicture($picPor)) {
        echo "Fajl je prebacen na server";
      }

      if(uploadPicture($picLand)) {
        echo "Fajl je prebacen na server";
      }
      
    } else {
      $_SESSION['comicErrors'] = $errors;
    }
    header("Location: ../index.php?page=panel");
  } else {
    header("Location: ../index.php");
  }
  