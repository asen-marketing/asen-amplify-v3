<?php

$unique_id = '';

if (isset($args['unique_id'])) {
    $unique_id = $args['unique_id'];
} else {
    $unique_id = wp_generate_uuid4();
}

$testimonials = [];

$testimonials = get_field('testimonials');

$total_testimonials = count($testimonials);

?>

<?php if (count($testimonials) > 5 && count($testimonials) < 10) : ?>
<section class="asen-testimonial-carousel asen-testimonial-carousel-<?php echo $unique_id . ' ' . $extra_classes; ?>">
    <div class="star-container">
        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
    </div>
    <div class="inside">
        <div class="glide">
            <div data-glide-el="track" class="glide__track">
                <ul class="glide__slides">
                    <?php $color_toggle = true; ?>
                    <?php foreach ($testimonials as $index => $testimonial_item) : ?>
                    <li class="glide__slide" data-slide-id="<?php echo $index; ?>">
                        <?php 
                                    // Starting at the second slide (configured in Glide at bottom of template),
                                    // at each 3rd slide, toggle the class toggler to select an accent color.
                                    $slide_background_color = 'color1';
                                    if (($index + 2) % 3 == 0) {
                                        if ($color_toggle == true) {
                                            $slide_background_color = 'color2';
                                            $color_toggle = false;
                                        } else {
                                            $slide_background_color = 'color3';
                                            $color_toggle = true;
                                        }                        
                                    }
                                ?>
                        <div class="slide-content-container <?php echo $slide_background_color; ?>">
                            <div class="quote-mark-icon">
                                <svg id="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 512 374" style="" xml:space="preserve">
                                    <g>
                                        <path
                                            d="M207.8,3.3H15c-8.3,0-15,6.7-15,15v192.8c0,8.3,6.7,15,15,15h81.4v129.6c0,8.3,6.7,15,15,15h48.2c6.5,0,12.2-4.1,14.2-10.3
                                                    L222,215.8c0.5-1.5,0.8-3.1,0.8-4.7V18.3C222.8,10,216.1,3.3,207.8,3.3z" />
                                        <path
                                            d="M497,3.3H304.2c-8.3,0-15,6.7-15,15v192.8c0,8.3,6.7,15,15,15h81.4v129.6c0,8.3,6.7,15,15,15h48.2
                                                    c6.5,0,12.2-4.1,14.2-10.3l48.2-144.6c0.5-1.5,0.8-3.1,0.8-4.7V18.3C512,10,505.3,3.3,497,3.3z" />
                                    </g>
                                </svg>
                            </div>
                            <blockquote
                                class="<?php if ( get_field('profile_image', $testimonial_item) ) : echo 'has-headshot'; endif; ?>">
                                <h5><?php echo get_the_title($testimonial_item); ?></h5>
                                <p><?php the_field('testimonial_quote', $testimonial_item); ?></p>
                                <div class="attribution-content">

                                    <?php if ( get_field('testimonial_image', $testimonial_item) ) : ?>
                                    <div class="headshot">
                                        <?php echo wp_get_attachment_image( get_field('testimonial_image', $testimonial_item), 'thumbnail' ); ?>
                                    </div>
                                    <?php endif; ?>

                                    <div class="author-info">

                                        <?php if ( get_field('testimonial_author', $testimonial_item) ) : ?>
                                        <p class="author"><?php the_field('testimonial_author', $testimonial_item); ?>
                                        </p>
                                        <?php endif; ?>

                                        <?php if ( get_field('testimonial_company', $testimonial_item) ) : ?>
                                        <cite><?php the_field('testimonial_company', $testimonial_item); ?></cite>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </blockquote>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<style>
.asen-testimonial-carousel-<?php echo $unique_id . ' ';

