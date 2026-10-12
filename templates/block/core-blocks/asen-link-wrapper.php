<?php
/**
 * Block Name: Asen - Link Wrapper
 *
 * Inner blocks rendered inside one <a>. The editor gets a <div> so clicks don't navigate.
 */

$link = get_field( 'link_object' );
$url  = $link['url'] ?? '';
if ( $url && get_field( 'link_anchor' ) ) {
    $url .= '#' . ltrim( get_field( 'link_anchor' ), '#' );
}
?>
<?php if ( ! empty( $is_preview ) || ! $url ) : ?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'asen-link-wrapper' ) ); ?>>
    <?php if ( ! empty( $is_preview ) ) : ?>
    <span class="block-label">Links to: <?php echo esc_html( $url ?: 'no link set' ); ?></span>
    <?php endif; ?>
    <InnerBlocks />
</div>
<?php else : ?>
<a <?php echo get_block_wrapper_attributes( array( 'class' => 'asen-link-wrapper' ) ); ?> href="<?php echo esc_url( $url ); ?>"<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener"' : ''; ?><?php echo ! empty( $link['title'] ) ? ' aria-label="' . esc_attr( $link['title'] ) . '"' : ''; ?>>
    <InnerBlocks />
</a>
<?php endif; ?>
