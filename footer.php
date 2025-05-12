            </div><!-- .main-content -->
            <?php 
                if ( class_exists('ACF') ) :
                    if (
                        is_page_template('custom-blank.php') == false && 
                        get_field('site_footer_layout', 'option') == 'standard'
                    ) : 
                        get_template_part(
                            'templates/footer/footer-layout',
                            get_field('site_footer_layout', 'option')
                        );
                    endif;

                    if (
                        is_page_template('custom-blank.php') == false && 
                        get_field('site_footer_layout', 'option') == 'simple'
                    ) : 
                        get_template_part(
                            'templates/footer/footer-layout',
                            get_field('site_footer_layout', 'option')
                        );
                    endif;

                    if (
                        is_page_template('custom-blank.php') == false && 
                        get_field('site_footer_layout', 'option') == 'standard-mailing-list'
                    ) : 
                        get_template_part(
                            'templates/footer/footer-layout',
                            get_field('site_footer_layout', 'option')
                        );
                    endif;

                    if (
                        is_page_template('custom-blank.php') == false && 
                        get_field('site_footer_layout', 'option') == 'simple-mailing-list'
                    ) : 
                        get_template_part(
                            'templates/footer/footer-layout',
                            get_field('site_footer_layout', 'option')
                        );
                    endif;
                endif;
            ?>

            <?php if (get_field('enable_floating_cta', 'option')) : ?>
            <?php get_template_part( 'templates/fixed-contact-cta-button' ); ?>
            <?php endif; ?>
            </div><!-- .site-container -->

            <?php 
            if ( class_exists('ACF') ) :
                if ( is_page_template('custom-blank.php') == false ) : 
                    get_template_part('templates/menu/off-canvas');
                endif;
            endif;
        ?>

            <?php wp_footer(); ?>
            </body>

            </html>