<?php /* Template Name: Contact Page */
get_header();

$site_name = get_bloginfo( 'name', 'display' );

?>

<main role="main">

    <article class="asen-contact-page">
        <?php get_template_part( 'templates/block/partials/banner', null, asen_banner_defaults( array( 'title' => get_the_title() ) ) ); ?>
        <section class="primary-copy">
            <div class="columns">
                <div class="left">
                    <h3><?php the_field('form_heading'); ?></h3>
                    <?php if ( get_field('contact_form') ) :
                        $gravity_form = get_field('contact_form');
                    ?>
                        <?php echo apply_filters( 'the_content',
                            '[gravityform id="' . $gravity_form .'" title="false" description="false" ajax="true"]'
                        ); ?>
                    <?php endif; ?>
                </div>
                <div class="right">
                    <?php $contact = asen_contact_info(); ?>
                    <h5>Office</h5>
                    <?php if ( $contact['address']['html'] ) : ?>
                        <p><a href="<?php echo esc_url( $contact['address']['url'] ); ?>" title="Locate <?php echo esc_attr( $site_name ); ?>" target="_blank" rel="noopener noreferrer"><?php echo $contact['address']['html']; ?></a></p>
                    <?php endif; ?>
                    <?php if ( $contact['phone']['url'] ) : ?>
                        <p><a href="<?php echo esc_url( $contact['phone']['url'] ); ?>" title="Call <?php echo esc_attr( $site_name ); ?>"><?php echo $contact['phone']['html']; ?></a></p>
                    <?php endif; ?>
                    <?php if ( $contact['hours']['html'] ) : ?>
                        <h5>Hours</h5>
                        <p><?php echo $contact['hours']['html']; ?></p>
                    <?php endif; ?>
                    <?php if ( have_rows('site_social_media_selection', 'option') ) : ?>
                        <h5>Social</h5>
                        <?php get_template_part('templates/social/links'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php if (get_the_content() != '' ) : ?>
        <section>
            <?php the_content(); ?>
        </section>
        <?php endif; ?>
    </article>

</main>

<?php get_footer(); ?>
