        </div><!-- .main-content -->
        <?php if ( class_exists( 'ACF' ) && ! is_page_template( 'custom-blank.php' ) ) {
            get_template_part( 'templates/footer/footer' );
        } ?>

        <?php if ( get_field( 'enable_floating_cta', 'option' ) ) {
            get_template_part( 'templates/fixed-contact-cta-button' );
        } ?>
    </div><!-- .site-container -->

    <?php if ( class_exists( 'ACF' ) && ! is_page_template( 'custom-blank.php' ) ) {
        get_template_part( 'templates/menu/off-canvas' );
    } ?>

    <?php wp_footer(); ?>
</body>

</html>
