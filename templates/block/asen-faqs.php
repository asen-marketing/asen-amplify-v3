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

<section class="asen-faqs asen-faqs-<?php echo $block['id']; echo $className; ?>">
    <div class="inside">
        <?php
        if( $all_faqs ): ?>
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
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
        <?php if (get_field('show_contact_us_disclaimer')) : ?>
        <p class="disclaimer">Didn't find your answer? <a href="/contact" title="Contact Us">Contact us</a>.</p>
        <?php endif; ?>
    </div>
</section>

<style>
.asen-faqs {
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
        ?>
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
        ?>
    }
}
</style>

<script defer>
(function($) {
    var triggers = $('.trigger-<?php echo trim($className); ?>'),
        answers = $('.faq-answer-<?php echo trim($className); ?>')

    answers.hide()

    triggers.on('click', function() {
        var answer = answers.eq($(this).data('faq'))

        if ($(this).hasClass('active')) {
            $(this).removeClass('active')
            answer.hide(250)
            return
        }
        triggers.removeClass('active')
        answers.hide(250)

        answer.toggle(250)
        $(this).toggleClass('active')
    })
})(jQuery)
</script>