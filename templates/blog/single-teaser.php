<article class="asen-blog-single-teaser" id="post-<?php the_ID(); ?>">
    <?php if ( !is_admin() ) : ?>
    <a href="<?php the_permalink(); ?>" title="Go read: <?php the_title(); ?>">
    <?php endif; ?>
        <header>
            <?php if ( !is_admin() ) : ?>
            <div class="banner <?php if (has_post_thumbnail()) : echo ' has-thumb'; endif; ?>">
                <div class="image">
                    <?php if ( has_post_thumbnail() ) :
                        echo get_the_post_thumbnail( get_the_ID(), 'large' );
                    endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <h2 class="entry-title">
                <?php the_title(); ?>
            </h2>

            <div class="meta">
                <?php if ( !is_admin() ) : ?>
                    <?php echo asen_get_primary_category(null, false); ?> 
                    <span class="separator">|</span>
                <?php endif; ?>
                <time datetime="<?php echo get_the_date('Y-m-d H:i'); ?>" pubdate>
                    <?php echo get_the_date(); ?>
                </time>
               
            </div>
        </header>
    <?php if ( !is_admin() ) : ?>
    </a>
    <?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->