<?php 
  session_start();
  require_once "php/utilities.php";
  require_once "../database.php";
?>
<!DOCTYPE html>
<html>
  <?php 
    include_once "views/head.php";
  ?>
  <body>
    <?php 
      include_once "views/navigation.php";
      include_once "views/main.php";
      include_once "views/footer.php";
      ?>
  </body>
</html>