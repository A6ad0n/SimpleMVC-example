<?php
namespace application\models;
/* 
 * class Note
 * 
 * 
 */

class Note extends \ItForFree\SimpleMVC\MVC\Model {
    
    public string $tableName = "articles";
    
    public string $orderBy = 'publicationDate ASC';
    
    public ?int $id = null;
    
    public $title = null;

    public $summary = null;
    
    public $content = null;
    
    public $publicationDate = null;

    public $categoryId = null;

    public $subcategoryId = null;

    public $active = null;

    public $authors = array();
    
    
    public function insert()
    {
        if ( !is_null( $this->id ) ) trigger_error ( "Article::insert(): Attempt to insert an Article object that already has its ID property set (to $this->id).", E_USER_ERROR );

        if (!isset($this->subcategoryId) || $this->subcategoryId == '') {
            $sql = "INSERT INTO articles ( publicationDate, categoryId, title, summary, content, active ) 
                VALUES ( :publicationDate, :categoryId, :title, :summary, :content, :active )";
            $st = $this->pdo->prepare ( $sql );
            $st->bindValue( ":publicationDate", (new \DateTime('NOW'))->format('Y-m-d H:i:s'), \PDO::PARAM_STMT );
            $st->bindValue( ":categoryId", $this->categoryId, \PDO::PARAM_INT );
            $st->bindValue( ":title", $this->title, \PDO::PARAM_STR );
            $st->bindValue( ":summary", $this->summary, \PDO::PARAM_STR );
            $st->bindValue( ":content", $this->content, \PDO::PARAM_STR );
            $st->bindValue( ":active", $this->active, \PDO::PARAM_INT );
        } else {
            $sql = "INSERT INTO articles ( publicationDate, categoryId, subcategoryId, title, summary, content, active ) 
                VALUES ( :publicationDate, :categoryId, :subcategoryId, :title, :summary, :content, :active )";
            $st = $this->pdo->prepare ( $sql );
            $st->bindValue( ":publicationDate", (new \DateTime('NOW'))->format('Y-m-d H:i:s'), \PDO::PARAM_STMT );
            $st->bindValue( ":categoryId", $this->categoryId, \PDO::PARAM_INT );
            $st->bindValue( ":subcategoryId", $this->subcategoryId, \PDO::PARAM_INT );
            $st->bindValue( ":title", $this->title, \PDO::PARAM_STR );
            $st->bindValue( ":summary", $this->summary, \PDO::PARAM_STR );
            $st->bindValue( ":content", $this->content, \PDO::PARAM_STR );
            $st->bindValue( ":active", $this->active, \PDO::PARAM_INT );
        }
        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }
    
    public function update()
    {
      if ( is_null( $this->id ) ) trigger_error ( "Article::update(): "
              . "Attempt to update an Article object "
              . "that does not have its ID property set.", E_USER_ERROR );

      if (!isset($this->subcategoryId) || $this->subcategoryId == '') {
        $sql = "UPDATE articles SET publicationDate=:publicationDate,"
                . " categoryId=:categoryId, title=:title, summary=:summary, active=:active, "
                . " content=:content WHERE id = :id";
        
        $st = $this->pdo->prepare ( $sql );
        $st->bindValue( ":publicationDate", $this->publicationDate, \PDO::PARAM_STMT );
        $st->bindValue( ":categoryId", $this->categoryId,\PDO::PARAM_INT );
        $st->bindValue( ":title", $this->title,\PDO::PARAM_STR );
        $st->bindValue( ":summary", $this->summary,\PDO::PARAM_STR );
        $st->bindValue( ":content", $this->content,\PDO::PARAM_STR );
        $st->bindValue( ":id", $this->id,\PDO::PARAM_INT );
        $st->bindValue( ":active", $this->active,\PDO::PARAM_INT );
      } else {
        $sql = "UPDATE articles SET publicationDate=:publicationDate,"
                . " categoryId=:categoryId, subcategoryId=:subcategoryId, title=:title, summary=:summary, active=:active, "
                . " content=:content WHERE id = :id";
        
        $st = $this->pdo->prepare ( $sql );
        $st->bindValue( ":publicationDate", $this->publicationDate, \PDO::PARAM_STMT );
        $st->bindValue( ":categoryId", $this->categoryId,\PDO::PARAM_INT );
        $st->bindValue( ":subcategoryId", $this->subcategoryId,\PDO::PARAM_INT );
        $st->bindValue( ":title", $this->title,\PDO::PARAM_STR );
        $st->bindValue( ":summary", $this->summary,\PDO::PARAM_STR );
        $st->bindValue( ":content", $this->content,\PDO::PARAM_STR );
        $st->bindValue( ":id", $this->id,\PDO::PARAM_INT );
        $st->bindValue( ":active", $this->active,\PDO::PARAM_INT );
      }
      $st->execute();

      $this->saveAuthors();
    }

    public function getAuthors($articleId) {
        $sql = "SELECT u.* 
                FROM users u 
                INNER JOIN article_authors aa ON u.id = aa.authorId 
                WHERE aa.articleId = :articleId 
                ORDER BY u.username";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":articleId", $articleId,\PDO::PARAM_INT);
        $st->execute();
        $authors = array();
        while ( $row = $st->fetch() ) {
            $authors[] = new UserModel($row);
        }
        return $authors;
    }

    public function loadAuthors() {
        $sql = "SELECT u.* 
                FROM users u 
                INNER JOIN article_authors aa ON u.id = aa.authorId 
                WHERE aa.articleId = :articleId";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":articleId", $this->id,\PDO::PARAM_INT);
        $st->execute();
        $this->authors = array();
        while ( $row = $st->fetch() ) {
            $this->authors[] = new UserModel($row);
        }
    }

    public function saveAuthors() {
        $this->deleteAuthors();

        if (!empty($this->authors)) {
            $sql = "INSERT INTO article_authors (articleId, authorId) VALUES ";
            $values = array();
            $params = array();

            foreach ($this->authors as $index => $authorId) {
                $values[] = "(:articleId, :authorId$index)";
                $params[":authorId$index"] = (int)$authorId;
            }

            $sql .= implode(", ", $values);
            $st = $this->pdo->prepare($sql);
            $st->bindValue(":articleId", $this->id,\PDO::PARAM_INT);

            foreach ($params as $key => $value) {
                $st->bindValue($key, $value,\PDO::PARAM_INT);
            }

            $st->execute();
        }
    }

    public function deleteAuthors() {
        if ($this->id) {
            $sql = "DELETE FROM article_authors WHERE articleId = :articleId";
            $st = $this->pdo->prepare($sql);
            $st->bindValue(":articleId", $this->id, \PDO::PARAM_INT);
            $st->execute();
        }
    }

    public function delete(): void {
        $this->deleteAuthors();
        parent::delete();
    }
}

