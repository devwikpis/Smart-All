# Guía de Desarrollo - Starter Theme

Esta guía documenta las características avanzadas implementadas en el tema para facilitar el desarrollo profesional.

## 📋 Tabla de Contenidos

1. [Sistema de Hooks](#sistema-de-hooks)
2. [Sistema de Logging](#sistema-de-logging)
3. [Sistema de Validación](#sistema-de-validación)
4. [Mejores Prácticas](#mejores-prácticas)

---

## 🎣 Sistema de Hooks

El tema incluye un sistema robusto de hooks personalizados que permite extender funcionalidad sin modificar archivos del tema.

### Hooks Disponibles

#### Hooks de Layout

```php
// Antes y después del header
do_action('starter_before_header');
do_action('starter_after_header');

// Antes y después del contenido
Starter_Hooks::before_content();
Starter_Hooks::after_content();

// Antes y después del loop
Starter_Hooks::before_loop();
Starter_Hooks::after_loop();

// Antes y después del footer
do_action('starter_before_footer');
do_action('starter_after_footer');
```

#### Hooks de Post

```php
// Antes y después de un post
Starter_Hooks::before_post($post_id);
Starter_Hooks::after_post($post_id);

// Antes y después del título
Starter_Hooks::before_post_title($post_id);
Starter_Hooks::after_post_title($post_id);

// Antes y después del contenido
Starter_Hooks::before_post_content($post_id);
Starter_Hooks::after_post_content($post_id);
```

#### Hooks de Head/Footer

```php
// En el <head>
do_action('starter_head_top');
do_action('starter_head_bottom');

// En el footer
do_action('starter_footer_top');
do_action('starter_footer_bottom');
```

### Filtros Disponibles

```php
// Modificar clases del body
add_filter('starter_body_classes', function($classes) {
    $classes[] = 'mi-clase-personalizada';
    return $classes;
});

// Modificar clases del post
add_filter('starter_post_classes', function($classes, $post_id) {
    if (is_featured($post_id)) {
        $classes[] = 'featured-post';
    }
    return $classes;
}, 10, 2);

// Modificar contenido del post
add_filter('starter_post_content', function($content, $post_id) {
    // Agregar contenido adicional
    return $content . '<div class="extra-content">...</div>';
}, 10, 2);
```

### Ejemplo de Uso en Templates

```php
// En single.php
<?php Starter_Hooks::before_content(); ?>

<main class="site-content">
    <?php Starter_Hooks::before_loop(); ?>
    
    <?php while (have_posts()) : the_post(); ?>
        <?php Starter_Hooks::before_post(); ?>
        
        <article <?php post_class(); ?>>
            <?php Starter_Hooks::before_post_title(); ?>
            <h1><?php the_title(); ?></h1>
            <?php Starter_Hooks::after_post_title(); ?>
            
            <?php Starter_Hooks::before_post_content(); ?>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
            <?php Starter_Hooks::after_post_content(); ?>
        </article>
        
        <?php Starter_Hooks::after_post(); ?>
    <?php endwhile; ?>
    
    <?php Starter_Hooks::after_loop(); ?>
</main>

<?php Starter_Hooks::after_content(); ?>
```

---

## 📊 Sistema de Logging

Sistema avanzado de logging con múltiples niveles y contexto para facilitar el debugging.

### Niveles de Log

- `DEBUG` - Información detallada para debugging
- `INFO` - Información general
- `WARNING` - Advertencias que no son errores
- `ERROR` - Errores que requieren atención
- `CRITICAL` - Errores críticos que pueden romper el sitio

### Uso Básico

```php
// Log simple
Starter_Logger::info('Usuario inició sesión');

// Log con contexto
Starter_Logger::warning('Intento de acceso denegado', [
    'user_id' => get_current_user_id(),
    'ip' => $_SERVER['REMOTE_ADDR'],
    'page' => $_SERVER['REQUEST_URI']
]);

// Log de error
Starter_Logger::error('Error al procesar formulario', [
    'form_id' => $form_id,
    'error' => $error_message
]);

// Log crítico
Starter_Logger::critical('Base de datos no disponible', [
    'host' => DB_HOST,
    'database' => DB_NAME
]);
```

### Logging de Queries

```php
// Medir tiempo de query
$start = microtime(true);
$results = $wpdb->get_results($query);
$time = microtime(true) - $start;

Starter_Logger::log_query($query, $time);
```

### Logging de Excepciones

```php
try {
    // Código que puede fallar
    do_something_risky();
} catch (Exception $e) {
    Starter_Logger::log_exception($e);
}
```

### Dump de Variables

```php
// Para debugging
$data = get_complex_data();
Starter_Logger::dump($data, 'Complex Data Structure');
```

### Medir Performance

```php
// Medir tiempo de ejecución
$result = Starter_Logger::measure(function() {
    return expensive_operation();
}, 'Expensive Operation');
```

### Ver Logs

Los logs se guardan en:
```
/wp-content/uploads/starter-logs/starter-YYYY-MM-DD.log
```

Formato del log:
```
[2025-10-29 13:00:00] [INFO] [file.php:123] function_name: Message | Context: {...}
```

### Obtener Historial en Memoria

```php
// Obtener todos los logs
$history = Starter_Logger::get_instance()->get_history();

// Filtrar por nivel
$errors = Starter_Logger::get_instance()->get_history('error');

// Obtener estadísticas
$stats = Starter_Logger::get_instance()->get_stats();
// ['total' => 50, 'by_level' => ['error' => 5, 'warning' => 10, ...]]
```

### Configuración

El nivel mínimo de log se determina automáticamente:
- `WP_DEBUG = true` → Nivel DEBUG (todos los logs)
- `WP_DEBUG = false` → Nivel WARNING (solo warnings y errores)

---

## ✅ Sistema de Validación

Sistema centralizado para validar y sanitizar datos de forma segura.

### Sanitización

```php
// Texto simple
$name = Starter_Validator::sanitize_text($_POST['name']);

// Textarea
$description = Starter_Validator::sanitize_textarea($_POST['description']);

// Email
$email = Starter_Validator::sanitize_email($_POST['email']);

// URL
$website = Starter_Validator::sanitize_url($_POST['website']);

// HTML (permite tags seguros)
$content = Starter_Validator::sanitize_html($_POST['content']);

// Números
$age = Starter_Validator::sanitize_int($_POST['age']);
$price = Starter_Validator::sanitize_float($_POST['price']);

// Booleano
$active = Starter_Validator::sanitize_bool($_POST['active']);

// Array
$tags = Starter_Validator::sanitize_array($_POST['tags']);

// Color hexadecimal
$color = Starter_Validator::sanitize_hex_color($_POST['color']);
```

### Validación Simple

```php
// Validar email
$email = Starter_Validator::validate_email($_POST['email']);
if ($email === false) {
    // Email inválido
}

// Validar URL
$url = Starter_Validator::validate_url($_POST['url']);
if ($url === false) {
    // URL inválida
}

// Validar teléfono
$phone = Starter_Validator::validate_phone($_POST['phone']);

// Validar longitud
if (!Starter_Validator::validate_length($name, 3, 50)) {
    // Nombre debe tener entre 3 y 50 caracteres
}

// Validar que esté en array de opciones
$valid_roles = ['admin', 'editor', 'author'];
if (!Starter_Validator::validate_in_array($role, $valid_roles)) {
    // Rol inválido
}

// Validar rango numérico
if (!Starter_Validator::validate_range($age, 18, 100)) {
    // Edad debe estar entre 18 y 100
}

// Validar fecha
if (!Starter_Validator::validate_date($date, 'Y-m-d')) {
    // Fecha inválida
}

// Validar nonce
if (!Starter_Validator::validate_nonce($_POST['nonce'], 'my_action')) {
    wp_die('Nonce inválido');
}
```

### Validación Múltiple

```php
$validator = Starter_Validator::get_instance();

// Definir reglas
$rules = [
    'name' => ['required', 'min:3', 'max:50'],
    'email' => ['required', 'email'],
    'age' => ['required', 'int', 'range:18,100'],
    'website' => ['url']
];

// Validar datos
if ($validator->validate_multiple($_POST, $rules)) {
    // Todos los datos son válidos
    $name = Starter_Validator::sanitize_text($_POST['name']);
    $email = Starter_Validator::sanitize_email($_POST['email']);
    // ... procesar datos
} else {
    // Hay errores
    $errors = $validator->get_errors();
    
    // Mostrar errores por campo
    foreach ($errors as $field => $field_errors) {
        foreach ($field_errors as $error) {
            echo "<p class='error'>{$error}</p>";
        }
    }
}
```

### Ejemplo Completo: Procesar Formulario

```php
function process_contact_form() {
    // Verificar nonce
    if (!Starter_Validator::validate_nonce($_POST['nonce'], 'contact_form')) {
        Starter_Logger::warning('Intento de envío sin nonce válido');
        return false;
    }
    
    // Validar datos
    $validator = Starter_Validator::get_instance();
    $rules = [
        'name' => ['required', 'min:3', 'max:100'],
        'email' => ['required', 'email'],
        'phone' => ['required'],
        'message' => ['required', 'min:10']
    ];
    
    if (!$validator->validate_multiple($_POST, $rules)) {
        Starter_Logger::info('Formulario con errores de validación', [
            'errors' => $validator->get_errors()
        ]);
        return $validator->get_errors();
    }
    
    // Sanitizar datos
    $data = [
        'name' => Starter_Validator::sanitize_text($_POST['name']),
        'email' => Starter_Validator::sanitize_email($_POST['email']),
        'phone' => Starter_Validator::validate_phone($_POST['phone']),
        'message' => Starter_Validator::sanitize_textarea($_POST['message'])
    ];
    
    // Procesar formulario
    $result = send_contact_email($data);
    
    if ($result) {
        Starter_Logger::info('Formulario de contacto enviado', [
            'email' => $data['email']
        ]);
        return true;
    } else {
        Starter_Logger::error('Error al enviar formulario de contacto', [
            'data' => $data
        ]);
        return false;
    }
}
```

---

## 🎯 Mejores Prácticas

### 1. Siempre Sanitizar Inputs

```php
// ❌ MAL
$name = $_POST['name'];
echo $name;

// ✅ BIEN
$name = Starter_Validator::sanitize_text($_POST['name']);
echo esc_html($name);
```

### 2. Validar Antes de Procesar

```php
// ❌ MAL
$email = $_POST['email'];
wp_mail($email, 'Subject', 'Message');

// ✅ BIEN
$email = Starter_Validator::validate_email($_POST['email']);
if ($email) {
    wp_mail($email, 'Subject', 'Message');
} else {
    Starter_Logger::warning('Email inválido proporcionado');
}
```

### 3. Usar Nonces en Formularios

```php
// En el formulario
<form method="post">
    <?php wp_nonce_field('my_action', 'my_nonce'); ?>
    <!-- campos del formulario -->
</form>

// Al procesar
if (!Starter_Validator::validate_nonce($_POST['my_nonce'], 'my_action')) {
    wp_die('Nonce inválido');
}
```

### 4. Loguear Eventos Importantes

```php
// Loguear acciones del usuario
Starter_Logger::info('Usuario actualizó perfil', [
    'user_id' => get_current_user_id()
]);

// Loguear errores
Starter_Logger::error('Error al guardar post', [
    'post_id' => $post_id,
    'error' => $error_message
]);
```

### 5. Usar Hooks para Extensibilidad

```php
// En lugar de modificar archivos del tema
// Usar hooks en functions.php o plugin

// Agregar contenido después del título
add_action('starter_after_post_title', function($post_id) {
    echo '<div class="post-meta">' . get_post_meta_html($post_id) . '</div>';
});

// Modificar clases del post
add_filter('starter_post_classes', function($classes, $post_id) {
    if (is_sticky($post_id)) {
        $classes[] = 'sticky-post';
    }
    return $classes;
}, 10, 2);
```

### 6. Manejar Errores Apropiadamente

```php
try {
    $result = risky_operation();
    Starter_Logger::info('Operación completada exitosamente');
} catch (Exception $e) {
    Starter_Logger::log_exception($e);
    // Mostrar mensaje amigable al usuario
    wp_die('Ocurrió un error. Por favor intenta nuevamente.');
}
```

### 7. Medir Performance en Operaciones Costosas

```php
$results = Starter_Logger::measure(function() {
    return $wpdb->get_results($complex_query);
}, 'Complex Database Query');

// Si toma más de 1 segundo, se logueará como WARNING
```

---

## 🔧 Debugging

### Habilitar Modo Debug

En `wp-config.php`:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 0);
```

### Ver Logs en Tiempo Real

```bash
# Ver logs de WordPress
tail -f /ruta/a/wp-content/debug.log

# Ver logs del tema
tail -f /ruta/a/wp-content/uploads/starter-logs/starter-$(date +%Y-%m-%d).log
```

### Debug de Hooks

```php
// Ver qué funciones están enganchadas a un hook
global $wp_filter;
print_r($wp_filter['starter_before_content']);
```

### Debug de Validación

```php
$validator = Starter_Validator::get_instance();
$validator->validate_multiple($data, $rules);

if ($validator->has_errors()) {
    Starter_Logger::debug('Errores de validación', [
        'errors' => $validator->get_errors()
    ]);
}
```

---

## 📚 Recursos Adicionales

- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/)
- [WordPress Theme Handbook](https://developer.wordpress.org/themes/)

---

**Última actualización:** 2025-10-29
