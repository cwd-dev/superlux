<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0.22
 */

if (!defined("SOLENG_THEME_FREE")) define("SOLENG_THEME_FREE", false);
if (!defined("SOLENG_THEME_FREE_WP")) define("SOLENG_THEME_FREE_WP", false);

// Theme storage
$SOLENG_STORAGE = array(
	// Theme required plugin's slugs
	'required_plugins' => array_merge(

		// List of plugins for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			// Required plugins
			// DON'T COMMENT OR REMOVE NEXT LINES!
			'trx_addons'					=> esc_html__('ThemeREX Addons', 'soleng'),

			// Recommended (supported) plugins fot both (lite and full) versions
			// If plugin not need - comment (or remove) it
			'contact-form-7'				=> esc_html__('Contact Form 7', 'soleng'),
			'mailchimp-for-wp'				=> esc_html__('MailChimp for WP', 'soleng'),
			'woocommerce'					=> esc_html__('WooCommerce', 'soleng'),
            'elegro-payment'				=> esc_html__('Elegro Crypto Payment', 'soleng'),
            'trx_updater'					=> esc_html__('ThemeREX Updater', 'soleng')
		),

		// List of plugins for the FREE version only
		//-----------------------------------------------------
		SOLENG_THEME_FREE 
			? array(
					// Recommended (supported) plugins for the FREE (lite) version
					'siteorigin-panels'			=> esc_html__('SiteOrigin Panels', 'soleng'),
					) 

		// List of plugins for the PREMIUM version only
		//-----------------------------------------------------
			: array(
					// Recommended (supported) plugins for the PRO (full) version
					// If plugin not need - comment (or remove) it
					'essential-grid'			=> esc_html__('Essential Grid', 'soleng'),
					'revslider'					=> esc_html__('Revolution Slider', 'soleng'),
					'js_composer'				=> esc_html__('WPBakery PageBuilder', 'soleng'),
					)
	),
	
	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'	=> 'http://soleng.axiomthemes.com',
	'theme_doc_url'		=> 'http://soleng.axiomthemes.com/doc/',
	'theme_download_url'=> 'https://themeforest.net/item/soleng-solar-energy-company-wp-theme/21621910',

	'theme_support_url'	=> 'https://themerex.net/support/',									// Axiom

	'theme_video_url'	=> 'https://www.youtube.com/channel/UCBjqhuwKj3MfE3B6Hg2oA8Q',	// Axiom

	// Responsive resolutions
	// Parameters to create css media query: min, max, 
	'responsive' => array(
						// By device
						'desktop'	=> array('min' => 1680),
						'notebook'	=> array('min' => 1280, 'max' => 1679),
						'tablet'	=> array('min' =>  768, 'max' => 1279),
						'mobile'	=> array('max' =>  767),
						// By size
						'xxl'		=> array('max' => 1679),
						'xl'		=> array('max' => 1439),
						'lg'		=> array('max' => 1279),
						'md'		=> array('max' => 1023),
						'sm'		=> array('max' =>  767),
						'sm_wp'		=> array('max' =>  600),
						'xs'		=> array('max' =>  479)
						)
);

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( !function_exists('soleng_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'soleng_customizer_theme_setup1', 1 );
	function soleng_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		soleng_storage_set('settings', array(
			
			'duplicate_options'		=> 'child',		// none  - use separate options for the main and the child-theme
													// child - duplicate theme options from the main theme to the child-theme only
													// both  - sinchronize changes in the theme options between main and child themes

			'customize_refresh'		=> 'auto',		// Refresh method for preview area in the Appearance - Customize:
													// auto - refresh preview area on change each field with Theme Options
													// manual - refresh only obn press button 'Refresh' at the top of Customize frame

			'max_load_fonts'		=> 5,			// Max fonts number to load from Google fonts or from uploaded fonts

			'comment_maxlength'		=> 1000,		// Max length of the message from contact form

			'comment_after_name'	=> true,		// Place 'comment' field before the 'name' and 'email'

			'socials_type'			=> 'icons',		// Type of socials:
													// icons - use font icons to present social networks
													// images - use images from theme's folder trx_addons/css/icons.png

			'icons_type'			=> 'icons',		// Type of other icons:
													// icons - use font icons to present icons
													// images - use images from theme's folder trx_addons/css/icons.png

			'icons_selector'		=> 'internal',	// Icons selector in the shortcodes:
													// standard VC icons selector (very slow and don't support images)
													// internal - internal popup with plugin's or theme's icons list (fast)
			'check_min_version'		=> true,		// Check if exists a .min version of .css and .js and return path to it
													// instead the path to the original file
													// (if debug_mode is off and modification time of the original file < time of the .min file)
			'autoselect_menu'		=> true,		// Show any menu if no menu selected in the location 'main_menu'
													// (for example, the theme is just activated)
			'disable_jquery_ui'		=> false,		// Prevent loading custom jQuery UI libraries in the third-party plugins
		
			'use_mediaelements'		=> true,		// Load script "Media Elements" to play video and audio
			
			'tgmpa_upload'			=> false,		// Allow upload not pre-packaged plugins via TGMPA
			
			'allow_no_image'		=> false		// Allow use image placeholder if no image present in the blog, related posts, post navigation, etc.
		));


		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------
		
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		
		soleng_storage_set('load_fonts', array(
			// Google font
			array(
				'name'	 => 'Archivo Black',
				'family' => 'sans-serif',
				'styles' => '400'		// Parameter 'style' used only for the Google fonts
				),
			// Font-face packed with theme
			array(
				'name'   => 'Rubik',
				'family' => 'sans-serif',
				'styles' => '300,300i,400,400i,500,500i,700,700i,900,900i'		// Parameter 'style' used only for the Google fonts
				)
		));
		
		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		soleng_storage_set('load_fonts_subset', 'latin,latin-ext');
		
		// Settings of the main tags
		// Attention! Font name in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!

		soleng_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'soleng'),
				'description'		=> esc_html__('Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'soleng'),
				'font-family'		=> '"Rubik",sans-serif',
				'font-size' 		=> '1rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.4em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.585px',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '1.05em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'soleng'),
				'font-family'		=> '"Archivo Black",sans-serif',
				'font-size' 		=> '3.684em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.01em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.65px',
				'margin-top'		=> '0.76em',
				'margin-bottom'		=> '0.44em'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'soleng'),
				'font-family'		=> '"Archivo Black",sans-serif',
				'font-size' 		=> '3.158em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.18em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.6px',
				'margin-top'		=> '1.15em',
				'margin-bottom'		=> '0.5em'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'soleng'),
				'font-family'		=> '"Archivo Black",sans-serif',
				'font-size' 		=> '2.632em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.1em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.5px',
				'margin-top'		=> '1.42em',
				'margin-bottom'		=> '0.43em'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'soleng'),
				'font-family'		=> '"Archivo Black",sans-serif',
				'font-size' 		=> '2.105em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.15em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.4px',
				'margin-top'		=> '1.85em',
				'margin-bottom'		=> '0.75em'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'soleng'),
				'font-family'		=> '"Archivo Black",sans-serif',
				'font-size' 		=> '1.474em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.3px',
				'margin-top'		=> '2.65em',
				'margin-bottom'		=> '0.75em'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'soleng'),
				'font-family'		=> '"Archivo Black",sans-serif',
				'font-size' 		=> '1.053em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.3em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.2px',
				'margin-top'		=> '3.7em',
				'margin-bottom'		=> '1.15em'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'soleng'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'soleng'),
				'font-family'		=> '"Archivo Black",sans-serif',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'soleng'),
				'font-family'		=> '"Archivo Black",sans-serif',
				'font-size' 		=> '17px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '17px',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.5px'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'soleng'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'soleng'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '18px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> 'normal',	// Attention! Firefox don't allow line-height less then 1.5em in the select
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.55px'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'soleng'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'soleng'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '18px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.51px',
				'margin-top'		=> '0.4em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'soleng'),
				'description'		=> esc_html__('Font settings of the main menu items', 'soleng'),
				'font-family'		=> '"Rubik",sans-serif',
				'font-size' 		=> '1.0714em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.8px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'soleng'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'soleng'),
				'font-family'		=> '"Archivo Black",sans-serif',
				'font-size' 		=> '0.835em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.55px'
				)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		soleng_storage_set('scheme_color_groups', array(
			'main'	=> array(
							'title'			=> esc_html__('Main', 'soleng'),
							'description'	=> esc_html__('Colors of the main content area', 'soleng')
							),
			'alter'	=> array(
							'title'			=> esc_html__('Alter', 'soleng'),
							'description'	=> esc_html__('Colors of the alternative blocks (sidebars, etc.)', 'soleng')
							),
			'extra'	=> array(
							'title'			=> esc_html__('Extra', 'soleng'),
							'description'	=> esc_html__('Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'soleng')
							),
			'inverse' => array(
							'title'			=> esc_html__('Inverse', 'soleng'),
							'description'	=> esc_html__('Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'soleng')
							),
			'input'	=> array(
							'title'			=> esc_html__('Input', 'soleng'),
							'description'	=> esc_html__('Colors of the form fields (text field, textarea, select, etc.)', 'soleng')
							),
			)
		);
		soleng_storage_set('scheme_color_names', array(
			'bg_color'	=> array(
							'title'			=> esc_html__('Background color', 'soleng'),
							'description'	=> esc_html__('Background color of this block in the normal state', 'soleng')
							),
			'bg_hover'	=> array(
							'title'			=> esc_html__('Background hover', 'soleng'),
							'description'	=> esc_html__('Background color of this block in the hovered state', 'soleng')
							),
			'bd_color'	=> array(
							'title'			=> esc_html__('Border color', 'soleng'),
							'description'	=> esc_html__('Border color of this block in the normal state', 'soleng')
							),
			'bd_hover'	=>  array(
							'title'			=> esc_html__('Border hover', 'soleng'),
							'description'	=> esc_html__('Border color of this block in the hovered state', 'soleng')
							),
			'text'		=> array(
							'title'			=> esc_html__('Text', 'soleng'),
							'description'	=> esc_html__('Color of the plain text inside this block', 'soleng')
							),
			'text_dark'	=> array(
							'title'			=> esc_html__('Text dark', 'soleng'),
							'description'	=> esc_html__('Color of the dark text (bold, header, etc.) inside this block', 'soleng')
							),
			'text_light'=> array(
							'title'			=> esc_html__('Text light', 'soleng'),
							'description'	=> esc_html__('Color of the light text (post meta, etc.) inside this block', 'soleng')
							),
			'text_link'	=> array(
							'title'			=> esc_html__('Link', 'soleng'),
							'description'	=> esc_html__('Color of the links inside this block', 'soleng')
							),
			'text_hover'=> array(
							'title'			=> esc_html__('Link hover', 'soleng'),
							'description'	=> esc_html__('Color of the hovered state of links inside this block', 'soleng')
							),
			'text_link2'=> array(
							'title'			=> esc_html__('Link 2', 'soleng'),
							'description'	=> esc_html__('Color of the accented texts (areas) inside this block', 'soleng')
							),
			'text_hover2'=> array(
							'title'			=> esc_html__('Link 2 hover', 'soleng'),
							'description'	=> esc_html__('Color of the hovered state of accented texts (areas) inside this block', 'soleng')
							),
			'text_link3'=> array(
							'title'			=> esc_html__('Link 3', 'soleng'),
							'description'	=> esc_html__('Color of the other accented texts (buttons) inside this block', 'soleng')
							),
			'text_hover3'=> array(
							'title'			=> esc_html__('Link 3 hover', 'soleng'),
							'description'	=> esc_html__('Color of the hovered state of other accented texts (buttons) inside this block', 'soleng')
							)
			)
		);
		soleng_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'soleng'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#ffffff', //
					'bd_color'			=> '#e5e5e5',
		
					// Text and links colors
					'text'				=> '#888885', //
					'text_light'		=> '#848484', //
					'text_dark'			=> '#312d2a', //
					'text_link'			=> '#a6c1c9', //
					'text_hover'		=> '#e78e47', //
					'text_link2'		=> '#e78e47', //
					'text_hover2'		=> '#a6c1c9', //
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',
		
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#f5f4ef', //
					'alter_bg_hover'	=> '#e6e8eb',
					'alter_bd_color'	=> '#e5e5e5',
					'alter_bd_hover'	=> '#c5c5c4', //?
					'alter_text'		=> '#888885', //
					'alter_light'		=> '#b7b7b7',
					'alter_dark'		=> '#312d2a', //
					'alter_link'		=> '#a6c1c9', //
					'alter_hover'		=> '#e78e47', //
					'alter_link2'		=> '#e78e47', //
					'alter_hover2'		=> '#a6c1c9',
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',
		
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#f5f4ef', //
					'extra_bg_hover'	=> '#fafaf7', //
					'extra_bd_color'	=> '#a6c1c9', //
					'extra_bd_hover'	=> '#3d3d3d',
					'extra_text'		=> '#888885', //
					'extra_light'		=> '#afafaf',
					'extra_dark'		=> '#312d2a', //
					'extra_link'		=> '#a6c1c9',
					'extra_hover'		=> '#e78e47',
					'extra_link2'		=> '#e78e47', //
					'extra_hover2'		=> '#a6c1c9',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#f5f4ef', //
					'input_bg_hover'	=> '#ffffff', //
					'input_bd_color'	=> '#f5f4ef', //
					'input_bd_hover'	=> '#312d2a', //
					'input_text'		=> '#888885', //
					'input_light'		=> '#888885', //
					'input_dark'		=> '#312d2a', //
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#67bcc1',
					'inverse_bd_hover'	=> '#5aa4a9',
					'inverse_text'		=> '#ffffff', //
					'inverse_light'		=> '#888885',
					'inverse_dark'		=> '#312d2a', //
					'inverse_link'		=> '#ffffff', //
					'inverse_hover'		=> '#1d1d1d'
				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'soleng'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#3b3b3b', //
					'bd_color'			=> '#2e2c33',
		
					// Text and links colors
					'text'				=> '#b7b7b7',
					'text_light'		=> '#ffffff', //
					'text_dark'			=> '#ffffff', //
					'text_link'			=> '#a6c1c9', //
					'text_hover'		=> '#e78e47', //
					'text_link2'		=> '#e78e47', //
					'text_hover2'		=> '#a6c1c9', //
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#303030', //
					'alter_bg_hover'	=> '#888885',
					'alter_bd_color'	=> '#464646',
					'alter_bd_hover'	=> '#4a4a4a',
					'alter_text'		=> '#a6a6a6',
					'alter_light'		=> '#5f5f5f',
					'alter_dark'		=> '#ffffff',
					'alter_link'		=> '#ffaa5f',
					'alter_hover'		=> '#e78e47',
					'alter_link2'		=> '#e78e47', //
					'alter_hover2'		=> '#a6c1c9', //
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#1e1d22',
					'extra_bg_hover'	=> '#28272e',
					'extra_bd_color'	=> '#464646',
					'extra_bd_hover'	=> '#4a4a4a',
					'extra_text'		=> '#a6a6a6',
					'extra_light'		=> '#5f5f5f',
					'extra_dark'		=> '#ffffff',
					'extra_link'		=> '#ffaa5f',
					'extra_hover'		=> '#e78e47',
					'extra_link2'		=> '#e78e47',
					'extra_hover2'		=> '#a6c1c9',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#2e2d32',
					'input_bg_hover'	=> '#2e2d32',
					'input_bd_color'	=> '#2e2d32',
					'input_bd_hover'	=> '#353535',
					'input_text'		=> '#b7b7b7',
					'input_light'		=> '#5f5f5f',
					'input_dark'		=> '#ffffff',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#e36650',
					'inverse_bd_hover'	=> '#cb5b47',
					'inverse_text'		=> '#ffffff', //
					'inverse_light'		=> '#5f5f5f',
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff', //
					'inverse_hover'		=> '#1d1d1d'
				)
			)
		
		));
		
		// Simple schemes substitution
		soleng_storage_set('schemes_simple', array(
			// Main color	// Slave elements and it's darkness koef.
			'text_link'		=> array('alter_hover' => 1,	'extra_link' => 1, 'inverse_bd_color' => 0.85, 'inverse_bd_hover' => 0.7),
			'text_hover'	=> array('alter_link' => 1,		'extra_hover' => 1),
			'text_link2'	=> array('alter_hover2' => 1,	'extra_link2' => 1),
			'text_hover2'	=> array('alter_link2' => 1,	'extra_hover2' => 1),
			'text_link3'	=> array('alter_hover3' => 1,	'extra_link3' => 1),
			'text_hover3'	=> array('alter_link3' => 1,	'extra_hover3' => 1)
		));

		// Additional colors for each scheme
		soleng_storage_set('scheme_colors_add', array(
			'bg_color_0'		=> array('color' => 'bg_color',			'alpha' => 0),
			'bg_color_02'		=> array('color' => 'bg_color',			'alpha' => 0.2),
			'bg_color_024'		=> array('color' => 'bg_color',			'alpha' => 0.24),
			'bg_color_07'		=> array('color' => 'bg_color',			'alpha' => 0.7),
			'bg_color_08'		=> array('color' => 'bg_color',			'alpha' => 0.8),
			'bg_color_09'		=> array('color' => 'bg_color',			'alpha' => 0.9),
			'alter_bg_color_07'	=> array('color' => 'alter_bg_color',	'alpha' => 0.7),
			'alter_bg_color_04'	=> array('color' => 'alter_bg_color',	'alpha' => 0.4),
			'alter_bg_color_02'	=> array('color' => 'alter_bg_color',	'alpha' => 0.2),
			'alter_bd_color_02'	=> array('color' => 'alter_bd_color',	'alpha' => 0.2),
			'alter_link_02'		=> array('color' => 'alter_link',		'alpha' => 0.2),
			'alter_link_07'		=> array('color' => 'alter_link',		'alpha' => 0.7),
			'extra_bg_color_07'	=> array('color' => 'extra_bg_color',	'alpha' => 0.7),
			'extra_link_02'		=> array('color' => 'extra_link',		'alpha' => 0.2),
			'extra_link_07'		=> array('color' => 'extra_link',		'alpha' => 0.7),
			'text_dark_02'		=> array('color' => 'text_dark',		'alpha' => 0.2),
			'text_dark_065'		=> array('color' => 'text_dark',		'alpha' => 0.65),
			'text_dark_07'		=> array('color' => 'text_dark',		'alpha' => 0.7),
			'text_link_02'		=> array('color' => 'text_link',		'alpha' => 0.2),
			'text_link_07'		=> array('color' => 'text_link',		'alpha' => 0.7),
			'text_link2_06'		=> array('color' => 'text_link2',		'alpha' => 0.6),
			'text_link2_09'		=> array('color' => 'text_link2',		'alpha' => 0.9),
			'inverse_link_035'	=> array('color' => 'inverse_link',		'alpha' => 0.35),
			'text_link_blend'	=> array('color' => 'text_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5),
			'alter_link_blend'	=> array('color' => 'alter_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		soleng_storage_set('theme_thumbs', apply_filters('soleng_filter_add_thumb_sizes', array(
			'soleng-thumb-huge'		=> array(
												'size'	=> array(1170, 468, true),
												'title' => esc_html__( 'Huge image', 'soleng' ),
												'subst'	=> 'trx_addons-thumb-huge'
												),
			'soleng-thumb-big' 		=> array(
												'size'	=> array( 670, 268, true),
												'title' => esc_html__( 'Large image', 'soleng' ),
												'subst'	=> 'trx_addons-thumb-big'
												),

			'soleng-thumb-med' 		=> array(
												'size'	=> array( 370, 148, true),
												'title' => esc_html__( 'Medium image', 'soleng' ),
												'subst'	=> 'trx_addons-thumb-medium'
												),

			'soleng-thumb-tiny' 		=> array(
												'size'	=> array( 104, 104, true),
												'title' => esc_html__( 'Small square avatar', 'soleng' ),
												'subst'	=> 'trx_addons-thumb-tiny'
												),
			'soleng-thumb-postslist' 		=> array(
												'size'	=> array(  262,  121, true),
												'title' => esc_html__( 'Posts List', 'soleng' ),
												'subst'	=> 'trx_addons-thumb-postslist'
												),
			'soleng-thumb-classic' 		=> array(
												'size'	=> array(  370,  232, true),
												'title' => esc_html__( 'Classic List', 'soleng' ),
												'subst'	=> 'trx_addons-thumb-classic'
												),
			'soleng-thumb-serviceimage' 		=> array(
												'size'	=> array(  455,  366, true),
												'title' => esc_html__( 'Service Image', 'soleng' ),
												'subst'	=> 'trx_addons-thumb-serviceimage'
												),
			'soleng-thumb-servicecompact' 		=> array(
												'size'	=> array(  570,  280, true),
												'title' => esc_html__( 'Service Compact Image', 'soleng' ),
												'subst'	=> 'trx_addons-thumb-servicecompact'
												),
			'soleng-thumb-masonry-big' => array(
												'size'	=> array( 760,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry Large (scaled)', 'soleng' ),
												'subst'	=> 'trx_addons-thumb-masonry-big'
												),

			'soleng-thumb-masonry'		=> array(
												'size'	=> array( 370,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry (scaled)', 'soleng' ),
												'subst'	=> 'trx_addons-thumb-masonry'
												)
			))
		);
	}
}




//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( !function_exists( 'soleng_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'soleng_importer_set_options', 9 );
	function soleng_importer_set_options($options=array()) {
		if (is_array($options)) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url(soleng_get_protocol() . '://demofiles.axiomthemes.com/soleng/');
			// Required plugins
			$options['required_plugins'] = array_keys(soleng_storage_get('required_plugins'));
			// Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 3;
			// Default demo
			$options['files']['default']['title'] = esc_html__('Soleng Demo', 'soleng');
			$options['files']['default']['domain_dev'] = esc_url(soleng_get_protocol().'://soleng.axiomthemes.com');		// Developers domain
			$options['files']['default']['domain_demo']= esc_url(soleng_get_protocol().'://soleng.axiomthemes.com');		// Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
			// Banners
			$options['banners'] = array(
				array(
					'image' => soleng_get_file_url('theme-specific/theme-about/images/frontpage.png'),
					'title' => esc_html__('Front Page Builder', 'soleng'),
					'content' => wp_kses(__("Create your front page right in the WordPress Customizer. There's no need in WPBakery PageBuilder, or any other builder. Simply enable/disable sections, fill them out with content, and customize to your liking.", 'soleng'), 'soleng_kses_content'),
					'link_url' => esc_url('//www.youtube.com/watch?v=VT0AUbMl_KA'),
					'link_caption' => esc_html__('Watch Video Introduction', 'soleng'),
					'duration' => 20
					),
				array(
					'image' => soleng_get_file_url('theme-specific/theme-about/images/layouts.png'),
					'title' => esc_html__('Layouts Builder', 'soleng'),
					'content' => wp_kses(__('Use Layouts Builder to create and customize header and footer styles for your website. With a flexible page builder interface and custom shortcodes, you can create as many header and footer layouts as you want with ease.', 'soleng'), 'soleng_kses_content'),
					'link_url' => esc_url('//www.youtube.com/watch?v=pYhdFVLd7y4'),
					'link_caption' => esc_html__('Learn More', 'soleng'),
					'duration' => 20
					),
				array(
					'image' => soleng_get_file_url('theme-specific/theme-about/images/documentation.png'),
					'title' => esc_html__('Read Full Documentation', 'soleng'),
					'content' => wp_kses(__('Need more details? Please check our full online documentation for detailed information on how to use Soleng.', 'soleng'), 'soleng_kses_content'),
					'link_url' => esc_url(soleng_storage_get('theme_doc_url')),
					'link_caption' => esc_html__('Online Documentation', 'soleng'),
					'duration' => 15
					),
				array(
					'image' => soleng_get_file_url('theme-specific/theme-about/images/video-tutorials.png'),
					'title' => esc_html__('Video Tutorials', 'soleng'),
					'content' => wp_kses(__('No time for reading documentation? Check out our video tutorials and learn how to customize Soleng in detail.', 'soleng'), 'soleng_kses_content'),
					'link_url' => esc_url(soleng_storage_get('theme_video_url')),
					'link_caption' => esc_html__('Video Tutorials', 'soleng'),
					'duration' => 15
					),
				array(
					'image' => soleng_get_file_url('theme-specific/theme-about/images/studio.png'),
					'title' => esc_html__('Website Customization', 'soleng'),
					'content' => wp_kses(__("Need a website fast? Order our custom service, and we'll build a website based on this theme for a very fair price. We can also implement additional functionality such as website translation, setting up WPML, and much more.", 'soleng'), 'soleng_kses_content'),
					'link_url' => esc_url('//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themedash '),
					'link_caption' => esc_html__('Contact Us', 'soleng'),
					'duration' => 25
					)
				);
		}
		return $options;
	}
}




// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if (!function_exists('soleng_create_theme_options')) {

	function soleng_create_theme_options() {

		// Message about options override. 
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = wp_kses_data(__('<b>Attention!</b> Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages', 'soleng'));

		soleng_storage_set('options', array(
		
			// 'Logo & Site Identity'
			'title_tagline' => array(
				"title" => esc_html__('Logo & Site Identity', 'soleng'),
				"desc" => '',
				"priority" => 10,
				"type" => "section"
				),
			'logo_info' => array(
				"title" => esc_html__('Logo in the header', 'soleng'),
				"desc" => '',
				"priority" => 20,
				"type" => "info",
				),
			'logo_text' => array(
				"title" => esc_html__('Use Site Name as Logo', 'soleng'),
				"desc" => wp_kses_data( __('Use the site title and tagline as a text logo if no image is selected', 'soleng') ),
				"class" => "soleng_column-1_2 soleng_new_row",
				"priority" => 30,
				"std" => 1,
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_retina_enabled' => array(
				"title" => esc_html__('Allow retina display logo', 'soleng'),
				"desc" => wp_kses_data( __('Show fields to select logo images for Retina display', 'soleng') ),
				"class" => "soleng_column-1_2",
				"priority" => 40,
				"refresh" => false,
				"std" => 0,
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_zoom' => array(
				"title" => esc_html__('Logo zoom', 'soleng'),
				"desc" => wp_kses_data( __("Zoom the logo. 1 - original size. Maximum size of logo depends on the actual size of the picture", 'soleng') ),
				"std" => 1,
				"min" => 0.2,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => SOLENG_THEME_FREE ? "hidden" : "slider"
				),
			// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'soleng'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'soleng') ),
				"class" => "soleng_column-1_2",
				"priority" => 70,
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => SOLENG_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile_header' => array(
				"title" => esc_html__('Logo for the mobile header', 'soleng'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'soleng') ),
				"class" => "soleng_column-1_2 soleng_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_header_retina' => array(
				"title" => esc_html__('Logo for the mobile header for Retina', 'soleng'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'soleng') ),
				"class" => "soleng_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => SOLENG_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile' => array(
				"title" => esc_html__('Logo mobile', 'soleng'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile menu', 'soleng') ),
				"class" => "soleng_column-1_2 soleng_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_retina' => array(
				"title" => esc_html__('Logo mobile for Retina', 'soleng'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'soleng') ),
				"class" => "soleng_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => SOLENG_THEME_FREE ? "hidden" : "image"
				),
			'logo_side' => array(
				"title" => esc_html__('Logo side', 'soleng'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu', 'soleng') ),
				"class" => "soleng_column-1_2 soleng_new_row",
				"hidden" => true,
				"std" => '',
				"type" => "image"
				),
			'logo_side_retina' => array(
				"title" => esc_html__('Logo side for Retina', 'soleng'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'soleng') ),
				"class" => "soleng_column-1_2",
				"hidden" => true,
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => SOLENG_THEME_FREE ? "hidden" : "image"
				),
			
		
		
			// 'General settings'
			'general' => array(
				"title" => esc_html__('General Settings', 'soleng'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 20,
				"type" => "section",
				),

			'general_layout_info' => array(
				"title" => esc_html__('Layout', 'soleng'),
				"desc" => '',
				"type" => "info",
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'soleng'),
				"desc" => wp_kses_data( __('Select width of the body content', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'soleng')
				),
				"refresh" => false,
				"std" => 'wide',
				"options" => soleng_get_list_body_styles(),
				"type" => "select"
				),
			'boxed_bg_image' => array(
				"title" => esc_html__('Boxed bg image', 'soleng'),
				"desc" => wp_kses_data( __('Select or upload image, used as background in the boxed body', 'soleng') ),
				"dependency" => array(
					'body_style' => array('boxed')
				),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'soleng')
				),
				"std" => '',
				"hidden" => true,
				"type" => "image"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'soleng'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'soleng')
				),
				"refresh" => false,
				"std" => 0,
				"type" => "checkbox"
				),

			'general_sidebar_info' => array(
				"title" => esc_html__('Sidebar', 'soleng'),
				"desc" => '',
				"type" => "info",
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'soleng'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'soleng')
				),
				"std" => 'right',
				"options" => array(),
				"type" => "switch"
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'soleng'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'soleng')
				),
				"dependency" => array(
					'sidebar_position' => array('left', 'right')
				),
				"std" => 'sidebar_widgets',
				"options" => array(),
				"type" => "select"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'soleng'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'soleng') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),


			'general_widgets_info' => array(
				"title" => esc_html__('Additional widgets', 'soleng'),
				"desc" => '',
				"type" => SOLENG_THEME_FREE ? "hidden" : "info",
				),
			'widgets_above_page' => array(
				"title" => esc_html__('Widgets at the top of the page', 'soleng'),
				"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'soleng')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => SOLENG_THEME_FREE ? "hidden" : "select"
				),
			'widgets_above_content' => array(
				"title" => esc_html__('Widgets above the content', 'soleng'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'soleng')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => SOLENG_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_content' => array(
				"title" => esc_html__('Widgets below the content', 'soleng'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'soleng')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => SOLENG_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_page' => array(
				"title" => esc_html__('Widgets at the bottom of the page', 'soleng'),
				"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'soleng')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => SOLENG_THEME_FREE ? "hidden" : "select"
				),

			'general_effects_info' => array(
				"title" => esc_html__('Design & Effects', 'soleng'),
				"desc" => '',
				"type" => "info",
				),
			'border_radius' => array(
				"title" => esc_html__('Border radius', 'soleng'),
				"desc" => wp_kses_data( __('Specify the border radius of the form fields and buttons in pixels or other valid CSS units', 'soleng') ),
				"hidden" => true,
				"std" => 0,
				"type" => "text"
				),

			'general_misc_info' => array(
				"title" => esc_html__('Miscellaneous', 'soleng'),
				"desc" => '',
				"type" => SOLENG_THEME_FREE ? "hidden" : "info",
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'soleng'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'soleng') ),
				"std" => 0,
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),
            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'soleng'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'soleng') ),
                "std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'soleng'), 'soleng_kses_content' ),
                "type"  => "text"
            ),
		
		
			// 'Header'
			'header' => array(
				"title" => esc_html__('Header', 'soleng'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 30,
				"type" => "section"
				),

			'header_style_info' => array(
				"title" => esc_html__('Header style', 'soleng'),
				"desc" => '',
				"type" => "info"
				),
			'header_type' => array(
				"title" => esc_html__('Header style', 'soleng'),
				"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'soleng')
				),
				"std" => 'default',
				"options" => soleng_get_list_header_footer_types(),
				"type" => SOLENG_THEME_FREE || !soleng_exists_trx_addons() ? "hidden" : "switch"
				),
			'header_style' => array(
				"title" => esc_html__('Select custom layout', 'soleng'),
				"desc" => wp_kses( __("Select custom header from Layouts Builder", 'soleng'), 'soleng_kses_content' ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'soleng')
				),
				"dependency" => array(
					'header_type' => array('custom')
				),
				"std" => SOLENG_THEME_FREE ? 'header-custom-sow-header-default' : 'header-custom-header-default',
				"options" => array(),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'soleng'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'soleng')
				),
				"std" => 'default',
				"options" => array(),
				"type" => SOLENG_THEME_FREE ? "hidden" : "switch"
				),
			'header_fullheight' => array(
				"title" => esc_html__('Header fullheight', 'soleng'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'soleng')
				),
				"hidden" => true,
				"std" => 0,
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_zoom' => array(
				"title" => esc_html__('Header zoom', 'soleng'),
				"desc" => wp_kses_data( __("Zoom the header title. 1 - original size", 'soleng') ),
				"std" => 1,
				"min" => 0.3,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => SOLENG_THEME_FREE ? "hidden" : "slider"
				),
			'header_wide' => array(
				"title" => esc_html__('Header fullwidth', 'soleng'),
				"desc" => wp_kses_data( __('Do you want to stretch the header widgets area to the entire window width?', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'soleng')
				),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 1,
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_widgets_info' => array(
				"title" => esc_html__('Header widgets', 'soleng'),
				"desc" => wp_kses_data( __('Here you can place a widget slider, advertising banners, etc.', 'soleng') ),
				"type" => "info"
				),
			'header_widgets' => array(
				"title" => esc_html__('Header widgets', 'soleng'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on each page', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'soleng'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on this page', 'soleng') ),
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'header_columns' => array(
				"title" => esc_html__('Header columns', 'soleng'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'soleng')
				),
				"dependency" => array(
					'header_type' => array('default'),
					'header_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => soleng_get_list_range(0,6),
				"type" => "select"
				),

			'menu_info' => array(
				"title" => esc_html__('Main menu', 'soleng'),
				"desc" => wp_kses_data( __('Select main menu style, position, color scheme and other parameters', 'soleng') ),
				"type" => SOLENG_THEME_FREE ? "hidden" : "info"
				),
			'menu_style' => array(
				"title" => esc_html__('Menu position', 'soleng'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'soleng')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'soleng')
				),
				"type" => SOLENG_THEME_FREE || !soleng_exists_trx_addons() ? "hidden" : "switch"
				),
			'menu_side_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'soleng'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'soleng')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 0,
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_side_icons' => array(
				"title" => esc_html__('Iconed sidemenu', 'soleng'),
				"desc" => wp_kses_data( __('Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'soleng')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_mobile_fullscreen' => array(
				"title" => esc_html__('Mobile menu fullscreen', 'soleng'),
				"desc" => wp_kses_data( __('Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'soleng') ),
				"hidden" => true,
				"std" => 1,
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_image_info' => array(
				"title" => esc_html__('Header image', 'soleng'),
				"desc" => '',
				"type" => SOLENG_THEME_FREE ? "hidden" : "info"
				),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'soleng'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'soleng') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'soleng')
				),
				"std" => 0,
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_mobile_info' => array(
				"title" => esc_html__('Mobile header', 'soleng'),
				"desc" => wp_kses_data( __("Configure the mobile version of the header", 'soleng') ),
				"priority" => 500,
				"dependency" => array(
					'header_type' => array('default')
				),
				"type" => SOLENG_THEME_FREE ? "hidden" : "info"
				),
			'header_mobile_enabled' => array(
				"title" => esc_html__('Enable the mobile header', 'soleng'),
				"desc" => wp_kses_data( __("Use the mobile version of the header (if checked) or relayout the current header on mobile devices", 'soleng') ),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 0,
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_additional_info' => array(
				"title" => esc_html__('Additional info', 'soleng'),
				"desc" => wp_kses_data( __('Additional info to show at the top of the mobile header', 'soleng') ),
				"std" => '',
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"refresh" => false,
				"teeny" => false,
				"rows" => 20,
				"type" => SOLENG_THEME_FREE ? "hidden" : "text_editor"
				),
			'header_mobile_hide_info' => array(
				"title" => esc_html__('Hide additional info', 'soleng'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_logo' => array(
				"title" => esc_html__('Hide logo', 'soleng'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_login' => array(
				"title" => esc_html__('Hide login/logout', 'soleng'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_search' => array(
				"title" => esc_html__('Hide search', 'soleng'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_cart' => array(
				"title" => esc_html__('Hide cart', 'soleng'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
				),


		
			// 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'soleng'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 50,
				"type" => "section"
				),
			'footer_type' => array(
				"title" => esc_html__('Footer style', 'soleng'),
				"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'soleng')
				),
				"std" => 'default',
				"options" => soleng_get_list_header_footer_types(),
				"type" => SOLENG_THEME_FREE || !soleng_exists_trx_addons() ? "hidden" : "switch"
				),
			'footer_style' => array(
				"title" => esc_html__('Select custom layout', 'soleng'),
				"desc" => wp_kses( __("Select custom footer from Layouts Builder", 'soleng'), 'soleng_kses_content' ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'soleng')
				),
				"dependency" => array(
					'footer_type' => array('custom')
				),
				"std" => SOLENG_THEME_FREE ? 'footer-custom-sow-footer-default' : 'footer-custom-footer-default',
				"options" => array(),
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'soleng'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'soleng')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 'footer_widgets',
				"options" => array(),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'soleng'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'soleng')
				),
				"dependency" => array(
					'footer_type' => array('default'),
					'footer_widgets' => array('^hide')
				),
				"std" => 3,
				"options" => soleng_get_list_range(0,6),
				"type" => "select"
				),
			'footer_wide' => array(
				"title" => esc_html__('Footer fullwidth', 'soleng'),
				"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'soleng') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'soleng')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_in_footer' => array(
				"title" => esc_html__('Show logo', 'soleng'),
				"desc" => wp_kses_data( __('Show logo in the footer', 'soleng') ),
				'refresh' => false,
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_footer' => array(
				"title" => esc_html__('Logo for footer', 'soleng'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the footer', 'soleng') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1)
				),
				"std" => '',
				"type" => "image"
				),
			'logo_footer_retina' => array(
				"title" => esc_html__('Logo for footer (Retina)', 'soleng'),
				"desc" => wp_kses_data( __('Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'soleng') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1),
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => SOLENG_THEME_FREE ? "hidden" : "image"
				),
			'socials_in_footer' => array(
				"title" => esc_html__('Show social icons', 'soleng'),
				"desc" => wp_kses_data( __('Show social icons in the footer (under logo or footer widgets)', 'soleng') ),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => !soleng_exists_trx_addons() ? "hidden" : "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'soleng'),
				"desc" => wp_kses_data( __('Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'soleng') ),
				"translate" => true,
				"std" => esc_html__('Copyright &copy; {Y} by AxiomThemes. All rights reserved.', 'soleng'),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"refresh" => false,
				"type" => "textarea"
				),
			
		
		
			// 'Blog'
			'blog' => array(
				"title" => esc_html__('Blog', 'soleng'),
				"desc" => wp_kses_data( __('Options of the the blog archive', 'soleng') ),
				"priority" => 70,
				"type" => "panel",
				),
		
				// Blog - Posts page
				'blog_general' => array(
					"title" => esc_html__('Posts page', 'soleng'),
					"desc" => wp_kses_data( __('Style and components of the blog archive', 'soleng') ),
					"type" => "section",
					),
				'blog_general_info' => array(
					"title" => esc_html__('General settings', 'soleng'),
					"desc" => '',
					"type" => "info",
					),
				'blog_style' => array(
					"title" => esc_html__('Blog style', 'soleng'),
					"desc" => '',
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'soleng')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => 'excerpt',
					"options" => array(),
					"type" => "select"
					),
				'first_post_large' => array(
					"title" => esc_html__('First post large', 'soleng'),
					"desc" => wp_kses_data( __('Make your first post stand out by making it bigger', 'soleng') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'soleng')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('classic', 'masonry')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				"blog_content" => array( 
					"title" => esc_html__('Posts content', 'soleng'),
					"desc" => wp_kses_data( __("Display either post excerpts or the full post content", 'soleng') ),
					"std" => "excerpt",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"options" => array(
						'excerpt'	=> esc_html__('Excerpt',	'soleng'),
						'fullpost'	=> esc_html__('Full post',	'soleng')
					),
					"type" => "switch"
					),
				'excerpt_length' => array(
					"title" => esc_html__('Excerpt length', 'soleng'),
					"desc" => wp_kses_data( __("Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged", 'soleng') ),
					"dependency" => array(
						'blog_style' => array('excerpt'),
						'blog_content' => array('excerpt')
					),
					"std" => 30,
					"type" => "text"
					),
				'blog_columns' => array(
					"title" => esc_html__('Blog columns', 'soleng'),
					"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'soleng') ),
					"std" => 2,
					"options" => soleng_get_list_range(2,4),
					"type" => "hidden"
					),
				'post_type' => array(
					"title" => esc_html__('Post type', 'soleng'),
					"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'soleng') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'soleng')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"linked" => 'parent_cat',
					"refresh" => false,
					"hidden" => true,
					"std" => 'post',
					"options" => array(),
					"type" => "select"
					),
				'parent_cat' => array(
					"title" => esc_html__('Category to show', 'soleng'),
					"desc" => wp_kses_data( __('Select category to show in the blog archive', 'soleng') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'soleng')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"refresh" => false,
					"hidden" => true,
					"std" => '0',
					"options" => array(),
					"type" => "select"
					),
				'posts_per_page' => array(
					"title" => esc_html__('Posts per page', 'soleng'),
					"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'soleng') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'soleng')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"hidden" => true,
					"std" => '',
					"type" => "text"
					),
				"blog_pagination" => array( 
					"title" => esc_html__('Pagination style', 'soleng'),
					"desc" => wp_kses_data( __('Show pagination below the posts list', 'soleng') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'soleng')
					),
					"std" => "pages",
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"options" => array(
						'pages'	=> esc_html__("Page numbers", 'soleng'),
						'infinite' => esc_html__("Infinite scroll", 'soleng')
					),
					"type" => "select"
					),
				'show_filters' => array(
					"title" => esc_html__('Show filters', 'soleng'),
					"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'soleng') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'soleng')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('portfolio', 'gallery')
					),
					"hidden" => true,
					"std" => 0,
					"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
					),
	
				'blog_sidebar_info' => array(
					"title" => esc_html__('Sidebar', 'soleng'),
					"desc" => '',
					"type" => "info",
					),
				'sidebar_position_blog' => array(
					"title" => esc_html__('Sidebar position', 'soleng'),
					"desc" => wp_kses_data( __('Select position to show sidebar', 'soleng') ),
					"std" => 'right',
					"options" => array(),
					"type" => "switch"
					),
				'sidebar_widgets_blog' => array(
					"title" => esc_html__('Sidebar widgets', 'soleng'),
					"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'soleng') ),
					"dependency" => array(
						'sidebar_position_blog' => array('left', 'right')
					),
					"std" => 'sidebar_widgets',
					"options" => array(),
					"type" => "select"
					),
				'expand_content_blog' => array(
					"title" => esc_html__('Expand content', 'soleng'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'soleng') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
	
	
				'blog_widgets_info' => array(
					"title" => esc_html__('Additional widgets', 'soleng'),
					"desc" => '',
					"type" => SOLENG_THEME_FREE ? "hidden" : "info",
					),
				'widgets_above_page_blog' => array(
					"title" => esc_html__('Widgets at the top of the page', 'soleng'),
					"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'soleng') ),
					"std" => 'hide',
					"options" => array(),
					"type" => SOLENG_THEME_FREE ? "hidden" : "select"
					),
				'widgets_above_content_blog' => array(
					"title" => esc_html__('Widgets above the content', 'soleng'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'soleng') ),
					"std" => 'hide',
					"options" => array(),
					"type" => SOLENG_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_content_blog' => array(
					"title" => esc_html__('Widgets below the content', 'soleng'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'soleng') ),
					"std" => 'hide',
					"options" => array(),
					"type" => SOLENG_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_page_blog' => array(
					"title" => esc_html__('Widgets at the bottom of the page', 'soleng'),
					"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'soleng') ),
					"std" => 'hide',
					"options" => array(),
					"type" => SOLENG_THEME_FREE ? "hidden" : "select"
					),

				'blog_advanced_info' => array(
					"title" => esc_html__('Advanced settings', 'soleng'),
					"desc" => '',
					"type" => "info",
					),
				'no_image' => array(
					"title" => esc_html__('Image placeholder', 'soleng'),
					"desc" => wp_kses_data( __('Select or upload an image used as placeholder for posts without a featured image', 'soleng') ),
					"std" => '',
					"type" => "image"
					),
				'time_diff_before' => array(
					"title" => esc_html__('Easy Readable Date Format', 'soleng'),
					"desc" => wp_kses_data( __("For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'soleng') ),
					"std" => 5,
					"type" => "text"
					),
				'sticky_style' => array(
					"title" => esc_html__('Sticky posts style', 'soleng'),
					"desc" => wp_kses_data( __('Select style of the sticky posts output', 'soleng') ),
					"std" => 'inherit',
					"options" => array(
						'inherit' => esc_html__('Decorated posts', 'soleng'),
						'columns' => esc_html__('Mini-cards',	'soleng')
					),
					"type" => SOLENG_THEME_FREE ? "hidden" : "select"
					),
				"blog_animation" => array( 
					"title" => esc_html__('Animation for the posts', 'soleng'),
					"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'soleng') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'soleng')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => "none",
					"options" => array(),
					"type" => SOLENG_THEME_FREE ? "hidden" : "select"
					),
				'meta_parts' => array(
					"title" => esc_html__('Post meta', 'soleng'),
					"desc" => wp_kses_data( __("If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Counters and Share Links are available only if plugin ThemeREX Addons is active", 'soleng') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'soleng')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|author=1|counters=0',
					"options" => array(
						'categories' => esc_html__('Categories', 'soleng'),
						'date'		 => esc_html__('Post date', 'soleng'),
						'author'	 => esc_html__('Post author', 'soleng'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'soleng')
					),
					"type" => SOLENG_THEME_FREE ? "hidden" : "checklist"
				),
				'counters' => array(
					"title" => esc_html__('Views, Likes and Comments', 'soleng'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'soleng') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'soleng')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=0|likes=0|comments=0',
					"options" => array(
						'views' => esc_html__('Views', 'soleng'),
						'likes' => esc_html__('Likes', 'soleng'),
						'comments' => esc_html__('Comments', 'soleng')
					),
					"type" => SOLENG_THEME_FREE || !soleng_exists_trx_addons() ? "hidden" : "checklist"
				),

				
				// Blog - Single posts
				'blog_single' => array(
					"title" => esc_html__('Single posts', 'soleng'),
					"desc" => wp_kses_data( __('Settings of the single post', 'soleng') ),
					"type" => "section",
					),
				'hide_featured_on_single' => array(
					"title" => esc_html__('Hide featured image on the single post', 'soleng'),
					"desc" => wp_kses_data( __("Hide featured image on the single post's pages", 'soleng') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'soleng')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'hide_sidebar_on_single' => array(
					"title" => esc_html__('Hide sidebar on the single post', 'soleng'),
					"desc" => wp_kses_data( __("Hide sidebar on the single post's pages", 'soleng') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'show_post_meta' => array(
					"title" => esc_html__('Show post meta', 'soleng'),
					"desc" => wp_kses_data( __("Display block with post's meta: date, categories, counters, etc.", 'soleng') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'meta_parts_post' => array(
					"title" => esc_html__('Post meta', 'soleng'),
					"desc" => wp_kses_data( __("Meta parts for single posts. Counters and Share Links are available only if plugin ThemeREX Addons is active", 'soleng') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|author=1',
					"options" => array(
						'categories' => esc_html__('Categories', 'soleng'),
						'date'		 => esc_html__('Post date', 'soleng'),
						'author'	 => esc_html__('Post author', 'soleng')
					),
					"type" => SOLENG_THEME_FREE ? "hidden" : "checklist"
				),
				'counters_post' => array(
					"title" => esc_html__('Views, Likes and Comments', 'soleng'),
					"desc" => wp_kses_data( __("Likes and Views are available only if plugin ThemeREX Addons is active", 'soleng') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"hidden" => true,
					"std" => 'views=0|likes=0|comments=0',
					"options" => array(
						'views' => esc_html__('Views', 'soleng'),
						'likes' => esc_html__('Likes', 'soleng'),
						'comments' => esc_html__('Comments', 'soleng')
					),
					"type" => SOLENG_THEME_FREE || !soleng_exists_trx_addons() ? "hidden" : "checklist"
				),
				'show_share_links' => array(
					"title" => esc_html__('Show share links', 'soleng'),
					"desc" => wp_kses_data( __("Display share links on the single post", 'soleng') ),
					"std" => 1,
					"type" => !soleng_exists_trx_addons() ? "hidden" : "checkbox"
					),
				'show_author_info' => array(
					"title" => esc_html__('Show author info', 'soleng'),
					"desc" => wp_kses_data( __("Display block with information about post's author", 'soleng') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'blog_single_related_info' => array(
					"title" => esc_html__('Related posts', 'soleng'),
					"desc" => '',
					"type" => "info",
					),
				'show_related_posts' => array(
					"title" => esc_html__('Show related posts', 'soleng'),
					"desc" => wp_kses_data( __("Show section 'Related posts' on the single post's pages", 'soleng') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'soleng')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'related_posts' => array(
					"title" => esc_html__('Related posts', 'soleng'),
					"desc" => wp_kses_data( __('How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'soleng') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"hidden" => true,
					"std" => 2,
					"options" => soleng_get_list_range(1,9),
					"type" => SOLENG_THEME_FREE ? "hidden" : "select"
					),
				'related_columns' => array(
					"title" => esc_html__('Related columns', 'soleng'),
					"desc" => wp_kses_data( __('How many columns should be used to output related posts in the single page?', 'soleng') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"hidden" => true,
					"std" => 2,
					"options" => soleng_get_list_range(1,2),
					"type" => SOLENG_THEME_FREE ? "hidden" : "switch"
					),
				'related_style' => array(
					"title" => esc_html__('Related posts style', 'soleng'),
					"desc" => wp_kses_data( __('Select style of the related posts output', 'soleng') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"hidden" => true,
					"std" => 2,
					"options" => soleng_get_list_styles(2,2),
					"type" => SOLENG_THEME_FREE ? "hidden" : "switch"
					),
			'blog_end' => array(
				"type" => "panel_end",
				),
			
		
		
			// 'Colors'
			'panel_colors' => array(
				"title" => esc_html__('Colors', 'soleng'),
				"desc" => '',
				"priority" => 300,
				"type" => "section"
				),

			'color_schemes_info' => array(
				"title" => esc_html__('Color schemes', 'soleng'),
				"desc" => wp_kses_data( __('Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'soleng') ),
				"type" => "info",
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'soleng'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'soleng')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'soleng'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'soleng')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Sidemenu Color Scheme', 'soleng'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'soleng')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => SOLENG_THEME_FREE ? "hidden" : "switch"
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Sidebar Color Scheme', 'soleng'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'soleng')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'soleng'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'soleng')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),

			'color_scheme_editor_info' => array(
				"title" => esc_html__('Color scheme editor', 'soleng'),
				"desc" => wp_kses_data(__('Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'soleng') ),
				"type" => "info",
				),
			'scheme_storage' => array(
				"title" => esc_html__('Color scheme editor', 'soleng'),
				"desc" => '',
				"std" => '$soleng_get_scheme_storage',
				"refresh" => false,
				"colorpicker" => "tiny",
				"type" => "scheme_editor"
				),


			// 'Hidden'
			'media_title' => array(
				"title" => esc_html__('Media title', 'soleng'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'soleng') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'soleng')
				),
				"hidden" => true,
				"std" => '',
				"type" => SOLENG_THEME_FREE ? "hidden" : "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'soleng'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'soleng') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'soleng')
				),
				"hidden" => true,
				"std" => '',
				"type" => SOLENG_THEME_FREE ? "hidden" : "text"
				),


			// Internal options.
			// Attention! Don't change any options in the section below!
			// Use huge priority to call render this elements after all options!
			'reset_options' => array(
				"title" => '',
				"desc" => '',
				"std" => '0',
				"priority" => 10000,
				"type" => "hidden",
				),

			'last_option' => array(		// Need to manually call action to include Tiny MCE scripts
				"title" => '',
				"desc" => '',
				"std" => 1,
				"type" => "hidden",
				),

		));


		// Prepare panel 'Fonts'
		$fonts = array(
		
			// 'Fonts'
			'fonts' => array(
				"title" => esc_html__('Typography', 'soleng'),
				"desc" => '',
				"priority" => 200,
				"type" => "panel"
				),

			// Fonts - Load_fonts
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'soleng'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'soleng') )
						. '<br>'
						. wp_kses_data( __('<b>Attention!</b> Press "Refresh" button to reload preview area after the all fonts are changed', 'soleng') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'soleng'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'soleng') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'soleng') ),
				"class" => "soleng_column-1_3 soleng_new_row",
				"refresh" => false,
				"std" => '$soleng_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=soleng_get_theme_setting('max_load_fonts'); $i++) {
			if (soleng_get_value_gp('page') != 'theme_options') {
				$fonts["load_fonts-{$i}-info"] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					"title" => esc_html(sprintf(esc_html__('Font %s', 'soleng'), $i)),
					"desc" => '',
					"type" => "info",
					);
			}
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'soleng'),
				"desc" => '',
				"class" => "soleng_column-1_3 soleng_new_row",
				"refresh" => false,
				"std" => '$soleng_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'soleng'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'soleng') )
							: '',
				"class" => "soleng_column-1_3",
				"refresh" => false,
				"std" => '$soleng_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'soleng'),
					'serif' => esc_html__('serif', 'soleng'),
					'sans-serif' => esc_html__('sans-serif', 'soleng'),
					'monospace' => esc_html__('monospace', 'soleng'),
					'cursive' => esc_html__('cursive', 'soleng'),
					'fantasy' => esc_html__('fantasy', 'soleng')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'soleng'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'soleng') )
								. '<br>'
								. wp_kses_data( __('<b>Attention!</b> Each weight and style increase download size! Specify only used weights and styles.', 'soleng') )
							: '',
				"class" => "soleng_column-1_3",
				"refresh" => false,
				"std" => '$soleng_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = soleng_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html(sprintf(esc_html__('%s settings', 'soleng'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								// Translators: Add tag's name to make description
								: wp_kses( sprintf(esc_html__('Font settings of the "%s" tag.', 'soleng'), $tag), 'soleng_kses_content' ),
				"type" => "section",
				);
	
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$options = '';
				$type = 'text';
				$load_order = 1;
				$title = ucfirst(str_replace('-', ' ', $css_prop));
				if ($css_prop == 'font-family') {
					$type = 'select';
					$options = array();
					$load_order = 2;		// Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} else if ($css_prop == 'font-weight') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'soleng'),
						'100' => esc_html__('100 (Light)', 'soleng'), 
						'200' => esc_html__('200 (Light)', 'soleng'), 
						'300' => esc_html__('300 (Thin)',  'soleng'),
						'400' => esc_html__('400 (Normal)', 'soleng'),
						'500' => esc_html__('500 (Semibold)', 'soleng'),
						'600' => esc_html__('600 (Semibold)', 'soleng'),
						'700' => esc_html__('700 (Bold)', 'soleng'),
						'800' => esc_html__('800 (Black)', 'soleng'),
						'900' => esc_html__('900 (Black)', 'soleng')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'soleng'),
						'normal' => esc_html__('Normal', 'soleng'), 
						'italic' => esc_html__('Italic', 'soleng')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'soleng'),
						'none' => esc_html__('None', 'soleng'), 
						'underline' => esc_html__('Underline', 'soleng'),
						'overline' => esc_html__('Overline', 'soleng'),
						'line-through' => esc_html__('Line-through', 'soleng')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'soleng'),
						'none' => esc_html__('None', 'soleng'), 
						'uppercase' => esc_html__('Uppercase', 'soleng'),
						'lowercase' => esc_html__('Lowercase', 'soleng'),
						'capitalize' => esc_html__('Capitalize', 'soleng')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"class" => "soleng_column-1_5",
					"refresh" => false,
					"load_order" => $load_order,
					"std" => '$soleng_get_theme_fonts_option',
					"options" => $options,
					"type" => $type
				);
			}
			
			$fonts["{$tag}_section_end"] = array(
				"type" => "section_end"
				);
		}

		$fonts['fonts_end'] = array(
			"type" => "panel_end"
			);

		// Add fonts parameters to Theme Options
		soleng_storage_set_array_before('options', 'panel_colors', $fonts);

		// Add Header Video if WP version < 4.7
		if (!function_exists('get_header_video_url')) {
			soleng_storage_set_array_after('options', 'header_image_override', 'header_video', array(
				"title" => esc_html__('Header video', 'soleng'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'soleng') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'soleng')
				),
				"std" => '',
				"type" => "video"
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is 'Theme Options'
		if (!function_exists('the_custom_logo') || (isset($_REQUEST['page']) && $_REQUEST['page']=='theme_options')) {
			soleng_storage_set_array_before('options', 'logo_retina', function_exists('the_custom_logo') ? 'custom_logo' : 'logo', array(
				"title" => esc_html__('Logo', 'soleng'),
				"desc" => wp_kses_data( __('Select or upload the site logo', 'soleng') ),
				"class" => "soleng_column-1_2 soleng_new_row",
				"priority" => 60,
				"std" => '',
				"type" => "image"
				)
			);
		}
	}
}


