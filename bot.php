<?php

// Configuración del bot
define('BOT_TOKEN', 'API_KEY_HERE');
define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN . '/');

// Incluir la API de acciones
require_once 'StockAPI.php';

class TelegramBot {
    private $stockAPI;
    private $chatId;
    private $messageId;
    private $firstName;
    
    public function __construct() {
        $this->stockAPI = new StockAPI();
    }
    
    /**
     * Procesar webhook de Telegram
     */
    public function processWebhook() {
        $content = file_get_contents("php://input");
        $update = json_decode($content, true);
        
        if (!$update) {
            return;
        }
        
        // Log para depuración
        file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Update recibido: " . json_encode($update) . "\n", FILE_APPEND);
        
        // Extraer información del mensaje
        if (isset($update['message'])) {
            $message = $update['message'];
            $this->chatId = $message['chat']['id'];
            $this->messageId = $message['message_id'];
            $this->firstName = $message['from']['first_name'] ?? 'Usuario';
            $text = $message['text'] ?? '';
            
            file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Procesando comando: " . $text . "\n", FILE_APPEND);
            
            // Procesar comando
            $this->processCommand($text);
        }
        
        // Procesar callback query (botones)
        if (isset($update['callback_query'])) {
            $callbackQuery = $update['callback_query'];
            $this->chatId = $callbackQuery['message']['chat']['id'];
            $this->messageId = $callbackQuery['message']['message_id'];
            $this->firstName = $callbackQuery['from']['first_name'] ?? 'Usuario';
            
            file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Procesando callback: " . $callbackQuery['data'] . "\n", FILE_APPEND);
            
            // Procesar callback
            $this->processCallback($callbackQuery['data']);
            
            // Responder al callback query
            $this->answerCallbackQuery($callbackQuery['id']);
        }
    }
    
    /**
     * Procesar comandos del bot
     */
    private function processCommand($text) {
        $text = trim($text);
        $parts = explode(' ', $text);
        $command = strtolower($parts[0]);
        
        switch ($command) {
            case '/start':
                $this->sendWelcomeMessage();
                break;
                
            case '/help':
                $this->sendHelpMessage();
                break;
                
            case '/quote':
            case '/cotizacion':
                if (isset($parts[1])) {
                    $this->sendQuote(strtoupper($parts[1]));
                } else {
                    $this->sendStockButtons("💰 Selecciona una acción para ver su cotización:");
                }
                break;
                
            case '/trend':
            case '/tendencia':
                if (isset($parts[1])) {
                    $this->sendTrend(strtoupper($parts[1]));
                } else {
                    $this->sendStockButtons("📊 Selecciona una acción para ver su tendencia:", "trend_");
                }
                break;
                
            case '/history':
            case '/historial':
                $symbol = isset($parts[1]) ? strtoupper($parts[1]) : null;
                
                if ($symbol) {
                    $this->sendHistory($symbol);
                } else {
                    $this->sendStockButtons("📅 Selecciona una acción para ver información de historial:", "trend_");
                }
                break;
                
            case '/popular':
            case '/populares':
                $this->sendStockButtons("🌟 Acciones Populares - Toca para ver cotización:");
                break;
                
            case '/search':
            case '/buscar':
                if (isset($parts[1])) {
                    $query = implode(' ', array_slice($parts, 1));
                    $this->searchSymbols($query);
                } else {
                    $this->sendMessage("❌ Por favor especifica qué buscar: `/search Apple`");
                }
                break;
                
            default:
                // Si no es un comando, asumir que es un símbolo
                if (preg_match('/^[A-Z]{1,5}(\.[A-Z]{2})?$/', strtoupper($text))) {
                    $this->sendQuote(strtoupper($text));
                } else {
                    $this->sendMessage("❓ Comando no reconocido. Usa /help para ver los comandos disponibles.");
                }
                break;
        }
    }
    
