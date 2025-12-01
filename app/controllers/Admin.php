<?php

class Admin extends BaseController {
    public $userModel;

    public function __construct(){
        // if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
        //     header('Location: ' . WEBROOT);
        //     exit();
        // }
        $this->userModel = $this->model('UserModel');
    }

    public function index(){
        $data = [
            'title' => 'Dashboard - Quản trị viên',
            'page'  => 'dashboard',
            'totalCustomers' => $this->userModel->countCustomers(),
            'totalOrders'    => $this->userModel->countOrders(),
            'totalBooks'  => $this->userModel->countBooks(),
            'sumRevenue'    => $this->userModel->sumRevenue()
        ];

        $this->render('Admin/inc/header', $data);
        $this->render('Admin/Dashboard/index', $data);
        $this->render('Admin/inc/footer', $data);
    }

    public function login() {
        // Nếu đã là admin rồi thì vào thẳng Dashboard
        if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
            header('Location: ' . WEBROOT . '/admin');
            exit();
        }

        $data = [
            'title' => 'Đăng nhập Quản trị viên',
            'error' => $_SESSION['admin_error'] ?? ''
        ];
        unset($_SESSION['admin_error']);

        $this->render('Admin/login', $data);
    }

    // 2. Xử lý đăng nhập
    public function loginProcess() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $_SESSION['admin_error'] = 'Vui lòng nhập đầy đủ thông tin.';
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $user = $this->userModel->findUserByEmail($username);
        } else {
            $user = $this->userModel->findUserByUsername($username);
        }

        if ($user && password_verify($password, $user['password_hash'])) {
            
            if ($user['role'] === 'admin') {
                $_SESSION['user_id']   = $user['user_id'];
                $_SESSION['username']  = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role']      = $user['role'];
                $_SESSION['avatar']    = $user['avatar'];
                header('Location: ' . WEBROOT . '/admin');
                exit();
            } else {
                $_SESSION['admin_error'] = 'Bạn không có quyền truy cập trang quản trị.';
            }
        } else {
            $_SESSION['admin_error'] = 'Tên đăng nhập hoặc mật khẩu không đúng.';
        }

        header('Location: ' . WEBROOT . '/admin/login');
    }

}