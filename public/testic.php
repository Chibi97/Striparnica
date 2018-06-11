<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $img = $_POST['imgBase64'];
  $img = str_replace('data:image/png;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $fileData = base64_decode($img);
  $fileName = 'photo.png';
  file_put_contents($fileName, $fileData);
  echo "Sacuvano!";
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Slicica</title>
</head>
<body>
  <input id='fileinput' type='file' >
  <button id='posalji'>Posalji</button>
 <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<script>
    var MAXWidthHeight = 200;
    var canvas = document.createElement("canvas");

    function h(e) {
      var fr = new FileReader();
      fr.onload = function (e) {
        var img = new Image();
        img.onload = function () {
          var r = MAXWidthHeight / Math.max(this.width, this.height)
          var w = Math.round(this.width * r)
          var h = Math.round(this.height * r)

          canvas.width = w;
          canvas.height = h;
          canvas.getContext("2d").drawImage(this, 0, 0, w, h);
          this.src = canvas.toDataURL();
          document.body.appendChild(this);
        }
        img.src = e.target.result;
      }
      fr.readAsDataURL(e.target.files[0]);
    }
    window.onload = function () {
      document.getElementById('fileinput').addEventListener('change', h, false);
    }


    $("#posalji").click(() => {
      $.ajax({
        type: "POST",
        url: "testic.php",
        data: {
          imgBase64: canvas.toDataURL()
        }
      }).done((data) => alert(data));
    })
</script>
</body>
</html>