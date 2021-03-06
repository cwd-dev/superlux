<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

$soleng_post_id    = get_the_ID();
$soleng_post_date  = soleng_get_date();
$soleng_post_title = get_the_title();
$soleng_post_link  = get_permalink();
$soleng_post_author_id   = get_the_author_meta('ID');
$soleng_post_author_name = get_the_author_meta('display_name');
$soleng_post_author_url  = get_author_posts_url($soleng_post_author_id, '');

$soleng_args = get_query_var('soleng_args_widgets_posts');
$soleng_show_date = isset($soleng_args['show_date']) ? (int) $soleng_args['show_date'] : 1;
$soleng_show_image = isset($soleng_args['show_image']) ? (int) $soleng_args['show_image'] : 1;
$soleng_show_author = isset($soleng_args['show_author']) ? (int) $soleng_args['show_author'] : 1;
$soleng_show_counters = isset($soleng_args['show_counters']) ? (int) $soleng_args['show_counters'] : 1;
$soleng_show_categories = isset($soleng_args['show_categories']) ? (int) $soleng_args['show_categories'] : 1;

$soleng_output = soleng_storage_get('soleng_output_widgets_posts');

$soleng_post_counters_output = '';
if ( $soleng_show_counters ) {
	$soleng_post_counters_output = '<span class="post_info_item post_info_counters">'
								. soleng_get_post_counters('comments')
							. '</span>';
}


$soleng_output .= '<article class="post_item with_thumb">';

if ($soleng_show_image) {
	$soleng_post_thumb = get_the_post_thumbnail($soleng_post_id, soleng_get_thumb_size('tiny'), array(
		'alt' => the_title_attribute( array( 'echo' => false ) )
    ));
	if ($soleng_post_thumb) $soleng_output .= '<div class="post_thumb">' . ($soleng_post_link ? '<a href="' . esc_url($soleng_post_link) . '">' : '') . ($soleng_post_thumb) . ($soleng_post_link ? '</a>' : '') . '</div>';
}

$soleng_output .= '<div class="post_content">'
			. ($soleng_show_categories 
					? '<div class="post_categories">'
						. soleng_get_post_categories()
						. $soleng_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($soleng_post_link ? '<a href="' . esc_url($soleng_post_link) . '">' : '') . ($soleng_post_title) . ($soleng_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('soleng_filter_get_post_info', 
								'<div class="post_info">'
									. ($soleng_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($soleng_post_link ? '<a href="' . esc_url($soleng_post_link) . '" class="post_info_date">' : '') 
											. esc_html($soleng_post_date) 
											. ($soleng_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($soleng_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'soleng') . ' ' 
											. ($soleng_post_link ? '<a href="' . esc_url($soleng_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($soleng_post_author_name) 
											. ($soleng_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$soleng_show_categories && $soleng_post_counters_output
										? $soleng_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
soleng_storage_set('soleng_output_widgets_posts', $soleng_output);
?>