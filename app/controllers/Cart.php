<?php
class Cart extends BaseController {
    public $productModel;

    public function __construct() {
        $this->productModel = $this->model('ProductModel');

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function index() {
        $cartData = $_SESSION['cart'];
        $products = [];
        $totalPrice = 0;

        if (!empty($cartData)) {
            foreach ($cartData as $id => $qty) {
                $product = $this->productModel->getProductByIdAdmin($id); 
                if ($product) {
                    $product['buy_qty'] = $qty;
                    $final_price = $product['price']; 

                    if ($product['discount_price'] > 0 && $product['discount_price'] < $product['price']) {
                        $final_price = $product['discount_price'];
                    }

                    $subtotal = $final_price * $qty;
                    
                    $product['subtotal'] = $subtotal;
                    $totalPrice += $product['subtotal'];
                    $product['final_price'] = $final_price;
                    
                    $products[] = $product;
                }
            }
        }

        $data = [
            'title' => 'Giỏ hàng của bạn',
            'page'  => 'cart',
            'cart_items' => $products,
            'total_price' => $totalPrice
        ];

        $this->render('Block/header', $data);
        $this->render('Cart/index', $data); 
        $this->render('Block/footer');
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
            $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            if ($id > 0 && $qty > 0) {
                if (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id] += $qty;
                } else {
                    $_SESSION['cart'][$id] = $qty;
                }
                
                $_SESSION['cart_message'] = "Đã thêm sản phẩm vào giỏ hàng!";
            }
        }

        if (isset($_POST['action']) && $_POST['action'] === 'buy_now') {
            header('Location: ' . WEBROOT . '/cart');
            exit();
        }
        
        $referer = $_SERVER['HTTP_REFERER'] ?? WEBROOT;
        header('Location: ' . $referer);
        exit();
    }

    public function remove($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: ' . WEBROOT . '/cart');
        exit();
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['product_id'];
            $qty = (int)$_POST['quantity'];
            
            if ($qty > 0) {
                $_SESSION['cart'][$id] = $qty;
            } else {
                unset($_SESSION['cart'][$id]);
            }
        }
        header('Location: ' . WEBROOT . '/cart');
        exit();
    }
}