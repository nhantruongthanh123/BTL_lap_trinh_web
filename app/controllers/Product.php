<?php
class Product extends BaseController {
    public $model;
    public $data;
    public $categoryModel;

    public function __construct() {
        $this->model = $this->model('ProductModel');
        $this->categoryModel = $this->model('CategoryModel');
    }

    public function index() {
        $products = $this->model->getAllProducts();
        $categories = $this->categoryModel->getAllCategories();

        $data = [
            'products' => $products,
            'categories' => $categories,
            'page'     => 'product',
            'title' => 'Tất cả sản phẩm - Bookstore'
        ];

        $this->render('Block/header', $data);
        $this->render('Product/index', $data);
        $this->render('Block/footer');
    }

    public function category($slug) {
        $products = $this->model->getProductsByCategory($slug);
        $categories = $this->categoryModel->getAllCategories();
        
        $categoryName = 'Danh mục sản phẩm';
        foreach ($categories as $cat) {
            if ($cat['slug'] === $slug) {
                $categoryName = $cat['category_name'];
                break;
            }
        }
        $data = [
            'products' => $products,
            'categories' => $categories,
            'page'     => 'product',
            'title' => $categoryName . ' - Bookstore'
        ];
        
        $this->render('Block/header', $data);
        $this->render('Product/index', $data);
        $this->render('Block/footer');
    }

    public function detail($bookId) {
        $book = $this->model->getBookById($bookId);
        if (!$book) {
            require_once ROOT . '../errors/404.php';
            exit;
        }

        $relatedBooks = $this->model->getRelatedBooks($book['category_id'], $bookId);
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

}
?>