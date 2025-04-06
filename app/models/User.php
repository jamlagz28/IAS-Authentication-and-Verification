<?php

namespace App\Models;

use Core\BaseModel;
use PDO;


class User extends BaseModel
{

    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function emailExists($email)
    {
        $query = "SELECT id FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function createUser($name, $email, $password, $verificationCode)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (name, email, password,verification_code) VALUES (?, ?, ?,?)");
        return $stmt->execute([$name, $email, $password, $verificationCode]);
    }
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt =$this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        return $user ? $user : null;
    }
    public function getUsers()
    {
        return $this->getAll();
    }

    public function getUserById($id)
    {
        return $this->getById($id);
    }

    public function updateUser($id, $data)
    {
        $setClause = [];
        $values = [];
    
        foreach ($data as $key => $value) {
            $setClause[] = "$key = ?";
            $values[] = $value;
        }
    
        $setClause = implode(", ", $setClause);
        $sql = "UPDATE {$this->table} SET $setClause WHERE id = ?";
    
        $values[] = $id;
    
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }
    

    public function deleteUser($id)
    {
        return $this->delete($id);
    }
}
