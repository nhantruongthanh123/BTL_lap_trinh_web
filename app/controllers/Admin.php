<?php

class Admin extends BaseController {
    public $userModel;
    public $productModel;
    public $categoryModel;
    public $publisherModel;
    public $authorModel;

    public function __construct(){
        // if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
        //     header('Location: ' . WEBROOT);
        //     exit();
        // }
        $this->userModel = $this->model('UserModel');
        $this->productModel = $this->model('ProductModel');
        $this->categoryModel = $this->model('CategoryModel');
        $this->publisherModel = $this->model('PublisherModel');
        $this->authorModel = $this->model('AuthorModel');
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
        $this->render('Admin/index', $data);
        $this->render('Admin/inc/footer', $data);
    }

    public function login() {
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

    public function books() {
        $books = $this->productModel->getAllProductsAdmin(); 

        $data = [
            'title' => 'Quản lý Sách',
            'page'  => 'books',
            'books' => $books,
            'success' => $_SESSION['admin_success'] ?? '',
            'error'   => $_SESSION['admin_error'] ?? ''
        ];
        unset($_SESSION['admin_success']);
        unset($_SESSION['admin_error']);

        $this->render('Admin/inc/header', $data);
        $this->render('Admin/books', $data);
        $this->render('Admin/inc/footer', $data);
    }

    public function bookAdd() {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $categories = $this->categoryModel->getAllCategories();
        $publishers = $this->publisherModel->getAllPublishers();
        $authors = $this->authorModel->getAllAuthors();
        
        $success = $_SESSION['admin_success'] ?? '';
        $error = $_SESSION['admin_error'] ?? '';
        $errors = $_SESSION['admin_errors'] ?? [];
        $old = $_SESSION['admin_old'] ?? [];
        
        unset($_SESSION['admin_success'], $_SESSION['admin_error'], $_SESSION['admin_errors'], $_SESSION['admin_old']);

        $data = [
            'title' => 'Thêm Sách Mới',
            'page' => 'books',
            'categories' => $categories,
            'publishers' => $publishers,
            'authors' => $authors,
            'success' => $success,
            'error' => $error,
            'errors' => $errors,
            'old' => $old
        ];

        $this->render('Admin/inc/header', $data);
        $this->render('Admin/addBook', $data); 
        $this->render('Admin/inc/footer', $data);
    }

    public function bookAddProcess() {
        // 1. KIỂM TRA METHOD VÀ QUYỀN
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/admin/bookAdd');
            exit();
        }
        
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        // 2. LẤY DỮ LIỆU TỪ FORM
        $title = trim($_POST['title'] ?? '');
        $author_id = intval($_POST['author_id'] ?? 0);
        $isbn = trim($_POST['isbn'] ?? '');
        $publisher_id = intval($_POST['publisher_id'] ?? 0);
        $category_id = intval($_POST['category_id'] ?? 0);
        $price = floatval($_POST['price'] ?? 0);
        $discount_price = floatval($_POST['discount_price'] ?? 0);
        $stock_quantity = intval($_POST['stock_quantity'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;

        // 3. LƯU DỮ LIỆU CŨ ĐỂ HIỂN thị LẠI KHI LỖI
        $old = [
            'title' => $title,
            'author_id' => $author_id,
            'isbn' => $isbn,
            'publisher_id' => $publisher_id,
            'category_id' => $category_id,
            'price' => $price,
            'discount_price' => $discount_price,
            'stock_quantity' => $stock_quantity,
            'description' => $description,
            'is_active' => $is_active,
            'is_featured' => $is_featured
        ];

        $errors = [];

        // 4. VALIDATE CƠ BẢN
        if (empty($title)) {
            $errors['title'] = 'Tên sách không được để trống.';
        }
        
        if ($category_id <= 0) {
            $errors['category_id'] = 'Vui lòng chọn danh mục.';
        }
        
        if ($price <= 0) {
            $errors['price'] = 'Giá bán phải lớn hơn 0.';
        }
        
        if ($stock_quantity < 0) {
            $errors['stock_quantity'] = 'Số lượng không được âm.';
        }

        // ========== XỬ LÝ UPLOAD ẢNH BÌA (THEO MẪU USER) ==========
        $coverFileName = null;
        
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            $maxSize = 5 * 1024 * 1024; // 5MB
            
            $fileType = $_FILES['cover_image']['type'];
            $fileSize = $_FILES['cover_image']['size'];
            $tmpName = $_FILES['cover_image']['tmp_name'];
            
            // 1. VALIDATE LOẠI FILE
            if (!in_array($fileType, $allowedTypes)) {
                $errors['cover_image'] = 'Chỉ chấp nhận file ảnh JPG, PNG, GIF.';
            } 
            // 2. VALIDATE KÍCH THƯỚC
            elseif ($fileSize > $maxSize) {
                $errors['cover_image'] = 'Kích thước file không được vượt quá 5MB.';
            } 
            else {
                // 3. TẠO TÊN FILE UNIQUE
                $extension = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
                $coverFileName = 'cover_' . time() . '_' . uniqid() . '.' . $extension;
                
                // 4. ĐƯỜNG DẪN LƯU FILE
                $uploadDir = ROOT . '/public/images/';
                $uploadPath = $uploadDir . $coverFileName;
                
                // 5. TẠO THƯ MỤC NẾU CHƯA TỒN TẠI
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                // 6. DI CHUYỂN FILE TỪ TEMP SANG THƯ MỤC ĐÍCH
                if (!move_uploaded_file($tmpName, $uploadPath)) {
                    $errors['cover_image'] = 'Upload ảnh thất bại. Vui lòng thử lại.';
                    $coverFileName = null;
                }
            }
        }

        // 6. NẾU CÓ LỖI → REDIRECT VỀ FORM
        if (!empty($errors)) {
            error_log("=== VALIDATION ERRORS ===");
            error_log(print_r($errors, true));
            error_log("=== OLD DATA ===");
            error_log(print_r($old, true));

            $_SESSION['admin_error'] = 'Có lỗi khi thêm sách. Vui lòng kiểm tra lại. haha';
            $_SESSION['admin_errors'] = $errors;
            $_SESSION['admin_old'] = $old;
            header('Location: ' . WEBROOT . '/admin/bookAdd');
            exit();
        }

        // 7. CHUẨN BỊ DỮ LIỆU ĐỂ LƯU VÀO DATABASE
        $data = [
            'title' => $title,
            'author_id' => $author_id,
            'isbn' => $isbn,
            'publisher_id' => $publisher_id,
            'category_id' => $category_id,
            'price' => $price,                      
            'discount_price' => $discount_price,   
            'stock_quantity' => $stock_quantity,
            'description' => $description,
            'is_active' => $is_active,
            'is_featured' => $is_featured,
            'cover_image' => $coverFileName,
            'created_at' => date('Y-m-d H:i:s')
        ];

        
        $insertId = $this->productModel->addProduct($data);
        if ($insertId) {
            $_SESSION['admin_success'] = 'Thêm sách mới thành công!';
            header('Location: ' . WEBROOT . '/admin/books');
            exit();
        } else {
            if ($coverFileName) {
                $uploadPath = ROOT . '/public/images/' . $coverFileName;
                if (file_exists($uploadPath)) {
                    @unlink($uploadPath);
                }
            }
            
            $_SESSION['admin_error'] = 'Lưu sách vào database thất bại. Vui lòng thử lại.';
            $_SESSION['admin_old'] = $old;
            header('Location: ' . WEBROOT . '/admin/bookAdd');
            exit();
        }
        
    }

    public function deleteBook($bookId) {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $book = $this->productModel->getProductByIdAdmin($bookId);
        if (!$book) {
            $_SESSION['admin_error'] = 'Sách không tồn tại.';
            header('Location: ' . WEBROOT . '/admin/books');
            exit();
        }

        $deleted = $this->productModel->deleteProduct($bookId);

        header('Location: ' . WEBROOT . '/admin/books');
    }

    public function editBook($bookId) {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $book = $this->productModel->getProductByIdAdmin($bookId);
        if (!$book) {
            $_SESSION['admin_error'] = 'Sách không tồn tại.';
            header('Location: ' . WEBROOT . '/admin/books');
            exit();
        }

        $categories = $this->categoryModel->getAllCategories();
        $publishers = $this->publisherModel->getAllPublishers();
        $authors = $this->authorModel->getAllAuthors();

        $success = $_SESSION['admin_success'] ?? '';
        $error = $_SESSION['admin_error'] ?? '';
        $errors = $_SESSION['admin_errors'] ?? [];
        $old = $_SESSION['admin_old'] ?? [];

        unset($_SESSION['admin_success'], $_SESSION['admin_error'], $_SESSION['admin_errors'], $_SESSION['admin_old']);

        $data = [
            'title' => 'Chỉnh Sửa Sách: ' . $book['title'],
            'page' => 'books',
            'book' => $book,  
            'categories' => $categories,
            'publishers' => $publishers,
            'authors' => $authors,
            'success' => $success,
            'error' => $error,
            'errors' => $errors,
            'old' => $old
        ];

        $this->render('Admin/inc/header', $data);
        $this->render('Admin/editBook', $data); 
        $this->render('Admin/inc/footer', $data);
    }

    public function editBookProcess($bookId) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/admin/books');
            exit();
        }
        
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }


        $existingBook = $this->productModel->getProductByIdAdmin($bookId);
        if (!$existingBook) {
            $_SESSION['admin_error'] = 'Sách không tồn tại.';
            header('Location: ' . WEBROOT . '/admin/books');
            exit();
        }


        $title = trim($_POST['title'] ?? '');
        $author_id = intval($_POST['author_id'] ?? 0);
        $isbn = trim($_POST['isbn'] ?? '');
        $publisher_id = intval($_POST['publisher_id'] ?? 0);
        $category_id = intval($_POST['category_id'] ?? 0);
        $price = floatval($_POST['price'] ?? 0);
        $discount_price = floatval($_POST['discount_price'] ?? 0);
        $stock_quantity = intval($_POST['stock_quantity'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;


        $old = [
            'title' => $title,
            'author_id' => $author_id,
            'isbn' => $isbn,
            'publisher_id' => $publisher_id,
            'category_id' => $category_id,
            'price' => $price,
            'discount_price' => $discount_price,
            'stock_quantity' => $stock_quantity,
            'description' => $description,
            'is_active' => $is_active,
            'is_featured' => $is_featured
        ];

        $errors = [];

        if (empty($title)) {
            $errors['title'] = 'Tên sách không được để trống.';
        }
        
        if ($category_id <= 0) {
            $errors['category_id'] = 'Vui lòng chọn danh mục.';
        }
        
        if ($price <= 0) {
            $errors['price'] = 'Giá bán phải lớn hơn 0.';
        }
        
        if ($stock_quantity < 0) {
            $errors['stock_quantity'] = 'Số lượng không được âm.';
        }

        $coverFileName = $existingBook['cover_image']; 
        
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            $maxSize = 5 * 1024 * 1024;
            
            $fileType = $_FILES['cover_image']['type'];
            $fileSize = $_FILES['cover_image']['size'];
            $tmpName = $_FILES['cover_image']['tmp_name'];
            
            if (!in_array($fileType, $allowedTypes)) {
                $errors['cover_image'] = 'Chỉ chấp nhận file ảnh JPG, PNG, GIF.';
            } elseif ($fileSize > $maxSize) {
                $errors['cover_image'] = 'Kích thước file không được vượt quá 5MB.';
            } else {
                $extension = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
                $newCoverFileName = 'cover_' . time() . '_' . uniqid() . '.' . $extension;
                
                $uploadDir = ROOT . '/public/images/';
                $uploadPath = $uploadDir . $newCoverFileName;
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                if (move_uploaded_file($tmpName, $uploadPath)) {
                    if ($existingBook['cover_image']) {
                        $oldImagePath = ROOT . '/public/images/' . $existingBook['cover_image'];
                        if (file_exists($oldImagePath)) {
                            @unlink($oldImagePath);
                        }
                    }
                    $coverFileName = $newCoverFileName;
                } else {
                    $errors['cover_image'] = 'Upload ảnh thất bại.';
                }
            }
        }

        if (!empty($errors)) {
            $_SESSION['admin_error'] = 'Có lỗi khi cập nhật sách.';
            $_SESSION['admin_errors'] = $errors;
            $_SESSION['admin_old'] = $old;
            header('Location: ' . WEBROOT . '/admin/editBook/' . $bookId);
            exit();
        }

        $data = [
            'title' => $title,
            'author_id' => $author_id,
            'isbn' => $isbn,
            'publisher_id' => $publisher_id,
            'category_id' => $category_id,
            'price' => $price,
            'discount_price' => $discount_price,
            'stock_quantity' => $stock_quantity,
            'description' => $description,
            'is_active' => $is_active,
            'is_featured' => $is_featured,
            'cover_image' => $coverFileName,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $updated = $this->productModel->updateProduct($bookId, $data);
        
        if ($updated) {
            $_SESSION['admin_success'] = 'Cập nhật sách thành công!';
            header('Location: ' . WEBROOT . '/admin/books');
            exit();
        } else {
            $_SESSION['admin_error'] = 'Cập nhật thất bại.';
            $_SESSION['admin_old'] = $old;
            header('Location: ' . WEBROOT . '/admin/editBook/' . $bookId);
            exit();
        }
    }
}