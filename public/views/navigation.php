<body>
  <header class='flex-col center'>
    <nav class='log-reg flex-row nav center'>
      <h1>
        <a class='logo' href='#'>MyComicsList</a>
      </h1>
      <ul>
        <li>
          <a href='#' class='btn-style'>Admin panel</a>
        </li>
        <li>
          <a href='#' class='btn-style'>Account</a>
        </li>
        <li>
          <?php if(!isset($_SESSION['user'])): ?>
          <a href='#' id='login' class='btn-style'>Login</a>
          <?php else: ?>
          <a href='../php/logout.php' class='btn-style'>Logout</a>
          <?php endif; ?>
        </li>
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
