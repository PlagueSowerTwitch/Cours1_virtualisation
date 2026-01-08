<?php
header("Content-Type: application/json");

$response = [
    'service' => 'SurnameService',
    'message' => 'Frederick Rat',
    'timestamp' => date('Y-m-d H:i:s'),
    'method' => $_SERVER['REQUEST_METHOD'],
];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['name'])) {
        $response['greeting'] = "Bonjour, " . htmlspecialchars($_GET['name']) . " !";
    }
    
    // Appel au RentalService
    try {
        $rentalServiceUrl = "http://rental-service:8080/bonjour";
        $context = stream_context_create([
            'http' => ['timeout' => 5]
        ]);
        $rentalResponse = @file_get_contents($rentalServiceUrl, false, $context);
        if ($rentalResponse !== false) {
            $response['rentalService'] = $rentalResponse;
        }
    } catch (Exception $e) {
        $response['rentalService'] = 'Service unavailable: ' . $e->getMessage();
    }
}

http_response_code(200);
echo json_encode($response, JSON_PRETTY_PRINT);
?>

