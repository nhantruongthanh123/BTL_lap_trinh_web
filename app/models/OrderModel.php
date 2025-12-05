<?php
class OrderModel extends BaseModel {
    protected $table = 'orders';

    public function getAllOrders(){
        $sql = "SELECT o.*, u.full_name 
                FROM " . $this->table . " o
                LEFT JOIN users u ON o.user_id = u.user_id
                ORDER BY o.order_date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // LẤY ĐƠN HÀNG THEO ID
    public function getOrderById($orderId) {
        $sql = "SELECT o.*, 
                       u.full_name, 
                       u.email, 
                       u.phone
                FROM " . $this->table . " o
                LEFT JOIN users u ON o.user_id = u.user_id
                WHERE o.order_id = :order_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // LẤY CHI TIẾT ĐƠN HÀNG (SẢN PHẨM)
    public function getOrderItems($orderId) {
        $sql = "SELECT oi.*, 
                       b.title as book_title,
                       b.cover_image
                FROM order_items oi
                INNER JOIN books b ON oi.book_id = b.book_id
                WHERE oi.order_id = :order_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG
    public function updateOrderStatus($orderId, $status) {
        $sql = "UPDATE " . $this->table . " 
                SET status = :status,
                    updated_at = NOW()
                WHERE order_id = :order_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // CẬP NHẬT TRẠNG THÁI THANH TOÁN
    public function updatePaymentStatus($orderId, $paymentStatus) {
        $sql = "UPDATE " . $this->table . " 
                SET payment_status = :payment_status,
                    updated_at = NOW()
                WHERE order_id = :order_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':payment_status', $paymentStatus);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // ĐẾM SỐ ĐƠN HÀNG THEO TRẠNG THÁI
    public function countOrdersByStatus($status) {
        $sql = "SELECT COUNT(*) as count 
                FROM " . $this->table . " 
                WHERE status = :status";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function createOrder($data) {
        $sql = "INSERT INTO orders 
                (user_id, order_number, total_amount, discount_amount, shipping_fee, 
                final_amount, status, payment_status, payment_method, shipping_address, 
                note, coupon_code) 
                VALUES 
                (:user_id, :order_number, :total_amount, :discount_amount, :shipping_fee, 
                :final_amount, :status, :payment_status, :payment_method, :shipping_address, 
                :note, :coupon_code)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':order_number', $data['order_number'], PDO::PARAM_STR);
        $stmt->bindValue(':total_amount', $data['total_amount'], PDO::PARAM_STR);
        $stmt->bindValue(':discount_amount', $data['discount_amount'], PDO::PARAM_STR);
        $stmt->bindValue(':shipping_fee', $data['shipping_fee'], PDO::PARAM_STR);
        $stmt->bindValue(':final_amount', $data['final_amount'], PDO::PARAM_STR);
        $stmt->bindValue(':status', $data['status'], PDO::PARAM_STR);
        $stmt->bindValue(':payment_status', $data['payment_status'], PDO::PARAM_STR);
        $stmt->bindValue(':payment_method', $data['payment_method'], PDO::PARAM_STR);
        $stmt->bindValue(':shipping_address', $data['shipping_address'], PDO::PARAM_STR);
        $stmt->bindValue(':note', $data['note'], PDO::PARAM_STR);
        $stmt->bindValue(':coupon_code', $data['coupon_code'], PDO::PARAM_STR);
        
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function addOrderItem($data) {
        $sql = "INSERT INTO order_items (order_id, book_id, quantity, price, subtotal) 
                VALUES (:order_id, :book_id, :quantity, :price, :subtotal)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':order_id', $data['order_id'], PDO::PARAM_INT);
        $stmt->bindValue(':book_id', $data['book_id'], PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $data['quantity'], PDO::PARAM_INT);
        $stmt->bindValue(':price', $data['price'], PDO::PARAM_STR);
        $stmt->bindValue(':subtotal', $data['subtotal'], PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public function getActiveOrdersByUserId($userId) {
        $sql = "SELECT * FROM orders 
                WHERE user_id = :user_id 
                AND status NOT IN ('delivered', 'cancelled')
                ORDER BY order_date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrdersByUserId($userId) {
        $sql = "SELECT * FROM orders 
                WHERE user_id = :user_id 
                ORDER BY order_date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrdersByUserIdAndStatus($userId, $status) {
        $sql = "SELECT * FROM orders 
                WHERE user_id = :user_id AND status = :status 
                ORDER BY order_date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUserOrdersByStatus($userId, $status) {
        $sql = "SELECT COUNT(*) as count 
                FROM orders 
                WHERE user_id = :user_id AND status = :status";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }
}