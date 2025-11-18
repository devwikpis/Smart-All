<?php
$testimonials = get_field('testimonials', 'option');
if ($testimonials) {
?>
    <section class="testimonials">
        <div class="testimonials__wrapper max-width">
            <div class="testimonials__texts">
                <div class="testimonials__texts--content">
                    <h2 class="h2 testimonials__h2"><?php echo $testimonials['title']; ?></h2>
                    <h3 class="p testimonials__p"><?php echo $testimonials['description']; ?></h3>
                    <div class="testimonials__inner-arrows">
                        <button class="testimonials__arrow testimonials__arrow--prev"><svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.8036 20.625L0.98214 10.8036L10.8036 0.982177" stroke="#222322" stroke-width="1.96429" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button class="testimonials__arrow testimonials__arrow--next">
                            <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.982145 20.625L10.8036 10.8036L0.982146 0.982177" stroke="#222322" stroke-width="1.96429" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
                <span class="testimonials__icon"><svg width="169" height="169" viewBox="0 0 169 169" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M143.009 124.694C133.13 135.404 118.18 140.833 98.5833 140.833H91.5417V120.983L97.2032 119.849C106.85 117.92 113.561 114.124 117.152 108.554C119.027 105.554 120.089 102.118 120.236 98.5833H98.5833C96.7158 98.5833 94.9247 97.8414 93.6041 96.5208C92.2836 95.2002 91.5417 93.4092 91.5417 91.5416V42.2499C91.5417 34.483 97.858 28.1666 105.625 28.1666H147.875C149.743 28.1666 151.534 28.9085 152.854 30.229C154.175 31.5496 154.917 33.3407 154.917 35.2083V70.4166L154.896 90.9712C154.959 91.7528 156.297 110.272 143.009 124.694ZM28.1667 28.1666H70.4167C72.2842 28.1666 74.0753 28.9085 75.3959 30.229C76.7164 31.5496 77.4583 33.3407 77.4583 35.2083V70.4166L77.4372 90.9712C77.5006 91.7528 78.8385 110.272 65.5509 124.694C55.6714 135.404 40.7219 140.833 21.125 140.833H14.0833V120.983L19.7448 119.849C29.3919 117.92 36.1026 114.124 39.6939 108.554C41.5683 105.554 42.6311 102.118 42.7781 98.5833H21.125C19.2574 98.5833 17.4663 97.8414 16.1458 96.5208C14.8252 95.2002 14.0833 93.4092 14.0833 91.5416V42.2499C14.0833 34.483 20.3997 28.1666 28.1667 28.1666Z" fill="#96DBE3" fill-opacity="0.27" />
                    </svg>
                </span>
            </div>
            <div class="swiper-testimonials g-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($testimonials['cards'] as $testimonial) { ?>
                        <div class="swiper-slide">
                            <div class="testimonials__card">
                                <div class="testimonials__card--top">
                                    <img class="testimonials__card--img" src="<?php echo $testimonial['image']['url']; ?>" alt="<?php echo $testimonial['image']['alt']; ?>">
                                    <div class="testimonials__card--texts">
                                        <h2 class="h3 testimonials__card--h3"><?php echo $testimonial['name']; ?></h2>
                                        <h3 class="p testimonials__card--p"><?php echo $testimonial['position']; ?></h3>
                                    </div>
                                </div>
                                <div class="testimonials__card--bottom">
                                    <p class="p testimonials__card--p"><?php echo $testimonial['description']; ?></p>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
<?php
}
?>