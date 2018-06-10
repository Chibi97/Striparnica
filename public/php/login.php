<?php
  session_start();
  require_once "../../database.php";
  require_once "utilities.php";

  if(isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $errors   = [];

    $passwordMessage = "A password must have at least one digit, at least one uppercase char, lowercase chars and it should be at least 8 chars long";
    $emailMessage    = "You must enter a valid format for email address";
    $rePassword = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/';
    if(!preg_match($rePassword, $password)) {
      $errors["password"] = $passwordMessage;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors["email"] = $emailMessage;
    }
    
    if(empty($errors)) {
      $password = sha1($password);
      $upit = "SELECT u.* FROM users u INNER JOIN roles r ON u.id_role = r.id
      WHERE email = :email AND password = :pass;";
      
      $selectedUser = bindAndSelect($conn, $upit, [
        "email" => $email,
        "pass" => $password
      ], true);

      if($selectedUser) {
        $_SESSION['user'] = $selectedUser;
      } else {
        $_SESSION['greske'] = ['email' => 'Email or password are not valid'];
      }
    } else {
      $_SESSION['greske'] = $errors;
    }
  }
  
  header("Location: ../index.php");

