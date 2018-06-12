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
      $page = null;
      if(isset($_GET['page'])) {
        $page = $_GET['page'];
      }

      include_once "views/navigation.php";
      switch($page) {
        case 'browse':
          include_once "views/browse.php";
          break;
        case 'panel':
          if(isset($_SESSION['user'])) {
            if($_SESSION['user']->id_role == 1) {
              include_once "../admin/panel.php";
            } else {
              include "views/main.php";
            }
          } else {
              include "views/main.php";
            }
          break;
        default:
          include "views/main.php";
          break;
      }
      include_once "views/footer.php";
      ?>
  </body>
</html>