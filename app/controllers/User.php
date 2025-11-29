<?php
class User extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('UserModel');
    }

    public function register(){
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . WEBROOT);
            exit();
        }

        $errors = $_SESSION['register_errors'] ?? [];
        $old_input = $_SESSION['old_input'] ?? [];


        unset($_SESSION['register_errors']);
        unset($_SESSION['old_input']);
        
        $data = [
            'title' => 'Đăng ký tài khoản - Bookstore',
            'page'  => 'auth',
            'errors' => $errors,
            'old_input' => $old_input 
        ];


        $this->render('Block/header', $data);
        $this->render('User/register', $data); 
        $this->render('Block/footer');
    }

    public function registerProcess() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/user/register');
            exit();
        }

        // 2. Lấy và sanitize dữ liệu
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $full_name = trim($_POST['full_name'] ?? '');
        
        $errors = [];

        // 3. VALIDATE (Kiểm tra dữ liệu)
        if (empty($username)) {
        $errors['username'] = 'Vui lòng nhập tên đăng nhập.';
        } elseif (strlen($username) < 3) {
            $errors['username'] = 'Tên đăng nhập phải có ít nhất 3 ký tự.';
        } elseif ($this->userModel->findUserByUsername($username)) {
            $errors['username'] = 'Tên đăng nhập này đã có người sử dụng.';
        }

        // Thêm các kiểm tra khác: email hợp lệ, username không trùng...
        if (empty($full_name)) {
            $errors['full_name'] = 'Vui lòng nhập họ và tên.';
        }

        if (empty($email)) {
            $errors['email'] = 'Vui lòng nhập email.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ.';
        } elseif ($this->userModel->isEmailExists($email)) {
            $errors['email'] = 'Email đã được sử dụng.';
        }

        if (empty($password)) {
            $errors['password'] = 'Vui lòng nhập mật khẩu.';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        if (empty($confirm_password)) {
            $errors['confirm_password'] = 'Vui lòng xác nhận mật khẩu.';
        } elseif ($password !== $confirm_password) {
            $errors['confirm_password'] = 'Mật khẩu xác nhận không khớp.';
        }

        if (!empty($errors)) {
            $_SESSION['register_errors'] = $errors;
            $_SESSION['old_input'] = $_POST; // Giữ lại dữ liệu đã nhập
            header('Location: ' . WEBROOT . '/user/register');
            exit();
        }

        // 4. Xử lý đăng ký
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $data_to_model = [
            'username' => $username,
            'email' => $email,
            'password_hash' => $password_hash,
            'full_name' => $full_name,
        ];

        $result = $this->userModel->register($data_to_model);

        unset($_SESSION['register_errors']);
        unset($_SESSION['old_input']);
        
        $userInfo = [
            'username' => $username,
            'email' => $email,
            'full_name' => $full_name
        ];

        $_SESSION['registerSuccess'] = $userInfo;

        $this->registerSuccess();
        
        
    }

    public function login(){
        // Kiểm tra nếu đã đăng nhập → Không cho vào trang login
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . WEBROOT);
            exit();
        }

        $loginError = $_SESSION['login_error'] ?? '';
        
        $successMessage = $_SESSION['success_message'] ?? '';

        unset($_SESSION['login_error']);
        unset($_SESSION['success_message']);

        // Lấy danh mục để hiển thị menu
        $categories = $this->model('CategoryModel')->getAllCategories();

        // Chuẩn bị dữ liệu truyền vào view
        $data = [
            'title' => 'Đăng nhập - Bookstore',
            'page' => 'auth',
            'categories' => $categories,
            'error' => $loginError,              
            'success' => $successMessage         
        ];

        // Render view
        $this->render('Block/header', $data);
        $this->render('User/login', $data);
        $this->render('Block/footer');
    }

    public function loginProcess() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/user/login');
            exit();
        }

        $inputText = trim($_POST['username'] ?? ''); 
        $password  = $_POST['password'] ?? '';

        // Validate cơ bản
        if (empty($inputText) || empty($password)) {
            $_SESSION['login_error'] = 'Vui lòng nhập tên đăng nhập và mật khẩu.';
            header('Location: ' . WEBROOT . '/user/login');
            exit();
        }

        //  Tìm user trong Database
        // Logic: Kiểm tra xem $inputText có phải là Email không?
        if (filter_var($inputText, FILTER_VALIDATE_EMAIL)) {
            // Nếu đúng định dạng email -> Tìm theo Email
            $user = $this->userModel->findUserByEmail($inputText);
        } else {
            $user = $this->userModel->findUserByUsername($inputText);
        }

        if ($user && password_verify($password, $user['password_hash'])) {
            if ($user['role'] !== 'customer') {
                $_SESSION['login_error'] = 'Tài khoản này không có quyền đăng nhập tại đây. Vui lòng sử dụng trang đăng nhập dành cho Quản trị viên.';
                header('Location: ' . WEBROOT . '/user/login');
                exit();
            }

            $_SESSION['user_id']   = $user['user_id'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role']      = $user['role']; 
            $_SESSION['email']     = $user['email'];

            header('Location: ' . WEBROOT); 
            exit();

        } else {
            $_SESSION['login_error'] = 'Tên đăng nhập hoặc mật khẩu không đúng.';
            header('Location: ' . WEBROOT . '/user/login');
            exit();
        }
    }

    public function logout(){
        session_unset();
        session_destroy();
        
        header('Location: ' . WEBROOT);
        exit();
    }


    public function registerSuccess() {
        // Kiểm tra có session success không (tránh truy cập trực tiếp)
        if (!isset($_SESSION['registerSuccess'])) {
            header('Location: ' . WEBROOT . '/user/register');
            exit();
        }
        
        $successData = $_SESSION['registerSuccess'];
        
        // Xóa session sau khi lấy
        unset($_SESSION['registerSuccess']);
        
        $categories = $this->model('CategoryModel')->getAllCategories();
        
        $data = [
            'title' => 'Đăng ký thành công - Bookstore',
            'page' => 'auth',
            'categories' => $categories,
            'user_info' => $successData
        ];
        
        $this->render('Block/header', $data);
        $this->render('User/registerSuccess', $data);
        $this->render('Block/footer');
    }
}