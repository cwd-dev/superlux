<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('soleng_wpml_get_css')) {
	add_filter('soleng_filter_get_css', 'soleng_wpml_get_css', 10, 4);
	function soleng_wpml_get_css($css, $colors, $fonts, $scheme='') {
		
		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

CSS;
		}

		return $css;
	}
}
?>