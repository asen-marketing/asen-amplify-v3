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
$nav_rows = get_field('nav_arrow_icons');
$prev_icon = $nav_rows[0]['previous_button_icon'];
$next_icon = $nav_rows[0]['next_button_icon'];
$nav_color = $nav_rows[0]['nav_arrow_color'];
$colors = get_field('service_colors');
$bg_colors = [];
$text_colors = [];
$link_colors = [];
$link_hover_colors = [];
$button_colors = [];
$button_hover_colors = [];
$total_colors = 1;

foreach ($colors as $index => $color_row) {
    if ($color_row['bg_color']) {
        array_push($bg_colors, $color_row['bg_color']);
    }
    if ($color_row['text_color']) {
    array_push($text_colors, $color_row['text_color']);
    }
    if ($color_row['link_color']) {
    array_push($link_colors, $color_row['link_color']);
    }
    if ($color_row['link_hover_color']) {
    array_push($link_hover_colors, $color_row['link_hover_color']);
    }
    if ($color_row['button_color']) {
        array_push($button_colors, $color_row['button_color']);
        }
    if ($color_row['button_hover_color']) {
        array_push($button_hover_colors, $color_row['button_hover_color']);
        }
    $total_colors++;
}

?>

<section
    class="asen-services-hub asen-services-hub-<?php echo $block['id']; echo $className; ?><?php if (get_field('has_background')) echo ' has-background'; ?>">

    <?php if (get_field('has_background')) : ?>
    <div class="heading-container">
        <h2 class="services-heading"><?php echo get_field('services_heading'); ?></h2>
        <p class="services-subheading"><?php echo get_field('services_subheading'); ?></p>
    </div>
    <?php endif; ?>

    <div class="inside<?php echo $carousel ? ' carousel' : ' grid'; ?>">
        <?php if ($services) : ?>
        <?php if ($carousel) : ?>
        <div class="controls" data-glide-el="controls">
            <button class="previous" data-glide-dir="<" title="Show previous slide"
                aria-controls="carousel-<?php echo $block['id']; ?>"><?php echo $prev_icon; ?></button>
            <button class="next" data-glide-dir="&#x0003E;" title="Show next slide"
                aria-controls="carousel-<?php echo $block['id']; ?>"><?php echo $next_icon; ?></button>
        </div>
        <div class="glide glide-<?php echo $block['id']; ?>">
            <div data-glide-el="track" class="glide__track" id="carousel-<?php echo $block['id']; ?>">
                <ul class="glide__slides">
                    <?php endif; ?>
                    <?php foreach( $services as $index => $service ): 
                $name = get_the_title( $service->ID );
                $use_icon = get_field('media_options', $service->ID) === 'icon';
                $image = get_field( 'service_image', $service->ID );
                $icon = get_field('icon_code', $service->ID);
                $blurb = get_field('service_blurb', $service->ID);
                $link = get_permalink($service->ID);
                $color = ($index + 1) % $total_colors;
                if ($color === 0) $color = 1;
                
                    ?>
                    <li class="<?php echo $carousel ? 'glide__slide ' : ''; ?> service-item<?php echo ($index == 1 ? ' is-active' : ''); ?><?php if (!$use_icon && $image) echo ' has-image'; ?><?php echo ' color-' . $color;?>"
                        data-slide-id="<?php echo $index - 1; ?>">
                        <?php if (!$use_icon && $image) : ?>
                        <?php echo wp_get_attachment_image($image, 'full'); ?>
                        <?php elseif ($use_icon) : ?>
                        <?php echo $icon; ?>
                        <?php endif; ?>
                        <div class="copy-container">
                            <h3 class="service-title"><?php echo $name; ?></h3>
                            <p class="service-blurb"><?php echo $blurb; ?></p>
                            <?php if ($link && get_field('tier_3', 'option') && get_field('link_style') !== 'none') : ?>
                            <?php 
                                $link_text = get_field('link_text');
                                $style = get_field('link_style');
                                ?>

                            <a class="service-link <?php echo $style; ?>" href="<?php echo $link; ?>"
                                title="<?php echo $link_text; ?>"><?php echo $link_text; if ($style === 'icon') echo get_field('link_icon_code'); ?></a>
                            <?php endif; ?>
                        </div>
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
.asen-services-hub-<?php echo $block['id'];

