<?php
class Order extends BaseController {
    public $userModel;
    public $productModel;
    public $orderModel;
    public $couponModel;
    

    public function __construct() {
        $this->userModel = $this->model('UserModel');
        $this->productModel = $this->model('ProductModel');
        $this->orderModel = $this->model('OrderModel');
        $this->couponModel = $this->model('CouponModel');
    }

    public function checkout() {
        if (empty($_SESSION['cart'])) {
            header('Location: ' . WEBROOT . '/cart');
            exit();
        }

        $user = [];
        if (isset($_SESSION['user_id'])) {
            $user = $this->userModel->getUserById($_SESSION['user_id']);
        }

        $cartData = $_SESSION['cart'];
        $products = [];
        $totalPrice = 0;

        foreach ($cartData as $id => $qty) {
            $product = $this->productModel->getProductByIdAdmin($id);
            if ($product) {
                $price = $product['price'];
                if ($product['discount_price'] && $product['discount_price'] <$product['price']) {
                    $price = $product['discount_price'];
                }
                $product['buy_qty'] = $qty;
                $product['subtotal'] = $price * $qty;
                $product['final_price'] = $price;
                $totalPrice += $product['subtotal'];
                $products[] = $product;
            }
        }

        $availableCoupons = $this->couponModel->getAvailableCoupons($totalPrice);

        $data = [
            'title' => 'Thanh toán',
            'page'  => 'checkout',
            'user'  => $user,
            'cart_items' => $products,
            'total_price' => $totalPrice,
            'available_coupons' => $availableCoupons
        ];

        $this->render('Block/header', $data);
        $this->render('Order/checkout', $data); 
        $this->render('Block/footer');
    }

    public function placeorder() {
        // 1. Kiểm tra session user
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để đặt hàng';
            header('Location: ' . WEBROOT . '/user/login');
            exit();
        }

        // 2. Kiểm tra giỏ hàng
        if (empty($_SESSION['cart'])) {
            $_SESSION['error'] = 'Giỏ hàng trống';
            header('Location: ' . WEBROOT . '/cart');
            exit();
        }

        // 3. Validate input
        if (empty($_POST['shipping_address'])) {
            $_SESSION['error'] = 'Vui lòng nhập địa chỉ giao hàng';
            header('Location: ' . WEBROOT . '/order/checkout');
            exit();
        }
        $userId = $_SESSION['user_id'];
        $shippingAddress = trim($_POST['shipping_address']);
        $note = trim($_POST['note'] ?? '');
        $paymentMethod = $_POST['payment_method'] ?? 'cod';
        $couponCode = trim($_POST['coupon_code'] ?? '');

        // 4. Tính toán giá từ giỏ hàng
        $cartData = $_SESSION['cart'];
        $totalAmount = 0;
        $orderItems = [];

        foreach ($cartData as $bookId => $quantity) {
            $product = $this->productModel->getProductByIdAdmin($bookId);
            if ($product && $product['stock_quantity'] >= $quantity) {
                $price = $product['discount_price'] ?: $product['price'];
                $subtotal = $price * $quantity;
                $totalAmount += $subtotal;
                
                $orderItems[] = [
                    'book_id' => $bookId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal
                ];
            } else {
                $_SESSION['error'] = 'Sản phẩm "' . $product['title'] . '" không đủ số lượng';
                header('Location: ' . WEBROOT . '/cart');
                exit();
            }
        }

        $shippingFee = 15000;
        $discountAmount = 0;

        if (!empty($couponCode)) {
            $couponValidation = $this->couponModel->validateCoupon($couponCode, $totalAmount);
            
            if ($couponValidation['valid']) {
                $coupon = $couponValidation['coupon'];
                
                if ($coupon['discount_type'] == 'free_shipping') {
                    $shippingFee = 0;
                    $discountAmount = 15000;
                } elseif ($coupon['discount_type'] == 'fixed_amount') {
                    $discountAmount = $coupon['discount_value'];
                }
            } else {
                $couponCode = null;
            }
        }

        $finalAmount = $totalAmount + $shippingFee - $discountAmount;
        $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

        $orderData = [
                'user_id' => $userId,
                'order_number' => $orderNumber,
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'shipping_fee' => $shippingFee,
                'final_amount' => $finalAmount,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $paymentMethod,
                'shipping_address' => $shippingAddress,
                'note' => $note,
                'coupon_code' => $couponCode
            ];


        $db = $this->orderModel->getDbConnection();

        try {
            $db->beginTransaction();

            $orderId = $this->orderModel->createOrder($orderData);

            if (!$orderId) {
                throw new Exception("Không thể tạo bản ghi đơn hàng chính.");
            }

            foreach ($orderItems as $item) {
                $item['order_id'] = $orderId;
                $this->orderModel->addOrderItem($item);

                $this->productModel->decreaseStock($item['book_id'], $item['quantity']);
            }

            $db->commit();

            unset($_SESSION['cart']);
            $_SESSION['success'] = 'Đặt hàng thành công! Mã đơn hàng: ' . $orderNumber;
            header('Location: ' . WEBROOT . '/order/success/' . $orderId);
            exit();

        } catch (Exception $e) {
            $db->rollBack();
            $_SESSION['error'] = 'Đặt hàng thất bại, đã xảy ra lỗi. Vui lòng thử lại.';
            header('Location: ' . WEBROOT . '/order/checkout');
            exit();
        }
    }

    public function success($orderId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . WEBROOT . '/user/login');
            exit();
        }

        $order = $this->orderModel->getOrderById($orderId);
        
        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            header('Location: ' . WEBROOT);
            exit();
        }

        $data = [
            'title' => 'Đặt hàng thành công',
            'order' => $order
        ];

        $this->render('Block/header', $data);
        $this->render('Order/success', $data);
        $this->render('Block/footer');
    }
}