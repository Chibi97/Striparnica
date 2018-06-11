
<form action='#' method='POST' enctype='multipart/form-data' id='dodajStrip'>
  <h1>Add a new comic</h1>
  <div class='input-group'>
    <label>Name of the comic</label>
    <input type='text' name='comicName' />
  </div>

  <div class='input-group'>
    <label>Description</label>
    <textarea></textarea>
  </div>

  <div class='input-group'>
    <label>Number of issues (volumes)</label>
    <input type='text' name='issues' />
  </div>

  <div class='input-group'>
    <label>Choose subfilters</label>
    <select>
      <?php 
        $upit = "SELECT * FROM sub_filters";
        $filters = selectMultipleRows($conn, $upit);
        foreach($filters as $filter): ?>
        <option value="<?= $filter->name ?>"><?= $filter->name ?></option>
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

  <button>Insert</button>
</form>
