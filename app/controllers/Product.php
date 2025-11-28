<?php
class Product extends BaseController {
    public $model;
    public $data;

    public function __construct() {
        $this->model = $this->model('ProductModel');
    }

    public function list_product() {
        $data = $this->model->getList();

        // Render view with data
        $this->data['productData'] = $data;
        $this->data['pageTitle'] = "Product List";
        $this->render('Product/list', $this->data);
    }

    public function detail() {
        $this->render('Product/detail');
    }
}
?>