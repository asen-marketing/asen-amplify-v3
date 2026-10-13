<?php
/**
 * Shared list of posts for the CPT hub blocks, as a grid, alternating rows, or a Splide carousel.
 *
 * Args: items (posts or IDs), item_template (template part rendered per post with args + 'post'), layout (grid|alternating|carousel),
 * columns (1-6; slides per view in the carousel), label (carousel aria-label), splide (extra Splide options), item_args,
 * lead (optional [ 'template' => ..., 'args' => [...] ] rendered as the first item, e.g. a CTA tile).
 */

// Filter before get_post(): an empty ACF selection is false, and get_post( false ) returns the current page.
$items     = array_filter( array_map( 'get_post', array_filter( (array) ( $args['items'] ?? array() ) ) ) );
$layout    = $args['layout'] ?? 'grid';
$columns   = max( 1, min( 6, (int) ( $args['columns'] ?? 3 ) ) );
$template  = $args['item_template'];
$item_args = $args['item_args'] ?? array();
$lead      = $args['lead'] ?? null;

if ( ! $items ) {
    if ( is_admin() ) {
        echo '<p>Select items to display.</p>';
    }
    return;
}

if ( 'carousel' === $layout ) :
    wp_enqueue_script( 'asen-carousel' );
    wp_enqueue_style( 'splide' );
    $options = array_replace_recursive( array(
        'type'         => 'loop',
        'perPage'      => $columns,
        'gap'          => 'var(--wp--custom--gap--lg)',
        'arrows'       => true,
        'pagination'   => false,
        'autoplay'     => true,
        'interval'     => 5000,
        'pauseOnHover' => true,
        'breakpoints'  => array(
            1024 => array( 'perPage' => (int) ceil( $columns / 2 ) ),
            640  => array( 'perPage' => 1 ),
        ),
    ), $args['splide'] ?? array() );
?>
<div class="collection collection-carousel splide has-columns-<?php echo $columns; ?>" aria-label="<?php echo esc_attr( $args['label'] ?? '' ); ?>" data-splide="<?php echo esc_attr( wp_json_encode( $options ) ); ?>">
    <div class="splide__track">
        <ul class="splide__list">
            <?php if ( $lead ) : ?>
            <li class="splide__slide collection-item is-lead"><?php get_template_part( $lead['template'], null, $lead['args'] ?? array() ); ?></li>
            <?php endif; ?>
            <?php foreach ( $items as $item ) : ?>
            <li class="splide__slide collection-item"><?php get_template_part( $template, null, array_merge( $item_args, array( 'post' => $item ) ) ); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php else : ?>
<ul class="collection collection-<?php echo esc_attr( $layout ); ?> has-columns-<?php echo $columns; ?>">
    <?php if ( $lead ) : ?>
    <li class="collection-item is-lead"><?php get_template_part( $lead['template'], null, $lead['args'] ?? array() ); ?></li>
    <?php endif; ?>
    <?php foreach ( $items as $item ) : ?>
    <li class="collection-item"><?php get_template_part( $template, null, array_merge( $item_args, array( 'post' => $item ) ) ); ?></li>
    <?php endforeach; ?>
</ul>
<?php endif;
