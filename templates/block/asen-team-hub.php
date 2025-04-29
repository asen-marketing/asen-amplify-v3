<?php
/**
 * Block Name: Asen Team Hub
 *
 * Displays team CPT as a grid or carousel.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$team_members = get_field('team_members');
?>

<section class="asen-team-hub asen-team-hub-<?php echo $block['id']; echo $className; ?>">
    <div class="inside<?php echo get_field('use_carousel') ? ' carousel' : ' grid'; ?>">
        <?php if ($team_members) : ?>
        <?php foreach( $team_members as $index => $team_member ): 
                $name = get_the_title( $team_member->ID );
                $image = get_field( 'team_member_image', $team_member->ID );
                $position = get_field( 'team_member_position', $team_member->ID );
                $bio = get_field( 'team_member_bio', $team_member->ID );
                ?>
        <div class="team-item">
            <h3><?php echo $name; ?></h3>
            <?php echo wp_get_attachment_image($image, 'full'); ?>
            <h4><?php echo $position; ?></h4>
            <p><?php echo $bio; ?></p>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php if (!get_field('use_carousel')) : ?>

<style>
.asen-team-hub .inside.grid .team-item {
    width: calc(100% / <?php echo get_field('number_of_columns'); ?> + (2rem / <?php echo get_field('number_of_columns'); ?>) - 2rem);
}
</style>

<?php else : ?>
<script defer>
(function($) {

})(jQuery)
</script>
<?php endif; ?>