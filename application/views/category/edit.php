<style> 
    
    textarea{
        height: 200%;
        width: 1110px;
        color: #003300;
    }
   
</style>

<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-categories-nav.php'); ?>

<h2><?= $editCategoryTitle ?></h2>

<form id="editCategory" method="post" action="<?= $Url::link("admin/categories/edit&id=" . $_GET['id'])?>">
    <h5>Category title</h5> 
    <input type="text" name="name" placeholder="name category" value=<?= $viewCategories->name?>><br>
    <h5>Category description</h5>
    <textarea type="description" name="description" placeholred="контент"   value=><?= $viewCategories->description ?></textarea><br>

<input type="hidden" name="categoryId" value="<?= $_GET['id']; ?>">
<input type="submit" name="saveChanges" value="Сохранить">
<input type="submit" name="cancel" value="Назад">
</form>