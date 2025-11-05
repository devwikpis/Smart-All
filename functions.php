<?php

/**
 * Functions.php del tema Starter
 * 
 * @package Starter_Theme
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

$theme_dir = trailingslashit(get_template_directory());
$theme_uri = trailingslashit(get_template_directory_uri());
$front_page_id = get_option('page_on_front');
define('STARTER_DIR_PATH', $theme_dir);
define('STARTER_DIR_URI', $theme_uri);
define('STARTER_VERSION', wp_get_theme()->get('Version'));
define('FRONT_PAGE_ID', $front_page_id);
if (WP_DEBUG) {
    error_log('Tema Starter inicializado - Versión: ' . STARTER_VERSION);
}

require_once STARTER_DIR_PATH . 'inc/class-starter-master.php';

function starter_bootstrap_theme()
{
    if (!class_exists('Starter_Master')) {
        wp_die(__('Error: El núcleo del tema no pudo cargarse.', 'starter'));
    }

    $theme = new Starter_Master();
    $theme->run();
}
add_action('after_setup_theme', 'starter_bootstrap_theme', 0);

register_activation_hook(__FILE__, 'starter_activate_theme');
function starter_activate_theme()
{
    if (!current_user_can('activate_plugins')) return;

    flush_rewrite_rules();
    update_option('starter_theme_version', STARTER_VERSION);
}
