<?php
namespace Api\Core;

abstract class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = \Api\Config\Database::getInstance()->getConnection();
    }

    abstract public function create(array $data);
    abstract public function read($id);
    abstract public function update($id, array $data);
    abstract public function delete($id);
}