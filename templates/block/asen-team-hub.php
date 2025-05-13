<?php
/**
 * Block Name: Asen Team Hub
 *
 * Displays team CPT as a grid or carousel.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$team_members = get_field('team_members');
$carousel = get_field('use_carousel');
$nav_rows = get_field('nav_arrow_icons');
$prev_icon = $nav_rows[0]['previous_button_icon'];
$next_icon = $nav_rows[0]['next_button_icon'];
$nav_color = $nav_rows[0]['nav_arrow_color'];
?>

<section
    class="asen-team-hub asen-team-hub-<?php echo $block['id']; echo $className; ?><?php echo $carousel ? ' carousel' : ' grid'; ?>">
    <div class="inside<?php echo $carousel ? ' carousel' : ' grid'; ?>">
        <?php if ($team_members) : ?>
        <?php if ($carousel) : ?>
        <div class="controls" data-glide-el="controls">
            <button class="previous" data-glide-dir="<" title="Show previous slide"
                aria-controls="carousel-<?php echo $block['id']; ?>"><?php echo $prev_icon ? $prev_icon : '<i class="fa-regular fa-circle-chevron-left"></i>'; ?></button>
            <button class="next" data-glide-dir="&#x0003E;" title="Show next slide"
                aria-controls="carousel-<?php echo $block['id']; ?>"><?php echo $next_icon ? $next_icon : '<i class="fa-regular fa-circle-chevron-right"></i>'; ?></button>
        </div>
        <div class="glide glide-<?php echo $block['id']; ?>">
            <div data-glide-el="track" class="glide__track" id="carousel-<?php echo $block['id']; ?>">
                <ul class="glide__slides">
                    <?php endif; ?>
                    <?php foreach( $team_members as $index => $team_member ): 
                $name = get_the_title( $team_member->ID );
                $image = get_field( 'team_member_image', $team_member->ID );
                $position = get_field( 'team_member_position', $team_member->ID );
                $bio = get_field( 'team_member_bio', $team_member->ID );
                ?>
                    <li class="<?php echo $carousel ? 'glide__slide ' : ''; ?> team-item<?php echo ($index == 1 ? ' is-active' : ''); ?>"
                        data-slide-id="<?php echo $index - 1; ?>">
                        <?php echo wp_get_attachment_image($image, 'full'); ?>
                        <h3 class="team-member-name<?php echo ' text-' . get_field('name_text_transform'); ?>">
                            <?php echo $name; ?></h3>
                        <h4 class="team-member-position<?php echo ' text-' . get_field('title_text_transform'); ?>">
                            <?php echo $position; ?></h4>
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
.asen-team-hub-<?php echo $block['id'] . ' ';
?>.inside .team-item,
.asen-team-hub-<?php echo $block['id'] . ' ';

?>.inside .glide__slide {
    width: calc(100% / <?php echo get_field('number_of_columns'); ?> + (2rem / <?php echo get_field('number_of_columns'); ?>) - 2rem);

    h3.team-member-name {
        color: <?php the_field('name_color');
        ?>;
        font-weight: <?php the_field('name_font_weight');
        ?>;
    }

    h4.team-member-position {
        font-weight: <?php the_field('title_font_weight');
        ?>;
    }

    h4,
    p {
        color: <?php the_field('text_color');
        ?>;
    }
}

.asen-team-hub-<?php echo $block['id'] . ' ';

?>.controls {
    i {
        color: <?php echo $nav_color;
        ?>;
    }
}

@media (max-width: 1024px) {

    .asen-team-hub .inside .team-item,
    .asen-team-hub .inside .glide__slide {
        width: calc(100% / <?php echo round(get_field('number_of_columns') / 2); ?> + (2rem / <?php echo round(get_field('number_of_columns') / 2); ?>) - 2rem);

    }
}

@media (max-width: 640px) {

    .asen-team-hub .inside .team-item,
    .asen-team-hub .inside .glide__slide {
        width: 100%;
    }
}
</style>

<?php if ($carousel && !is_admin()) : ?>
<script defer>
(function($) {
    "use strict";
    var windowObject = $(window),
        carouselContainer = $('.asen-team-grid-<?php echo $block['id']; ?>'),
        prevButton = $('.controls > .previous'),
        nextButton = $('.controls > .next')

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