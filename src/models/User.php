<?php

namespace App\Models; 

use App\Config\Database;
use PDO;

class User {

    protected $table = self::class;
    protected $pdo;

    //pourquoi on demande le nom de la table alors que c'est forcement dans la table users qu'on va taper ??
    public function __construct(string $table = ""){
        $this->table = $table;
        $this->pdo = Database::getPDO();
    }

    //chercher un user dans la bdd select * from user where email = :email
    public function findByEmail(string $email): array | bool{
        $table = $this->table;
        $sql = <<<sql
        SELECT *
        FROM $table
        WHERE email = :email        
        sql;
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':email', $email);
            $statement->execute(); 
            return $statement->fetch(PDO::FETCH_ASSOC); 
        } catch (Exception $e) {
            echo($e->getMessage());
            return false;
        }
    }

    //créer un user dans la bdd (à ameliorer)
    public function createUser(string $firstname, string $lastname, string $pseudo, string $email, string $password ): array | bool {
        $table = $this->table;
        $role = 2;  //ca jsuis pas sur de la sécu...
        $sql = <<<sql
        INSERT INTO $table(firstname, lastname, pseudo, email, password, id_role)
        VALUES(:firstname, :lastname, :pseudo, :email, :password, :id_role)
        sql;
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam("firstname", $firstname);
            $statement->bindParam("lastname", $lastname);
            $statement->bindParam("pseudo", $pseudo);
            $statement->bindParam("email", $email);
            $statement->bindParam("password", $password);
            $statement->bindParam("id_role", $role); //du coup ici non plus mais j'ai pas trouvé mieux, a voir dans le create du sql si on peut pas faire un par défaut
            $statement->execute();
            return $this->pdo->lastInsertId();
        } catch(Exception $e) {
            echo($e->getMessage());
            return false;
        }
    }
    
    //TODO : fonction deleteUser

    //TODO : fonction updateUser (un peu tricky celle la je pense)

    //Stocker le token de connexion rememberme dans l'utilisateur
    public function updateRememberMe(string $token, int $user_id){
        $table = $this->table;
        $sql = <<<sql
            UPDATE $table 
            SET remember_token = :token 
            WHERE id = :id
        sql;
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':token', $token);
            $statement->bindParam(':id', $user_id);
            $statement->execute(); 
            return $statement->rowCount();
        } catch(Exception $e) {
            echo($e->getMessage());
            return false;
        }
    }

    //retrouver les infos de session grace au token remember me
    public function findByToken(string $token): array | bool {
        $table = $this->table;
        $sql = <<<sql
            SELECT * 
            FROM $table
            WHERE remember_token = :token
        sql;
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':token', $token);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch(Exception $e) {
            echo($e->getMessage());
            return false;
        }
    }
}
?>