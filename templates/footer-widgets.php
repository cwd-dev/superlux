<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0.10
 */

// Footer sidebar
$soleng_footer_name = soleng_get_theme_option('footer_widgets');
$soleng_footer_present = !soleng_is_off($soleng_footer_name) && is_active_sidebar($soleng_footer_name);
if ($soleng_footer_present) { 
	soleng_storage_set('current_sidebar', 'footer');
	$soleng_footer_wide = soleng_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($soleng_footer_name) ) {
		dynamic_sidebar($soleng_footer_name);
	}
	$soleng_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($soleng_out)) {
		$soleng_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $soleng_out);
		$soleng_need_columns = true;
		if ($soleng_need_columns) {
			$soleng_columns = max(0, (int) soleng_get_theme_option('footer_columns'));
			if ($soleng_columns == 0) $soleng_columns = min(4, max(1, substr_count($soleng_out, '<aside ')));
			if ($soleng_columns > 1)
				$soleng_out = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($soleng_columns).' widget', $soleng_out);
			else
				$soleng_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($soleng_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$soleng_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($soleng_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'soleng_action_before_sidebar' );
				soleng_show_layout($soleng_out);
				do_action( 'soleng_action_after_sidebar' );
				if ($soleng_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$soleng_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>