<?php include_once "admin_nav.php" ?>
<?php 
  if(isset($_POST['update-category'])) {
    $category = $_POST['categoryID'];
    $new_name = $_POST['categoryName'];
    $query = "UPDATE filters SET name=:name WHERE id=:id";
    bind($conn, $query, ["name" => $new_name, "id" => $category]); 
  }

  $category = 1;
  if(isset($_GET['category'])) {
    $category = $_GET['category'];
  }

  $query = "SELECT * FROM filters where id=:id";
  $filter = bindAndSelect($conn, $query, [
    "id" => $category
  ], true);
?>

<div class='flex-row center add-comic'>
  <form action='<?= $_SERVER['PHP_SELF'] . "?page=edit_category&category=$category" ?>' method='POST'>
    <input type='hidden' name='categoryID' id="comicID" value='<?= $category ?>'/>

    <h1 id="naslov">Edit Category</h1>
    <div class='input-group'>
      <label>Category Name</label>
      <input type='text' name='categoryName' value='<?= $filter->name ?>' />
    </div>
    <span class='form-error'><?= error_for("comicName", "comicErrors"); ?></span>

    <button class='change-btn' name='update-category'>Update</button>
    <a href='index.php?page=list_category'>Nazad</a>
  </form>
</div>