<?php get_header(); ?>

<main role="main" class="<?php echo ( is_active_sidebar( 'woo-sidebar' ) && is_shop() || is_active_sidebar( 'woo-sidebar' ) && is_product_category() ) ? 'has-sidebar' : 'no-sidebar' ?>">
    <div class="woo-content">
        <?php woocommerce_content(); ?>
    </div>
    <?php if (
        is_active_sidebar( 'woo-sidebar' ) && is_shop() ||
        is_active_sidebar( 'woo-sidebar' ) && is_product_category()
        ) : ?>
        <aside class="woo-sidebar">
            <?php dynamic_sidebar( 'woo-sidebar' ); ?>
        </aside>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
