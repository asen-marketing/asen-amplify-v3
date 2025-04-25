<?php
/**
 * Block Name: Asen Blockquote Rotator Row
 *
 * A rotating blockquote that looks great with Asen 2020.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
?>
<?php if ( is_admin() && get_field('quotes') ) : ?>
    <?php foreach( get_field('quotes') as $item ): ?>
        <p><strong><?php echo $item['quote'] ?></strong> <?php echo $item['attribution']; ?></p>
    <?php endforeach; ?>
<?php elseif ( get_field('quotes') ) : ?>
    <div class="asen-blockquote asen-blockquote-rotator asen-blockquote-rotator-<?php echo $block['id']; echo $className; ?>">
        <div class="inside">
            <div class="glide">
                <div data-glide-el="track" class="glide__track">
                    <ul class="glide__slides">
                        <?php while ( have_rows('quotes') ) : the_row(); ?>
                            <li class="glide__slide <?php echo (get_row_index() == 1 ? 'is-active' : ''); ?>" data-slide-id="<?php echo get_row_index() - 1; ?>">
                                <blockquote class="<?php the_sub_field('text_size'); ?>">
                                    <p>&ldquo;<?php the_sub_field('quote'); ?>&rdquo;</p>
                                    <?php if ( get_sub_field('attribution') ) : ?>
                                        <cite>&#8213; <?php the_sub_field('attribution'); ?></cite>
                                    <?php endif; ?>
                                </blockquote>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]">
                    <?php while ( have_rows('quotes') ) : the_row(); ?>
                        <button class="slider__bullet glide__bullet" data-glide-dir="=<?php echo get_row_index() - 1; ?>"></button>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
    <script defer>
        (function($) {
            "use strict";

            var windowObject = $(window),
                carouselContainer = $('.asen-blockquote-rotator-<?php echo $block['id']; ?>');

            windowObject.on("load", function() {
                var glide = new Glide(".asen-blockquote-rotator-<?php echo $block['id']; ?> .glide", {
                    type: "carousel",
                    startAt: 0,
                    autoplay: 5000,
                    gap: 0,
                    animationDuration: 400,
                    hoverpaulse: true,
                });
                glide.mount();

                glide.on('run.before', function (event) {
                    carouselContainer.find('.glide__slide').removeClass('is-active');
                });

                glide.on('run', function (event) {
                    let newActive = carouselContainer.find('.glide__slide[data-slide-id="' + glide.index + '"]');
                    newActive.prevAll().addClass('is-previous');
                    newActive.nextAll().removeClass('is-previous');
                    newActive.addClass('is-active');
                });
            }); // End window loaded.
        })(jQuery);
    </script>
<?php else : ?>
    <p>Add some quotes!</p>
<?php endif; ?>
