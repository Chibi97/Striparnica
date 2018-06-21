<section class='slider flex-row center'>
  <span id="slide-left" class='fas fa-chevron-left'></span>
  <article class='list-of-comics'>
    <div class='sneak-peek'>
      <h2>Sneak Peek</h2>
    </div>
    <div class='image-slider-wrap'>
      <div class='image-slider'>
        <?php
          $upit = "SELECT p.path, p.alt FROM comics c INNER JOIN pictures p ON c.id = p.id_comic ORDER BY issues LIMIT 0,10";
          $pics = selectMultipleRows($conn, $upit);
          foreach($pics as $pic):
        ?>
        <img src='<?= $pic->path ?>' alt='<?= $pic->alt ?>' />
        <?php endforeach ?>
      </div>
    </div>
  </article>
  <span id="slide-right" class='fas fa-chevron-right'></span>
</section>

<?php
  if(isset($_SESSION['user'])): ?>
  <?php 
    $upit = "SELECT c.name,p.path, p.alt, COUNT(*) AS votes FROM votes v JOIN comics c ON v.id_comic = c.id JOIN pictures p ON c.id = p.id_comic GROUP BY c.name, p.path, p.alt ORDER BY votes DESC LIMIT 0,3";
    $comics = selectMultipleRows($conn, $upit);
  ?>
    <section class='list-adv  flex-col center'>
      <h2>Top by votes:</h2>
      <article class='last-added flex-row'>
        
        <?php
         if(count($comics) == 0) {
           echo "<span>Be the first one to vote!</span>";
         } 
        foreach($comics as $comic): ?>
          <figure class='l3-item'>
            <img src='<?= $comic->path ?>' alt='<?= $comic->alt ?>' />
            <figcaption class='l3-desc'>
              <p><?= $comic->name ?></p>
            </figcaption>
          </figure>
       <?php endforeach ?>
      </article>

      <article class='vote flex-col center'>
        <h2>Vote for your favorite comic:</h2>
        <select id='vote' name='vote'>
          <?php
            $upit = "SELECT id,name FROM comics";
            $comics = selectMultipleRows($conn, $upit);
            foreach($comics as $comic):
          ?>
            <option value='<?= $comic->id ?>'><?= $comic->name ?></option>
          <?php endforeach ?>
        </select>
        <span class='already-voted'></span>
        <span class='vote-msg'> Click <a href=''>here</a> to remove your vote.</span>
      </article>
    </section>
   
<?php else: ?>
  <section class='list-adv flex-row center'>
    <article class='la-group'>
      <p>Ever wanted to keep track of the comics that you are interested it? Well, we have a solution for you! We'll give you one list, so you decide what you'll keep track of -- favorites, currently reading, plan to read or anything else. Register now, and you can make your own list of comics for free, give your own ratings and decide what next to read.</p>
    </article>
    <article class='links-lr'>
      <a href='#' class='open-modal-register btn-style bs-white'>JOIN US NOW</a>
      <a href='#' class='open-modal-login btn-style bs-white'>LOGIN</a>
    </article>  
  </section>
<?php endif; ?>


<section class='section-filter flex-row center'>
  <article class='sf-article'>
    <h3>BROWSE BY FILTERS</h3>
    <?php
     $rows = selectMultipleRows($conn, "SELECT DISTINCT sf.name FROM filters f INNER JOIN sub_filters sf ON f.id = sf.id_filter;");
     
     foreach($rows as $row) {
        echo "<a href='index.php?page=browse&filter={$row->name}' class='filter'>{$row->name}</a>";
      }
    ?>
   
  </article>
</section>
