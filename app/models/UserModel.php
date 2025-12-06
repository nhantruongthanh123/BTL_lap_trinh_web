<?php
class UserModel extends BaseModel {
    protected $table = 'users';

    public function register($data) {
        $sql = "INSERT INTO " . $this->table . " (username, email, password_hash, full_name) 
                VALUES (:username, :email, :password_hash, :full_name)";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue(':username', $data['username']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':full_name', $data['full_name']);
        $stmt->bindValue(':password_hash', $data['password_hash']); 

        return $stmt->execute(); 
    }

    public function findUserByEmail($email) {
        $sql = "SELECT user_id, username, email, password_hash, role, full_name, avatar
                FROM " . $this->table . " 
                WHERE email = :email AND is_active = 1";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findUserByUsername($username) {
        $sql = "SELECT user_id, username, email, password_hash, role, full_name, avatar
                FROM " . $this->table . " 
                WHERE username = :username";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById($user_id) {
        $sql = "SELECT user_id, username, email, role, full_name, gender, birthday, phone, address, password_hash, avatar, is_active
                FROM " . $this->table . " 
                WHERE user_id = :user_id";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($userId, $data) {
        if (isset($data['avatar'])) {
            $sql = "UPDATE " . $this->table . " 
                    SET full_name = :full_name, 
                        phone = :phone,
                        email = :email,
                        gender = :gender,
                        birthday = :birthday,
                        address = :address,
                        avatar = :avatar
                    WHERE user_id = :user_id";
        } else {
            $sql = "UPDATE " . $this->table . " 
                    SET full_name = :full_name, 
                        phone = :phone,
                        email = :email,
                        gender = :gender,
                        birthday = :birthday,
                        address = :address
                    WHERE user_id = :user_id";
        }
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':full_name', $data['full_name']);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':gender', $data['gender'] ?? null);
            $stmt->bindValue(':birthday', $data['birthday'] ?? null);
            $stmt->bindValue(':phone', $data['phone'] ?? null);
            $stmt->bindValue(':address', $data['address'] ?? null);

            if (isset($data['avatar'])) {
                $stmt->bindValue(':avatar', $data['avatar']);
            }

            return $stmt->execute();
    }

    public function isEmailExists($email) {
        $sql = "SELECT COUNT(*) FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function updatePassword($userId, $newPasswordHash) {
        $sql = "UPDATE " . $this->table . " 
                SET password_hash = :password_hash 
                WHERE user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':password_hash', $newPasswordHash);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function updateAvatar($userId, $avatarPath) {
        $sql = "UPDATE " . $this->table . " 
                SET avatar = :avatar 
                WHERE user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':avatar', $avatarPath);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function countCustomers() {
        $sql = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE role = 'customer' AND is_active = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function countOrders() {
        $sql = "SELECT COUNT(*) as total FROM orders";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function countBooks() {
        $sql = "SELECT COUNT(*) as total FROM books";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
    
    public function sumRevenue() {
        $sql = "SELECT SUM(final_amount) as total_revenue 
                FROM orders 
                WHERE payment_status = 'paid' AND status IN ('confirmed', 'shipping', 'delivered')";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_revenue'] ?? 0;
    }

    public function getAllCustomers(){
        $sql = "SELECT u.*, 
                       COUNT(o.order_id) as total_orders, 
                       COALESCE(SUM(o.final_amount), 0) as total_spent
                FROM " . $this->table . " u
                
                -- THÊM ĐIỀU KIỆN TRONG JOIN (Quan trọng)
                -- Chỉ join những đơn hàng đã thanh toán
                LEFT JOIN orders o ON u.user_id = o.user_id AND o.payment_status = 'paid'
                
                WHERE u.role = 'customer'
                GROUP BY u.user_id
                ORDER BY u.user_id DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCustomersPaginated($limit = 10, $offset = 0){
        $sql = "SELECT u.*, 
                       COUNT(o.order_id) as total_orders, 
                       COALESCE(SUM(o.final_amount), 0) as total_spent
                FROM " . $this->table . " u
                
                -- THÊM ĐIỀU KIỆN TRONG JOIN (Quan trọng)
                -- Chỉ join những đơn hàng đã thanh toán
                LEFT JOIN orders o ON u.user_id = o.user_id AND o.payment_status = 'paid'
                
                WHERE u.role = 'customer'
                GROUP BY u.user_id
                ORDER BY u.user_id DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUserStatus($userId, $isActive) {
        $sql = "UPDATE users 
                SET is_active = :is_active,
                    updated_at = NOW()
                WHERE user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':is_active', $isActive, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

}