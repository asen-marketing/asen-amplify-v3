<?php
/**
 * Block Name: Asen Icon + Copy Grid
 *
 * A CTA grid made up of icons with headings and copy.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$link_type = get_field('link_type_options');

?>
<?php if ( have_rows('copy_text_blocks') ) : ?>
<section class="asen-icon-copy-grid asen-icon-copy-grid-<?php echo $block['id']; echo $className; ?>">
    <div class="inside">
        <div class="items <?php the_field('block_background_options'); ?> <?php the_field('link_type_options'); ?>">
            <?php while ( have_rows('copy_text_blocks') ) : the_row(); ?>
            <div class="item">
                <?php the_sub_field('icon'); ?>
                <div class="copy">
                    <h4><?php the_sub_field('heading'); ?></h4>
                    <p><?php the_sub_field('copy'); ?></p>
                </div>
                <?php 
                        $link = get_sub_field('link');
                        if( $link &&  $link_type !== 'invisible-link'): 
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self';
                            ?>
                <a class="asen-text-link" href="<?php echo esc_url( $link_url ); ?>"
                    target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?> <i
                        class="fa-regular fa-circle-plus"></i></a>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>