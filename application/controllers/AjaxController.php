<?php
namespace application\controllers;
use application\models\Note;


class AjaxController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public function getContentAction() {
        $Note = new Note();
        if ($this->isApiRequested()) {
            $jsonInput = file_get_contents('php://input');
            if (!empty($jsonInput)) {
                $data = json_decode($jsonInput, true);
                if (isset($data['id'])) {
                    $id = $data['id'];
                    $article = $Note->getById((int) $id);
                    $this->sendApiResponse([$article->content]);
                } else {
                    $this->sendApiResponse(['error' => 'Missing id parameter in JSON body'], 400);
                }
            } 
            elseif (isset($_GET['articleId'])) {
                $article = $Note->getById((int) $_GET['articleId']);
                $this->sendApiResponse([$article->content]);
            } 
            elseif (isset($_POST['articleId'])) {
                $article = $Note->getById((int) $_POST['articleId']);
                $this->sendApiResponse([$article->content]);
            } 
            else {
                $this->sendApiResponse(['error' => 'No article identifier provided'], 400);
            }
        } else {
            if (isset($_GET['articleId'])) {
                $article = $Note->getById((int) $_GET['articleId']);
                echo $article->content;
            }
            if (isset($_POST['articleId'])) {
                $article = $Note->getById((int) $_POST['articleId']);
                echo json_encode($article->content);
            }
        }
    }

    public function showContentsHandlerAction() {
        $Note = new Note();
        if ($this->isApiRequested()) {
            $jsonInput = file_get_contents('php://input');
            $data = json_decode($jsonInput, true);
            $id = $data['id'];
            $article = $Note->getById((int) $id);
            $this->sendApiResponse([json_encode($article->content)]);
        }
        if (isset($_GET['articleId'])) {
            $article = $Note->getById((int)$_GET['articleId']);
            echo $article->content;
        }
        if (isset ($_POST['articleId'])) {
            $article = $Note->getById((int)$_POST['articleId']);
            echo json_encode($article->content);
        }
    }
}

