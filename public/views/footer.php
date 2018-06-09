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
      <div class='card'>
        <div class='card__face card__face--front'>
          <h1>Login Modal</h1>
          <span id="modal-exit">&times;</span>
          <form action='php/login.php' method='POST'>
            <input type='text' name='email' placeholder="Email" />
            <span class='form-error'><?= error_for("email"); ?></span>
            <input type='password' name='password' placeholder="Password" />
            <span class='form-error'><?= error_for("password"); ?></span>
            <button id='login' name='login'>
              Login
            </button>
            <button id='register-btn'>Register</button>
          </form>
        </div>
        <div class='card__face card__face--back'>
          <h1>Register<h1>
          <button id='login-btn'>Login</button>
        </div>
      </div>
      <!--
      
  -->
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
  <script src='scripts/mainslider.js'></script>
  <script src='scripts/filters.js'></script>
  