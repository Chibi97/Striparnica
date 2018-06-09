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
        <div class='card__face card__face--front flex-col center'>
          <h1>Login</h1>
          <span class='modal-exit'>&times;</span>
          <form action='php/login.php' method='POST'>
            <div class='relative'>
              <input type='text' name='email' placeholder='Email' />
              <span class='fas fa-at fa-span absolute'></span>
            </div>
            <p class='form-error'><?= error_for("email"); ?></p>

            <div class='relative'>
              <input type='password' name='password' placeholder='Password' />
              <span class='fas fa-key fa-span absolute'></span>
            </div>
            <p class='form-error'><?= error_for("password"); ?></p>

            <button id='login' name='login' class='btn-style'>Login</button>
            <button id='register-btn' class='btn-style'>Register</button>
          </form>
        </div>

        <div class='card__face card__face--back flex-col center'>
          <h1>Register</h1>
          <span class='modal-exit'>&times;</span>
          <form action='php/register.php' method='POST'>
            <div class='relative'>
              <input type='text' name='reg-email' placeholder='Email' />
              <span class='fas fa-at fa-span absolute'></span>
            </div>
            <p class='form-error'></p>

            <div class='relative'>
              <input type='password' name='reg-password' placeholder='Password' />
              <span class='fas fa-key fa-span absolute'></span>
            </div>
            <p class='form-error'></p>

            <button id='login-btn' name='login' class='btn-style'>Login</button>
            <button id='register-btn' class='btn-style'>Register</button>
          </form>
        </div>
        
      </div>
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
  