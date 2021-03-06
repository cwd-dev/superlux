<div class="front_page_section front_page_section_blog<?php
			$soleng_scheme = soleng_get_theme_option('front_page_blog_scheme');
			if (!soleng_is_inherit($soleng_scheme)) echo ' scheme_'.esc_attr($soleng_scheme);
			echo ' front_page_section_paddings_'.esc_attr(soleng_get_theme_option('front_page_blog_paddings'));
		?>"<?php
		$soleng_css = '';
		$soleng_bg_image = soleng_get_theme_option('front_page_blog_bg_image');
		if (!empty($soleng_bg_image)) 
			$soleng_css .= 'background-image: url('.esc_url(soleng_get_attachment_url($soleng_bg_image)).');';
		if (!empty($soleng_css))
			echo ' style="' . esc_attr($soleng_css) . '"';
?>><?php
	// Add anchor
	$soleng_anchor_icon = soleng_get_theme_option('front_page_blog_anchor_icon');	
	$soleng_anchor_text = soleng_get_theme_option('front_page_blog_anchor_text');	
	if ((!empty($soleng_anchor_icon) || !empty($soleng_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_blog"'
										. (!empty($soleng_anchor_icon) ? ' icon="'.esc_attr($soleng_anchor_icon).'"' : '')
										. (!empty($soleng_anchor_text) ? ' title="'.esc_attr($soleng_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_blog_inner<?php
			if (soleng_get_theme_option('front_page_blog_fullheight'))
				echo ' soleng-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$soleng_css = '';
			$soleng_bg_mask = soleng_get_theme_option('front_page_blog_bg_mask');
			$soleng_bg_color = soleng_get_theme_option('front_page_blog_bg_color');
			if (!empty($soleng_bg_color) && $soleng_bg_mask > 0)
				$soleng_css .= 'background-color: '.esc_attr($soleng_bg_mask==1
																	? $soleng_bg_color
																	: soleng_hex2rgba($soleng_bg_color, $soleng_bg_mask)
																).';';
			if (!empty($soleng_css))
				echo ' style="' . esc_attr($soleng_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_blog_content_wrap content_wrap">
			<?php
			// Caption
			$soleng_caption = soleng_get_theme_option('front_page_blog_caption');
			if (!empty($soleng_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_blog_caption front_page_block_<?php echo !empty($soleng_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses($soleng_caption, 'soleng_kses_content'); ?></h2><?php
			}
		
			// Description (text)
			$soleng_description = soleng_get_theme_option('front_page_blog_description');
			if (!empty($soleng_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_blog_description front_page_block_<?php echo !empty($soleng_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses(wpautop($soleng_description), 'soleng_kses_content'); ?></div><?php
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_blog_output"><?php 
				if (is_active_sidebar('front_page_blog_widgets')) {
					dynamic_sidebar( 'front_page_blog_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!soleng_exists_trx_addons())
						soleng_customizer_need_trx_addons_message();
					else
						soleng_customizer_need_widgets_message('front_page_blog_caption', 'ThemeREX Addons - Blogger');
				}
			?></div>
		</div>
	</div>
</div>