<?php
class Home extends BaseController {
    public $model;

    public function __construct() {
        $this->model = $this->model('HomeModel');
    }

    public function index() {
        $data = $this->model->getList();
        echo "Home Page<br>";
        
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

}
?>