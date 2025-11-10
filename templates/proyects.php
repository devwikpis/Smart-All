<?php

/**
 * Template Name: Proyectos
 * Description: Página de proyectos personalizada para el sitio web
 * 
 * @package starter_Theme
 * @author Wikpis
 * @version 1.0.0
 */
get_header(); ?>
<main class="main-proyects">
    <?php foreach (get_field('first_proyects') as $index => $proyect) { ?>
        <?php get_template_part('template-parts/target/target-proyect', null, ['proyect' => $proyect, 'index' => $index]); ?>
    <?php }
    $info_banner = get_field('info_banner_info_banner');
    if ($info_banner) {
        get_template_part('template-parts/block-banner', null, ['acf' => $info_banner]);
    }
    foreach (get_field('last_proyects') as $index => $proyect) {
        $index = $index + 1; ?>
        <?php get_template_part('template-parts/target/target-proyect', null, ['proyect' => $proyect, 'index' => $index]); ?>
    <?php } ?>

</main>
<?php get_footer();
