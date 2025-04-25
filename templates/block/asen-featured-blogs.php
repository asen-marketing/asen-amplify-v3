<?php
/**
 * Block Name: Asen Featured Blogs
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

if ( class_exists('ACF') === false ) return; 

$className = '';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}

$posts_number_shown = 2;

$blog_posts = new WP_Query([
    'posts_per_page' => $posts_number_shown
]);

?>

<?php if (is_admin()) : ?>

<pre><?php print_r(get_fields()); ?></pre>

<?php else : ?>
<section class="asen-featured-blogs asen-featured-blogs-<?php echo $block['id']; echo $className; ?>">
    <div class="inside">
        <div class="posts-grid">
            <article class="asen-blog-single-teaser cta-teaser">
                <header>
                    <div class="teaser-image<?php if (has_post_thumbnail()) : echo ' has-thumb'; endif; ?>">
                        <?php if ( has_post_thumbnail() ) :
                                echo get_the_post_thumbnail( get_the_ID(), 'large' );
                            endif; ?>
                    </div>
                    <h2 class="cta-title">
                        <?php the_field('blog_archive_cta_heading'); ?>
                    </h2>
                    <a class="cta-link" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"
                        title="Navigate to find all blog posts">
                        See All Posts <i class="fa-regular fa-circle-plus" aria-hidden="true"></i>
                    </a>
                </header>
            </article>
            <?php
                    while ( $blog_posts->have_posts() ) :
                        $blog_posts->the_post();
                        get_template_part('templates/blog/single-teaser');
                    endwhile;
                    wp_reset_query();
                ?>
        </div>
    </div>
</section>

<?php endif; ?>