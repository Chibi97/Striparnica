<?php
  session_start();
  require "../../database.php";
  require "../php/utilities.php";

  $status = 404;
  header('Content-Type: application/json');
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = 403;
    if(isset($_SESSION['user'])) {
      $status = 400;
      $idUser = isset($_SESSION['user']) ? $_SESSION['user']->id : null;

      if(isset($_POST['votedFor'])) {
        $votedFor = $_POST['votedFor'];
        if($votedFor > 0) {
          $status = 200;
          if(!empty($idUser)) {
            $query = "INSERT INTO votes(id_user, id_comic) 
                      VALUES(:id_user, :id_comic)";
            try {
              bindWithException($conn, $query, [
                "id_user" => $idUser,
                "id_comic" => $votedFor
              ]);
              $upit = "SELECT c.name,p.path, p.alt, COUNT(*) AS votes FROM votes v JOIN comics c ON v.id_comic = c.id JOIN pictures p ON c.id = p.id_comic GROUP BY c.name, p.path, p.alt ORDER BY votes DESC LIMIT 0,3";
              $results = selectMultipleRows($conn, $upit);
              echo json_encode($results);
            } catch(PDOException $e) {
              echo json_encode(["poruka" => "You already voted."]);
            }    
          }
        }
      }
    }
  }

  http_response_code($status);

