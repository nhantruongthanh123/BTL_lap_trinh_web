<?php
class Product extends BaseController {
    public $productModel;
    public $categoryModel;
    public $reviewModel;

    public function __construct() {
        $this->productModel = $this->model('ProductModel');
        $this->categoryModel = $this->model('CategoryModel');
        $this->reviewModel = $this->model('ReviewModel');
    }

    public function index() {
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 12; 
        $offset = ($currentPage - 1) * $perPage;

        $products = $this->productModel->getAllProducts();
        $paginatedProducts = $this->productModel->getProductsPaginated($perPage, $offset);
        $totalProducts = $this->productModel->countAllProducts();
        $totalPage = ceil($totalProducts / $perPage);
        $categories = $this->categoryModel->getAllCategories();

        $data = [
            'products' => $products,
            'paginatedProducts' => $paginatedProducts,
            'currentPage' => $currentPage,
            'totalPage' => $totalPage,
            'totalProducts' => $totalProducts,
            'categories' => $categories,
            'page'     => 'product',
            'title' => 'Tất cả sản phẩm - Bookstore'
        ];

        $this->render('Block/header', $data);
        $this->render('Product/index', $data);
        $this->render('Block/footer');
    }

    public function category($slug) {
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 8;
        $offset = ($currentPage - 1) * $perPage;

        $products = $this->productModel->getProductsByCategory($slug);
        $paginatedProducts = $this->productModel->getProductsByCategoryPaginated($slug, $perPage, $offset);
        $totalProducts = $this->productModel->countProductsByCategory($slug);
        $totalPage = ceil($totalProducts / $perPage);
        $categories = $this->categoryModel->getAllCategories();
        
        foreach ($categories as $cat) {
            if ($cat['slug'] === $slug) {
                $categoryName = $cat['category_name'];
                break;
            }
        }
        $data = [
            'products' => $products,
            'paginatedProducts' => $paginatedProducts,
            'currentPage' => $currentPage,
            'totalPage' => $totalPage,
            'totalProducts' => $totalProducts,
            'categorySlug' => $slug,
            'categories' => $categories,
            'page'     => 'product',
            'title' => $categoryName . ' - Bookstore'
        ];
        
        $this->render('Block/header', $data);
        $this->render('Product/category', $data);
        $this->render('Block/footer');
    }

    public function detail($bookId) {
        $book = $this->productModel->getBookById($bookId);
        if (!$book) {
            require_once ROOT . '../errors/404.php';
            exit;
        }

        $relatedBooks = $this->productModel->getRelatedBooks($book['category_id'], $bookId);
        $categories = $this->categoryModel->getAllCategories();

        $currentReviewPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 5;
        $offset = ($currentReviewPage - 1) * $perPage;

        $reviews = $this->reviewModel->getReviewsByBookId($bookId, $perPage, $offset);
        $totalReviews = $this->reviewModel->countReviewsByBookId($bookId);
        $totalReviewPages = ceil($totalReviews / $perPage);
        $ratingStats = $this->reviewModel->getBookRatingStats($bookId);

        $userReview = null;
        $canReview = false;
        $isPurchased = false;
        
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $userReview = $this->reviewModel->getUserReviewForBook($bookId, $userId);
            $isPurchased = $this->reviewModel->hasUserPurchased($bookId, $userId);
            $canReview = !$userReview; 
        }
        
        $data = [
            'book' => $book,
            'relatedBooks' => $relatedBooks,
            'categories' => $categories,
            'reviews' => $reviews,
            'totalReviews' => $totalReviews,
            'currentReviewPage' => $currentReviewPage,
            'totalReviewPages' => $totalReviewPages,
            'ratingStats' => $ratingStats,
            'userReview' => $userReview,
            'canReview' => $canReview,
            'isPurchased' => $isPurchased,
            'page'     => 'product',
            'title' => $book['title'] . ' - Bookstore'
        ];
        
        $this->render('Block/header', $data);
        $this->render('Product/detail', $data);
        $this->render('Block/footer');
    }

    public function addReview() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để đánh giá']);
            exit;
        }
        
        $bookId = isset($_POST['book_id']) ? (int)$_POST['book_id'] : 0;
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
        $userId = $_SESSION['user_id'];
        
        // Validate
        if ($rating < 1 || $rating > 5) {
            echo json_encode(['success' => false, 'message' => 'Đánh giá phải từ 1 đến 5 sao']);
            exit;
        }
        
        if (empty($comment)) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập nội dung đánh giá']);
            exit;
        }
        
        // Kiểm tra đã review chưa
        if ($this->reviewModel->hasUserReviewed($bookId, $userId)) {
            echo json_encode(['success' => false, 'message' => 'Bạn đã đánh giá sách này rồi']);
            exit;
        }
        
        // Kiểm tra đã mua sách chưa
        $isPurchased = $this->reviewModel->hasUserPurchased($bookId, $userId);
        
        $data = [
            'book_id' => $bookId,
            'user_id' => $userId,
            'rating' => $rating,
            'comment' => $comment,
            'is_verified_purchase' => $isPurchased ? 1 : 0
        ];
        
        if ($this->reviewModel->addReview($data)) {
            echo json_encode(['success' => true, 'message' => 'Đánh giá của bạn đã được gửi thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại']);
        }
        exit;
    }

    // API: Cập nhật review
    public function updateReview() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập']);
            exit;
        }
        
        $reviewId = isset($_POST['review_id']) ? (int)$_POST['review_id'] : 0;
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
        $userId = $_SESSION['user_id'];
        
        // Validate
        if ($rating < 1 || $rating > 5) {
            echo json_encode(['success' => false, 'message' => 'Đánh giá phải từ 1 đến 5 sao']);
            exit;
        }
        
        if (empty($comment)) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập nội dung đánh giá']);
            exit;
        }
        
        $data = [
            'rating' => $rating,
            'comment' => $comment
        ];
        
        if ($this->reviewModel->updateReview($reviewId, $userId, $data)) {
            echo json_encode(['success' => true, 'message' => 'Cập nhật đánh giá thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại']);
        }
        exit;
    }

    // API: Xóa review
    public function deleteReview() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập']);
            exit;
        }
        
        $reviewId = isset($_POST['review_id']) ? (int)$_POST['review_id'] : 0;
        $userId = $_SESSION['user_id'];
        
        if ($this->reviewModel->deleteReview($reviewId, $userId)) {
            echo json_encode(['success' => true, 'message' => 'Xóa đánh giá thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại']);
        }
        exit;
    }

    public function search() {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        if (empty($keyword)) {
            header("Location: " . WEBROOT . "/product");
            exit;
        }

        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 8;
        $offset = ($currentPage - 1) * $perPage;



        $products = $this->productModel->searchBooks($keyword);
        $categories = $this->categoryModel->getAllCategories();

        $data = [
            'products' => $products,
            'categories' => $categories,
            'keyword' => $keyword,
            'page' => 'product',
            'title' => 'Kết quả tìm kiếm: "' . htmlspecialchars($keyword) . '" - Bookstore'
        ];
        
        $this->render('Block/header', $data);
        $this->render('Product/search', $data);
        $this->render('Block/footer');
    }

}
?>