<?php
  function error_for($key) {
    if(isset($_SESSION['greske'][$key])) {
      return $_SESSION['greske'][$key];
    }
    return "";
  }

   function selectMultipleRows($conn, $upit) {
      $result = $conn->query($upit);
      return $result->fetchAll();
  }