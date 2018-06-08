  <footer>
    <div class="footer-picture flex-row center">
      <ul class="links">
        <li><a href="#">Browse</a></li>
        <li><a href="#">My List</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="#">Documentation</a></li>
      </ul>

      <div class="disclaimer">
        <p>Design by ©
        <strong>Olja Ivkovic</strong>
        <br/>This site is a project for <strong>ICT College</strong>, made for educational purposes. I don't intend to profit nor gain any rights. All
        rights go to their rightful owners.</p>
        
        <a href="#" class="fab fa-github"></a>
        <a href="#" class="fab fa-instagram"></a>
        <a href="#" class="fab fa-facebook"></a>
      </div>
    </div>
    
    <!-- MODAL  -->
    <div class='modal'>
      <h1>Login Modal</h1>
      <span>&times;</span>
      <?php if(isset($_SESSION['greske'])): ?>
      <ul>
        <?php foreach($_SESSION['greske'] as $greska): ?>
        <li><?= $greska; ?></li>
        <?php endforeach ?>
      </ul>
      <?php endif ?>
      <form action='php/login.php' method='POST'>
        <input type='text' name='email' placeholder="Email" />
        <input type='password' name='password' placeholder="Password" />
        <button name='login'>
          Login
        </button>
      </form>
    </div>
  </footer>

  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script>
    <?php if(isset($_SESSION['greske'])): ?>
      window.modalOpen = true;
      <?php unset($_SESSION['greske']); ?>
    <?php else: ?>
      window.modalOpen = false;
    <?php endif ?>
  </script>
  <script src='scripts/modal.js'></script>
</body>
</html>