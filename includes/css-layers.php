<?php
/**
 * Cascade layers. scss/index.scss declares `vendor, reset, base, components, blocks, utilities`; here every stylesheet
 * WordPress or a plugin enqueues is imported into `vendor`, so the theme's layered CSS sits above core and plugin
 * defaults. Unlayered CSS (child theme, _custom.scss, inline block styles) still wins over everything.
 */

// Stylesheets that must stay unlayered: the theme's own (they declare the layer order), core-block-supports, which
// carries the layout values editors picked in the block sidebar and has to keep beating the theme, and logged-in
// toolbars (admin bar, plugins' admin-bar items, Query Monitor), whose ID-scoped rules would otherwise lose to the
// theme's plain ul/li/a rules — layer order beats specificity.
function asen_unlayered_style_handles() {
    return apply_filters( 'asen/unlayered_style_handles', array( 'main', 'core-block-supports', 'admin-bar', 'query-monitor' ) );
}

function asen_is_unlayered_style( $handle ) {
    return in_array( $handle, asen_unlayered_style_handles(), true ) || preg_match( '/admin-?bar/', $handle );
}

// <link rel="stylesheet"> → <style>@import url() layer(vendor)</style> for third-party stylesheets on the front end.
// Tags carrying SRI (integrity=) stay links: @import can't verify them. $href arrives HTML-escaped (&#038;), and entities
// aren't decoded inside <style>, so it's decoded first; esc_url_raw() still strips quotes and angle brackets.
function asen_layer_third_party_styles( $tag, $handle, $href, $media ) {
    if ( is_admin() || ! wp_style_is( 'main', 'enqueued' ) || asen_is_unlayered_style( $handle ) || str_contains( $tag, 'integrity=' ) ) {
        return $tag;
    }
    $url   = esc_url_raw( html_entity_decode( $href, ENT_QUOTES | ENT_HTML5 ) );
    $media = ( $media && 'all' !== $media ) ? ' ' . esc_attr( $media ) : '';
    return sprintf( "<style id=\"%s-css\">@import url(\"%s\") layer(vendor)%s;</style>\n", esc_attr( $handle ), $url, $media );
}
add_filter( 'style_loader_tag', 'asen_layer_third_party_styles', 20, 4 );

// Inline styles (global-styles presets, core per-block CSS, plugin variables) get wrapped in `vendor` right before they print.
function asen_layer_inline_styles() {
    if ( is_admin() || ! wp_style_is( 'main', 'enqueued' ) ) {
        return;
    }
    $styles = wp_styles();
    foreach ( $styles->registered as $handle => $dep ) {
        if ( asen_is_unlayered_style( $handle ) ) {
            continue;
        }
        $after = $styles->get_data( $handle, 'after' );
        if ( ! $after ) {
            continue;
        }
        $css = implode( "\n", (array) $after );
        if ( str_starts_with( ltrim( $css ), '@layer vendor{' ) ) {
            continue;
        }
        $styles->registered[ $handle ]->extra['after'] = array( '@layer vendor{' . $css . '}' );
    }
}
add_action( 'wp_print_styles', 'asen_layer_inline_styles', 1 );         // head
add_action( 'wp_print_footer_scripts', 'asen_layer_inline_styles', 1 ); // late styles (classic themes print global-styles here)
