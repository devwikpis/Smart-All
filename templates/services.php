<?php

/**
 * Template Name: Servicios
 * Description: Página de servicios personalizada para el sitio web
 * 
 * @package starter_Theme
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
    <?php }

    $steps = get_field('steps');
    if ($steps) {
    ?>
        <section class="steps bg-full" style="background-image: url(<?php echo $steps['image']['url']; ?>);">
            <div class="steps__overlay"></div>
            <div class="steps__wrapper max-width">
                <div class="steps__header">
                    <h2 class="h2 steps__h2"><?php echo $steps['title'] ?></h2>
                    <h3 class="p steps__p"><?php echo $steps['description'] ?></h3>
                </div>
                <ul class="steps__list">
                    <?php foreach ($steps['step'] as $index => $step) { ?>
                        <li class="steps__item">
                            <span class="steps__item--number">0<?php echo $index + 1 ?></span>
                            <h3 class="h3 steps__item--h3"><?php echo $step['title'] ?></h3>
                            <p class="p steps__item--p"><?php echo $step['description'] ?></p>

                        </li>
                    <?php } ?>
                </ul>
            </div>
        </section>
    <?php }

    $faqs = get_field('faqs');
    if ($faqs) {
        get_template_part('template-parts/block-faqs', null, ['acf' => $faqs]);
    }
    ?>
</main>
<?php get_footer();
