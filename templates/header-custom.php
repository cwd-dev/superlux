<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0.06
 */

$soleng_header_css = '';
$soleng_header_image = get_header_image();
$soleng_header_video = soleng_get_header_video();
if (!empty($soleng_header_image) && soleng_trx_addons_featured_image_override(is_singular() || soleng_storage_isset('blog_archive') || is_category())) {
	$soleng_header_image = soleng_get_current_mode_image($soleng_header_image);
}

$soleng_header_id = str_replace('header-custom-', '', soleng_get_theme_option("header_style"));
if ((int) $soleng_header_id == 0) {
	$soleng_header_id = soleng_get_post_id(array(
												'name' => $soleng_header_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$soleng_header_id = apply_filters('soleng_filter_get_translated_layout', $soleng_header_id);
}
$soleng_header_meta = get_post_meta($soleng_header_id, 'trx_addons_options', true);

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($soleng_header_id); 
				?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($soleng_header_id)));
				echo !empty($soleng_header_image) || !empty($soleng_header_video) 
					? ' with_bg_image' 
					: ' without_bg_image';
				if ($soleng_header_video!='') 
					echo ' with_bg_video';
				if ($soleng_header_image!='') 
					echo ' '.esc_attr(soleng_add_inline_css_class('background-image: url('.esc_url($soleng_header_image).');'));
				if (!empty($soleng_header_meta['margin']) != '') 
					echo ' '.esc_attr(soleng_add_inline_css_class('margin-bottom: '.esc_attr(soleng_prepare_css_value($soleng_header_meta['margin'])).';'));
				if (is_single() && has_post_thumbnail()) 
					echo ' with_featured_image';
				if (soleng_is_on(soleng_get_theme_option('header_fullheight'))) 
					echo ' header_fullheight soleng-full-height';
				if (!soleng_is_inherit(soleng_get_theme_option('header_scheme')))
					echo ' scheme_' . esc_attr(soleng_get_theme_option('header_scheme'));
				?>"><?php

	// Background video
	if (!empty($soleng_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('soleng_action_show_layout', $soleng_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>