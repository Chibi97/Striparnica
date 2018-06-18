<section class='slider flex-row center'>
  <span id="slide-left" class='fas fa-chevron-left'></span>
  <article class='list-of-comics'>
    <div class='sneak-peek'>
      <h2>Sneak Peek</h2>
    </div>
    <div class='image-slider-wrap'>
      <div class='image-slider'>
        <img src='images/comics/american_gods.jpg' alt='american_gods' />
        <img src='images/comics/death_note.jpg' alt='american_gods' />
        <img src='images/comics/naruto.jpg' alt='american_gods' />
        <img src='images/comics/infinity_gauntlet.jpg' alt='american_gods' />
        <img src='images/comics/sandman.jpg' alt='american_gods' />

         <img src='images/comics/american_gods.jpg' alt='american_gods' />
        <img src='images/comics/death_note.jpg' alt='american_gods' />
        <img src='images/comics/naruto.jpg' alt='american_gods' />
        <img src='images/comics/infinity_gauntlet.jpg' alt='american_gods' />
        <img src='images/comics/sandman.jpg' alt='american_gods' />
      </div>
    </div>
  </article>
  <span id="slide-right" class='fas fa-chevron-right'></span>
</section>

<?php
  if(isset($_SESSION['user'])): ?>
    <section class='list-adv flex-col center'>
      <h2>The last ones you added</h2>
      <article class='last-added flex-row'>
        <figure class='l3-item'>
          <img src='../images/comics/infinity_gauntlet.jpg' alt='iw' />
          <figcaption class='l3-desc'>
            <p>Neki opis</p>
          </figcaption>
        </figure>

        <figure class='l3-item'>
          <img src='../images/comics/attack_on_titan.jpg' alt='iw' />
          <figcaption class='l3-desc'>
            <p>Neki opis</p>
          </figcaption>
        </figure>

        <figure class='l3-item'>
          <img src='../images/comics/naruto.jpg' alt='iw' />
          <figcaption class='l3-desc'>
            <p>Neki opis</p>
          </figcaption>
        </figure>
      </article>
      <span class='the-rest'>You can see the rest <a href='../index.php?page=my_list'>here</a>.</span>
    </section>
<?php else: ?>
  <section class='list-adv flex-row center'>
    <article class='la-group'>
      <p>Ever wanted to keep track of the comics that you are interested it? Well, we have a solution for you! We'll give you one list, so you decide what you'll keep track of -- favorites, currently reading, plan to read or anything else. Register now, and you can make your own list of comics for free, give your own ratings and decide what next to read.</p>
    </article>
    <article>
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
