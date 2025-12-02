<?php
class AuthorModel extends BaseModel {
    protected $table = 'authors';

    public function getAllAuthors() {
        $sql = "SELECT * FROM " . $this->table;
        return $this->db->query($sql)->fetchAll();
    }
}