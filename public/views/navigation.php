<header class='flex-col center'>
  <nav class='log-reg flex-row nav center'>
    <h1>
      <a class='logo' href='/index.php'>MyComicsList</a>
    </h1>
    <ul>
      <?php
        $html = "";

        if(isset($_SESSION['user'])) {
          if($_SESSION['user']->id_role == 1) {
            $html .= "
               <li><a href='index.php?page=panel' class='btn-style'>Admin panel</a></li>
            ";
          } 

          $html .= "
            <li>
              <a href='../php/logout.php' class='btn-style'>Logout</a>
            </li>
          ";
          
        } else {
          $html .= "<li>
          <a href='#' class='btn-style open-modal-login'>Login</a>
          </li> <li>
          <a href='#' class='btn-style open-modal-register'>Register</a>
          </li>";
        }

        echo $html;
      ?>
    </ul>
  </nav>

  <?php 
  $linkovi = selectMultipleRows($conn, "SELECT * FROM links"); ?>
  <nav class='navigation nav center'>
    <ul>
      <?php foreach($linkovi as $link): ?>
          <li>
            <a href='<?= $link->path ?>'><?= $link->name ?></a>
          </li>
      <?php endforeach ?>
    </ul>
  </nav>
</header>
