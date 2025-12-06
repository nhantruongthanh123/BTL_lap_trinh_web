<?php
class Home extends BaseController {
    public $homeModel;
    public $categoryModel;

    public function __construct() {
        $this->homeModel = $this->model('HomeModel');
        $this->categoryModel = $this->model('CategoryModel');
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        $data = [   'title' => 'Trang chủ - Bookstore', 
                    'page'     => 'home',
                    'categories' => $categories];

        $this->render('Block/header', $data);
        $this->render('Home/index', ['products' => $this->homeModel->getListBooks(8)]);
        $this->render('Block/footer');
    }
}
?>