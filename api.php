<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

require_once 'StockAPI.php';

try {
    $stockAPI = new StockAPI();
    
    // Obtener parámetros
    $symbol = $_GET['symbol'] ?? null;
    $action = $_GET['action'] ?? 'quote';
    
    if (!$symbol) {
        throw new Exception('Symbol parameter is required');
    }
    
    switch ($action) {
        case 'quote':
            $result = $stockAPI->getQuote($symbol);
            break;
        case 'trend':
            $result = $stockAPI->getTrend($symbol);
            break;
        case 'history':
            $days = $_GET['days'] ?? 30;
            $result = $stockAPI->getHistory($symbol, $days);
            break;
        default:
            throw new Exception('Invalid action parameter');
    }
    
    echo json_encode([
        'success' => true,
        'data' => $result,
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