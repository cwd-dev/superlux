<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

						// Widgets area inside page content
						soleng_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					soleng_create_widgets_area('widgets_below_page');

					$soleng_body_style = soleng_get_theme_option('body_style');
					if ($soleng_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$soleng_footer_type = soleng_get_theme_option("footer_type");
			if ($soleng_footer_type == 'custom' && !soleng_is_layouts_available())
				$soleng_footer_type = 'default';
			get_template_part( "templates/footer-{$soleng_footer_type}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (soleng_is_on(soleng_get_theme_option('debug_mode')) && soleng_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(soleng_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>