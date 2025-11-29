<?php

class HomeModel extends BaseModel {
    protected $table = 'books';

    public function getListBooks($limit = 10){
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}