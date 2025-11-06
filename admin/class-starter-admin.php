<?php

/**
 * Maneja todas las funcionalidades del área de administración del tema
 * 
 * @package Starter_Theme
 * @version 1.1.0
 */
class Starter_Admin
{

    private $theme_name;
    private $version;
    private $options_pages;

    public function __construct($theme_name, $version)
    {
        $this->theme_name = $theme_name;
        $this->version = $version;
        $this->init_options_pages();
    }

    /**
     * Inicializa la configuración de las páginas de opciones
     */
    private function init_options_pages()
    {
        $this->options_pages = [
            'main' => [
                'page_title' => __('Theme Options', 'starter'),
                'menu_title' => __('Theme Options', 'starter'),
                'menu_slug'  => 'theme-options',
                'capability' => 'edit_posts',
                'redirect'   => false,
                'icon_url'   => 'dashicons-admin-generic',
                'position'   => 60
            ],
            'header' => [
                'page_title' => __('Header Options', 'starter'),
                'menu_title' => __('Header', 'starter'),
                'menu_slug'  => 'theme-options-header',
                'capability' => 'edit_posts'
            ],
            'footer' => [
                'page_title' => __('Footer Options', 'starter'),
                'menu_title' => __('Footer', 'starter'),
                'menu_slug'  => 'theme-options-footer',
                'capability' => 'edit_posts'
            ]
        ];
    }


    /**
     * Configura los soportes básicos del tema
     */
    public function setup_theme()
    {
        add_theme_support('post-thumbnails');
        add_image_size('blog-thumbnail', 1040, 450, true);


        add_theme_support('title-tag');
        add_theme_support('html5', ['script', 'style']);
    }

    /**
     * Registra las páginas de opciones con ACF
     */
    public function register_options_pages()
    {
        if (!function_exists('acf_add_options_page')) {
            return;
        }

        $main_page = acf_add_options_page($this->options_pages['main']);

        foreach (['header', 'footer'] as $page) {
            acf_add_options_sub_page(array_merge(
                $this->options_pages[$page],
                ['parent_slug' => $main_page['menu_slug']]
            ));
        }
    }

    /**
     * Carga assets en el admin
     */
    public function enqueue_scripts()
    {

        wp_enqueue_script(
            $this->theme_name . '-admin',
            get_template_directory_uri() . '/assets/js/starter-admin.js',
            ['jquery'],
            $this->version,
            true
        );

        wp_localize_script(
            $this->theme_name . '-admin',
            'starterAdmin',
            [
                'ajaxUrl'   => admin_url('admin-ajax.php'),
                'nonce'     => wp_create_nonce('starter_admin_nonce'),
                'i18n'      => [
                    'confirmDelete' => __('¿Estás seguro de eliminar este elemento?', 'starter')
                ]
            ]
        );
    }
    public function enqueue_styles()
    {
        wp_enqueue_style(
            'starter-admin',
            get_template_directory_uri() . '/css/starter-admin.css',
            array(),
            $this->version
        );
    }
}
