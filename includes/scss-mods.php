<?php
function asen_global_scss() {

    $file = 'wp-content/themes/amplify2020/scss/_global-variables.scss';
    
    $file_lines = file('wp-content/themes/amplify2020/scss/_global-variables.scss');
    
    if (get_field('primary_site_color', 'option')) {
        $file_lines[0] = '$site-primary-color:' . get_field('site_primary_color', 'option') . ';';
    }
    if (get_field('secondary_site_color', 'option')) {
        $file_lines[1] = '$site-secondary-color:' . get_field('site_secondary_color', 'option') . ';';
    }
    if (get_field('accent_site_color', 'option')) {
        $file_lines[2] = '$site-accent-color:' . get_field('site_accent_color', 'option') . ';';
    }
    if (get_field('site_text_color', 'option')) {
        $file_lines[3] = '$site-text-color:' . get_field('site_text_color', 'option') . ';';
    }
    
    file_put_contents($file, implode("\n", $file_lines));
}

add_action('wp_head', 'asen_global_scss', 1);

?>