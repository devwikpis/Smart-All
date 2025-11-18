 <?php $acf = $args['acf']; ?>

 <section class="faqs">
     <div class="faqs__wrapper max-width">
         <div class="faqs__header">
             <h2 class="h2 faqs__h2"><?php echo $acf['title']; ?></h2>
             <p class="p faqs__p"><?php echo $acf['description']; ?></p>
         </div>
         <div class="faqs__list">
             <?php foreach ($acf['faqs'] as $index => $faq) { ?>
                 <details class="faqs__item">
                     <summary class="faqs__item--summary">
                         <h2 class="h3 faqs__item--h3"><?php echo $faq['ask']; ?></h2>
                         <span class="faqs__item--span">
                             <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M0.5 0.500001L5.5 5.5L10.5 0.5" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                             </svg>

                         </span>
                     </summary>
                     <div class="faqs__item--content content">
                         <?php echo $faq['answer']; ?>
                     </div>
                 </details>
             <?php } ?>
         </div>
     </div>
 </section>