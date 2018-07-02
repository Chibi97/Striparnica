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
          if(isset($_SESSION['user']) && $_SESSION['user']->role == "administrator") {
            include_once "../admin/panel.php";
          } else {
            include "views/main.php";
          }
          break;
        case 'stats':
          if(isset($_SESSION['user']) && $_SESSION['user']->role == "administrator") {
            include_once "../admin/stats.php";
          } else {
            include "views/main.php";
          }
          break;
        case 'list_category':
          if(isset($_SESSION['user']) && $_SESSION['user']->role == "administrator") {
            include_once "../admin/list_category.php";
          } else {
            include "views/main.php";
          }
          break;
        case 'edit_category':
          if(isset($_SESSION['user']) && $_SESSION['user']->role == "administrator") {
            include_once "../admin/edit_category.php";
          } else {
            include "views/main.php";
          }
          break;
        case 'my_list':
          include "views/my_list.php";
          break;
        case 'about':
          include "views/about.php";
          break;
        case 'contact':
          include "views/contact.php";
          break;
        default:
          include "views/main.php";
          break;
      }
      include_once "views/footer.php";
      ?>
  </body>
</html>