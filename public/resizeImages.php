<?php
  include_once 'php/utilities.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $file = $_FILES['slika'];
  $target = "uploads/" . time() . "_" . basename($file["name"]);
  try {
    // AKO ovo baci exception, ovo dole se ne izvrsava. oki, a sto nisi za ime fajla posolio?
    resize_image($file['tmp_name'], 355, 'resize_image_by_width'); // nema potrebe proslediti sirnu i ovako je ne korstim ok, a sta je sad ovo
    move_uploaded_file($file['tmp_name'], $target);
  } catch(Exception $e) {
    echo "Slika nije u dobrom formatu!";
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Slicica</title>

  <style>
    .images {
      display: flex;
    }

    .images img {
      margin: .5em;
    }
  </style>
</head>
<body>
  <form action='resizeImages.php' method='post' enctype='multipart/form-data'>
    <input type='file' name='slika'>
    <button>
      Posalji
    </button>
  </form>

  <?php
    $files = scandir("uploads/");
    foreach($files as $file):
  ?>
  <div class=''>
    <?php if($file != '.' && $file != '..'): ?>
      <img src='uploads/<?= $file ?>'>
    <?php endif ?>
  <?php endforeach ?>
  </div>
</body>
</html>
