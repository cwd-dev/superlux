<?php
/* Theme-specific action to configure ThemeREX Addons components
------------------------------------------------------------------------------- */


/* ThemeREX Addons components
------------------------------------------------------------------------------- */
if (!function_exists('soleng_trx_addons_theme_specific_setup1')) {
	add_filter( 'trx_addons_filter_components_editor', 'soleng_trx_addons_theme_specific_components');
	function soleng_trx_addons_theme_specific_components($enable=false) {
		return SOLENG_THEME_FREE
					? false		// Free version
					: false;		// Pro version or Developer mode
	}
}

if (!function_exists('soleng_trx_addons_theme_specific_setup1')) {
	add_action( 'after_setup_theme', 'soleng_trx_addons_theme_specific_setup1', 1 );
	function soleng_trx_addons_theme_specific_setup1() {
		if (soleng_exists_trx_addons()) {
			add_filter( 'trx_addons_cv_enable',					'soleng_trx_addons_cv_enable');
			add_filter( 'trx_addons_demo_enable',				'soleng_trx_addons_demo_enable');
			add_filter( 'trx_addons_filter_edd_themes_market',	'soleng_trx_addons_edd_themes_market_enable');
			add_filter( 'trx_addons_cpt_list',					'soleng_trx_addons_cpt_list');
			add_filter( 'trx_addons_sc_list',					'soleng_trx_addons_sc_list');
			add_filter( 'trx_addons_widgets_list',				'soleng_trx_addons_widgets_list');
		}
	}
}

// CV
if ( !function_exists( 'soleng_trx_addons_cv_enable' ) ) {
	
	function soleng_trx_addons_cv_enable($enable=false) {
		// To do: return false if theme not use CV functionality
		return SOLENG_THEME_FREE
					? false		// Free version
					: true;		// Pro version
	}
}

// Demo mode
if ( !function_exists( 'soleng_trx_addons_demo_enable' ) ) {
	
	function soleng_trx_addons_demo_enable($enable=false) {
		// To do: return false if theme not use Demo functionality
		return SOLENG_THEME_FREE
					? false		// Free version
					: true;		// Pro version
	}
}

// EDD Themes market
if ( !function_exists( 'soleng_trx_addons_edd_themes_market_enable' ) ) {
	
	function soleng_trx_addons_edd_themes_market_enable($enable=false) {
		// To do: return false if theme not Themes market functionality
		return SOLENG_THEME_FREE
					? false		// Free version
					: true;		// Pro version
	}
}


// API
if ( !function_exists( 'soleng_trx_addons_api_list' ) ) {
	
	function soleng_trx_addons_api_list($list=array()) {
		// To do: Enable/Disable Third-party plugins API via add/remove it in the list

		// If it's a free version - leave only basic set
		if (SOLENG_THEME_FREE) {
			$free_api = array('instagram_feed', 'siteorigin-panels', 'woocommerce', 'contact-form-7');
			foreach ($list as $k=>$v) {
				if (!in_array($k, $free_api)) {
					unset($list[$k]);
				}
			}
		}
		return $list;
	}
}


// CPT
if ( !function_exists( 'soleng_trx_addons_cpt_list' ) ) {
	
	function soleng_trx_addons_cpt_list($list=array()) {
		// To do: Enable/Disable CPT via add/remove it in the list

		// If it's a free version - leave only basic set
		if (SOLENG_THEME_FREE) {
			$free_cpt = array('layouts', 'portfolio', 'post', 'services', 'team', 'testimonials');
			foreach ($list as $k=>$v) {
				if (!in_array($k, $free_cpt)) {
					unset($list[$k]);
				}
			}
		}
		return $list;
	}
}

// Shortcodes
if ( !function_exists( 'soleng_trx_addons_sc_list' ) ) {
	
	function soleng_trx_addons_sc_list($list=array()) {
		// To do: Add/Remove shortcodes into list
		// If you add new shortcode - in the theme's folder must exists /trx_addons/shortcodes/new_sc_name/new_sc_name.php

		// If it's a free version - leave only basic set
		if (SOLENG_THEME_FREE) {
			$free_shortcodes = array('action', 'anchor', 'blogger', 'button', 'form', 'icons', 'price', 'promo', 'socials');
			foreach ($list as $k=>$v) {
				if (!in_array($k, $free_shortcodes)) {
					unset($list[$k]);
				}
			}
		}
		return $list;
	}
}

