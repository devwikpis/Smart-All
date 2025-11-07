<?php

/**
 * Template Name: Servicios
 * Description: Página de servicios personalizada para el sitio del Tecnológico de Antioquia
 * 
 * @package TdeA_Theme
 * @author Wikpis
 * @version 1.0.0
 */
get_header(); ?>
<main class="main-services">
    <section class="services">
        <div class="services__wrapper max-width">
            <h1 class="h2 services__h1"><?php echo get_field('title') ?></h1>
            <p class="p services__p"><?php echo get_field('description') ?></p>
        </div>
    </section>
    <?php foreach (get_field('services') as $index => $service) { ?>
        <?php get_template_part('template-parts/target/target-service', null, ['service' => $service, 'index' => $index]); ?>
    <?php }
    $info_banner = get_field('info_banner');
    if ($info_banner) {
        get_template_part('template-parts/block-banner', null, ['acf' => $info_banner]);
    }
    foreach (get_field('services_two') as $index => $service) {
        $index = $index + 1; ?>
        <?php get_template_part('template-parts/target/target-service', null, ['service' => $service, 'index' => $index]); ?>
    <?php } ?>
</main>
<?php get_footer();
