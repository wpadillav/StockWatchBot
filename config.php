<?php
/**
 * Configuración de la API de Bolsa de Valores
 */

return [
    // Configuración de APIs externas
    'api_keys' => [
        'alpha_vantage' => 'YOUR_ALPHA_VANTAGE_KEY', // Obtener en: https://www.alphavantage.co/support/#api-key
        'twelvedata' => 'YOUR_TWELVEDATA_KEY',       // Obtener en: https://twelvedata.com/
        'polygon' => 'YOUR_POLYGON_KEY'              // Obtener en: https://polygon.io/
    ],
    
    // URLs base de las APIs
    'api_urls' => [
        'alpha_vantage' => 'https://www.alphavantage.co/query',
        'twelvedata' => 'https://api.twelvedata.com/v1',
        'polygon' => 'https://api.polygon.io/v2'
    ],
    
    // Configuración de cache
    'cache' => [
        'enabled' => true,
        'duration' => 60, // 1 minuto para datos reales (antes eran 5 minutos)
        'path' => '/PATCH/api/cache/'
    ],
    
    // Límites de rate limiting
    'rate_limit' => [
        'enabled' => true,
        'requests_per_minute' => 100,
        'requests_per_hour' => 1000
    ],
    
    // Símbolos más populares para demo
    'popular_symbols' => [
        'US' => [
            'AAPL' => 'Apple Inc.',
            'GOOGL' => 'Alphabet Inc.',
            'MSFT' => 'Microsoft Corporation',
            'AMZN' => 'Amazon.com Inc.',
            'TSLA' => 'Tesla Inc.',
            'META' => 'Meta Platforms Inc.',
            'NFLX' => 'Netflix Inc.',
            'NVDA' => 'NVIDIA Corporation'
        ],
        'ES' => [
            'SAN.MC' => 'Banco Santander',
            'BBVA.MC' => 'Banco Bilbao Vizcaya Argentaria',
            'IBE.MC' => 'Iberdrola',
            'ITX.MC' => 'Inditex',
            'TEF.MC' => 'Telefónica'
        ]
    ],
    
    // Configuración de respuestas
    'response' => [
        'format' => 'json',
        'include_metadata' => true,
        'timezone' => 'Europe/Madrid'
    ]
];
?>