<?php
/**
 * Block Name: Asen Products Showcase
 *
 * Block for displaying Products CPT.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$products = get_field('products');
$carousel = get_field('use_carousel');
$alternating = get_field('alternating_grid');
$nav_rows = get_field('nav_arrow_icons');

if (is_array($nav_rows)) {
$prev_icon = $nav_rows[0]['previous_button_icon'];
$next_icon = $nav_rows[0]['next_button_icon'];
$nav_color = $nav_rows[0]['nav_arrow_color'];
}

$colors = get_field('product_colors');
$bg_colors = [];
$text_colors = [];
$total_colors = 1;

if (is_array($colors)) {
    foreach ($colors as $index => $color_row) {
        if ($color_row['bg_color']) {
            array_push($bg_colors, $color_row['bg_color']);
        }
        if ($color_row['text_color']) {
            array_push($text_colors, $color_row['text_color']);
        }
        $total_colors++;
    }
}
?>

<section
    class="asen-products-showcase asen-products-showcase-<?php echo $block['id']; echo $className; ?><?php if (get_field('has_background')) echo ' has-background'; ?><?php if ($alternating) echo ' alternating'; ?><?php if ($carousel) echo ' carousel'; if (!$carousel && !$alternating) echo ' grid' ?><?php if (get_field('align_center')) echo ' align-center'; ?>">
    <?php if (get_field('has_background')) : ?>
    <div class="heading-container<?php if (get_field('heading_align_center')) echo ' align-center'; ?>"
        style="<?php if (get_field('block_max_width')) echo 'max-width: ' . (get_field('block_max_width') - 200) . 'px;'; ?>">
        <h2
            class="products-heading <?php if (get_field('block_heading_text_transform')) echo get_field('block_heading_text_transform'); ?>">
            <?php echo get_field('block_heading'); ?></h2>
        <p
            class="products-subheading <?php if (get_field('block_subheading_text_transform')) echo get_field('block_subheading_text_transform'); ?>">
            <?php echo get_field('block_subheading'); ?></p>
    </div>
    <?php endif; ?>

    <div class="inside<?php if ($carousel) echo ' carousel'; if (!$carousel && !$alternating) echo ' grid' ?><?php if ($alternating) echo ' alternating'; ?>"
        style="<?php echo 'max-width: ' . get_field('block_max_width') . 'px;'; ?>">
        <?php if ($products) : ?>
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
                    <?php foreach( $products as $index => $product ): 
                $name = get_the_title( $product->ID );
                $image = get_field( 'product_image', $product->ID );
                $description = get_field('description', $product->ID);
                $price = get_field('price', $product->ID);
                $color = ($index + 1) % $total_colors;
                if ($color === 0) $color = 1;
                
                    ?>
                    <li class="<?php echo $carousel ? 'glide__slide ' : ''; ?> product-item<?php echo ($index == 1 ? ' is-active' : ''); ?><?php echo ' color-' . $color;?><?php if ($alternating && $index % 2 === 1) echo ' reverse'; ?>"
                        data-slide-id="<?php echo $index - 1; ?>">
                        <?php if ($image) : ?>
                        <?php echo wp_get_attachment_image($image, 'full'); ?>
                        <?php endif; ?>
                        <div class="copy-container<?php if (count($bg_colors)) echo ' has-background'; ?>">
                            <h3
                                class="product-title <?php if (get_field('heading_text_transform')) echo get_field('heading_text_transform'); ?>">
                                <?php echo $name; ?></h3>
                            <?php if ($description) : ?>
                            <p class=" description"><?php echo $description; ?></p>
                            <?php endif; ?>
                            <?php if ($price) : ?>
                            <p class="price"><?php echo '$' . $price; ?></p>
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

<?php
$block_heading_size = get_field('block_heading_size');
$block_subheading_size = get_field('block_subheading_size');
$alt_heading_size = get_field('heading_size');
$alt_description_size = get_field('description_size');
?>

<style>
.asen-products-showcase-<?php echo $block['id'];

?>.has-background::after {
    background-color: <?php echo get_field('background_color');
    ?>;
}

.asen-products-showcase-<?php echo $block['id'];

?>.has-background .heading-container {
    h2 {
        color: <?php the_field('block_heading_color');
        ?>;
        font-size: <?php echo get_field('block_heading_size') . 'px';
        ?>;

        <?php if (isset($block_heading_size) && $block_heading_size > 40) {
            $block_heading_size=round($block_heading_size * 0.85);
        }

        ?>@media (max-width: 1024px) {
            font-size: <?php if (isset($block_heading_size)) echo $block_heading_size . 'px';
            ?>;
        }

        <?php if (isset($block_heading_size) && $block_heading_size > 40) {
            $block_heading_size=round($block_heading_size * 0.8);
        }

        ?>@media (max-width: 640px) {
            font-size: <?php if (isset($block_heading_size)) echo $block_heading_size . 'px';
            ?>;
        }
    }

    p {
        color: <?php the_field('block_subheading_color');
        ?>;
        font-size: <?php echo get_field('block_subheading_size') . 'px';
        ?>;

        <?php if (isset($block_subheading_size) && $block_subheading_size > 25) {
            $block_subheading_size=round($block_subheading_size * 0.85);
        }

        ?>@media (max-width: 1024px) {
            font-size: <?php if (isset($block_subheading_size)) echo $block_subheading_size . 'px';
            ?>;
        }

        <?php if (isset($block_subheading_size) && $block_subheading_size > 25) {
            $block_subheading_size=round($block_subheading_size * 0.85);
        }

        ?>@media (max-width: 640px) {
            font-size: <?php if (isset($block_subheading_size)) echo $block_subheading_size . 'px';
            ?>;
        }
    }
}

.asen-products-showcase-<?php echo $block['id'] . ' ';

?>.controls button {
    i {
        color: <?php if (isset($nav_color)) echo $nav_color;
        ?>;
    }
}

.asen-products-showcase-<?php echo $block['id'] . ' ';
?>.inside .product-item,
.asen-products-showcase-<?php echo $block['id'] . ' ';

?>.inside .glide__slide {
    width: calc(100% / <?php echo get_field('number_of_columns'); ?> + (2rem / <?php echo get_field('number_of_columns'); ?>) - 2rem);


    .copy-container {

        p,
        h3 {
            color: <?php echo get_field('product_text_color');
            ?>;
        }
    }
}

@media (max-width: 1024px) {

    .asen-products-showcase-<?php echo $block['id'] . ' ';
    ?>.inside .product-item,
    .asen-products-showcase-<?php echo $block['id'] . ' ';

    ?>.inside .glide__slide {
        width: calc(100% / <?php echo round(get_field('number_of_columns') / 2); ?> + (2rem / <?php echo round(get_field('number_of_columns') / 2); ?>) - 2rem);

    }
}

@media (max-width: 640px) {
    .asen-products-showcase-<?php echo $block['id'] . ' ';
    ?>.inside .product-item,
    .asen-products-showcase-<?php echo $block['id'] . ' ';

    ?>.inside .glide__slide {
        width: 100%;
    }
}

.asen-products-showcase-<?php echo $block['id'] . ' ';

?> {
    .inside {
        <?php if (is_array($bg_colors) || is_array($text_colors)): ?> <?php for ($i=0; $i < $total_colors; $i++): ?> .product-item.color-<?php echo $i + 1;

        ?> {
            background-color: <?php if (isset($bg_colors[$i])) echo $bg_colors[$i];
            ?>;
            color: <?php if (isset($text_colors[$i])) echo $text_colors[$i];
            ?>;

            .copy-container {
                background-color: <?php if (isset($bg_colors[$i])) echo $bg_colors[$i];
                ?>;

                h3.product-title,
                p.description,
                p.price {
                    color: <?php if (isset($text_colors[$i])) echo $text_colors[$i];
                    ?>;
                }
            }
        }

        <?php endfor;
        ?><?php endif;
        ?>
    }


    .inside.alternating .product-item .copy-container {
        h3.product-title {
            color: <?php echo get_field('alternating_heading_color');
            ?>;
            font-size: <?php echo get_field('heading_size') . 'px';
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

        p.description {
            color: <?php echo get_field('alternating_text_color');
            ?>;
            font-size: <?php echo get_field('description_size') . 'px';
            ?>;

            <?php if (isset($alt_description_size) && $alt_description_size > 25) {
                $alt_description_size=round($alt_description_size * 0.85);
            }

            ?>@media (max-width: 1024px) {
                font-size: <?php if (isset($alt_description_size)) echo $alt_description_size . 'px';
                ?>;
            }

            <?php if (isset($alt_description_size) && $alt_description_size > 25) {
                $alt_description_size=round($alt_description_size * 0.85);
            }

            ?>@media (max-width: 640px) {
                font-size: <?php if (isset($alt_description_size)) echo $alt_description_size . 'px';
                ?>;
            }
        }
    }
}
</style>

<?php if ($carousel && !is_admin()) : ?>
<script defer>
(function($) {
    "use strict";
    var windowObject = $(window),
        carouselContainer = $('.asen-products-showcase-<?php echo $block['id']; ?>'),
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