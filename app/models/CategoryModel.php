<?php
class CategoryModel extends BaseModel {
    protected $table = 'categories';

    public function getAllCategories(){
        try {
            $sql = "SELECT category_id, category_name, slug FROM {$this->table} WHERE is_active = 1 ORDER BY category_name ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getAllCategories: " . $e->getMessage());
            return [];
        }
    }
}