<?php
  session_start();
  require "../../database.php";
  require "../php/utilities.php";

  $status = 404;
  if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $status = 403;
    if(isset($_SESSION['user'])) {
      $status = 400;
      $idUser = isset($_SESSION['user']) ? $_SESSION['user']->id : null;
      $toDelete = "SELECT id_comic FROM votes WHERE id_user = $idUser";
      
      $status = 200;
      if(!empty($idUser)) {
        $query = "DELETE FROM votes WHERE id_user = :id_user AND id_comic = :id_comic";
        try {
          bindWithException($conn, $query, [
            "id_user" => $idUser,
            "id_comic" => $removeVoteFor
          ]);
          $upit = "SELECT c.name,p.path, p.alt, COUNT(*) AS votes FROM votes v JOIN comics c ON v.id_comic = c.id JOIN pictures p ON c.id = p.id_comic GROUP BY c.name, p.path, p.alt ORDER BY votes DESC LIMIT 0,3";
          $results = selectMultipleRows($conn, $upit);
          echo json_encode($results);
        } catch(PDOException $e) {
          $status = 500;
          echo json_encode(["poruka" => "Something went wrong"]);
        } 
      }
    }
  }


  http_response_code($status);

