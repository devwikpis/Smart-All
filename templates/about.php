<?php

/**
 * Template Name: Nosotros
 * Description: Página de nosotros personalizada para el sitio web
 * 
 * @package starter_Theme
 * @author Wikpis
 * @version 1.0.0
 */
get_header(); ?>
<main class="main-about">
    <?php $about = get_field('top_info');

    if ($about) { ?>
        <section class="about-top">
            <div class="about-top__wrapper max-width">
                <div class="about-top__header">
                    <h1 class="h2 about-top__h2"><?php echo $about['title']; ?></h1>
                    <p class="p about-top__p"><?php echo $about['description']; ?></p>
                </div>
                <div class="about-top__content">
                    <figure class="about-top__figure">
                        <?php echo process_image($about['image']); ?>
                    </figure>
                    <div class="about-top__texts">
                        <div class="content">
                            <?php echo $about['history']; ?>
                        </div>
                        <a href="<?php echo $about['cta']['url']; ?>" target="<?php echo $about['cta']['target']; ?>" class="about-top__cta button button--aqua"><?php echo $about['cta']['title']; ?></a>
                    </div>
                </div>
            </div>
        </section>
    <?php }
    $timeline = get_field('time_line');
    if ($timeline) { ?>
        <section class="timeline">
            <div class="timeline__wrapper max-width">
                <div class="timeline__header">
                    <h2 class="h2 timeline__h2"><?php echo $timeline['title']; ?></h2>
                    <p class="p timeline__p"><?php echo $timeline['description']; ?></p>
                </div>

                <ul class="timeline__list">
                    <?php foreach ($timeline['date'] as $index => $item) { ?>
                        <li class="timeline__item <?php echo $index % 2 == 0 ? 'timeline__item--left' : 'timeline__item--right'; ?>"
                            data-aos="<?php echo $index % 2 == 0 ? 'fade-left' : 'fade-right'; ?>">
                            <div class="timeline__content">
                                <span class="timeline__span h2"><?php echo $item['year']; ?></span>
                                <h3 class="h3 timeline__h3"><?php echo $item['title']; ?></h3>
                                <p class="p timeline__p"><?php echo $item['description']; ?></p>

                            </div>
                        </li>
                        <li></li>
                    <?php } ?>
                </ul>
            </div>
        </section>
    <?php }

    $values = get_field('values');
    if ($values) { ?>
        <section class="values">
            <div class="values__wrapper max-width">
                <div class="values__texts">
                    <h2 class="h2 values__h2"><?php echo $values['title']; ?></h2>
                    <p class="p values__p"><?php echo $values['description']; ?></p>
                </div>
                <div class="swiper-values g-swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($values['cards'] as $value) { ?>
                            <div class="swiper-slide">
                                <div class="values__card">
                                    <span class="values__icon">
                                        <?php echo $value['icon']; ?>
                                    </span>
                                    <h3 class="h3 values__h3"><?php echo $value['title']; ?></h3>
                                    <p class="p values__p"><?php echo $value['description']; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
    <?php }

    $team = get_field('team');
    if ($team) { ?>
        <section class="team">
            <div class="team__wrapper max-width">
                <div class="team__header">
                    <h2 class="h2 team__h2"><?php echo $team['title']; ?></h2>
                    <p class="p team__p"><?php echo $team['description']; ?></p>
                </div>
                <div class="swiper-team g-swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($team['members'] as $member) { ?>
                            <div class="swiper-slide">
                                <div class="team__card">
                                    <figure class="team__figure">
                                        <?php echo process_image($member['image']); ?>
                                    </figure>
                                    <div class="team__texts">
                                        <h3 class="h3 team__h3"><?php echo $member['title']; ?></h3>
                                        <span class="team__span"><?php echo $member['ocupation']; ?></span>
                                        <p class="p team__texts--p"><?php echo $member['description']; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
    <?php }
    $info_banner = get_field('info_banner')['info_banner'];
    if ($info_banner) {
        get_template_part('template-parts/block-banner', null, ['acf' => $info_banner]);
    } ?>
</main>

<?php get_footer();
