 <?php $service = $args['service'];
    $index = $args['index']; ?>

 <section class="service-cards <?php echo $index % 2 == 0 ? 'service-cards--reverse' : ''; ?>">
     <div class="service-cards__wrapper max-width">
         <div class="service-cards__texts">
             <h2 class="h3 service-cards__h2"><?php echo get_the_title($service->ID); ?></h2>
             <p class="p service-cards__p"><?php echo get_the_excerpt($service->ID); ?></p>
             <a href="<?php echo get_the_permalink($service->ID); ?>" class="button button--aqua service-cards__cta">Más información</a>
         </div>
         <figure class="service-cards__image">
             <img src="<?php echo get_the_post_thumbnail_url($service->ID); ?>" alt="<?php echo get_the_post_thumbnail_caption($service->ID); ?>">
         </figure>
     </div>
 </section>