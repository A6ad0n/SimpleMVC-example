<?php

namespace application\controllers;

use application\models\Category;
use application\models\Subcategory;
use application\models\Note;

/**
 * Контроллер для домашней страницы
 */
class HomepageController extends \ItForFree\SimpleMVC\MVC\Controller
{
    /**
     * @var string Название страницы
     */
    public $homepageTitle = "Домашняя страница";
    
    /**
     * @var string Пусть к файлу макета 
     */
    public string $layoutPath = 'home.php';
      
    /**
     * Выводит на экран страницу "Домашняя страница"
     */
    public function indexAction()
    {
        $Note = new Note();
        $Category = new Category();
        $Subcategory = new Subcategory();
        $subcategories = $Subcategory->getList(10)['results'];
        $notes = $Note->getList()['results'];
        $categoryIds = array_map(fn($n) => $n->categoryId, $notes);
        $categoryIds = array_unique($categoryIds);
        $categories = array();
        foreach ($categoryIds as $catId) {
            $categories[$catId] = $Category->getById($catId);
        }
        $preparedData = array();
        foreach ($notes as $note) {
            $note->loadAuthors();
            $category = $categories[$note->categoryId] ?? null;
            $subcategory = null;
            foreach($subcategories as $subcat) {
                if ($subcat->categoryId == $category) {
                    $subcategory = $subcat; 
                    break;
                }
            }
            $preparedData[] = [
                'subcategoryId' => $subcategory->id,
                'subcategoryName' => $subcategory->name,
                'categoryId' => $category->id,
                'categoryName' => $category->name,
                'noteId' => $note->id,
                'noteTitle' => $note->title,
                'noteContent' => $note->content,
                'notePublicationDate' => $note->publicationDate,
                'noteActive' => $note->active,
                'noteAuthors' => $note->authors
            ];
        }
        $this->view->addVar('preparedData', $preparedData);
        $this->view->render('homepage/index.php');
    }
}

