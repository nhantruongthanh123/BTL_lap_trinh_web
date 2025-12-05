<?php
class CouponModel extends BaseModel {
    protected $table = 'coupons';

    public function getActiveCoupons() {
        $sql = "SELECT * FROM " . $this->table . " WHERE is_active = 1 AND expiration_date >= NOW()
                ORDER BY discount_value DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableCoupons($orderTotal) {
        $sql = "SELECT * FROM " . $this->table . " 
                WHERE is_active = 1 
                AND expiration_date >= CURDATE() 
                AND min_order_value <= :order_total
                ORDER BY discount_value DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':order_total', $orderTotal, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCouponByCode($code) {
        $sql = "SELECT * FROM " . $this->table . " 
                WHERE code = :code 
                AND is_active = 1 
                AND expiration_date >= CURDATE()";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':code', $code, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function validateCoupon($code, $orderTotal) {
        $coupon = $this->getCouponByCode($code);
        
        if (!$coupon) {
            return ['valid' => false, 'message' => 'Mã giảm giá không tồn tại hoặc đã hết hạn'];
        }

        if ($orderTotal < $coupon['min_order_value']) {
            return [
                'valid' => false, 
                'message' => 'Đơn hàng tối thiểu ' . number_format($coupon['min_order_value']) . ' ₫ để áp dụng mã này'
            ];
        }

        return [
            'valid' => true, 
            'coupon' => $coupon,
            'message' => 'Áp dụng mã thành công!'
        ];
    }


}