<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0.10
 */


// Socials
if ( soleng_is_on(soleng_get_theme_option('socials_in_footer')) && ($soleng_output = soleng_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php soleng_show_layout($soleng_output); ?>
		</div>
	</div>
	<?php
}
?>