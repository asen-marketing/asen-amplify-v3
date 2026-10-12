<?php get_header();

$banner_classes = '';
$banner_styles = '';

?>

<main role="main">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article class="team-member-post" id="post-<?php the_ID(); ?>">
                <div class="inside">
                    <div class="left">
                        <?php echo wp_get_attachment_image( get_field('team_member_image'), 'large' ); ?>
                        <?php if (
                            get_field('team_member_email_address') ||
                            get_field('team_member_phone_number')
                        ) : ?>
                            <ul>
                                <?php if ( get_field('team_member_email_address') ) : ?>
                                    <li>
                                        <a
                                            href="mailto:<?php the_field('team_member_email_address'); ?>"
                                            title="Email <?php the_title(); ?>"
                                        >
                                            <?php the_field('team_member_email_address'); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if ( get_field('team_member_phone_number') ) : ?>
                                    <li>
                                        <a
                                            href="tel:<?php echo asen_clean_phone_number(get_field('team_member_phone_number')); ?>"
                                            title="Call <?php the_title(); ?>"
                                        >
                                            <?php the_field('team_member_phone_number'); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div class="right">
                        <header>
                            <h1><?php the_title(); ?></h1>
                            <p><?php the_field('team_member_position'); ?></p>
                        </header>
                        <section>
                            <?php the_field('team_member_bio'); ?>
                        </section>
                    </div>
                </div>
            </article><!-- #post-<?php the_ID(); ?> -->
            <?php get_template_part('templates/bottom-form'); ?>
        <?php endwhile;?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
