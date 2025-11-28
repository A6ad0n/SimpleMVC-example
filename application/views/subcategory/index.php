<?php 
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>
<?php include('includes/admin-subcategories-nav.php'); ?>

<h2>List subcategories</h2>

<?php if (!empty($subcategories)): ?>
<table class="table">
    <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">Category</th>
    </tr>
     </thead>
    <tbody>
    <?php foreach($preparedData as $row): ?>
    <tr>
        <td> <?= "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/subcategories/index&id=' 
		. $row['subcategoryId'] . ">{$row['subcategoryName']}</a>" ) ?> </td>
        <td> <?= $row['subcategoryDescription'] ?> </td>
        <td> <?= "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/categories/index&id=' 
		. $row['categoryId'] . ">{$row['categoryName']}</a>" ) ?> </td>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<?php else:?>
    <p> Список subcategories пуст</p>
<?php endif; ?>