// Widgets
if ( !function_exists( 'soleng_trx_addons_widgets_list' ) ) {
	
	function soleng_trx_addons_widgets_list($list=array()) {
		// To do: Add/Remove widgets into list
		// If you add widget - in the theme's folder must exists /trx_addons/widgets/new_widget_name/new_widget_name.php

		// If it's a free version - leave only basic set
		if (SOLENG_THEME_FREE) {
			$free_widgets = array('aboutme', 'banner', 'contacts', 'flickr', 'popular_posts', 'recent_posts', 'slider', 'socials');
			foreach ($list as $k=>$v) {
				if (!in_array($k, $free_widgets)) {
					unset($list[$k]);
				}
			}
		}
		return $list;
	}
}

// Add mobile menu to the plugin's cached menu list
if ( !function_exists( 'soleng_trx_addons_menu_cache' ) ) {
	add_filter( 'trx_addons_filter_menu_cache', 'soleng_trx_addons_menu_cache');
	function soleng_trx_addons_menu_cache($list=array()) {
		if (in_array('#menu_main', $list)) $list[] = '#menu_mobile';
		$list[] = '.menu_mobile_inner > nav > ul';
		return $list;
	}
}

// Add theme-specific vars into localize array
if (!function_exists('soleng_trx_addons_localize_script')) {
	add_filter( 'soleng_filter_localize_script', 'soleng_trx_addons_localize_script' );
	function soleng_trx_addons_localize_script($arr) {
		$arr['alter_link_color'] = soleng_get_scheme_color('alter_link');
		return $arr;
	}
}


// Shortcodes support
//------------------------------------------------------------------------

// Add new output types (layouts) in the shortcodes
if ( !function_exists( 'soleng_trx_addons_sc_type' ) ) {
	add_filter( 'trx_addons_sc_type', 'soleng_trx_addons_sc_type', 10, 2);
	function soleng_trx_addons_sc_type($list, $sc) {
		// To do: check shortcode slug and if correct - add new 'key' => 'title' to the list
		if ($sc == 'trx_sc_title') {
			$list['default alter'] = esc_html__('Alter', 'soleng');
			$list['2'] = esc_html__('Style 2', 'soleng');
		}	
		if ($sc == 'trx_sc_layouts_menu') {
			$list['default alter'] = esc_html__('Alter', 'soleng');
		}	
		if ($sc == 'trx_sc_services') {
			$list['image'] = esc_html__('Image', 'soleng');
			$list['listing'] = esc_html__('Listing', 'soleng');
		}	
		if ($sc == 'trx_sc_icons') {
			$list['image'] = esc_html__('Image', 'soleng');
			$list['leftpos'] = esc_html__('Icon position Left', 'soleng');
			$list['rightpos'] = esc_html__('Icon position Right', 'soleng');
		}	
		if ($sc == 'trx_sc_button') {
			$list['iconed'] = esc_html__('Icon', 'soleng');
		}	
		return $list;
	}
}

// Add new styles to content
if ( !function_exists( 'soleng_filter_widget_args' ) ) {
	add_filter( 'trx_addons_filter_widget_args', 'soleng_filter_widget_args', 10, 3);
	function soleng_filter_widget_args($list, $instance, $sc) {
		
		if (in_array($sc, array('trx_addons_widget_contacts'))){
			$socials_label = isset($instance['socials_label']) ? $instance['socials_label'] : '';

			$list['socials_label'] = $socials_label;
		}
		
		return $list;
	}
}

