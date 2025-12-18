<?php
header("Content-Type: application/json");

$response = [
    'status' => 'success',
    'message' => 'Frederick Rat',
    'timestamp' => date('Y-m-d H:i:s'),
    'method' => $_SERVER['REQUEST_METHOD'],
];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['name'])) {
        $response['greeting'] = "Bonjour, " . htmlspecialchars($_GET['name']) . " !";
    }
}

http_response_code(200);
echo json_encode($response, JSON_PRETTY_PRINT);
?>
