<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

$soleng_args = get_query_var('soleng_logo_args');

// Site logo
$soleng_logo_type   = isset($soleng_args['type']) ? $soleng_args['type'] : '';
$soleng_logo_image  = soleng_get_logo_image($soleng_logo_type);
$soleng_logo_text   = soleng_is_on(soleng_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$soleng_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($soleng_logo_image) || !empty($soleng_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($soleng_logo_image)) {
			if (empty($soleng_logo_type) && function_exists('the_custom_logo') && (int) $soleng_logo_image > 0) {
				the_custom_logo();
			} else {
				$soleng_attr = soleng_getimagesize($soleng_logo_image);
				echo '<img src="'.esc_url($soleng_logo_image).'" alt="'. esc_attr(basename($soleng_logo_image)).'"'.(!empty($soleng_attr[3]) ? ' '.wp_kses_data($soleng_attr[3]) : '').'>';
			}
		} else {
			soleng_show_layout(soleng_prepare_macros($soleng_logo_text), '<span class="logo_text">', '</span>');
			soleng_show_layout(soleng_prepare_macros($soleng_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>