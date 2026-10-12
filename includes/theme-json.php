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
