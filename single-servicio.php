<?php

/**
 * Description: Página para las Paginas interdas de servicios 
 * 
 * @package starter_Theme
 */
get_header();
?>
<main class="main-single-service">
    <?php $info_service = get_field('info_service');
    if ($info_service) {

    ?>
        <section class="info-service">
            <div class="info-service__wrapper max-width">
                <div class="info-service__texts">
                    <h1 class="info-service__h1 p"><?php echo $info_service['title']; ?></h1>
                    <div class="content info-service__content"><?php echo $info_service['description']; ?></div>
                    <a href="<?php echo $info_service['cta']['url']; ?>" target="<?php echo $info_service['cta']['target']; ?>" class="button button--aqua"><?php echo $info_service['cta']['title']; ?></a>
                </div>
                <figure class="info-service__figure">
                    <?php echo process_image($info_service['featured_image']); ?>
                </figure>
            </div>
            <div class="info-service__slide max-width">
                <div class="swiper-service g-swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($info_service['gallery'] as $slide) { ?>
                            <div class="swiper-slide">
                                <figure class="info-service__slide--figure">
                                    <?php echo process_image($slide['image']); ?>
                                    <p class="p info-service__slide--p"><?php echo $slide['text']; ?></p>
                                </figure>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
    <?php }
    $benefits = get_field('benefits');
    if ($benefits) {
    ?>
        <section class="benefits bg-full" style="background-image: url(<?php echo $benefits['image']['url']; ?>);">
            <div class="benefits__overlay"></div>
            <div class="benefits__wrapper max-width">
                <div class="benefits__header">
                    <h2 class="h2 benefits__h2"><?php echo $benefits['title'] ?></h2>
                    <h3 class="p benefits__p"><?php echo $benefits['description'] ?></h3>
                </div>
                <ul class="benefits__list">
                    <?php foreach ($benefits['benefits'] as $index => $benefit) { ?>
                        <li class="benefits__item">
                            <span class="benefits__item--icon"><?php echo $benefit['icon'] ?></span>
                            <h4 class="h3 benefits__item--h3"><?php echo $benefit['title'] ?></h4>
                            <p class="p benefits__item--p"><?php echo $benefit['description'] ?></p>

                        </li>
                    <?php } ?>
                </ul>
            </div>
        </section>
    <?php }

    $info_banner = get_field('info_banner');
    if ($info_banner) {
    ?>
        <section class="info-banner ">

            <div class="info-banner__wrapper bg-full max-width" style="background-image: url(<?php echo $info_banner['image']['url']; ?>);">
                <div class="info-banner__overlay"></div>
                <div class="info-banner__texts">
                    <p class="p info-banner__p"><?php echo $info_banner['description'] ?></p>
                    <span class="p info-banner__span"><?php echo $info_banner['tag'] ?></span>
                </div>
            </div>

        </section>
        <div class="info-banner__content max-width content">
            <?php echo $info_banner['full_content'] ?>
        </div>
    <?php }
    get_template_part('template-parts/testimonials');
    $service_faqs = get_field('faqs')['faqs'];
    if ($service_faqs) {
        get_template_part('template-parts/block-faqs', null, ['acf' => $service_faqs]);
    }

    $contact_form = get_field('contact');
    if ($contact_form) {
    ?>
        <section class="contact-form">
            <div class="contact-form__wrapper max-width">
                <div class="contact-form__texts">
                    <div class="contact-form__header">
                        <h2 class="h2 contact-form__h2"><?php echo $contact_form['title'] ?></h2>
                        <p class="p contact-form__p"><?php echo $contact_form['description'] ?></p>
                    </div>
                    <div class="contact-form__content">
                        <?php echo do_shortcode($contact_form['shortcode']) ?>
                    </div>
                </div>
                <figure class="contact-form__figure">
                    <?php
                    if (is_numeric($contact_form['image'])) {
                        $image_id = $contact_form['image'];
                        $image = [
                            'url' => wp_get_attachment_image_url($image_id, 'full'),
                            'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true),
                            'title' => get_the_title($image_id)
                        ];
                    } else {
                        $image = $contact_form['image'];
                    }
                    echo process_image($image); ?>
                </figure>
            </div>
        </section>
    <?php }
    ?>
</main>

<?php get_footer(); ?>