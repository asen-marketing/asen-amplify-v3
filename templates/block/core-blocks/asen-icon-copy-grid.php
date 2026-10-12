<?php
/**
 * Block Name: Asen - Icon + Copy Grid
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

$link_type       = get_field( 'link_type_options' ) ?: 'no-link';
$link_icon       = get_field( 'link_icon' );
$align_center    = get_field( 'alignment_options' );
$container_width = get_field( '__container_width' ) ?: 'xl';
$heading_size    = get_field( '__heading_size' ) ?: 'h5';

$classes = array_filter( array(
    'asen-icon-copy-grid',
    'link-' . $link_type,
    $align_center ? 'align-center' : '',
    'block-width-' . $container_width,
    'asen-icon-copy-grid--heading-' . $heading_size,
) );
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) ); ?>>
    <div class="inside">
        <?php if ( have_rows( 'copy_text_blocks' ) ) : ?>
        <div class="items">
            <?php while ( have_rows( 'copy_text_blocks' ) ) : the_row();
                $icon      = get_sub_field( 'icon' );
                $heading   = get_sub_field( 'heading' );
                $copy      = get_sub_field( 'copy' );
                $link      = get_sub_field( 'link' );
                $wrap_link = $link && 'invisible-link' === $link_type;
                $tag       = $wrap_link ? 'a' : 'div';
            ?>
            <<?php echo $tag; ?> class="item"<?php if ( $wrap_link ) : ?> href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ?: '_self' ); ?>" title="<?php echo esc_attr( $link['title'] ); ?>"<?php endif; ?>>
                <?php if ( $icon ) : ?>
                <div class="icon"><?php echo $icon; ?></div>
                <?php endif; ?>
                <div class="copy">
                    <?php if ( $heading ) : ?>
                    <h4><?php echo esc_html( $heading ); ?></h4>
                    <?php endif; ?>
                    <?php if ( $copy ) : ?>
                    <p><?php echo wp_kses_post( $copy ); ?></p>
                    <?php endif; ?>
                </div>
                <?php if ( $link && in_array( $link_type, array( 'button-link', 'text-link' ), true ) ) : ?>
                <a class="<?php echo 'button-link' === $link_type ? 'button button-small' : 'asen-text-link'; ?>" href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ?: '_self' ); ?>">
                    <?php echo esc_html( $link['title'] ); ?><?php if ( 'text-link' === $link_type && $link_icon ) { echo $link_icon; } ?>
                </a>
                <?php endif; ?>
            </<?php echo $tag; ?>>
            <?php endwhile; ?>
        </div>
        <?php elseif ( is_admin() ) : ?>
        <p>Add items to the grid.</p>
        <?php endif; ?>
    </div>
</section>
