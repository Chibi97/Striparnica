<<?php include_once "admin_nav.php" ?>
<div class="flex-row center">
  <table class='my-table'>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Action</th>
    </tr>
  <?php
    $svi = $conn->query("SELECT * FROM filters");
    foreach($svi as $f):
  ?>
      <tr>
        <td><?= $f->id ?></td>
        <td><?= $f->name ?></td>
        <td>
          <a href='index.php?page=edit_category&category=<?= $f->id ?>'>Edit</a>
        </td>
      </tr>
  <?php endforeach ?>
  </table>
</div>