<div class='browse-container'>
  <div class='filters'>
    <h1 class='text-center'>Filters</h1>
    <?php $filters = selectMultipleRows($conn, "SELECT name FROM filters"); ?> 
    <ul>
      <?php foreach($filters as $filter): ?>
        <li>
          <div class='title'>
            <span><?= $filter->name ?></span> 
            <i class="fas fa-caret-up"></i>
          </div>
          <ul class='sub-items'>
            <li>Test1</li>
            <li>Test2</li>
          </ul>
        </li>
      <?php endforeach ?>
    </ul>
  </div>
  <div class='comics'>
  </div>
</div>