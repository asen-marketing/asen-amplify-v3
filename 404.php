<?php get_header(); ?>

<main role="main">
    <article id="post-0" <?php post_class('et_pb_post not_found page'); ?>>
        <div class="entry">
            <h1><?php the_field('site_404_page_title', 'option'); ?></h1>
            <?php if (get_field('site_404_page_blurb', 'option')) : ?>
                <p><?php the_field('site_404_page_blurb', 'option'); ?></p>
            <?php endif; ?>

            <div class="widget_search">
                <?php get_search_form(true); ?>
            </div>

            <?php if (has_nav_menu('primary-menu')) : ?>
                <nav class="not-found-menu">
                    <?php wp_nav_menu(array(
                        'menu' => 'Primary Menu',
                        'container' => '',
                        'menu_class' => 'primary-menu',

                    )); ?>
                </nav>
            <?php else : ?>
                <p>Create a menu called "Primary Menu"!</p>
            <?php endif; ?>
        </div>
    </article> <!-- .et_pb_post -->
</main>

<?php get_footer(); ?>