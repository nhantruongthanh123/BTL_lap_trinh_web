<?php
class Home extends BaseController {
    public $model;
    public $categoryModel;

    public function __construct() {
        $this->model = $this->model('HomeModel');
        $this->categoryModel = $this->model('CategoryModel');
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        $data = [   'title' => 'Trang chủ - Bookstore', 
                    'page'     => 'home',
                    'categories' => $categories];

        $this->render('Block/header', $data);
        $this->render('Home/index', ['products' => $this->model->getListBooks(8)]);
        $this->render('Block/footer');
    }
}
?>