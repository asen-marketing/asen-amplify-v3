<?php
/**
 * Block Name: Asen - FAQs
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

$by_category     = get_field( 'faq_categories' );
$split_layout    = get_field( 'split_layout' );
$heading         = get_field( 'heading' );
$copy            = get_field( 'copy' );
$show_disclaimer = get_field( 'show_contact_us_disclaimer' );
$container_width = get_field( '__container_width' ) ?: 'lg';

if ( $by_category ) {
    $categories = array_filter( (array) get_field( 'faq_category_selection' ) );
    $args       = array( 'post_type' => 'faq', 'posts_per_page' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC' );
    if ( $categories ) {
        $args['tax_query'] = array( array( 'taxonomy' => 'faq-category', 'terms' => $categories ) );
    }
    $faqs = get_posts( $args );
} else {
    $faqs = array_filter( (array) get_field( 'faq_selection' ) );
}

$classes = array_filter( array( 'asen-faqs', $split_layout ? 'split-layout' : '', 'block-width-' . $container_width ) );
$disclaimer = '<p class="disclaimer">Didn\'t find your answer? <a href="/contact" title="Contact Us">Contact us</a>.</p>';
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) ); ?>>
    <div class="inside">
        <?php if ( $split_layout ) : ?>
        <div class="copy-container">
            <?php if ( $heading ) : ?>
            <h3><?php echo esc_html( $heading ); ?></h3>
            <?php endif; ?>
            <?php if ( $copy ) : ?>
            <p><?php echo wp_kses_post( $copy ); ?></p>
            <?php endif; ?>
            <?php if ( $show_disclaimer ) { echo $disclaimer; } ?>
        </div>
        <?php endif; ?>

        <?php if ( $faqs ) : ?>
        <div class="faq-container">
            <?php foreach ( $faqs as $i => $faq ) :
                $faq       = get_post( $faq );
                $answer_id = 'faq-' . $block['id'] . '-' . $i;
            ?>
            <div class="faq">
                <button class="question" type="button" aria-expanded="false" aria-controls="<?php echo esc_attr( $answer_id ); ?>">
                    <?php echo esc_html( get_the_title( $faq ) ); ?>
                </button>
                <div class="answer" id="<?php echo esc_attr( $answer_id ); ?>">
                    <div class="answer-inner"><?php echo wp_kses_post( get_field( 'faq_answer', $faq->ID ) ); ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php elseif ( is_admin() ) : ?>
        <p>No FAQs selected.</p>
        <?php endif; ?>

        <?php if ( $show_disclaimer && ! $split_layout ) { echo $disclaimer; } ?>
    </div>
</section>
