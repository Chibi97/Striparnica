<?php
  function error_for($key) {
    if(isset($_SESSION['greske'][$key])) {
      return $_SESSION['greske'][$key];
    }
    return "";
  }