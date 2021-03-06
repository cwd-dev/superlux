<div class="front_page_section front_page_section_contacts<?php
			$soleng_scheme = soleng_get_theme_option('front_page_contacts_scheme');
			if (!soleng_is_inherit($soleng_scheme)) echo ' scheme_'.esc_attr($soleng_scheme);
			echo ' front_page_section_paddings_'.esc_attr(soleng_get_theme_option('front_page_contacts_paddings'));
		?>"<?php
		$soleng_css = '';
		$soleng_bg_image = soleng_get_theme_option('front_page_contacts_bg_image');
		if (!empty($soleng_bg_image)) 
			$soleng_css .= 'background-image: url('.esc_url(soleng_get_attachment_url($soleng_bg_image)).');';
		if (!empty($soleng_css))
			echo ' style="' . esc_attr($soleng_css) . '"';
?>><?php
	// Add anchor
	$soleng_anchor_icon = soleng_get_theme_option('front_page_contacts_anchor_icon');	
	$soleng_anchor_text = soleng_get_theme_option('front_page_contacts_anchor_text');	
	if ((!empty($soleng_anchor_icon) || !empty($soleng_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_contacts"'
										. (!empty($soleng_anchor_icon) ? ' icon="'.esc_attr($soleng_anchor_icon).'"' : '')
										. (!empty($soleng_anchor_text) ? ' title="'.esc_attr($soleng_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_contacts_inner<?php
			if (soleng_get_theme_option('front_page_contacts_fullheight'))
				echo ' soleng-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$soleng_css = '';
			$soleng_bg_mask = soleng_get_theme_option('front_page_contacts_bg_mask');
			$soleng_bg_color = soleng_get_theme_option('front_page_contacts_bg_color');
			if (!empty($soleng_bg_color) && $soleng_bg_mask > 0)
				$soleng_css .= 'background-color: '.esc_attr($soleng_bg_mask==1
																	? $soleng_bg_color
																	: soleng_hex2rgba($soleng_bg_color, $soleng_bg_mask)
																).';';
			if (!empty($soleng_css))
				echo ' style="' . esc_attr($soleng_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$soleng_caption = soleng_get_theme_option('front_page_contacts_caption');
			$soleng_description = soleng_get_theme_option('front_page_contacts_description');
			if (!empty($soleng_caption) || !empty($soleng_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($soleng_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo !empty($soleng_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses($soleng_caption, 'soleng_kses_content');
					?></h2><?php
				}
			
				// Description
				if (!empty($soleng_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo !empty($soleng_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses(wpautop($soleng_description), 'soleng_kses_content');
					?></div><?php
				}
			}

			// Content (text)
			$soleng_content = soleng_get_theme_option('front_page_contacts_content');
			$soleng_layout = soleng_get_theme_option('front_page_contacts_layout');
			if ($soleng_layout == 'columns' && (!empty($soleng_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?><div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ((!empty($soleng_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?><div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo !empty($soleng_content) ? 'filled' : 'empty'; ?>"><?php
					echo wp_kses($soleng_content, 'soleng_kses_content');
				?></div><?php
			}

			if ($soleng_layout == 'columns' && (!empty($soleng_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div><div class="column-2_3"><?php
			}
		
			// Shortcode output
			$soleng_sc = soleng_get_theme_option('front_page_contacts_shortcode');
			if (!empty($soleng_sc) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo !empty($soleng_sc) ? 'filled' : 'empty'; ?>"><?php
					soleng_show_layout(do_shortcode($soleng_sc));
				?></div><?php
			}

			if ($soleng_layout == 'columns' && (!empty($soleng_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div></div><?php
			}
			?>			
		</div>
	</div>
</div>