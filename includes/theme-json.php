<?php
/**
 * theme.json support: editor styles, and preset-only controls for non-Asen users.
 */

function asen_theme_json_setup() {
    add_theme_support( 'editor-styles' );
    add_editor_style( 'css/editor.css' );
    add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'asen_theme_json_setup' );

// Builders are Asen staff; everyone else is a client editing content.
function asen_user_is_builder() {
    $email  = wp_get_current_user()->user_email;
    $domain = $email ? substr( strrchr( $email, '@' ), 1 ) : '';
    return (bool) apply_filters( 'asen/is_builder', 'asenmarketing.com' === $domain );
}

// Clients pick from the palette and presets only; builders keep the custom inputs. Settings only, so front-end CSS is identical for everyone.
function asen_theme_json_client_settings( $theme_json ) {
    if ( asen_user_is_builder() ) {
        return $theme_json;
    }
    return $theme_json->update_with( array(
        'version'  => 3,
        'settings' => array(
            'color'      => array( 'custom' => false, 'customGradient' => false, 'customDuotone' => false ),
            'spacing'    => array( 'customSpacingSize' => false ),
            'typography' => array( 'customFontSize' => false ),
            'layout'     => array( 'allowCustomContentAndWideSize' => false ),
        ),
    ) );
}
add_filter( 'wp_theme_json_data_theme', 'asen_theme_json_client_settings' );

// theme.json is the only palette. When Kadence Blocks' saved palette has colors (its 3.8 design tokens write a default one),
// it adds them, plus WP's legacy default colors, to the editor, the theme.json palette and ACF swatches. Every one of those
// reads this option, so read it as empty. A child that wants Kadence's palette: add_filter( 'asen/allow_kadence_palette', '__return_true' ).
function asen_empty_kadence_palette( $value ) {
    if ( apply_filters( 'asen/allow_kadence_palette', false ) ) {
        return $value;
    }
    $colors = json_decode( (string) $value, true );
    if ( ! is_array( $colors ) || empty( $colors['palette'] ) ) {
        return $value;
    }
    $colors['palette'] = array();
    return wp_json_encode( $colors );
}
add_filter( 'option_kadence_blocks_colors', 'asen_empty_kadence_palette' );
