<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('soleng_revslider_theme_setup9')) {
	add_action( 'after_setup_theme', 'soleng_revslider_theme_setup9', 9 );
	function soleng_revslider_theme_setup9() {

		add_filter( 'soleng_filter_merge_styles',				'soleng_revslider_merge_styles' );
		
		if (is_admin()) {
			add_filter( 'soleng_filter_tgmpa_required_plugins','soleng_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'soleng_revslider_tgmpa_required_plugins' ) ) {
	
	function soleng_revslider_tgmpa_required_plugins($list=array()) {
		if (soleng_storage_isset('required_plugins', 'revslider')) {
			$path = soleng_get_file_dir('plugins/revslider/revslider.zip');
			if (!empty($path) || soleng_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> soleng_storage_get_array('required_plugins', 'revslider'),
					'slug' 		=> 'revslider',
                    'version'   => '6.2.2',
					'source'	=> !empty($path) ? $path : 'upload://revslider.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'soleng_exists_revslider' ) ) {
	function soleng_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}
	
// Merge custom styles
if ( !function_exists( 'soleng_revslider_merge_styles' ) ) {
	
	function soleng_revslider_merge_styles($list) {
		if (soleng_exists_revslider()) {
			$list[] = 'plugins/revslider/_revslider.scss';
		}
		return $list;
	}
}
?>