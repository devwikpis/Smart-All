<?php

/**
 * Contiene todas las funciones de callback para AJAX
 * 
 * @package Starter_Theme
 */
class Starter_Ajax_Handler
{
    protected $callbacks = [];

    public function register_action($action, $callback)
    {
        $this->callbacks[$action] = $callback;

        add_action("wp_ajax_{$action}", [$this, 'handle_request']);
        add_action("wp_ajax_nopriv_{$action}", [$this, 'handle_request']);
    }

    public function handle_request()
    {
        try {
            error_log('Datos recibidos: ' . print_r($_REQUEST, true));

            if (empty($_REQUEST['nonce'])) {
                throw new Exception('Nonce no proporcionado', 403);
            }

            $nonce = sanitize_text_field($_REQUEST['nonce']);
            $nonce_valid = wp_verify_nonce($nonce, 'starter_ajax_nonce');

            error_log('Nonce recibido: ' . $nonce);
            error_log('Nonce válido: ' . ($nonce_valid ? 'Sí' : 'No'));

            if (!$nonce_valid) {
                throw new Exception('Nonce inválido o expirado', 403);
            }

            $action = sanitize_text_field($_REQUEST['action'] ?? '');
            if (isset($this->callbacks[$action]) && is_callable($this->callbacks[$action])) {
                call_user_func($this->callbacks[$action]);
            } else {
                throw new Exception("Callback no definido para la acción '{$action}'", 404);
            }
        } catch (Exception $e) {
            error_log('Error en AJAX: ' . $e->getMessage());
            wp_send_json_error($e->getMessage(), $e->getCode());
        }

        wp_die();
    }

    public static function localize_scripts()
    {
        wp_localize_script('starter-ajax', 'starter_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('starter_ajax_nonce')
        ]);
    }
}
