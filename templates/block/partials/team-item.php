<?php
/**
 * Team member card for the Team Hub (templates/block/partials/collection.php).
 */

$post     = $args['post'];
$image    = get_field( 'team_member_image', $post->ID );
$position = get_field( 'team_member_position', $post->ID );
?>
<article class="team-item">
    <?php if ( $image ) : ?>
    <div class="item-media"><?php echo wp_get_attachment_image( $image, 'large' ); ?></div>
    <?php endif; ?>
    <div class="item-copy">
        <h3 class="item-title"><?php echo esc_html( get_the_title( $post ) ); ?></h3>
        <?php if ( $position ) : ?>
        <p class="item-meta"><?php echo esc_html( $position ); ?></p>
        <?php endif; ?>
    </div>
</article>
