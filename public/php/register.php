<?php
  session_start();
  require_once "../../database.php";
  require "utilities.php";

  if(isset($_POST['register'])) {
    $email    = $_POST['reg-email'];
    $password = $_POST['reg-password'];
    $confirm  = $_POST['reg-confirm'];
    $errors   = [];

    $passwordMessage = "A password must have at least one digit, at least one uppercase char, lowercase chars, at least one special char and it should be at least 8 chars long";
    $emailMessage = "Your email must be of a valid format";
    $confirmMessage = "Your passwords are not matching";
    $uniqueMessage = "This email is taken";

    if($password !== $confirm) {
      $errors["reg_confirm"] = $confirmMessage;
    } else {
        $rePassword = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+=-|?><,.`~:{}[\]~`;\'\"])[A-Za-z\d!@#$%^&*()_+=-|?><,.`~:{}[\]~`;\'\"]{8,}$/';
        if(!preg_match($rePassword, $password)) {
        $errors["reg_password"] = $passwordMessage;
      }
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors["reg_email"] = $emailMessage;
    }

    if(empty($errors)) {
      $password = sha1($password);
      $upit = "INSERT INTO users (email, password, id_role) VALUES (:email, :pass, 2)";
      $inserted = bind($conn, $upit, [
        "email" => $email,
        "pass" => $password
      ]);
      
      $id = $conn->lastInsertId();

      $user = (object)[
        "id" => $id,
        "email" => $email,
        "password" => $password,
        "id_role" => 2
      ];

      if($inserted) {
        $_SESSION['user'] = $user;
      } else {
        $errors['reg_email'] = $uniqueMessage;
        $errors["turn_modal"] = true;
        $_SESSION['greske'] = $errors;
      }
    } else {
      $errors["turn_modal"] = true;
      $_SESSION['greske'] = $errors;
    }
  }

  header("Location: ../index.php");
