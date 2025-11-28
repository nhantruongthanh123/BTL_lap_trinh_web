<?php
class ProductModel {
    protected $_table = 'products';

    public function getList(){
        $_data = [
            'item1',
            'item2',
            'item3'
        ];
        return $_data;
    }
}