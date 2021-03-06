<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0.10
 */

$soleng_footer_id = str_replace('footer-custom-', '', soleng_get_theme_option("footer_style"));
if ((int) $soleng_footer_id == 0) {
	$soleng_footer_id = soleng_get_post_id(array(
												'name' => $soleng_footer_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$soleng_footer_id = apply_filters('soleng_filter_get_translated_layout', $soleng_footer_id);
}
$soleng_footer_meta = get_post_meta($soleng_footer_id, 'trx_addons_options', true);
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($soleng_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($soleng_footer_id))); 
						if (!empty($soleng_footer_meta['margin']) != '') 
							echo ' '.esc_attr(soleng_add_inline_css_class('margin-top: '.soleng_prepare_css_value($soleng_footer_meta['margin']).';'));
						if (!soleng_is_inherit(soleng_get_theme_option('footer_scheme')))
							echo ' scheme_' . esc_attr(soleng_get_theme_option('footer_scheme'));
						?>">
	<?php
    // Custom footer's layout
    do_action('soleng_action_show_layout', $soleng_footer_id);
	?>
</footer><!-- /.footer_wrap -->
