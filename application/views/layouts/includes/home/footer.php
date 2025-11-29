<?php
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;
$User = Config::getObject('core.user.class');
?>

<div class="border-t border-[#00a0b0] mt-10 pt-5 text-[0.8em]">
    Простая PHP CMS &copy; 2017. Все права принадлежат всем. ;)         
    <?php  $href = '/';
    if ($User->isAllowed("login/login")) { 
        $href = WebRouter::link("login/login");
    }
    else if ($User->isAllowed("admin/adminusers/index")) {
        $href = WebRouter::link("admin/adminusers/index");
    } 
    ?>
    <a class="underline text-blue-800 visited:text-purple-800" href="<?=$href ?>">Site Admin</a>
</div>

