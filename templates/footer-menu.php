<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0.10
 */

// Footer menu
$soleng_menu_footer = soleng_get_nav_menu(array(
											'location' => 'menu_footer',
											'class' => 'sc_layouts_menu sc_layouts_menu_default'
											));
if (!empty($soleng_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php soleng_show_layout($soleng_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>