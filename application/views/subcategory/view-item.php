<?php
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-subcategories-nav.php'); ?>

<h2><?= $viewSubcategories->name ?>
    <span>
        <?= $User->returnIfAllowed("admin/subcategories/edit", 
            "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/subcategories/edit&id=". $viewSubcategories->id) 
            . ">[Редактировать]</a>");?>
        
        <?= $User->returnIfAllowed("admin/subcategories/delete",
                "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/subcategories/delete&id=". $viewSubcategories->id)
            .    ">[Удалить]</a>"); ?>
    </span>
</h2> 

<h3> Category:  <?= $User->returnIfAllowed("admin/subcategories/edit",
        "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/categories/index&id=". $category->id)
    .    ">". $category->name ."</a>"); ?> </h3>

<p>Контент: <?= $viewSubcategories->description ?></p>

