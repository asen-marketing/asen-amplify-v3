<?php
/**
 * Block Name: Asen Services Hub
 *
 * Displays services CPT as a grid or carousel.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$services = get_field('services');
$carousel = get_field('use_carousel');
?>

<section class="asen-services-hub asen-services-hub-<?php echo $block['id']; echo $className; ?>">
    <div class="inside<?php echo $carousel ? ' carousel' : ' grid'; ?>">
        <?php if ($services) : ?>
        <?php if ($carousel) : ?>
        <div class="glide glide-<?php echo $block['id']; ?>">
            <div class="controls" data-glide-el="controls">
                <button class="next" data-glide-dir="&#x0003E;" title="Show next slide"
                    aria-controls="carousel-<?php echo $block['id']; ?>"><i
                        class="fa-regular fa-angle-right"></i></button>
                <button class="previous" data-glide-dir="<" title="Show previous slide"
                    aria-controls="carousel-<?php echo $block['id']; ?>"><i class="fa-light fa-angle-left"></i></button>
            </div>
            <div data-glide-el="track" class="glide__track" id="carousel-<?php echo $block['id']; ?>">
                <ul class="glide__slides">
                    <?php endif; ?>
                    <?php foreach( $services as $index => $service ): 
                $name = get_the_title( $service->ID );
                $use_icon = get_field('use_icon', $service->ID);
                $image = get_field( 'service_image', $service->ID );
                $icon = get_field('icon_code', $service->ID);
                $blurb = get_field('service_blurb', $service->ID);
                $link = get_field('service_link', $service->ID);
                ?>
                    <li class="<?php echo $carousel ? 'glide__slide ' : ''; ?> service-item<?php echo ($index == 1 ? ' is-active' : ''); ?>"
                        data-slide-id="<?php echo $index - 1; ?>">
                        <?php if (!$use_icon && $image) : ?>
                        <?php echo wp_get_attachment_image($image, 'full'); ?>
                        <?php elseif ($use_icon) : ?>
                        <?php echo $icon; ?>
                        <?php endif; ?>
                        <h3><?php echo $name; ?></h3>
                        <p><?php echo $blurb; ?></p>
                        <?php if ($link) : ?>
                        <a class="service-link" href="<?php echo $link['url']; ?>" title="<?php echo $link['title']; ?>"
                            target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?>
                            <?php echo get_field('link_icon_code'); ?></a>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ($carousel) : ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
.asen-services-hub-<?php echo $block['id'] . ' ';
?>.inside .service-item,
.asen-services-hub-<?php echo $block['id'] . ' ';

?>.inside .glide__slide {
    width: calc(100% / <?php echo get_field('number_of_columns'); ?> + (2rem / <?php echo get_field('number_of_columns'); ?>) - 2rem);
    background-color: <?php echo get_field('service_background_color');
    ?>;

    p,
    h3,
    h4 {

        color: <?php echo get_field('service_text_color');
        ?>;
    }

    i {
        color: <?php echo get_field('service_icon_color');
        ?>;
    }

    a,
    a>i {
        color: <?php echo get_field('service_link_color');
        ?>;
    }

    a:hover {
        color: <?php echo get_field('service_link_hover_color');
        ?>;

        i {
            color: <?php echo get_field('service_link_hover_color');
            ?>;
        }
    }
}

@media (max-width: 1024px) {

    .asen-services-hub-<?php echo $block['id'] . ' ';
    ?>.inside .service-item,
    .asen-services-hub-<?php echo $block['id'] . ' ';

    ?>.inside .glide__slide {
        width: calc(100% / <?php echo round(get_field('number_of_columns') / 2); ?> + (2rem / <?php echo round(get_field('number_of_columns') / 2); ?>) - 2rem);

    }
}

@media (max-width: 640px) {
    .asen-services-hub-<?php echo $block['id'] . ' ';
    ?>.inside .service-item,
    .asen-services-hub-<?php echo $block['id'] . ' ';

    ?>.inside .glide__slide {
        width: 100%;
    }
}
</style>

<?php if ($carousel && !is_admin()) : ?>
<script defer>
(function($) {
    "use strict";
    var windowObject = $(window),
        carouselContainer = $('.asen-service-grid-<?php echo $block['id']; ?>');

    $(document).ready(function() {
        var glide = new Glide(".glide-<?php echo $block['id']; ?>", {
            type: "carousel",
            perView: <?php echo get_field('number_of_columns') ? get_field('number_of_columns') : 3; ?>,
            autoplay: 5000,
            hoverpause: true,
            gap: 20,
            rewind: true,
            breakpoints: {
                1024: {
                    perView: <?php echo get_field('number_of_columns') ? round(get_field('number_of_columns') / 2) : 2; ?>,
                    gap: 30,
                },
                640: {
                    perView: 1
                },
            },
        });

        glide.on('build.after', function(event) {
            carouselContainer.addClass('is-ready');
            carouselContainer.find('.glide__slide').removeClass('second');
            carouselContainer.find('.glide__slide').removeClass('third');
            carouselContainer.find('.glide__slide.is-active').next().addClass('second');
            carouselContainer.find('.glide__slide.is-active').next().next().addClass('third');
        });

        glide.on('run.before', function(event) {
            carouselContainer.find('.glide__slide').removeClass('is-active');
        });

        glide.on('run', function(event) {
            let newActive = carouselContainer.find('.glide__slide[data-slide-id="' + glide.index +
                '"]');
            carouselContainer.find('.glide__slide').removeClass('second');
            carouselContainer.find('.glide__slide').removeClass('third');
            newActive.next().addClass('second');
            newActive.next().next().addClass('third');
            newActive.removeClass('is-previous').addClass('is-active');
        });

        glide.mount();
    }); // End window loaded.
})(jQuery);
</script>
<?php endif; ?>