<?php
/**
 * Block Name: Asen WYSIWYG
 *
 * A traditional WYSIWYG block.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if ( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

?>

<div class="<?php echo $className; ?>" >

<?php
if ( get_field('asen_wysiwyg') ) {
    the_field('asen_wysiwyg');
} else {
    echo '<p style="color: red;">ENTER TEXT OR REMOVE THIS WYSIWYG BLOCK!</p>';
}
?>
 </div>