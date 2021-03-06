<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('soleng_mailchimp_get_css')) {
	add_filter('soleng_filter_get_css', 'soleng_mailchimp_get_css', 10, 4);
	function soleng_mailchimp_get_css($css, $colors, $fonts, $scheme='') {
		
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
form.mc4wp-form .mc4wp-form-fields input[type="email"] {
	{$fonts['input_font-family']}
	{$fonts['input_font-size']}
	{$fonts['input_font-weight']}
	{$fonts['input_font-style']}
	{$fonts['input_line-height']}
	{$fonts['input_text-decoration']}
	{$fonts['input_text-transform']}
	{$fonts['input_letter-spacing']}
}
form.mc4wp-form .mc4wp-form-fields input[type="submit"] {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}

CSS;
		
			
			$rad = soleng_get_border_radius();
			$css['fonts'] .= <<<CSS


CSS;
		}

		
		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

form.mc4wp-form .mc4wp-form-fields input[type="email"].filled,
form.mc4wp-form .mc4wp-form-fields input[type="email"]:hover,
form.mc4wp-form .mc4wp-form-fields input[type="email"]:focus {
	background-color: {$colors['bg_color']} !important;
	border-color: {$colors['text_link']} !important;
}

form.mc4wp-form .mc4wp-alert {
	color: {$colors['inverse_text']};
	background-color: {$colors['text_link']};
	border-color: {$colors['text_link']};
}
form.mc4wp-form .mc4wp-alert a{
	color: {$colors['inverse_link']};
}
form.mc4wp-form .mc4wp-alert a:hover{
	color: {$colors['text_link2']};
}

CSS;
		}

		return $css;
	}
}
?>