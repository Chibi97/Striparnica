<?php
  session_start();
  require "../../database.php";
  require "../php/utilities.php";

  function obrisiSliku($putanja) {
    $publicPath = relativeToProjectOS("public/$putanja");
    var_dump($publicPath);
    if(file_exists($publicPath)) {
      unlink($publicPath);
    }
  }

  $status = 404;
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = 403;
    if(true) {
      $status = 400;
      if(isset($_POST['id'])) {
        $status = 204;
        $id = $_POST['id'];
        $conn->beginTransaction();
        try {
          $upit = "SELECT path FROM pictures WHERE id_comic=:id";
          $slike = bindAndSelect($conn, $upit, ["id" => $id], false);
          $upit = "DELETE FROM pictures WHERE id_comic=:id";
          bindWithException($conn, $upit, ["id" => $id]);
          $upit = "DELETE FROM list WHERE id_comic=:id";
          bindWithException($conn, $upit, ["id" => $id]);
          $upit = "DELETE FROM comics_sub_filters WHERE id_comic=:id";
          bindWithException($conn, $upit, ["id" => $id]);
          $upit = "DELETE FROM comics WHERE id=:id";
          bindWithException($conn, $upit, ["id" => $id]);

          foreach($slike as $slika) {
            obrisiSliku($slika->path);
          }
        } catch (PDOException $e) {
          $conn->rollBack();
          echo $e->getMessage();
        } catch (Exception $e) {
          $conn->rollBack();
          echo $e->getMessage();
        }
        $conn->commit();
      }
    }
  }

  http_response_code($status);