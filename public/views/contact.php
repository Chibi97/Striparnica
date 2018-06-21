<div class='flex-row center add-comic'>
  <form action='#' method='POST'>
    <h1>Contact us</h1>
    <div class='input-group'>
      <label>Your email address</label>
      <input type='text' name='comicName' id='comicName' />
    </div>
    <span class='form-error'><?= error_for("comicName", "comicErrors"); ?></span>

    <div class='input-group'>
      <label>Your message...</label>
      <textarea name='desc' id='desc'></textarea>
    </div>
    <span class='form-error'><?= error_for("description", "comicErrors"); ?></span>

    <button class='change-btn' name='contact'>Contact us</button>
  </form>


</div>