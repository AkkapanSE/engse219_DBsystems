<?php
class Response {
    public function send($data, $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function sendError($statusCode, $message) {
        http_response_code($statusCode);
        echo json_encode([
            'error' => $message
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function sendSuccess($data, $message = '', $statusCode = 200) {
        $response = ['data' => $data];
        if ($message) {
            $response['message'] = $message;
        }
        $this->send($response, $statusCode);
    }
}
?>