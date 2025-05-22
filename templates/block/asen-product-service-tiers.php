<?php
/**
 * Block Name: Asen Product and Service Tiers
 *
 * Every brochure site needs a product and/or services tier row.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

?>
<?php if ( have_rows('tiers') ) : ?>
<section class="asen-product-service-tiers asen-product-service-tiers-<?php echo $block['id']; echo $className; ?>">
    <div class="inside">
        <div class="items total-<?php echo count( get_field('tiers') ); ?>">
            <?php while ( have_rows('tiers') ) : the_row();
                    $index = get_row_index();
                    $item_styles = '';
                    $header_styles = '';
                    if ( get_sub_field('accent_color') ) {
                        $item_styles .= 'border-color: ' . get_sub_field('accent_color') . ';';
                        $header_styles .= 'background-color: ' . get_sub_field('accent_color') . ';';
                    }
                ?>
            <article class="item item-<?php echo $index; ?>" data-index="<?php echo $index; ?>"
                <?php echo ($item_styles != '' ? 'style="' . $item_styles . '"' : ''); ?>>
                <header <?php echo ($header_styles != '' ? 'style="' . $header_styles . '"' : ''); ?>>
                    <h6 class="label"><?php the_sub_field('label'); ?></h6>
                    <h3 class="heading"><?php the_sub_field('heading'); ?></h3>
                    <div class="subheading-copy">
                        <?php the_sub_field('subheading_copy'); ?>
                    </div>
                </header>
                <?php if ( have_rows('list_items') ) : ?>
                <section class="list-items">
                    <ul>
                        <?php while ( have_rows('list_items') ) : the_row();
                                        $index = get_row_index();
                                    ?>
                        <li><?php the_sub_field('item'); ?></li>
                        <?php endwhile; ?>
                    </ul>
                </section>
                <?php endif; ?>
                <?php 
                            $link = get_sub_field('button_link');
                            if ( $link ) : 
                                $link_url = $link['url'];
                                $link_title = $link['title'];
                                $link_target = $link['target'] ? $link['target'] : '_self';
                            ?>
                <footer class="action">
                    <a class="button" href="<?php echo esc_url( $link_url ); ?>"
                        target="<?php echo esc_attr( $link_target ); ?>"
                        data-service-name="<?php the_sub_field('hidden_gravity_forms_value'); ?>">
                        <?php echo esc_html( $link_title ); ?>
                    </a>
                </footer>
                <?php endif; ?>
            </article>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>