<?php
class ProductModel extends BaseModel {
    protected $table = 'books';

    public function getAllProducts() {
        $sql = "SELECT b.*, a.author_name, c.category_name
                FROM {$this->table} b
                LEFT JOIN authors a ON b.author_id = a.author_id
                LEFT JOIN categories c ON b.category_id = c.category_id
                WHERE b.is_active = 1 
                ORDER BY b.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsByCategory($slug) {
        $sql = "SELECT b.*, a.author_name, c.category_name, c.slug as category_slug
                FROM {$this->table} b
                INNER JOIN categories c ON b.category_id = c.category_id
                LEFT JOIN authors a ON b.author_id = a.author_id
                WHERE c.slug = :slug AND b.is_active = 1
                ORDER BY b.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookById($bookId) {
        $sql = "SELECT b.*, 
                        c.category_name, c.slug as category_slug,
                        a.author_name, a.biography as author_bio,
                        p.publisher_name
                FROM {$this->table} b
                LEFT JOIN categories c ON b.category_id = c.category_id
                LEFT JOIN authors a ON b.author_id = a.author_id
                LEFT JOIN publishers p ON b.publisher_id = p.publisher_id
                WHERE b.book_id = :book_id AND b.is_active = 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRelatedBooks($categoryId, $currentBookId, $limit = 4) {
        $sql = "SELECT book_id, title, cover_image, price, discount_price
                FROM {$this->table}
                WHERE category_id = :category_id 
                AND book_id != :current_book_id 
                AND is_active = 1
                ORDER BY RAND()
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':current_book_id', $currentBookId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}