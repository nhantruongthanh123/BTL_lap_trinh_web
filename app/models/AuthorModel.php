<?php
class AuthorModel extends BaseModel {
    protected $table = 'authors';

    public function getAllAuthors() {
        $sql = "SELECT a.*, COUNT(b.book_id) as book_count
                FROM " . $this->table . " a
                LEFT JOIN books b ON a.author_id = b.author_id
                GROUP BY a.author_id
                ORDER BY a.author_name ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAuthorById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE author_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addAuthor($data) {
        $sql = "INSERT INTO " . $this->table . " 
                (author_name, biography, birth_date, nationality) 
                VALUES 
                (:name, :bio, :birth, :nationality)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $data['author_name']);
        $stmt->bindValue(':bio', $data['biography']);
        $stmt->bindValue(':birth', $data['birth_date']);
        $stmt->bindValue(':nationality', $data['nationality']);
        
        return $stmt->execute();
    }

    public function updateAuthor($id, $data) {
        $sql = "UPDATE " . $this->table . " SET 
                author_name = :name, 
                biography = :bio, 
                birth_date = :birth, 
                nationality = :nationality 
                WHERE author_id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $data['author_name']);
        $stmt->bindValue(':bio', $data['biography']);
        $stmt->bindValue(':birth', $data['birth_date']);
        $stmt->bindValue(':nationality', $data['nationality']);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function deleteAuthor($id) {
        $sqlCheck = "SELECT COUNT(*) as count FROM books WHERE author_id = :id";
        $stmtCheck = $this->db->prepare($sqlCheck);
        $stmtCheck->bindValue(':id', $id, PDO::PARAM_INT);
        $stmtCheck->execute();
        $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            return false; 
        }

        $sql = "DELETE FROM " . $this->table . " WHERE author_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}