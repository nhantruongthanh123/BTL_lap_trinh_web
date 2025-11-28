<?php
class Product extends BaseController {
    public $model;
    public $data;

    public function __construct() {
        $this->model = $this->model('ProductModel');
    }

    public function index() {
        $data = $this->model->getList();

        // Render view with data
        $this->data['productData'] = $data;
        $this->data['pageTitle'] = "Product List";
        $this->render('Product/list', $this->data);
    }

    public function detail() {
        $this->data['info'] = "/product/detail";
        $this->data['content']['pageTitle'] = "Product Detail Page";
        $this->data['content']['product'] = $this->model->getDetail(1);
        $this->render('Layout/client_layout', $this->data);

    }
}
?>