<div class='flex-row center add-comic'>
  <form action='/ajax/addNewComic.php' method='POST' enctype='multipart/form-data'>
    <h1>Add a new comic</h1>
    <div class='input-group'>
      <label>Name of the comic</label>
      <input type='text' name='comicName' />
    </div>

    <div class='input-group'>
      <label>Description</label>
      <textarea name='desc'></textarea>
    </div>

    <div class='input-group'>
      <label>Number of issues (volumes)</label>
      <input type='number' min="1" max="2000" name='issues' />
    </div>

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

    <div class='input-group'>
      <label>Upload 2 pictures</label>
      <p>Please upload picture that is 250 x 350</p>
      <input type='file' name='comic-big-pic'>
      <p>Please upload picture that is 500 x 300</p>
      <input type='file' name='comic-small-pic'>
    </div>

    <button id='insertComic' name='insert'>Insert</button>
  </form>
</div>
<script>
window.addEventListener('DOMContentLoaded', () => {
  $(".multipleSelect").fastselect()
})
</script>
