# Medidas de Seguridad - Starter Theme

Este documento describe las medidas de seguridad implementadas en el tema para proteger el sitio WordPress.

## 📋 Tabla de Contenidos

1. [Características de Seguridad](#características-de-seguridad)
2. [Configuración](#configuración)
3. [Headers de Seguridad](#headers-de-seguridad)
4. [API REST](#api-rest)
5. [Recomendaciones Adicionales](#recomendaciones-adicionales)

---

## 🔒 Características de Seguridad

### 1. Ocultación de Información del Sistema

**Implementado:**
- ✅ Versión de WordPress oculta
- ✅ Generador meta tag removido
- ✅ Versiones de assets (CSS/JS) removidas
- ✅ RSD link removido
- ✅ Windows Live Writer manifest removido
- ✅ Shortlink removido
- ✅ Adjacent posts links removidos

**Beneficio:** Dificulta que atacantes identifiquen vulnerabilidades específicas de versiones.

### 2. Protección de la API REST

**Implementado:**
- ✅ URL de la API cambiada de `/wp-json` a `/api`
- ✅ Links de descubrimiento de la API removidos del header
- ✅ Restricción de acceso a usuarios autenticados (configurable)
- ✅ Rutas públicas específicas permitidas

**Acceso a la API:**
```
Antes: https://tusitio.com/wp-json/wp/v2/posts
Ahora: https://tusitio.com/api/wp/v2/posts
```

**Rutas públicas permitidas por defecto:**
- `/wp/v2/posts` - Publicaciones
- `/wp/v2/pages` - Páginas
- `/wp/v2/media` - Medios
- `/wp/v2/categories` - Categorías
- `/wp/v2/tags` - Etiquetas

### 3. Protección contra XML-RPC

**Implementado:**
- ✅ XML-RPC completamente deshabilitado

**Beneficio:** Previene ataques de fuerza bruta y DDoS a través de XML-RPC.

### 4. Headers de Seguridad HTTP

**Headers implementados:**

| Header | Valor | Propósito |
|--------|-------|-----------|
| `X-Frame-Options` | `SAMEORIGIN` | Previene clickjacking |
| `X-Content-Type-Options` | `nosniff` | Previene MIME type sniffing |
| `X-XSS-Protection` | `1; mode=block` | Protección XSS del navegador |
| `Referrer-Policy` | `strict-origin-when-cross-origin` | Controla información del referer |
| `Permissions-Policy` | `geolocation=(), microphone=(), camera=()` | Deshabilita APIs sensibles |
| `Strict-Transport-Security` | `max-age=31536000` | Fuerza HTTPS (solo si SSL activo) |

### 5. Content Security Policy (CSP)

**Implementado:**
```
default-src 'self';
script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.google-analytics.com;
style-src 'self' 'unsafe-inline' https://fonts.googleapis.com;
font-src 'self' https://fonts.gstatic.com;
img-src 'self' data: https:;
connect-src 'self';
frame-ancestors 'self';
base-uri 'self';
form-action 'self';
```

**Nota:** Ajusta el CSP según las necesidades de tu sitio en `class-starter-security.php`.

### 6. Protección contra Enumeración de Usuarios

**Implementado:**
- ✅ Bloqueo de `?author=1` queries
- ✅ Protección de canonical redirects
- ✅ Respuesta 403 Forbidden en intentos de enumeración

**Beneficio:** Previene que atacantes descubran nombres de usuario válidos.

### 7. Seguridad de Archivos

**Implementado:**
- ✅ Edición de archivos desde el admin deshabilitada (`DISALLOW_FILE_EDIT`)
- ✅ Sanitización de nombres de archivos subidos
- ✅ Protección contra hotlinking de imágenes (opcional)

### 8. Registro de Intentos de Login Fallidos

**Implementado:**
- ✅ Log de intentos fallidos con IP y timestamp
- ✅ Registro en error_log de WordPress

**Ubicación del log:**
```
/wp-content/debug.log
```

### 9. Protección AJAX

**Implementado:**
- ✅ Sistema de nonces para peticiones AJAX
- ✅ Métodos helper para crear y verificar nonces

**Uso en código:**
```php
// Crear nonce
$nonce = Starter_Security::create_nonce('mi_accion');

// Verificar nonce
if (Starter_Security::verify_nonce($_POST['nonce'], 'mi_accion')) {
    // Código seguro aquí
}
```

---

## ⚙️ Configuración

### Activar/Desactivar Características

Edita el archivo `inc/class-starter-security.php` para personalizar:

#### 1. Deshabilitar Feeds RSS

Descomenta en el constructor:
```php
$this->disable_rss_feeds();
```

#### 2. Activar Protección contra Hotlinking

Descomenta en el constructor:
```php
add_action('init', [$this, 'prevent_image_hotlinking']);
```

#### 3. Modificar Rutas Públicas de la API

Edita el array `$public_routes` en el método `restrict_rest_api()`:
```php
$public_routes = [
    '/wp/v2/posts',
    '/wp/v2/pages',
    // Agrega tus rutas aquí
];
```

#### 4. Cambiar Prefijo de la API REST

Modifica el método `change_rest_url_prefix()`:
```php
public function change_rest_url_prefix($prefix)
{
    return 'tu-prefijo-personalizado'; // Cambia 'api' por tu prefijo
}
```

#### 5. Ajustar Content Security Policy

Modifica el método `add_content_security_policy()` según tus necesidades:
```php
$csp = "default-src 'self'; ";
$csp .= "script-src 'self' 'unsafe-inline' https://tu-dominio.com; ";
// ... más directivas
```

---

## 🌐 Headers de Seguridad

### Verificar Headers

Usa estas herramientas para verificar los headers de seguridad:

1. **SecurityHeaders.com**
   ```
   https://securityheaders.com/?q=tusitio.com
   ```

2. **Mozilla Observatory**
   ```
   https://observatory.mozilla.org/analyze/tusitio.com
   ```

3. **Comando curl**
   ```bash
   curl -I https://tusitio.com
   ```

### Puntuación Esperada

Con todas las medidas implementadas, deberías obtener:
- SecurityHeaders.com: **A** o **A+**
- Mozilla Observatory: **B+** o superior

---

## 🔌 API REST

### Acceso a la API

#### Para Usuarios No Autenticados

Solo pueden acceder a las rutas públicas definidas:
```javascript
// ✅ Permitido
fetch('https://tusitio.com/api/wp/v2/posts')

// ❌ Bloqueado (401 Unauthorized)
fetch('https://tusitio.com/api/wp/v2/users')
```

#### Para Usuarios Autenticados

Acceso completo a toda la API REST:
```javascript
fetch('https://tusitio.com/api/wp/v2/users', {
    headers: {
        'X-WP-Nonce': wpApiSettings.nonce
    }
})
```

### Deshabilitar Restricción de la API

Si necesitas que la API sea completamente pública, comenta esta línea en el constructor:
```php
// add_filter('rest_authentication_errors', [$this, 'restrict_rest_api']);
```

---

## 🛡️ Recomendaciones Adicionales

### 1. Configuración de WordPress

Agrega a tu `wp-config.php`:

```php
// Deshabilitar edición de archivos
define('DISALLOW_FILE_EDIT', true);

// Deshabilitar instalación de plugins/temas
define('DISALLOW_FILE_MODS', true);

// Cambiar prefijo de base de datos (en instalación nueva)
$table_prefix = 'wp_xyz_'; // Cambia 'xyz' por algo aleatorio

// Limitar revisiones de posts
define('WP_POST_REVISIONS', 3);

// Habilitar auto-updates de seguridad
define('WP_AUTO_UPDATE_CORE', 'minor');
```

### 2. Archivo .htaccess

Agrega estas reglas a tu `.htaccess`:

```apache
# Proteger wp-config.php
<files wp-config.php>
    order allow,deny
    deny from all
</files>

# Proteger .htaccess
<files .htaccess>
    order allow,deny
    deny from all
</files>

# Deshabilitar listado de directorios
Options -Indexes

# Proteger archivos sensibles
<FilesMatch "^.*(error_log|wp-config\.php|php.ini|\.[hH][tT][aApP].*)$">
    Order deny,allow
    Deny from all
</FilesMatch>

# Bloquear acceso a xmlrpc.php
<Files xmlrpc.php>
    order deny,allow
    deny from all
</Files>
```

### 3. Plugins de Seguridad Recomendados

Considera instalar:
- **Wordfence Security** - Firewall y escaneo de malware
- **iThemes Security** - Hardening completo
- **Sucuri Security** - Auditoría y monitoreo
- **All In One WP Security** - Suite de seguridad completa

### 4. SSL/HTTPS

**Obligatorio:** Usa siempre HTTPS en producción.

Forzar HTTPS en `wp-config.php`:
```php
define('FORCE_SSL_ADMIN', true);
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}
```

### 5. Backups Regulares

- Configura backups automáticos diarios
- Almacena backups fuera del servidor
- Prueba la restauración regularmente

### 6. Actualizaciones

- Mantén WordPress actualizado
- Actualiza plugins y temas regularmente
- Elimina plugins/temas no utilizados

### 7. Contraseñas Fuertes

- Usa contraseñas de 16+ caracteres
- Habilita autenticación de dos factores (2FA)
- Cambia contraseñas regularmente

### 8. Monitoreo

- Revisa logs regularmente
- Configura alertas de seguridad
- Monitorea cambios en archivos

---

## 📝 Logs de Seguridad

### Ubicación de Logs

```
/wp-content/debug.log
```

### Habilitar Logging

En `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

### Revisar Logs

```bash
tail -f /ruta/a/wp-content/debug.log
```

---

## 🔍 Auditoría de Seguridad

### Checklist Mensual

- [ ] Revisar intentos de login fallidos
- [ ] Verificar usuarios administradores
- [ ] Actualizar WordPress core
- [ ] Actualizar plugins y temas
- [ ] Revisar permisos de archivos
- [ ] Verificar backups funcionan
- [ ] Escanear malware
- [ ] Revisar logs de error

### Herramientas de Escaneo

1. **WPScan**
   ```bash
   wpscan --url https://tusitio.com
   ```

2. **Sucuri SiteCheck**
   ```
   https://sitecheck.sucuri.net/
   ```

---

## 📞 Soporte

Si encuentras algún problema de seguridad:

1. **NO** lo publiques públicamente
2. Contacta al administrador del sitio
3. Proporciona detalles técnicos
4. Espera confirmación antes de divulgar

---

## 📄 Licencia

Este código de seguridad es parte del Starter Theme y está bajo la misma licencia del tema.

---

## 🔄 Changelog

### Version 1.0.0
- Implementación inicial de todas las medidas de seguridad
- Headers HTTP de seguridad
- Protección de API REST
- Sistema de nonces para AJAX
- Protección contra enumeración de usuarios
- Logging de intentos fallidos de login

---

**Última actualización:** 2025-10-29
