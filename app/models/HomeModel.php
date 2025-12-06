<?php

class HomeModel extends BaseModel {
    protected $table = 'books';

    public function getListBooks($limit = 8){
        $sql = "SELECT b.*, a.author_name, c.category_name
                FROM {$this->table} b
                LEFT JOIN authors a ON b.author_id = a.author_id
                LEFT JOIN categories c ON b.category_id = c.category_id
                WHERE b.is_active = 1 AND b.is_featured = 1
                ORDER BY b.created_at DESC 
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}