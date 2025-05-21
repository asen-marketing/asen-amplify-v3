<?php
/**
 * Block Name: Asen Buttons Group
 *
 * Buttons grouped in a container for control.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if ( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
$styles = '';

?>
<?php if ( !have_rows('buttons') && is_admin() ) : ?>
<p>Add buttons!</p>
<?php endif; ?>
<?php if ( !is_admin() ) : ?>
<section class="asen-buttons-group buttons-group-<?php echo $block['id']; echo $className; ?>"
    <?php echo ($styles != '' ? 'style="' . $styles . '"' : ''); ?>>
    <?php endif; ?>
    <?php while ( have_rows('buttons') ) : the_row();
        $button_link = get_sub_field('link');
    ?>
    <a class="button asen-button <?php the_sub_field('custom_classes'); ?>" href="<?php echo $button_link['url']; ?>"
        title="<?php echo $button_link['title']; ?>" target="<?php echo $button_link['target']; ?>">
        <?php if ( isset($button_link['title']) ) : echo $button_link['title']; else : echo 'ADD BUTTON TEXT'; endif; ?>
    </a>
    <?php endwhile; ?>
    <?php if ( !is_admin() ) : ?>
</section>
<?php endif; ?>