<?php
/**
 * The style "default" of the Icons
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_icons');
$trx_addons_number = 0;

$icon_present = '';
$svg_present = false;

?><div id="<?php echo esc_attr($args['id']); ?>" 
	class="sc_icons sc_icons_<?php
		echo esc_attr($args['type']);
		echo ' sc_icons_size_' . esc_attr($args['size']);
		if (!empty($args['align'])) echo ' sc_align_'.esc_attr($args['align']);
		if (!empty($args['class'])) echo ' '.esc_attr($args['class']);
	?>"<?php
	if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"';
?>><?php

	trx_addons_sc_show_titles('sc_icons', $args);

	if ($args['columns'] > 1) {
		?><div class="sc_icons_columns_wrap sc_item_columns <?php echo esc_attr(trx_addons_get_columns_wrap_class()); ?> columns_padding_bottom"><?php
	}
	foreach ($args['icons2'] as $item) {
		$trx_addons_number++;
		$item['color'] = !empty($item['color']) ? $item['color'] : $args['color'];
		if ($args['columns'] > 1) {
			?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
		}
		?><div class="sc_icons_item"><div class="sc_icons_item_content"><?php
			if (!empty($item['title2'])) {
				$item['title2'] = explode('|', $item['title2']);
				?><h4 class="sc_icons_item_title"><?php
					foreach ($item['title2'] as $str) {
						?><span><?php trx_addons_show_layout($str); ?></span><?php
					}
				?></h4><?php
			}
			if (!empty($item['description2'])) {
				?><div class="sc_icons_item_description"><?php
					if (strpos($item['description2'], '<p>') === false) {
						$item['description2'] = explode('|', str_replace("\n", '|', $item['description2']));
						foreach ($item['description2'] as $str) {
							?><span><?php trx_addons_show_layout($str); ?></span><?php
						}
					} else
						trx_addons_show_layout($item['description2']);
				?></div><?php
			}
			?></div><div class="sc_icon_item_number_container<?php 
					if (isset($args['alter_border_color']) && ($args['alter_border_color'] > 0)){ echo ' alter_border_color'; } 
				?>"><div class="sc_icon_item_number_content"><span class="sc_icon_item_number"><?php
				printf("%2d", $trx_addons_number);
			?></span></div></div><?php
		?></div><?php
		if ($args['columns'] > 1) {
			?></div><?php
		}
	}

	if ($args['columns'] > 1) {
		?></div><?php
	}

	trx_addons_sc_show_links('sc_icons', $args);

?></div><!-- /.sc_icons --><?php

trx_addons_load_icons($icon_present);
if (trx_addons_is_on(trx_addons_get_option('debug_mode')) && $svg_present) {
	wp_enqueue_script( 'vivus', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/vivus.js'), array('jquery'), null, true );
	wp_enqueue_script( 'trx-addons-sc-icons', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'icons/icons.js'), array('jquery'), null, true );
}
?>