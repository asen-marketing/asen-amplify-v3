<?php
    $url = get_the_permalink( get_the_ID() );
    $blurb = get_the_title();
    $featured_image = '';
    if ( has_post_thumbnail() ) {
        $featured_image = wp_get_attachment_url( get_post_thumbnail_id() );
    }
    $site_name = get_bloginfo('name', 'display');
?>

<ul class="site-social share">
    <li>
        <a 
            href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>"
            title="Share on Facebook" 
            target="_blank"
            rel="noreferrer noopener"
        >
            <i class="fa-brands fa-facebook-f"></i>
        </a>
    </li>
    <li>
        <a 
            href="https://www.linkedin.com/shareArticle?url=<?php echo $url; ?>&title=<?php echo urlencode($blurb); ?>" 
            title="Share on Linkedin" 
            target="_blank"
            rel="noreferrer noopener"
        >
            <i class="fa-brands fa-linkedin-in"></i>
        </a>
    </li>
    <li>
        <a 
            href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>&text=<?php echo urlencode($blurb); ?>" 
            title="Share on X Twitter" 
            target="_blank"
            rel="noreferrer noopener"
        >
            <i class="fa-brands fa-x-twitter"></i>
        </a>
    </li>
    <li>
        <a 
            href="https://pinterest.com/pin/create/button/?url=<?php echo $url; ?>" 
            title="Share on Pinterest" 
            target="_blank"
            rel="noreferrer noopener"
        >
            <i class="fa-brands fa-pinterest-p"></i>
        </a>
    </li>
    <?php 
        $email_subject_string = 'Check out this article by ' . $site_name . ': ' . $blurb;
        $email_body_string = 'Check out this article by ' . $site_name . ', ' . $blurb . '. URL: ' . $url . ' ';
    ?>
    <li>
        <a 
            href="mailto:?subject=<?php echo $email_subject_string; ?>&body=<?php echo $email_body_string; ?>" 
            title="Share via Email" 
            target="_blank"
            rel="noreferrer noopener"
        >
            <i class="fa-regular fa-envelope"></i>
        </a>
    </li>
</ul>
