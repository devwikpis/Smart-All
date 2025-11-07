<?php

/**
 * La plantilla para mostrar el pie de página
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Wikpis
 */

$footer = get_field('footer', 'option');
?>
<footer class="footer">
    <section class="footer__wrapper max-width">
        <a href="" class="footer__logo">
            <?php echo process_image($footer['logo'], 'footer__logo-image'); ?>
        </a>
        <nav class="footer__nav">
            <?php
            wp_nav_menu([
                'theme_location' => 'menu_primary',
                'container'      => false,
                'menu_class'     => 'footer__nav-list',
                'menu_id'        => 'footer__nav-list',
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>'
            ]);

            ?>
        </nav>
        <ul class="footer__contact">
            <?php foreach ($footer['top_contact'] as $contact) { ?>
                <li class="footer__contact--li">
                    <a href="<?php echo $contact['url']; ?>" target="_blank"><span class="footer__contact--icon"><?php echo $contact['icon']; ?></span><span class="footer__contact--text"><?php echo $contact['name']; ?></span></a>
                </li>
            <?php } ?>
        </ul>
        <ul class="footer__socials">
            <?php foreach ($footer['socials'] as $social) { ?>
                <li class="footer__socials--li">
                    <a href="<?php echo $social['url']; ?>" target="_blank"><span class="footer__socials--icon"><?php echo $social['icon']; ?></span></a>
                </li>
            <?php } ?>
        </ul>
    </section>
</footer>
<?php wp_footer(); ?>
</body>

</html>