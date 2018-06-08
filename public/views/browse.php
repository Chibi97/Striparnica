<div class='browse-container flex-row'>
  <div class='filters'>
    <h1 class='text-center heading'>Filters</h1>
    <?php 
      $filters = selectMultipleRows($conn, "SELECT name FROM filters");
      $subFilters = selectMultipleRows($conn, "SELECT sf.name FROM sub_filters sf INNER JOIN filters f ON sf.id_filter = f.id
      WHERE id_filter = 4");
     ?> 
    <ul>
      <?php foreach($filters as $filter): ?>
        <li>
          <div class='title'>
            <span><?= $filter->name ?></span> 
            <i class="fas fa-caret-up"></i>
          </div>
          <ul class='sub-items'>
            <li><a href='#'>Test1</a></li>
            <li><a href='#'>Test1</a></li>
            <li><a href='#'>Test1</a></li>
          </ul>
        </li>
      <?php endforeach ?>
    </ul>
  </div>
  <div class='comics'>
  </div>
</div>