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
    <!-- Modal se najcesce stavljau footeru -->
    <div class='modal'>
      <h1>Login Modal</h1>
      <span>&times;</span>
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
    // OVO ce nam trebati i za php zbog toga je globalna
    // NE PREBACUJES U .js fajl
    window.modalOpen = false;



    // ovo ispod posle odvoji u .js fajl
    $(document).ready(function() {
      initModal();

      $("#login").click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        openModal();
      });
    });

    function initModal() {
      $(".modal").find("span").click(function() {
          if(window.modalOpen) {
            closeModal();
          }
        });

      $("body").click(function() {
          if(window.modalOpen) {
            closeModal();
          }
        });
    }

    function closeModal() {
      window.modalOpen = false;
      $(".modal").removeClass("show");
      $("#crnilo").remove();
    }

    function openModal() {
      window.modalOpen = true;
        var crnilo = $("<div id='crnilo'>");
        crnilo.css({
          display: "block",
          position: "fixed",
          width: "100%",
          height: "100%",
          background: "rgba(0, 0, 0, 0.6)", 
          zIndex: 999
        });
        
        
        $(".modal").addClass("show");
        $("body").prepend(crnilo);
    }
  </script>
</body>
</html>