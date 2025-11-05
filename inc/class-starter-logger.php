<?php
/**
 * Sistema de Logging y Debugging
 * 
 * Proporciona funcionalidades avanzadas de logging con diferentes niveles,
 * contexto y formateo para facilitar el debugging y monitoreo del tema.
 * 
 * @package Starter_Theme
 * @version 1.0.0
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

class Starter_Logger
{
    /**
     * Niveles de log
     */
    const LEVEL_DEBUG = 'debug';
    const LEVEL_INFO = 'info';
    const LEVEL_WARNING = 'warning';
    const LEVEL_ERROR = 'error';
    const LEVEL_CRITICAL = 'critical';

    /**
     * Instancia única (Singleton)
     * 
     * @var Starter_Logger|null
     */
    private static $instance = null;

    /**
     * Archivo de log personalizado
     * 
     * @var string
     */
    private $log_file;

    /**
     * Nivel mínimo de log
     * 
     * @var string
     */
    private $min_level;

    /**
     * Historial de logs en memoria
     * 
     * @var array
     */
    private $log_history = [];

    /**
     * Máximo de logs en memoria
     * 
     * @var int
     */
    private $max_history = 100;

    /**
     * Constructor privado
     */
    private function __construct()
    {
        $upload_dir = wp_upload_dir();
        $log_dir = $upload_dir['basedir'] . '/starter-logs';
        
        // Crear directorio de logs si no existe
        if (!file_exists($log_dir)) {
            wp_mkdir_p($log_dir);
            // Proteger directorio con .htaccess
            file_put_contents($log_dir . '/.htaccess', 'Deny from all');
        }

        $this->log_file = $log_dir . '/starter-' . date('Y-m-d') . '.log';
        $this->min_level = defined('WP_DEBUG') && WP_DEBUG ? self::LEVEL_DEBUG : self::LEVEL_WARNING;
    }

    /**
     * Obtener instancia única
     * 
     * @return Starter_Logger
     */
    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Log de nivel DEBUG
     * 
     * @param string $message Mensaje a loguear
     * @param array  $context Contexto adicional
     * @return void
     */
    public static function debug($message, $context = [])
    {
        self::get_instance()->log($message, self::LEVEL_DEBUG, $context);
    }

    /**
     * Log de nivel INFO
     * 
     * @param string $message Mensaje a loguear
     * @param array  $context Contexto adicional
     * @return void
     */
    public static function info($message, $context = [])
    {
        self::get_instance()->log($message, self::LEVEL_INFO, $context);
    }

    /**
     * Log de nivel WARNING
     * 
     * @param string $message Mensaje a loguear
     * @param array  $context Contexto adicional
     * @return void
     */
    public static function warning($message, $context = [])
    {
        self::get_instance()->log($message, self::LEVEL_WARNING, $context);
    }

    /**
     * Log de nivel ERROR
     * 
     * @param string $message Mensaje a loguear
     * @param array  $context Contexto adicional
     * @return void
     */
    public static function error($message, $context = [])
    {
        self::get_instance()->log($message, self::LEVEL_ERROR, $context);
    }

    /**
     * Log de nivel CRITICAL
     * 
     * @param string $message Mensaje a loguear
     * @param array  $context Contexto adicional
     * @return void
     */
    public static function critical($message, $context = [])
    {
        self::get_instance()->log($message, self::LEVEL_CRITICAL, $context);
    }

    /**
     * Método principal de logging
     * 
     * @param string $message Mensaje a loguear
     * @param string $level   Nivel del log
     * @param array  $context Contexto adicional
     * @return void
     */
    public function log($message, $level = self::LEVEL_INFO, $context = [])
    {
        // Verificar si el nivel es suficiente para loguear
        if (!$this->should_log($level)) {
            return;
        }

        $log_entry = $this->format_log_entry($message, $level, $context);
        
        // Guardar en historial
        $this->add_to_history($log_entry);

        // Escribir en archivo si WP_DEBUG_LOG está activo
        if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
            $this->write_to_file($log_entry);
        }

        // Log en error_log de WordPress para errores críticos
        if (in_array($level, [self::LEVEL_ERROR, self::LEVEL_CRITICAL])) {
            error_log($log_entry['formatted']);
        }

        // Disparar acción para que otros puedan escuchar
        do_action('starter_log', $log_entry, $level, $message, $context);
    }

    /**
     * Verificar si se debe loguear según el nivel
     * 
     * @param string $level Nivel del log
     * @return bool
     */
    private function should_log($level)
    {
        $levels = [
            self::LEVEL_DEBUG => 0,
            self::LEVEL_INFO => 1,
            self::LEVEL_WARNING => 2,
            self::LEVEL_ERROR => 3,
            self::LEVEL_CRITICAL => 4
        ];

        return $levels[$level] >= $levels[$this->min_level];
    }

    /**
     * Formatear entrada de log
     * 
     * @param string $message Mensaje
     * @param string $level   Nivel
     * @param array  $context Contexto
     * @return array Entrada formateada
     */
    private function format_log_entry($message, $level, $context)
    {
        $timestamp = current_time('mysql');
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        $caller = isset($backtrace[2]) ? $backtrace[2] : [];
        
        $file = isset($caller['file']) ? basename($caller['file']) : 'unknown';
        $line = isset($caller['line']) ? $caller['line'] : 0;
        $function = isset($caller['function']) ? $caller['function'] : 'unknown';

        $formatted = sprintf(
            "[%s] [%s] [%s:%d] %s: %s",
            $timestamp,
            strtoupper($level),
            $file,
            $line,
            $function,
            $message
        );

        if (!empty($context)) {
            $formatted .= ' | Context: ' . json_encode($context, JSON_UNESCAPED_UNICODE);
        }

        return [
            'timestamp' => $timestamp,
            'level' => $level,
            'message' => $message,
            'context' => $context,
            'file' => $file,
            'line' => $line,
            'function' => $function,
            'formatted' => $formatted
        ];
    }

    /**
     * Escribir en archivo de log
     * 
     * @param array $log_entry Entrada de log
     * @return void
     */
    private function write_to_file($log_entry)
    {
        $formatted = $log_entry['formatted'] . PHP_EOL;
        
        // Escribir de forma segura
        if (is_writable(dirname($this->log_file))) {
            file_put_contents($this->log_file, $formatted, FILE_APPEND | LOCK_EX);
        }
    }

    /**
     * Agregar al historial en memoria
     * 
     * @param array $log_entry Entrada de log
     * @return void
     */
    private function add_to_history($log_entry)
    {
        $this->log_history[] = $log_entry;

        // Mantener solo los últimos N logs
        if (count($this->log_history) > $this->max_history) {
            array_shift($this->log_history);
        }
    }

    /**
     * Obtener historial de logs
     * 
     * @param string|null $level Filtrar por nivel
     * @return array
     */
    public function get_history($level = null)
    {
        if ($level === null) {
            return $this->log_history;
        }

        return array_filter($this->log_history, function($entry) use ($level) {
            return $entry['level'] === $level;
        });
    }

    /**
     * Limpiar historial
     * 
     * @return void
     */
    public function clear_history()
    {
        $this->log_history = [];
    }

    /**
     * Obtener estadísticas de logs
     * 
     * @return array
     */
    public function get_stats()
    {
        $stats = [
            'total' => count($this->log_history),
            'by_level' => []
        ];

        foreach ($this->log_history as $entry) {
            $level = $entry['level'];
            if (!isset($stats['by_level'][$level])) {
                $stats['by_level'][$level] = 0;
            }
            $stats['by_level'][$level]++;
        }

        return $stats;
    }

    /**
     * Loguear query de base de datos
     * 
     * @param string $query Query SQL
     * @param float  $time  Tiempo de ejecución
     * @return void
     */
    public static function log_query($query, $time)
    {
        $level = $time > 1.0 ? self::LEVEL_WARNING : self::LEVEL_DEBUG;
        $message = sprintf('Query execution time: %.4fs', $time);
        
        self::get_instance()->log($message, $level, [
            'query' => $query,
            'time' => $time
        ]);
    }

    /**
     * Loguear error de PHP
     * 
     * @param int    $errno   Número de error
     * @param string $errstr  Mensaje de error
     * @param string $errfile Archivo donde ocurrió
     * @param int    $errline Línea donde ocurrió
     * @return void
     */
    public static function log_php_error($errno, $errstr, $errfile, $errline)
    {
        $level = self::LEVEL_ERROR;
        
        switch ($errno) {
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                $level = self::LEVEL_CRITICAL;
                break;
            case E_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_USER_WARNING:
                $level = self::LEVEL_WARNING;
                break;
        }

        self::get_instance()->log($errstr, $level, [
            'errno' => $errno,
            'file' => $errfile,
            'line' => $errline
        ]);
    }

    /**
     * Loguear excepción
     * 
     * @param Exception $exception Excepción capturada
     * @return void
     */
    public static function log_exception($exception)
    {
        self::get_instance()->log($exception->getMessage(), self::LEVEL_CRITICAL, [
            'exception' => get_class($exception),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ]);
    }

    /**
     * Dump de variable para debugging
     * 
     * @param mixed  $var  Variable a dumpear
     * @param string $label Etiqueta descriptiva
     * @return void
     */
    public static function dump($var, $label = 'Variable Dump')
    {
        $dump = print_r($var, true);
        self::get_instance()->log($label, self::LEVEL_DEBUG, [
            'dump' => $dump,
            'type' => gettype($var)
        ]);
    }

    /**
     * Medir tiempo de ejecución de una función
     * 
     * @param callable $callback Función a medir
     * @param string   $label    Etiqueta para el log
     * @return mixed Resultado de la función
     */
    public static function measure($callback, $label = 'Execution')
    {
        $start = microtime(true);
        $result = $callback();
        $time = microtime(true) - $start;

        $level = $time > 1.0 ? self::LEVEL_WARNING : self::LEVEL_DEBUG;
        self::get_instance()->log(sprintf('%s took %.4fs', $label, $time), $level, [
            'execution_time' => $time
        ]);

        return $result;
    }
}

// Inicializar logger
Starter_Logger::get_instance();
