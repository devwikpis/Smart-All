<?php

/**
 * Template Name: Front Page
 * Description: Página de inicio personalizada para el sitio del Tecnológico de Antioquia
 * 
 * @package TdeA_Theme
 * @author Wikpis
 * @version 1.0.0
 */
get_header(); ?>
<main class="main main-front-page">
    <?php
    $banner = get_field('hero');
    if ($banner) {
    ?>
        <section class="banner bg-full" style="background-image: url(<?php echo $banner['image']['url']; ?>);">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/banner-bars.svg" alt="Lineas de color">
            <div class="banner__wrapper max-width">
                <div class="banner__texts">
                    <h1 class="h1 banner__h1"><?php echo $banner['title']; ?></h1>
                    <p class="p banner__p"><?php echo $banner['description']; ?></p>
                    <a href="<?php echo $banner['cta']['url']; ?>" target="<?php echo $banner['cta']['target']; ?>" class="button button--aqua banner__cta"><?php echo $banner['cta']['title']; ?></a>
                </div>
            </div>
        </section>
    <?php
    }
    ?>
</main>
<?php get_footer();
