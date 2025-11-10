<?php
class Starter_Public
{
    private $theme_name;
    private $version;

    public function __construct($theme_name, $version)
    {
        $this->theme_name = $theme_name;
        $this->version = $version;
    }

    public function enqueue_styles()
    {
        wp_enqueue_style(
            'poppins-font',
            STARTER_DIR_URI . 'assets/fonts/poppins/poppins.css',
            array(),
            $this->version,
            'all'
        );

        wp_enqueue_style(
            'public-css',
            STARTER_DIR_URI . 'public/css/style.css',
            array('poppins-font'),
            $this->version,
            'all'
        );

        // Encolar estilos de home solo en la front-page
        if (is_front_page()) {
            wp_enqueue_style(
                'home-css',
                STARTER_DIR_URI . 'public/css/home.css',
                array('public-css'),
                $this->version,
                'all'
            );
        }

        // Encolar estilos de services solo en el template de servicios
        if (is_page_template('templates/services.php')) {
            wp_enqueue_style(
                'services-css',
                STARTER_DIR_URI . 'public/css/services.css',
                array('public-css'),
                $this->version,
                'all'
            );
        }

        // Encolar estilos de single-service solo en el single de servicio
        if (is_singular('servicio')) {
            wp_enqueue_style(
                'single-service-css',
                STARTER_DIR_URI . 'public/css/single-service.css',
                array('public-css'),
                $this->version,
                'all'
            );
        }

        // Encolar estilos de proyects solo en el template de proyectos
        if (is_page_template('templates/proyects.php')) {
            wp_enqueue_style(
                'proyects-css',
                STARTER_DIR_URI . 'public/css/proyects.css',
                array('public-css'),
                $this->version,
                'all'
            );
        }

        // Encolar estilos de about solo en el template de about
        if (is_page_template('templates/about.php')) {
            wp_enqueue_style(
                'about-css',
                STARTER_DIR_URI . 'public/css/about.css',
                array('public-css'),
                $this->version,
                'all'
            );
        }

        // Encolar estilos de contact solo en el template de contact
        if (is_page_template('templates/contact.php')) {
            wp_enqueue_style(
                'contact-css',
                STARTER_DIR_URI . 'public/css/contact.css',
                array('public-css'),
                $this->version,
                'all'
            );
        }
    }


    public function enqueue_scripts()
    {

        wp_enqueue_script(
            'public-js',
            STARTER_DIR_URI . 'public/js/app.js',
            ['jquery'],
            $this->version,
            true
        );
        wp_localize_script(
            'public-js',
            'starter_ajax',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('starter_ajax_nonce')
            ]
        );
    }


    /**
     * Funciones para ajustar el menú del frontend
     */

    public function starter_menus_frontend()
    {
        register_nav_menus([
            'menu_primary'   => __('Primary Menu', $this->theme_name),
        ]);

        $logo = [
            'width' => 230,
            'height' => 80,
            'flex-height' => true,
            'flex-width'  => true,
        ];
        add_theme_support('custom-logo', $logo);
    }
}
