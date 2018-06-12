<?php
   session_start();
   include "../php/utilities.php";
   include "../../database.php";

   if(isset($_POST['insert'])) {
     $name   = trim($_POST['comicName']);
     $desc   = trim($_POST['desc']);
     $issues = (int)$_POST['issues'];
     $tags   = isset($_POST['tags']) ? $_POST['tags'] : null;
     // uploaded pic 1 & 2
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

     if($issues < 1) {
       $errors['issues'] = $issuesError;
     }

     if(empty($tags)) {
       $errors['tags'] = $tagsError;
     }

     // picture validation

     if(empty($errors)) {
       // upis u bazu
       $conn->
       // INSERT INTO comics (name, description, issues) VALUES (n, d, i);
       // INSERT INTO comics_sub_filters

       /*if($inserted) {

       } else {
         $_SESSION['greske'] = $errors;
       } */
     } else {
       $_SESSION['comicErrors'] = $errors;
     }
    header("Location: ../index.php?page=panel");
  }
  