    /**
     * Procesar callback data del bot
     */
    private function processCallback($data) {
        file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Procesando callback data: " . $data . "\n", FILE_APPEND);
        
        if ($data === 'quote_all') {
            file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Enviando botones de acciones\n", FILE_APPEND);
            $this->sendStockButtons();
        } 
        else if (strpos($data, 'quote_') === 0) {
            $symbol = substr($data, 6);
            file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Obteniendo cotización para: " . $symbol . "\n", FILE_APPEND);
            $this->sendQuote($symbol);
        }
        else if (strpos($data, 'trend_') === 0) {
            $symbol = substr($data, 6);
            file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Obteniendo tendencia para: " . $symbol . "\n", FILE_APPEND);
            $this->sendTrend($symbol);
        }
        else if ($data === 'main_menu') {
            file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Volviendo al menú principal\n", FILE_APPEND);
            $this->sendStockButtons();
        }
        else if ($data === 'more_stocks') {
            file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Mostrando más acciones\n", FILE_APPEND);
            $this->sendMoreStockButtons();
        }
        else if ($data === 'spanish_stocks') {
            file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Mostrando acciones españolas\n", FILE_APPEND);
            $this->sendSpanishStockButtons();
        }
        else {
            file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Callback no reconocido: " . $data . "\n", FILE_APPEND);
        }
    }
    
    /**
     * Responder al callback query
     */
    private function answerCallbackQuery($callbackQueryId, $text = '') {
        $this->makeApiRequest('answerCallbackQuery', [
            'callback_query_id' => $callbackQueryId,
            'text' => $text
        ]);
    }
    
    /**
     * Enviar mensaje de bienvenida
     */
    private function sendWelcomeMessage() {
        $message = "🎉 ¡Hola *{$this->firstName}*! Bienvenido a *BolsaBot ES*\n\n";
        $message .= "📈 *¿Qué puedo hacer por ti?*\n\n";
        $message .= "• Consultar cotizaciones en tiempo real\n";
        $message .= "• Analizar tendencias de acciones\n";
        $message .= "• Obtener historiales de precios\n";
        $message .= "• Buscar símbolos bursátiles\n\n";
        $message .= "🚀 *Comienza consultando META (Meta/Facebook):*";
        
        // Botón especial para META
        $keyboard = [
            [
                ['text' => '📘 Ver META (Facebook)', 'callback_data' => 'quote_META']
            ],
            [
                ['text' => '🌟 Ver Todas las Acciones', 'callback_data' => 'quote_all']
            ]
        ];
        
        $this->sendMessageWithKeyboard($message, $keyboard, true);
    }
    
    /**
     * Enviar mensaje de ayuda
     */
    private function sendHelpMessage() {
        $message = "📋 *Comandos disponibles:*\n\n";
        $message .= "🔸 *Cotizaciones:*\n";
        $message .= "• `/quote SYMBOL` - Cotización actual\n";
        $message .= "• `SYMBOL` - Atajo para cotización\n\n";
        $message .= "🔸 *Análisis:*\n";
        $message .= "• `/trend SYMBOL` - Tendencia y análisis\n";
        $message .= "• `/history SYMBOL` - Información de historial\n\n";
        $message .= "🔸 *Búsqueda:*\n";
        $message .= "• `/search EMPRESA` - Buscar símbolo\n";
        $message .= "• `/popular` - Acciones más populares\n\n";
        $message .= "🔸 *Información:*\n";
        $message .= "• `/help` - Este mensaje\n\n";
        $message .= "📝 *Ejemplos:*\n";
        $message .= "`/quote AAPL`\n";
        $message .= "`/trend MSFT`\n";
        $message .= "`/history TSLA`\n";
        $message .= "`GOOGL`\n\n";
        $message .= "💡 *Tip:* También puedes escribir directamente el símbolo (ej: AAPL)";
        
        $this->sendMessage($message, true);
    }
    
