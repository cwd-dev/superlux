<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

if (soleng_sidebar_present()) {
	ob_start();
	$soleng_sidebar_name = soleng_get_theme_option('sidebar_widgets');
	soleng_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($soleng_sidebar_name) ) {
		dynamic_sidebar($soleng_sidebar_name);
	}
	$soleng_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($soleng_out)) {
		$soleng_sidebar_position = soleng_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($soleng_sidebar_position); ?> widget_area<?php if (!soleng_is_inherit(soleng_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(soleng_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'soleng_action_before_sidebar' );
				soleng_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $soleng_out));
				do_action( 'soleng_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>