?>.has-background::after {
    background-color: <?php echo get_field('background_color');
    ?>;
}

.asen-services-hub-<?php echo $block['id'];

?>.has-background .heading-container {
    h2 {
        color: <?php the_field('services_heading_color');
        ?>;
    }

    p {
        color: <?php the_field('services_subheading_color');
        ?>;
    }
}

.asen-services-hub-<?php echo $block['id'] . ' ';

?>.controls {
    button {
        border: 3px solid <?php echo $nav_color;
        ?>;
    }

    i {
        color: <?php echo $nav_color;
        ?>;
    }
}

.asen-services-hub-<?php echo $block['id'] . ' ';
?>.inside .service-item,
.asen-services-hub-<?php echo $block['id'] . ' ';

?>.inside .glide__slide {
    width: calc(100% / <?php echo get_field('number_of_columns'); ?> + (2rem / <?php echo get_field('number_of_columns'); ?>) - 2rem);


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

.asen-services-hub-<?php echo $block['id'] . ' ';

?> {
    .service-item.color-1 {
        background-color: <?php echo $bg_colors[0];
        ?>;
        color: <?php echo $text_colors[0];
        ?>;

        h3 {
            color: <?php echo $text_colors[0];
            ?>;
        }

        a,
        a>i {
            color: <?php echo $link_colors[0];
            ?>;
        }

        a:hover,
        a:hover>i {
            color: <?php echo $link_hover_colors[0];
            ?>;
        }

        a.button {
            background-color: <?php echo $button_colors[0];
            ?>;
        }

        a.button:hover {
            background-color: <?php echo $button_hover_colors[0];
            ?>;
        }
    }

    .service-item.color-2 {
        background-color: <?php echo $bg_colors[1];
        ?>;
        color: <?php echo $text_colors[1];
        ?>;

        h3 {
            color: <?php echo $text_colors[1];
            ?>;
        }

        a,
        a>i {
            color: <?php echo $link_colors[1];
            ?>;
        }

        a:hover,
        a:hover>i {
            color: <?php echo $link_hover_colors[1];
            ?>;
        }

        a.button {
            background-color: <?php echo $button_colors[1];
            ?>;
        }

        a.button:hover {
            background-color: <?php echo $button_hover_colors[1];
            ?>;
        }
    }

    .service-item.color-3 {
        background-color: <?php echo $bg_colors[2];
        ?>;
        color: <?php echo $text_colors[2];
        ?>;

        h3 {
            color: <?php echo $text_colors[2];
            ?>;
        }

        a,
        a>i {
            color: <?php echo $link_colors[2];
            ?>;
        }

        a:hover,
        a:hover>i {
            color: <?php echo $link_hover_colors[2];
            ?>;
        }

        a.button {
            background-color: <?php echo $button_colors[2];
            ?>;
        }

        a.button:hover {
            background-color: <?php echo $button_hover_colors[2];
            ?>;
        }
    }
}
</style>

<?php if ($carousel && !is_admin()) : ?>
<script defer>
(function($) {
    "use strict";
    var windowObject = $(window),
        carouselContainer = $('.asen-services-hub-<?php echo $block['id']; ?>'),
        prevButton = carouselContainer.find('.controls > .previous'),
        nextButton = carouselContainer.find('.controls > .next')

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

        prevButton.on('click', function() {
            glide.go('<')
        })
        nextButton.on('click', function() {
            glide.go('>')
        })

        glide.mount();
    }); // End window loaded.
})(jQuery);
</script>
<?php endif; ?>