// Add params to the default shortcode's atts
if ( !function_exists( 'soleng_trx_addons_sc_atts' ) ) {
	add_filter( 'trx_addons_sc_atts', 'soleng_trx_addons_sc_atts', 10, 2);
	function soleng_trx_addons_sc_atts($atts, $sc) {
		
		// Param 'scheme'
		if (in_array($sc, array('trx_sc_action', 'trx_sc_blogger', 'trx_sc_cars', 'trx_sc_courses', 'trx_sc_content', 'trx_sc_dishes',
								'trx_sc_events', 'trx_sc_form',	'trx_sc_googlemap', 'trx_sc_portfolio', 'trx_sc_price', 'trx_sc_promo',
								'trx_sc_properties', 'trx_sc_services', 'trx_sc_team', 'trx_sc_testimonials', 'trx_sc_title',
								'trx_widget_audio', 'trx_widget_twitter', 'trx_sc_layouts_container')))
			$atts['scheme'] = 'inherit';
		// Param 'color_style'
		if (in_array($sc, array('trx_sc_action', 'trx_sc_blogger', 'trx_sc_cars', 'trx_sc_courses', 'trx_sc_content', 'trx_sc_dishes',
								'trx_sc_events', 'trx_sc_form',	'trx_sc_googlemap', 'trx_sc_portfolio', 'trx_sc_price', 'trx_sc_promo',
								'trx_sc_properties', 'trx_sc_services', 'trx_sc_team', 'trx_sc_testimonials', 'trx_sc_title',
								'trx_widget_audio', 'trx_widget_twitter',
								'trx_sc_button')))
			$atts['color_style'] = 'default';


		// Param 'contacts'
		if (in_array($sc, array('trx_widget_contacts'))){
			$atts['socials_label'] = '';
		}
		// Param 'services'
		if (in_array($sc, array('trx_sc_services'))){
			$atts['service_compact'] = "0";
		}	
		// Param 'services'
		if (in_array($sc, array('trx_sc_layouts_menu'))){
			$atts['menu_padding'] = "0";
		}	

		return $atts;
	}
}

