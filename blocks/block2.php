<div class="main-container-swiper">
<div class="swiper-container main-swiper">
    <div class="swiper-wrapper">
        <?php
        $slide_index = 1; // Инициализация счетчика слайдов
        foreach ($slide_data as $slide): ?>
            <div class="swiper-slide">
                <h2><?php echo $slide_index . '. ' . esc_html($slide['title']); ?></h2> <!-- Вывод номера слайда и заголовка -->
                <div class="slide-description"><?php echo wp_kses_post($slide['description']); ?></div>
                <img src="<?php echo esc_url($slide['image']); ?>" alt="<?php echo esc_attr($slide['title']); ?>">
            </div>
        <?php
            $slide_index++;
        endforeach; ?>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
</div>
<script>
    jQuery(document).ready(function($) {
        var mySwiper = new Swiper('.swiper-container', {
            // Optional parameters
            loop: true,
            spaceBetween: 30, // Увеличиваем пространство между слайдами
            slidesPerView: 1, // Default number of slides per view (for mobile)

            // Responsive breakpoints
            breakpoints: {
                // when window width is >= 640px
                640: {
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            },

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
</script>
