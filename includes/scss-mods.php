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
    
    // $site_colors = get_field('site_colors', 'option');
    // $p_small = get_field('p_small', 'option');
    // $p_medium = get_field('p_medium', 'option');
    // $p_large = get_field('p_large', 'option');
    // $p_xlarge = get_field('p_xlarge', 'option');
    // $h1 = get_field('h1', 'option');
    // $h2 = get_field('h2', 'option');
    // $h3 = get_field('h3', 'option');
    // $h4 = get_field('h4', 'option');
    // $h5 = get_field('h5', 'option');
    // $h6 = get_field('h6', 'option');

    // $file = 'wp-content/themes/amplify2020/scss/_global-variables.scss';
    
    // $file_lines = file('wp-content/themes/amplify2020/scss/_global-variables.scss');
    
    // print_r($site_colors);
    // if (have_rows($site_colors)) {
    //     while (have_rows($site_colors)) {
            // if (get_sub_field('site_primary_color')) {
            //     $file_lines[0] = '$site-primary-color:' . get_sub_field('site_primary_color') . ';';
            // }
            // if (get_sub_field('site_secondary_color')) {
            //     $file_lines[1] = '$site-secondary-color:' . get_sub_field('site_secondary_color') . ';';
            // }
            // if (get_sub_field('site_accent_color')) {
            //     $file_lines[2] = '$site-accent-color:' . get_sub_field('site_accent_color') . ';';
            // }
            // if (get_sub_field('site_text_color')) {
            //     $file_lines[3] = '$site-text-color:' . get_sub_field('site_text_color') . ';';
            // }
    //     }
    // }
    // if (have_rows($p_small)) {
    //     while (have_rows($p_small)) {
    //         if (get_sub_field('font_size')) {
    //             $file_lines[4] = '$p-small-size:' . get_sub_field('font_size') . ';';
    //         }
    //         if (get_sub_field('font_weight')) {
    //             $file_lines[5] = '$p-small-weight:' . get_sub_field('font_weight') . ';';
    //         }
    //     }
    // }
    // if (have_rows($p_medium)) {
    //     while (have_rows($p_medium)) {
    //         if (get_sub_field('font_size')) {
    //             $file_lines[6] = '$p-medium-size:' . get_sub_field('font_size') . ';';
    //         }
    //         if (get_sub_field('font_weight')) {
    //             $file_lines[7] = '$p-medium-weight:' . get_sub_field('font_weight') . ';';
    //         }
    //     }
    // }
    // if (have_rows($p_large)) {
    //     while (have_rows($p_large)) {
    //         if (get_sub_field('font_size')) {
    //             $file_lines[8] = '$p-large-size:' . get_sub_field('font_size') . ';';
    //         }
    //         if (get_sub_field('font_weight')) {
    //             $file_lines[9] = '$p-large-weight:' . get_sub_field('font_weight') . ';';
    //         }
    //     }
    // }
    // if (have_rows($p_xlarge)) {
    //     while (have_rows($p_xlarge)) {
    //         if (get_sub_field('font_size')) {
    //             $file_lines[10] = '$p-xlarge-size:' . get_sub_field('font_size') . ';';
    //         }
    //         if (get_sub_field('font_weight')) {
    //             $file_lines[11] = '$p-xlarge-weight:' . get_sub_field('font_weight') . ';';
    //         }
    //     }
    // }
    // if (have_rows($h1)) {
    //     while (have_rows($h1)) {
    //         if (get_sub_field('font_size')) {
    //             $file_lines[12] = '$h1-size:' . get_sub_field('font_size') . ';';
    //         }
    //         if (get_sub_field('font_weight')) {
    //             $file_lines[13] = '$h1-weight:' . get_sub_field('font_weight') . ';';
    //         }
    //     }
    // }
    // if (have_rows($h2)) {
    //     while (have_rows($h2)) {
    //         if (get_sub_field('font_size')) {
    //             $file_lines[14] = '$h2-size:' . get_sub_field('font_size') . ';';
    //         }
    //         if (get_sub_field('font_weight')) {
    //             $file_lines[15] = '$h2-weight:' . get_sub_field('font_weight') . ';';
    //         }
    //     }
    // }
    // if (have_rows($h3)) {
    //     while (have_rows($h3)) {
    //         if (get_sub_field('font_size')) {
    //             $file_lines[16] = '$h3-size:' . get_sub_field('font_size') . ';';
    //         }
    //         if (get_sub_field('font_weight')) {
    //             $file_lines[17] = '$h3-weight:' . get_sub_field('font_weight') . ';';
    //         }
    //     }
    // }
    // if (have_rows($h4)) {
    //     while (have_rows($h4)) {
    //         if (get_sub_field('font_size')) {
    //             $file_lines[18] = '$h4-size:' . get_sub_field('font_size') . ';';
    //         }
    //         if (get_sub_field('font_weight')) {
    //             $file_lines[19] = '$h4-weight:' . get_sub_field('font_weight') . ';';
    //         }
    //     }
    // }
    // if (have_rows($h5)) {
    //     while (have_rows($h5)) {
    //         if (get_sub_field('font_size')) {
    //             $file_lines[20] = '$h5-size:' . get_sub_field('font_size') . ';';
    //         }
    //         if (get_sub_field('font_weight')) {
    //             $file_lines[21] = '$h5-weight:' . get_sub_field('font_weight') . ';';
    //         }
    //     }
    // }
    // if (have_rows($h6)) {
    //     while (have_rows($h6)) {
    //         if (get_sub_field('font_size')) {
    //             $file_lines[22] = '$h6-size:' . get_sub_field('font_size') . ';';
    //         }
    //         if (get_sub_field('font_weight')) {
    //             $file_lines[23] = '$h6-weight:' . get_sub_field('font_weight') . ';';
    //         }
    //     }
    // }
    
    // file_put_contents($file, implode($file_lines));
}

add_action('wp_head', 'asen_global_scss', 1);

?>