// Add params into shortcodes VC map
if ( !function_exists( 'soleng_trx_addons_sc_map' ) ) {
	add_filter( 'trx_addons_sc_map', 'soleng_trx_addons_sc_map', 10, 2);
	function soleng_trx_addons_sc_map($params, $sc) {

		// Param 'scheme'
		if (in_array($sc, array('trx_sc_action', 'trx_sc_blogger', 'trx_sc_cars', 'trx_sc_courses', 'trx_sc_content', 'trx_sc_dishes',
								'trx_sc_events', 'trx_sc_form', 'trx_sc_googlemap', 'trx_sc_portfolio', 'trx_sc_price', 'trx_sc_promo',
								'trx_sc_properties', 'trx_sc_services', 'trx_sc_team', 'trx_sc_testimonials', 'trx_sc_title',
								'trx_widget_audio', 'trx_widget_twitter', 'trx_sc_layouts_container'))) {
			if (empty($params['params']) || !is_array($params['params'])) $params['params'] = array();
			$params['params'][] = array(
					'param_name' => 'scheme',
					'heading' => esc_html__('Color scheme', 'soleng'),
					'description' => wp_kses_data( __('Select color scheme to decorate this block', 'soleng') ),
					'group' => esc_html__('Colors', 'soleng'),
					'admin_label' => true,
					'value' => array_flip(soleng_get_list_schemes(true)),
					'type' => 'dropdown'
				);
		}
		// Param 'color_style'
		$param = array(
			'param_name' => 'color_style',
			'heading' => esc_html__('Color style', 'soleng'),
			'description' => wp_kses_data( __('Select color style to decorate this block', 'soleng') ),
			'edit_field_class' => 'vc_col-sm-4',
			'admin_label' => true,
			'value' => array_flip(soleng_get_list_sc_color_styles()),
			'type' => 'dropdown'
		);
		if (in_array($sc, array('trx_sc_button'))) {
			if (empty($params['params']) || !is_array($params['params'])) $params['params'] = array();
			$new_params = array();
			foreach ($params['params'] as $v) {
				if (in_array($v['param_name'], array('type', 'size'))) $v['edit_field_class'] = 'vc_col-sm-4';
				$new_params[] = $v;
				if ($v['param_name'] == 'size') {
					$new_params[] = $param;
				}
			}
			$params['params'] = $new_params;
		} else if (in_array($sc, array('trx_sc_action', 'trx_sc_blogger', 'trx_sc_cars', 'trx_sc_courses', 'trx_sc_content', 'trx_sc_dishes',
								'trx_sc_events', 'trx_sc_form',	'trx_sc_googlemap', 'trx_sc_portfolio', 'trx_sc_price', 'trx_sc_promo',
								'trx_sc_properties', 'trx_sc_services', 'trx_sc_team', 'trx_sc_testimonials', 'trx_sc_title',
								'trx_widget_audio', 'trx_widget_twitter'))) {
			if (empty($params['params']) || !is_array($params['params'])) $params['params'] = array();
			$new_params = array();
			foreach ($params['params'] as $v) {
				if (in_array($v['param_name'], array('title_style', 'title_tag', 'title_align'))) $v['edit_field_class'] = 'vc_col-sm-6';
				$new_params[] = $v;
				if ($v['param_name'] == 'title_align') {
					if (!empty($v['group'])) $param['group'] = $v['group'];
					$param['edit_field_class'] = 'vc_col-sm-6';
					$new_params[] = $param;
				}
			}
			$params['params'] = $new_params;
		}

		// Param for widget contacts
		if (in_array($sc, array('trx_widget_contacts'))) {
			if (empty($params['params']) || !is_array($params['params'])) $params['params'] = array();
			$params['params'][] = array(
	                "param_name" => "socials_label",
	                "heading" => esc_html__("Socials title", 'soleng'),
	                "description" => wp_kses_data( __("Socials title", 'soleng') ),
					'dependency' => array(
						'element' => 'socials',
						'value' => '1',
					),                
	                "admin_label" => true,
	                "type" => "textfield"
				);
		}

		// Param for widget contacts
		if (in_array($sc, array('trx_sc_layouts_menu'))) {
			if (empty($params['params']) || !is_array($params['params'])) $params['params'] = array();
			$params['params'][] = array(
					'param_name' => 'menu_padding',
					'heading' => esc_html__('Extra padding', 'soleng'),
					'description' => wp_kses_data( __('Add extra padding to the right', 'soleng') ),
					'edit_field_class' => 'vc_col-sm-3',
					'dependency' => array(
						'element' => 'type',
						'value' => array('default', 'default alter')
					),                
					'std' => "0",
					"value" => array(esc_html__("Yes", 'soleng') => "1" ),
					"type" => "checkbox"
				);
		}


		/* dependency */
		if (in_array($sc, array('trx_sc_services'))) {   
			if (empty($params['params']) || !is_array($params['params'])) $params['params'] = array();
			$params['params'][] = array(
					'param_name' => 'service_compact',
					'heading' => esc_html__('Comapact Service', 'soleng'),
					'description' => wp_kses_data( __('Comapact Service', 'soleng') ),
					'edit_field_class' => 'vc_col-sm-3',
					'dependency' => array(
						'element' => 'type',
						'value' => array('image')
					),
					'std' => "0",
					"value" => array(esc_html__("Yes", 'soleng') => "1" ),
					"type" => "checkbox"

				);

			$aa = $params['params'];   
			foreach ($aa as $k => $v) {    
				if($v['param_name'] == 'columns'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('default','iconed','image','listing')     
					);    
				}
				if($v['param_name'] == 'hide_excerpt'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')
					);    
				}
				if($v['param_name'] == 'slider'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')     
					);    
				}
				if($v['param_name'] == 'icons_animation'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')     
					);    
				}
				if($v['param_name'] == 'featured'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')     
					);    
				}
				if($v['param_name'] == 'featured_position'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')     
					);    
				}
				if($v['param_name'] == 'post_type'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')     
					);    
				}
			}  
		}
		if (in_array($sc, array('trx_sc_blogger'))) {   
			$aa = $params['params'];   
			foreach ($aa as $k => $v) {    
				if($v['param_name'] == 'slider'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')     
					);    
				}
				if($v['param_name'] == 'post_type'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')     
					);    
				}
			}  
		}
		if (in_array($sc, array('trx_sc_button'))) {   
			$aa = $params['params'];   
			foreach ($aa as $k => $v) {    
				if($v['param_name'] == 'subtitle'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')     
					);    
				}
				if($v['param_name'] == 'icon'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('iconed')
					);    
				}
				if($v['param_name'] == 'image'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')
					);    
				}
				if($v['param_name'] == 'icon_position'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')
					);    
				}
			}  
		}	
		if (in_array($sc, array('trx_sc_team'))) {   
			$aa = $params['params'];   
			foreach ($aa as $k => $v) {    
				if($v['param_name'] == 'slider'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')     
					);    
				}
			}  
		}
		if (in_array($sc, array('trx_sc_skills'))) {   
			$aa = $params['params'];   
			foreach ($aa as $k => $v) {    
				if($v['param_name'] == 'compact'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')     
					);    
				}
			}  
		}
		if (in_array($sc, array('trx_sc_layouts_search'))) {   
			$aa = $params['params'];   
			foreach ($aa as $k => $v) {    
				if($v['param_name'] == 'ajax'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')     
					);    
				}
			}  
		}

		if (in_array($sc, array('trx_sc_action'))) {   
			$aa = $params['params'];   
			foreach ($aa as $k => $v) {    
				if($v['param_name'] == 'slider'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')     
					);    
				}
			}  
			$ab = $params['params'];   
			foreach ($ab as $k => $v) {    
				if($v['param_name'] == 'actions'){     
					$a = $params['params'][$k]['params'];
					foreach ($a as $g => $v) {    
						if($v['param_name'] == 'icon'){     
							unset($params['params'][$k]['params'][$g]);
						}
						if($v['param_name'] == 'info'){     
							unset($params['params'][$k]['params'][$g]);
						}
						if($v['param_name'] == 'subtitle'){     
							unset($params['params'][$k]['params'][$g]);
						}
						if($v['param_name'] == 'date'){     
							unset($params['params'][$k]['params'][$g]);
						}
						if($v['param_name'] == 'description'){     
							unset($params['params'][$k]['params'][$g]);
						}
						if($v['param_name'] == 'image'){     
							unset($params['params'][$k]['params'][$g]);
						}
						if($v['param_name'] == 'bg_color'){     
							unset($params['params'][$k]['params'][$g]);
						}
						if($v['param_name'] == 'color'){     
							unset($params['params'][$k]['params'][$g]);
						}
						if($v['param_name'] == 'description'){     
							unset($params['params'][$k]['params'][$g]);
						}
					}  
					 
				}
			}  
		}

		if (in_array($sc, array('trx_sc_price'))) {   
			$aa = $params['params'];   
			foreach ($aa as $k => $v) {    
				if($v['param_name'] == 'slider'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'type',      
						'value' => array('none')     
					);    
				}
			}  
			$ab = $params['params'];   
			foreach ($ab as $k => $v) {    
				if($v['param_name'] == 'prices'){     
					$a = $params['params'][$k]['params'];
					foreach ($a as $g => $v) {    
						if($v['param_name'] == 'label'){     
							unset($params['params'][$k]['params'][$g]);
						}
						if($v['param_name'] == 'description'){     
							unset($params['params'][$k]['params'][$g]);
						}
						if($v['param_name'] == 'image'){     
							unset($params['params'][$k]['params'][$g]);
						}
						if($v['param_name'] == 'bg_image'){     
							unset($params['params'][$k]['params'][$g]);
						}
						if($v['param_name'] == 'bg_color'){     
							unset($params['params'][$k]['params'][$g]);
						}
						if($v['param_name'] == 'icon'){     
							unset($params['params'][$k]['params'][$g]);
						}
					}  
					 
				}
			}  
		}

		return $params;
	}
}

