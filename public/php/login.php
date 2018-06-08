<?php
  session_start();

  // DODAJ VALIDACIJE OVDE MRZI ME
  // ja cu samo da ti pokazem ako ima greske.


  $_SESSION['greske'] = [
    "email nije u dobrom formatu",
    "lozinka nije u dobrom formatu"
  ];

  header("Location: index.php");