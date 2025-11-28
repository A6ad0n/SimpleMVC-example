<?php
namespace application\controllers\admin;
use application\models\Note;
use application\models\UserModel;
use application\models\Category;
use application\models\Subcategory;
use ItForFree\SimpleMVC\Config;

/* 
 *   Class-controller notes
 * 
 * 
 */

class NotesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    
    public string $layoutPath = 'admin-main.php';

    protected array $rules = [ //вариант 2:  здесь всё гибче, проще развивать в дальнешем
         ['allow' => true, 'roles' => ['admin']],
         ['allow' => false, 'roles' => ['?', '@']],
    ];
    
    public function indexAction()
    {
        $Note = new Note();
        $Category = new Category();
        $Subcategory = new Subcategory();

        $noteId = $_GET['id'] ?? null;
        
        if ($noteId) { // если указан конктреный пользователь
            $viewNotes = $Note->getById($_GET['id']);
            $viewNotes->loadAuthors();
            $category = $Category->getById($viewNotes->categoryId);
            if ($viewNotes->subcategoryId)
                $subcategory = $Subcategory->getById($viewNotes->subcategoryId);
            $this->view->addVar('category', $category);
            $this->view->addVar('subcategory', $subcategory);
            $this->view->addVar('viewNotes', $viewNotes);
            $this->view->render('note/view-item.php');
        } else { // выводим полный список
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
                    'notePublicationDate' => $note->publicationDate,
                    'noteActive' => $note->active,
                    'noteAuthors' => $note->authors
                ];
            }
            $this->view->addVar('preparedData', $preparedData);
            $this->view->render('note/index.php');
        }
    }
    
    /**
     * Выводит на экран форму для создания новой статьи (только для Администратора)
     */
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewNote'])) {
                $Note = new Note();
                $newNotes = $Note->loadFromArray($_POST);
                $newNotes->insert(); 
                $newNotes->authors = $_POST['authors'];
                $newNotes->saveAuthors();
                $this->redirect($Url::link("admin/notes/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/notes/index"));
            }
        }
        else {
            $Category = new Category();
            $Subcategory = new Subcategory();
            $User = new UserModel();
            $categories = $Category->getList(10)['results'];
            $subcategories = $Subcategory->getList(10)['results'];
            $users = $User->getList(10)['results'];
            $this->view->addVar('categories', $categories);
            $this->view->addVar('subcategories', $subcategories);
            $this->view->addVar('users', $users);


            $addNoteTitle = "Добавление новой заметки";
            $this->view->addVar('addNoteTitle', $addNoteTitle);
            
            $this->view->render('note/add.php');
        }
    }
    
    /**
     * Выводит на экран форму для редактирования статьи (только для Администратора)
     */
    public function editAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) { // это выполняется нормально.
            
            if (!empty($_POST['saveChanges'] )) {
                $Note = new Note();
                $newNotes = $Note->loadFromArray($_POST);
                $newNotes->update();
                $this->redirect($Url::link("admin/notes/index&id=$id"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/notes/index&id=$id"));
            }
        }
        else {
            $Note = new Note();
            $viewNotes = $Note->getById($id);
            $viewNotes->loadAuthors();
            $Category = new Category();
            $Subcategory = new Subcategory();
            $User = new UserModel();
            $categories = $Category->getList(10)['results'];
            $subcategories = $Subcategory->getList(10)['results'];
            $users = $User->getList(10)['results'];
            $this->view->addVar('categories', $categories);
            $this->view->addVar('subcategories', $subcategories);
            $this->view->addVar('users', $users);
            
            $editNoteTitle = "Редактирование заметки";
            
            $this->view->addVar('viewNotes', $viewNotes);
            $this->view->addVar('editNoteTitle', $editNoteTitle);
            
            $this->view->render('note/edit.php');   
        }
        
    }
    
    /**
     * Выводит на экран предупреждение об удалении данных (только для Администратора)
     */
    public function deleteAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) {
            if (!empty($_POST['deleteNote'])) {
                $Note = new Note();
                $newNotes = $Note->loadFromArray($_POST);
                $newNotes->delete();
                
                $this->redirect($Url::link("admin/notes/index"));
              
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/notes/edit&id=$id"));
            }
        }
        else {
            
            $Note = new Note();
            $deletedNote = $Note->getById($id);
            $deleteNoteTitle = "Удалить заметку?";
            
            $this->view->addVar('deleteNoteTitle', $deleteNoteTitle);
            $this->view->addVar('deletedNote', $deletedNote);
            
            $this->view->render('note/delete.php');
        }
    }
    
    
}