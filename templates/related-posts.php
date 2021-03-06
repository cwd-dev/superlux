<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

$soleng_link = get_permalink();
$soleng_post_format = get_post_format();
$soleng_post_format = empty($soleng_post_format) ? 'standard' : str_replace('post-format-', '', $soleng_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_1 post_format_'.esc_attr($soleng_post_format) ); ?>><?php
	soleng_show_post_featured(array(
		'thumb_size' => apply_filters('soleng_filter_related_thumb_size', soleng_get_thumb_size( (int) soleng_get_theme_option('related_posts') == 1 ? 'huge' : 'big' )),
		'show_no_image' => soleng_get_theme_setting('allow_no_image'),
		'singular' => false,
		'post_info' => '<div class="post_header entry-header">'
							. '<div class="post_categories">'.wp_kses(soleng_get_post_categories(''), 'soleng_kses_content').'</div>'
							. '<h6 class="post_title entry-title"><a href="'.esc_url($soleng_link).'">'.esc_html(get_the_title()).'</a></h6>'
							. (in_array(get_post_type(), array('post', 'attachment'))
									? '<span class="post_date"><a href="'.esc_url($soleng_link).'">'.wp_kses_data(soleng_get_date()).'</a></span>'
									: '')
						. '</div>'
		)
	);
?></div>