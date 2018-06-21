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

  <div class='vote'>
    <h1>Vote for your favorite comic</h1>
    <select id='vote' name='vote'>
      <?php
        $upit = "SELECT id,name FROM comics";
        $comics = selectMultipleRows($conn, $upit);
        foreach($comics as $comic):
      ?>
        <option value='<?= $comic->id ?>'><?= $comic->name ?></option>
      <?php endforeach ?>
    </select>
  </div>
</div>