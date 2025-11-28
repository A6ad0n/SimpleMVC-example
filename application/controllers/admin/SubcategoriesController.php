<?php
namespace application\controllers\admin;
use application\models\Subcategory;
use application\models\Category;
use ItForFree\SimpleMVC\Config;

/* 
 *   Class-controller subcategories
 * 
 * 
 */

class SubcategoriesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public string $layoutPath = 'admin-main.php';

    protected array $rules = [ //вариант 2:  здесь всё гибче, проще развивать в дальнешем
         ['allow' => true, 'roles' => ['admin']],
         ['allow' => false, 'roles' => ['?', '@']],
    ];

    public function indexAction()
    {
        $Subcategory = new Subcategory();
        $Category = new Category();
        $subcategoryId = $_GET['id'] ?? null;
        if ($subcategoryId) {
            $viewSubcategories = $Subcategory->getById($_GET['id']);
            $category = $Category->getById($viewSubcategories->categoryId);
            $this->view->addVar('category', $category);
            $this->view->addVar('viewSubcategories', $viewSubcategories);
            $this->view->render('subcategory/view-item.php');
        } else {
            $subcategories = $Subcategory->getList()['results'];
            $categoryIds = array_map(fn($subcat) => $subcat->categoryId, $subcategories);
            $categoryIds = array_unique($categoryIds);
            $categories = array();
            foreach ($categoryIds as $catId) {
                $categories[$catId] = $Category->getById($catId);
            }
            $preparedData = array();
            foreach ($subcategories as $subcategory) {
                $categoryId = $subcategory->categoryId;
                $category = $categories[$categoryId] ?? null;
                $preparedData[] = [
                    'subcategoryId' => $subcategory->id,
                    'subcategoryName' => $subcategory->name,
                    'subcategoryDescription' => $subcategory->description,
                    'categoryId' => $category->id,
                    'categoryName' => $category->name
                ];
            }
            $this->view->addVar('subcategories', $subcategories);
            $this->view->addVar('preparedData', $preparedData);
            $this->view->render('subcategory/index.php');
        }
    }
     
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewSubcategory'])) {
                $Subcategory = new Subcategory();
                $newSubcategories = $Subcategory->loadFromArray($_POST);
                $newSubcategories->insert(); 
                $this->redirect($Url::link("admin/subcategories/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategories/index"));
            }
        }
        else {
            $Category = new Category();
            $categories = $Category->getList(10)['results'];
            $addSubcategoryTitle = "Добавление новой заметки";
            $this->view->addVar('addSubcategoryTitle', $addSubcategoryTitle);
            $this->view->addVar('categories', $categories);
            $this->view->render('subcategory/add.php');
        }
    }
    
    public function editAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        if (!empty($_POST)) {
            if (!empty($_POST['saveChanges'] )) {
                $Subcategory = new Subcategory();
                $newSubcategories = $Subcategory->loadFromArray($_POST);
                $newSubcategories->update();
                $this->redirect($Url::link("admin/subcategories/index&id=$id"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategories/index&id=$id"));
            }
        }
        else {
            $Subcategory = new Subcategory();
            $viewSubcategories = $Subcategory->getById($id);
            $Category = new Category();
            $categories = $Category->getList(10)['results']; // !!! ADD PAGINATION or idk
            $this->view->addVar('categories', $categories);
            $editSubcategoryTitle = "Редактирование заметки";
            $this->view->addVar('viewSubcategories', $viewSubcategories);
            $this->view->addVar('editSubcategoryTitle', $editSubcategoryTitle);
            $this->view->render('subcategory/edit.php');   
        }
        
    }
    
    public function deleteAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        if (!empty($_POST)) {
            if (!empty($_POST['deleteSubcategory'])) {
                $Subcategory = new Subcategory();
                $newSubcategories = $Subcategory->loadFromArray($_POST);
                $newSubcategories->id = $id;
                $newSubcategories->delete();
                $this->redirect($Url::link("admin/subcategories/index"));
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategories/edit&id=$id"));
            }
        }
        else {
            $Subcategory = new Subcategory();
            $deletedSubcategory = $Subcategory->getById($id);
            $deleteSubcategoryTitle = "Удалить заметку?";
            $this->view->addVar('deleteSubcategoryTitle', $deleteSubcategoryTitle);
            $this->view->addVar('deletedSubcategory', $deletedSubcategory);
            $this->view->render('subcategory/delete.php');
        }
    }   
}