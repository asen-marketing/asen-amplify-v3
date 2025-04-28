            </div><!-- .main-content -->
            <?php 
                if ( class_exists('ACF') ) :
                    if (
                        is_page_template('custom-blank.php') == false && 
                        get_field('site_footer_layout', 'option')
                    ) : 
                        get_template_part(
                            'templates/footer/footer-layout',
                            get_field('site_footer_layout', 'option')
                        );
                    endif;
                endif;
            ?>
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