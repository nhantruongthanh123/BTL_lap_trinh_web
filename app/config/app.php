<?php

class App{
    
    private $__controller, $__action, $__params;

    function __construct(){
        global $routes;

        $this->__controller = $routes['default_controller'];
        $this->__action = 'index';
        $this->__params = [];

        $this->handlerUrl();
    }

    function getUrl(){
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        }
        else {
            $url = '/';
        }
        return $url;
    }

    public function handlerUrl(){
        $url = $this->getUrl();

        $urlarr = array_filter(explode('/',$url));
        $urlarr = array_values($urlarr);
        
        // Controller
        if (!empty($urlarr[0])) {
            $this->__controller = ucfirst($urlarr[0]);
        }
        else {
            $this->__controller = ucfirst($this->__controller);
        }

        if (file_exists('app/controllers/'.($this->__controller).'.php')) {
            require_once 'app/controllers/'.($this->__controller).'.php';

            // Check class exists
            if (!class_exists($this->__controller)) {
                $this->loadError('404');
                return;
            }
            
            $this->__controller = new $this->__controller;
            unset($urlarr[0]);
        }
        else {
            $this->loadError('404');
            return;
        } 

        // Action
        if (!empty($urlarr[1])) {
            $this->__action = $urlarr[1];
            unset($urlarr[1]);
        }
        
        // Check action exists
        if (method_exists($this->__controller, $this->__action)) {
            $this->__params = array_values($urlarr);
            call_user_func_array([$this->__controller, $this->__action], $this->__params);
        }
        else {
            $this->loadError('404');
            return;
        }
    }

    public function loadError($name='404'){
        require_once 'app/errors/'.$name.'.php';
    }
}

?>