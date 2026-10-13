<?php if ( get_field('site_header_cta_option', 'option') == 'button') : ?>
<?php 
    $link = get_field('site_header_cta_link', 'option');
    if ( $link ) : 
        $link_url = $link['url'];
        $link_title = $link['title'];
        $link_target = $link['target'] ? $link['target'] : '_self';
    ?>
<a class="button button-small cta-header" href="<?php echo esc_url( $link_url ); ?>"
    target="<?php echo esc_attr( $link_target ); ?>">
    <?php echo esc_html( $link_title ); ?>
</a>
<?php endif; ?>
<?php elseif ( get_field('site_header_cta_option', 'option') == 'phone' ) : ?>
<?php $phone = asen_contact_info()['phone']; ?>
<?php if ( $phone['url'] ) : ?>
<a class="button button-small button-no-background button-phone"
    href="<?php echo esc_url( $phone['url'] ); ?>"
    title="Call <?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
    <?php echo $phone['html']; ?>
</a>
<?php else : ?>
<p>Set a phone number!</p>
<?php endif; ?>
<?php elseif ( get_field('site_header_cta_option', 'option') == 'social' ) : ?>
<?php get_template_part('templates/social/links'); ?>
<?php endif; ?>