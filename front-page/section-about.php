<div class="front_page_section front_page_section_about<?php
			$soleng_scheme = soleng_get_theme_option('front_page_about_scheme');
			if (!soleng_is_inherit($soleng_scheme)) echo ' scheme_'.esc_attr($soleng_scheme);
			echo ' front_page_section_paddings_'.esc_attr(soleng_get_theme_option('front_page_about_paddings'));
		?>"<?php
		$soleng_css = '';
		$soleng_bg_image = soleng_get_theme_option('front_page_about_bg_image');
		if (!empty($soleng_bg_image)) 
			$soleng_css .= 'background-image: url('.esc_url(soleng_get_attachment_url($soleng_bg_image)).');';
		if (!empty($soleng_css))
			echo ' style="' . esc_attr($soleng_css) . '"';
?>><?php
	// Add anchor
	$soleng_anchor_icon = soleng_get_theme_option('front_page_about_anchor_icon');	
	$soleng_anchor_text = soleng_get_theme_option('front_page_about_anchor_text');	
	if ((!empty($soleng_anchor_icon) || !empty($soleng_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_about"'
										. (!empty($soleng_anchor_icon) ? ' icon="'.esc_attr($soleng_anchor_icon).'"' : '')
										. (!empty($soleng_anchor_text) ? ' title="'.esc_attr($soleng_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_about_inner<?php
			if (soleng_get_theme_option('front_page_about_fullheight'))
				echo ' soleng-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$soleng_css = '';
			$soleng_bg_mask = soleng_get_theme_option('front_page_about_bg_mask');
			$soleng_bg_color = soleng_get_theme_option('front_page_about_bg_color');
			if (!empty($soleng_bg_color) && $soleng_bg_mask > 0)
				$soleng_css .= 'background-color: '.esc_attr($soleng_bg_mask==1
																	? $soleng_bg_color
																	: soleng_hex2rgba($soleng_bg_color, $soleng_bg_mask)
																).';';
			if (!empty($soleng_css))
				echo ' style="' . esc_attr($soleng_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$soleng_caption = soleng_get_theme_option('front_page_about_caption');
			if (!empty($soleng_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo !empty($soleng_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses($soleng_caption, 'soleng_kses_content'); ?></h2><?php
			}
		
			// Description (text)
			$soleng_description = soleng_get_theme_option('front_page_about_description');
			if (!empty($soleng_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo !empty($soleng_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses(wpautop($soleng_description), 'soleng_kses_content'); ?></div><?php
			}
			
			// Content
			$soleng_content = soleng_get_theme_option('front_page_about_content');
			if (!empty($soleng_content) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo !empty($soleng_content) ? 'filled' : 'empty'; ?>"><?php
					$soleng_page_content_mask = '%%CONTENT%%';
					if (strpos($soleng_content, $soleng_page_content_mask) !== false) {
						$soleng_content = preg_replace(
									'/(\<p\>\s*)?'.$soleng_page_content_mask.'(\s*\<\/p\>)/i',
									sprintf('<div class="front_page_section_about_source">%s</div>',
												apply_filters('the_content', get_the_content())),
									$soleng_content
									);
					}
					soleng_show_layout($soleng_content);
				?></div><?php
			}
			?>
		</div>
	</div>
</div>