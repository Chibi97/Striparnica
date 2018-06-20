<?php
  session_start();
  require "../../database.php";

  $status = 404;
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = 403;
    if(isset($_SESSION['user'])) {
      $status = 400;
      $idUser = isset($_SESSION['user']) ? $_SESSION['user']->id : null;

      if(isset($_POST['stripId'])) {
        $idStrip = $_POST['stripId'];
        $status = 200;

        if(!empty($idUser)) {
          $query = "DELETE FROM list WHERE id_user = :id_user AND id_comic = :id_comic";
          $stmt = $conn->prepare($query);
          $stmt->bindParam(":id_user", $idUser);
          $stmt->bindParam(":id_comic", $idStrip);
          $stmt->execute();
        }
      }
    }
  }

  http_response_code($status);