// Add params into shortcodes SOW map
if ( !function_exists( 'soleng_trx_addons_sow_map' ) ) {
	add_filter( 'trx_addons_sow_map', 'soleng_trx_addons_sow_map', 10, 2);
	function soleng_trx_addons_sow_map($params, $sc) {

		// Param 'color_style'
		$param = array(
			'color_style' => array(
				'label' => esc_html__('Color style', 'soleng'),
				'description' => wp_kses_data( __('Select color style to decorate this block', 'soleng') ),
				'options' => soleng_get_list_sc_color_styles(),
				'default' => 'default',
				'type' => 'select'
			)
		);
		if (in_array($sc, array('trx_sc_button')))
			soleng_array_insert_after($params, 'size', $param);
		else if (in_array($sc, array('trx_sc_action', 'trx_sc_blogger', 'trx_sc_cars', 'trx_sc_courses', 'trx_sc_content', 'trx_sc_dishes',
								'trx_sc_events', 'trx_sc_form',	'trx_sc_googlemap', 'trx_sc_portfolio', 'trx_sc_price', 'trx_sc_promo',
								'trx_sc_properties', 'trx_sc_services', 'trx_sc_team', 'trx_sc_testimonials', 'trx_sc_title',
								'trx_widget_audio', 'trx_widget_twitter')))
			soleng_array_insert_after($params, 'title_align', $param);
		return $params;
	}
}

