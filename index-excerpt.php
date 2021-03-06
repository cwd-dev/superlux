<?php
/**
 * The template for homepage posts with "Excerpt" style
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

soleng_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	soleng_show_layout(get_query_var('blog_archive_start'));

	?><div class="posts_container"><?php
	
	$soleng_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$soleng_sticky_out = soleng_get_theme_option('sticky_style')=='columns' 
							&& is_array($soleng_stickies) && count($soleng_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($soleng_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	while ( have_posts() ) { the_post(); 
		if ($soleng_sticky_out && !is_sticky()) {
			$soleng_sticky_out = false;
			?></div><?php
		}
		get_template_part( 'content', $soleng_sticky_out && is_sticky() ? 'sticky' : 'excerpt' );
	}
	if ($soleng_sticky_out) {
		$soleng_sticky_out = false;
		?></div><?php
	}
	
	?></div><?php

	soleng_show_pagination();

	soleng_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>