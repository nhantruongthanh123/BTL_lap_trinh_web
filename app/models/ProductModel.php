<?php
class ProductModel extends BaseModel {
    protected $_table = 'books';
    public function getAllProducts() {
        $sql = "SELECT * FROM " . $this->_table . " WHERE is_active = 1 ORDER BY created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsByCategory($slug) {
        $sql = "SELECT books.* FROM books 
            INNER JOIN categories ON books.category_id = categories.category_id 
            WHERE categories.slug = ? AND books.is_active = 1";
            
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$slug]); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

}