    /**
     * Enviar cotización de una acción
     */
    private function sendQuote($symbol) {
        try {
            file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Iniciando sendQuote para: " . $symbol . "\n", FILE_APPEND);
            
            $this->sendTypingAction();
            $quote = $this->stockAPI->getQuote($symbol);
            
            file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Datos obtenidos para " . $symbol . ": " . json_encode($quote) . "\n", FILE_APPEND);
            
            $changeIcon = $quote['change'] >= 0 ? '📈' : '📉';
            $changeColor = $quote['change'] >= 0 ? '🟢' : '🔴';
            
            $message = "$changeIcon *{$quote['symbol']}*\n\n";
            $message .= "💰 *Precio:* \${$quote['price']}\n";
            $message .= "$changeColor *Cambio:* {$quote['change']} ({$quote['change_percent']})\n\n";
            
            if (isset($quote['volume'])) {
                $message .= "📊 *Volumen:* " . number_format($quote['volume']) . "\n";
            }
            
            if (isset($quote['high']) && isset($quote['low'])) {
                $message .= "⬆️ *Máximo:* \${$quote['high']}\n";
                $message .= "⬇️ *Mínimo:* \${$quote['low']}\n";
            }
            
            $message .= "\n🕐 *Actualizado:* " . date('H:i:s');
            
            if (isset($quote['source'])) {
                $message .= "\n📡 *Fuente:* {$quote['source']}";
            }
            
            if (isset($quote['note'])) {
                $message .= "\n💡 {$quote['note']}";
            }
            
            // Agregar botones para más acciones
            $keyboard = [
                [
                    ['text' => '📊 Ver Tendencia', 'callback_data' => 'trend_' . $symbol],
                    ['text' => ' Actualizar', 'callback_data' => 'quote_' . $symbol]
                ],
                [
                    ['text' => '⬅️ Volver a Lista', 'callback_data' => 'quote_all']
                ]
            ];
            
            file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Enviando mensaje con teclado para " . $symbol . "\n", FILE_APPEND);
            
            $this->sendMessageWithKeyboard($message, $keyboard, true);
            
        } catch (Exception $e) {
            file_put_contents('bot_debug.log', date('Y-m-d H:i:s') . " - Error en sendQuote para " . $symbol . ": " . $e->getMessage() . "\n", FILE_APPEND);
            
            $this->sendMessage("❌ Error al obtener cotización para *{$symbol}*\n\n" .
                             "💡 Verifica que el símbolo sea correcto o usa `/search` para buscar.\n\n" .
                             "Detalles: " . $e->getMessage());
        }
    }
    
    /**
     * Enviar análisis de tendencia
     */
    private function sendTrend($symbol) {
        try {
            $this->sendTypingAction();
            $quote = $this->stockAPI->getQuote($symbol);
            
            $changeIcon = $quote['change'] >= 0 ? '📈' : '📉';
            $changeColor = $quote['change'] >= 0 ? '🟢' : '🔴';
            
            $message = "📊 *Análisis de Tendencia - {$quote['symbol']}*\n\n";
            $message .= "💰 *Precio Actual:* \${$quote['price']}\n";
            $message .= "$changeColor *Cambio Hoy:* {$quote['change']} ({$quote['change_percent']})\n\n";
            
            // Análisis básico de tendencia basado en el cambio porcentual
            $change_str = str_replace(['$', '+', '%'], '', $quote['change_percent']);
            $change_num = floatval($change_str);
            
            if ($change_num > 2) {
                $trend = "� *Tendencia:* Muy alcista (+2%+)";
                $analysis = "La acción muestra un fuerte momentum positivo.";
            } elseif ($change_num > 0.5) {
                $trend = "📈 *Tendencia:* Alcista (+0.5%+)";
                $analysis = "Movimiento positivo moderado.";
            } elseif ($change_num > -0.5) {
                $trend = "➡️ *Tendencia:* Neutral (±0.5%)";
                $analysis = "La acción se mantiene estable.";
            } elseif ($change_num > -2) {
                $trend = "📉 *Tendencia:* Bajista (-0.5%-)";
                $analysis = "Presión vendedora moderada.";
            } else {
                $trend = "⬇️ *Tendencia:* Muy bajista (-2%-)";
                $analysis = "Fuerte movimiento a la baja.";
            }
            
            $message .= "$trend\n";
            $message .= "💡 *Análisis:* $analysis\n\n";
            
            if (isset($quote['volume'])) {
                $message .= "📊 *Volumen:* " . number_format($quote['volume']) . "\n";
            }
            
            $message .= "\n⚠️ *Nota:* Este análisis es básico y no constituye asesoría financiera.";
            
            // Agregar botones para navegación
            $keyboard = [
                [
                    ['text' => '🔄 Actualizar Cotización', 'callback_data' => 'quote_' . $symbol],
                    ['text' => '⬅️ Volver a Lista', 'callback_data' => 'quote_all']
                ]
            ];
            
            $this->sendMessageWithKeyboard($message, $keyboard, true);
            
        } catch (Exception $e) {
            $this->sendMessage("❌ Error al analizar tendencia para *{$symbol}*\n\n" .
                             "Detalles: " . $e->getMessage());
        }
    }
    
