<?php
/**
 * Block Name: Asen Split Fancy Copy
 *
 * A two column block with fancy block, background, and layout.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
$boxClassName = '';
$copyClassName = '';
$thumbSize = 'asen-full-screen';
if ( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if ( get_field('box_gradient') && get_field('box_gradient') != 'none' ) {
    $boxClassName .= ' ' . get_field( 'box_gradient' );
}
if ( get_field('copy_size') ) {
    $copyClassName .= ' ' . get_field( 'copy_size' );
}
if ( is_admin() ) {
    $thumbSize = 'medium';
}
?>

<section class="asen-split-fancy-content asen-split-fancy-content-<?php echo $block['id']; echo $className; ?>">
    <div class="background-layer">
        <?php if ( get_field('background_image') ) : ?>
            <?php echo wp_get_attachment_image( get_field('background_image'), $thumbSize ); ?>
        <?php endif; ?>
        <div class="overlay"></div>
    </div>
    <div class="inside">
        <header class="text-enlarge <?php echo $boxClassName; ?>">
            <?php the_field('box_copy'); ?>
        </header>
        <div class="copy <?php echo $copyClassName; ?>"">
            <?php the_field('copy'); ?>
        </div>
    </div>
</section>