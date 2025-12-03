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
}