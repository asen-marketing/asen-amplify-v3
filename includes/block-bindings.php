<?php
// Site Options contact info as a block bindings source: {"source":"asen/site-option","args":{"key":"phone"}}.
// Clients edit the value once in Site Options; every bound block follows, and can't be edited on its own.

// Each key: label, plain text, escaped HTML, and the link it opens (or '').
function asen_contact_info() {
    static $info = null;
    if ( null !== $info ) {
        return $info;
    }

    $opt        = fn( $name ) => function_exists( 'get_field' ) ? trim( (string) get_field( $name, 'option' ) ) : '';
    $phone      = $opt( 'site_phone_number' );
    $email      = $opt( 'site_email_address' );
    $city_state = implode( ', ', array_filter( array( $opt( 'site_city' ), $opt( 'site_state' ) ) ) );
    $address    = array_values( array_filter( array(
        implode( ', ', array_filter( array( $opt( 'site_address_1' ), $opt( 'site_address_2' ) ) ) ),
        trim( $city_state . ' ' . $opt( 'site_zip' ) ),
    ) ) );
    $hours      = array_values( array_filter( array_map( 'trim', preg_split( '/\R/', $opt( 'site_hours' ) ) ) ) );

    $info = array(
        'phone'   => array(
            'label' => __( 'Phone', 'asen-amplify-v3' ),
            'text'  => $phone,
            'html'  => esc_html( $phone ),
            'url'   => $phone ? 'tel:' . asen_clean_phone_number( $phone ) : '',
        ),
        'email'   => array(
            'label' => __( 'Email', 'asen-amplify-v3' ),
            'text'  => $email,
            'html'  => esc_html( $email ),
            'url'   => is_email( $email ) ? 'mailto:' . $email : '',
        ),
        'address' => array(
            'label' => __( 'Address', 'asen-amplify-v3' ),
            'text'  => implode( ', ', $address ),
            'html'  => implode( '<br>', array_map( 'esc_html', $address ) ),
            'url'   => $address ? 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( implode( ', ', $address ) ) : '',
        ),
        'hours'   => array(
            'label' => __( 'Hours', 'asen-amplify-v3' ),
            'text'  => implode( ', ', $hours ),
            'html'  => implode( '<br>', array_map( 'esc_html', $hours ) ),
            'url'   => '',
        ),
    );
    return $info;
}

// What a key outputs depends on the attribute it's bound to: text content links itself, a button/image link gets the URL.
function asen_contact_binding_value( array $item, string $attribute ) {
    switch ( $attribute ) {
        case 'url':
            return $item['url'] ? $item['url'] : null;
        case 'content':
            return $item['url'] && $item['html'] ? sprintf( '<a href="%s">%s</a>', esc_url( $item['url'] ), $item['html'] ) : $item['html'];
        case 'text':
        case 'caption':
            return $item['html'];
        case 'alt':
        case 'title':
            return $item['text'];
    }
    return null;
}

function asen_site_option_binding_value( array $source_args, $block_instance, string $attribute_name ) {
    $info = asen_contact_info();
    $key  = $source_args['key'] ?? '';
    return isset( $info[ $key ] ) ? asen_contact_binding_value( $info[ $key ], $attribute_name ) : null;
}

function asen_register_block_bindings() {
    register_block_bindings_source( 'asen/site-option', array(
        'label'              => __( 'Site Options', 'asen-amplify-v3' ),
        'get_value_callback' => 'asen_site_option_binding_value',
    ) );
}
add_action( 'init', 'asen_register_block_bindings' );

// The editor gets the same resolved values, so bound blocks preview real data and the fields show in the Attributes panel.
function asen_enqueue_editor_bindings() {
    $fields = array();
    foreach ( asen_contact_info() as $key => $item ) {
        $values = array();
        foreach ( array( 'content', 'text', 'caption', 'url', 'alt', 'title' ) as $attribute ) {
            $values[ $attribute ] = asen_contact_binding_value( $item, $attribute );
        }
        $fields[ $key ] = array( 'label' => $item['label'], 'values' => $values );
    }

    $path = get_template_directory() . '/js/editor-bindings.js';
    wp_enqueue_script( 'asen-editor-bindings', get_template_directory_uri() . '/js/editor-bindings.js', array( 'wp-blocks' ), filemtime( $path ), true );
    wp_add_inline_script( 'asen-editor-bindings', 'window.asenSiteOptionBindings = ' . wp_json_encode( $fields ) . ';', 'before' );
}
add_action( 'enqueue_block_editor_assets', 'asen_enqueue_editor_bindings' );