?> {
    <?php $top_padding=get_field('top_padding');
    $bottom_padding=get_field('bottom_padding');
    $top_margin=get_field('top_margin');
    $bottom_margin=get_field('bottom_margin');

    if ($top_padding || $top_padding==0) {
        echo 'padding-top: '. $top_padding . 'px;';
        echo '@media (max-width: 1440px) {padding-top: '. $top_padding * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {padding-top: '. $top_padding * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {padding-top: '. $top_padding * 0.55 . 'px;}';
    }

    if ($bottom_padding || $bottom_padding==0) {
        echo 'padding-bottom: '. $bottom_padding . 'px;';
        echo '@media (max-width: 1440px) {padding-bottom: '. $bottom_padding * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {padding-bottom: '. $bottom_padding * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {padding-bottom: '. $bottom_padding * 0.55 . 'px;}';
    }

    if ($top_margin || $top_margin==0) {
        echo 'margin-top: '. $top_margin . 'px;';
        echo '@media (max-width: 1440px) {margin-top: '. $top_margin * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {margin-top: '. $top_margin * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {margin-top: '. $top_margin * 0.55 . 'px;}';
    }

    if ($bottom_margin || $bottom_margin==0) {
        echo 'margin-bottom: '. $bottom_margin . 'px;';
        echo '@media (max-width: 1440px) {margin-bottom: '. $bottom_margin * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {margin-bottom: '. $bottom_margin * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {margin-bottom: '. $bottom_margin * 0.55 . 'px;}';
    }

    ?>.glide__slide .slide-content-container.color1 {
        <?php if (isset(get_field('color1')['background_color'])) echo 'background-color: '. get_field('color1')['background_color'] . ';';

        ?>h5 {
            <?php if (isset(get_field('color1')['heading_color'])) echo 'color: '. get_field('color1')['heading_color'] . ';';
            ?>
        }

        p,
        p.author,
        cite {
            <?php if (isset(get_field('color1')['text_color'])) echo 'color: '. get_field('color1')['text_color'] . ';';
            ?>
        }

        .quote-mark-icon svg {
            <?php if (isset(get_field('color1')['quotation_icon_color'])) echo 'fill: '. get_field('color1')['quotation_icon_color'] . ';';
            ?>
        }
    }

    .glide__slide .slide-content-container.color2 {
        <?php if (isset(get_field('color2')['background_color'])) echo 'background-color: '. get_field('color2')['background_color'] . ';';

        ?>h5 {
            <?php if (isset(get_field('color2')['heading_color'])) echo 'color: '. get_field('color2')['heading_color'] . ';';
            ?>
        }

        p,
        p.author,
        cite {
            <?php if (isset(get_field('color2')['text_color'])) echo 'color: '. get_field('color2')['text_color'] . ';';
            ?>
        }

        .quote-mark-icon svg {
            <?php if (isset(get_field('color2')['quotation_icon_color'])) echo 'fill: '. get_field('color2')['quotation_icon_color'] . ';';
            ?>
        }
    }

    .glide__slide .slide-content-container.color3 {
        <?php if (isset(get_field('color3')['background_color'])) echo 'background-color: '. get_field('color3')['background_color'] . ';';

        ?>h5 {
            <?php if (isset(get_field('color3')['heading_color'])) echo 'color: '. get_field('color3')['heading_color'] . ';';
            ?>
        }

        p,
        p.author,
        cite {
            <?php if (isset(get_field('color3')['text_color'])) echo 'color: '. get_field('color3')['text_color'] . ';';
            ?>
        }

        .quote-mark-icon svg {
            <?php if (isset(get_field('color3')['quotation_icon_color'])) echo 'fill: '. get_field('color3')['quotation_icon_color'] . ';';
            ?>
        }
    }
}
</style>

<script defer>
(function($) {
    "use strict";

    var windowObject = $(window);
    var carouselContainer = $('.asen-testimonial-carousel-<?php echo $unique_id; ?>');
    var totalSlides = <?php echo $total_testimonials; ?>;
    var currentSlide = 0; // All is zero indexed.

    windowObject.on("load", function() {
        var glide = new Glide(".asen-testimonial-carousel-<?php echo $unique_id; ?> .glide", {
            type: "carousel",
            startAt: 1, // Pay close attention to the modifications below that make this work.
            autoplay: 5000,
            gap: 0,
            animationDuration: 1000,
            hoverpause: false,
            perView: 3,
            breakpoints: {
                900: {
                    perView: 2
                },
                670: {
                    perView: 1
                }
            }
        });

        glide.on('build.after', function(event) {
            carouselContainer.addClass('is-ready');
        });
        glide.on('run.before', function(event) {
            // carouselContainer.find('.glide__slide').removeClass('is-active');
            // console.log('run.before')
        });
        glide.on('run', function(event) {
            setTimeout(function() {
                advanceSlides(glide.index);
            }, 100);
            // advanceSlides(glide.index);
        });
        glide.on('mount.after', function(event) {
            advanceSlides(glide.index);
        });

        function advanceSlides(index = -1) {
            if (index >= 0) currentSlide = index - 1;
            let slide1 = (currentSlide) % totalSlides;
            if (slide1 < 0) slide1 = 8;
            let slide2 = (currentSlide + 1) % totalSlides;
            let slide3 = (currentSlide + 2) % totalSlides;
            // Because we're starting the zero indexed Glide at 1, we need to adjust indexes *and* 
            // adjust the index if the value is over the total.
            slide1 = slide1 + 1;
            if (slide1 > totalSlides - 1) slide1 = 0;
            slide2 = slide2 + 1;
            if (slide2 > totalSlides - 1) slide2 = 0;
            slide3 = slide3 + 1;
            if (slide3 > totalSlides - 1) slide3 = 0;
            carouselContainer.find('.glide__slide').removeClass('is-active');
            carouselContainer.find('.glide__slide[data-slide-id="' + slide1 + '"]').addClass('is-active');
            carouselContainer.find('.glide__slide[data-slide-id="' + slide2 + '"]').addClass('is-active');
            carouselContainer.find('.glide__slide[data-slide-id="' + slide3 + '"]').addClass('is-active');
        }

        glide.mount();

    }); // End window loaded.
})(jQuery);
</script>
<?php endif; ?>