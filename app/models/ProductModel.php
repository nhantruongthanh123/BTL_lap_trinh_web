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

    public function getProductsPaginated($limit = 12, $offset) {
        $sql = "SELECT b.*, a.author_name, c.category_name
                FROM {$this->table} b
                LEFT JOIN authors a ON b.author_id = a.author_id
                LEFT JOIN categories c ON b.category_id = c.category_id
                WHERE b.is_active = 1 
                ORDER BY b.created_at DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsByCategoryPaginated($slug, $limit = 8, $offset) {
        $sql = "SELECT b.*, a.author_name, c.category_name, c.slug as category_slug
                FROM {$this->table} b
                INNER JOIN categories c ON b.category_id = c.category_id
                LEFT JOIN authors a ON b.author_id = a.author_id
                WHERE c.slug = :slug AND b.is_active = 1
                ORDER BY b.created_at DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
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

    public function searchBooks($keyword, $limit = 12) {
        $sql = "SELECT b.*, a.author_name, c.category_name
                FROM {$this->table} b
                LEFT JOIN authors a ON b.author_id = a.author_id
                LEFT JOIN categories c ON b.category_id = c.category_id
                WHERE b.is_active = 1 
                AND (
                    b.title LIKE :keyword1 
                    OR a.author_name LIKE :keyword2
                    OR b.isbn LIKE :keyword3
                    OR b.description LIKE :keyword4
                )
                ORDER BY b.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $keyword = trim($keyword);
        $searchTerm = '%' . $keyword . '%';
        $stmt->bindValue(':keyword1', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':keyword2', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':keyword3', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':keyword4', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct($data){
        if (empty($data['discount_price']) || $data['discount_price'] <= 0) {
            $data['discount_price'] = $data['price'];
        }

        $sql = "INSERT INTO " . $this->table . " 
                (title, author_id, category_id, price, discount_price, stock_quantity, description, cover_image, isbn, publisher_id, is_active, is_featured, created_at) 
                VALUES 
                (:title, :author_id, :category_id, :price, :discount_price, :stock_quantity, :description, :cover_image, :isbn, :publisher_id, :is_active, :is_featured, :created_at)";
        
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':title', $data['title']);
        $stmt->bindValue(':author_id', $data['author_id']); 
        $stmt->bindValue(':category_id', $data['category_id'], PDO::PARAM_INT);          
        $stmt->bindValue(':price', $data['price']);                      
        $stmt->bindValue(':discount_price', $data['discount_price']);                   
        $stmt->bindValue(':stock_quantity', $data['stock_quantity'], PDO::PARAM_INT);   
        $stmt->bindValue(':description', $data['description']);                         
        $stmt->bindValue(':cover_image', $data['cover_image']);                          
        $stmt->bindValue(':isbn', $data['isbn']);
        $stmt->bindValue(':publisher_id', $data['publisher_id'], PDO::PARAM_INT);
        $stmt->bindValue(':is_active', $data['is_active'], PDO::PARAM_INT);
        $stmt->bindValue(':is_featured', $data['is_featured'], PDO::PARAM_INT);
        $stmt->bindValue(':created_at', $data['created_at']);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    public function updateProduct($id, $data) {
        $sql = "UPDATE " . $this->table . " SET 
                title = :title, 
                author_id = :author,
                category_id = :category, 
                price = :price, 
                discount_price = :discount, 
                stock_quantity = :stock, 
                description = :desc,
                isbn = :isbn,
                updated_at = :updated_at,
                publisher_id = :publisher_id,
                is_active = :is_active,
                is_featured = :is_featured";
        
        if (!empty($data['cover_image'])) {
            $sql .= ", cover_image = :image";
        }
        
        $sql .= " WHERE book_id = :id";
                
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue(':title', $data['title']);
        $stmt->bindValue(':author', $data['author_id']); 
        $stmt->bindValue(':category', $data['category_id']);
        $stmt->bindValue(':price', $data['price']);
        $stmt->bindValue(':discount', $data['discount_price'] ?? 0);
        $stmt->bindValue(':stock', $data['stock_quantity']);
        $stmt->bindValue(':desc', $data['description']);
        $stmt->bindValue(':isbn', $data['isbn'] ?? null);
        $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'));
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':publisher_id', $data['publisher_id']);
        $stmt->bindValue(':is_active', $data['is_active']);
        $stmt->bindValue(':is_featured', $data['is_featured']);
        
        if (!empty($data['cover_image'])) {
            $stmt->bindValue(':image', $data['cover_image']);
        }
        
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $sql = "UPDATE " . $this->table . " SET is_active = 0 WHERE book_id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function getProductByIdAdmin($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE book_id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllProductsAdmin($limit = null, $offset = null) {
        $sql = "SELECT b.*, c.category_name, COALESCE(SUM(oi.quantity), 0) as total_sold
                FROM " . $this->table . " b
                LEFT JOIN categories c ON b.category_id = c.category_id
                LEFT JOIN order_items oi ON b.book_id = oi.book_id
                LEFT JOIN orders o ON oi.order_id = o.order_id 
                GROUP BY b.book_id
                ORDER BY b.book_id DESC"; 

        if ($limit !== null && $offset !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }
        
        $stmt = $this->db->prepare($sql);

        if ($limit !== null && $offset !== null) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllProducts() {
        $sql = "SELECT COUNT(*) as total FROM " . $this->table;
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['total'] : 0;
    }

    public function countProductsByCategory($slug) {
        $sql = "SELECT COUNT(*) as total 
                FROM {$this->table} b
                INNER JOIN categories c ON b.category_id = c.category_id
                WHERE c.slug = :slug AND b.is_active = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function decreaseStock($bookId, $quantity) {
        $sql = "UPDATE books 
                SET stock_quantity = stock_quantity - :quantity 
                WHERE book_id = :book_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}