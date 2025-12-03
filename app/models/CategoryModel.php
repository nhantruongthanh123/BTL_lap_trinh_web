<?php
class CategoryModel extends BaseModel {
    protected $table = 'categories';

    public function getAllCategories(){
        $sql = "SELECT c.category_id, c.category_name, c.slug, c.is_active, c.description, 
                       COUNT(b.book_id) as book_count
                FROM {$this->table} c
                LEFT JOIN books b ON c.category_id = b.category_id
                GROUP BY c.category_id
                ORDER BY c.category_name ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCategory($data){
        $sql = "INSERT INTO {$this->table} (category_name, slug, is_active, description) VALUES (:category_name, :slug, :is_active, :description)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':category_name' => $data['category_name'],
            ':slug' => $data['slug'],
            ':is_active' => $data['is_active'],
            ':description' => $data['description']
        ]);
    }

    public function updateCategory($category_id, $data){
        $sql = "UPDATE {$this->table} SET category_name = :category_name, slug = :slug, is_active = :is_active, description = :description WHERE category_id = :category_id";
        $stmt = $this->db->prepare($sql);
        $data[':category_id'] = $category_id;
        return $stmt->execute([
            ':category_name' => $data['category_name'],
            ':slug' => $data['slug'],
            ':is_active' => $data['is_active'],
            ':description' => $data['description'],
            ':category_id' => $category_id
        ]);
    }

    public function deleteCategory($category_id){
        $sql = "UPDATE {$this->table} SET is_active = 0 WHERE category_id = :category_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':category_id' => $category_id]);
    }

    public function getCategoryBySlug($slug) {
        $sql = "SELECT * FROM " . $this->table . " WHERE slug = :slug";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}