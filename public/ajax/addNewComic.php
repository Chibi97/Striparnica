<?php
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

     $reName = '/^[A-Z][a-z]{2,48}(\s([A-Z][a-z]{1,48}|[0-9]{1,4}))*$/';

     if(!preg_match($reName, $name)) {
       $errors[] = $nameError;
     }

     if(strlen($desc) < 10) {
       $errors[] = $descError;
     }

     if($issues < 1) {
       $errors[] = $issuesError;
     }

     if(empty($tags)) {
       $errors[] = $tagsError;
     }

     // picture validation

     if(empty($errors)) {
       // upis u bazu
       


       /*if($inserted) {

       } else {
         $_SESSION['greske'] = $errors;
       } */
     } else {
       $_SESSION['greske'] = $errors;
     }
     
  }
  