<?php
    $post_type = get_post_type_object( get_post_type() );
    $title = $post_type->label;
    $slug = $post_type->name;
    $singular_title = $post_type->labels->singular_name;
?>
<article class="asen-archive grid-layout-<?php the_field($slug . '_archive_items_layout', 'option'); ?>">
    <?php get_template_part('templates/interior-banner'); ?>
    <div class="items">
        <div class="inside">
            <?php if ( get_field($slug . '_archive_list', 'option') ) : ?>
                <?php foreach ( get_field($slug . '_archive_list', 'option') as $key => $item ) :
                    $image_slug = '';
                    $teaser_blurb_slug = '';
                    if ( $slug === 'team' ) {
                        $image_slug = 'team_member_image';
                        $teaser_blurb_slug = 'team_member_position';
                    } else if ( $slug === 'products' ) {
                        $image_slug = 'product_image';
                        $teaser_blurb_slug = 'product_price';
                    } else if ( $slug === 'services' ) {
                        $image_slug = 'service_image';
                        $teaser_blurb_slug = 'service_short_description';
                    }
                ?>
                    <article class="asen-archive-item archive-item-<?php echo $item; ?>" id="post-<?php echo $item; ?>">
                        <a
                            href="<?php echo get_the_permalink($item); ?>"
                            title="Learn more about the <?php echo $singular_title . ' ' . get_the_title( $item ) ?>"
                        >
                            <header>
                                <span class="thumb" <?php echo $image_attribute; ?>>
                                    <?php echo wp_get_attachment_image( get_field($image_slug, $item), 'large' ); ?>
                                    <span class="overlay"></span>
                                </span>
                                <span class="copy">
                                    <h3><?php echo get_the_title( $item ); ?></h3>
                                    <p><?php the_field( $teaser_blurb_slug, $item ); ?></p>
                                </span>
                            </header>
                        </a>
                    </article>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Add items under <?php echo $title; ?> -> Archive Settings in the backend!</p>
            <?php endif; ?>
        </div>
    </div>
</article>
<?php if ( get_field($slug . '_archive_cta_form', 'option') ) : ?>
<section class="asen-archive-form">
    <div class="inside">
        <?php if ( get_field($slug . '_archive_cta_heading', 'option') ) : ?>
            <h5 class="h3"><?php the_field($slug . '_archive_cta_heading', 'option'); ?></h5>
        <?php endif; ?>
        <?php if ( get_field($slug . '_archive_cta_form', 'option') ) :
            $cta_gravity_form = get_field($slug . '_archive_cta_form', 'option');
        ?>
            <?php echo apply_filters( 'the_content',
                '[gravityform id="' . $cta_gravity_form .'" title="false" description="false" ajax="true"]'
            ); ?>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>