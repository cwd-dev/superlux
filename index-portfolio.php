<?php
/**
 * The template for homepage posts with "Portfolio" style
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
	
	// Show filters
	$soleng_cat = soleng_get_theme_option('parent_cat');
	$soleng_post_type = soleng_get_theme_option('post_type');
	$soleng_taxonomy = soleng_get_post_type_taxonomy($soleng_post_type);
	$soleng_show_filters = soleng_get_theme_option('show_filters');
	$soleng_tabs = array();
	if (!soleng_is_off($soleng_show_filters)) {
		$soleng_args = array(
			'type'			=> $soleng_post_type,
			'child_of'		=> $soleng_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> $soleng_taxonomy,
			'pad_counts'	=> false
		);
		$soleng_portfolio_list = get_terms($soleng_args);
		if (is_array($soleng_portfolio_list) && count($soleng_portfolio_list) > 0) {
			$soleng_tabs[$soleng_cat] = esc_html__('All', 'soleng');
			foreach ($soleng_portfolio_list as $soleng_term) {
				if (isset($soleng_term->term_id)) $soleng_tabs[$soleng_term->term_id] = $soleng_term->name;
			}
		}
	}
	if (count($soleng_tabs) > 0) {
		$soleng_portfolio_filters_ajax = true;
		$soleng_portfolio_filters_active = $soleng_cat;
		$soleng_portfolio_filters_id = 'portfolio_filters';
		?>
		<div class="portfolio_filters soleng_tabs soleng_tabs_ajax">
			<ul class="portfolio_titles soleng_tabs_titles">
				<?php
				foreach ($soleng_tabs as $soleng_id=>$soleng_title) {
					?><li><a href="<?php echo esc_url(soleng_get_hash_link(sprintf('#%s_%s_content', $soleng_portfolio_filters_id, $soleng_id))); ?>" data-tab="<?php echo esc_attr($soleng_id); ?>"><?php echo esc_html($soleng_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$soleng_ppp = soleng_get_theme_option('posts_per_page');
			if (soleng_is_inherit($soleng_ppp)) $soleng_ppp = '';
			foreach ($soleng_tabs as $soleng_id=>$soleng_title) {
				$soleng_portfolio_need_content = $soleng_id==$soleng_portfolio_filters_active || !$soleng_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $soleng_portfolio_filters_id, $soleng_id)); ?>"
					class="portfolio_content soleng_tabs_content"
					data-blog-template="<?php echo esc_attr(soleng_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(soleng_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($soleng_ppp); ?>"
					data-post-type="<?php echo esc_attr($soleng_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($soleng_taxonomy); ?>"
					data-cat="<?php echo esc_attr($soleng_id); ?>"
					data-parent-cat="<?php echo esc_attr($soleng_cat); ?>"
					data-need-content="<?php echo (false===$soleng_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($soleng_portfolio_need_content) 
						soleng_show_portfolio_posts(array(
							'cat' => $soleng_id,
							'parent_cat' => $soleng_cat,
							'taxonomy' => $soleng_taxonomy,
							'post_type' => $soleng_post_type,
							'page' => 1,
							'sticky' => $soleng_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		soleng_show_portfolio_posts(array(
			'cat' => $soleng_cat,
			'parent_cat' => $soleng_cat,
			'taxonomy' => $soleng_taxonomy,
			'post_type' => $soleng_post_type,
			'page' => 1,
			'sticky' => $soleng_sticky_out
			)
		);
	}

	soleng_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>