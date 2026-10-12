<?php
/**
 * Block Name: Asen Background Graphic
 *
 * Add a graphic for Asen 2020 to any container block.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . ' #' . get_field('anchor_name') .'</h3>';
} else {
    $className = '';
    if ( !empty($block['className']) ) {
        $className .= ' ' . $block['className'];
    }
    ?><div class="asen-anchor <?php echo $className;?>" id="<?php the_field('anchor_name'); ?>"></div><?php
}