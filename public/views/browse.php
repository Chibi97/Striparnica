<div class='flex-col center'>
  <div class='browse-container row-no-wrap'>
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
              <li>
                <label class='custom-checkbox'>
                  <span class='search-text'><?= $subfilter->name ?></span>
                  <input class='filter' type='checkbox' value='<?= $subfilter->id ?>' />
                  <span class='checkmark'></span>
                </label>
              </li>
            <?php endforeach ?>
            </ul>
          </li>
        <?php endforeach ?>
      </ul>
    </div>
    <div class='comics flex-row center'>

    </div>
  </div>
  <div class='comics-control'>
  </div>
</div>