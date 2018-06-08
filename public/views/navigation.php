<header class='flex-col center'>
  <nav class='log-reg flex-row nav center'>
    <h1>
      <a class='logo' href='#'>MyComicsList</a>
    </h1>
    <ul>
      <?php
        $html = "";

        if(isset($_SESSION['user'])) {
          if($_SESSION['user']->id_role == 1) {
            $html .= "
               <li><a href='#' class='btn-style'>Admin panel</a></li>
            ";
          } 

          $html .= "
            <li><a href='#' class='btn-style'>Account</a></li>
            <li>
              <a href='../php/logout.php' class='btn-style'>Logout</a>
            </li>
          ";
          
        } else {
          $html .= "<li>
          <a href='#' class='btn-style login'>Login</a>
          </li>";
        }

        echo $html;
      ?>
    </ul>
  </nav>

  <nav class='navigation nav center'>
    <ul>
      <li>
        <a href='#'>Home</a>
      </li>
      <li>
        <a href='#'>Browse</a>
      </li>
      <li>
        <a href='#'>My List</a>
      </li>
      <li>
        <a href='#'>About</a>
      </li>
      <li>
        <a href='#'>Contact</a>
      </li>
    </ul>
  </nav>
</header>
