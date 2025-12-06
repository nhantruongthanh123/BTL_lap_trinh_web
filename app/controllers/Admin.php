<?php

class Admin extends BaseController {
    public $userModel;
    public $productModel;
    public $categoryModel;
    public $publisherModel;
    public $authorModel;
    public $orderModel;

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
        $this->orderModel = $this->model('OrderModel');
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
                $_SESSION['email']     = $user['email'];
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
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 6;
        $offset = ($currentPage - 1) * $perPage;

        $books = $this->productModel->getAllProductsAdmin(); 
        $paginatedBooks = $this->productModel->getAllProductsAdmin($perPage, $offset);
        $totalBooks = $this->productModel->countAllProducts();
        $totalPages = ceil($totalBooks / $perPage); 

        $categories = $this->categoryModel->getAllCategories();

        $data = [
            'title' => 'Quản lý Sách',
            'page'  => 'books',
            'books' => $books,
            'paginatedBooks' => $paginatedBooks,
            'categories' => $categories,
            'currentPage'=> $currentPage,       
            'totalPages' => $totalPages, 
            'totalBooks' => $totalBooks,
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


    public function categories(){
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $categories = $this->categoryModel->getAllCategories();

        $data = [
            'title' => 'Quản lý Danh mục',
            'page'  => 'categories',
            'categories' => $categories,
            'success' => $_SESSION['admin_success'] ?? '',
            'error'   => $_SESSION['admin_error'] ?? ''
        ];
        unset($_SESSION['admin_success']);
        unset($_SESSION['admin_error']);

        $this->render('Admin/inc/header', $data);
        $this->render('Admin/categories', $data);
        $this->render('Admin/inc/footer', $data);
    }

    public function categoryAddProcess() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/admin/categories');
            exit();
        }

        $category_name = trim($_POST['category_name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;


        $data = [
            'category_name' => $category_name,
            'slug' => $slug,
            'description' => $description,
            'is_active' => $is_active
        ];

        $result = $this->categoryModel->addCategory($data);

        if ($result) {
            $_SESSION['admin_success'] = 'Thêm danh mục thành công!';
        } else {
            $_SESSION['admin_error'] = 'Thêm danh mục thất bại!';
        }

        header('Location: ' . WEBROOT . '/admin/categories');
        exit();
    }

    public function categoryUpdateProcess() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/admin/categories');
            exit();
        }

        $category_id = intval($_POST['category_id'] ?? 0);
        $category_name = trim($_POST['category_name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;


        $data = [
            'category_name' => $category_name,
            'slug' => $slug,
            'description' => $description,
            'is_active' => $is_active
        ];

        $result = $this->categoryModel->updateCategory($category_id, $data);

        if ($result) {
            $_SESSION['admin_success'] = 'Cập nhật danh mục thành công!';
        } else {
            $_SESSION['admin_error'] = 'Cập nhật danh mục thất bại!';
        }

        header('Location: ' . WEBROOT . '/admin/categories');
        exit();
    }

    public function categoryDelete($categoryId) {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $deleted = $this->categoryModel->deleteCategory($categoryId);

        if ($deleted) {
            $_SESSION['admin_success'] = 'Xóa danh mục thành công!';
        } else {
            $_SESSION['admin_error'] = 'Xóa danh mục thất bại!';
        }

        header('Location: ' . WEBROOT . '/admin/categories');
    }

    public function authors(){
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $authors = $this->authorModel->getAllAuthors();

        $data = [
            'title' => 'Quản lý Tác giả',
            'page'  => 'authors',
            'authors' => $authors,
            'success' => $_SESSION['admin_success'] ?? '',
            'error'   => $_SESSION['admin_error'] ?? ''
        ];
        unset($_SESSION['admin_success']);
        unset($_SESSION['admin_error']);

        $this->render('Admin/inc/header', $data);
        $this->render('Admin/authors', $data);
        $this->render('Admin/inc/footer', $data);
    }

    public function authorAddProcess() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/admin/authors');
            exit();
        }

