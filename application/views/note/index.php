<?php 
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>
<?php include('includes/admin-notes-nav.php'); ?>

<h2>List notes</h2>

<?php if (!empty($preparedData)): ?>
<table class="table">
    <thead>
        <tr>
            <th>Publication Date</th>
            <th>Article</th>
            <th>Category</th>
            <th>Subcategory</th>
            <th>Authors</th>
            <th>Active</th>
        </tr>     
     </thead>
    <tbody>
    <?php foreach($preparedData as $row): ?>
    <tr>
        <td><?php echo $row['notePublicationDate']?></td>
        <td> <?= "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/notes/index&id=' 
		    . $row['noteId'] . ">{$row['noteTitle']}</a>" ) ?> </td>
        <td>   
            <?php 
            if(isset ($row['categoryId'])) {
                echo "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/categories/index&id=' 
                . $row['categoryId'] . ">{$row['categoryName']}</a>");                    
            }
            else {
            echo "Без категории";
            }?>
        </td>
        <td>
            <?php 
            if(isset($row['subcategoryId'])) {
                 echo "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/subcategories/index&id=' 
                . $row['subcategoryId'] . ">{$row['subcategoryName']}</a>");   
            }
            else {
                echo "(none)";
            }?>
        </td>
        <td>
            <?php 
            if (isset($row['noteAuthors']) && !empty($row['noteAuthors'])) {
                $hyperNames = array();
                foreach($row['noteAuthors'] as $author) {
                    $hyperNames[] = "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/adminusers/index&id=' 
                    . $author->id . ">{$author->login}</a>"); 
                }
                echo implode(', ', $hyperNames);
            } else {
                echo '(none)';
            }?> 
        </td>
        <td>
            <?php echo $row['noteActive'] == 1 ? 'active' : 'deactivated'; ?>
        </td>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<?php else:?>
    <p> Список заметок пуст</p>
<?php endif; ?>

