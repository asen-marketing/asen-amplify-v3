<?php

// Pattern files in /patterns are auto-registered by WordPress from their file headers.
// The category has to exist before core registers them (init priority 10), hence priority 9.
function asen_register_pattern_categories() {
    register_block_pattern_category( 'asen', array( 'label' => 'Asen' ) );
}
add_action( 'init', 'asen_register_pattern_categories', 9 );
