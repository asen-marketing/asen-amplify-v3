<?php
/**
 * Block Name: Asen - Tabbed Content
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

$selector        = get_field( 'tab_selector_options' ) ?: 'buttons';
$tabs            = get_field( 'tabs' ) ?: array();
$container_width = get_field( '__container_width' ) ?: 'sm';
$base_id         = 'tabs-' . $block['id'];

$classes = array( 'asen-tabbed-content', 'selector-' . $selector, 'block-width-' . $container_width );
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) ); ?>>
    <div class="inside">
        <?php if ( $tabs ) : ?>
            <?php if ( 'dropdown' === $selector ) : ?>
            <div class="tab-dropdown">
                <label class="screen-reader-text" for="<?php echo esc_attr( $base_id ); ?>-select">Select a tab</label>
                <select class="tab-selector" id="<?php echo esc_attr( $base_id ); ?>-select">
                    <?php foreach ( $tabs as $tab ) : ?>
                    <option value="<?php echo esc_attr( sanitize_title( $tab['tab_name'] ) ); ?>"><?php echo esc_html( $tab['tab_name'] ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php else : ?>
            <div class="tab-buttons" role="tablist">
                <?php foreach ( $tabs as $i => $tab ) : $slug = sanitize_title( $tab['tab_name'] ); ?>
                <button class="button tab" type="button" role="tab" id="<?php echo esc_attr( "$base_id-tab-$i" ); ?>"
                    aria-controls="<?php echo esc_attr( "$base_id-panel-$i" ); ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
                    data-tab="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $tab['tab_name'] ); ?></button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="tab-panels">
                <?php foreach ( $tabs as $i => $tab ) : $slug = sanitize_title( $tab['tab_name'] ); ?>
                <div class="tab-panel <?php echo esc_attr( $tab['special_classes'] ?? '' ); ?>" role="tabpanel" id="<?php echo esc_attr( "$base_id-panel-$i" ); ?>"
                    aria-labelledby="<?php echo esc_attr( "$base_id-tab-$i" ); ?>" data-tab="<?php echo esc_attr( $slug ); ?>"<?php echo 0 === $i ? '' : ' hidden'; ?>>
                    <?php echo $tab['tab_content']; ?>
                </div>
                <?php endforeach; ?>
            </div>
        <?php elseif ( is_admin() ) : ?>
        <p>Add tabs.</p>
        <?php endif; ?>
    </div>
</section>
