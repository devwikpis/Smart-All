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
                    <div class="info-service__slide">
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
                </div>
                <?php $type = $info_service['type_media'];
                if ($type == 'feature_image') { ?>
                    <figure class="info-service__figure">
                        <?php echo process_image($info_service['featured_image']); ?>
                    </figure>
                <?php } elseif ($type == 'video') { ?>
                    <div class="info-service__video">
                        <video class="info-service__video-player" src="<?php echo $info_service['video']; ?>"></video>
                        <button class="info-service__video-play" aria-label="Reproducir video">
                            <svg width="102" height="122" viewBox="0 0 102 122" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g filter="url(#filter0_d_511_5074)">
                                    <path d="M9.1001 105.399V16.1116C9.1001 10.55 15.2733 7.20949 19.9291 10.2517L89.0296 55.4037C93.2839 58.1835 93.2514 64.4275 88.9686 67.163L19.8681 111.298C15.2085 114.274 9.1001 110.928 9.1001 105.399Z" fill="white" fill-opacity="0.84" shape-rendering="crispEdges" />
                                </g>
                                <defs>
                                    <filter id="filter0_d_511_5074" x="9.72748e-05" y="-0.000391006" width="101.301" height="121.511" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                        <feOffset />
                                        <feGaussianBlur stdDeviation="4.55" />
                                        <feComposite in2="hardAlpha" operator="out" />
                                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 1 0" />
                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_511_5074" />
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_511_5074" result="shape" />
                                    </filter>
                                </defs>
                            </svg>
                        </button>
                    </div>
                <?php } ?>
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