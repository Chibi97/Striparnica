<?php
  require "../../database.php";
  require "../php/utilities.php";

  session_start();

  $stats = 403;
  if(isset($_SESSION['user']) && $_SESSION['user']->role == 'administrator') {
    $status = 200;
    $upit = "select c.name, count(*) as vote_num, (select count(*) from comics_sub_filters csf 
             where csf.id_comic=c.id) as favorite_count from votes v
             join comics c on v.id_comic=c.id
             group by c.name
             limit 5";
    $result = selectMultipleRows($conn, $upit);
    echo json_encode($result);
  }


  http_response_code($status);