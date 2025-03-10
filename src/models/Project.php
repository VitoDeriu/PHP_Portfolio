<?php

namespace App\Models; 

use App\Config\Database;
use PDO;

class Project {
    
    protected $table = self::class;
    protected $pdo;

    public function __construct(string $table = ""){
        $this->table = $table;
        $this->pdo = Database::getPDO();
    }
    
    public function createProject($title, $description, $image, $link, $id_user){
        $table = $this->table;
        $sql = <<<sql
        INSERT INTO $table (title, description, image, link, id_user)
        VALUES(:title, :description, :image, :link, :id_user)
        sql;
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam("title", $title);
            $statement->bindParam("description", $description);
            $statement->bindParam("image", $image);
            $statement->bindParam("link", $link);
            $statement->bindParam("id_user", $id_user);
            $statement->execute();
            return $this->pdo->lastInsertId();
        } catch(Exception $e) {
            echo($e->getMessage());
            return false;
        }
    }

    //fonction find adaptative. il faut passer en parametre un tableau de critère et et de clé et ca construit la requete automatiquement avec les clé fourni
    public function find(array $criteria =[]) :array{
        $table = $this->table;
        $sql = "SELECT $table.*, users.pseudo FROM $table ";
        $sql .= "JOIN users ON $table.id_user = users.id";
        $params = [];

        if(!empty($criteria)){
            $condition =[];
            foreach ($criteria as $key => $value){
                $condition[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $sql .= " WHERE " . implode(" AND ", $condition);
        }

        $sql .= " ORDER BY $table.id DESC";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            echo($e->getMessage());
            return false;
        }

    }

    
    //TODO : Delete Project a vérifier chatgpt
    public function deleteProject(int $id): bool {
        $table = $this->table;
        $sql = "DELETE FROM $table WHERE $table.id = :id";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam("id", $id);
            return $statement->execute();
        } catch (Exception $e) {
            echo($e->getMessage());
            return false;
        }
    }
    







    //TODO : Update Project

    




}
?>
