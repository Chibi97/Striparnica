<?php
  $id = isset($_SESSION['user']) ? $_SESSION['user']->id : null;
  if(empty($id)): ?>
    <section class='list-adv flex-row center'>
      <article class='la-group'>
        <p><strong class='warning'>You need to login in order to see this page..</strong></p>
        <p>Ever wanted to keep track of the comics that you are interested it? Well, we have a solution for you! We'll give you one list, so you decide what you'll keep track of -- favorites, currently reading, plan to read or anything else. Register now, and you can make your own list of comics for free, give your own ratings and decide what next to read.</p>
      </article>

       <article class='links-lr'>
      <a href='#' class='open-modal-register btn-style bs-white'>JOIN US NOW</a>
      <a href='#' class='open-modal-login btn-style bs-white'>LOGIN</a>
    </article> 
    </section>
<?php else:
    $upit = "SELECT c.*, p.path, p.alt FROM comics c 
                INNER JOIN list l ON l.id_comic=c.id INNER JOIN pictures p ON p.id_comic = c.id
                WHERE l.id_user=$id";
    $myComics = $conn->query($upit)->fetchAll();
     if(!empty($myComics)) { 
?>
<div class='wrapper-for-comics flex-row center'>
  <?php foreach($myComics as $myComic): ?>
  <div class='comic'>
    <img src='<?= $myComic->path ?>' alt='<?= $myComic->alt ?>' />
    <div class='ar-btn'>
      <a href='#' data-id='<?= $myComic->id ?>' class='btn-style bs-white add-to-list remove'>Remove</a>
    </div>
    <h2><?= $myComic->name ?></h2>
    <p class='scroll'><?= $myComic->description ?></p>
    <div class='info'>
      <p><strong>Issues/Chapters: </strong><?= $myComic->issues ?></p>
    </div>
  </div>
  <?php endforeach ?>
</div>

<?php } else { ?>
 <section class='list-adv flex-row center'>
      <article class='la-group'>
        <p><strong class='warning'>You don't have anything in your list... browse and add some!</strong></p>
      </article>
  </section>
<?php } ?>
    
<?php endif; ?>