<?php

function custom_breadcrumbs()
{
    $separator = '<span class="breadcrumb__separator" aria-hidden="true"><svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1 9L5 5L1 1" stroke="#B9B9B9" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</span>';
    $home_title = 'Inicio';

    $post_type = get_post_type();
    $queried_object = get_queried_object();
    $position = 1;


    echo '<nav class="breadcrumb max-width" aria-label="Migas de pan">';
    echo '<ol class="breadcrumb__list" itemscope itemtype="https://schema.org/BreadcrumbList">';

    echo '<li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    echo '<a class="breadcrumb__link" itemprop="item" href="' . esc_url(home_url('/')) . '">';
    echo '<span itemprop="name">' . esc_html($home_title) . '</span>';
    echo '</a>';
    echo '<meta itemprop="position" content="' . $position . '" />';
    echo $separator;
    echo '</li>';

    $position++;

    if (is_page() && !is_front_page()) {
        $ancestors = get_post_ancestors(get_the_ID());
        if ($ancestors) {
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor) {
                echo '<li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                echo '<a class="breadcrumb__link" itemprop="item" href="' . esc_url(get_permalink($ancestor)) . '">';
                echo '<span itemprop="name">' . esc_html(get_the_title($ancestor)) . '</span>';
                echo '</a>';
                echo '<meta itemprop="position" content="' . $position . '" />';
                echo $separator;
                echo '</li>';
                $position++;
            }
        }
        echo '<li class="breadcrumb__item breadcrumb__item--current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span class="breadcrumb__text" itemprop="name">' . esc_html(get_the_title()) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } elseif (is_single() && 'post' === $post_type) {
        $categories = get_the_category();
        if ($categories) {
            $primary_category = $categories[0];
            echo '<li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<a class="breadcrumb__link" itemprop="item" href="' . esc_url(get_category_link($primary_category->term_id)) . '">';
            echo '<span itemprop="name">' . esc_html($primary_category->name) . '</span>';
            echo '</a>';
            echo '<meta itemprop="position" content="' . $position . '" />';
            echo $separator;
            echo '</li>';
            $position++;
        }
        echo '<li class="breadcrumb__item breadcrumb__item--current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span class="breadcrumb__text" itemprop="name">' . esc_html(get_the_title()) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } elseif (is_single() && 'post' !== $post_type) {
        $post_type_object = get_post_type_object($post_type);
        echo '<li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<a class="breadcrumb__link" itemprop="item" href="' . esc_url(get_post_type_archive_link($post_type)) . '">';
        echo '<span itemprop="name">' . esc_html($post_type_object->labels->name) . '</span>';
        echo '</a>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo $separator;
        echo '</li>';
        $position++;
        echo '<li class="breadcrumb__item breadcrumb__item--current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span class="breadcrumb__text" itemprop="name">' . esc_html(get_the_title()) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } elseif (is_tax()) {
        $taxonomy = $queried_object->taxonomy;
        $term_id = $queried_object->term_id;
        $term_name = $queried_object->name;
        $taxonomy_object = get_taxonomy($taxonomy);

        if ($taxonomy == 'facultad') {
            echo '<li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<a class="breadcrumb__link" itemprop="item" href="/facultades">';
            echo '<span itemprop="name">Facultades</span>';
            echo '</a>';
            echo '<meta itemprop="position" content="' . $position . '" />';
            echo $separator;
            echo '</li>';
            $position++;
        }

        echo '<li class="breadcrumb__item breadcrumb__item--current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span class="breadcrumb__text" itemprop="name">' . esc_html($term_name) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } elseif (is_404()) {
        echo '<li class="breadcrumb__item breadcrumb__item--current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span class="breadcrumb__text" itemprop="name">Error 404</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    }

    echo '</ol>';
    echo '</nav>';
}
