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
    $services = get_field('services');
    if ($services) {
    ?>
        <section class="services">
            <div class="services__wrapper max-width">
                <div class="services__texts">
                    <h2 class="h2 services__h2"><?php echo $services['title']; ?></h2>
                    <p class="p services__p"><?php echo $services['description']; ?></p>
                </div>
                <div class="swiper-services g-swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($services['cards'] as $service) { ?>
                            <div class="swiper-slide">
                                <div class="services__card">
                                    <span class="services__icon">
                                        <?php echo $service['icon']; ?>
                                    </span>
                                    <h3 class="h3 services__h3"><?php echo $service['title']; ?></h3>
                                    <p class="p services__p"><?php echo $service['description']; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <a href="<?php echo $services['cta']['url']; ?>" target="<?php echo $services['cta']['target']; ?>" class="button button--aqua services__cta"><?php echo $services['cta']['title']; ?></a>
            </div>
        </section>
    <?php
    }
    $about = get_field('about');
    if ($about) {
    ?>
        <section class="about">
            <div class="about__wrapper max-width">
                <div class="about__content">
                    <div class="about__texts">
                        <h2 class="h2 about__h2"><?php echo $about['title']; ?></h2>
                        <p class="p about__p"><?php echo $about['description']; ?></p>
                    </div>
                    <ul class="about__list">
                        <?php foreach ($about['blocks'] as $index => $card) { ?>
                            <li class="about__item">
                                <div class="about__card">
                                    <span class="about__card--number">
                                        0<?php echo $index + 1; ?>
                                    </span>
                                    <div class="about__card--texts">
                                        <h3 class="h3 about__card--h3"><?php echo $card['title']; ?></h3>
                                        <p class="p about__card--p"><?php echo $card['description']; ?></p>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                    <a href="<?php echo $about['cta']['url']; ?>" target="<?php echo $about['cta']['target']; ?>" class="button button--aqua about__cta"><?php echo $about['cta']['title']; ?></a>
                </div>
                <div class="about__image">
                    <img class="about__image--lines about__image--lines--top" src="<?php echo get_template_directory_uri(); ?>/assets/lines-top.svg" alt="Lines">
                    <img class="about__image--img" src="<?php echo $about['image']['url']; ?>" alt="<?php echo $about['image']['alt']; ?>">
                    <img class="about__image--lines about__image--lines--bottom" src="<?php echo get_template_directory_uri(); ?>/assets/lines-bottom.svg" alt="Lines">
                </div>
            </div>
        </section>
    <?php
    }
    $proyects = get_field('success_stories');
    if ($proyects) {
    ?>
        <section class="proyects">
            <div class="proyects__wrapper max-width">
                <div class="proyects__texts">
                    <h2 class="h2 proyects__h2"><?php echo $proyects['title']; ?></h2>
                    <p class="p proyects__p"><?php echo $proyects['description']; ?></p>
                </div>
                <div class="swiper-proyects g-swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($proyects['proyects'] as $proyect) { ?>
                            <div class="swiper-slide">
                                <div class="proyects__card">
                                    <figure class="proyects__card--figure">
                                        <img class="proyects__card--img" src="<?php echo get_the_post_thumbnail_url($proyect->ID); ?>" alt="<?php echo get_the_post_thumbnail_caption($proyect->ID); ?>">
                                        <?php
                                        $term = get_the_terms($proyect->ID, 'tipo-de-proyecto')[0];
                                        $color_tag = get_field('color_tag', $term);
                                        ?>
                                        <span class="proyects__card--taxonomy" style="<?php echo $color_tag ? 'background-color: ' . $color_tag . ';' : ''; ?>"><?php echo $term->name; ?></span>
                                    </figure>
                                    <div class="proyects__card--texts">
                                        <h3 class="h3 proyects__card--h3"><?php echo get_the_title($proyect->ID); ?></h3>
                                        <p class="p proyects__card--p"><?php echo get_the_excerpt($proyect->ID); ?></p>
                                        <a href="<?php echo get_permalink($proyect->ID); ?>" class="button button--aqua proyects__card--cta">Conocer más</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
    <?php
    }
    ?>
    <?php get_template_part('template-parts/testimonials');
    $info_banner = get_field('info_banner');
    if ($info_banner) {
        get_template_part('template-parts/block-banner', null, ['acf' => $info_banner]);
    }
    $suppliers = get_field('suppliers');
    if ($suppliers) {
    ?>
        <section class="suppliers">
            <div class="suppliers__wrapper max-width">
                <div class="suppliers__texts">
                    <h2 class="h2 suppliers__h2"><?php echo $suppliers['title']; ?></h2>
                    <p class="p suppliers__p"><?php echo $suppliers['description']; ?></p>
                </div>
                <div class="swiper-suppliers g-swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($suppliers['supplier'] as $supplier) { ?>
                            <div class="swiper-slide">
                                <a href="<?php echo $supplier['url']; ?>" target="_blank" class="suppliers__card">
                                    <img class="suppliers__card--img" src="<?php echo $supplier['icon']['url']; ?>" alt="<?php echo $supplier['icon']['alt']; ?>">
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
    <?php
    }
    ?>
</main>
<?php get_footer();