// Add classes to the shortcode's output
if ( !function_exists( 'soleng_trx_addons_sc_output' ) ) {
	add_filter( 'trx_addons_sc_output', 'soleng_trx_addons_sc_output', 10, 4);
	function soleng_trx_addons_sc_output($output, $sc, $atts, $content) {
		
		if (in_array($sc, array('trx_sc_action'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_action ', 'class="sc_action scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_action ', 'class="sc_action color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_blogger'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_blogger ', 'class="sc_blogger scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_blogger ', 'class="sc_blogger color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_button'))) {
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_button ', 'class="sc_button color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_cars'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_cars ', 'class="sc_cars scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_cars ', 'class="sc_cars color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_courses'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_courses ', 'class="sc_courses scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_courses ', 'class="sc_courses color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_content'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_content ', 'class="sc_content scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_content ', 'class="sc_content color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_dishes'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_dishes ', 'class="sc_dishes scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_dishes ', 'class="sc_dishes color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_events'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_events ', 'class="sc_events scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_events ', 'class="sc_events color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_form'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_form ', 'class="sc_form scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_form ', 'class="sc_form color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_googlemap'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_googlemap_content', 'class="sc_googlemap_content scheme_'.esc_attr($atts['scheme']), $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_googlemap_content ', 'class="sc_googlemap_content color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_portfolio'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_portfolio ', 'class="sc_portfolio scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_portfolio ', 'class="sc_portfolio color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_price'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_price ', 'class="sc_price scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_price ', 'class="sc_price color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_promo'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_promo ', 'class="sc_promo scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_promo ', 'class="sc_promo color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_properties'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_properties ', 'class="sc_properties scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_properties ', 'class="sc_properties color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_services'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_services ', 'class="sc_services scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_services ', 'class="sc_services color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_team'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_team ', 'class="sc_team scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_team ', 'class="sc_team color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_testimonials'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_testimonials ', 'class="sc_testimonials scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_testimonials ', 'class="sc_testimonials color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_title'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_title ', 'class="sc_title scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_title ', 'class="sc_title color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_widget_audio'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('sc_widget_audio', 'sc_widget_audio scheme_'.esc_attr($atts['scheme']), $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_widget_audio ', 'class="sc_widget_audio color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_widget_twitter'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('sc_widget_twitter', 'sc_widget_twitter scheme_'.esc_attr($atts['scheme']), $output);
			if (!empty($atts['color_style']) && !soleng_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_widget_twitter ', 'class="sc_widget_twitter color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_layouts_container'))) {
			if (!empty($atts['scheme']) && !soleng_is_inherit($atts['scheme']))
				$output = str_replace('sc_layouts_container', 'sc_layouts_container scheme_'.esc_attr($atts['scheme']), $output);
	
		}
		return $output;
	}
}

// Return tag for the item's title
if ( !function_exists( 'soleng_trx_addons_sc_item_title_tag' ) ) {
	add_filter( 'trx_addons_filter_sc_item_title_tag', 'soleng_trx_addons_sc_item_title_tag');
	function soleng_trx_addons_sc_item_title_tag($tag='') {
		return $tag=='h1' ? 'h2' : $tag;
	}
}

// Return args for the item's button
if ( !function_exists( 'soleng_trx_addons_sc_item_button_args' ) ) {
	add_filter( 'trx_addons_filter_sc_item_button_args', 'soleng_trx_addons_sc_item_button_args', 10, 3);
	function soleng_trx_addons_sc_item_button_args($args, $sc, $sc_args) {
		if (!empty($sc_args['color_style']))
			$args['color_style'] = $sc_args['color_style'];
		return $args;
	}
}

// Return theme specific title layout for the slider
if ( !function_exists( 'soleng_trx_addons_slider_title' ) ) {
	add_filter( 'trx_addons_filter_slider_title',	'soleng_trx_addons_slider_title', 10, 2 );
	function soleng_trx_addons_slider_title($title, $data) {
		$title = '';
		if (!empty($data['title'])) 
			$title .= '<h3 class="slide_title">'
						. (!empty($data['link']) ? '<a href="'.esc_url($data['link']).'">' : '')
						. esc_html($data['title'])
						. (!empty($data['link']) ? '</a>' : '')
						. '</h3>';
		if (!empty($data['cats']))
			$title .= sprintf('<div class="slide_cats">%s</div>', $data['cats']);
		return $title;
	}
}

// Add new styles to the Google map
if ( !function_exists( 'soleng_trx_addons_sc_googlemap_styles' ) ) {
	add_filter( 'trx_addons_filter_sc_googlemap_styles',	'soleng_trx_addons_sc_googlemap_styles');
	function soleng_trx_addons_sc_googlemap_styles($list) {
		$list['dark'] = esc_html__('Dark', 'soleng');
		return $list;
	}
}

// Input hover
if ( !function_exists( 'soleng_filter_get_list_input_hover' ) ) {
	add_filter( 'trx_addons_filter_get_list_input_hover',	'soleng_filter_get_list_input_hover');
	function soleng_filter_get_list_input_hover($list) {
		unset($list);
		$list = array();
		$list['default'] = esc_html__('Default', 'soleng');
		return $list;
	}
}

// menu hover
if ( !function_exists( 'soleng_filter_get_list_menu_hover' ) ) {
	add_filter( 'trx_addons_filter_get_list_menu_hover',	'soleng_filter_get_list_menu_hover');
	function soleng_filter_get_list_menu_hover($list) {
		unset($list);
		$list = array();
		$list['fade'] = esc_html__('Fade', 'soleng');
		return $list;
	}
}

// animation in
if ( !function_exists( 'soleng_filter_get_list_animations_in' ) ) {
	add_filter( 'trx_addons_filter_get_list_animations_in',	'soleng_filter_get_list_animations_in');
	function soleng_filter_get_list_animations_in($list) {
		unset($list);
		$list = array();
		$list['fadeIn'] = esc_html__('Fade In', 'soleng');
		return $list;
	}
}

// animation out
if ( !function_exists( 'soleng_filter_get_list_animations_out' ) ) {
	add_filter( 'trx_addons_filter_get_list_animations_out',	'soleng_filter_get_list_animations_out');
	function soleng_filter_get_list_animations_out($list) {
		unset($list);
		$list = array();
		$list['fadeOut'] = esc_html__('fade Out', 'soleng');
		return $list;
	}
}

// WP Editor addons
//------------------------------------------------------------------------

// Theme-specific configure of the WP Editor
if ( !function_exists( 'soleng_trx_addons_tiny_mce_style_formats' ) ) {
	add_filter( 'trx_addons_filter_tiny_mce_style_formats', 'soleng_trx_addons_tiny_mce_style_formats');
	function soleng_trx_addons_tiny_mce_style_formats($style_formats) {
		// Add style 'Arrow' to the 'List styles'
		// Remove 'false &&' from the condition below to add new style to the list
		if (is_array($style_formats) && count($style_formats)>0 ) {
			unset($style_formats[1]);
			$style_formats[1]['title'] = "Copyright";
			$style_formats[1]['items'] = array();			
			foreach ($style_formats as $k=>$v) {
				if ( $v['title'] == esc_html__('Inline', 'soleng') ) {
					unset($style_formats[$k]['items']);
					$style_formats[$k]['items'] = array();

					$style_formats[$k]['items'][] = array(
								'title' => esc_html__('Accent text', 'soleng'),
								'inline' => 'span',
								'classes' => 'trx_addons_accent'
							);
					$style_formats[$k]['items'][] = array(
								'title' => esc_html__('Hovered text', 'soleng'),
								'inline' => 'span',
								'classes' => 'trx_addons_hover'
							);
					$style_formats[$k]['items'][] = array(
								'title' => esc_html__('Text with background', 'soleng'),
								'inline' => 'span',
								'classes' => 'trx_addons_accent_bg'
							);
					$style_formats[$k]['items'][] = array(
								'title' => esc_html__('Dropcap 1', 'soleng'),
								'inline' => 'span',
								'classes' => 'trx_addons_dropcap trx_addons_dropcap_style_1'
							);
					$style_formats[$k]['items'][] = array(
								'title' => esc_html__('Dropcap 2', 'soleng'),
								'inline' => 'span',
								'classes' => 'trx_addons_dropcap trx_addons_dropcap_style_2'
							);
				}

				if ( $v['title'] == esc_html__('List styles', 'soleng') ) {
					unset($style_formats[$k]['items']);
					$style_formats[$k]['items'] = array();
					$style_formats[$k]['items'][] = array(
								'title' => esc_html__('Arrow', 'soleng'),
								'selector' => 'ul',
								'classes' => 'trx_addons_list_custom'
							);
					$style_formats[$k]['items'][] = array(
								'title' => esc_html__('Minus', 'soleng'),
								'selector' => 'ul',
								'classes' => 'trx_addons_list_minus'
							);
				}				
				if ( $v['title'] == esc_html__('Copyright', 'soleng') ) {
					$style_formats[$k]['items'][] = array(
								'title' => esc_html__('Default', 'soleng'),
								'inline' => 'span',
								'classes' => 'copyright_text'
							);

				}				
			}
		}
		return $style_formats;
	}
}


// Setup team and portflio pages
//------------------------------------------------------------------------

// Disable override header image on team and portfolio pages
if ( !function_exists( 'soleng_trx_addons_allow_override_header_image' ) ) {
	add_filter( 'soleng_filter_allow_override_header_image', 'soleng_trx_addons_allow_override_header_image' );
	function soleng_trx_addons_allow_override_header_image($allow) {
		return soleng_is_team_page() ? false : $allow;
	}
}

// Get thumb size for the team items
if ( !function_exists( 'soleng_trx_addons_thumb_size' ) ) {
	add_filter( 'trx_addons_filter_thumb_size',	'soleng_trx_addons_thumb_size', 10, 2);
	function soleng_trx_addons_thumb_size($thumb_size='', $type='') {
		if ($type == 'team-default')
			$thumb_size = soleng_get_thumb_size('classic');
		if ($type == 'services-default')
			$thumb_size = soleng_get_thumb_size('classic');
		return $thumb_size;
	}
}
if ( !function_exists( 'soleng_filter_posts_list_thumb_size' ) ) {
	add_filter( 'trx_addons_filter_posts_list_thumb_size',	'soleng_filter_posts_list_thumb_size', 10);
	function soleng_filter_posts_list_thumb_size($thumb_size='') {
		$thumb_size = soleng_get_thumb_size('postslist');
		return $thumb_size;
	}
}

if ( !function_exists( 'soleng_filter_get_list_sc_content_extra_bg_mask' ) ) {
	add_filter( 'trx_addons_filter_get_list_sc_content_extra_bg_mask',	'soleng_filter_get_list_sc_content_extra_bg_mask', 10);
	function soleng_filter_get_list_sc_content_extra_bg_mask($list='') {
		$list['94'] = esc_html__('94%', 'soleng');
		return $list;
	}
}
if ( !function_exists( 'soleng_filter_get_list_sc_button_sizes' ) ) {
	add_filter( 'trx_addons_filter_get_list_sc_button_sizes',	'soleng_filter_get_list_sc_button_sizes', 10);
	function soleng_filter_get_list_sc_button_sizes($list='') {
		unset($list['small']);
		return $list;
	}
}

if ( !function_exists( 'soleng_filter_get_list_sc_icon_sizes' ) ) {
	add_filter( 'trx_addons_filter_get_list_sc_icon_sizes',	'soleng_filter_get_list_sc_icon_sizes', 10);
	function soleng_filter_get_list_sc_icon_sizes($list='') {
		unset($list['small']);
		return $list;
	}
}

if ( !function_exists( 'soleng_filter_get_list_sc_layouts_search' ) ) {
	add_filter( 'trx_addons_filter_get_list_sc_layouts_search',	'soleng_filter_get_list_sc_layouts_search', 10);
	function soleng_filter_get_list_sc_layouts_search($list='') {
		unset($list['expand']);
		unset($list['fullscreen']);
		return $list;
	}
}

if ( !function_exists( 'soleng_sc_direction' ) ) {
	add_filter( 'trx_addons_sc_direction',	'soleng_sc_direction', 10);
	function soleng_sc_direction($list='') {
		unset($list['vertical']);
		return $list;
	}
}

if ( !function_exists( 'soleng_filter_get_list_sc_layouts_row_types' ) ) {
	add_filter( 'trx_addons_filter_get_list_sc_layouts_row_types',	'soleng_filter_get_list_sc_layouts_row_types', 10);
	function soleng_filter_get_list_sc_layouts_row_types($list='') {
		unset($list['narrow']);
		unset($list['compact']);
		return $list;
	}
}

if ( !function_exists( 'soleng_filter_get_list_sc_content_widths' ) ) {
	add_filter( 'trx_addons_filter_get_list_sc_content_widths',	'soleng_filter_get_list_sc_content_widths', 10);
	function soleng_filter_get_list_sc_content_widths($list='') {
		$list['85p'] = esc_html__('85% of container', 'soleng');
		return $list;
	}
}

// Add fields to the override options for the team members
// All other CPT override optionses may be modified in the same method
if (!function_exists('soleng_trx_addons_override_options_fields')) {
	add_filter( 'trx_addons_filter_meta_box_fields', 'soleng_trx_addons_override_options_fields', 10, 2);
	function soleng_trx_addons_override_options_fields($mb, $post_type) {
		if (defined('TRX_ADDONS_CPT_TEAM_PT') && $post_type==TRX_ADDONS_CPT_TEAM_PT) {
			$mb['email'] = array(
				"title" => esc_html__("E-mail",  'soleng'),
				"desc" => wp_kses_data( __("Team member's email", 'soleng') ),
				"std" => "",
				"details" => true,
				"type" => "text"
			);

		}
		return $mb;
	}
}
?>