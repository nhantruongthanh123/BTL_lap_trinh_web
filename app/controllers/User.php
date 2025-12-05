<?php
class User extends BaseController {
    private $userModel;
    private $categoryModel;
    private $orderModel;

    public function __construct() {
        $this->userModel = $this->model('UserModel');
        $this->categoryModel = $this->model('CategoryModel');
        $this->orderModel = $this->model('OrderModel');
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

        $categories = $this->model('CategoryModel')->getAllCategories();

        $data = [
            'title' => 'Đăng nhập - Bookstore',
            'page' => 'auth',
            'categories' => $categories,
            'error' => $loginError,              
            'success' => $successMessage         
        ];

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
            $_SESSION['avatar']    = $user['avatar'];

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
        if (!isset($_SESSION['registerSuccess'])) {
            header('Location: ' . WEBROOT . '/user/register');
            exit();
        }
        
        $successData = $_SESSION['registerSuccess'];
        
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

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . WEBROOT . '/user/login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($userId);

        if (!$user) {
            session_destroy();
            $_SESSION['login_error'] = 'Tài khoản không tồn tại hoặc đã bị vô hiệu hóa.';
            header('Location: ' . WEBROOT . '/user/login');
            exit();
        }

        $successMessage = $_SESSION['profile_success'] ?? '';
        $errorMessage = $_SESSION['profile_error'] ?? '';

        unset($_SESSION['profile_success']);
        unset($_SESSION['profile_error']);



        $data = [
        'title' => 'Thông tin tài khoản - Bookstore',
        'page' => 'profile',
        'categories' => $this->categoryModel->getAllCategories(),
        'user' => $user,
        'success' => $successMessage,
        'error' => $errorMessage,
        'active_tab' => 'profile'
        ];

        $this->render('Block/header', $data);
        $this->render('Block/sidebar_customer', $data);
        $this->render('User/profile', $data); 
        $this->render('Block/footer');
    }

    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . WEBROOT . '/user/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/user/profile');
            exit();
        }

        $userId = $_SESSION['user_id'];

        // ========== XỬ LÝ UPLOAD AVATAR ==========
        $avatarFileName = null;
        
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            $maxSize = 2 * 1024 * 1024; // 2MB
            
            $fileType = $_FILES['avatar']['type'];
            $fileSize = $_FILES['avatar']['size'];
            $tmpName = $_FILES['avatar']['tmp_name'];
            
            // 1. VALIDATE LOẠI FILE
            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['profile_error'] = 'Chỉ chấp nhận file ảnh JPG, PNG, GIF.';
                header('Location: ' . WEBROOT . '/user/profile');
                exit();
            }
            
            // 2. VALIDATE KÍCH THƯỚC
            if ($fileSize > $maxSize) {
                $_SESSION['profile_error'] = 'Kích thước file không được vượt quá 2MB.';
                header('Location: ' . WEBROOT . '/user/profile');
                exit();
            }
            
            // 3. TẠO TÊN FILE UNIQUE
            $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $avatarFileName = 'avatar_' . $userId . '_' . time() . '.' . $extension;
            
            // 4. ĐƯỜNG DẪN LƯU FILE
            $uploadDir = ROOT . '/../../public/assets/Clients/avatars/';
            $uploadPath = $uploadDir . $avatarFileName;
            
            // 5. TẠO THƯ MỤC NẾU CHƯA TỒN TẠI
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // 6. DI CHUYỂN FILE TỪ TEMP SANG THƯ MỤC ĐÍCH
            if (!move_uploaded_file($tmpName, $uploadPath)) {
                $_SESSION['profile_error'] = 'Upload ảnh thất bại. Vui lòng thử lại.';
                header('Location: ' . WEBROOT . '/user/profile');
                exit();
            }
            
            // 7. XÓA AVATAR CŨ (nếu không phải default)
            $currentUser = $this->userModel->getUserById($userId);
            $oldAvatar = $currentUser['avatar'] ?? null;
            
            if ($oldAvatar && $oldAvatar !== 'default-avatar.png') {
                $oldPath = $uploadDir . $oldAvatar;
                if (file_exists($oldPath)) {
                    unlink($oldPath); // Xóa file cũ
                }
            }
        }

        $day = $_POST['day'] ?? '';
        $month = $_POST['month'] ?? '';
        $year = $_POST['year'] ?? '';
        
        $birthday = null;
        if (!empty($day) && !empty($month) && !empty($year)) {
            $birthday = sprintf('%04d-%02d-%02d', $year, $month, $day);
        }
        
        $data = [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'gender' => $_POST['gender'] ?? null,
            'birthday' => $birthday ?? null,
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? '')
        ];

        if ($avatarFileName) {
            $data['avatar'] = $avatarFileName;
        }

        // VALIDATE
        if (empty($data['full_name']) || empty($data['email'])) {
            $_SESSION['profile_error'] = 'Họ tên và email không được để trống.';
            header('Location: ' . WEBROOT . '/user/profile');
            exit();
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['profile_error'] = 'Email không hợp lệ.';
            header('Location: ' . WEBROOT . '/user/profile');
            exit();
        }

        // Validate birthday
        if ($birthday && !checkdate($month, $day, $year)) {
            $_SESSION['profile_error'] = 'Ngày sinh không hợp lệ.';
            header('Location: ' . WEBROOT . '/user/profile');
            exit();
        }
        if (!empty($data['birthday']) && strtotime($data['birthday']) > time()) {
            $_SESSION['profile_error'] = 'Ngày sinh không hợp lệ.';
            header('Location: ' . WEBROOT . '/user/profile');
            exit();
        }

        if ($this->userModel->updateProfile($userId, $data)) {
            $_SESSION['full_name'] = $data['full_name']; 
            $_SESSION['email'] = $data['email'];
            $_SESSION['profile_success'] = 'Cập nhật thông tin thành công!';
            if ($avatarFileName) {
                $_SESSION['avatar'] = $avatarFileName;
            }
        } else {
            $_SESSION['profile_error'] = 'Cập nhật thất bại. Vui lòng thử lại.';
        }

        header('Location: ' . WEBROOT . '/user/profile');
        exit();
    }

    public function changePassword() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . WEBROOT . '/user/login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($userId);

        if (!$user) {
            session_destroy();
            $_SESSION['login_error'] = 'Tài khoản không tồn tại hoặc đã bị vô hiệu hóa.';
            header('Location: ' . WEBROOT . '/user/login');
            exit();
        }

        // Lấy thông báo
        $successMessage = $_SESSION['password_success'] ?? '';
        $errorMessage = $_SESSION['password_error'] ?? '';
        $errors = $_SESSION['password_errors'] ?? [];

        unset($_SESSION['password_success']);
        unset($_SESSION['password_error']);
        unset($_SESSION['password_errors']);

        $data = [
            'title' => 'Đổi mật khẩu - Bookstore',
            'page' => 'changePassword',
            'categories' => $this->categoryModel->getAllCategories(),
            'user' => $user,
            'success' => $successMessage,
            'error' => $errorMessage,
            'errors' => $errors,
            'active_tab' => 'password'
        ];

        $this->render('Block/header', $data);
        $this->render('Block/sidebar_customer', $data);
        $this->render('User/changePassword', $data);
        $this->render('Block/footer');
    }

    public function changePasswordProcess() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . WEBROOT . '/user/login');
            exit();
        }

        // Chỉ chấp nhận POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/user/changePassword');
            exit();
        }

        $userId = $_SESSION['user_id'];

        // Lấy dữ liệu từ form
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $errors = [];

        // VALIDATE
        if (empty($currentPassword)) {
            $errors['current_password'] = 'Vui lòng nhập mật khẩu hiện tại.';
        }

        if (empty($newPassword)) {
            $errors['new_password'] = 'Vui lòng nhập mật khẩu mới.';
        } elseif (strlen($newPassword) < 6) {
            $errors['new_password'] = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
        }

        if (empty($confirmPassword)) {
            $errors['confirm_password'] = 'Vui lòng xác nhận mật khẩu mới.';
        } elseif ($newPassword !== $confirmPassword) {
            $errors['confirm_password'] = 'Mật khẩu xác nhận không khớp.';
        }

        // Nếu có lỗi validate
        if (!empty($errors)) {
            $_SESSION['password_errors'] = $errors;
            header('Location: ' . WEBROOT . '/user/changePassword');
            exit();
        }

        // Lấy thông tin user từ database
        $user = $this->userModel->getUserById($userId);

        // Kiểm tra mật khẩu hiện tại có đúng không
        if (!password_verify($currentPassword, $user['password_hash'])) {
            $_SESSION['password_error'] = 'Mật khẩu hiện tại không đúng.';
            header('Location: ' . WEBROOT . '/user/changePassword');
            exit();
        }

        // Kiểm tra mật khẩu mới không giống mật khẩu cũ
        if ($currentPassword === $newPassword) {
            $_SESSION['password_error'] = 'Mật khẩu mới phải khác mật khẩu hiện tại.';
            header('Location: ' . WEBROOT . '/user/changePassword');
            exit();
        }

        // Mã hóa mật khẩu mới
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        // Cập nhật mật khẩu
        if ($this->userModel->updatePassword($userId, $newPasswordHash)) {
            $_SESSION['password_success'] = 'Đổi mật khẩu thành công!';
        } else {
            $_SESSION['password_error'] = 'Đổi mật khẩu thất bại. Vui lòng thử lại.';
        }

        header('Location: ' . WEBROOT . '/user/changePassword');
        exit();
    }


    public function removeAvatar() {
        // 1. KIỂM TRA ĐĂNG NHẬP
        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                'success' => false, 
                'message' => 'Vui lòng đăng nhập để thực hiện chức năng này.'
            ]);
            exit();
        }

        // 2. CHỈ CHẤP NHẬN POST REQUEST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'success' => false, 
                'message' => 'Phương thức không hợp lệ.'
            ]);
            exit();
        }

        $userId = $_SESSION['user_id'];
        
        // 3. LẤY THÔNG TIN USER HIỆN TẠI
        $user = $this->userModel->getUserById($userId);
        
        if (!$user) {
            echo json_encode([
                'success' => false, 
                'message' => 'Không tìm thấy thông tin người dùng.'
            ]);
            exit();
        }

        $currentAvatar = $user['avatar'] ?? null;

        // 4. XÓA FILE VẬT LÝ (nếu không phải default)
        if ($currentAvatar && $currentAvatar !== 'default-avatar.png') {
            $avatarPath = __DIR__ . '/../../public/assets/Clients/avatars/' . $currentAvatar;
            
            if (file_exists($avatarPath)) {
                if (!unlink($avatarPath)) {
                    echo json_encode([
                        'success' => false, 
                        'message' => 'Không thể xóa file ảnh. Vui lòng thử lại.'
                    ]);
                    exit();
                }
            }
        }

        // 5. CẬP NHẬT DATABASE - Đổi về default-avatar.png
        if ($this->userModel->updateAvatar($userId, 'default-avatar.png')) {
            
            // 6. CẬP NHẬT SESSION
            $_SESSION['avatar'] = 'default-avatar.png';
            
            // 7. TRẢ VỀ JSON THÀNH CÔNG
            echo json_encode([
                'success' => true, 
                'message' => 'Xóa ảnh đại diện thành công!'
            ]);
            
        } else {
            // 8. TRẢ VỀ JSON THẤT BẠI
            echo json_encode([
                'success' => false, 
                'message' => 'Cập nhật database thất bại. Vui lòng thử lại.'
            ]);
        }
        
        exit();
    }

    public function orders() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . WEBROOT . '/user/login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $status = $_GET['status'] ?? 'all';

        // Chỉ lấy đơn hàng CHƯA HOÀN THÀNH (chưa delivered và chưa cancelled)
        if ($status === 'all') {
            $orders = $this->orderModel->getActiveOrdersByUserId($userId);
        } else {
            $orders = $this->orderModel->getOrdersByUserIdAndStatus($userId, $status);
        }

        // Cập nhật số lượng đơn hàng pending vào session
        $_SESSION['pending_orders'] = $this->orderModel->countUserOrdersByStatus($userId, 'pending');

        $data = [
            'title' => 'Đơn hàng của tôi',
            'page' => 'orders',
            'orders' => $orders,
            'current_status' => $status
        ];

        $this->render('Block/header', $data);
        $this->render('User/orders', $data);
        $this->render('Block/footer');
    }

    public function orderHistory() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . WEBROOT . '/user/login');
            exit();
        }

        $userId = $_SESSION['user_id'];

        $orders = $this->orderModel->getAllOrdersByUserId($userId);

        $data = [
            'title' => 'Lịch sử mua hàng',
            'page' => 'orderHistory',
            'orders' => $orders
        ];

        $this->render('Block/header', $data);
        $this->render('User/orderHistory', $data);
        $this->render('Block/footer');
    }


}