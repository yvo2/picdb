<?php

class Repository {
    protected $db;
    protected $table;

    function __construct($table)
    {
        $this->table = $table;
        $this->db = ConnectionManager::obtainConnection();
    }

    public function readById($id) {
        $prepared = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $prepared->bind_param('i', $id);

        $prepared->execute();

        return $prepared->get_result();
    }

}