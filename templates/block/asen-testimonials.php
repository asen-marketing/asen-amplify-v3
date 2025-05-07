<?php
/**
 * Block Name: Asen Testimonials
 *
 * Displays testimonials CPT as a grid or carousel.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$testimonials = get_field('testimonials');
$carousel = get_field('use_carousel');
$nav_arrows = get_field('nav_arrows');
$grid_colors = get_field('grid_colors');

if (is_array($grid_colors)) {
    $total_colors = count($grid_colors);
}
?>

<section
    class="asen-testimonials asen-testimonials-<?php echo $block['id']; echo $className; ?><?php echo $carousel ? ' carousel' : ' grid'; ?>">
    <?php if ($carousel) : ?>
    <div class="width-container<?php echo get_field('full_width') ? ' full' : ''; ?>">
        <?php endif; ?>
        <div class="inside<?php echo $carousel ? ' carousel' : ' grid'; ?>">
            <?php if ($testimonials) : ?>
            <?php foreach( $testimonials as $index => $testimonial ): 
                $quote = get_field('testimonial_quote', $testimonial->ID );
                $author = get_field('testimonial_author', $testimonial->ID);
                $company = get_field( 'testimonial_company', $testimonial->ID );
                $image = get_field('testimonial_image', $testimonial->ID);

                if (isset($total_colors)) {
                    $current_color = ($index % $total_colors) + 1;
                }
                ?>
            <div class="testimonial-item<?php echo (($index == 0 && $carousel) ? ' active' : ''); ?><?php echo ' text-' . get_field('font_size'); ?><?php if (isset($current_color)) echo ' color-' . $current_color; ?>"
                data-slide-id="<?php echo $index - 1; ?>">
                <?php if ($image) : ?>
                <?php echo wp_get_attachment_image($image, 'full'); ?>
                <?php endif; ?>
                <p class="quote">
                    <?php echo '"' . $quote . '"'; ?></p>
                <p class="author"><span class="name"><?php echo $author; ?></span><?php if ($company) echo ', '; ?>
                    <?php if ($company) : ?>
                    <?php echo $company; ?>
                    <?php endif; ?>
                </p>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>

            <?php if ($carousel && count($testimonials) > 1) : ?>
            <?php if (!$nav_arrows) : ?>
            <div class="selectors">
                <?php for ($i = 0; $i < count($testimonials); $i++) : ?>
                <button data-index="<?php echo $i; ?>"></button>
                <?php endfor; ?>
            </div>
            <?php else : 
                $prev_icon = get_field('previous_icon');
                $next_icon = get_field('next_icon');
                ?>
            <div class="controls">
                <button class="previous" data-glide-dir="<" title="Show previous slide"
                    aria-controls="carousel-<?php echo $block['id']; ?>"><?php echo $prev_icon; ?></button>
                <button class="next" data-glide-dir="&#x0003E;" title="Show next slide"
                    aria-controls="carousel-<?php echo $block['id']; ?>"><?php echo $next_icon; ?></button>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php if ($carousel) : ?>
    </div>
    <?php endif; ?>
</section>

<style>
.asen-testimonials-<?php echo $block['id'];

?> {
    p.author {
        opacity: <?php the_field('author_opacity');
        ?>;
    }
}

.asen-testimonials-<?php echo $block['id'];

?>.carousel {
    .width-container {
        background-color: <?php echo get_field('background_color');
        ?>;

        p {
            color: <?php echo get_field('text_color');
            ?>;
        }
    }

    .selectors {
        button {
            background-color: <?php the_field('nav_color');
            ?>;
        }
    }

    .controls {
        button {

            color: <?php the_field('nav_color');
            ?>;
            border: 3px solid <?php the_field('nav_color');
            ?>;
        }
    }
}

.asen-testimonials-<?php echo $block['id'] . ' ';

?>.inside.grid {
    column-count: <?php the_field('number_of_columns');
    ?>;

    <?php // color rotation ?>
    <?php if (is_array($grid_colors)): ?> <?php for ($i=0; $i < count($grid_colors); $i++): ?> .color-<?php echo $i + 1;

    ?> {
        background-color: <?php echo $grid_colors[$i]['background_color'];
        ?>;
        color: <?php echo $grid_colors[$i]['text_color'];
        ?>;
    }

    <?php endfor;
    ?><?php endif;
    ?>
}

@media (max-width: 1024px) {

    .asen-testimonials-<?php echo $block['id'] . ' ';

    ?>.inside.grid {
        grid-template-columns: repeat(<?php echo round(get_field('number_of_columns') / 2); ?>, minmax(0, 1fr));
    }
}

@media (max-width: 640px) {

    .asen-testimonials-<?php echo $block['id'] . ' ';

    ?>.inside.grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php if ($carousel && count($testimonials) > 1) : ?>
<script defer>
(function($) {
    var quotes = $('.testimonial-item'),
        selectors = $('.selectors button'),
        current = 0,
        intId

    selectors.eq(0).addClass('active')

    function startInterval() {
        intId = setInterval(() => {
            quotes.removeClass('active')
            selectors.removeClass('active')
            if (current === quotes.length - 1) {
                current = 0
            } else {
                current++
            }
            quotes.eq(current).addClass('active')
            selectors.eq(current).addClass('active')
        }, 5000);
    }

    selectors.on('click', function() {
        if ($(this).data('index') !== current) {
            clearInterval(intId)
            current = $(this).data('index')
            quotes.removeClass('active')
            selectors.removeClass('active')
            quotes.eq(current).addClass('active')
            selectors.eq(current).addClass('active')
            startInterval()
        }
    })

    startInterval()
})(jQuery)
</script>
<?php endif; ?>