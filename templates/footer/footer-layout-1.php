<?php
    $site_name = get_bloginfo('name', 'display');
    $site_tagline = get_bloginfo('description', 'display');
?>

<footer class="site-footer layout-1">
    <div class="top">
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
                <?php if ( has_nav_menu('footer-menu') ) : ?>
                <?php wp_nav_menu(array(
                        'menu' => 'Footer Menu',
                        'container' => '',
                        'menu_class' => 'footer-menu',
                        'theme_location' => 'footer-menu',
                        'depth' => 1
                    )); ?>
                <?php if (has_nav_menu('footer-menu-2')) : ?>
                <?php wp_nav_menu(array(
                        'container' => '',
                        'menu_class' => 'footer-menu-2',
                        'theme_location' => 'footer-menu-2',
                        'depth' => 1
                    )); ?>
                <?php endif; ?>
                <?php else : ?>
                <p>Create a menu called "Footer Menu"! </p>
                <?php endif; ?>
            </div>
            <?php if (get_field('footer_mailing_list', 'option')) : ?>
            <div class="column column-3">
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
            <?php endif; ?>
        </div>
    </div>
    <div class="bottom">
        <div class="inside">
            <p class="copyright">
                &copy; Copyright <?php echo date('Y'); ?> <?php echo $site_name; ?>
                <?php the_field('font_awesome_separator_character', 'option'); ?>
                <a class="privacy-link" href="/privacy/">Privacy Policy</a>
            </p>
            <?php get_template_part('templates/social/links'); ?>
        </div>
    </div>
</footer>