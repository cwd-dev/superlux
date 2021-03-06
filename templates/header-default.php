<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

$soleng_header_css = '';
$soleng_header_image = get_header_image();
$soleng_header_video = soleng_get_header_video();
if (!empty($soleng_header_image) && soleng_trx_addons_featured_image_override(is_singular() || soleng_storage_isset('blog_archive') || is_category())) {
	$soleng_header_image = soleng_get_current_mode_image($soleng_header_image);
}

?><header class="top_panel top_panel_default<?php
					echo !empty($soleng_header_image) || !empty($soleng_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($soleng_header_video!='') echo ' with_bg_video';
					if ($soleng_header_image!='') echo ' '.esc_attr(soleng_add_inline_css_class('background-image: url('.esc_url($soleng_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (soleng_is_on(soleng_get_theme_option('header_fullheight'))) echo ' header_fullheight soleng-full-height';
					if (!soleng_is_inherit(soleng_get_theme_option('header_scheme')))
						echo ' scheme_' . esc_attr(soleng_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($soleng_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (soleng_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Mobile header
	if (soleng_is_on(soleng_get_theme_option("header_mobile_enabled"))) {
		get_template_part( 'templates/header-mobile' );
	}
	
	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );

?></header>