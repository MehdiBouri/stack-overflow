<?php

namespace App\Model;

use PDO;
use App\database\Database;
use DateTime;

class QuestionModel
{

    protected $id;

    protected $title;

    protected $content;

    protected $status;

    protected $technology;

    protected $createdAt;

    protected $updatedAt;

    protected $userId;

    protected $pdo;

    const TABLE_NAME = 'questions';

    const PAGE = 10;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getPDO();

    }

    #Récupérer toutes les questions
    public function findAll($title = '', $order = 'DESC', $admin = false)
    {
        if ($title) {
            $sqlTitle = ' title LIKE :sqlValueTitle OR technology LIKE :sqlValueTitle ';
        }
        else {
            $sqlTitle = '';
        }

        if (!$admin) {
            $sqlAdmin = " status != 'moderated'";

            if ($title) {
                $sqlAdmin = ' AND '.$sqlAdmin;
            }
        }
        else {
            $sqlAdmin = '';
        }

        if ($title || !$admin) {
            $sqlWhere = ' WHERE ';
        }
        else {
            $sqlWhere = '';
        }

        $sql = 'SELECT
                `id`
                ,`title`
                ,`content`
                ,`status`
                ,`technology`
                ,`created_at`
                ,`user_id`
                FROM ' . self::TABLE_NAME . $sqlWhere . $sqlTitle . $sqlAdmin.'
                ORDER BY `created_at` '.$order;
        
                
        $pdoStatement = $this->pdo->prepare($sql);
        if ($title) {
            $pdoStatement->bindValue('sqlValueTitle', '%'.$title.'%', PDO::PARAM_STR);
        }
        $result = $pdoStatement->execute();


        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        foreach($result as $r) {
            $r->setCreatedAt($r->created_at);
            $r->setUserId($r->user_id);
        }

        return $result;
    }


    #Récupérer toutes les questions par page
    public function findByPage($page = 1)
    {
        $pageDebut = ($page - 1) * self::PAGE;

        $sql = 'SELECT
                `id`
                ,`title`
                ,`content`
                ,`status`
                ,`technology`
                ,`created_at`
                ,`user_id`
                FROM ' . self::TABLE_NAME . '
                ORDER BY `id` ASC
                LIMIT '.$pageDebut.', '.self::PAGE;

        $pdoStatement = $this->pdo->query($sql);
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $result;
    }


    public function countPage()
    {
        $sql = 'SELECT
                count(*) AS count
                FROM ' . self::TABLE_NAME;

        $pdoStatement = $this->pdo->query($sql);
        $result = $pdoStatement->fetch();
        
        return ceil($result['count'] / self::PAGE);
    }

    #Pour trouver une question par son ID
    public function findById($id)
    {
        $sql = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = '.$id;

        $pdoStatement = $this->pdo->query($sql);
        $question = $pdoStatement->fetchObject(self::class);
        $question->setCreatedAt($question->created_at);
        $question->setUserId($question->user_id);
        
        return $question;
    }

    #Pour ajouter une nouvelle question dans la base de données
    public function create($title, $content, $technology, $userId)
    {
        $sql = 'INSERT INTO ' . self::TABLE_NAME . '
                (`title`, `content`, `technology`, `user_id`)
                VALUES
                (:title, :content, :technology, :user_id)
        ';

        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->bindValue(':title', $title, PDO::PARAM_STR);
        $pdoStatement->bindValue(':content', $content, PDO::PARAM_STR);
        $pdoStatement->bindValue(':technology', $technology, PDO::PARAM_STR);
        $pdoStatement->bindValue(':user_id', $userId, PDO::PARAM_INT);


        $result = $pdoStatement->execute();
        
        if (!$result) {
            return false;
        }

        return $this->pdo->lastInsertId();
    }


    #Clôturer une question
    public function close($id)
    {
        $sql = 'UPDATE '.self::TABLE_NAME.'
        SET status = "closed"
        WHERE id = '.$id;
        
        $pdoStatement = $this->pdo->prepare($sql);
        $result = $pdoStatement->execute();
        
        return $result;
    }

    #Réouvrir une question
    public function publish($id)
    {
        $sql = 'UPDATE '.self::TABLE_NAME.'
        SET status = "published"
        WHERE id = '.$id;
        
        $pdoStatement = $this->pdo->prepare($sql);
        $result = $pdoStatement->execute();
        
        return $result;
    }

    #Modérer/masquer une question
    public function moderate($id)
    {
        $sql = 'UPDATE '.self::TABLE_NAME.'
        SET status = "moderated"
        WHERE id = '.$id;
        
        $pdoStatement = $this->pdo->prepare($sql);
        $result = $pdoStatement->execute();
        
        return $result;
    }
    
    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of technology
     */ 
    public function getTechnology()
    {
        return $this->technology;
    }

    /**
     * Set the value of technology
     *
     * @return  self
     */ 
    public function setTechnology($technology)
    {
        $this->technology = $technology;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getCreatedAtFormat()
    {
        return $this->createdAt->format('d/m/Y H:i');
    }
    

    /**
     * Set the value of createdAt
     *
     * @return  self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = new DateTime($createdAt);

        return $this;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId(int $userId)
    {
        $this->userId = $userId;

        return $this;
    }
}
