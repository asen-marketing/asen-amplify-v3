<?php
    $site_name = get_bloginfo('name', 'display');
    $site_tagline = get_bloginfo('description', 'display');
?>

<footer class="site-footer layout-3">
    <div class="top">
        <div class="inside">
            <div class="row row-1">
                <a href="<?php echo site_url( '/', 'https' ); ?>" title="<?php echo get_bloginfo('name', 'display'); ?>">
                    <?php if ( get_field('site_footer_logo_image', 'option') ) : ?>
                        <?php echo wp_get_attachment_image( get_field('site_footer_logo_image', 'option'), 'large' ); ?>
                    <?php else : ?>
                        Add footer logo!
                    <?php endif; ?>
                </a>
            </div>
            <div class="row row-2">
                <?php 
                    if ( get_field('site_address_1', 'option') && get_field('site_city', 'option') && get_field('site_state', 'option') && get_field('site_zip', 'option') ) :
                    $footer_site_address_string = get_field('site_address_1', 'option') . ', ' . get_field('site_city', 'option') . ', ' . get_field('site_state', 'option') . ' ' . get_field('site_zip', 'option');
                ?>
                    <p>
                        <a 
                            <?php if (get_field('google_maps_link', 'option')) : ?>
                                href="<?php the_field('google_maps_link', 'option'); ?>" 
                            <?php else : ?>
                                href="https://www.google.com/maps/place/<?php echo urlencode($footer_site_address_string); ?>" 
                            <?php endif; ?>
                            title="Locate <?php echo $site_name; ?>" 
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <?php the_field('site_address_1', 'option');
                                if ( get_field('site_address_2', 'option') ) : echo ', ' . get_field('site_address_2', 'option'); endif; ?><br />
                            <?php the_field('site_city', 'option'); ?>, <?php the_field('site_state', 'option'); ?> <?php the_field('site_zip', 'option'); ?>
                        </a>
                    </p>
                <?php endif; ?>
                <?php if ( get_field('site_email_address', 'option') ) : ?>
                    <p>
                        <a href="mailto:<?php echo esc_html( antispambot(get_field('site_email_address', 'option')) ); ?>" title="Email <?php echo $site_name; ?> about questions.">
                            <?php echo esc_html( antispambot(get_field('site_email_address', 'option')) ); ?>
                        </a>
                    </p>
                <?php endif; ?>                   
                <?php if ( get_field('site_phone_number', 'option') ) : ?>
                    <p>
                        <a href="tel:<?php echo asen_clean_phone_number(get_field('site_phone_number', 'option')); ?>" title="Call <?php echo $site_name; ?>.">
                            <?php the_field('site_phone_number', 'option'); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>
            <div class="row row-3">
                <?php get_template_part('templates/social/links'); ?>
            </div>
        </div>
    </div>
    <div class="bottom">
        <div class="inside">
            <p class="copyright">
                &copy; Copyright <?php echo date('Y'); ?> <?php echo $site_name; ?> 
                <?php the_field('font_awesome_separator_character', 'option'); ?>
                <a class="privacy-link" href="/privacy/">Privacy Policy</a>        
            </p>
        </div>
    </div>
</footer>
