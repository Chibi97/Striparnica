<?php
  session_start();
  require "../../database.php";
  require "../php/utilities.php";

  $status = 404;
  header('Content-Type: application/json');
  if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $status = 403;
    if(isset($_SESSION['user'])) {
      $status = 400;
      $idUser = isset($_SESSION['user']) ? $_SESSION['user']->id : null;
      
      $status = 200;
      if(!empty($idUser)) {
        try {
          $query  = "DELETE FROM votes WHERE id_user = $idUser";
          $conn->query($query);

          $upit = "SELECT c.name,p.path, p.alt, COUNT(*) AS votes FROM votes v JOIN comics c ON v.id_comic = c.id JOIN pictures p ON c.id = p.id_comic GROUP BY c.name, p.path, p.alt ORDER BY votes DESC LIMIT 0,3";
          $results = selectMultipleRows($conn, $upit);
          echo json_encode($results);
        } catch(PDOException $e) {
          echo json_encode(["poruka" => "Something went wrong"]);
        } 
      }
    }
  }

  http_response_code($status);

