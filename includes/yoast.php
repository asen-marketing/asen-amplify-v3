<?php

// Disable Yoast SEO @Person schema on posts.
// Helps bad actors enumerate usernames.
add_filter( 'wpseo_schema_needs_author', '__return_false' );