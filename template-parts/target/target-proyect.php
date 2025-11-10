 <?php $proyect = $args['proyect'];
    $index = $args['index'];
    $proyect_fields = get_field('page_info', $proyect->ID);
    ?>

 <section class="proyect-card <?php echo $index % 2 == 0 ? '' : 'proyect-card--reverse'; ?>">
     <div class="proyect-card__wrapper max-width">
         <div class="proyect-card__container">
             <div class="proyect-card__top">
                 <h2 class="h2 proyect-card__h2"><?php echo get_the_title($proyect->ID); ?></h2>
                 <h3 class="h3 proyect-card__h3"><?php echo $proyect_fields['sub_title']; ?></h3>
                 <div class="proyect-card__content content"><?php echo $proyect_fields['first_content']; ?></div>
             </div>
             <figure class="proyect-card__image">
                 <img src="<?php echo get_the_post_thumbnail_url($proyect->ID); ?>" alt="<?php echo get_the_post_thumbnail_caption($proyect->ID); ?>">
             </figure>
         </div>
         <div class="proyect-card__content content"><?php echo $proyect_fields['last_content']; ?></div>

     </div>
     <div class="proyect-card__gallery max-width">
         <div class="swiper-proyect g-swiper">
             <div class="swiper-wrapper">
                 <?php foreach ($proyect_fields['gallery'] as $slide) { ?>
                     <div class="swiper-slide">
                         <figure class="proyect-card__slide--figure">
                             <?php echo process_image($slide); ?>
                         </figure>
                     </div>
                 <?php } ?>
             </div>
             <div class="proyect-card__navigation">
                 <div class="swiper-button-prev"></div>
                 <div class="swiper-pagination"></div>
                 <div class="swiper-button-next"></div>
             </div>
         </div>
     </div>
 </section>