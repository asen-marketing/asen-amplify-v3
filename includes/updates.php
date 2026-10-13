<?php
/**
 * Self-update from GitHub releases (plugin-update-checker, includes/vendor). Each release carries asen-amplify-v3.zip, built by
 * .github/workflows/release.yml; sites pick it up under Dashboard → Updates and WP-Cron installs it automatically.
 * Public repo, so no token needed; ASEN_AMPLIFY_GITHUB_TOKEN in wp-config.php only lifts GitHub's anonymous API rate limit.
 * Opt a site out of automatic installs with define( 'ASEN_AMPLIFY_DISABLE_AUTO_UPDATE', true );
 */

// A git checkout (local development) must never be replaced by a release zip.
if ( is_dir( get_template_directory() . '/.git' ) || ( function_exists( 'wp_is_development_mode' ) && wp_is_development_mode( 'theme' ) ) ) {
    return;
}

require_once __DIR__ . '/vendor/plugin-update-checker/plugin-update-checker.php';

$asen_update_checker = YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
    'https://github.com/asenmarketing/asen-amplify-v3/',
    get_template_directory(),
    'asen-amplify-v3'
);
$asen_update_checker->getVcsApi()->enableReleaseAssets( '/^asen-amplify-v3\.zip$/', YahnisElsts\PluginUpdateChecker\v5p7\Vcs\Api::REQUIRE_RELEASE_ASSETS );
if ( defined( 'ASEN_AMPLIFY_GITHUB_TOKEN' ) && ASEN_AMPLIFY_GITHUB_TOKEN ) {
    $asen_update_checker->setAuthentication( ASEN_AMPLIFY_GITHUB_TOKEN );
}

// Install this theme's updates automatically, the way WordPress handles minor core releases.
function asen_auto_update_parent_theme( $update, $item ) {
    if ( isset( $item->theme ) && 'asen-amplify-v3' === $item->theme ) {
        return ! ( defined( 'ASEN_AMPLIFY_DISABLE_AUTO_UPDATE' ) && ASEN_AMPLIFY_DISABLE_AUTO_UPDATE );
    }
    return $update;
}
add_filter( 'auto_update_theme', 'asen_auto_update_parent_theme', 10, 2 );
