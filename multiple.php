<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'StockAPI.php';

try {
    $stockAPI = new StockAPI();
    $symbols = $_GET['symbols'] ?? '';
    
    if (empty($symbols)) {
        throw new Exception('Symbols parameter is required (comma-separated)');
    }
    
    $symbolArray = array_map('trim', explode(',', $symbols));
    $result = $stockAPI->getMultipleQuotes($symbolArray);
    
    echo json_encode([
        'success' => true,
        'data' => $result,
        'count' => count($result),
        'timestamp' => time()
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'timestamp' => time()
    ]);
}
?>