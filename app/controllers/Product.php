<?php
class Product extends BaseController {
    public $productModel;
    public $data;
    public $categoryModel;

    public function __construct() {
        $this->productModel = $this->model('ProductModel');
        $this->categoryModel = $this->model('CategoryModel');
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
        
        $data = [
            'book' => $book,
            'relatedBooks' => $relatedBooks,
            'categories' => $categories,
            'page'     => 'product',
            'title' => $book['title'] . ' - Bookstore'
        ];

        

        $this->render('Block/header', $data);
        $this->render('Product/detail', $data);
        $this->render('Block/footer');
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