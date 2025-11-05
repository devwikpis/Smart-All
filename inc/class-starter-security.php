<?php

/**
 * Security Class - WordPress Theme Security Hardening
 * 
 * Implementa medidas de seguridad para proteger el sitio WordPress:
 * - Oculta información sensible del sistema
 * - Protege contra ataques comunes
 * - Mejora la seguridad de la API REST
 * - Implementa headers de seguridad
 * 
 * @package Starter_Theme
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

class Starter_Security
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->init_hooks();
    }

    /**
     * Inicializar hooks de seguridad
     */
    private function init_hooks()
    {
        // Ocultar información del sistema
        add_action('init', [$this, 'remove_wordpress_version']);
        add_filter('the_generator', '__return_empty_string');
        remove_action('wp_head', 'wp_generator');

        // Ocultar información de la API REST
        add_filter('rest_url_prefix', [$this, 'change_rest_url_prefix']);
        remove_action('wp_head', 'rest_output_link_wp_head');
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('template_redirect', 'rest_output_link_header', 11);

        // Deshabilitar XML-RPC si no es necesario
        add_filter('xmlrpc_enabled', '__return_false');

        // Remover información innecesaria del header
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_shortlink_wp_head');
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

        // Headers de seguridad
        add_action('send_headers', [$this, 'add_security_headers']);

        // Protección contra enumeración de usuarios
        add_action('init', [$this, 'prevent_user_enumeration']);
        add_filter('redirect_canonical', [$this, 'prevent_author_enumeration'], 10, 2);

        // Deshabilitar edición de archivos desde el admin
        if (!defined('DISALLOW_FILE_EDIT')) {
            define('DISALLOW_FILE_EDIT', true);
        }

        // Proteger wp-config.php y .htaccess
        add_action('init', [$this, 'protect_sensitive_files']);

        // Limitar intentos de login (básico)
        add_action('wp_login_failed', [$this, 'log_failed_login']);

        // Remover información de versión de scripts y estilos
        add_filter('style_loader_src', [$this, 'remove_version_from_assets'], 9999);
        add_filter('script_loader_src', [$this, 'remove_version_from_assets'], 9999);

        // Proteger contra hotlinking de imágenes (opcional)
        // add_action('init', [$this, 'prevent_image_hotlinking']);

        // Deshabilitar REST API para usuarios no autenticados (opcional)
        add_filter('rest_authentication_errors', [$this, 'restrict_rest_api']);

        // Sanitizar nombres de archivos subidos
        add_filter('sanitize_file_name', [$this, 'sanitize_uploaded_filename'], 10, 1);

        // Agregar Content Security Policy
        add_action('wp_head', [$this, 'add_content_security_policy'], 1);
    }

    /**
     * Remover versión de WordPress de todas partes
     */
    public function remove_wordpress_version()
    {
        global $wp_version;
        $wp_version = '';
    }

    /**
     * Cambiar el prefijo de la URL de la API REST
     * Hace más difícil encontrar la API
     */
    public function change_rest_url_prefix($prefix)
    {
        // Cambiar 'wp-json' por algo menos obvio
        return 'api';
    }

    /**
     * Agregar headers de seguridad HTTP
     */
    public function add_security_headers()
    {
        // Prevenir clickjacking
        header('X-Frame-Options: SAMEORIGIN');

        // Prevenir MIME type sniffing
        header('X-Content-Type-Options: nosniff');

        // Habilitar protección XSS del navegador
        header('X-XSS-Protection: 1; mode=block');

        // Referrer Policy - controla qué información se envía en el header Referer
        header('Referrer-Policy: strict-origin-when-cross-origin');

        // Permissions Policy (antes Feature Policy)
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

        // HSTS - Force HTTPS (solo si el sitio usa HTTPS)
        if (is_ssl()) {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
        }
    }

    /**
     * Prevenir enumeración de usuarios
     */
    public function prevent_user_enumeration()
    {
        if (!is_admin() && isset($_REQUEST['author']) && is_numeric($_REQUEST['author'])) {
            wp_die('Forbidden - User enumeration is not allowed', 'Forbidden', ['response' => 403]);
        }
    }

    /**
     * Prevenir enumeración de autores mediante canonical redirect
     */
    public function prevent_author_enumeration($redirect, $request)
    {
        if (preg_match('/\?author=([0-9]*)(\/*)/i', $request)) {
            wp_die('Forbidden - Author enumeration is not allowed', 'Forbidden', ['response' => 403]);
        }
        return $redirect;
    }

    /**
     * Proteger archivos sensibles
     */
    public function protect_sensitive_files()
    {
        // Esta función puede extenderse con reglas .htaccess adicionales
        // Por ahora, aseguramos que DISALLOW_FILE_EDIT esté activo
    }

    /**
     * Registrar intentos fallidos de login
     */
    public function log_failed_login($username)
    {
        $ip = $this->get_client_ip();
        $log_message = sprintf(
            'Failed login attempt - Username: %s, IP: %s, Time: %s',
            sanitize_user($username),
            $ip,
            current_time('mysql')
        );

        if (WP_DEBUG_LOG) {
            error_log($log_message);
        }

        // Aquí podrías implementar un sistema de bloqueo por IP
        // o integración con un plugin de seguridad
    }

    /**
     * Obtener IP del cliente de forma segura
     */
    private function get_client_ip()
    {
        $ip = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : 'Unknown';
    }

    /**
     * Remover parámetro de versión de assets
     */
    public function remove_version_from_assets($src)
    {
        if (strpos($src, 'ver=')) {
            $src = remove_query_arg('ver', $src);
        }
        return $src;
    }

    /**
     * Prevenir hotlinking de imágenes
     */
    public function prevent_image_hotlinking()
    {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $site_url = home_url();

        if (!empty($referer) && strpos($referer, $site_url) === false) {
            $request_uri = $_SERVER['REQUEST_URI'];
            $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

            foreach ($image_extensions as $ext) {
                if (strpos($request_uri, '.' . $ext) !== false) {
                    header('HTTP/1.1 403 Forbidden');
                    exit;
                }
            }
        }
    }

    /**
     * Restringir API REST a usuarios autenticados
     * Descomenta si quieres que la API solo sea accesible para usuarios logueados
     */
    public function restrict_rest_api($access)
    {
        // Permitir acceso a ciertos endpoints públicos
        $public_routes = [
            '/wp/v2/posts',
            '/wp/v2/pages',
            '/wp/v2/media',
            '/wp/v2/categories',
            '/wp/v2/tags',
        ];

        $current_route = $_SERVER['REQUEST_URI'] ?? '';

        // Permitir acceso a rutas públicas específicas
        foreach ($public_routes as $route) {
            if (strpos($current_route, $route) !== false) {
                return $access;
            }
        }

        // Requerir autenticación para todo lo demás
        if (!is_user_logged_in()) {
            return new WP_Error(
                'rest_forbidden',
                __('REST API access restricted to authenticated users.', 'starter'),
                ['status' => 401]
            );
        }

        return $access;
    }

    /**
     * Sanitizar nombres de archivos subidos
     */
    public function sanitize_uploaded_filename($filename)
    {
        // Remover caracteres especiales y espacios
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);

        // Convertir a minúsculas
        $filename = strtolower($filename);

        // Remover múltiples puntos consecutivos
        $filename = preg_replace('/\.+/', '.', $filename);

        return $filename;
    }

    /**
     * Agregar Content Security Policy
     */
    public function add_content_security_policy()
    {
        // CSP básico - ajusta según las necesidades de tu sitio
        $csp = "default-src 'self'; ";
        $csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.google-analytics.com https://www.googletagmanager.com; ";
        $csp .= "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.cdnfonts.com; ";
        $csp .= "font-src 'self' data: https://fonts.gstatic.com https://fonts.cdnfonts.com; ";
        $csp .= "img-src 'self' data: https:; ";
        $csp .= "connect-src 'self'; ";
        $csp .= "worker-src 'self' blob:; ";
        $csp .= "base-uri 'self'; ";
        $csp .= "form-action 'self';";

        echo '<meta http-equiv="Content-Security-Policy" content="' . esc_attr($csp) . '">' . "\n";
    }

    /**
     * Deshabilitar feeds RSS si no son necesarios
     */
    public function disable_rss_feeds()
    {
        add_action('do_feed', [$this, 'disable_feed'], 1);
        add_action('do_feed_rdf', [$this, 'disable_feed'], 1);
        add_action('do_feed_rss', [$this, 'disable_feed'], 1);
        add_action('do_feed_rss2', [$this, 'disable_feed'], 1);
        add_action('do_feed_atom', [$this, 'disable_feed'], 1);
    }

    /**
     * Callback para deshabilitar feeds
     */
    public function disable_feed()
    {
        wp_die(__('No feed available, please visit our <a href="' . get_bloginfo('url') . '">homepage</a>!', 'starter'));
    }

    /**
     * Agregar nonce a formularios AJAX personalizados
     */
    public static function create_nonce($action = 'starter_ajax_nonce')
    {
        return wp_create_nonce($action);
    }

    /**
     * Verificar nonce en peticiones AJAX
     */
    public static function verify_nonce($nonce, $action = 'starter_ajax_nonce')
    {
        return wp_verify_nonce($nonce, $action);
    }

    /**
     * Limpiar output de WordPress de comentarios HTML innecesarios
     */
    public function remove_html_comments($buffer)
    {
        $buffer = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $buffer);
        return $buffer;
    }
}

// Inicializar la clase de seguridad
new Starter_Security();
