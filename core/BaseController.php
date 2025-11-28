<?php

class BaseController {
    public function model($model){
        $modelPath = ROOT . '/app/models/' . $model . '.php';
        if (file_exists($modelPath)){
            require_once $modelPath;
            if (class_exists($model)){
                return new $model();
            }
        }

        return false;
        
    }

    public function render($view, $data = []){
        extract($data);

        if (file_exists(ROOT . '/app/views/' . $view . '.php')){
            require_once ROOT . '/app/views/' . $view . '.php';
        }
    }
}