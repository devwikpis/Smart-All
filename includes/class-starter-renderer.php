<?php
function render_button(array $button): string
{
    if (empty($button['url_button']) || empty($button['text_button'])) {
        return '';
    }

    $defaults = [
        'tipo_de_boton' => [
            'estilo_de_boton' => 'button-default',
            'tamano_de_boton' => 'button-xl'
        ],
        'type_button' => 'default',
        '_blank' => false,
        'icons' => [],
        'attributes' => []
    ];
    $button = array_merge($defaults, $button);

    $url = (filter_var($button['url_button'], FILTER_VALIDATE_URL) ||
        preg_match('%^(/|#)[a-zA-Z0-9-._~:/?#[\]@!$&\'()*+,;=]*$%', $button['url_button']))
        ? $button['url_button']
        : '#';

    $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    $text = htmlspecialchars($button['text_button'], ENT_QUOTES, 'UTF-8');

    $icon_left = !empty($button['icons']['icon_left']) ? '<i class="left">' . $button['icons']['icon_left'] . '</i>' : '';
    $icon_right = !empty($button['icons']['icon_right']) ? '<i class="right">' . $button['icons']['icon_right'] . '</i>' : '';

    $target = $button['_blank'] ? ' target="_blank" rel="noopener noreferrer"' : '';

    $attributes = '';
    foreach ($button['attributes'] as $attr => $value) {
        $attributes .= ' ' . htmlspecialchars($attr, ENT_QUOTES, 'UTF-8') . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
    }

    $classes = ['button'];

    if (is_array($button['tipo_de_boton'])) {
        $classes[] = htmlspecialchars($button['tipo_de_boton']['estilo_de_boton'] ?? 'button-default');
        $classes[] = htmlspecialchars($button['tipo_de_boton']['tamano_de_boton'] ?? 'button-xl');
    } else {
        $classes[] = htmlspecialchars($button['tipo_de_boton']);
    }

    $class_attr = ' class="' . implode(' ', $classes) . '"';

    return '<a' . $class_attr . ' href="' . $url . '"' . $target . $attributes . '>' . $icon_left . $text . $icon_right . '</a>';
}

function process_image($image): string
{
    if (empty($image['url'])) {
        return '<img src="' . esc_url('/wp-content/uploads/2025/05/placeholder-image.svg') . '" alt="Imagen no disponible" loading="lazy">';
    }

    $url = esc_url($image['url']);
    $alt = !empty($image['alt']) ? esc_attr($image['alt']) : (!empty($image['title']) ? esc_attr($image['title']) : 'Imagen sin descripción');

    return '<img src="' . $url . '"' .
        (!empty($image['title']) ? ' title="' . esc_attr($image['title']) . '"' : '') .
        ' alt="' . $alt . '"' .
        ' loading="lazy"' .
        '>';
}
