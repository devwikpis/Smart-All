<?php
/**
 * Sistema de Validación y Sanitización
 * 
 * Proporciona métodos centralizados para validar y sanitizar datos
 * de forma segura y consistente en todo el tema.
 * 
 * @package Starter_Theme
 * @version 1.0.0
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

class Starter_Validator
{
    /**
     * Instancia única (Singleton)
     * 
     * @var Starter_Validator|null
     */
    private static $instance = null;

    /**
     * Errores de validación
     * 
     * @var array
     */
    private $errors = [];

    /**
     * Constructor privado
     */
    private function __construct()
    {
        // Constructor vacío
    }

    /**
     * Obtener instancia única
     * 
     * @return Starter_Validator
     */
    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Sanitizar texto simple
     * 
     * @param string $value Valor a sanitizar
     * @return string Valor sanitizado
     */
    public static function sanitize_text($value)
    {
        return sanitize_text_field($value);
    }

    /**
     * Sanitizar textarea (permite saltos de línea)
     * 
     * @param string $value Valor a sanitizar
     * @return string Valor sanitizado
     */
    public static function sanitize_textarea($value)
    {
        return sanitize_textarea_field($value);
    }

    /**
     * Sanitizar email
     * 
     * @param string $email Email a sanitizar
     * @return string Email sanitizado
     */
    public static function sanitize_email($email)
    {
        return sanitize_email($email);
    }

    /**
     * Sanitizar URL
     * 
     * @param string $url URL a sanitizar
     * @return string URL sanitizada
     */
    public static function sanitize_url($url)
    {
        return esc_url_raw($url);
    }

    /**
     * Sanitizar slug
     * 
     * @param string $slug Slug a sanitizar
     * @return string Slug sanitizado
     */
    public static function sanitize_slug($slug)
    {
        return sanitize_title($slug);
    }

    /**
     * Sanitizar HTML (permite tags seguros)
     * 
     * @param string $html HTML a sanitizar
     * @param array  $allowed_tags Tags permitidos (opcional)
     * @return string HTML sanitizado
     */
    public static function sanitize_html($html, $allowed_tags = null)
    {
        if ($allowed_tags === null) {
            $allowed_tags = wp_kses_allowed_html('post');
        }
        return wp_kses($html, $allowed_tags);
    }

    /**
     * Sanitizar número entero
     * 
     * @param mixed $value Valor a sanitizar
     * @return int Número entero
     */
    public static function sanitize_int($value)
    {
        return intval($value);
    }

    /**
     * Sanitizar número flotante
     * 
     * @param mixed $value Valor a sanitizar
     * @return float Número flotante
     */
    public static function sanitize_float($value)
    {
        return floatval($value);
    }

    /**
     * Sanitizar booleano
     * 
     * @param mixed $value Valor a sanitizar
     * @return bool Booleano
     */
    public static function sanitize_bool($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Sanitizar array
     * 
     * @param array    $array Array a sanitizar
     * @param callable $callback Función de sanitización para cada elemento
     * @return array Array sanitizado
     */
    public static function sanitize_array($array, $callback = null)
    {
        if (!is_array($array)) {
            return [];
        }

        if ($callback === null) {
            $callback = [self::class, 'sanitize_text'];
        }

        return array_map($callback, $array);
    }

    /**
     * Sanitizar clave de array
     * 
     * @param string $key Clave a sanitizar
     * @return string Clave sanitizada
     */
    public static function sanitize_key($key)
    {
        return sanitize_key($key);
    }

    /**
     * Sanitizar nombre de archivo
     * 
     * @param string $filename Nombre de archivo
     * @return string Nombre sanitizado
     */
    public static function sanitize_filename($filename)
    {
        return sanitize_file_name($filename);
    }

    /**
     * Sanitizar clase CSS
     * 
     * @param string $class Clase CSS
     * @return string Clase sanitizada
     */
    public static function sanitize_css_class($class)
    {
        return sanitize_html_class($class);
    }

    /**
     * Sanitizar hex color
     * 
     * @param string $color Color hexadecimal
     * @return string Color sanitizado o vacío si inválido
     */
    public static function sanitize_hex_color($color)
    {
        if (empty($color)) {
            return '';
        }

        // Remover # si existe
        $color = ltrim($color, '#');

        // Validar formato hex
        if (preg_match('/^[a-fA-F0-9]{6}$/', $color)) {
            return '#' . $color;
        } elseif (preg_match('/^[a-fA-F0-9]{3}$/', $color)) {
            return '#' . $color;
        }

        return '';
    }

    /**
     * Validar email
     * 
     * @param string $email Email a validar
     * @return bool|string Email válido o false
     */
    public static function validate_email($email)
    {
        $email = self::sanitize_email($email);
        return is_email($email) ? $email : false;
    }

    /**
     * Validar URL
     * 
     * @param string $url URL a validar
     * @return bool|string URL válida o false
     */
    public static function validate_url($url)
    {
        $url = self::sanitize_url($url);
        return filter_var($url, FILTER_VALIDATE_URL) ? $url : false;
    }

    /**
     * Validar número de teléfono
     * 
     * @param string $phone Teléfono a validar
     * @return bool|string Teléfono válido o false
     */
    public static function validate_phone($phone)
    {
        // Remover caracteres no numéricos excepto + y espacios
        $phone = preg_replace('/[^0-9+\s()-]/', '', $phone);
        
        // Validar que tenga al menos 7 dígitos
        if (preg_match('/\d{7,}/', $phone)) {
            return $phone;
        }

        return false;
    }

    /**
     * Validar longitud de string
     * 
     * @param string $value Valor a validar
     * @param int    $min   Longitud mínima
     * @param int    $max   Longitud máxima
     * @return bool
     */
    public static function validate_length($value, $min = 0, $max = PHP_INT_MAX)
    {
        $length = strlen($value);
        return $length >= $min && $length <= $max;
    }

    /**
     * Validar que el valor esté en un array de opciones
     * 
     * @param mixed $value   Valor a validar
     * @param array $options Opciones válidas
     * @return bool
     */
    public static function validate_in_array($value, $options)
    {
        return in_array($value, $options, true);
    }

    /**
     * Validar número en rango
     * 
     * @param numeric $value Valor a validar
     * @param numeric $min   Valor mínimo
     * @param numeric $max   Valor máximo
     * @return bool
     */
    public static function validate_range($value, $min, $max)
    {
        return $value >= $min && $value <= $max;
    }

    /**
     * Validar fecha
     * 
     * @param string $date   Fecha a validar
     * @param string $format Formato esperado (default: Y-m-d)
     * @return bool
     */
    public static function validate_date($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    /**
     * Validar que sea alfanumérico
     * 
     * @param string $value Valor a validar
     * @return bool
     */
    public static function validate_alphanumeric($value)
    {
        return ctype_alnum($value);
    }

    /**
     * Validar con expresión regular
     * 
     * @param string $value   Valor a validar
     * @param string $pattern Patrón regex
     * @return bool
     */
    public static function validate_regex($value, $pattern)
    {
        return preg_match($pattern, $value) === 1;
    }

    /**
     * Validar nonce de WordPress
     * 
     * @param string $nonce  Nonce a validar
     * @param string $action Acción del nonce
     * @return bool
     */
    public static function validate_nonce($nonce, $action)
    {
        return wp_verify_nonce($nonce, $action) !== false;
    }

    /**
     * Validar capacidad de usuario
     * 
     * @param string $capability Capacidad requerida
     * @param int    $user_id    ID del usuario (opcional)
     * @return bool
     */
    public static function validate_user_capability($capability, $user_id = null)
    {
        if ($user_id === null) {
            return current_user_can($capability);
        }
        
        $user = get_userdata($user_id);
        return $user && user_can($user, $capability);
    }

    /**
     * Validar que el post existe
     * 
     * @param int $post_id ID del post
     * @return bool
     */
    public static function validate_post_exists($post_id)
    {
        return get_post($post_id) !== null;
    }

    /**
     * Validar múltiples campos
     * 
     * @param array $data  Datos a validar
     * @param array $rules Reglas de validación
     * @return bool
     * 
     * @example
     * $rules = [
     *     'email' => ['required', 'email'],
     *     'name' => ['required', 'min:3', 'max:50'],
     *     'age' => ['required', 'int', 'range:18,100']
     * ];
     */
    public function validate_multiple($data, $rules)
    {
        $this->errors = [];
        $valid = true;

        foreach ($rules as $field => $field_rules) {
            $value = isset($data[$field]) ? $data[$field] : null;

            foreach ($field_rules as $rule) {
                if (!$this->apply_rule($field, $value, $rule)) {
                    $valid = false;
                }
            }
        }

        return $valid;
    }

    /**
     * Aplicar regla de validación
     * 
     * @param string $field Nombre del campo
     * @param mixed  $value Valor del campo
     * @param string $rule  Regla a aplicar
     * @return bool
     */
    private function apply_rule($field, $value, $rule)
    {
        // Parsear regla (ej: "min:3" -> rule: "min", param: "3")
        $parts = explode(':', $rule);
        $rule_name = $parts[0];
        $param = isset($parts[1]) ? $parts[1] : null;

        switch ($rule_name) {
            case 'required':
                if (empty($value)) {
                    $this->add_error($field, sprintf(__('El campo %s es requerido', 'starter'), $field));
                    return false;
                }
                break;

            case 'email':
                if (!self::validate_email($value)) {
                    $this->add_error($field, sprintf(__('El campo %s debe ser un email válido', 'starter'), $field));
                    return false;
                }
                break;

            case 'url':
                if (!self::validate_url($value)) {
                    $this->add_error($field, sprintf(__('El campo %s debe ser una URL válida', 'starter'), $field));
                    return false;
                }
                break;

            case 'min':
                if (!self::validate_length($value, intval($param))) {
                    $this->add_error($field, sprintf(__('El campo %s debe tener al menos %d caracteres', 'starter'), $field, $param));
                    return false;
                }
                break;

            case 'max':
                if (!self::validate_length($value, 0, intval($param))) {
                    $this->add_error($field, sprintf(__('El campo %s debe tener máximo %d caracteres', 'starter'), $field, $param));
                    return false;
                }
                break;

            case 'int':
                if (!is_numeric($value) || intval($value) != $value) {
                    $this->add_error($field, sprintf(__('El campo %s debe ser un número entero', 'starter'), $field));
                    return false;
                }
                break;

            case 'range':
                list($min, $max) = explode(',', $param);
                if (!self::validate_range($value, $min, $max)) {
                    $this->add_error($field, sprintf(__('El campo %s debe estar entre %s y %s', 'starter'), $field, $min, $max));
                    return false;
                }
                break;
        }

        return true;
    }

    /**
     * Agregar error de validación
     * 
     * @param string $field   Campo con error
     * @param string $message Mensaje de error
     * @return void
     */
    private function add_error($field, $message)
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }

    /**
     * Obtener errores de validación
     * 
     * @param string|null $field Campo específico (opcional)
     * @return array
     */
    public function get_errors($field = null)
    {
        if ($field !== null) {
            return isset($this->errors[$field]) ? $this->errors[$field] : [];
        }
        return $this->errors;
    }

    /**
     * Verificar si hay errores
     * 
     * @return bool
     */
    public function has_errors()
    {
        return !empty($this->errors);
    }

    /**
     * Limpiar errores
     * 
     * @return void
     */
    public function clear_errors()
    {
        $this->errors = [];
    }
}

// Inicializar validator
Starter_Validator::get_instance();
