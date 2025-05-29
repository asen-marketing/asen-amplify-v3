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
$image_icon = get_field('display_options');
$alternating = get_field('alternating_grid');
$nav_rows = get_field('nav_arrow_icons');

if (is_array($nav_rows)) {
$prev_icon = $nav_rows[0]['previous_button_icon'];
$next_icon = $nav_rows[0]['next_button_icon'];
$nav_color = $nav_rows[0]['nav_arrow_color'];
}

$colors = get_field('service_colors');
$bg_colors = [];
$text_colors = [];
$link_colors = [];
$link_hover_colors = [];
$button_colors = [];
$button_hover_colors = [];
$service_icon_colors = [];
$total_colors = 1;

if (is_array($colors)) {
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
        if ($color_row['service_icon_color']) {
            array_push($service_icon_colors, $color_row['service_icon_color']);
        }
        $total_colors++;
    }
}

if ($alternating) {
    $alternating_styles = get_field('alternating_styles');
}
if (isset($alternating_styles) && is_array($alternating_styles)) {
    $alt_color = $alternating_styles[0]['text_color'];
    $alt_heading_size = $alternating_styles[0]['heading_font_size'];
    $alt_copy_size = $alternating_styles[0]['copy_font_size'];
}
?>

<section
    class="asen-services-hub asen-services-hub-<?php echo $block['id']; echo $className; ?><?php if (get_field('has_background')) echo ' has-background'; ?><?php echo ' ' . $image_icon; ?><?php if ($alternating) echo ' alternating'; ?><?php if ($carousel) echo ' carousel'; if (!$carousel && !$alternating) echo ' grid' ?>"
    id="<?php echo $block['anchor']; ?>">
    <?php if (get_field('has_background')) : ?>
    <div class="heading-container"
        style="<?php if (get_field('block_max_width')) echo 'max-width: ' . (get_field('block_max_width') - 200) . 'px;'; ?>">
        <h2 class="services-heading"><?php echo get_field('services_heading'); ?></h2>
        <p class="services-subheading"><?php echo get_field('services_subheading'); ?></p>
    </div>
    <?php endif; ?>

    <div class="inside<?php if ($carousel) echo ' carousel'; if (!$carousel && !$alternating) echo ' grid' ?><?php if ($alternating && $image_icon === 'image') echo ' alternating'; ?>"
        style="<?php echo 'max-width: ' . get_field('block_max_width') . 'px;'; ?>">
        <?php if ($services) : ?>
        <?php if ($carousel) : ?>
        <div class="controls" data-glide-el="controls">
            <button class="previous" data-glide-dir="<" title="Show previous slide"
                aria-controls="carousel-<?php echo $block['id']; ?>"><?php echo $prev_icon ? $prev_icon : '<i class="fa-regular fa-circle-chevron-left"></i>'; ?></button>
            <button class="next" data-glide-dir="&#x0003E;" title="Show next slide"
                aria-controls="carousel-<?php echo $block['id']; ?>"><?php echo $next_icon ? $next_icon : '<i class="fa-regular fa-circle-chevron-right"></i>'; ?></button>
        </div>
        <div class="glide glide-<?php echo $block['id']; ?>"
            style="<?php if (get_field('block_max_width')) echo 'max-width: ' . (get_field('block_max_width') - 200) . 'px;'; ?>">
            <div data-glide-el="track" class="glide__track" id="carousel-<?php echo $block['id']; ?>">
                <ul class="glide__slides">
                    <?php endif; ?>
                    <?php foreach( $services as $index => $service ): 
                $name = get_the_title( $service->ID );
                $image = get_field( 'service_image', $service->ID );
                $icon = get_field('icon_code', $service->ID);
                $blurb = get_field('service_blurb', $service->ID);
                $link = get_permalink($service->ID);
                $color = ($index + 1) % $total_colors;
                if ($color === 0) $color = 1;
                
                    ?>
                    <li class="<?php echo $carousel ? 'glide__slide ' : ''; ?> service-item<?php echo ($index == 1 ? ' is-active' : ''); ?><?php if ($image_icon === 'image' && $image) echo ' has-image'; ?><?php echo ' color-' . $color;?><?php if ($alternating && $index % 2 === 1) echo ' reverse'; ?>"
                        data-slide-id="<?php echo $index - 1; ?>">
                        <?php if ($image_icon === 'image' && $image) : ?>
                        <?php echo wp_get_attachment_image($image, 'full'); ?>
                        <?php endif; ?>
                        <?php if ($image_icon === 'icon' && $icon) : ?>
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
    i {
        color: <?php if (isset($nav_color)) echo $nav_color;
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

?>.inside {
    <?php if (is_array($bg_colors) || is_array($text_colors) || is_array($link_colors)): ?> <?php for ($i=0; $i < $total_colors; $i++): ?> .service-item.color-<?php echo $i + 1;

    ?> {
        background-color: <?php if(isset($bg_colors[$i])) echo $bg_colors[$i];
        ?>;
        color: <?php if (isset($text_colors[$i])) echo $text_colors[$i];
        ?>;

        i {
            color: <?php if (isset($service_icon_colors[$i])) echo $service_icon_colors[$i];
            ?>;
        }

        .copy-container {

            h3.service-title,
            p.service-blurb {
                color: <?php if (isset($text_colors[$i])) echo $text_colors[$i];
                ?>;
            }


            a,
            a>i {
                color: <?php if (isset($link_colors[$i])) echo $link_colors[$i];
                ?>;
            }

            a:hover,
            a:hover>i {
                color: <?php if (isset($link_hover_colors[$i])) echo $link_hover_colors[$i];
                ?>;
            }

            a.button {
                background-color: <?php if (isset($button_colors[$i])) echo $button_colors[$i];
                ?>;
            }

            a.button:hover {
                background-color: <?php if (isset($button_hover_colors[$i])) echo $button_hover_colors[$i];
                ?>;
            }
        }
    }

    <?php endfor;
    ?><?php endif;

    ?>
}

.asen-services-hub-<?php echo $block['id'] . ' ';

?>,
.asen-services-hub-<?php echo $block['id'] . '.has-background ';

?> {
    <?php $top_padding=get_field('top_padding');
    $bottom_padding=get_field('bottom_padding');
    $top_margin=get_field('top_margin');
    $bottom_margin=get_field('bottom_margin');

    if ($top_padding) {
        echo 'padding-top: '. $top_padding . 'px;';
        echo '@media (max-width: 1440px) {padding-top: '. $top_padding * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {padding-top: '. $top_padding * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {padding-top: '. $top_padding * 0.55 . 'px;}';
    }

    if ($bottom_padding) {
        echo 'padding-bottom: '. $bottom_padding . 'px;';
        echo '@media (max-width: 1440px) {padding-bottom: '. $bottom_padding * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {padding-bottom: '. $bottom_padding * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {padding-bottom: '. $bottom_padding * 0.55 . 'px;}';
    }

    if ($top_margin) {
        echo 'margin-top: '. $top_margin . 'px;';
        echo '@media (max-width: 1440px) {margin-top: '. $top_margin * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {margin-top: '. $top_margin * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {margin-top: '. $top_margin * 0.55 . 'px;}';
    }

    if ($bottom_margin) {
        echo 'margin-bottom: '. $bottom_margin . 'px;';
        echo '@media (max-width: 1440px) {margin-bottom: '. $bottom_margin * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {margin-bottom: '. $bottom_margin * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {margin-bottom: '. $bottom_margin * 0.55 . 'px;}';
    }

    ?>.inside.alternating .service-item .copy-container {

        <?php if (isset($alternating_styles)) : ?>h3.service-title,
        p.service-blurb {
            color: <?php echo $alt_color;
            ?>;
        }

        h3.service-title {
            font-size: <?php echo $alt_heading_size . 'px';
            ?>;

            <?php if (isset($alt_heading_size) && $alt_heading_size > 40) {
                $alt_heading_size=round($alt_heading_size * 0.85);
            }

            ?>@media (max-width: 1024px) {
                font-size: <?php if (isset($alt_heading_size)) echo $alt_heading_size . 'px';
                ?>;
            }

            <?php if (isset($alt_heading_size) && $alt_heading_size > 40) {
                $alt_heading_size=round($alt_heading_size * 0.8);
            }

            ?>@media (max-width: 640px) {
                font-size: <?php if (isset($alt_heading_size)) echo $alt_heading_size . 'px';
                ?>;
            }
        }

        p.service-blurb {
            font-size: <?php echo $alt_copy_size . 'px';
            ?>;

            <?php if (isset($alt_copy_size) && $alt_copy_size > 25) {
                $alt_copy_size=round($alt_copy_size * 0.85);
            }

            ?>@media (max-width: 1024px) {
                font-size: <?php if (isset($alt_copy_size)) echo $alt_copy_size . 'px';
                ?>;
            }

            <?php if (isset($alt_copy_size) && $alt_copy_size > 25) {
                $alt_copy_size=round($alt_copy_size * 0.85);
            }

            ?>@media (max-width: 640px) {
                font-size: <?php if (isset($alt_copy_size)) echo $alt_copy_size . 'px';
                ?>;
            }
        }

        <?php endif;
        ?>
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
                    perView: <?php echo get_field('number_of_columns') ? round(get_field('number_of_columns') / 2) : 2; ?>
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