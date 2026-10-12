<?php

// DEBUG PRINT_R
function asen_debug_print($var) {

	$type = get_debug_type($var);

	$result = '<div class="asen-debug">';
	$result .= '<h5><span>Variable type:</span> ' . $type . '</h5>';

	if (
		isset($var) == false
	) {
		$result .= '<pre>isset() tests false.</pre>';
	} else if (
		$type == 'null'
	) {
		$result .= '<pre>Variable is null!</pre>';
	} else if (
		empty($var) && 
		$var == 0
	) {
		$result .= '<pre>empty() tests true, but is a <strong>' . $type . '</strong> zero.</pre>';
	} else if (
		empty($var)
	) {
		$result .= '<pre>empty() tests true.</pre>';
	} else if (
		$type == 'string'
	) {
		$var = print_r($var, true);
		$result .= '<pre><strong>"</strong>' . esc_html($var) . '<strong>"</strong></pre>';
	} else {
		$var = print_r($var, true);
		$result .= '<pre>' . esc_html($var) . '</pre>';
	}

	$result .= '</div>';

	echo $result;
}
