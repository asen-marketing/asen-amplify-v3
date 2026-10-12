<?php
/**
 * What clients (non-Asen users, see asen_user_is_builder()) can do in the block editor. Builders are unrestricted.
 */

// Inserter allowlist: Asen blocks plus the core blocks content editing needs. Filter asen/client_allowed_blocks per site.
function asen_client_allowed_blocks( $allowed, $context ) {
    if ( asen_user_is_builder() ) {
        return $allowed;
    }
    $core = array(
        'core/paragraph', 'core/heading', 'core/list', 'core/list-item', 'core/image', 'core/gallery', 'core/buttons', 'core/button',
        'core/quote', 'core/separator', 'core/spacer', 'core/group', 'core/columns', 'core/column', 'core/media-text', 'core/cover',
        'core/video', 'core/embed', 'core/table', 'core/block',
    );
    $asen = array_values( array_filter( array_keys( WP_Block_Type_Registry::get_instance()->get_all_registered() ), fn( $name ) => str_starts_with( $name, 'acf/' ) ) );
    return apply_filters( 'asen/client_allowed_blocks', array_merge( $core, $asen ) );
}
add_filter( 'allowed_block_types_all', 'asen_client_allowed_blocks', 10, 2 );

// Clients can't unlock locked blocks (the page banner, contentOnly pattern sections) or switch to the code editor.
function asen_client_editor_settings( $settings ) {
    if ( ! asen_user_is_builder() ) {
        $settings['canLockBlocks']      = false;
        $settings['codeEditingEnabled'] = false;
    }
    return $settings;
}
add_filter( 'block_editor_settings_all', 'asen_client_editor_settings' );

// New pages start with a banner that can't be moved or removed.
function asen_page_block_template( $args, $post_type ) {
    if ( 'page' === $post_type ) {
        $args['template'] = array(
            array( 'acf/asen-banner', array( 'lock' => array( 'move' => true, 'remove' => true ) ) ),
            array( 'core/paragraph' ),
        );
    }
    return $args;
}
add_filter( 'register_post_type_args', 'asen_page_block_template', 10, 2 );
