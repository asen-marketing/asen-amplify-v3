<?php
/**
 * Block Name: Asen FAQs
 *
 * Displays dropdowns for FAQs based on selected categories.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$all_faqs = null;
$split_layout = get_field('split_layout');
$heading = get_field('heading');
$copy = get_field('copy');

if (!get_field('faq_categories')) {
    $all_faqs = get_field('faq_selection');
} else {
    $categories = get_field('faq_category_selection');

if ($categories) {
  if (!is_array($categories)) {
    $categories = array($categories);
}
$args = array(
    'post_type' => 'faq',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'faq-category',
            'terms' => $categories,
        ),
    ),
);
}
if (!$categories) {
    $args = array(
        'post_type' => 'faq',
        'posts_per_page' => -1
    );
}
$all_faqs = get_posts($args);
}

?>

<section
    class="asen-faqs<?php echo $split_layout ? ' split-layout' : ''; ?> asen-faqs-<?php echo $block['id']; echo $className; ?>">
    <div class="inside" style="<?php echo 'max-width: ' . get_field('block_max_width') . 'px;'; ?>">

        <?php if ($split_layout) : ?>
        <div class=" copy-container">
            <?php if ($heading) : ?>
            <h3><?php echo $heading; ?></h3>
            <?php endif; ?>
            <?php if ($copy) : ?>
            <?php echo $copy; ?>
            <?php endif; ?>
            <?php if (get_field('show_contact_us_disclaimer')) : ?>
            <p class="disclaimer">Didn't find your answer? <a href="/contact" title="Contact Us">Contact us</a>.</p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php
        if( $all_faqs ): ?>
        <div class="faq-container">
            <?php foreach( $all_faqs as $index => $faq_post ): 
                $title = get_the_title( $faq_post->ID );
                $faq_answer = get_field( 'faq_answer', $faq_post->ID );
                ?>
            <div class="faq">
                <div class="question trigger-<?php echo trim($className); ?>" data-faq="<?php echo $index; ?>">
                    <h6 class="copy"><?php echo ( $title ); ?></h6>
                </div>
                <p class="answer faq-answer-<?php echo trim($className); ?>" data-faq="<?php echo $index; ?>">
                    <?php echo ( $faq_answer ); ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
        <?php if (get_field('show_contact_us_disclaimer') && !$split_layout) : ?>
        <p class="disclaimer">Didn't find your answer? <a href="/contact" title="Contact Us">Contact us</a>.</p>
        <?php endif; ?>
    </div>
</section>

<?php 
$open_close_styles = get_field('open_close_icons');
$split_styles = get_field('split_text_styles');

if ($open_close_styles) {
    $icon_size = $open_close_styles[0]['icon_size'];
    $open_icon = $open_close_styles[0]['open_icon'];
    $close_icon = $open_close_styles[0]['close_icon'];
}
if ($split_styles) {
    $heading_size = $split_styles[0]['heading_size'];
    $heading_color = $split_styles[0]['heading_color'];
    $copy_size = $split_styles[0]['copy_size'];
    $copy_color = $split_styles[0]['copy_color'];
}
?>

<style>
.asen-faqs-<?php echo $block['id'];

?> {
    .inside {

        .copy-container {
            h3 {
                font-size: <?php if (isset($heading_size)) echo $heading_size . 'px';
                ?>;
                color: <?php if (isset($heading_color)) echo $heading_color;
                ?>;

                <?php if (isset($heading_size) && $heading_size > 40) {
                    $heading_size=round($heading_size * 0.85);
                }

                ?>@media (max-width: 1024px) {
                    font-size: <?php if (isset($heading_size)) echo $heading_size . 'px';
                    ?>;
                }

                <?php if (isset($heading_size) && $heading_size > 40) {
                    $heading_size=round($heading_size * 0.85);
                }

                ?>@media (max-width: 640px) {
                    font-size: <?php if (isset($heading_size)) echo $heading_size . 'px';
                    ?>;
                }
            }

            p {
                font-size: <?php if(isset($copy_size)) echo $copy_size . 'px';
                ?>;
                color: <?php if (isset($copy_color)) echo $copy_color;
                ?>;

                <?php if (isset($copy_size) && $copy_size > 22) {
                    $copy_size=round($copy_size * 0.85);
                }

                ?>@media (max-width: 1024px) {
                    font-size: <?php if (isset($copy_size)) echo $copy_size . 'px';
                    ?>;
                }

                <?php if (isset($copy_size) && $copy_size > 22) {
                    $copy_size=round($copy_size * 0.85);
                }

                ?>@media (max-width: 640px) {
                    font-size: <?php if (isset($copy_size)) echo $copy_size . 'px';
                    ?>;
                }
            }
        }


        .faq {
            .question {
                background-color: <?php the_field('question_bar_color');
                ?>;

                h6 {
                    color: <?php the_field('question_bar_text_color');
                    ?>;
                }
            }


            .question::after {
                color: <?php the_field('question_bar_text_color');
                ?>;
                font-size: <?php echo $icon_size . 'px';
                ?>;
                content: "<?php echo '\\' . $open_icon; ?>";

                <?php if ($icon_size && $icon_size > 25) {
                    $icon_size=round($icon_size * 0.85);
                }

                ?>@media (max-width: 640px) {
                    font-size: <?php echo $icon_size . 'px';
                    ?>;
                }
            }

            .question:hover {
                background-color: <?php the_field('question_bar_active_color');
                ?>;

                h6 {
                    color: <?php the_field('question_bar_active_text_color');
                    ?>;
                }
            }

            .question:hover::after {
                color: <?php the_field('question_bar_active_text_color');
                ?>
            }

            .question.active {
                background-color: <?php the_field('question_bar_active_color');
                ?>;

                h6 {
                    color: <?php the_field('question_bar_active_text_color');
                    ?>;
                }
            }

            .question.active::after {
                color: <?php the_field('question_bar_active_text_color');
                ?>;
                content: "<?php echo '\\' . $close_icon; ?>";
            }
        }
    }
}
</style>

<script defer>
(function($) {

    var faqBlock = $('.asen-faqs-<?php echo $block['id']; ?>'),
        triggers = faqBlock.find('.trigger-<?php echo trim($className); ?>'),
        answers = faqBlock.find('.faq-answer-<?php echo trim($className); ?>')

    answers.hide()

    triggers.on('click', function() {
        var answer = answers.eq($(this).data('faq'))

        if ($(this).hasClass('active')) {
            $(this).removeClass('active')
            answer.hide(350)
            return
        }
        triggers.removeClass('active')
        answers.hide(350)

        answer.toggle(350)
        $(this).toggleClass('active')
    })
})(jQuery)
</script>