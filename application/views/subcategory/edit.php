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

<?php include('includes/admin-subcategories-nav.php'); ?>

<h2><?= $editSubcategoryTitle ?></h2>

<form id="editSubcategory" method="post" action="<?= $Url::link("admin/subcategories/edit&id=" . $_GET['id'])?>">
    <h5>Subcategory name</h5> 
    <input type="text" name="name" placeholder="name subcategory" value=<?= $viewSubcategories->name?>><br>
    <h5>Subcategory decsription</h5>
    <textarea type="description" name="description" placeholred="контент"   value=><?= $viewSubcategories->description ?></textarea><br>
    <h5>Category</h5>
    <select name="categoryId" id="categoryId" required>
        <option value="">Select a Category</option>
        <?php foreach ( $categories as $category ) { ?>
            <option value="<?php echo $category->id?>"<?php echo ( $category->id == $viewSubcategoryies->categoryId ) ? " selected" : "" ?>><?php echo htmlspecialchars( $category->name ?? '')?></option>
        <?php } ?>
    </select>

<input type="hidden" name="id" value="<?= $_GET['id']; ?>">
<input type="submit" name="saveChanges" value="Сохранить">
<input type="submit" name="cancel" value="Назад">
</form>