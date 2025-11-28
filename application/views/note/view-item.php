<?php
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-notes-nav.php'); ?>

<h2><?= $viewNotes->title ?>
    <span>
        <?= $User->returnIfAllowed("admin/notes/edit", 
            "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/notes/edit&id=". $viewNotes->id) 
            . ">[Редактировать]</a>");?>
        
        <?= $User->returnIfAllowed("admin/notes/delete",
                "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/notes/delete&id=". $viewNotes->id)
            .    ">[Удалить]</a>"); ?>
    </span>
</h2>

<h3>Category:  <?= $User->returnIfAllowed("admin/categories/edit",
"<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/categories/index&id=". $category->id)
.    ">". $category->name ."</a>"); ?> </h3>

<h4>Subcategory:  <?= $subcategory ? $User->returnIfAllowed("admin/subcategories/edit",
"<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/subcategories/index&id=". $subcategory->id)
.    ">". $subcategory->name ."</a>") : "(none)"; ?> </h3>

<p>Summary: <?= $viewNotes->summary ?></p>
<p>Контент: <?= $viewNotes->content ?></p>
<p>Authors:  
    <?php 
    if (isset($viewNotes->authors) && !empty($viewNotes->authors)) {
        $hyperNames = array();
        foreach($viewNotes->authors as $author) {
            $hyperNames[] = "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/adminusers/index&id=' 
            . $author->id . ">{$author->login}</a>"); 
        }
        echo implode(', ', $hyperNames);
    } else {
        echo '(none)';
    }?> 
</p>
<p>Publication Date:  <?php echo $viewNotes->publicationDate ?></p>
<p>Status:  <?php echo $viewNotes->active == 1 ? 'active' : 'deactivated'; ?></p>
