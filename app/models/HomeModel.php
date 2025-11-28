<?php

// Ke thua tu class model

class HomeModel {
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