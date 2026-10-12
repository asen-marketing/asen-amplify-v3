<?php
$site_name    = get_bloginfo( 'name', 'display' );
$logo_id      = get_field( 'site_footer_logo_image', 'option' );
$address_1    = get_field( 'site_address_1', 'option' );
$address_2    = get_field( 'site_address_2', 'option' );
$city         = get_field( 'site_city', 'option' );
$state        = get_field( 'site_state', 'option' );
$zip          = get_field( 'site_zip', 'option' );
$email        = get_field( 'site_email_address', 'option' );
$phone        = get_field( 'site_phone_number', 'option' );
$maps_link    = get_field( 'google_maps_link', 'option' );
$mailing_form = get_field( 'site_footer_mailing_list_enabled', 'option' ) ? get_field( 'site_footer_mailing_list_form', 'option' ) : false;
$has_address  = $address_1 && $city && $state && $zip;
?>

<footer class="site-footer standard<?php echo $mailing_form ? ' has-mailing-list' : ''; ?>">
    <div class="top">
        <div class="inside">
            <div class="column column-1">
                <a href="<?php echo esc_url( site_url( '/', 'https' ) ); ?>" title="<?php echo esc_attr( $site_name ); ?>">
                    <?php if ( $logo_id ) : ?>
                    <?php echo wp_get_attachment_image( $logo_id, 'large' ); ?>
                    <?php else : ?>
                    Add footer logo!
                    <?php endif; ?>
                </a>
                <?php if ( $address_1 || $email || $phone ) : ?>
                <div class="footer-contact-info">
                    <?php if ( $has_address ) :
                        $address_string = $address_1 . ', ' . $city . ', ' . $state . ' ' . $zip;
                        $maps_href      = $maps_link ? $maps_link : 'https://www.google.com/maps/place/' . rawurlencode( $address_string );
                    ?>
                    <p class="contact-address">
                        <a href="<?php echo esc_url( $maps_href ); ?>" title="Locate <?php echo esc_attr( $site_name ); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo esc_html( $address_1 ); ?><?php if ( $address_2 ) { echo ', ' . esc_html( $address_2 ); } ?><br />
                            <?php echo esc_html( $city ); ?>, <?php echo esc_html( $state ); ?> <?php echo esc_html( $zip ); ?>
                        </a>
                    </p>
                    <?php endif; ?>
                    <?php if ( $email ) : ?>
                    <p class="contact-email">
                        <a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>" title="Email <?php echo esc_attr( $site_name ); ?> about questions.">
                            <?php echo esc_html( antispambot( $email ) ); ?>
                        </a>
                    </p>
                    <?php endif; ?>
                    <?php if ( $phone ) : ?>
                    <p class="contact-phone">
                        <a href="tel:<?php echo esc_attr( asen_clean_phone_number( $phone ) ); ?>" title="Call <?php echo esc_attr( $site_name ); ?>.">
                            <?php echo esc_html( $phone ); ?>
                        </a>
                    </p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="column column-2">
                <?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
                <?php wp_nav_menu( array(
                    'container'      => '',
                    'menu_class'     => 'footer-menu',
                    'theme_location' => 'footer-menu',
                    'depth'          => 1,
                ) ); ?>
                <?php if ( has_nav_menu( 'footer-menu-2' ) ) : ?>
                <?php wp_nav_menu( array(
                    'container'      => '',
                    'menu_class'     => 'footer-menu-2',
                    'theme_location' => 'footer-menu-2',
                    'depth'          => 1,
                ) ); ?>
                <?php endif; ?>
                <?php if ( has_nav_menu( 'footer-menu-3' ) ) : ?>
                <?php wp_nav_menu( array(
                    'container'      => '',
                    'menu_class'     => 'footer-menu-3',
                    'theme_location' => 'footer-menu-3',
                    'depth'          => 1,
                ) ); ?>
                <?php endif; ?>
                <?php else : ?>
                <p>Create a menu called "Footer Menu"!</p>
                <?php endif; ?>
            </div>
            <?php if ( $mailing_form ) : ?>
            <div class="column column-3">
                <div class="footer-mailing-list-container <?php echo esc_attr( get_field( 'site_footer_mailing_list_submit_button_alignment', 'option' ) ); ?>">
                    <?php if ( get_field( 'site_footer_mailing_list_heading', 'option' ) ) : ?>
                    <h5><?php echo esc_html( get_field( 'site_footer_mailing_list_heading', 'option' ) ); ?></h5>
                    <p><?php echo esc_html( get_field( 'site_footer_mailing_list_sub_heading', 'option' ) ); ?></p>
                    <?php endif; ?>
                    <?php echo apply_shortcodes( '[gravityform id="' . intval( $mailing_form ) . '" title="false" description="false" ajax="true"]' ); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="bottom">
        <div class="inside">
            <p class="copyright">
                &copy; <?php echo date( 'Y' ); ?> <?php echo esc_html( $site_name ); ?>
                <?php the_field( 'font_awesome_separator_character', 'option' ); ?>
                <a class="privacy-link" href="/privacy/">Privacy Policy</a>
            </p>
            <?php get_template_part( 'templates/social/links' ); ?>
        </div>
    </div>
</footer>
