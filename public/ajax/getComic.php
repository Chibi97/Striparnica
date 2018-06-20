<?php
  session_start();

  require "../../database.php";
  require "../php/utilities.php";

  $status = 404;
  if($_SERVER['REQUEST_METHOD'] == "POST") {
    $status = 403;
    if($_SESSION['user']->role === 'administrator')
      $status = 400;
      if(isset($_POST['id'])) {
        $id = $_POST['id'];
        try {
          $status = 500;
          $comic  = bindAndSelect($conn, "select c.*, p.path from comics c join pictures p on c.id = p.id_comic where c.id=:id", ["id" => $id], true);
          $filters = bindAndSelect($conn,
            "select * from sub_filters join comics_sub_filters csf 
                 on sub_filters.id = csf.id_sub_filter where csf.id_comic=:id", ["id" => $comic->id], false);
          if($comic) {
            $status = 200;
            if(!$filters) $filters = [];
            echo json_encode([
              "comic" => $comic,
              "filters" => $filters
            ]);
          }
        } catch(Exception $e) {
          $status = 500;
        }
      }
  }

  http_response_code($status);