    /**
     * Enviar historial de precios
     */
    private function sendHistory($symbol) {
        try {
            $this->sendTypingAction();
            
            // Mensaje informativo mejorado
            $message = "📅 *Historial de {$symbol}*\n\n";
            $message .= "📊 *Función en desarrollo*\n\n";
            $message .= "Esta función mostrará:\n";
            $message .= "• 📈 Precios de cierre históricos\n";
            $message .= "• 📊 Volúmenes de trading\n";
            $message .= "• ⬆️ Máximos y ⬇️ mínimos\n";
            $message .= "• 📉 Tendencias a largo plazo\n";
            $message .= "• 📋 Análisis técnico avanzado\n\n";
            
            $message .= "💡 *Disponible actualmente:*\n";
            $message .= "• 💰 Cotización actual en tiempo real\n";
            $message .= "• 📊 Análisis de tendencia del día\n";
            $message .= "• 📈 Comparación con otras acciones\n\n";
            
            $message .= "⚠️ *Próximamente:*\n";
            $message .= "• 📊 Gráficos interactivos\n";
            $message .= "• 📈 Datos históricos completos\n";
            $message .= "• 🔍 Análisis técnico profesional";
            
            // Botones de navegación simplificados
            $keyboard = [
                [
                    ['text' => '🔄 Ver Cotización Actual', 'callback_data' => 'quote_' . $symbol],
                    ['text' => '📊 Análisis Tendencia', 'callback_data' => 'trend_' . $symbol]
                ],
                [
                    ['text' => '⬅️ Volver a Lista', 'callback_data' => 'quote_all']
                ]
            ];
            
            $this->sendMessageWithKeyboard($message, $keyboard, true);
            
        } catch (Exception $e) {
            $this->sendMessage("❌ Error al obtener información de historial para *{$symbol}*\n\n" .
                             "Detalles: " . $e->getMessage());
        }
    }
    
    /**
     * Enviar acciones populares con botones
     */
    private function sendStockButtons($message = "🌟 Selecciona una acción:", $prefix = "quote_") {
        // META como primera opción
        $keyboard = [
            [
                ['text' => '📘 META (Facebook)', 'callback_data' => $prefix . 'META']
            ],
            [
                ['text' => '🍎 AAPL', 'callback_data' => $prefix . 'AAPL'],
                ['text' => '🔍 GOOGL', 'callback_data' => $prefix . 'GOOGL'],
                ['text' => '⊞ MSFT', 'callback_data' => $prefix . 'MSFT']
            ],
            [
                ['text' => '📦 AMZN', 'callback_data' => $prefix . 'AMZN'],
                ['text' => '⚡ TSLA', 'callback_data' => $prefix . 'TSLA'],
                ['text' => '🎮 NVDA', 'callback_data' => $prefix . 'NVDA']
            ],
            [
                ['text' => '🎬 NFLX', 'callback_data' => $prefix . 'NFLX'],
                ['text' => '💾 AMD', 'callback_data' => $prefix . 'AMD'],
                ['text' => '🖥️ INTC', 'callback_data' => $prefix . 'INTC']
            ],
            [
                ['text' => '➕ Más Acciones', 'callback_data' => 'more_stocks'],
                ['text' => '🇪🇸 Mercado Español', 'callback_data' => 'spanish_stocks']
            ]
        ];
        
        $this->sendMessageWithKeyboard($message, $keyboard, true);
    }
    
    /**
     * Enviar más acciones con botones
     */
    private function sendMoreStockButtons() {
        $message = "💼 *Más Acciones Disponibles:*";
        
        $keyboard = [
            [
                ['text' => '💳 V (Visa)', 'callback_data' => 'quote_V'],
                ['text' => '💳 MA (Mastercard)', 'callback_data' => 'quote_MA'],
                ['text' => '💰 JPM (JPMorgan)', 'callback_data' => 'quote_JPM']
            ],
            [
                ['text' => '🏦 BAC (Bank America)', 'callback_data' => 'quote_BAC'],
                ['text' => '🏛️ WFC (Wells Fargo)', 'callback_data' => 'quote_WFC'],
                ['text' => '💸 PYPL (PayPal)', 'callback_data' => 'quote_PYPL']
            ],
            [
                ['text' => '🏪 WMT (Walmart)', 'callback_data' => 'quote_WMT'],
                ['text' => '🛠️ HD (Home Depot)', 'callback_data' => 'quote_HD'],
                ['text' => '🎯 TGT (Target)', 'callback_data' => 'quote_TGT']
            ],
            [
                ['text' => '🏰 DIS (Disney)', 'callback_data' => 'quote_DIS'],
                ['text' => '🎵 SPOT (Spotify)', 'callback_data' => 'quote_SPOT'],
                ['text' => '📺 ROKU (Roku)', 'callback_data' => 'quote_ROKU']
            ],
            [
                ['text' => '⬅️ Volver a Principales', 'callback_data' => 'quote_all']
            ]
        ];
        
        $this->sendMessageWithKeyboard($message, $keyboard, true);
    }
    
