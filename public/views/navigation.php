<header class='flex-col center'>
  <nav class='log-reg flex-row nav center'>
    <h1>
      <a class='logo' href='#'>MyComicsList</a>
    </h1>
    <ul>
      <?php if(isset($_SESSION['user'])): ?>
        <li><a href='#' class='btn-style'>Account</a></li>
        <li>
          <a href='#' id='login' class='btn-style'>Login</a>
      <?php elseif($_SESSION['user']->id_role == 1): ?>
        <li><a href='#' class='btn-style'>Admin panel</a></li>
      <?php else: ?>
        <a href='../php/logout.php' class='btn-style'>Logout</a>
        </li>
      <?php endif; ?>
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
