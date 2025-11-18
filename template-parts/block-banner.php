 <?php $acf = $args['acf']; ?>
 <section class="section-banner bg-full" style="background-image: url(<?php echo $acf['image']; ?>);">
     <div class="section-banner__overlay"></div>
     <div class="section-banner__wrapper max-width">
         <div class="section-banner__texts">
             <h2 class="h2 section-banner__h2"><?php echo $acf['title']; ?></h2>
             <h3 class="p section-banner__p"><?php echo $acf['description']; ?></h3>
             <a href="<?php echo $acf['cta']['url']; ?>" target="<?php echo $acf['cta']['target']; ?>" class="button button--aqua section-banner__cta"><?php echo $acf['cta']['title']; ?></a>
         </div>
     </div>
 </section>