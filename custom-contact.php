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
                    <h5>Office</h5>
                    <?php if ( get_field('site_address_1', 'option') && get_field('site_city', 'option') && get_field('site_state', 'option') && get_field('site_zip', 'option') ) : ?>
                        <p>
                            <a href="https://www.google.com/maps/place/<?php the_field('site_address_1', 'option'); ?>,+<?php the_field('site_city', 'option'); ?>,+<?php the_field('site_state', 'option'); ?>+<?php the_field('site_zip', 'option'); ?>" title="Locate <?php echo $site_name; ?>" target="_blank">
                                <?php the_field('site_address_1', 'option');
                                    if ( get_field('site_address_2', 'option') ) : echo ' <br />' . get_field('site_address_2', 'option'); endif; ?><br />
                                <?php the_field('site_city', 'option'); ?>, <?php the_field('site_state', 'option'); ?> <?php the_field('site_zip', 'option'); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                    <?php if ( get_field('site_phone_number', 'option') ) : ?>
                        <p><a href="tel:<?php echo asen_clean_phone_number(get_field('site_phone_number', 'option')); ?>" title="Call <?php echo $site_name; ?>."><?php the_field('site_phone_number', 'option'); ?></a></p>
                    <?php endif; ?>
                    <?php if ( get_field('site_busines_hours', 'option') ) : ?>
                        <h5>Hours</h5>
                        <?php the_field('site_busines_hours', 'option'); ?>
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
