<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
?>

<?php include('includes/admin-categories-nav.php'); ?>

<h2><?= $deleteCategoryTitle ?></h2>

<form method="post" action="<?= $Url::link("admin/categories/delete&id=". $_GET['id'])?>" >
    Вы уверены, что хотите удалить заметку?
    
    <input type="hidden" name="caterogyId" value="<?= $deletedCategory->id ?>">
    <input type="submit" name="deleteCategory" value="Удалить">
    <input type="submit" name="cancel" value="Вернуться"><br>
</form>