<?php
  session_start();
  require_once "utilities.php";

  if(isset($_POST['contact'])) {
    define("TO", "oljawildchild@gmail.com");
    $email = $_POST['contact-email'];
    $message = $_POST['contact-message'];
    $errors = [];

    $emailMess = "You must enter a valid format for email address";
    $messageMess = "Your message must have at least 10 characters";

     if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors["email"] = $emailMess;
    }

    if(strlen($message) < 10) {
      $errors["message"] = $messageMess;
    }

    if(empty($errors)) {
      $subject = "MyComicsList contact";
      $header = "From: $email";
      mail(TO, $subject, $message, $header);
    } else {
      $_SESSION['contactErrors'] = $errors;
    }
  }

  header("Location: /index.php?page=contact");