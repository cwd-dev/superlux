<?php
/**
 * The Portfolio template to display the content
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

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($soleng_columns).' post_format_'.esc_attr($soleng_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!soleng_is_off($soleng_animation) ? ' data-animation="'.esc_attr(soleng_get_animation_classes($soleng_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$soleng_image_hover = soleng_get_theme_option('image_hover');
	// Featured image
	soleng_show_post_featured(array(
		'thumb_size' => soleng_get_thumb_size(strpos(soleng_get_theme_option('body_style'), 'full')!==false || $soleng_columns < 3 
								? 'masonry-big' 
								: 'masonry'),
		'show_no_image' => true,
		'class' => $soleng_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $soleng_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>