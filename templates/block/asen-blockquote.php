<?php
/**
 * Block Name: Asen Blockquote Row
 *
 * A blockquote row that looks great with Asen 2020.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
?>
<?php if ( get_field('text') ) : ?>
<div class="asen-blockquote asen-blockquote-<?php echo $block['id']; echo $className; ?>">
    <div class="inside">
        <blockquote class="<?php the_field('text_size'); ?>">
            <p>&ldquo;<?php the_field('text'); ?>&rdquo;</p>
            <?php if ( get_field('attribution') ) : ?>
                <cite>&#8213; <?php the_field('attribution'); ?></cite>
            <?php endif; ?>
        </blockquote>
    </div>
</div>
<?php endif; ?>