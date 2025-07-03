<?php
    $site_name = get_bloginfo('name', 'display');
    $site_tagline = get_bloginfo('description', 'display');
?>

<footer class="site-footer simple mailing-list layout-4">
    <div class="top">
        <div class="inside">
            <div
                class="footer-mailing-list-container <?php the_field('site_footer_mailing_list_submit_button_alignment', 'option'); ?>">
                <?php if ( get_field('site_footer_mailing_list_heading', 'option') ) : ?>
                <h5><?php the_field('site_footer_mailing_list_heading', 'option'); ?></h5>
                <p><?php the_field('site_footer_mailing_list_sub_heading', 'option'); ?></p>
                <?php endif; ?>
                <?php
                    if ( get_field('site_footer_mailing_list_form', 'option') ) :
                    $footer_gravity_form = get_field('site_footer_mailing_list_form', 'option');
                ?>
                <?php echo apply_shortcodes(
                        '[gravityform id="' . $footer_gravity_form .'" title="false" description="false" ajax="true"]'
                    ); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="bottom">
        <div class="inside">
            <div class="column column-1">
                <a href="<?php echo site_url( '/', 'https' ); ?>"
                    title="<?php echo get_bloginfo('name', 'display'); ?>">
                    <?php if ( get_field('site_footer_logo_image', 'option') ) : ?>
                    <?php echo wp_get_attachment_image( get_field('site_footer_logo_image', 'option'), 'large' ); ?>
                    <?php else : ?>
                    Add footer logo!
                    <?php endif; ?>
                </a>
            </div>
            <div class="column column-2">
                <p class="copyright">
                    &copy; <?php echo date('Y'); ?> <?php echo $site_name; ?>
                    <?php the_field('font_awesome_separator_character', 'option'); ?>
                    <a class="privacy-link" href="/privacy/">Privacy Policy</a>
                </p>
                <?php get_template_part('templates/social/links'); ?>
            </div>
        </div>
    </div>
</footer>