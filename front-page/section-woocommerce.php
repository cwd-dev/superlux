<div class="front_page_section front_page_section_woocommerce<?php
			$soleng_scheme = soleng_get_theme_option('front_page_woocommerce_scheme');
			if (!soleng_is_inherit($soleng_scheme)) echo ' scheme_'.esc_attr($soleng_scheme);
			echo ' front_page_section_paddings_'.esc_attr(soleng_get_theme_option('front_page_woocommerce_paddings'));
		?>"<?php
		$soleng_css = '';
		$soleng_bg_image = soleng_get_theme_option('front_page_woocommerce_bg_image');
		if (!empty($soleng_bg_image)) 
			$soleng_css .= 'background-image: url('.esc_url(soleng_get_attachment_url($soleng_bg_image)).');';
		if (!empty($soleng_css))
			echo ' style="' . esc_attr($soleng_css) . '"';
?>><?php
	// Add anchor
	$soleng_anchor_icon = soleng_get_theme_option('front_page_woocommerce_anchor_icon');	
	$soleng_anchor_text = soleng_get_theme_option('front_page_woocommerce_anchor_text');	
	if ((!empty($soleng_anchor_icon) || !empty($soleng_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_woocommerce"'
										. (!empty($soleng_anchor_icon) ? ' icon="'.esc_attr($soleng_anchor_icon).'"' : '')
										. (!empty($soleng_anchor_text) ? ' title="'.esc_attr($soleng_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner<?php
			if (soleng_get_theme_option('front_page_woocommerce_fullheight'))
				echo ' soleng-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$soleng_css = '';
			$soleng_bg_mask = soleng_get_theme_option('front_page_woocommerce_bg_mask');
			$soleng_bg_color = soleng_get_theme_option('front_page_woocommerce_bg_color');
			if (!empty($soleng_bg_color) && $soleng_bg_mask > 0)
				$soleng_css .= 'background-color: '.esc_attr($soleng_bg_mask==1
																	? $soleng_bg_color
																	: soleng_hex2rgba($soleng_bg_color, $soleng_bg_mask)
																).';';
			if (!empty($soleng_css))
				echo ' style="' . esc_attr($soleng_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$soleng_caption = soleng_get_theme_option('front_page_woocommerce_caption');
			$soleng_description = soleng_get_theme_option('front_page_woocommerce_description');
			if (!empty($soleng_caption) || !empty($soleng_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($soleng_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo !empty($soleng_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses($soleng_caption, 'soleng_kses_content');
					?></h2><?php
				}
			
				// Description (text)
				if (!empty($soleng_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo !empty($soleng_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses(wpautop($soleng_description), 'soleng_kses_content');
					?></div><?php
				}
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs"><?php 
				$soleng_woocommerce_sc = soleng_get_theme_option('front_page_woocommerce_products');
				if ($soleng_woocommerce_sc == 'products') {
					$soleng_woocommerce_sc_ids = soleng_get_theme_option('front_page_woocommerce_products_per_page');
					$soleng_woocommerce_sc_per_page = count(explode(',', $soleng_woocommerce_sc_ids));
				} else {
					$soleng_woocommerce_sc_per_page = max(1, (int) soleng_get_theme_option('front_page_woocommerce_products_per_page'));
				}
				$soleng_woocommerce_sc_columns = max(1, min($soleng_woocommerce_sc_per_page, (int) soleng_get_theme_option('front_page_woocommerce_products_columns')));
				echo do_shortcode("[{$soleng_woocommerce_sc}"
									. ($soleng_woocommerce_sc == 'products' 
											? ' ids="'.esc_attr($soleng_woocommerce_sc_ids).'"' 
											: '')
									. ($soleng_woocommerce_sc == 'product_category' 
											? ' category="'.esc_attr(soleng_get_theme_option('front_page_woocommerce_products_categories')).'"' 
											: '')
									. ($soleng_woocommerce_sc != 'best_selling_products' 
											? ' orderby="'.esc_attr(soleng_get_theme_option('front_page_woocommerce_products_orderby')).'"'
											  . ' order="'.esc_attr(soleng_get_theme_option('front_page_woocommerce_products_order')).'"' 
											: '')
									. ' per_page="'.esc_attr($soleng_woocommerce_sc_per_page).'"' 
									. ' columns="'.esc_attr($soleng_woocommerce_sc_columns).'"' 
									. ']');
			?></div>
		</div>
	</div>
</div>