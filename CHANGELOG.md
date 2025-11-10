# 📊 Changelog - StockWatchBot

Todos los cambios notables a este proyecto serán documentados en este archivo.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
y este proyecto adhiere a [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### 🔮 Planificado
- Gráficos interactivos con Chart.js
- Alertas personalizadas vía email
- Soporte para criptomonedas
- API de webhooks
- Análisis técnico avanzado

## [2.1.0] - 2025-11-10

### ✨ Added
- Documentación completa del proyecto (README.md profesional)
- Sistema de contribuciones (CONTRIBUTING.md)
- Licencia MIT oficial
- Archivo .gitignore completo para el proyecto
- Badges de estado en README
- Estructura de proyecto documentada
- Roadmap de desarrollo futuro

### 🔧 Changed
- Mejorada la presentación del proyecto para GitHub
- Optimizada la estructura de archivos
- Actualizada la documentación de la API

### 📚 Documentation
- README.md completamente rediseñado
- Agregada sección de instalación paso a paso
- Documentados todos los endpoints de la API
- Agregados ejemplos de uso del bot de Telegram
- Incluida información sobre el stack tecnológico

## [2.0.0] - 2025-11-10

### ✨ Added
- Bot de Telegram completamente interactivo (@BolsaBotESbot)
- Sistema de botones inline para navegación
- Análisis automático de tendencias
- META (Facebook) como acción destacada
- Soporte para mercado español (SAN.MC, BBVA.MC, etc.)
- Sistema de logging para depuración
- Función de búsqueda de símbolos mejorada

### 🔧 Changed
- **BREAKING**: Interface del bot simplificada (removidos botones de historial)
- Mejorada la experiencia de usuario en el bot
- Optimizadas las respuestas de la API
- Actualizada la documentación web

### ❌ Removed
- Botones de "Historial 7d" y "Historial 30d" del bot
- Callbacks de historial específicos
- Funcionalidad de historial por días en el bot

### 🐛 Fixed
- Corregidos caracteres mal codificados en emojis
- Solucionado problema de botones que no respondían
- Mejorado manejo de errores en callback queries
- Optimizada la estructura de callback processing

### 📱 Bot de Telegram
- Comandos principales: `/start`, `/quote`, `/trend`, `/help`
- Navegación fluida con botones interactivos
- Respuestas instantáneas con datos en tiempo real
- META destacado como primera opción
- Soporte para acciones de EE.UU. y España

## [1.5.0] - 2025-11-09

### ✨ Added
- Footer profesional en todas las páginas
- Links de navegación mejorados
- Diseño visual consistente entre páginas
- Iconos de Font Awesome actualizados

### 🔧 Changed
- Mejorado el design system general
- Optimizadas las transiciones CSS
- Actualizada la paleta de colores

### 🎨 Design
- Gradientes profesionales en backgrounds
- Animaciones suaves en hover effects
- Tipografía mejorada con Segoe UI
- Sistema de iconos consistente

## [1.4.0] - 2025-11-09

### ✨ Added
- Integración completa con Yahoo Finance API
- Datos reales en tiempo real para todas las acciones
- Sistema de caché optimizado (60 segundos)
- Manejo robusto de errores y timeouts

### 🔧 Changed
- **BREAKING**: Reemplazados datos simulados por datos reales
- Mejorada la precisión de los datos
- Optimizado el tiempo de respuesta
- Actualizada la documentación de la API

### 🐛 Fixed
- Corregidos errores de conectividad con APIs externas
- Mejorado manejo de symbols inválidos
- Solucionados timeouts en consultas lentas

### 📊 API
- Endpoint `/api.php` con datos reales
- Soporte para múltiples símbolos `/multiple.php`
- Búsqueda de símbolos `/search.php`
- Datos de volumen, máximos y mínimos

## [1.3.0] - 2025-11-08

### ✨ Added
- Dashboard web interactivo (index.html)
- Documentación completa de la API (docs.html)
- Interfaz responsive con Bootstrap 5
- Sistema de botones interactivos para consultas

### 🎨 Design
- Design system profesional
- Colores corporativos consistentes
- Animaciones CSS suaves
- Layout responsive para móviles

### 📱 Frontend
- JavaScript vanilla para interacciones
- AJAX para consultas asíncronas
- Indicadores de carga
- Mensajes de error informativos

## [1.2.0] - 2025-11-07

### ✨ Added
- Sistema de caché para optimizar performance
- Clase CacheManager para gestión de caché
- Configuración centralizada en config.php
- Logs de actividad y errores

### 🔧 Changed
- Refactorizada la estructura de clases
- Mejorada la organización del código
- Optimizados los tiempos de respuesta

### 🛡️ Security
- Validación de inputs mejorada
- Sanitización de parámetros
- Rate limiting básico

## [1.1.0] - 2025-11-06

### ✨ Added
- Endpoint para múltiples cotizaciones
- Función de búsqueda de símbolos
- Análisis de tendencias básico
- Soporte para mercados internacionales

### 📊 Data
- Agregadas más acciones populares
- Soporte para símbolos españoles (.MC)
- Datos de volumen y variaciones
- Timestamps en todas las respuestas

## [1.0.0] - 2025-11-05

### 🎉 Initial Release

### ✨ Added
- API REST básica para cotizaciones
- Endpoint principal `/api.php`
- Clase StockAPI para gestión de datos
- Estructura básica del proyecto
- Datos simulados para testing

### 📊 Features
- Consulta de cotizaciones por símbolo
- Formato JSON estandarizado
- Manejo básico de errores
- Documentación inicial

### 🛠️ Technical
- PHP 8.0+ compatible
- Arquitectura orientada a objetos
- PSR-4 autoloading ready
- Estructura modular

---

## 📋 Tipos de Cambios

- **Added** ✨ - Nueva funcionalidad
- **Changed** 🔧 - Cambios en funcionalidad existente
- **Deprecated** ⚠️ - Funcionalidades que serán removidas
- **Removed** ❌ - Funcionalidades removidas
- **Fixed** 🐛 - Correcciones de bugs
- **Security** 🛡️ - Mejoras de seguridad

## 🔗 Links

- [GitHub Releases](https://github.com/wpadillav/StockWatchBot/releases)
- [Issues](https://github.com/wpadillav/StockWatchBot/issues)
- [Pull Requests](https://github.com/wpadillav/StockWatchBot/pulls)

---

<div align="center">

**📝 Nota**: Este changelog es actualizado automáticamente con cada release.

Para ver todos los commits detallados: [GitHub History](https://github.com/wpadillav/StockWatchBot/commits/main)

</div>