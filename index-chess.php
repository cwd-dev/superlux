<?php
/**
 * The template for homepage posts with "Chess" style
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

soleng_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	soleng_show_layout(get_query_var('blog_archive_start'));

	$soleng_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$soleng_sticky_out = soleng_get_theme_option('sticky_style')=='columns' 
							&& is_array($soleng_stickies) && count($soleng_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($soleng_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	if (!$soleng_sticky_out) {
		?><div class="chess_wrap posts_container"><?php
	}
	while ( have_posts() ) { the_post(); 
		if ($soleng_sticky_out && !is_sticky()) {
			$soleng_sticky_out = false;
			?></div><div class="chess_wrap posts_container"><?php
		}
		get_template_part( 'content', $soleng_sticky_out && is_sticky() ? 'sticky' :'chess' );
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