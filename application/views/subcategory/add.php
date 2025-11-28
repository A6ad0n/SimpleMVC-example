<style> 
    
    textarea{
        height: 200%;
        width: 1110px;
        color: #003300;
    }
   
</style>

<?php include('includes/admin-subcategories-nav.php'); ?>
<h2><?= $addSubcategoryTitle ?></h2>

<form id="addSubcategory" method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/subcategories/add")?>"> 
    <div class="form-group">
        <label for="name">Название новой subcategory</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="имя заметки">
    </div>
    <div class="form-group">
        <label for="description">Содержание</label><br>
        <textarea type="description" name="description" placeholred="описание заметки"  value=></textarea>
    </div>
    <div class="form-group">
        <label for="categoryId">Category</label>
        <select name="categoryId" id="categoryId" required>
            <option value="">Select a Category</option>
            <?php foreach ( $categories as $category ) { ?>
                <option value="<?php echo $category->id?>"><?php echo htmlspecialchars( $category->name ?? '')?></option>
            <?php } ?>
        </select>
    </div>
    <input type="submit" class="btn btn-primary" name="saveNewSubcategory" value="Сохранить">
    <input type="submit" class="btn" name="cancel" value="Назад">
</form>    
