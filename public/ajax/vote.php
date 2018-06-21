<?php
  require "../../database.php";
  require "../php/utilities.php";

  $status = 404;
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = 400;
    if(isset($_POST['votedFor'])) {
      $votedFor = $_POST['votedFor'];
      $status = 200;
      $query = "UPDATE comics SET votes = votes + 1 WHERE id = :id";
      $stmt = $conn->prepare($query);
      $success = bind($conn,$query, [
        "id" => $votedFor
      ]);
      if($success) {
        echo json_encode(["message"=> "uspeh"]);
      } else {
        echo json_encode(["message"=> "nije uspelo"]);
      }
    } 
  }
  http_response_code($status);