        $author_name = trim($_POST['author_name'] ?? '');
        $nationality = trim($_POST['nationality'] ?? '');
        $birth_date = trim($_POST['birth_date'] ?? '');
        $biography = trim($_POST['biography'] ?? '');

        // Validate
        if (empty($author_name)) {
            $_SESSION['admin_error'] = 'Tên tác giả không được để trống!';
            header('Location: ' . WEBROOT . '/admin/authors');
            exit();
        }

        $data = [
            'author_name' => $author_name,
            'nationality' => $nationality ?: null,
            'birth_date' => $birth_date ?: null,
            'biography' => $biography
        ];

        $result = $this->authorModel->addAuthor($data);

        if ($result) {
            $_SESSION['admin_success'] = 'Thêm tác giả thành công!';
        } else {
            $_SESSION['admin_error'] = 'Thêm tác giả thất bại!';
        }

        header('Location: ' . WEBROOT . '/admin/authors');
        exit();
    }

    public function authorUpdateProcess() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/admin/authors');
            exit();
        }

        $author_id = intval($_POST['author_id'] ?? 0);
        $author_name = trim($_POST['author_name'] ?? '');
        $nationality = trim($_POST['nationality'] ?? '');
        $birth_date = trim($_POST['birth_date'] ?? '');
        $biography = trim($_POST['biography'] ?? '');

        if (empty($author_name)) {
            $_SESSION['admin_error'] = 'Tên tác giả không được để trống!';
            header('Location: ' . WEBROOT . '/admin/authors');
            exit();
        }

        $data = [
            'author_name' => $author_name,
            'nationality' => $nationality ?: null,
            'birth_date' => $birth_date ?: null,
            'biography' => $biography
        ];

        $result = $this->authorModel->updateAuthor($author_id, $data);

        if ($result) {
            $_SESSION['admin_success'] = 'Cập nhật tác giả thành công!';
        } else {
            $_SESSION['admin_error'] = 'Cập nhật tác giả thất bại!';
        }

        header('Location: ' . WEBROOT . '/admin/authors');
        exit();
    }

    public function authorDelete($authorId) {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $result = $this->authorModel->deleteAuthor($authorId);

        if ($result) {
            $_SESSION['admin_success'] = 'Xóa tác giả thành công!';
        } else {
            $_SESSION['admin_error'] = 'Không thể xóa! Tác giả này đang có sách.';
        }

        header('Location: ' . WEBROOT . '/admin/authors');
        exit();
    }

    public function publishers(){
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $publishers = $this->publisherModel->getAllPublishers();

        $data = [
            'title' => 'Quản lý Nhà xuất bản',
            'page'  => 'publishers',
            'publishers' => $publishers,
            'success' => $_SESSION['admin_success'] ?? '',
            'error'   => $_SESSION['admin_error'] ?? ''
        ];
        unset($_SESSION['admin_success']);
        unset($_SESSION['admin_error']);

        $this->render('Admin/inc/header', $data);
        $this->render('Admin/publishers', $data);
        $this->render('Admin/inc/footer', $data);
    }

    public function publisherAddProcess() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/admin/publishers');
            exit();
        }

        $publisher_name = trim($_POST['publisher_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (empty($publisher_name)) {
            $_SESSION['admin_error'] = 'Tên nhà xuất bản không được để trống!';
            header('Location: ' . WEBROOT . '/admin/publishers');
            exit();
        }
        else if (!empty($phone) && !preg_match('/^0[0-9]{9}$/', $phone)) {
            $_SESSION['admin_error'] = 'Số điện thoại không hợp lệ (Phải có 10 số và bắt đầu bằng số 0)!';
            header('Location: ' . WEBROOT . '/admin/publishers');
            exit();
        }

        $data = [
            'publisher_name' => $publisher_name,
            'phone' => $phone,
            'email' => $email
        ];

        $result = $this->publisherModel->addPublisher($data);

        if ($result) {
            $_SESSION['admin_success'] = 'Thêm nhà xuất bản thành công!';
        } else {
            $_SESSION['admin_error'] = 'Thêm nhà xuất bản thất bại!';
        }

        header('Location: ' . WEBROOT . '/admin/publishers');
        exit();
    }

    public function publisherUpdateProcess() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/admin/publishers');
            exit();
        }

        $publisher_id = intval($_POST['publisher_id'] ?? 0);
        $publisher_name = trim($_POST['publisher_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (empty($publisher_name)) {
            $_SESSION['admin_error'] = 'Tên nhà xuất bản không được để trống!';
            header('Location: ' . WEBROOT . '/admin/publishers');
            exit();
        }
        else if (!empty($phone) && !preg_match('/^0[0-9]{9}$/', $phone)) {
            $_SESSION['admin_error'] = 'Số điện thoại không hợp lệ (Phải có 10 số và bắt đầu bằng số 0)!';
            header('Location: ' . WEBROOT . '/admin/publishers');
            exit();
        }

        $data = [
            'publisher_name' => $publisher_name,
            'phone' => $phone,
            'email' => $email
        ];

        $result = $this->publisherModel->updatePublisher($publisher_id, $data);

        if ($result) {
            $_SESSION['admin_success'] = 'Cập nhật nhà xuất bản thành công!';
        } else {
            $_SESSION['admin_error'] = 'Cập nhật nhà xuất bản thất bại!';
        }

        header('Location: ' . WEBROOT . '/admin/publishers');
        exit();
    }

    public function publisherDelete($publisherId) {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $result = $this->publisherModel->deletePublisher($publisherId);

        if ($result) {
            $_SESSION['admin_success'] = 'Xóa nhà xuất bản thành công!';
        } else {
            $_SESSION['admin_error'] = 'Không thể xóa! Nhà xuất bản này đang có sách.';
        }

        header('Location: ' . WEBROOT . '/admin/publishers');
        exit();
    }

    public function orders(){
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $orders = $this->orderModel->getAllOrders();

        $data = [
            'title' => 'Quản lý Đơn hàng',
            'page'  => 'orders',
            'orders' => $orders,
            'success' => $_SESSION['admin_success'] ?? '',
            'error'   => $_SESSION['admin_error'] ?? ''
        ];
        unset($_SESSION['admin_success']);
        unset($_SESSION['admin_error']);

        $this->render('Admin/inc/header', $data);
        $this->render('Admin/orders', $data);
        $this->render('Admin/inc/footer', $data);
    }

    public function orderDetail($orderId) {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        // LẤY THÔNG TIN ĐƠN HÀNG
        $order = $this->orderModel->getOrderById($orderId);
        
        if (!$order) {
            $_SESSION['admin_error'] = 'Đơn hàng không tồn tại!';
            header('Location: ' . WEBROOT . '/admin/orders');
            exit();
        }

        // LẤY CHI TIẾT SẢN PHẨM TRONG ĐƠN HÀNG
        $orderItems = $this->orderModel->getOrderItems($orderId);

        $data = [
            'title' => 'Chi tiết đơn hàng #' . $order['order_number'],
            'page'  => 'orders',
            'order' => $order,
            'orderItems' => $orderItems,
            'success' => $_SESSION['admin_success'] ?? '',
            'error'   => $_SESSION['admin_error'] ?? ''
        ];
        
        unset($_SESSION['admin_success'], $_SESSION['admin_error']);

        $this->render('Admin/inc/header', $data);
        $this->render('Admin/orderDetail', $data);
        $this->render('Admin/inc/footer', $data);
    }

    // CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG
    public function updateOrderStatus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/admin/orders');
            exit();
        }

        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $orderId = intval($_POST['order_id'] ?? 0);
        $status = trim($_POST['status'] ?? '');

        $validStatuses = ['pending', 'confirmed', 'shipping', 'delivered', 'cancelled'];
        
        if (!in_array($status, $validStatuses)) {
            $_SESSION['admin_error'] = 'Trạng thái không hợp lệ!';
            header('Location: ' . WEBROOT . '/admin/orderDetail/' . $orderId);
            exit();
        }

        $result = $this->orderModel->updateOrderStatus($orderId, $status);

        if ($result) {
            $_SESSION['admin_success'] = 'Cập nhật trạng thái đơn hàng thành công!';
        } else {
            $_SESSION['admin_error'] = 'Cập nhật trạng thái thất bại!';
        }

        header('Location: ' . WEBROOT . '/admin/orderDetail/' . $orderId);
        exit();
    }

    // CẬP NHẬT TRẠNG THÁI THANH TOÁN
    public function updatePaymentStatus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . WEBROOT . '/admin/orders');
            exit();
        }

        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $orderId = intval($_POST['order_id'] ?? 0);
        $paymentStatus = trim($_POST['payment_status'] ?? '');

        $validPaymentStatuses = ['unpaid', 'paid', 'refunded'];
        
        if (!in_array($paymentStatus, $validPaymentStatuses)) {
            $_SESSION['admin_error'] = 'Trạng thái thanh toán không hợp lệ!';
            header('Location: ' . WEBROOT . '/admin/orderDetail/' . $orderId);
            exit();
        }

        $result = $this->orderModel->updatePaymentStatus($orderId, $paymentStatus);

        if ($result) {
            $_SESSION['admin_success'] = 'Cập nhật trạng thái thanh toán thành công!';
        } else {
            $_SESSION['admin_error'] = 'Cập nhật trạng thái thanh toán thất bại!';
        }

        header('Location: ' . WEBROOT . '/admin/orderDetail/' . $orderId);
        exit();
    }

    public function customers(){
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $customers = $this->userModel->getAllCustomers();

        $data = [
            'title' => 'Quản lý Khách hàng',
            'page'  => 'customers',
            'customers' => $customers,
            'success' => $_SESSION['admin_success'] ?? '',
            'error'   => $_SESSION['admin_error'] ?? ''
        ];
        
        unset($_SESSION['admin_success'], $_SESSION['admin_error']);

        $this->render('Admin/inc/header', $data);
        $this->render('Admin/customers', $data);
        $this->render('Admin/inc/footer', $data);
    }

    // CẬP NHẬT TRẠNG THÁI KHÁCH HÀNG (ACTIVE/INACTIVE)
    public function toggleCustomerStatus($userId) {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        $user = $this->userModel->getUserById($userId);
        
        if (!$user) {
            $_SESSION['admin_error'] = 'Khách hàng không tồn tại!';
            header('Location: ' . WEBROOT . '/admin/customers');
            exit();
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        $result = $this->userModel->updateUserStatus($userId, $newStatus);

        if (isset($newStatus)) echo 'hihihi';

        if ($result) {
            $statusText = $newStatus ? 'kích hoạt' : 'vô hiệu hóa';
            $_SESSION['admin_success'] = "Đã {$statusText} tài khoản thành công!";
        } else {
            $_SESSION['admin_error'] = 'Cập nhật trạng thái thất bại!';
        }

        header('Location: ' . WEBROOT . '/admin/customers');
        exit();
    }

    // XÓA KHÁCH HÀNG
    public function deleteCustomer($userId) {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: ' . WEBROOT . '/admin/login');
            exit();
        }

        // Không cho phép xóa chính mình
        if ($userId == $_SESSION['user_id']) {
            $_SESSION['admin_error'] = 'Không thể xóa tài khoản của chính bạn!';
            header('Location: ' . WEBROOT . '/admin/customers');
            exit();
        }

        $result = $this->userModel->deleteUser($userId);

        if ($result) {
            $_SESSION['admin_success'] = 'Xóa khách hàng thành công!';
        } else {
            $_SESSION['admin_error'] = 'Không thể xóa! Khách hàng này có đơn hàng.';
        }

        header('Location: ' . WEBROOT . '/admin/customers');
        exit();
    }


}