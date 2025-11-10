<?php

/**
 * Description: Página para las Paginas interdas del starter
 * 
 * @package starter_Theme
 */
get_header();
?>
<main class="main-single max-width content">
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
</main>

<?php get_footer(); ?>