<?php
/**
 * Sistema de Hooks Personalizado del Tema
 * 
 * Proporciona hooks estratégicos en todo el tema para permitir
 * extensibilidad sin modificar archivos del tema.
 * 
 * @package Starter_Theme
 * @version 1.0.0
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

class Starter_Hooks
{
    /**
     * Instancia única de la clase (Singleton)
     * 
     * @var Starter_Hooks|null
     */
    private static $instance = null;

    /**
     * Array de hooks registrados para debugging
     * 
     * @var array
     */
    private $registered_hooks = [];

    /**
     * Constructor privado para Singleton
     */
    private function __construct()
    {
        $this->init_hooks();
    }

    /**
     * Obtener instancia única
     * 
     * @return Starter_Hooks
     */
    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Inicializar hooks del tema
     * 
     * @return void
     */
    private function init_hooks()
    {
        // Registrar hooks automáticamente en puntos clave de WordPress
        add_action('wp_head', [$this, 'fire_head_hooks'], 1);
        add_action('wp_footer', [$this, 'fire_footer_hooks'], 1);
        add_action('get_header', [$this, 'fire_before_header_hooks']);
        add_action('get_footer', [$this, 'fire_before_footer_hooks']);
    }

    /**
     * Disparar hooks en el head
     * 
     * @return void
     */
    public function fire_head_hooks()
    {
        /**
         * Hook ejecutado al inicio del <head>
         * 
         * @since 1.0.0
         */
        do_action('starter_head_top');

        /**
         * Hook ejecutado al final del <head>
         * 
         * @since 1.0.0
         */
        add_action('wp_head', function() {
            do_action('starter_head_bottom');
        }, 999);
    }

    /**
     * Disparar hooks en el footer
     * 
     * @return void
     */
    public function fire_footer_hooks()
    {
        /**
         * Hook ejecutado al inicio del footer
         * 
         * @since 1.0.0
         */
        do_action('starter_footer_top');

        /**
         * Hook ejecutado al final del footer
         * 
         * @since 1.0.0
         */
        add_action('wp_footer', function() {
            do_action('starter_footer_bottom');
        }, 999);
    }

    /**
     * Disparar hooks antes del header
     * 
     * @return void
     */
    public function fire_before_header_hooks()
    {
        /**
         * Hook ejecutado antes de cargar header.php
         * 
         * @since 1.0.0
         */
        do_action('starter_before_header');
    }

    /**
     * Disparar hooks antes del footer
     * 
     * @return void
     */
    public function fire_before_footer_hooks()
    {
        /**
         * Hook ejecutado antes de cargar footer.php
         * 
         * @since 1.0.0
         */
        do_action('starter_before_footer');
    }

    /**
     * Hook: Antes del contenido principal
     * 
     * @return void
     */
    public static function before_content()
    {
        /**
         * Hook ejecutado antes del contenido principal
         * 
         * @since 1.0.0
         */
        do_action('starter_before_content');
    }

    /**
     * Hook: Después del contenido principal
     * 
     * @return void
     */
    public static function after_content()
    {
        /**
         * Hook ejecutado después del contenido principal
         * 
         * @since 1.0.0
         */
        do_action('starter_after_content');
    }

    /**
     * Hook: Antes del loop
     * 
     * @return void
     */
    public static function before_loop()
    {
        /**
         * Hook ejecutado antes del loop de WordPress
         * 
         * @since 1.0.0
         */
        do_action('starter_before_loop');
    }

    /**
     * Hook: Después del loop
     * 
     * @return void
     */
    public static function after_loop()
    {
        /**
         * Hook ejecutado después del loop de WordPress
         * 
         * @since 1.0.0
         */
        do_action('starter_after_loop');
    }

    /**
     * Hook: Antes de un post individual
     * 
     * @param int $post_id ID del post
     * @return void
     */
    public static function before_post($post_id = null)
    {
        if ($post_id === null) {
            $post_id = get_the_ID();
        }

        /**
         * Hook ejecutado antes de mostrar un post
         * 
         * @since 1.0.0
         * @param int $post_id ID del post actual
         */
        do_action('starter_before_post', $post_id);
    }

    /**
     * Hook: Después de un post individual
     * 
     * @param int $post_id ID del post
     * @return void
     */
    public static function after_post($post_id = null)
    {
        if ($post_id === null) {
            $post_id = get_the_ID();
        }

        /**
         * Hook ejecutado después de mostrar un post
         * 
         * @since 1.0.0
         * @param int $post_id ID del post actual
         */
        do_action('starter_after_post', $post_id);
    }

    /**
     * Hook: Antes del título del post
     * 
     * @param int $post_id ID del post
     * @return void
     */
    public static function before_post_title($post_id = null)
    {
        if ($post_id === null) {
            $post_id = get_the_ID();
        }

        /**
         * Hook ejecutado antes del título del post
         * 
         * @since 1.0.0
         * @param int $post_id ID del post actual
         */
        do_action('starter_before_post_title', $post_id);
    }

    /**
     * Hook: Después del título del post
     * 
     * @param int $post_id ID del post
     * @return void
     */
    public static function after_post_title($post_id = null)
    {
        if ($post_id === null) {
            $post_id = get_the_ID();
        }

        /**
         * Hook ejecutado después del título del post
         * 
         * @since 1.0.0
         * @param int $post_id ID del post actual
         */
        do_action('starter_after_post_title', $post_id);
    }

    /**
     * Hook: Antes del contenido del post
     * 
     * @param int $post_id ID del post
     * @return void
     */
    public static function before_post_content($post_id = null)
    {
        if ($post_id === null) {
            $post_id = get_the_ID();
        }

        /**
         * Hook ejecutado antes del contenido del post
         * 
         * @since 1.0.0
         * @param int $post_id ID del post actual
         */
        do_action('starter_before_post_content', $post_id);
    }

    /**
     * Hook: Después del contenido del post
     * 
     * @param int $post_id ID del post
     * @return void
     */
    public static function after_post_content($post_id = null)
    {
        if ($post_id === null) {
            $post_id = get_the_ID();
        }

        /**
         * Hook ejecutado después del contenido del post
         * 
         * @since 1.0.0
         * @param int $post_id ID del post actual
         */
        do_action('starter_after_post_content', $post_id);
    }

    /**
     * Hook: En la sidebar
     * 
     * @param string $sidebar_id ID de la sidebar
     * @return void
     */
    public static function sidebar($sidebar_id = 'primary')
    {
        /**
         * Hook ejecutado en la sidebar
         * 
         * @since 1.0.0
         * @param string $sidebar_id ID de la sidebar
         */
        do_action('starter_sidebar', $sidebar_id);
    }

    /**
     * Filtro: Clases del body
     * 
     * @param array $classes Clases existentes
     * @return array Clases filtradas
     */
    public static function body_classes($classes)
    {
        /**
         * Filtro para modificar las clases del body
         * 
         * @since 1.0.0
         * @param array $classes Array de clases CSS
         */
        return apply_filters('starter_body_classes', $classes);
    }

    /**
     * Filtro: Clases del post
     * 
     * @param array $classes Clases existentes
     * @param int   $post_id ID del post
     * @return array Clases filtradas
     */
    public static function post_classes($classes, $post_id = null)
    {
        if ($post_id === null) {
            $post_id = get_the_ID();
        }

        /**
         * Filtro para modificar las clases del post
         * 
         * @since 1.0.0
         * @param array $classes Array de clases CSS
         * @param int   $post_id ID del post
         */
        return apply_filters('starter_post_classes', $classes, $post_id);
    }

    /**
     * Filtro: Contenido del post
     * 
     * @param string $content Contenido del post
     * @param int    $post_id ID del post
     * @return string Contenido filtrado
     */
    public static function post_content($content, $post_id = null)
    {
        if ($post_id === null) {
            $post_id = get_the_ID();
        }

        /**
         * Filtro para modificar el contenido del post
         * 
         * @since 1.0.0
         * @param string $content Contenido del post
         * @param int    $post_id ID del post
         */
        return apply_filters('starter_post_content', $content, $post_id);
    }

    /**
     * Registrar un hook personalizado para debugging
     * 
     * @param string $hook_name Nombre del hook
     * @param string $description Descripción del hook
     * @return void
     */
    public function register_hook($hook_name, $description = '')
    {
        $this->registered_hooks[$hook_name] = [
            'name' => $hook_name,
            'description' => $description,
            'registered_at' => current_time('mysql')
        ];
    }

    /**
     * Obtener todos los hooks registrados
     * 
     * @return array Array de hooks registrados
     */
    public function get_registered_hooks()
    {
        return $this->registered_hooks;
    }

    /**
     * Verificar si un hook está registrado
     * 
     * @param string $hook_name Nombre del hook
     * @return bool True si está registrado
     */
    public function is_hook_registered($hook_name)
    {
        return isset($this->registered_hooks[$hook_name]);
    }
}

// Inicializar el sistema de hooks
Starter_Hooks::get_instance();
