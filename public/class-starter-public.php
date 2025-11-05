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
            'public-css',
            STARTER_DIR_URI . 'public/css/style.css',
            array(),
            $this->version,
            'all'
        );
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
            'menu-1'        => __('Primary Menu', $this->theme_name),
            'menu_header'   => __('Header Menu', $this->theme_name),
            'footer_menu_1' => __('Footer Menu 1', $this->theme_name),
            'footer_menu_2' => __('Footer Menu 2', $this->theme_name),
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
