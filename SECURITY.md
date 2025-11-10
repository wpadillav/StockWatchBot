# 🔒 Security Policy

## 🛡️ Supported Versions

Actualmente damos soporte de seguridad para las siguientes versiones de StockWatchBot:

| Version | Supported          |
| ------- | ------------------ |
| 2.1.x   | ✅ |
| 2.0.x   | ✅ |
| 1.5.x   | ❌ |
| < 1.5   | ❌ |

## 🚨 Reporting a Vulnerability

La seguridad de StockWatchBot es muy importante para nosotros. Si descubres una vulnerabilidad de seguridad, por favor repórtala de manera responsable.

### 📧 Cómo Reportar

**NO** crees un issue público para vulnerabilidades de seguridad.

En su lugar:

1. **Email privado**: Envía un email a `security@URL.com` con:
   - Descripción detallada de la vulnerabilidad
   - Pasos para reproducir el problema
   - Impacto potencial
   - Versión afectada

2. **Información a incluir**:
   ```
   Subject: [SECURITY] Vulnerabilidad en StockWatchBot
   
   - Tipo de vulnerabilidad
   - Ubicación del problema (archivo/función)
   - Pasos para reproducir
   - Impacto estimado (bajo/medio/alto/crítico)
   - Propuesta de solución (opcional)
   ```

### ⏰ Tiempo de Respuesta

- **Confirmación inicial**: 24-48 horas
- **Evaluación completa**: 3-5 días hábiles
- **Fix y release**: Depende de la severidad

### 🎯 Proceso de Manejo

1. **Recepción**: Confirmamos la recepción en 24h
2. **Evaluación**: Analizamos la vulnerabilidad
3. **Desarrollo**: Creamos un fix
4. **Testing**: Probamos la solución
5. **Release**: Publicamos la corrección
6. **Disclosure**: Divulgación coordinada (opcional)

## 🔍 Scope de Seguridad

### ✅ En Scope
- **API REST** (`api.php`, `multiple.php`, `search.php`)
- **Bot de Telegram** (`bot.php`)
- **Dashboard Web** (`index.html`, `docs.html`)
- **Clases core** (`StockAPI.php`, `CacheManager.php`)
- **Configuración** (`config.php`)

### ❌ Out of Scope
- **APIs de terceros** (Yahoo Finance, Telegram)
- **Infraestructura de hosting**
- **Ataques de fuerza bruta** en endpoints públicos
- **Rate limiting** (no implementado intencionalmente)
- **DDOS attacks**

## 🛠️ Tipos de Vulnerabilidades

### 🔴 **Críticas** (Fix inmediato)
- Remote Code Execution (RCE)
- SQL Injection
- Authentication bypass
- Data exposure masiva

### 🟠 **Altas** (Fix en 7 días)
- Cross-Site Scripting (XSS)
- Cross-Site Request Forgery (CSRF)
- Path traversal
- Information disclosure

### 🟡 **Medias** (Fix en 30 días)
- Input validation issues
- Access control issues
- Configuration issues

### 🟢 **Bajas** (Fix en releases programados)
- Information leakage menor
- Best practices violations
- Documentation issues

## 🔐 Security Best Practices

### 🛡️ Para Usuarios
- **Nunca compartas** tokens de bots de Telegram
- **Usa HTTPS** siempre en producción
- **Mantén actualizadas** las dependencias
- **Revisa logs** regularmente

### 👩‍💻 Para Desarrolladores
- **Valida inputs** siempre
- **Sanitiza outputs** para prevenir XSS
- **Usa prepared statements** si usas SQL
- **No hardcodees** credenciales
- **Implementa rate limiting** si es necesario

## 📋 Security Checklist

### ✅ Implementado
- ✅ Input validation en API endpoints
- ✅ Output encoding en responses HTML
- ✅ Error handling sin information disclosure
- ✅ Secure file permissions
- ✅ No hardcoded credentials (tokens externos)

### 🔄 En Progreso
- 🔄 Rate limiting implementation
- 🔄 Content Security Policy (CSP)
- 🔄 Additional input sanitization

### 📋 Pendiente
- ⏳ Automated security scanning
- ⏳ Dependency vulnerability checking
- ⏳ Security headers optimization

## 🏆 Hall of Fame

Reconocemos a las personas que reportan vulnerabilidades de manera responsable:

<!-- Será actualizada cuando recibamos reports -->

*¡Sé el primero en contribuir a la seguridad de StockWatchBot!*

## 📚 Resources

### 🔗 Enlaces Útiles
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Guide](https://phpsec.org/)
- [Telegram Bot Security](https://core.telegram.org/bots/security)

### 📖 Documentación
- [API Documentation](https://URL.com/api/docs.html)
- [Contributing Guide](CONTRIBUTING.md)
- [Code of Conduct](CODE_OF_CONDUCT.md)

## 🙏 Agradecimientos

Agradecemos a toda la comunidad de seguridad por ayudar a mantener StockWatchBot seguro para todos.

---

**🛡️ Recuerda**: La divulgación responsable ayuda a proteger a todos los usuarios. Gracias por ayudar a hacer StockWatchBot más seguro.

---

<div align="center">

**📧 Contacto de Seguridad**: `security@URL.com`

*Respuesta garantizada en 24-48 horas*

</div>