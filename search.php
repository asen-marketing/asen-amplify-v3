<?php get_header(); ?>

<main role="main">
    <div class="search-banner">
        <div class="inside">
            <h1 class="h3">Search results for &ldquo;<?php echo get_search_query(); ?>&rdquo;</h1>
            <?php echo get_search_form(); ?>
        </div>
    </div>
    <?php if (have_posts()) : ?>
        <div class="results">
            <div class="inside">
            <?php while (have_posts()) : the_post();
                $post_id = get_the_ID();
                $post_type = get_post_type( $post_id );
                $post_type_object = get_post_type_object( $post_type );
            ?>

                <article id="post-<?php the_ID(); ?>">
                    <header>
                        <h6 class="type"><?php echo $post_type_object->labels->name; ?></h6>
                        <h4 class="title"><?php the_title(); ?></h4>
                    </header>
                    <?php the_excerpt(); ?>
                    <footer>
                        <p><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read more&hellip;</a></p>
                    </footer>
                </article><!-- #post-<?php the_ID(); ?> -->
                
            <?php endwhile;?>
            <?php wp_pagenavi(); ?>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
