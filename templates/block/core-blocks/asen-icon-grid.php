<?php
/**
 * Block Name: Asen Icon Grid
 *
 * A CTA grid made especially for icons.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
?>
<?php if ( have_rows('items') ) : ?>
    <section class="asen-icon-grid asen-icon-grid-<?php echo $block['id']; echo $className; ?>">
        <div class="inside">
            <div class="items">
                <?php while ( have_rows('items') ) : the_row();
                    $index = get_row_index();
                    $link = (get_sub_field('use_custom_url') == true ? get_sub_field('link_custom') : get_the_permalink(get_sub_field('link_wordpress')));
                ?>
                    <article class="item item-<?php echo $index; echo ($index == 1 ? ' is-active' : ''); ?>" data-index="<?php echo $index; ?>">
                        <?php if ( !is_admin() && get_sub_field('link_target') != 'none' ) : ?>
                        <a
                            href="<?php echo $link; ?>"
                            title="<?php if ( get_sub_field('text') ) : the_sub_field('text'); else : echo 'Learn More'; endif; ?>"
                            <?php echo (get_sub_field('link_target') == '_blank' ? 'target="_blank"' : ''); ?>
                        >
                        <?php endif; ?>
                            <?php echo wp_get_attachment_image( get_sub_field('icon'), 'large' ); ?>
                            <?php if ( get_sub_field('text') ) : ?>
                                <p class="text">
                                    <?php the_sub_field('text'); ?>
                                </p>
                            <?php endif; ?>
                        <?php if ( !is_admin() && get_sub_field('link_target') != 'none' ) : ?>
                        </a>
                        <?php endif; ?>
                    </article>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <?php if ( is_admin() ) : ?>
        <style>
            .asen-icon-grid-<?php echo $block['id']; ?> .inside .items {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            .asen-icon-grid-<?php echo $block['id']; ?> .item {
                width: 23%;
                margin: 0 1% 10px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
            }
            @media (max-width: 1024px) {
                .asen-icon-grid-<?php echo $block['id']; ?> .item {
                    width: 31%;
                }
            }
            @media (max-width: 540px) {
                .asen-icon-grid-<?php echo $block['id']; ?> .item {
                    width: 48%;
                }
            }
            @media (max-width: 480px) {
                .asen-icon-grid-<?php echo $block['id']; ?> .item {
                    width: 100%;
                    margin: 0 0 10px;
                }
            }
        </style>
    <?php endif; ?>
<?php endif; ?>