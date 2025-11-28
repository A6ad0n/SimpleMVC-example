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

<?php include('includes/admin-notes-nav.php'); ?>

<h2><?= $editNoteTitle ?></h2>

<form id="editNote" method="post" action="<?= $Url::link("admin/notes/edit&id=" . $_GET['id'])?>">
    <h5>Note title</h5> 
    <input type="text" name="title" placeholder="name note" value=<?= $viewNotes->title?>>
    <h5>Summary</h5>
    <textarea type="description" name="summary" placeholder="описание заметки"><?= $viewNotes->summary?></textarea>
    <h5>Note content</h5>
    <textarea type="description" name="content" placeholder="контент"><?= $viewNotes->content ?></textarea>
    <h5>Article Category</h5>
    <select name="categoryId">
        <option value="0"<?php echo !$viewNotes->categoryId ? " selected" : ""?>>(none)</option>
        <?php foreach ( $categories as $category ) { ?>
            <option value="<?php echo $category->id?>"<?php echo ( $category->id == $viewNotes->categoryId ) ? " selected" : ""?>><?php echo htmlspecialchars( $category->name )?></option>
        <?php } ?>
    </select>
    <h5>Article Subcategory</h5>
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
            echo '<optgroup h5="' . htmlspecialchars($categoryName) . '">';
            foreach ($subcategories as $subcategory) {
                $selected = (isset($viewNotes->subcategoryId) && $viewNotes->subcategoryId == $subcategory->id) ? ' selected' : '';
                echo '<option value="' . $subcategory->id . '" data-category="' . $subcategory->categoryId . '"' . $selected . '>' . htmlspecialchars($subcategory->name) . '</option>';
            }
            echo '</optgroup>';
        }
        ?>
    </select>

    <h5>Article Authors</h5>
    <select name="authors[]" id="authors" multiple="multiple" size="6" style="min-height: 120px;">
        <?php
        $currentAuthors = isset($viewNotes->authors) ? $viewNotes->authors : array();
        foreach ($users as $user) { 
            $selected = in_array($user, $currentAuthors) ? ' selected="selected"' : ''; ?>
        <option value="<?php echo $user->id?>"<?php echo $selected?>><?php echo htmlspecialchars($user->login)?></option>
        <?php } ?>
    </select>

    <h5>Publication Date</h5>
    <input type="date" name="publicationDate" id="publicationDate" placeholder="YYYY-MM-DD" required maxlength="10" value="
        <?php echo (isset($viewNotes->publicationDate)) ? $viewNotes->publicationDate : "" ?>" 
    />

    <h5>
        <input type="hidden" name="active" value="0">
        <input type="checkbox" name="active" id="active" value="1"
            <?php echo (isset($viewNotes->active) && $viewNotes->active == 1) ? 'checked' : 'unchecked'; ?>
        />
        Article is active
    </h5>

<input type="hidden" name="id" value="<?= $_GET['id']; ?>">
<input type="submit" name="saveChanges" value="Сохранить">
<input type="submit" name="cancel" value="Назад">
</form>