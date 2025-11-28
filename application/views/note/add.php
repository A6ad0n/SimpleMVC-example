<style> 
    
    textarea{
        height: 200%;
        width: 1110px;
        color: #003300;
    }
   
</style>

<?php include('includes/admin-notes-nav.php'); ?>
<h2><?= $addNoteTitle ?></h2>

<form id="addNote" method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/notes/add")?>"> 
    <div class="form-group">
        <label for="title">Название новой заметки</label>
        <input type="text" class="form-control" name="title" id="title" placeholder="имя заметки">
    </div>
    <div class="form-group">
        <label for="summary">Summary</label><br>
        <textarea type="description" name="summary" placeholder="описание заметки"  value=></textarea>
    </div>
    <div class="form-group">
        <label for="content">Содержание</label><br>
        <textarea type="description" name="content" placeholder="описание заметки"  value=></textarea>
    </div>
    <div class="form-group">
        <label for="categoryId">Article Category</label>
        <select name="categoryId">
            <option value="0">(none)</option>
        <?php foreach ( $categories as $category ) { ?>
            <option value="<?php echo $category->id?>"><?php echo htmlspecialchars( $category->name )?></option>
        <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="subcategoryId">Article Subcategory</label>
        <select name="subcategoryId" id="subcategoryId">
            <option value="">(none)</option>
            <?php 
            $groupedSubcategories = [];
            foreach ($subcategories as $subcategory) {
                $groupedSubcategories[$subcategory->categoryId][] = $subcategory;
            }
            foreach ($groupedSubcategories as $categoryId => $subcategories) {
                $categoryName = '';
                foreach ($categories as $category) {
                    if ($category->id == $categoryId) {
                        $categoryName = $category->name;
                        break;
                    }
                }
                echo '<optgroup label="' . htmlspecialchars($categoryName) . '">';
                foreach ($subcategories as $subcategory) {
                    echo '<option value="' . $subcategory->id . '" data-category="' . $subcategory->categoryId . '"' . '>' . htmlspecialchars($subcategory->name) . '</option>';
                }
                echo '</optgroup>';
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="authors">Article Authors</label>
        <select name="authors[]" id="authors" multiple="multiple" size="6" style="min-height: 120px;">
            <?php
            foreach ($users as $user) { ?>
                <option value="<?php echo $user->id?>"><?php echo htmlspecialchars($user->login)?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="publicationDate">Publication Date</label>
        <input type="date" name="publicationDate" id="publicationDate" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo "" ?>" />
    </div>

    <div class="form-group">
        <label for="active">
            <input type="hidden" name="active" value="0">
            <input type="checkbox" name="active" id="active" value="1"
            <?php echo 'checked'; ?>
            />
            Article is active
        </label>
    </div>
    <input type="submit" class="btn btn-primary" name="saveNewNote" value="Сохранить">
    <input type="submit" class="btn" name="cancel" value="Назад">
</form>    
