<?php

$blog_main_classes = '';

// if (
//     is_active_sidebar( 'blog_sidebar' ) ||
//     class_exists('ACF') && 
//     get_field('blog_archive_categories', 'option') ||
//     class_exists('ACF') && 
//     get_field('blog_archive_search', 'option') 
// ) {
//     $blog_main_classes .= ' blog-has-sidebar';
// }

?>

<main role="main" class="<?php echo $blog_main_classes; ?>">
    <div class="inside">
        <div class="blog-header">
            <h1 class="blog-feed-heading"><?php the_field('blog_feed_page_heading', 'option'); ?></h1>
            <p class="blog-feed-sub-heading"><?php the_field('blog_feed_page_sub_heading', 'option'); ?></p>
        </div>
        <div class="top-row">
            <div class="categories-dropdown">
                <form>
                    <?php
                    $cta_category_select_id = wp_unique_id('categories-dropdown-');
                    $cta_category_select_default_text = 'Filter by Category';

                    if ( is_category() ) {
                        $cta_category_select_default_text = 'All Posts';
                    }

                    $cta_category_select_args = [
                        'show_option_all'    => $cta_category_select_default_text,
                        'orderby'            => 'name',
                        'name'               => 'categories-dropdown',
                        'class'              => 'cta-category-select'
                    ];
                    wp_dropdown_categories($cta_category_select_args);
                ?>
                </form>
                <script type="text/javascript">
                var dropdown = document.getElementById("<?php echo $cta_category_select_id; ?>");

                function onCatChange() {
                    if (dropdown.options[dropdown.selectedIndex].value > 0) {
                        location.href = "<?php echo esc_url( home_url( '/' ) ); ?>?cat=" + dropdown.options[
                            dropdown.selectedIndex].value;
                    } else {
                        location.href = "<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>";
                    }
                }
                dropdown.onchange = onCatChange;
                </script>
            </div>

            <?php
            /**
             * The searchform.php template.
             *
             * Used any time that get_search_form() is called.
             *
             * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
             *
             * @package WordPress
             * @subpackage Twenty_Twenty
             * @since 1.0.0
             */

            /*
            * Generate a unique ID for each form and a string containing an aria-label if
            * one was passed to get_search_form() in the args array.
            */
            $unique_id = twentytwenty_unique_id( 'search-form-' );

            $aria_label = ! empty( $args['label'] ) ? 'aria-label="' . esc_attr( $args['label'] ) . '"' : '';
            ?>
            <form role="search"
                <?php echo $aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. ?>
                method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <label for="<?php echo esc_attr( $unique_id ); ?>">
                    <span
                        class="screen-reader-text"><?php _e( 'Search for:', 'twentytwenty' ); // phpcs:ignore: WordPress.Security.EscapeOutput.UnsafePrintingFunction -- core trusts translations ?></span>
                    <input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="search-field"
                        placeholder="Search blog&hellip;" value="<?php echo get_search_query(); ?>" name="s" />
                </label>
                <input type="hidden" name="post_type" value="post" />
                <button type="submit" class="button search-submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span class="sr-only">Search</span>
                </button>
            </form>

        </div>

        <div class="posts">
            <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('templates/blog/single-teaser'); ?>
            <?php endwhile;?>
            <?php endif; ?>
        </div>
        <?php wp_pagenavi(); ?>
    </div>
</main>