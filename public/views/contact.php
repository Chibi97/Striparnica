<div class='flex-row center add-comic'>
  <form action='php/contact.php' name='contact' method='POST'>
    <h1>Contact us</h1>
    <div class='input-group'>
      <label>Your email address</label>
      <input type='text' name='contact-email' />
    </div>
    <span class='form-error errContactEmail'><?= error_for("email", "contactErrors"); ?></span> 
    
    <div class='input-group'>
      <label>Your message...</label>
      <textarea name='contact-message'  id='contact-message'></textarea>
    </div>
    <span class='form-error errContactMsg'><?= error_for("message", "contactErrors"); ?></span>
    <?php unset($_SESSION['contactErrors']); ?>
    <button class='change-btn' name='contact'>Contact us</button>
    <span class='form-error '><?php error_for("success", "contactSuccess"); ?></span>
    <?php unset($_SESSION['contactSuccess']); ?>
  </form>
</div>