    /**
     * Enviar acciones españolas con botones
     */
    private function sendSpanishStockButtons() {
        $message = "🇪🇸 *Mercado Español:*";
        
        $keyboard = [
            [
                ['text' => '🏦 SAN.MC (Santander)', 'callback_data' => 'quote_SAN.MC'],
                ['text' => '🏛️ BBVA.MC (BBVA)', 'callback_data' => 'quote_BBVA.MC']
            ],
            [
                ['text' => '⚡ IBE.MC (Iberdrola)', 'callback_data' => 'quote_IBE.MC'],
                ['text' => '👕 ITX.MC (Inditex)', 'callback_data' => 'quote_ITX.MC']
            ],
            [
                ['text' => '📞 TEF.MC (Telefónica)', 'callback_data' => 'quote_TEF.MC']
            ],
            [
                ['text' => '⬅️ Volver a Principales', 'callback_data' => 'quote_all']
            ]
        ];
        
        $this->sendMessageWithKeyboard($message, $keyboard, true);
    }
    
    /**
     * Buscar símbolos
     */
    private function searchSymbols($query) {
        $symbols = [
            'apple' => 'AAPL - Apple Inc.',
            'google' => 'GOOGL - Alphabet Inc.',
            'microsoft' => 'MSFT - Microsoft Corp.',
            'amazon' => 'AMZN - Amazon.com Inc.',
            'tesla' => 'TSLA - Tesla Inc.',
            'meta' => 'META - Meta Platforms',
            'facebook' => 'META - Meta Platforms',
            'netflix' => 'NFLX - Netflix Inc.',
            'nvidia' => 'NVDA - NVIDIA Corp.',
            'amd' => 'AMD - Advanced Micro Devices',
            'intel' => 'INTC - Intel Corp.',
            'santander' => 'SAN.MC - Banco Santander',
            'bbva' => 'BBVA.MC - BBVA',
            'iberdrola' => 'IBE.MC - Iberdrola',
            'inditex' => 'ITX.MC - Inditex',
            'telefonica' => 'TEF.MC - Telefónica'
        ];
        
        $query = strtolower($query);
        $results = [];
        
        foreach ($symbols as $name => $symbol) {
            if (strpos($name, $query) !== false) {
                $results[] = $symbol;
            }
        }
        
        if (!empty($results)) {
            $message = "🔍 *Resultados para '{$query}':*\n\n";
            foreach ($results as $result) {
                $parts = explode(' - ', $result);
                $symbol = $parts[0];
                $name = $parts[1];
                $message .= "• `{$symbol}` - {$name}\n";
            }
            $message .= "\n💡 Toca el símbolo para ver la cotización";
        } else {
            $message = "❌ No se encontraron resultados para '*{$query}*'\n\n";
            $message .= "💡 Prueba buscar:\n";
            $message .= "• Nombres de empresas en inglés\n";
            $message .= "• Símbolos conocidos (AAPL, GOOGL, etc.)\n";
            $message .= "• Usa `/popular` para ver opciones disponibles";
        }
        
        $this->sendMessage($message, true);
    }
    
    /**
     * Enviar acción de "escribiendo"
     */
    private function sendTypingAction() {
        $this->makeApiRequest('sendChatAction', [
            'chat_id' => $this->chatId,
            'action' => 'typing'
        ]);
    }
    
    /**
     * Enviar mensaje a Telegram
     */
    private function sendMessage($text, $markdown = false) {
        $params = [
            'chat_id' => $this->chatId,
            'text' => $text
        ];
        
        if ($markdown) {
            $params['parse_mode'] = 'Markdown';
        }
        
        return $this->makeApiRequest('sendMessage', $params);
    }
    
    /**
     * Enviar mensaje con teclado inline
     */
    private function sendMessageWithKeyboard($text, $keyboard, $markdown = false) {
        $params = [
            'chat_id' => $this->chatId,
            'text' => $text,
            'reply_markup' => json_encode([
                'inline_keyboard' => $keyboard
            ])
        ];
        
        if ($markdown) {
            $params['parse_mode'] = 'Markdown';
        }
        
        return $this->makeApiRequest('sendMessage', $params);
    }
    
    /**
     * Hacer petición a la API de Telegram
     */
    private function makeApiRequest($method, $params) {
        $url = API_URL . $method;
        
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($params)
            ]
        ];
        
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        return json_decode($result, true);
    }
}

// Procesar webhook
$bot = new TelegramBot();
$bot->processWebhook();

?>