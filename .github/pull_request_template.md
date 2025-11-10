## 📝 Descripción

Describe brevemente los cambios introducidos en este PR.

### 🎯 Tipo de Cambio

¿Qué tipo de cambio introduce este PR?

- [ ] 🐛 Bug fix (cambio que arregla un issue)
- [ ] ✨ Nueva característica (cambio que agrega funcionalidad)
- [ ] 💥 Breaking change (cambio que rompe compatibilidad)
- [ ] 📚 Documentación (cambios solo en documentación)
- [ ] 🎨 Estilo (formato, punto y coma, etc; sin cambios de funcionalidad)
- [ ] ♻️ Refactor (cambio de código que no arregla bugs ni agrega características)
- [ ] ⚡ Performance (cambio que mejora performance)
- [ ] 🧪 Tests (agregar tests faltantes o corregir existentes)
- [ ] 🔧 Chore (cambios en build, herramientas, configuración)

### 🔗 Issues Relacionados

Fixes #(issue_number)
Closes #(issue_number)
Related to #(issue_number)

### 📋 Cambios Realizados

- [ ] Cambio 1
- [ ] Cambio 2
- [ ] Cambio 3

### 🧪 Testing

Describe las pruebas que realizaste para verificar tus cambios:

- [ ] ✅ Pruebas unitarias pasan
- [ ] ✅ Pruebas de integración pasan
- [ ] ✅ Probado manualmente en navegador
- [ ] ✅ Probado en diferentes dispositivos
- [ ] ✅ Probado bot de Telegram

### 📊 Componentes Afectados

¿Qué partes del sistema fueron modificadas?

- [ ] 🌐 Dashboard Web
- [ ] 📚 Documentación
- [ ] 🔗 API REST
- [ ] 🤖 Bot de Telegram
- [ ] 📱 Interfaz móvil
- [ ] 🔧 Backend/Core
- [ ] 🎨 UI/UX
- [ ] 📦 Configuración/Build

### 💥 Breaking Changes

¿Introduce este PR cambios que rompen compatibilidad?

- [ ] No
- [ ] Sí

Si marcaste sí, describe qué se rompe y cómo migrar:

```
Descripción de breaking changes y guía de migración
```

### 📸 Screenshots

Si los cambios incluyen modificaciones visuales, agrega screenshots:

| Antes | Después |
|-------|---------|
| ![image](url) | ![image](url) |

### 📱 Testing en Dispositivos

Si aplica, describe en qué dispositivos/navegadores probaste:

- [ ] 💻 Desktop Chrome
- [ ] 💻 Desktop Firefox
- [ ] 💻 Desktop Safari
- [ ] 📱 Mobile Chrome
- [ ] 📱 Mobile Safari
- [ ] 📱 Mobile Firefox

### ⚡ Performance

¿Los cambios afectan el performance?

- [ ] ✅ Mejora performance
- [ ] ➡️ Sin cambios significativos
- [ ] ⚠️ Puede afectar performance (explicar abajo)

Si afecta performance, explica:

```
Descripción del impacto en performance
```

### 🔒 Seguridad

¿Los cambios tienen implicaciones de seguridad?

- [ ] No
- [ ] Sí (explicar abajo)

Si tiene implicaciones de seguridad:

```
Descripción de consideraciones de seguridad
```

### 📋 Checklist

Antes de solicitar review, confirma que:

#### Código
- [ ] Mi código sigue la guía de estilo del proyecto
- [ ] He realizado self-review de mi código
- [ ] He comentado mi código, especialmente en áreas difíciles
- [ ] He hecho cambios correspondientes en la documentación
- [ ] Mis cambios no generan nuevos warnings
- [ ] Agregué tests que prueban mi fix o mi nueva característica
- [ ] Tests nuevos y existentes pasan con mis cambios

#### Documentación
- [ ] Actualicé README.md si es necesario
- [ ] Actualicé docs.html si hay cambios en API
- [ ] Actualicé CHANGELOG.md
- [ ] Agregué/actualicé comentarios en código

#### Git
- [ ] Mis commits siguen la convención (conventional commits)
- [ ] Rebase/merge con main está limpio
- [ ] No hay archivos sensibles en el commit
- [ ] No hay archivos temporales o de debug

### 🎯 Prioridad

¿Qué prioridad tiene este PR?

- [ ] 🔴 Crítica - Hotfix necesario
- [ ] 🟠 Alta - Feature importante
- [ ] 🟡 Media - Mejora general
- [ ] 🟢 Baja - Refactor o cleanup

### 🔄 Deployment

¿Requiere este PR acciones especiales al hacer deploy?

- [ ] No, deployment normal
- [ ] Sí, requiere acciones especiales (describir abajo)

Si requiere acciones especiales:

```bash
# Comandos o pasos especiales necesarios
composer install
php artisan migrate
# etc.
```

### 👀 Reviewers

¿Hay alguien específico que debería revisar este PR?

@wpadillav (siempre)
@username (si necesitas review específico)

### 📝 Notas Adicionales

Cualquier información adicional que los reviewers deberían saber:

```
Notas adicionales, context, decisiones de diseño, etc.
```

---

### 🎉 ¿Primera vez contribuyendo?

¡Bienvenido! Algunos tips:

- 📖 Lee [CONTRIBUTING.md](../CONTRIBUTING.md) para más detalles
- 🤝 Únete a las discusiones en issues
- ❓ Pregunta si tienes dudas
- 🙏 Agradecemos tu contribución

---

**🔍 Para Reviewers:**

- [ ] ✅ Código revisado y aprobado
- [ ] ✅ Tests verificados
- [ ] ✅ Documentación adecuada
- [ ] ✅ Performance aceptable
- [ ] ✅ Seguridad validada
- [ ] ✅ Ready to merge

**🚀 Ready para merge cuando todos los checks estén ✅**