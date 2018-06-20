<div class='flex-row center add-comic'>
  <form action='/php/addNewComic.php' method='POST' enctype='multipart/form-data'>
    <input type='hidden' name='_method' id="_method" value='POST' />
    <input type='hidden' name='comicID' id="comicID" value=''/>

    <h1 id="naslov">Add a new comic</h1>
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
      <label>Upload a picture</label>
      
      <input type='file' name='comic-por-pic'>
      <p>Please upload a picture that is portrait oriented!</p>
      <?php
       $subIndexes = ['type', 'size']; 
       foreach($subIndexes as $subIndex):
       ?>
        <p class='form-error'><?= multi_error_for("comic-por-pic", "comicErrors", $subIndex); ?></p>
       <?php endforeach ?>

    <?php unset($_SESSION['comicErrors']); ?>
    <button id='insertComic' name='insert'>Insert</button>
    <?php 
      if(isset($_SESSION['upload'])) {
        echo "<strong>" . $_SESSION['upload'] . "</strong>"; 
        unset($_SESSION['upload']);
      }
    ?>
  </form>
</div>
<div class="flex-col add-comic update-comic">
  <h1>Choose a comic</h1>
  <?php $stripovi = selectMultipleRows($conn, "select id, name from comics") ?>
  <select id='izbor-stripa'>
    <option value='0'>Izaberite...</option>
    <?php foreach($stripovi as $strip): ?>
      <option value='<?= $strip->id ?>'><?= $strip->name ?></option>
    <?php endforeach ?>
  </select>
  <button id="delete" disabled class='disabled'>
    Delete
  </button>
  <img id="preview" />
</div>
<script>
  window.addEventListener('DOMContentLoaded', () => {
     $(".dial").knob({
      min: 1,
      max: 1000,
      width: 100,
      height: 100
    });
    let select = $(".multipleSelect").fastselect().data('fastselect');

    $("#delete").click(function() {
      var id = $("#izbor-stripa").val();
      ajaxPost("ajax/deleteComic.php", {id: id}, (resp) => {
        console.log(resp);
      });
    });

    $("#izbor-stripa").change(function() {
      $("#delete").removeAttr('disabled');
      $("#delete").removeClass('disabled');
      ajaxPost("ajax/getComic.php", {id: $(this).val()}, (data) => {
        let comic = data.comic;
        let filterIds = data.filters.map((filter) => filter.id_sub_filter + "");
        var options = $(".multipleSelect option").filter(function() {
          return filterIds.includes($(this).val());
        }).toArray();
        $("#comicName").val(comic.name);
        $("#desc").val(comic.description);
        $(".dial").val(comic.issues);

        $(".multipleSelect option").each(function() {
          select.removeSelectedOption(this);
        });
        options.forEach((option) => select.setSelectedOption(option));

        $("#preview").attr("src", comic.path);
        $("#naslov").text("Updating a comic");
        $("#insertComic").text("Update");
        $("#_method").val("UPDATE");
        $("#comicID").val(comic.id);
      })
    });
  });
</script>
