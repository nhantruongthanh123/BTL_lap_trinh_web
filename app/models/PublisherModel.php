<?php
class PublisherModel extends BaseModel {
    protected $table = 'publishers';

    public function getAllPublishers(){
        $sql = "SELECT a.*, COUNT(b.book_id) as book_count
                FROM " . $this->table . " a
                LEFT JOIN books b ON a.publisher_id = b.publisher_id
                GROUP BY a.publisher_id
                ORDER BY a.publisher_name ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPublisherById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE publisher_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addPublisher($data){
        $sql = "INSERT INTO " . $this->table . " 
                (publisher_name, email, phone) 
                VALUES 
                (:name, :email, :phone)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $data['publisher_name']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':phone', $data['phone']);
        
        return $stmt->execute();
    }

    public function updatePublisher($id, $data){
        $sql = "UPDATE " . $this->table . " SET 
                publisher_name = :name, 
                email = :email, 
                phone = :phone 
                WHERE publisher_id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $data['publisher_name']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':phone', $data['phone']);
        $stmt->bindValue(':id', $id);
        
        return $stmt->execute();
    }

    public function deletePublisher($id){
        $sqlCheck = "SELECT COUNT(*) as count FROM books WHERE publisher_id = :id";
        $stmtCheck = $this->db->prepare($sqlCheck);
        $stmtCheck->bindValue(':id', $id, PDO::PARAM_INT);
        $stmtCheck->execute();
        $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            return false; 
        }

        $sql = "DELETE FROM " . $this->table . " WHERE publisher_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}