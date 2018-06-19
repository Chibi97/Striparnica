
<?php
  $id = $_SESSION['user']->id;
  $mycomics = "SELECT c.*, p.path, p.alt FROM comics c 
            INNER JOIN list l ON l.id_comic=c.id INNER JOIN pictures p ON p.id_comic = c.id
            WHERE l.id_user=$id";
  $myComics = selectMultipleRows($conn, $mycomics);
?>
<div class='wrapper-for-comics flex-row center'>
  <?php foreach($myComics as $myComic): ?>
  <div class='comic'>
    <img src='<?= $myComic->path ?>' alt='<?= $myComic->alt ?>' />
    <div class=''>
      <a href='#' data-id='<?= $myComic->id ?>' class='btn-style bs-white add-to-list'>Remove</a>
    </div>
    <h2><?= $myComic->name ?></h2>
    <p class='scroll'><?= $myComic->description ?></p>
    <div class='info'>
      <p><strong>Issues/Chapters: </strong><?= $myComic->issues ?></p>
      <p><strong>Number of votes: </strong><?= $myComic->votes ?></p>
    </div>
  </div>
  <?php endforeach ?>
</div>