// Returns a list of options that can be overridden for CPT
if (!function_exists('soleng_options_get_list_cpt_options')) {
	function soleng_options_get_list_cpt_options($cpt, $title='') {
		if (empty($title)) $title = ucfirst($cpt);
		return array(
					"header_info_{$cpt}" => array(
						"title" => esc_html__('Header', 'soleng'),
						"desc" => '',
						"type" => "info",
						),
					"header_type_{$cpt}" => array(
						"title" => esc_html__('Header style', 'soleng'),
						"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'soleng') ),
						"std" => 'inherit',
						"options" => soleng_get_list_header_footer_types(true),
						"type" => SOLENG_THEME_FREE ? "hidden" : "switch"
						),
					"header_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'soleng'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select custom layout to display the site header on the %s pages', 'soleng'), $title) ),
						"dependency" => array(
							"header_type_{$cpt}" => array('custom')
						),
						"std" => 'inherit',
						"options" => array(),
						"type" => SOLENG_THEME_FREE ? "hidden" : "select"
						),
					"header_position_{$cpt}" => array(
						"title" => esc_html__('Header position', 'soleng'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to display the site header on the %s pages', 'soleng'), $title) ),
						"std" => 'inherit',
						"options" => array(),
						"type" => SOLENG_THEME_FREE ? "hidden" : "switch"
						),
					"header_image_override_{$cpt}" => array(
						"title" => esc_html__('Header image override', 'soleng'),
						"desc" => wp_kses_data( __("Allow override the header image with the post's featured image", 'soleng') ),
						"std" => 0,
						"type" => SOLENG_THEME_FREE ? "hidden" : "checkbox"
						),
					"header_widgets_{$cpt}" => array(
						"title" => esc_html__('Header widgets', 'soleng'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select set of widgets to show in the header on the %s pages', 'soleng'), $title) ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
						
					"sidebar_info_{$cpt}" => array(
						"title" => esc_html__('Sidebar', 'soleng'),
						"desc" => '',
						"type" => "info",
						),
					"sidebar_position_{$cpt}" => array(
						"title" => esc_html__('Sidebar position', 'soleng'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to show sidebar on the %s pages', 'soleng'), $title) ),
						"std" => 'left',
						"options" => array(),
						"type" => "switch"
						),
					"sidebar_widgets_{$cpt}" => array(
						"title" => esc_html__('Sidebar widgets', 'soleng'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select sidebar to show on the %s pages', 'soleng'), $title) ),
						"dependency" => array(
							"sidebar_position_{$cpt}" => array('left', 'right')
						),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"hide_sidebar_on_single_{$cpt}" => array(
						"title" => esc_html__('Hide sidebar on the single pages', 'soleng'),
						"desc" => wp_kses_data( __("Hide sidebar on the single page", 'soleng') ),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"footer_info_{$cpt}" => array(
						"title" => esc_html__('Footer', 'soleng'),
						"desc" => '',
						"type" => "info",
						),
					"footer_type_{$cpt}" => array(
						"title" => esc_html__('Footer style', 'soleng'),
						"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'soleng') ),
						"std" => 'inherit',
						"options" => soleng_get_list_header_footer_types(true),
						"type" => SOLENG_THEME_FREE ? "hidden" : "switch"
						),
					"footer_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'soleng'),
						"desc" => wp_kses_data( __('Select custom layout to display the site footer', 'soleng') ),
						"std" => 'inherit',
						"dependency" => array(
							"footer_type_{$cpt}" => array('custom')
						),
						"options" => array(),
						"type" => SOLENG_THEME_FREE ? "hidden" : "select"
						),
					"footer_widgets_{$cpt}" => array(
						"title" => esc_html__('Footer widgets', 'soleng'),
						"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'soleng') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 'footer_widgets',
						"options" => array(),
						"type" => "select"
						),
					"footer_columns_{$cpt}" => array(
						"title" => esc_html__('Footer columns', 'soleng'),
						"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'soleng') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default'),
							"footer_widgets_{$cpt}" => array('^hide')
						),
						"std" => 3,
						"options" => soleng_get_list_range(0,6),
						"type" => "select"
						),
					"footer_wide_{$cpt}" => array(
						"title" => esc_html__('Footer fullwidth', 'soleng'),
						"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'soleng') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"widgets_info_{$cpt}" => array(
						"title" => esc_html__('Additional panels', 'soleng'),
						"desc" => '',
						"type" => SOLENG_THEME_FREE ? "hidden" : "info",
						),
					"widgets_above_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the top of the page', 'soleng'),
						"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'soleng') ),
						"std" => 'hide',
						"options" => array(),
						"type" => SOLENG_THEME_FREE ? "hidden" : "select"
						),
					"widgets_above_content_{$cpt}" => array(
						"title" => esc_html__('Widgets above the content', 'soleng'),
						"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'soleng') ),
						"std" => 'hide',
						"options" => array(),
						"type" => SOLENG_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_content_{$cpt}" => array(
						"title" => esc_html__('Widgets below the content', 'soleng'),
						"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'soleng') ),
						"std" => 'hide',
						"options" => array(),
						"type" => SOLENG_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the bottom of the page', 'soleng'),
						"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'soleng') ),
						"std" => 'hide',
						"options" => array(),
						"type" => SOLENG_THEME_FREE ? "hidden" : "select"
						)
					);
	}
}


// Return lists with choises when its need in the admin mode
if (!function_exists('soleng_options_get_list_choises')) {
	add_filter('soleng_filter_options_get_list_choises', 'soleng_options_get_list_choises', 10, 2);
	function soleng_options_get_list_choises($list, $id) {
		if (is_array($list) && count($list)==0) {
			if (strpos($id, 'header_style')===0)
				$list = soleng_get_list_header_styles(strpos($id, 'header_style_')===0);
			else if (strpos($id, 'header_position')===0)
				$list = soleng_get_list_header_positions(strpos($id, 'header_position_')===0);
			else if (strpos($id, 'header_widgets')===0)
				$list = soleng_get_list_sidebars(strpos($id, 'header_widgets_')===0, true);
			else if (strpos($id, '_scheme') > 0)
				$list = soleng_get_list_schemes($id!='color_scheme');
			else if (strpos($id, 'sidebar_widgets')===0)
				$list = soleng_get_list_sidebars(strpos($id, 'sidebar_widgets_')===0, true);
			else if (strpos($id, 'sidebar_position')===0)
				$list = soleng_get_list_sidebars_positions(strpos($id, 'sidebar_position_')===0);
			else if (strpos($id, 'widgets_above_page')===0)
				$list = soleng_get_list_sidebars(strpos($id, 'widgets_above_page_')===0, true);
			else if (strpos($id, 'widgets_above_content')===0)
				$list = soleng_get_list_sidebars(strpos($id, 'widgets_above_content_')===0, true);
			else if (strpos($id, 'widgets_below_page')===0)
				$list = soleng_get_list_sidebars(strpos($id, 'widgets_below_page_')===0, true);
			else if (strpos($id, 'widgets_below_content')===0)
				$list = soleng_get_list_sidebars(strpos($id, 'widgets_below_content_')===0, true);
			else if (strpos($id, 'footer_style')===0)
				$list = soleng_get_list_footer_styles(strpos($id, 'footer_style_')===0);
			else if (strpos($id, 'footer_widgets')===0)
				$list = soleng_get_list_sidebars(strpos($id, 'footer_widgets_')===0, true);
			else if (strpos($id, 'blog_style')===0)
				$list = soleng_get_list_blog_styles(strpos($id, 'blog_style_')===0);
			else if (strpos($id, 'post_type')===0)
				$list = soleng_get_list_posts_types();
			else if (strpos($id, 'parent_cat')===0)
				$list = soleng_array_merge(array(0 => esc_html__('- Select category -', 'soleng')), soleng_get_list_categories());
			else if (strpos($id, 'blog_animation')===0)
				$list = soleng_get_list_animations_in();
			else if ($id == 'color_scheme_editor')
				$list = soleng_get_list_schemes();
			else if (strpos($id, '_font-family') > 0)
				$list = soleng_get_list_load_fonts(true);
		}
		return $list;
	}
}
?>