# 🤝 Guía de Contribución - StockWatchBot

¡Gracias por tu interés en contribuir a StockWatchBot! Este documento te guiará a través del proceso de contribución.

## 📋 Tabla de Contenidos

- [🎯 Código de Conducta](#-código-de-conducta)
- [🤔 ¿Cómo puedo contribuir?](#-cómo-puedo-contribuir)
- [🐛 Reportar Bugs](#-reportar-bugs)
- [💡 Sugerir Características](#-sugerir-características)
- [🔧 Contribuciones de Código](#-contribuciones-de-código)
- [📝 Guía de Estilo](#-guía-de-estilo)
- [🔍 Proceso de Review](#-proceso-de-review)

## 🎯 Código de Conducta

Este proyecto se adhiere a un código de conducta. Al participar, se espera que mantengas este código:

### Nuestro Compromiso
- **Respetuoso**: Trata a todos con respeto y profesionalismo
- **Inclusivo**: Acoge a personas de todos los orígenes y experiencias
- **Constructivo**: Proporciona comentarios útiles y constructivos
- **Profesional**: Mantén las discusiones enfocadas en el proyecto

### Comportamientos Esperados ✅
- Usar lenguaje acogedor e inclusivo
- Ser respetuoso de diferentes puntos de vista
- Aceptar críticas constructivas con gracia
- Enfocarse en lo que es mejor para la comunidad
- Mostrar empatía hacia otros miembros

### Comportamientos Inaceptables ❌
- Lenguaje o imágenes sexualizadas
- Comentarios insultantes o despectivos
- Acoso público o privado
- Publicar información privada de otros
- Cualquier conducta inapropiada en un entorno profesional

## 🤔 ¿Cómo puedo contribuir?

Hay muchas maneras de contribuir al proyecto:

### 📊 **Formas de Contribuir**
- 🐛 [Reportar bugs](#-reportar-bugs)
- 💡 [Sugerir nuevas características](#-sugerir-características)
- 📝 Mejorar documentación
- 🔧 Contribuir código
- 🧪 Escribir tests
- 🌍 Agregar soporte para nuevos idiomas
- 📈 Agregar soporte para nuevos mercados

## 🐛 Reportar Bugs

Los bugs son rastreados como [GitHub issues](https://github.com/wpadillav/StockWatchBot/issues). Antes de crear un bug report:

### ✅ **Antes de reportar:**
1. **Busca issues existentes** - Puede que el bug ya esté reportado
2. **Verifica la versión** - Asegúrate de usar la versión más reciente
3. **Reproduce el bug** - Confirma que puedes reproducir el problema

### 📝 **Plantilla de Bug Report:**

```markdown
## 🐛 Descripción del Bug
Descripción clara y concisa del problema.

## 🔄 Pasos para Reproducir
1. Ve a '...'
2. Haz clic en '....'
3. Baja hasta '....'
4. Ve el error

## ✅ Comportamiento Esperado
Descripción clara de lo que esperabas que pasara.

## ❌ Comportamiento Actual
Descripción clara de lo que pasó en su lugar.

## 📸 Screenshots
Si es aplicable, agrega screenshots.

## 🖥️ Entorno
- OS: [ej. Windows, macOS, Linux]
- Navegador: [ej. Chrome 96, Safari 15]
- PHP: [ej. 8.1]
- Versión: [ej. v2.0]

## 📝 Contexto Adicional
Cualquier otra información sobre el problema.
```

## 💡 Sugerir Características

Las sugerencias son rastreadas como [GitHub issues](https://github.com/wpadillav/StockWatchBot/issues).

### 📝 **Plantilla de Feature Request:**

```markdown
## 🚀 Feature Request

### 📋 Resumen
Descripción breve de la característica.

### 🎯 Problema que Resuelve
Descripción del problema que esta característica resolvería.

### 💡 Solución Propuesta
Descripción detallada de lo que te gustaría que pasara.

### 🔧 Alternativas Consideradas
Otras soluciones que consideraste.

### 📊 Beneficios
- Beneficio 1
- Beneficio 2

### 🎨 Mockups/Ejemplos
Si es posible, agrega mockups o ejemplos.
```

## 🔧 Contribuciones de Código

### 🚀 **Setup del Entorno**

1. **Fork del repositorio**
```bash
# Haz fork en GitHub, luego:
git clone https://github.com/TU_USERNAME/StockWatchBot.git
cd StockWatchBot
```

2. **Configurar upstream**
```bash
git remote add upstream https://github.com/wpadillav/StockWatchBot.git
```

3. **Instalar dependencias**
```bash
# Si usas Composer
composer install

# Configurar servidor local
php -S localhost:8000
```

### 🌿 **Workflow de Desarrollo**

1. **Crear rama feature**
```bash
git checkout -b feature/nueva-caracteristica
# o
git checkout -b fix/arreglar-bug
```

2. **Nombrar ramas:**
- `feature/nombre-caracteristica` - Nuevas características
- `fix/descripcion-bug` - Corrección de bugs
- `docs/mejora-documentacion` - Documentación
- `refactor/mejora-codigo` - Refactoring
- `test/agregar-tests` - Tests

3. **Realizar cambios y commits**
```bash
git add .
git commit -m "feat: agregar nueva característica de análisis"
```

4. **Mantener rama actualizada**
```bash
git fetch upstream
git rebase upstream/main
```

5. **Push y Pull Request**
```bash
git push origin feature/nueva-caracteristica
# Crear PR en GitHub
```

### 📝 **Convenciones de Commits**

Usamos [Conventional Commits](https://www.conventionalcommits.org/):

```bash
# Formato
tipo(scope): descripción

# Ejemplos
feat(api): agregar endpoint para múltiples símbolos
fix(bot): corregir error en callback de botones
docs(readme): actualizar instrucciones de instalación
style(ui): mejorar diseño de dashboard
refactor(cache): optimizar sistema de caché
test(api): agregar tests para StockAPI
```

**Tipos de commit:**
- `feat` - Nueva característica
- `fix` - Corrección de bug
- `docs` - Documentación
- `style` - Formato, punto y coma faltante, etc
- `refactor` - Refactoring de código
- `test` - Tests
- `chore` - Tareas de mantenimiento

## 📝 Guía de Estilo

### 🐘 **PHP**

```php
<?php
// ✅ Usar PSR-12 coding standard
// ✅ Documentar funciones públicas
/**
 * Obtiene cotización de una acción
 * 
 * @param string $symbol Símbolo de la acción
 * @return array Datos de la cotización
 */
public function getQuote(string $symbol): array
{
    // ✅ Usar tipos explícitos
    // ✅ Nombres descriptivos
    $stockData = $this->fetchFromAPI($symbol);
    
    return $stockData;
}

// ❌ Evitar
function get($s) { return api($s); }
```

### 🎨 **HTML/CSS**

```html
<!-- ✅ Usar clases semánticas -->
<div class="stock-card">
    <h3 class="stock-symbol">AAPL</h3>
    <p class="stock-price">$185.25</p>
</div>

<!-- ✅ Seguir convenciones de Bootstrap -->
<button class="btn btn-primary btn-lg">
    <i class="fas fa-chart-line"></i> Ver Tendencia
</button>
```

### 📱 **JavaScript**

```javascript
// ✅ Usar ES6+
const loadStock = async (symbol) => {
    try {
        const response = await fetch(`/api.php?symbol=${symbol}`);
        const data = await response.json();
        updateUI(data);
    } catch (error) {
        console.error('Error loading stock:', error);
    }
};

// ❌ Evitar var, usar const/let
```

### 📚 **Documentación**

```markdown
# ✅ Usar emojis apropiados
## 🚀 Instalación

<!-- ✅ Ejemplos de código con sintaxis highlighting -->
```php
$api = new StockAPI();
$quote = $api->getQuote('AAPL');
```

<!-- ✅ Secciones claras y organizadas -->
### Parámetros
- `symbol` (string) - Símbolo de la acción
- `action` (string) - Tipo de consulta
```

## 🔍 Proceso de Review

### ✅ **Checklist para PRs**

Antes de enviar tu PR, asegúrate de que:

**Código:**
- [ ] El código sigue las guías de estilo
- [ ] Todas las funciones están documentadas
- [ ] No hay errores de sintaxis (`php -l`)
- [ ] Los cambios son backward compatible

**Tests:**
- [ ] Tests existentes pasan
- [ ] Se agregaron tests para nueva funcionalidad
- [ ] Se probó manualmente en navegador

**Documentación:**
- [ ] README actualizado si es necesario
- [ ] Documentación de API actualizada
- [ ] CHANGELOG actualizado

**Git:**
- [ ] Commits siguen convención
- [ ] Rama está actualizada con main
- [ ] No hay archivos sensibles

### 📋 **Plantilla de PR**

```markdown
## 📝 Descripción
Descripción breve de los cambios.

## 🎯 Tipo de Cambio
- [ ] Bug fix
- [ ] Nueva característica
- [ ] Breaking change
- [ ] Documentación

## 🧪 Testing
- [ ] Tests pasan
- [ ] Probado manualmente
- [ ] Tests agregados/actualizados

## 📋 Checklist
- [ ] Mi código sigue la guía de estilo
- [ ] He revisado mi propio código
- [ ] He comentado código complejo
- [ ] He actualizado la documentación
- [ ] Mis cambios no generan warnings

## 📸 Screenshots
Si es aplicable, agrega screenshots.
```

### 🎯 **Criterios de Aceptación**

Tu PR será revisado por:

1. **Funcionalidad** - ¿Los cambios funcionan como se espera?
2. **Código** - ¿El código es limpio y mantenible?
3. **Performance** - ¿Los cambios no degradan el performance?
4. **Seguridad** - ¿No hay vulnerabilidades introducidas?
5. **Compatibilidad** - ¿Es compatible con versiones existentes?

## 🎉 Reconocimiento

Los contribuidores serán reconocidos en:

- 📝 **CHANGELOG.md** - Cambios importantes
- 👥 **Contributors section** en README
- 🏆 **Releases notes** - Contribuciones significativas
- ⭐ **GitHub contributors graph**

## 📞 ¿Necesitas Ayuda?

Si tienes preguntas:

1. 📖 Revisa la [documentación](https://URL/api/docs.html)
2. 🔍 Busca en [issues existentes](https://github.com/wpadillav/StockWatchBot/issues)
3. 💬 Crea un nuevo issue con la etiqueta `question`
4. 📧 Contacta al mantenedor del proyecto

## 🙏 Agradecimientos

¡Gracias por contribuir a StockWatchBot! Tu ayuda hace que este proyecto sea mejor para todos. 🚀

---

> 📝 **Nota**: Esta guía puede ser actualizada. Asegúrate de revisar la versión más reciente antes de contribuir.

---

<div align="center">

**¿Primera vez contribuyendo a open source? 🌟**

¡No te preocupes! Todos empezamos así. Tu contribución, sin importar lo pequeña que sea, es valiosa.

</div>