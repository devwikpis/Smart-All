<?php

/**
 * Clase principal que coordina todas las funcionalidades del tema
 * 
 * @package Starter_Theme
 * @version 1.0.0
 */
class Starter_Master
{
    private $loader;
    private $theme_name;
    private $version;
    private $ajax_handler;
    public function __construct()
    {
        $this->theme_name = 'Starter_Theme';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->initialize_instances();
        $this->set_language_support();
        $this->define_hooks();
    }

    private function load_dependencies()
    {
        $dependencies = [
            'inc/class-starter-hooks-manager.php',
            'inc/class-starter-security.php',
            'admin/class-starter-admin.php',
            'public/class-starter-public.php',
            'inc/class-starter-ajax-handler.php',
            'inc/class-starter-ajax-functions.php',
            'includes/class-starter-renderer.php',
            'includes/class-starter-breadcrumbs.php',
            'includes/class-starter-shortcodes.php'
        ];

        foreach ($dependencies as $file) {
            $full_path = STARTER_DIR_PATH . $file;

            if (!file_exists($full_path)) {
                $error_msg = sprintf(
                    __('Archivo requerido no encontrado: %s', 'starter'),
                    $full_path
                );

                if (WP_DEBUG) {
                    throw new RuntimeException($error_msg);
                } else {
                    error_log($error_msg);
                    continue;
                }
            }

            require_once $full_path;
        }
    }

    private function initialize_instances()
    {
        $this->loader         = new Theme_Hooks_Manager();
        $this->admin          = new Starter_Admin($this->theme_name, $this->version);
        $this->public         = new Starter_Public($this->theme_name, $this->version);
        $this->ajax_handler   = new Starter_Ajax_Handler();
        $this->ajax_functions = new Starter_Ajax_Functions();
        $this->shortcodes     = new Starter_Shortcodes($this->theme_name, $this->version);
    }

    private function set_language_support()
    {
        load_theme_textdomain('starter', get_template_directory() . '/languages');
    }

    private function define_hooks()
    {
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Hooks específicos del área de administración
     */
    private function define_admin_hooks()
    {
        $this->loader->add_action('after_setup_theme', $this->admin, 'setup_theme');
        $this->loader->add_action('admin_enqueue_scripts', $this->admin, 'enqueue_styles');

        if (function_exists('acf_add_options_page')) {
            $this->loader->add_action('acf/init', $this->admin, 'register_options_pages');
        }
        $this->loader->add_shortcode('starter_module_tabs', $this->shortcodes, 'starter_shortcode_module_tabs');
        $this->loader->add_shortcode('starter_module_teachers', $this->shortcodes, 'starter_shortcode_module_teachers');
        $this->loader->add_shortcode('starter_module_faqs', $this->shortcodes, 'starter_shortcode_module_faqs');
        $this->loader->add_shortcode('starter_module_events', $this->shortcodes, 'starter_shortcode_module_events');
        $this->loader->add_shortcode('starter_module_faculties', $this->shortcodes, 'starter_shortcode_module_faculties');
        $this->loader->add_shortcode('starter_module_contact', $this->shortcodes, 'starter_shortcode_module_contact');
        $this->loader->add_shortcode('starter_module_accordion', $this->shortcodes, 'starter_shortcode_module_accordion');
        $this->loader->add_shortcode('starter_module_news', $this->shortcodes, 'starter_shortcode_module_news');
        $this->loader->add_shortcode('starter_module_contact_form', $this->shortcodes, 'starter_shortcode_module_contact_form');
        $this->loader->add_shortcode('starter_module_tabs_slide', $this->shortcodes, 'starter_shortcode_module_tabs_slide');
        $this->loader->add_shortcode('starter_module_figures', $this->shortcodes, 'starter_shortcode_module_figures');
        $this->loader->add_shortcode('starter_module_calls', $this->shortcodes, 'starter_shortcode_module_calls');
        $this->loader->add_shortcode('starter_module_magazines', $this->shortcodes, 'starter_shortcode_module_magazines');
        $this->loader->add_shortcode('starter_module_publications', $this->shortcodes, 'starter_shortcode_module_sale_publications');
        $this->loader->add_shortcode('starter_module_resources', $this->shortcodes, 'starter_shortcode_module_resources');
        $this->loader->add_shortcode('starter_module_full_tabs', $this->shortcodes, 'starter_shortcode_module_full_tabs');
        $this->loader->add_shortcode('starter_module_interest', $this->shortcodes, 'starter_shortcode_module_interest');
        $this->loader->add_shortcode('starter_module_directory', $this->shortcodes, 'starter_shortcode_module_directory');
        $this->loader->add_shortcode('starter_tabs_v1', $this->shortcodes, 'starter_shortcode_tabs_v1');
        $this->loader->add_shortcode('starter_cards_v1', $this->shortcodes, 'starter_shortcode_cards_v1');
        $this->loader->add_shortcode('starter_details_v1', $this->shortcodes, 'starter_shortcode_details_v1');
        $this->loader->add_shortcode('starter_contact_banner', $this->shortcodes, 'starter_shortcode_contact_banner');
        $this->loader->add_shortcode('starter_project_showcase', $this->shortcodes, 'starter_shortcode_project_showcase');
        $this->loader->add_shortcode('starter_module_icon_card', $this->shortcodes, 'starter_shortcode_module_icon_card');
        $this->loader->add_shortcode('starter_testimonials', $this->shortcodes, 'starter_shortcode_testimonials');
    }
    /**
     * Hooks específicos del frontend
     */
    private function define_public_hooks()
    {
        $this->loader->add_action('wp_enqueue_scripts', $this->public, 'enqueue_styles');

        $this->loader->add_action('wp_enqueue_scripts', $this->public, 'enqueue_scripts');
        $this->loader->add_action('init', $this->public, 'starter_menus_frontend');
        $this->ajax_handler->register_action(
            'get_data_filter',
            [$this->ajax_functions, 'get_data_filter']
        );
        $this->ajax_handler->register_action(
            'starter_filter_formalities_callback',
            [$this->ajax_functions, 'starter_filter_formalities_callback']
        );
        $this->ajax_handler->register_action(
            'filter_programs_by_city',
            [$this->ajax_functions, 'filter_programs_by_city']
        );
    }

    /**
     * Ejecuta el cargador de hooks
     */
    public function run()
    {
        $this->loader->register();
    }

    /**
     * Obtiene el nombre del tema
     * 
     * @return string
     */
    public function get_theme_name()
    {
        return $this->theme_name;
    }

    /**
     * Obtiene la versión del tema
     * 
     * @return string
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Obtiene el cargador de hooks
     * 
     * @return Theme_Hooks_Manager
     */
    public function get_loader()
    {
        return $this->loader;
    }
}
