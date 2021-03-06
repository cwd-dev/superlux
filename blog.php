<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WordPress editor or any Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$soleng_content = '';
$soleng_blog_archive_mask = '%%CONTENT%%';
$soleng_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $soleng_blog_archive_mask);
if ( have_posts() ) {
	the_post();
	if (($soleng_content = apply_filters('the_content', get_the_content())) != '') {
		if (($soleng_pos = strpos($soleng_content, $soleng_blog_archive_mask)) !== false) {
			$soleng_content = preg_replace('/(\<p\>\s*)?'.$soleng_blog_archive_mask.'(\s*\<\/p\>)/i', $soleng_blog_archive_subst, $soleng_content);
		} else
			$soleng_content .= $soleng_blog_archive_subst;
		$soleng_content = explode($soleng_blog_archive_mask, $soleng_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) soleng_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$soleng_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$soleng_args = soleng_query_add_posts_and_cats($soleng_args, '', soleng_get_theme_option('post_type'), soleng_get_theme_option('parent_cat'));
$soleng_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($soleng_page_number > 1) {
	$soleng_args['paged'] = $soleng_page_number;
	$soleng_args['ignore_sticky_posts'] = true;
}
$soleng_ppp = soleng_get_theme_option('posts_per_page');
if ((int) $soleng_ppp != 0)
	$soleng_args['posts_per_page'] = (int) $soleng_ppp;
// Make a new main query
$GLOBALS['wp_the_query']->query($soleng_args);


// Add internal query vars in the new query!
if (is_array($soleng_content) && count($soleng_content) == 2) {
	set_query_var('blog_archive_start', $soleng_content[0]);
	set_query_var('blog_archive_end', $soleng_content[1]);
}

get_template_part('index');
?>