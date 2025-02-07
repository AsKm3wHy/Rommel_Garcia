<?php
namespace Api\Core;

abstract class Controller {
    protected $db;

    public function __construct() {
        $this->db = \Api\Config\Database::getInstance()->getConnection();
    }

    abstract public function processRequest(string $method, array $segments);

    protected function sendResponse($data, int $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    protected function sendError($message, int $statusCode = 400) {
        $this->sendResponse(['error' => $message], $statusCode);
    }
}