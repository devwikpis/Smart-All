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

    <section class="full-projects">
        <div class="full-projects__wrapper">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'post_type' => 'proyecto',
                'posts_per_page' => 3,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC'
            );

            $proyectos_query = new WP_Query($args);

            if ($proyectos_query->have_posts()) :
                $index = 0;
                while ($proyectos_query->have_posts()) : $proyectos_query->the_post();
                    $proyect = get_post();
                    get_template_part('template-parts/target/target-proyect', null, ['proyect' => $proyect, 'index' => $index]);
                    $index++;
                endwhile;
                if ($proyectos_query->max_num_pages > 1) : ?>
                    <div class="full-projects__pagination max-width">

                        <a href="<?php echo get_pagenum_link($paged - 1); ?>" class="full-projects__pagination-btn full-projects__pagination-btn--prev  <?php echo ($paged > 1) ? 'active' : 'disabled'; ?>">
                            <span><svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.8034 20.6248L0.981934 10.8034L10.8034 0.981933" stroke="#222322" stroke-width="1.96429" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Anterior</span>
                        </a>

                        <a href="<?php echo get_pagenum_link($paged + 1); ?>" class="full-projects__pagination-btn full-projects__pagination-btn--next <?php echo ($paged < $proyectos_query->max_num_pages) ? 'active' : 'disabled'; ?>">
                            <span>Siguiente <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.982282 20.6248L10.8037 10.8034L0.982283 0.981933" stroke="#222322" stroke-width="1.96429" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </a>

                    </div>
                <?php endif;

                wp_reset_postdata();
            else : ?>
                <p class="full-projects__no-results">No se encontraron proyectos.</p>
            <?php endif; ?>
        </div>
    </section>
    <?php $info_banner = get_field('info_banner_info_banner');
    if ($info_banner) {
        get_template_part('template-parts/block-banner', null, ['acf' => $info_banner]);
    } ?>
</main>
<?php get_footer();
