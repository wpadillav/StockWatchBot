<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'StockAPI.php';

try {
    $stockAPI = new StockAPI();
    $query = $_GET['q'] ?? '';
    
    if (empty($query)) {
        throw new Exception('Query parameter (q) is required');
    }
    
    $result = $stockAPI->searchSymbols($query);
    
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