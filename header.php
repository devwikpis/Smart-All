<?php

/**
 * Header template for displaying the site header
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package Starter_Theme
 * @version 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'starter'); ?></a>

        <!-- Menu Overlay -->
        <div class="menu-overlay"></div>

        <header class="header <?php echo is_front_page() ? 'header--home' : '' ?>">
            <section class="header__wrapper max-width">

                <?php echo get_custom_logo(); ?>

                <!-- Mobile Menu Toggle -->
                <button class="header__toggle" aria-label="Toggle menu" aria-expanded="false">
                    <span class="header__toggle-line"></span>
                    <span class="header__toggle-line"></span>
                    <span class="header__toggle-line"></span>
                </button>

                <nav class="header__nav header__nav--desktop">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'menu_primary',
                        'container'      => false,
                        'menu_class'     => 'header__nav-list',
                        'menu_id'        => 'header__nav-list',
                        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>'
                    ]);

                    ?>
                </nav>
                <?php $menu_locations = get_nav_menu_locations();
                $menu_id = isset($menu_locations['menu_primary']) ? $menu_locations['menu_primary'] : 0;

                if ($menu_id) {
                    $schedule = get_field('schedule', 'term_' . $menu_id);
                    if (!$schedule) {
                        $schedule = get_field('schedule', 'nav_menu_' . $menu_id);
                    }

                    if ($schedule && isset($schedule['url']) && isset($schedule['title'])) {
                        echo '<a href="' . esc_url($schedule['url']) . '" target="_blank" class="header__schedule button button--br-white">' . esc_html($schedule['title']) . '</a>';
                    }
                }
                ?>
            </section>

            <!-- Mobile Navigation -->
            <nav class="header__nav header__nav--mobile">
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu_primary',
                    'container'      => false,
                    'menu_class'     => 'header__nav-list',
                    'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>'
                ]);
                ?>
            </nav>
        </header>