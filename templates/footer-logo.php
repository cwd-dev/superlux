<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0.10
 */

// Logo
if (soleng_is_on(soleng_get_theme_option('logo_in_footer'))) {
	$soleng_logo_image = '';
	if (soleng_is_on(soleng_get_theme_option('logo_retina_enabled')) && soleng_get_retina_multiplier() > 1)
		$soleng_logo_image = soleng_get_theme_option( 'logo_footer_retina' );
	if (empty($soleng_logo_image)) 
		$soleng_logo_image = soleng_get_theme_option( 'logo_footer' );
	$soleng_logo_text   = get_bloginfo( 'name' );
	if (!empty($soleng_logo_image) || !empty($soleng_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($soleng_logo_image)) {
					$soleng_attr = soleng_getimagesize($soleng_logo_image);
					echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($soleng_logo_image).'" class="logo_footer_image" alt="'. esc_attr(basename($soleng_logo_image)).'"'.(!empty($soleng_attr[3]) ? ' ' . wp_kses_data($soleng_attr[3]) : '').'></a>' ;
				} else if (!empty($soleng_logo_text)) {
					echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($soleng_logo_text) . '</a></h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>