<?php
/**
 * Block Name: Asen Featured Blogs
 *
 * Three posts, either the most recent or hand-picked, with an optional "See All Posts" tile.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}

if ( class_exists( 'ACF' ) === false ) return;

$posts_number_shown = 3;
$post_source        = get_field( 'post_source' ) ?: 'recent';
$handpicked_posts   = get_field( 'handpicked_posts' );
$show_cta_tile      = ! get_field( 'hide_cta_tile' ); // Inverted so blocks saved before this field existed keep the tile.
$cta_heading        = get_field( 'blog_archive_cta_heading' );

$query_args = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => $posts_number_shown,
    'ignore_sticky_posts' => true,
);

// Hand-picked falls back to recent when nothing is selected.
if ( 'handpicked' === $post_source && ! empty( $handpicked_posts ) ) {
    $query_args['post__in'] = array_map( 'intval', (array) $handpicked_posts );
    $query_args['orderby']  = 'post__in';
}

$blog_posts = new WP_Query( $query_args );

$classes = array(
    'asen-featured-blogs',
    'asen-featured-blogs-' . $block['id'],
    $show_cta_tile ? 'has-cta-tile' : '',
    $block['className'] ?? '',
);
?>

<section class="<?php echo esc_attr( implode( ' ', array_filter( $classes ) ) ); ?>"
    id="<?php echo esc_attr( $block['anchor'] ?? '' ); ?>">
    <div class="inside">
        <div class="posts-grid">
            <?php if ( $show_cta_tile ) : ?>
            <article class="asen-blog-single-teaser cta-teaser">
                <header>
                    <div class="teaser-image<?php echo has_post_thumbnail() ? ' has-thumb' : ''; ?>">
                        <?php if ( has_post_thumbnail() ) {
                            echo get_the_post_thumbnail( get_the_ID(), 'large' );
                        } ?>
                    </div>
                    <h2 class="cta-title"><?php echo esc_html( $cta_heading ); ?></h2>
                    <a class="cta-link" href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>"
                        title="Navigate to find all blog posts">
                        See All Posts <i class="fa-regular fa-circle-plus" aria-hidden="true"></i>
                    </a>
                </header>
            </article>
            <?php endif; ?>
            <?php
            while ( $blog_posts->have_posts() ) :
                $blog_posts->the_post();
                get_template_part( 'templates/blog/single-teaser' );
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>
