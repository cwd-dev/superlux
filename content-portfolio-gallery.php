<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

$soleng_blog_style = explode('_', soleng_get_theme_option('blog_style'));
$soleng_columns = empty($soleng_blog_style[1]) ? 2 : max(2, $soleng_blog_style[1]);
$soleng_post_format = get_post_format();
$soleng_post_format = empty($soleng_post_format) ? 'standard' : str_replace('post-format-', '', $soleng_post_format);
$soleng_animation = soleng_get_theme_option('blog_animation');
$soleng_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($soleng_columns).' post_format_'.esc_attr($soleng_post_format) ); ?>
	<?php echo (!soleng_is_off($soleng_animation) ? ' data-animation="'.esc_attr(soleng_get_animation_classes($soleng_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($soleng_image[1]) && !empty($soleng_image[2])) echo intval($soleng_image[1]) .'x' . intval($soleng_image[2]); ?>"
	data-src="<?php if (!empty($soleng_image[0])) echo esc_url($soleng_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$soleng_image_hover = 'icon';
	if (in_array($soleng_image_hover, array('icons', 'zoom'))) $soleng_image_hover = 'dots';
	$soleng_components = soleng_array_get_keys_by_value(soleng_get_theme_option('meta_parts'));
	$soleng_counters = soleng_array_get_keys_by_value(soleng_get_theme_option('counters'));
	soleng_show_post_featured(array(
		'hover' => $soleng_image_hover,
		'thumb_size' => soleng_get_thumb_size( strpos(soleng_get_theme_option('body_style'), 'full')!==false || $soleng_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. (!empty($soleng_components)
										? soleng_show_post_meta(apply_filters('soleng_filter_post_meta_args', array(
											'components' => $soleng_components,
											'counters' => $soleng_counters,
											'seo' => false,
											'echo' => false
											), $soleng_blog_style[0], $soleng_columns))
										: '')
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'soleng') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>