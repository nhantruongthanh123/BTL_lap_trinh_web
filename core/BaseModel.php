<?php
class BaseModel {
    protected $db;

    public function __construct(){
        if(class_exists('Database')){
            $this->db = Database::getInstance()->getConnection();
        }
    }

    public function getDbConnection(){
        return $this->db;
    }
}