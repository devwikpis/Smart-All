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

        <header id="masthead" class="header">
            <div class="header__container">
                <!-- Logo -->
                <div class="header__branding">
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    if ($custom_logo_id) {
                        echo '<div class="header__logo">';
                        the_custom_logo();
                        echo '</div>';
                    } else {
                        if (is_front_page() && is_home()) :
                    ?>
                            <h1 class="header__title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="header__title-link"><?php bloginfo('name'); ?></a></h1>
                    <?php
                        else :
                    ?>
                            <p class="header__title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="header__title-link"><?php bloginfo('name'); ?></a></p>
                    <?php
                        endif;
                        $starter_description = get_bloginfo('description', 'display');
                        if ($starter_description || is_customize_preview()) :
                    ?>
                            <p class="header__description"><?php echo $starter_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                    <?php endif;
                    } ?>
                </div><!-- .header__branding -->

                <!-- Mobile Menu Toggle -->
                <button class="header__toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="header__toggle-line"></span>
                    <span class="header__toggle-line"></span>
                    <span class="header__toggle-line"></span>
                    <span class="screen-reader-text"><?php esc_html_e('Menu', 'starter'); ?></span>
                </button>

                <!-- Navigation Menu -->
                <nav id="site-navigation" class="header__nav">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-1',
                            'menu_id'        => 'primary-menu',
                            'menu_class'     => 'header__menu',
                            'container'      => false,
                            'fallback_cb'    => false,
                        )
                    );
                    ?>
                </nav><!-- #site-navigation -->
            </div><!-- .header__container -->
        </header><!-- #masthead -->
        </aside>