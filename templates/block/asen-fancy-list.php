<?php
/**
 * Block Name: Asen Fancy List
 *
 * A two column block with fancy block, background, and layout.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
$thumbSize = 'medium';
$listClass = '';
if ( get_field('select_list_style') === 'icon' ) {
    $listClass = 'type-icon fa-ul';
} elseif ( get_field('select_list_style') === 'image' ) {
    $listClass = 'type-image';
} elseif ( get_field('select_list_style') === 'number' ) {
    $listClass = 'type-number';
}

if ( is_admin() ) {
    $thumbSize = 'thumb';
}
?>

<div class="asen-fancy-list asen-fancy-list-<?php echo $block['id']; echo $className; ?>">    
    <div class="inside">
        <?php if ( have_rows('list') ) : ?>
            <ul class="<?php echo $listClass; ?>">
            <?php while( have_rows('list') ): the_row(); ?>
                <li>
                    <?php if ( get_field('select_list_style') === 'icon' ) : ?>
                        <?php if ( is_admin() ) : ?>
                            <code><?php the_sub_field('list_item_icon'); ?></code> 
                        <?php else : ?>
                            <i class="fa-li <?php the_sub_field('list_item_icon'); ?>"></i>
                        <?php endif; ?>
                    <?php elseif ( get_field('select_list_style') === 'image' ) : ?>
                        <?php
                            $image = get_sub_field('list_item_image');
                            echo wp_get_attachment_image( $image, $thumbSize );
                        ?>
                    <?php elseif ( get_field('select_list_style') === 'number' ) : ?>
                        <span class="number"><?php the_sub_field('list_item_number'); ?></span>
                    <?php endif; ?>
                    <p class="copy"><?php the_sub_field('list_item_copy'); ?></p>
                </li>
            <?php endwhile; ?>
            </ul>
        <?php else : ?>
            <p>No list items set.</p>
        <?php endif; ?>
    </div>
</div>