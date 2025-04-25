<?php if (
    get_field('products_archive_cta_form', 'option') ||
    get_field('services_archive_cta_form', 'option') ||
    get_field('team_archive_cta_form', 'option') ||
    get_field('page_footer_gravity_form')
) :
    $cta_heading;
    $cta_form;
    if ( get_field('products_archive_cta_form_is_default', 'option') ) {
        $cta_heading = get_field('products_archive_cta_heading', 'option');
        $cta_form = get_field('products_archive_cta_form', 'option');
    } else {
        $cta_heading = get_field('single_product_cta_heading', 'option');
        $cta_form = get_field('single_product_cta_form', 'option');
    }
?>
    <section class="asen-archive-form">
        <div class="inside">
            <?php if ( $cta_heading ) : ?>
                <h5 class="h3"><?php echo $cta_heading; ?></h5>
            <?php endif; ?>
            <?php if ( $cta_form ) : ?>
                <?php echo apply_shortcodes(
                    '[gravityform id="' . $cta_form .'" title="false" description="false" ajax="true"]'
                ); ?>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>