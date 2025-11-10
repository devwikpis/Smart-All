<?php

/**
 * Template Name: Contacto
 * Description: Página de contacto personalizada para el sitio web
 * 
 * @package starter_Theme
 * @author Wikpis
 * @version 1.0.0
 */
get_header();
$contact = get_field('contact');
?>
<main class="main-contact">
    <section class="full-contact">
        <div class="full-contact__wrapper max-width">
            <div class="full-contact__left">
                <h1 class="h2 full-contact__h1"><?php echo $contact['title']; ?></h1>
                <p class="p full-contact__p"><?php echo $contact['description']; ?></p>

                <div class="form">
                    <?php echo do_shortcode($contact['shortcode']); ?>
                </div>
            </div>

            <div class="full-contact__right">
                <h2 class="h2 full-contact__h2"><?php echo $contact['title_2']; ?></h2>
                <p class="p full-contact__p"><?php echo $contact['description_2']; ?></p>

                <ul class="full-contact__list">
                    <?php foreach ($contact['cards_of_contact'] as $item) { ?>
                        <li class="full-contact__item">
                            <span class="full-contact__item--icon"><?php echo $item['icon']; ?></span>
                            <div class="full-contact__item--info">
                                <a href="<?php echo $item['cta']; ?>" target="_blank" class="full-contact__item--cta" aria-label="<?php echo $item['title']; ?>">
                                    <span class="full-contact__item--title"><?php echo $item['title']; ?></span>
                                    <span class="full-contact__item--subtitle"><?php echo $item['text']; ?></span>
                                </a>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
                <?php $info_banner = $contact['info_banner'];
                if ($info_banner) {
                    get_template_part('template-parts/block-banner', null, ['acf' => $info_banner]);
                } ?>
            </div>
    </section>

</main>

<?php get_footer();
