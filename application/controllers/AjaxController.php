<?php
namespace application\controllers;
use application\models\Note;


class AjaxController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public function getContentAction() {
        $Note = new Note();
        if (isset($_GET['articleId'])) {
            $article = $Note->getById((int) $_GET['articleId']);
            echo $article->content;
        }
        if (isset($_POST['articleId'])) {
            $article = $Note->getById((int) $_POST['articleId']);
            echo $article->content;
        }
    }

    public function showContentsHandlerAction() {
        $Note = new Note();
        if (isset($_GET['articleId'])) {
            $article = $Note->getById((int)$_GET['articleId']);
            echo $article->content;
        }
        if (isset ($_POST['articleId'])) {
            $article = $Note->getById((int)$_POST['articleId']);
            echo json_encode($article);
        }
    }
}

