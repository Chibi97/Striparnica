<div class='flex-col center'>
  <div class='browse-container flex-row'>
    <div class='filters'>
      <h1 class='text-center heading'>Filters</h1>
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
      bla blaa
    </div>
  </div>
</div>