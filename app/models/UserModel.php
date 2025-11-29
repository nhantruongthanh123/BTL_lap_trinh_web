<?php
class UserModel extends BaseModel {
    protected $table = 'users';

    public function register($data) {
        $sql = "INSERT INTO " . $this->table . " (username, email, password_hash, full_name) 
                VALUES (:username, :email, :password_hash, :full_name)";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue(':username', $data['username']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':full_name', $data['full_name']);
        $stmt->bindValue(':password_hash', $data['password_hash']); 

        return $stmt->execute(); 
    }

    public function findUserByEmail($email) {
        $sql = "SELECT user_id, username, email, password_hash, role, full_name
                FROM " . $this->table . " 
                WHERE email = :email AND is_active = 1";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findUserByUsername($username) {
        $sql = "SELECT user_id, username, email, password_hash, role, full_name
                FROM " . $this->table . " 
                WHERE username = :username AND is_active = 1";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isEmailExists($email) {
        $sql = "SELECT COUNT(*) FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn();
    }


}