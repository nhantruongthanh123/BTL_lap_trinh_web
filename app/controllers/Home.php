<?php
class Home extends BaseController {
    public $model;

    public function __construct() {
        $this->model = $this->model('HomeModel');
    }

    public function index() {
        $this->render('Block/header', ['title' => 'Trang chủ - Bookstore']);
        $this->render('Home/index');
        $this->render('Block/footer');
    }
}
?>