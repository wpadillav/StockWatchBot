<?php

require_once 'CacheManager.php';

class StockAPI {
    
    private $apiKey;
    private $config;
    private $cache;
    private $baseUrl = 'https://api.polygon.io/v2';
    private $fallbackUrl = 'https://api.twelvedata.com/v1';
    
    public function __construct() {
        // Cargar configuración
        $this->config = include 'config.php';
        
        // Configurar API key
        $this->apiKey = $_ENV['STOCK_API_KEY'] ?? $this->config['api_keys']['alpha_vantage'] ?? 'demo';
        
        // Inicializar cache
        if ($this->config['cache']['enabled']) {
            $this->cache = new CacheManager(
                $this->config['cache']['path'],
                $this->config['cache']['duration']
            );
        }
    }
    
    /**
     * Obtener cotización actual de una acción
     */
    public function getQuote($symbol) {
        $symbol = strtoupper($symbol);
        $cacheKey = "quote_{$symbol}";
        
        // Intentar obtener desde cache
        if ($this->cache && $this->cache->exists($cacheKey)) {
            return $this->cache->get($cacheKey);
        }
        
        // Intentar obtener datos reales de Yahoo Finance
        try {
            $result = $this->getYahooFinanceData($symbol);
            
            // Si los datos reales fallan, usar datos simulados
            if (!$result) {
                $result = $this->getSimulatedData($symbol);
                $result['note'] = 'Datos simulados - API externa no disponible';
            }
        } catch (Exception $e) {
            // En caso de error, usar datos simulados
            $result = $this->getSimulatedData($symbol);
            $result['note'] = 'Datos simulados - Error en API externa: ' . $e->getMessage();
        }
        
        // Guardar en cache si está habilitado
        if ($this->cache) {
            $this->cache->set($cacheKey, $result);
        }
        
        return $result;
    }
    
    /**
     * Obtener datos reales de Yahoo Finance
     */
    private function getYahooFinanceData($symbol) {
        $url = "https://query1.finance.yahoo.com/v8/finance/chart/{$symbol}";
        
        try {
            $data = $this->makeRequest($url);
            
            if (isset($data['chart']['result'][0])) {
                $chartData = $data['chart']['result'][0];
                $meta = $chartData['meta'];
                $quote = $chartData['indicators']['quote'][0];
                
                // Obtener el último precio disponible
                $timestamps = $chartData['timestamp'];
                $closes = $quote['close'];
                $opens = $quote['open'];
                $highs = $quote['high'];
                $lows = $quote['low'];
                $volumes = $quote['volume'];
                
                $lastIndex = count($closes) - 1;
                $currentPrice = $closes[$lastIndex];
                $openPrice = $opens[$lastIndex];
                $highPrice = $highs[$lastIndex];
                $lowPrice = $lows[$lastIndex];
                $volume = $volumes[$lastIndex];
                
                // Calcular cambio
                $previousClose = $meta['previousClose'];
                $change = $currentPrice - $previousClose;
                $changePercent = round(($change / $previousClose) * 100, 2);
                
                return [
                    'symbol' => $symbol,
                    'price' => round($currentPrice, 2),
                    'change' => round($change, 2),
                    'change_percent' => $changePercent . '%',
                    'volume' => intval($volume),
                    'high' => round($highPrice, 2),
                    'low' => round($lowPrice, 2),
                    'open' => round($openPrice, 2),
                    'previous_close' => round($previousClose, 2),
                    'trend' => $change > 0 ? 'UP' : ($change < 0 ? 'DOWN' : 'NEUTRAL'),
                    'source' => 'Yahoo Finance',
                    'timestamp' => end($timestamps)
                ];
            }
            
            return null;
        } catch (Exception $e) {
            throw new Exception('Error consultando Yahoo Finance: ' . $e->getMessage());
        }
    }
    
    /**
     * Obtener tendencia de la acción
     */
    public function getTrend($symbol) {
        $quote = $this->getQuote($symbol);
        
        return [
            'symbol' => $symbol,
            'trend' => $quote['trend'],
            'change' => $quote['change'],
            'change_percent' => $quote['change_percent'],
            'recommendation' => $this->getRecommendation($quote['change'])
        ];
    }
    
    /**
     * Obtener historial de precios
     */
    public function getHistory($symbol, $days = 30) {
        $symbol = strtoupper($symbol);
        $cacheKey = "history_{$symbol}_{$days}";
        
        // Intentar obtener desde cache
        if ($this->cache && $this->cache->exists($cacheKey)) {
            return $this->cache->get($cacheKey);
        }
        
        try {
            // Obtener datos reales de Yahoo Finance
            $result = $this->getYahooHistoryData($symbol, $days);
            
            if (!$result) {
                // Fallback a datos simulados
                $result = $this->getSimulatedHistoryData($symbol, $days);
                $result['note'] = 'Datos simulados - API externa no disponible';
            }
        } catch (Exception $e) {
            // En caso de error, usar datos simulados
            $result = $this->getSimulatedHistoryData($symbol, $days);
            $result['note'] = 'Datos simulados - Error en API externa: ' . $e->getMessage();
        }
        
        // Guardar en cache
        if ($this->cache) {
            $this->cache->set($cacheKey, $result);
        }
        
        return $result;
    }
    
