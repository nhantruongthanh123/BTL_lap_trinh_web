<?php
class PublisherModel extends BaseModel {
    protected $table = 'publishers';

    public function getAllPublishers(){
        $sql = "SELECT publisher_id, publisher_name FROM {$this->table} ORDER BY publisher_name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
}