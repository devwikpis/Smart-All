<?php

/**
 * Gestiona el registro centralizado de hooks (acciones, filtros y shortcodes) para el tema.
 * 
 * @package Starter_Theme
 * @version 1.1.0
 */
class Theme_Hooks_Manager
{
    private array $actions = [];
    private array $filters = [];
    private array $shortcodes = [];

    /**
     * Añade una acción de WordPress
     */
    public function add_action(
        string $hook,
        object $component,
        string $callback,
        int $priority = 10,
        int $accepted_args = 1
    ): void {
        $this->actions[] = [
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        ];
    }

    /**
     * Añade un filtro de WordPress
     */
    public function add_filter(
        string $hook,
        object $component,
        string $callback,
        int $priority = 10,
        int $accepted_args = 1
    ): void {
        $this->filters[] = [
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        ];
    }

    /**
     * Añade un shortcode de WordPress
     */
    public function add_shortcode(
        string $tag,
        object $component,
        string $callback
    ): void {
        $this->shortcodes[] = [
            'tag'       => $tag,
            'component' => $component,
            'callback'  => $callback
        ];
    }

    /**
     * Registra todos los hooks en WordPress
     */
    public function register(): void
    {
        foreach ($this->actions as $hook) {
            add_action(
                $hook['hook'],
                [$hook['component'], $hook['callback']],
                $hook['priority'],
                $hook['accepted_args']
            );
        }

        foreach ($this->filters as $hook) {
            add_filter(
                $hook['hook'],
                [$hook['component'], $hook['callback']],
                $hook['priority'],
                $hook['accepted_args']
            );
        }

        foreach ($this->shortcodes as $shortcode) {
            add_shortcode(
                $shortcode['tag'],
                [$shortcode['component'], $shortcode['callback']]
            );
        }
    }
}