    /**
     * Obtener historial real de Yahoo Finance
     */
    private function getYahooHistoryData($symbol, $days) {
        // Calcular timestamps
        $endTime = time();
        $startTime = $endTime - ($days * 24 * 60 * 60);
        
        $url = "https://query1.finance.yahoo.com/v8/finance/chart/{$symbol}?period1={$startTime}&period2={$endTime}&interval=1d";
        
        try {
            $data = $this->makeRequest($url);
            
            if (isset($data['chart']['result'][0])) {
                $chartData = $data['chart']['result'][0];
                $timestamps = $chartData['timestamp'];
                $quote = $chartData['indicators']['quote'][0];
                
                $history = [];
                $closes = $quote['close'];
                $volumes = $quote['volume'];
                
                for ($i = 0; $i < count($timestamps); $i++) {
                    if (isset($closes[$i]) && $closes[$i] !== null) {
                        $history[] = [
                            'date' => date('Y-m-d', $timestamps[$i]),
                            'price' => round($closes[$i], 2),
                            'volume' => intval($volumes[$i] ?? 0)
                        ];
                    }
                }
                
                return [
                    'symbol' => $symbol,
                    'period' => $days,
                    'data' => $history,
                    'source' => 'Yahoo Finance'
                ];
            }
            
            return null;
        } catch (Exception $e) {
            throw new Exception('Error obteniendo historial: ' . $e->getMessage());
        }
    }
    
    /**
     * Obtener historial simulado
     */
    private function getSimulatedHistoryData($symbol, $days) {
        // Simular datos históricos para demo
        $history = [];
        $basePrice = rand(100, 500);
        
        for ($i = $days; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $volatility = (rand(-5, 5) / 100);
            $price = $basePrice * (1 + $volatility);
            $basePrice = $price;
            
            $history[] = [
                'date' => $date,
                'price' => round($price, 2),
                'volume' => rand(1000000, 50000000)
            ];
        }
        
        return [
            'symbol' => $symbol,
            'period' => $days,
            'data' => $history,
            'source' => 'Simulated Data'
        ];
    }
    
    /**
     * Realizar solicitud HTTP
     */
    private function makeRequest($url) {
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Cache-Control: no-cache'
            ]
        ]);
        
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        
        curl_close($curl);
        
        if ($error) {
            throw new Exception("Error de conexión: {$error}");
        }
        
        if ($httpCode !== 200) {
            throw new Exception("API request failed with HTTP code: {$httpCode}");
        }
        
        $data = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response from API: ' . json_last_error_msg());
        }
        
        return $data;
    }
    
    /**
     * Generar datos simulados para demo
     */
    private function getSimulatedData($symbol) {
        $basePrice = rand(50, 500);
        $change = rand(-20, 20);
        $changePercent = round(($change / $basePrice) * 100, 2);
        
        return [
            'symbol' => $symbol,
            'price' => round($basePrice + $change, 2),
            'change' => $change,
            'change_percent' => $changePercent . '%',
            'volume' => rand(1000000, 50000000),
            'high' => round($basePrice + $change + rand(1, 10), 2),
            'low' => round($basePrice + $change - rand(1, 10), 2),
            'open' => round($basePrice, 2),
            'previous_close' => round($basePrice, 2),
            'trend' => $change > 0 ? 'UP' : ($change < 0 ? 'DOWN' : 'NEUTRAL'),
            'note' => 'Simulated data for demo purposes'
        ];
    }
    
    /**
     * Obtener recomendación basada en el cambio
     */
    private function getRecommendation($change) {
        if ($change > 5) {
            return 'STRONG_BUY';
        } elseif ($change > 0) {
            return 'BUY';
        } elseif ($change < -5) {
            return 'STRONG_SELL';
        } elseif ($change < 0) {
            return 'SELL';
        } else {
            return 'HOLD';
        }
    }
    
    /**
     * Obtener múltiples cotizaciones
     */
    public function getMultipleQuotes($symbols) {
        $quotes = [];
        
        foreach ($symbols as $symbol) {
            try {
                $quotes[$symbol] = $this->getQuote($symbol);
            } catch (Exception $e) {
                $quotes[$symbol] = ['error' => $e->getMessage()];
            }
        }
        
        return $quotes;
    }
    
    /**
     * Buscar acciones por nombre o símbolo
     */
    public function searchSymbols($query) {
        // Lista de símbolos comunes para demo
        $commonSymbols = [
            'AAPL' => 'Apple Inc.',
            'GOOGL' => 'Alphabet Inc.',
            'MSFT' => 'Microsoft Corporation',
            'AMZN' => 'Amazon.com Inc.',
            'TSLA' => 'Tesla Inc.',
            'META' => 'Meta Platforms Inc.',
            'NFLX' => 'Netflix Inc.',
            'NVDA' => 'NVIDIA Corporation',
            'AMD' => 'Advanced Micro Devices',
            'INTC' => 'Intel Corporation'
        ];
        
        $query = strtoupper($query);
        $results = [];
        
        foreach ($commonSymbols as $symbol => $name) {
            if (strpos($symbol, $query) !== false || strpos(strtoupper($name), $query) !== false) {
                $results[] = [
                    'symbol' => $symbol,
                    'name' => $name
                ];
            }
        }
        
        return $results;
    }
}
?>