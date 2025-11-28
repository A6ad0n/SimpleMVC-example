<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
?>

<?php include('includes/admin-subcategories-nav.php'); ?>

<h2><?= $deletedSubcategoryTitle ?></h2>

<form method="post" action="<?= $Url::link("admin/subcategories/delete&id=". $_GET['id'])?>" >
    Вы уверены, что хотите удалить заметку?
    
    <input type="hidden" name="subcategoryId" value="<?= $deletedSubcategory->id ?>">
    <input type="submit" name="deleteSubcategory" value="Удалить">
    <input type="submit" name="cancel" value="Вернуться"><br>
</form>