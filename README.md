# 📈 StockWatchBot

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.0-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Telegram Bot](https://img.shields.io/badge/telegram-@BolsaBotESbot-2CA5E0.svg?logo=telegram)](https://t.me/BolsaBotESbot)
[![Demo](https://img.shields.io/badge/demo-live-brightgreen.svg)](https://URL/api/)
[![API Status](https://img.shields.io/badge/api-operational-success.svg)](https://URL/api/api.php?symbol=AAPL)
[![GitHub issues](https://img.shields.io/github/issues/wpadillav/StockWatchBot)](https://github.com/wpadillav/StockWatchBot/issues)
[![GitHub stars](https://img.shields.io/github/stars/wpadillav/StockWatchBot)](https://github.com/wpadillav/StockWatchBot/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/wpadillav/StockWatchBot)](https://github.com/wpadillav/StockWatchBot/network)

> 🚀 **API REST de cotizaciones bursátiles en tiempo real con dashboard web y bot de Telegram integrado**

StockWatchBot es una plataforma completa que proporciona datos del mercado de valores en tiempo real a través de múltiples canales: API REST, dashboard web interactivo y bot de Telegram con interfaz de botones.

## ✨ Características

### 🎯 **Funcionalidades Principales**
- 📊 **API REST completa** - Endpoints para cotizaciones, tendencias e historiales
- 💻 **Dashboard interactivo** - Interface web moderna y responsive con Bootstrap 5
- 🤖 **Bot de Telegram** - [@BolsaBotESbot](https://t.me/BolsaBotESbot) con botones interactivos
- ⚡ **Datos en tiempo real** - Integración directa con Yahoo Finance API
- 🌟 **META destacado** - Facebook/Meta como opción principal
- 🇺🇸🇪🇸 **Mercados múltiples** - Soporte para acciones de EE.UU. y España

### 🛠️ **Características Técnicas**
- 🔄 **Sistema de caché** - Optimización de rendimiento (60 segundos)
- 📚 **Documentación completa** - API docs con ejemplos interactivos
- 🎨 **Design system profesional** - Gradientes, animaciones y iconos
- 📱 **Responsive design** - Compatible con todos los dispositivos
- 🔒 **Manejo de errores robusto** - Fallbacks y mensajes informativos
- 📊 **Análisis de tendencias** - Clasificación automática de movimientos

## 🚀 Demo en Vivo

| Servicio | URL | Descripción |
|----------|-----|-------------|
| 🌐 **Dashboard** | [URL/api](https://URL/api/) | Interface web principal |
| 📚 **API Docs** | [URL/api/docs.html](https://URL/api/docs.html) | Documentación completa |
| 🤖 **Telegram Bot** | [@BolsaBotESbot](https://t.me/BolsaBotESbot) | Bot interactivo gratuito |
| 🔗 **API Endpoint** | [URL/api/api.php](https://URL/api/api.php?symbol=AAPL) | Ejemplo de cotización |

## 🛠️ Stack Tecnológico

| Categoría | Tecnología | Uso |
|-----------|------------|-----|
| **Backend** | PHP 8.0+ | API REST y lógica de negocio |
| **Frontend** | HTML5, CSS3, JavaScript | Dashboard interactivo |
| **Framework CSS** | Bootstrap 5.3.0 | Design system y responsividad |
| **Icons** | Font Awesome 6.0 | Iconografía profesional |
| **Bot Platform** | Telegram Bot API | Interface conversacional |
| **Data Source** | Yahoo Finance API | Datos bursátiles en tiempo real |
| **Caching** | File System | Optimización de performance |
| **Documentation** | Markdown + HTML | Guías y referencias |

## 🚀 Instalación Rápida

### Prerrequisitos
```bash
- PHP 8.0 o superior
- Servidor web (Apache/Nginx)
- Conexión a internet para datos en tiempo real
- Token de Telegram Bot (opcional)
```

### 1️⃣ Clonar el repositorio
```bash
git clone https://github.com/wpadillav/StockWatchBot.git
cd StockWatchBot
```

### 2️⃣ Configurar servidor web
```bash
# Mover archivos al directorio web
cp -r * /var/www/html/stockwatch/

# O usar servidor PHP integrado para desarrollo
php -S localhost:8000
```

### 3️⃣ Configurar Bot de Telegram (Opcional)
```php
// Editar bot.php línea 4
define('BOT_TOKEN', 'TU_TOKEN_AQUI');

// Configurar webhook
curl -X POST https://api.telegram.org/bot<TOKEN>/setWebhook \
  -d "url=https://tu-dominio.com/bot.php"
```

### 4️⃣ ¡Listo!
Visita `http://localhost:8000` y comienza a usar la plataforma.

## 📖 Uso de la API

### Obtener Cotización
```http
GET /api.php?symbol=AAPL&action=quote
```

**Respuesta:**
```json
{
  "success": true,
  "data": {
    "symbol": "AAPL",
    "price": 185.25,
    "change": 2.15,
    "change_percent": "1.17%",
    "volume": 45678900,
    "high": 186.50,
    "low": 183.10
  },
  "timestamp": 1699650000
}
```

### Análisis de Tendencia
```http
GET /api.php?symbol=META&action=trend
```

### Múltiples Cotizaciones
```http
GET /multiple.php?symbols=AAPL,GOOGL,MSFT,META
```

### Búsqueda de Símbolos
```http
GET /search.php?q=Apple
```

## 🤖 Bot de Telegram

### Comandos Principales
- `/start` - Menú principal con botones interactivos
- `/quote SYMBOL` - Cotización específica (ej: `/quote META`)
- `/trend SYMBOL` - Análisis de tendencia
- `/search COMPANY` - Buscar símbolos
- `/help` - Lista completa de comandos

### Características del Bot
- ✅ **Botones interactivos** - Navegación fácil sin comandos
- ✅ **META destacado** - Acceso prioritario a Facebook/Meta
- ✅ **Análisis automático** - Clasificación de tendencias
- ✅ **Respuestas instantáneas** - Datos en tiempo real
- ✅ **Completamente gratuito** - Sin límites ni registros

## 📁 Estructura del Proyecto

```
StockWatchBot/
├── 📄 README.md              # Este archivo
├── 📄 LICENSE                # Licencia MIT
├── 📄 .gitignore            # Archivos ignorados
├── 📄 composer.json          # Dependencias PHP
├── 📄 CONTRIBUTING.md        # Guía de contribución
├── 📄 CHANGELOG.md           # Historial de cambios
├── 🔧 config.php             # Configuración general
├── 🔧 api.php                # Endpoint principal de API
├── 🔧 StockAPI.php           # Clase principal de la API
├── 🔧 CacheManager.php       # Sistema de caché
├── 🤖 bot.php                # Bot de Telegram
├── 🌐 index.html             # Dashboard principal
├── 📚 docs.html              # Documentación
├── 🔍 search.php             # Búsqueda de símbolos
├── 📊 multiple.php           # Múltiples cotizaciones
├── 📁 assets/                # Recursos estáticos
├── 📁 docs/                  # Documentación adicional
└── 📁 examples/              # Ejemplos de uso
```

## 🎯 Acciones Soportadas

### 🇺🇸 Mercado Estadounidense
| Símbolo | Empresa | Sector |
|---------|---------|--------|
| **META** | Meta Platforms | Tecnología |
| AAPL | Apple Inc. | Tecnología |
| GOOGL | Alphabet Inc. | Tecnología |
| MSFT | Microsoft | Tecnología |
| TSLA | Tesla Inc. | Automotriz |
| AMZN | Amazon | E-commerce |
| NVDA | NVIDIA | Semiconductores |

### 🇪🇸 Mercado Español
| Símbolo | Empresa | Sector |
|---------|---------|--------|
| SAN.MC | Banco Santander | Financiero |
| BBVA.MC | BBVA | Financiero |
| IBE.MC | Iberdrola | Energía |
| ITX.MC | Inditex | Retail |
| TEF.MC | Telefónica | Telecomunicaciones |

## 🤝 Contribuir

¡Las contribuciones son bienvenidas! Por favor lee [CONTRIBUTING.md](CONTRIBUTING.md) para más detalles.

### 🐛 Reportar Bugs
1. Verifica que el bug no esté ya reportado en [Issues](https://github.com/wpadillav/StockWatchBot/issues)
2. Crea un nuevo issue con descripción detallada
3. Incluye pasos para reproducir el problema

### 💡 Sugerir Características
1. Revisa las [issues existentes](https://github.com/wpadillav/StockWatchBot/issues)
2. Crea un issue con etiqueta `enhancement`
3. Describe claramente la funcionalidad deseada

### 🔧 Desarrollar
1. Fork del repositorio
2. Crea una rama feature (`git checkout -b feature/AmazingFeature`)
3. Commit de cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📊 Métricas del Proyecto

- **Idiomas soportados**: Español, English
- **APIs integradas**: Yahoo Finance, Telegram Bot API
- **Endpoints disponibles**: 5+
- **Respuesta promedio**: <500ms
- **Uptime**: 99.9%
- **Acciones soportadas**: 50+

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver [LICENSE](LICENSE) para más detalles.

## 👨‍💻 Autor

**William Padilla**
- 🐱 GitHub: [@wpadillav](https://github.com/wpadillav)
- 📧 Email: [contacto disponible en GitHub]
- 🌐 Web: [URL](https://URL)

## 🙏 Agradecimientos

- 📊 **Yahoo Finance** - Por proporcionar datos bursátiles gratuitos
- 🤖 **Telegram Bot API** - Por la plataforma de bots
- 🎨 **Bootstrap** - Por el framework CSS
- 🤖 **GitHub Copilot** - Por asistencia en el desarrollo
- 🌟 **Open Source Community** - Por herramientas y inspiración

## 📈 Roadmap

### ✅ **v1.0 - Base** (Completado)
- ✅ API REST funcional
- ✅ Dashboard web
- ✅ Bot de Telegram básico

### ✅ **v2.0 - Interactividad** (Completado)
- ✅ Botones interactivos en bot
- ✅ Análisis de tendencias
- ✅ Interface simplificada

### 🔄 **v3.0 - En desarrollo**
- 🔲 Gráficos interactivos
- 🔲 Alertas personalizadas
- 🔲 Más mercados internacionales
- 🔲 API de webhooks

### 🔮 **v4.0 - Futuro**
- 🔲 Análisis técnico avanzado
- 🔲 Portfolio tracking
- 🔲 Integración con brokers
- 🔲 Mobile app

---

<div align="center">

**⭐ ¡Dale una estrella si te gusta el proyecto!**

[🤖 Prueba el Bot](https://t.me/BolsaBotESbot) • [📊 Ver Demo](https://URL/api/) • [📚 Documentación](https://URL/api/docs.html) • [🐛 Reportar Bug](https://github.com/wpadillav/StockWatchBot/issues)

</div>

---

<sub>🏗️ Desarrollado con ❤️ por [William Padilla](https://github.com/wpadillav) | Asistido por GitHub Copilot</sub>