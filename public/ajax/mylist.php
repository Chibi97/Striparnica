<?php
  session_start();
  require "../../database.php";

  $status = 404;
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = 403;
    if(isset($_SESSION['user'])) {
      $status = 400;
      $idUser = $_SESSION['user']->id;

      if(isset($_POST['stripId'])) {
        $idStrip = $_POST['stripId'];
        $status = 200;

        $query = "INSERT INTO list(id_user, id_comic) 
                  VALUES(:id_kor, :id_com)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id_kor", $idUser);
        $stmt->bindParam(":id_com", $idStrip);
        $stmt->execute();
      }
    }
  }

  http_response_code($status);
