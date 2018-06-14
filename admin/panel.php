<div class='flex-row center add-comic'>
  <form action='../ajax/addNewComic.php' method='POST' enctype='multipart/form-data'>
    <h1>Add a new comic</h1>
    <div class='input-group'>
      <label>Name of the comic</label>
      <input type='text' name='comicName' id='comicName' />
    </div>
    <span class='form-error'><?= error_for("comicName", "comicErrors"); ?></span>

    <div class='input-group'>
      <label>Description</label>
      <textarea name='desc' id='desc'></textarea>
    </div>
    <span class='form-error'><?= error_for("description", "comicErrors"); ?></span>

    <div class='input-group'>
      <label>Number of issues (chapters)</label>
      <input type="text" name='issues' value="1" data-min="1" data-max="1000" class="dial" data-fgColor="#666A86">
    </div>
    <span class='form-error'><?= error_for("issues", "comicErrors"); ?></span>

    <div class='input-group'>
      <label>Choose subfilters</label>
      <select class='multipleSelect' multiple name='tags[]'>
        <?php 
          $upit = "SELECT * FROM sub_filters";
          $filters = selectMultipleRows($conn, $upit);
          foreach($filters as $filter): ?>
          <option value="<?= $filter->id ?>"><?= $filter->name ?></option>
          <?php endforeach ?>
      </select>
    </div>
    <span class='form-error'><?= error_for("tags", "comicErrors"); ?></span>

    <div class='input-group'>
      <label>Upload 2 pictures</label>
      
      <input type='file' name='comic-por-pic'>
      <p>Please upload a picture that is portrait oriented</p>
      <?php
       $subIndexes = ['type', 'size']; 
       foreach($subIndexes as $subIndex):
       ?>
        <p class='form-error'><?= multi_error_for("comic-por-pic", "comicErrors", $subIndex); ?></p>
       <?php endforeach ?>

      <input type='file' name='comic-land-pic'>
      <p>Please upload a picture that is landscape oriented</p>
      <?php
      foreach($subIndexes as $subIndex):
       ?>
        <p class='form-error'><?= multi_error_for("comic-land-pic", "comicErrors", $subIndex); ?></p>
       <?php endforeach ?>
    </div>

    <?php unset($_SESSION['comicErrors']); ?>
    <button id='insertComic' name='insert'>Insert</button>
  </form>
</div>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    $(".multipleSelect").fastselect()
  });
</script>
