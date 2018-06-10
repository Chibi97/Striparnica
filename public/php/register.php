<?php 
  session_start();
  require_once "../../database.php";

  if(isset($_POST['register'])) {
    $email    = $_POST['reg-email'];
    $password = $_POST['reg-password'];
    $confirm  = $_POST['reg-confirm'];
    $errors   = [];

    $passwordMessage = "A password must have at least one digit, at least one uppercase char, lowercase chars and it should be at least 8 chars long";
    $emailMessage = "Your email must be of a valid format";
    $confirmMessage = "Your passwords are not matching";


    if($password !== $confirm) {
      $errors["confirm"] = $confirmMessage;
    } else {
        $rePassword = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/';
        if(!preg_match($rePassword, $password)) {
        $errors["password"] = $passwordMessage;
      }
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors["email"] = $emailMessage;
    }

    if(empty($errors)) {
      $password = sha1($password);
      $upit = "INSERT INTO users (email, password, id_role) VALUES (:email, :pass, :id)";
      $stmt = $conn->prepare($upit);
      $stmt->bindParam(":email", $email);
      $stmt->bindParam(":pass", $password);
      $stmt->bindParam(":id", 2);
      $inserted = $stmt->execute();

      if($inserted) {
        echo "success";
      } else {
        echo "nope";
      }
    }

    header("Location: ../index.php");
    
  }

