<?php
/**
 * Block Name: Asen - Team Hub
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

$container_width = get_field( '__container_width' ) ?: 'xl';
$heading_size    = get_field( '__heading_size' ) ?: 'h6';

$classes = array( 'asen-team-hub', 'block-width-' . $container_width, 'has-item-heading-' . $heading_size );
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) ); ?>>
    <div class="inside">
        <?php get_template_part( 'templates/block/partials/collection', null, array(
            'items'         => get_field( 'team_members' ),
            'item_template' => 'templates/block/partials/team-item',
            'layout'        => get_field( 'use_carousel' ) ? 'carousel' : 'grid',
            'columns'       => get_field( 'number_of_columns' ) ?: 3,
            'label'         => 'Team members',
        ) ); ?>
    </div>
</section>
