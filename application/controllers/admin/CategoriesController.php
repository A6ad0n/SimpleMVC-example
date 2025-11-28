<?php
namespace application\controllers\admin;
use application\models\Category;
use ItForFree\SimpleMVC\Config;

/* 
 *   Class-controller categories
 * 
 * 
 */

class CategoriesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public string $layoutPath = 'admin-main.php';

    protected array $rules = [ //вариант 2:  здесь всё гибче, проще развивать в дальнешем
         ['allow' => true, 'roles' => ['admin']],
         ['allow' => false, 'roles' => ['?', '@']],
    ];

    public function indexAction()
    {
        $Category = new Category();
        $categoryId = $_GET['id'] ?? null;
        if ($categoryId) {
            $viewCategories = $Category->getById($_GET['id']);
            $this->view->addVar('viewCategories', $viewCategories);
            $this->view->render('category/view-item.php');
        } else {
            $categories = $Category->getList()['results'];
            $this->view->addVar('categories', $categories);
            $this->view->render('category/index.php');
        }
    }
     
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewCategory'])) {
                $Category = new Category();
                $newCategories = $Category->loadFromArray($_POST);
                $newCategories->insert(); 
                $this->redirect($Url::link("admin/categories/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/index"));
            }
        }
        else {
            $addCategoryTitle = "Добавление новой заметки";
            $this->view->addVar('addCategoryTitle', $addCategoryTitle);
            $this->view->render('category/add.php');
        }
    }
    
    public function editAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        if (!empty($_POST)) {
            if (!empty($_POST['saveChanges'] )) {
                $Category = new Category();
                $newCategories = $Category->loadFromArray($_POST);
                $newCategories->id = $id;
                $newCategories->update();
                $this->redirect($Url::link("admin/categories/index&id=$id"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/index&id=$id"));
            }
        }
        else {
            $Category = new Category();
            $viewCategories = $Category->getById($id);
            $editCategoryTitle = "Редактирование заметки";
            $this->view->addVar('viewCategories', $viewCategories);
            $this->view->addVar('editCategoryTitle', $editCategoryTitle);
            $this->view->render('category/edit.php');   
        }
        
    }
    
    public function deleteAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        if (!empty($_POST)) {
            if (!empty($_POST['deleteCategory'])) {
                $Category = new Category();
                $newCategories = $Category->loadFromArray($_POST);
                $newCategories->id = $id;
                $newCategories->delete();
                $this->redirect($Url::link("admin/categories/index"));
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/edit&id=$id"));
            }
        }
        else {
            $Category = new Category();
            $deletedCategory = $Category->getById($id);
            $deleteCategoryTitle = "Удалить заметку?";
            $this->view->addVar('deleteCategoryTitle', $deleteCategoryTitle);
            $this->view->addVar('deletedCategory', $deletedCategory);
            $this->view->render('category/delete.php');
        }
    }   
}