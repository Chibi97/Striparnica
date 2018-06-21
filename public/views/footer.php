  <footer>
    <div class="footer-picture flex-row center">
      <ul class="links">
        <?php 
          $linkovi = selectMultipleRows($conn, "SELECT * FROM links");
          $trenutna = isset($_GET['page']) ? 'index.php?page=' . $_GET['page'] : "index.php";

          foreach($linkovi as $link) {
            if($trenutna != $link->path) {   
              echo "<li><a href='$link->path'>$link->name</a></li>";  
            } 
          }
          echo "<li><a href='https://github.com/Chibi97/Striparnica'>Dokumentacija</a></li>";
        ?>
      </ul>

      <div class="disclaimer">
        <p>Design by ©
        <strong>Olja Ivkovic</strong></p>
        <p>This site is a project for <strong>ICT College</strong>, made for educational purposes. I don't intend to profit nor gain any rights. All
        rights go to their rightful owners.</p>
        
        <a href="https://github.com/" class="fab fa-github"></a>
        <a href="https://www.instagram.com/?hl=sr" class="fab fa-instagram"></a>
        <a href="https://www.facebook.com/" class="fab fa-facebook"></a>
      </div>
    </div>
    
    <!-- LOGIN MODAL  -->
    <div class='modal'>
      <div class='card'>
        <div class='card__face card__face--front flex-col center'>
          <h1>Login</h1>
          <span class='modal-exit'>&times;</span>
          <form action='php/login.php' name='login-forma' method='POST'>
            <div class='relative'>
              <input type='text' name='email' placeholder='Email' />
              <span class='fas fa-at fa-span fs-login absolute'></span>
            </div>
            <p class='form-error errEmail'><?= error_for("email", "greske"); ?></p>

            <div class='relative'>
              <input type='password' name='password' placeholder='Password' />
              <span class='fas fa-key fa-span fs-login absolute'></span>
            </div>
            <p class='form-error errPass'><?= error_for("password", "greske"); ?></p>

            <button id='login' name='login' class='btn-style'>Login</button>
            <button id='register-btn' class='btn-style'>Register</button>
          </form>
        </div>

        <!-- REGISTER MODAL  -->
        <div class='card__face card__face--back flex-col center'>
          <h1>Register</h1>
          <span class='modal-exit'>&times;</span>
          <form action='php/register.php' name='reg-forma'  method='POST' >
            <div class='relative'>
              <input type='text' name='reg-email' placeholder='Email' />
              <span class='fas fa-at fa-span fs-reg absolute'></span>
            </div>
            <p class='form-error errEmail'><?= error_for("reg_email", "greske");?></p>

            <div class='relative'>
              <input type='password' name='reg-password' placeholder='Password' />
              <span class='fas fa-key fa-span fs-reg absolute'></span>
            </div>
            <p class='form-error errPass'><?= error_for("reg_password", "greske");?></p>

            <div class='relative'>
              <input type='password' name='reg-confirm' placeholder='Confirm password' />
              <span class='fas fa-unlock fa-span fs-reg absolute'></span>
            </div>
            <p class='form-error errConfirm'><?= error_for("reg_confirm", "greske");?></p>

            <button id='login-btn' name='login' class='btn-style'>Login</button>
            <button id='register' class='btn-style' name='register'>Register</button>
          </form>
        </div>
        
      </div>
    </div>
  </footer>

  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src="scripts/jquery.selectBox.min.js" type="text/javascript"></script>
  <script>
    <?php if(isset($_SESSION['greske'])): ?>
      window.modalOpen = true;
      $(".fs-login").css("color", "crimson");
      <?php if(isset($_SESSION['greske']['turn_modal'])): ?>
        $(".fs-reg").css("color", "crimson");
        $(".fs-login").css("color", "#333");
        window.turnModal = true;
      <?php endif ?>
    <?php unset($_SESSION['greske']); ?>
    <?php else: ?>
      window.modalOpen = false;
    <?php endif ?>

    $('#vote').selectBox({
    mobile: true,
    menuSpeed: 'fast'
   });

   $('#izbor-stripa').selectBox({
      mobile: true,
      menuSpeed: 'fast'
     });
  </script>
  <script src='scripts/utils.js'></script>
  <script src='scripts/fastselect.min.js'></script>
  <script src='scripts/jquery.knob.min.js'></script>
  <script src='scripts/validations.js'></script>
  <script src='scripts/modal.js'></script>
  <script src='scripts/mainslider.js'></script>
  <script src='scripts/comics.js'></script>
  