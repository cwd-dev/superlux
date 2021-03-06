<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

// Header sidebar
$soleng_header_name = soleng_get_theme_option('header_widgets');
$soleng_header_present = !soleng_is_off($soleng_header_name) && is_active_sidebar($soleng_header_name);
if ($soleng_header_present) { 
	soleng_storage_set('current_sidebar', 'header');
	$soleng_header_wide = soleng_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($soleng_header_name) ) {
		dynamic_sidebar($soleng_header_name);
	}
	$soleng_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($soleng_widgets_output)) {
		$soleng_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $soleng_widgets_output);
		$soleng_need_columns = strpos($soleng_widgets_output, 'columns_wrap')===false;
		if ($soleng_need_columns) {
			$soleng_columns = max(0, (int) soleng_get_theme_option('header_columns'));
			if ($soleng_columns == 0) $soleng_columns = min(6, max(1, substr_count($soleng_widgets_output, '<aside ')));
			if ($soleng_columns > 1)
				$soleng_widgets_output = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($soleng_columns).' widget', $soleng_widgets_output);
			else
				$soleng_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($soleng_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$soleng_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($soleng_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'soleng_action_before_sidebar' );
				soleng_show_layout($soleng_widgets_output);
				do_action( 'soleng_action_after_sidebar' );
				if ($soleng_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$soleng_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>