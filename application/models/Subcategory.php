<?php
namespace application\models;

class Subcategory extends \ItForFree\SimpleMVC\MVC\Model
{
    public string $tableName = "subcategories";
    public string $orderBy = 'name ASC';

    public ?int $id = null;

    public $name = null;

    public $description = null;

    public $categoryId = null;

    public function insert() {
      if ( !is_null( $this->id ) ) trigger_error ( "Subcategory::insert(): Attempt to insert a Category object that already has its ID property set (to $this->id).", E_USER_ERROR );
      $sql = "INSERT INTO subcategories ( name, description, categoryId ) VALUES ( :name, :description, :categoryId )";
      $st = $this->pdo->prepare ( $sql );
      $st->bindValue( ":name", $this->name, \PDO::PARAM_STR );
      $st->bindValue( ":description", $this->description, \PDO::PARAM_STR );
      $st->bindValue( ":categoryId", $this->categoryId, \PDO::PARAM_INT);
      try {
        $st->execute();
        $this->id = $this->pdo->lastInsertId(); 
      } catch (\PDOException $e) {
        if ($e->errorInfo[1] == 1452) {
          trigger_error ( "Subcategory::insert(): Foreign key constraint violations - " . $e->getMessage(), E_USER_WARNING);
          return;
        } else {
          throw $e;
        }
      }
      
    }

    public function update() {
      if ( is_null( $this->id ) ) trigger_error ( "Subcategory::update(): Attempt to update a Category object that does not have its ID property set.", E_USER_ERROR );
      $sql = "UPDATE subcategories SET name=:name, description=:description, categoryId=:categoryId WHERE id = :id";
      $st = $this->pdo->prepare ( $sql );
      $st->bindValue( ":name", $this->name, \PDO::PARAM_STR );
      $st->bindValue( ":description", $this->description, \PDO::PARAM_STR );
      $st->bindValue( ":categoryId", $this->categoryId, \PDO::PARAM_INT );
      $st->bindValue( ":id", $this->id, \PDO::PARAM_INT );
      try {
        $st->execute();
      } catch (\PDOException $e) {
        if ($e->errorInfo[1] == 1452) {
          trigger_error ( "Subcategory::update(): Foreign key constraint violations - " . $e->getMessage(), E_USER_WARNING);
          
          return;
        } else {
          throw $e;
        }
      } 
    }
}
	  
	

