<?php
/**
 * Block Name: Asen - Dropdown Links
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

$label           = get_field( 'default_display_option' ) ?: 'Select a link';
$links           = get_field( 'links' ) ?: array();
$container_width = get_field( '__container_width' ) ?: 'sm';
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'asen-dropdown-links block-width-' . $container_width ) ); ?>>
    <div class="inside">
        <details class="dropdown">
            <summary><?php echo esc_html( $label ); ?></summary>
            <ul class="dropdown-options">
                <?php foreach ( $links as $row ) : $link = $row['link'] ?? null; if ( empty( $link['url'] ) ) { continue; } ?>
                <li><a href="<?php echo esc_url( $link['url'] ); ?>"<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener"' : ''; ?>><?php echo esc_html( $link['title'] ?: $link['url'] ); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </details>
    </div>
</div>
