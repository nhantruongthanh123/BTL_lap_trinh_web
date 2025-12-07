<?php
class ReviewModel extends BaseModel {
    protected $table = 'reviews';

    public function getReviewById($reviewId) {
        $sql = "SELECT * FROM {$this->table} WHERE review_id = :review_id LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':review_id', (int)$reviewId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getReviewsByBookId($bookId, $limit = 10, $offset = 0) {
        $sql = "SELECT r.*, u.full_name, u.avatar 
                FROM {$this->table} r
                LEFT JOIN users u ON r.user_id = u.user_id
                WHERE r.book_id = :book_id AND r.is_approved = 1
                ORDER BY r.created_at DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':book_id', (int)$bookId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đếm tổng số reviews của một sách
    public function countReviewsByBookId($bookId) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} 
                WHERE book_id = :book_id AND is_approved = 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':book_id', (int)$bookId, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Lấy thống kê rating của một sách
    public function getBookRatingStats($bookId) {
        $sql = "SELECT 
                    COUNT(*) as total_reviews,
                    AVG(rating) as average_rating,
                    SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as five_star,
                    SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as four_star,
                    SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as three_star,
                    SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as two_star,
                    SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as one_star
                FROM {$this->table}
                WHERE book_id = :book_id AND is_approved = 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':book_id', (int)$bookId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Kiểm tra user đã review sách này chưa
    public function hasUserReviewed($bookId, $userId) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} 
                WHERE book_id = :book_id AND user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':book_id', (int)$bookId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', (int)$userId, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    // Kiểm tra user đã mua sách này chưa (verified purchase)
    public function hasUserPurchased($bookId, $userId) {
        $sql = "SELECT COUNT(*) as count 
                FROM order_items oi
                INNER JOIN orders o ON oi.order_id = o.order_id
                WHERE oi.book_id = :book_id 
                AND o.user_id = :user_id 
                AND o.status IN ('delivered', 'confirmed')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':book_id', (int)$bookId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', (int)$userId, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    // Thêm review mới
    public function addReview($data) {
        $sql = "INSERT INTO {$this->table} 
                (book_id, user_id, rating, comment, is_verified_purchase) 
                VALUES (:book_id, :user_id, :rating, :comment, :is_verified_purchase)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':book_id', (int)$data['book_id'], PDO::PARAM_INT);
        $stmt->bindValue(':user_id', (int)$data['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':rating', (int)$data['rating'], PDO::PARAM_INT);
        $stmt->bindValue(':comment', $data['comment'], PDO::PARAM_STR);
        $stmt->bindValue(':is_verified_purchase', (int)$data['is_verified_purchase'], PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Cập nhật review
    public function updateReview($reviewId, $userId, $data) {
        $sql = "UPDATE {$this->table} 
                SET rating = :rating, comment = :comment, updated_at = NOW()
                WHERE review_id = :review_id AND user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':rating', (int)$data['rating'], PDO::PARAM_INT);
        $stmt->bindValue(':comment', $data['comment'], PDO::PARAM_STR);
        $stmt->bindValue(':review_id', (int)$reviewId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', (int)$userId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Xóa review
    public function deleteReview($reviewId, $userId) {
        $sql = "DELETE FROM {$this->table} 
                WHERE review_id = :review_id AND user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':review_id', (int)$reviewId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', (int)$userId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Lấy review của user cho sách cụ thể
    public function getUserReviewForBook($bookId, $userId) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE book_id = :book_id AND user_id = :user_id LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':book_id', (int)$bookId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', (int)$userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBooksWithReviews() {
        $sql = "SELECT 
                    b.book_id,
                    b.title,
                    b.cover_image,
                    a.author_name,
                    c.category_name,
                    COUNT(r.review_id) as total_reviews,
                    AVG(r.rating) as average_rating,
                    SUM(CASE WHEN r.is_approved = 0 THEN 1 ELSE 0 END) as pending_reviews
                FROM books b
                INNER JOIN reviews r ON b.book_id = r.book_id
                LEFT JOIN authors a ON b.author_id = a.author_id
                LEFT JOIN categories c ON b.category_id = c.category_id
                GROUP BY b.book_id
                ORDER BY total_reviews DESC, b.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Phân trang sách có reviews
    public function getBooksWithReviewsPaginated($limit, $offset) {
        $sql = "SELECT 
                    b.book_id,
                    b.title,
                    b.cover_image,
                    a.author_name,
                    c.category_name,
                    COUNT(r.review_id) as total_reviews,
                    AVG(r.rating) as average_rating,
                    SUM(CASE WHEN r.is_approved = 0 THEN 1 ELSE 0 END) as pending_reviews
                FROM books b
                INNER JOIN reviews r ON b.book_id = r.book_id
                LEFT JOIN authors a ON b.author_id = a.author_id
                LEFT JOIN categories c ON b.category_id = c.category_id
                GROUP BY b.book_id
                ORDER BY total_reviews DESC, b.created_at DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đếm số sách có reviews
    public function countBooksWithReviews() {
        $sql = "SELECT COUNT(DISTINCT book_id) as total FROM {$this->table}";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Lấy reviews của một sách (cho admin, bao gồm cả chưa duyệt)
    public function getReviewsByBookIdForAdmin($bookId) {
        $sql = "SELECT r.*, u.full_name, u.email, u.avatar
                FROM {$this->table} r
                LEFT JOIN users u ON r.user_id = u.user_id
                WHERE r.book_id = :book_id
                ORDER BY r.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':book_id', (int)$bookId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Phân trang reviews của một sách (cho admin)
    public function getReviewsByBookIdAdminPaginated($bookId, $limit, $offset) {
        $sql = "SELECT r.*, u.full_name, u.email, u.avatar
                FROM {$this->table} r
                LEFT JOIN users u ON r.user_id = u.user_id
                WHERE r.book_id = :book_id
                ORDER BY r.created_at DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':book_id', (int)$bookId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteReviewByAdmin($reviewId) {
        $sql = "DELETE FROM {$this->table} WHERE review_id = :review_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':review_id', (int)$reviewId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}