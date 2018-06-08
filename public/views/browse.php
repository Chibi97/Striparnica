<div class='browse-container'>
  <div class='filters'>
    <h1 class='text-center'>Filters</h1>
    <?php $filters = selectFiltersWithSubfilter($conn) ?> 
    <ul>
      <?php foreach($filters as $filter): ?>
        <li>
          <div class='title'>
            <span><?= $filter->name ?></span> <i class="fas fa-caret-up"></i>
          </div>
          <ul class='sub-items'>
          <?php foreach($filter->subfilters as $subfilter): ?>
            <li><?= $subfilter->name ?></li>
          <?php endforeach ?>
          </ul>
        </li>
      <?php endforeach ?>
    </ul>
  </div>
  <div class='comics'>
  </div>
</div>