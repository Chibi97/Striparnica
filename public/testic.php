<?php 
  function resize_image($file, $targetWidth, $targetHeight) {
    list($originalWidth, $originalHeight) = getimagesize($file);
    $ratio = $originalWidth / $originalHeight;

    // 250
    // 355
    if($ratio < 1) {
      $targetWidth = $targetHeight * $ratio;
    } else {
      throw new Error("Wrong image format supplied");
    }

    $originalImage = imagecreatefromjpeg($file);
    $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);
    imagecopyresampled($targetImage, $originalImage, 
        0, 0, 0, 0, 
        $targetWidth, $targetHeight, 
      $originalWidth, $originalHeight);
      imagejpeg($targetImage, $file, 100);
  }

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $file = $_FILES['slika'];
  $target = "uploads/" . basename($file["name"]);
  move_uploaded_file($file['tmp_name'], $target);
  resize_image($target, 250, 355);
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
  <form action='testic.php' method='post' enctype='multipart/form-data'>
    <input type='file' name='slika'>
    <button>
      Posalji
    </button>
  </form> 

  <?php 
    $files = scandir("uploads/");
    foreach($files as $file):
  ?>
  <div class='images'>
    <?php if($file != '.' && $file != '..'): ?>
      <img src='uploads/<?= $file ?>'>
    <?php endif ?>
  <?php endforeach ?>
  </div>
</body>
</html>