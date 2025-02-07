<?php
namespace Api\Controllers;

class AppointmentController {
    private $model;

    public function __construct() {
        $this->model = new \Api\Models\AppointmentModel();
    }

    public function handleRequest($method, $path) {
        try {
            switch ($method) {
                case 'POST':
                    return $this->createAppointment();
                case 'GET':
                    return isset($path[2]) ? 
                           $this->getAppointment($path[2]) : 
                           $this->sendError("Appointment ID required", 400);
                case 'PUT':
                    return isset($path[2]) ? 
                           $this->updateAppointment($path[2]) : 
                           $this->sendError("Appointment ID required", 400);
                default:
                    return $this->sendError("Method not allowed", 405);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    private function createAppointment() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->validateAppointment($data);
        
        if (!$this->model->checkAvailability($data['appointment_date'], $data['appointment_time'])) {
            return $this->sendError("Time slot not available", 400);
        }

        $id = $this->model->create($data);
        return $this->sendResponse(['id' => $id], 201);
    }

    private function getAppointment($id) {
        $appointment = $this->model->getById($id);
        return $appointment ? 
               $this->sendResponse($appointment) : 
               $this->sendError("Appointment not found", 404);
    }

    private function updateAppointment($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        return $this->model->update($id, $data) ? 
               $this->sendResponse(['success' => true]) : 
               $this->sendError("Update failed", 400);
    }

    private function sendResponse($data, $status = 200) {
        http_response_code($status);
        return ['status' => 'success', 'data' => $data];
    }

    private function sendError($message, $status) {
        http_response_code($status);
        return ['status' => 'error', 'message' => $message];
    }
}
