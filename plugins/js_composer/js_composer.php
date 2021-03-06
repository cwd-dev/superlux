<?php
/* WPBakery PageBuilder support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('soleng_vc_theme_setup9')) {
	add_action( 'after_setup_theme', 'soleng_vc_theme_setup9', 9 );
	function soleng_vc_theme_setup9() {
		
		add_filter( 'soleng_filter_merge_styles',		'soleng_vc_merge_styles' );

		if (soleng_exists_visual_composer()) {
	
			// Add/Remove params in the standard VC shortcodes
			//-----------------------------------------------------
			add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,	'soleng_vc_add_params_classes', 10, 3 );
			add_filter( 'vc_iconpicker-type-fontawesome',	'soleng_vc_iconpicker_type_fontawesome' );
			
			// Color scheme
			$scheme = array(
				"param_name" => "scheme",
				"heading" => esc_html__("Color scheme", 'soleng'),
				"description" => wp_kses_data( __("Select color scheme to decorate this block", 'soleng') ),
				"group" => esc_html__('Colors', 'soleng'),
				"admin_label" => true,
				"value" => array_flip(soleng_get_list_schemes(true)),
				"type" => "dropdown"
			);
			$sc_list = apply_filters('soleng_filter_add_scheme_in_vc', array('vc_section', 'vc_row', 'vc_row_inner', 'vc_column', 'vc_column_inner', 'vc_column_text'));
			foreach ($sc_list as $sc)
				vc_add_param($sc, $scheme);

			// Color scheme
			$param = array(
				"param_name" => "row_padding_table",
				"heading" => esc_html__("Extra padding", 'soleng'),
				"description" => wp_kses_data( __("Extra padding on resolution under 1279px", 'soleng') ),
				"group" => esc_html__('Paddings', 'soleng'),
				'edit_field_class' => 'vc_col-sm-4',
				"admin_label" => true,
				"std" => "0",
				"value" => array(esc_html__("Yes", 'soleng') => "1" ),
				"type" => "checkbox"
			);
			vc_add_param("vc_row", $param);
			vc_add_param("vc_row_inner", $param);

			// Alter height and hide on mobile for Empty Space
			vc_add_param("vc_empty_space", array(
				"param_name" => "alter_height",
				"heading" => esc_html__("Alter height", 'soleng'),
				"description" => wp_kses_data( __("Select alternative height instead value from the field above", 'soleng') ),
				"admin_label" => true,
				"value" => array(
					esc_html__('Tiny', 'soleng') => 'tiny',
					esc_html__('Small', 'soleng') => 'small',
					esc_html__('Medium', 'soleng') => 'medium',
					esc_html__('Large', 'soleng') => 'large',
					esc_html__('Huge', 'soleng') => 'huge',
					esc_html__('From the value above', 'soleng') => 'none'
				),
				"type" => "dropdown"
			));
			
			// Add Narrow style to the Progress bars
			vc_add_param("vc_progress_bar", array(
				"param_name" => "narrow",
				"heading" => esc_html__("Narrow", 'soleng'),
				"description" => wp_kses_data( __("Use narrow style for the progress bar", 'soleng') ),
				"std" => 0,
				"value" => array(esc_html__("Narrow style", 'soleng') => "1" ),
				"type" => "checkbox"
			));
			
			// Add param 'Closeable' to the Message Box
			vc_add_param("vc_message", array(
				"param_name" => "closeable",
				"heading" => esc_html__("Closeable", 'soleng'),
				"description" => wp_kses_data( __("Add 'Close' button to the message box", 'soleng') ),
				"std" => 0,
				"value" => array(esc_html__("Closeable", 'soleng') => "1" ),
				"type" => "checkbox"
			));
		}
		if (is_admin()) {
			add_filter( 'soleng_filter_tgmpa_required_plugins', 'soleng_vc_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'soleng_vc_tgmpa_required_plugins' ) ) {
	
	function soleng_vc_tgmpa_required_plugins($list=array()) {
		if (soleng_storage_isset('required_plugins', 'js_composer')) {
			$path = soleng_get_file_dir('plugins/js_composer/js_composer.zip');
			if (!empty($path) || soleng_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> soleng_storage_get_array('required_plugins', 'js_composer'),
					'slug' 		=> 'js_composer',
                    'version'   => '6.1',
					'source'	=> !empty($path) ? $path : 'upload://js_composer.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if WPBakery PageBuilder installed and activated
if ( !function_exists( 'soleng_exists_visual_composer' ) ) {
	function soleng_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if WPBakery PageBuilder in frontend editor mode
if ( !function_exists( 'soleng_vc_is_frontend' ) ) {
	function soleng_vc_is_frontend() {
		return (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true')
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline');
	}
}
	
// Merge custom styles
if ( !function_exists( 'soleng_vc_merge_styles' ) ) {
	
	function soleng_vc_merge_styles($list) {
		if (soleng_exists_visual_composer()) {
			$list[] = 'plugins/js_composer/_js_composer.scss';
		}
		return $list;
	}
}
	
// Add theme icons to the VC iconpicker list
if ( !function_exists( 'soleng_vc_iconpicker_type_fontawesome' ) ) {
	
	function soleng_vc_iconpicker_type_fontawesome($icons) {
		$list = soleng_get_list_icons();
		if (!is_array($list) || count($list) == 0) return $icons;
		$rez = array();
		foreach ($list as $icon)
			$rez[] = array($icon => str_replace('icon-', '', $icon));
		return array_merge( $icons, array(esc_html__('Theme Icons', 'soleng') => $rez) );
	}
}



// Shortcodes support
//------------------------------------------------------------------------

// Add params to the standard VC shortcodes
if ( !function_exists( 'soleng_vc_add_params_classes' ) ) {
	
	function soleng_vc_add_params_classes($classes, $sc, $atts) {
		// Add color scheme
		if (in_array($sc, apply_filters('soleng_filter_add_scheme_in_vc', array('vc_section', 'vc_row', 'vc_row_inner', 'vc_column', 'vc_column_inner', 'vc_column_text')))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$classes .= ($classes ? ' ' : '') . 'scheme_' . $atts['scheme'];
			if (!empty($atts['row_padding_table']) && !trx_addons_is_inherit($atts['row_padding_table']))
				$classes .= ($classes ? ' ' : '') . 'sc_layouts_row_padding_table';			
		}
		// Add other specific classes
		if (in_array($sc, array('vc_empty_space'))) {
			if (!empty($atts['alter_height']) && !soleng_is_off($atts['alter_height']))
				$classes .= ($classes ? ' ' : '') . 'height_' . $atts['alter_height'];
		} else if (in_array($sc, array('vc_progress_bar'))) {
			if (!empty($atts['narrow']) && (int) $atts['narrow']==1)
				$classes .= ($classes ? ' ' : '') . 'vc_progress_bar_narrow';
		} else if (in_array($sc, array('vc_message'))) {
			if (!empty($atts['closeable']) && (int) $atts['closeable']==1)
				$classes .= ($classes ? ' ' : '') . 'vc_message_box_closeable';
		}
		return $classes;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (soleng_exists_visual_composer()) { require_once SOLENG_THEME_DIR . 'plugins/js_composer/js_composer-styles.php'; }
?>