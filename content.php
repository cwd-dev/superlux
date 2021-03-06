<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

$soleng_seo = soleng_is_on(soleng_get_theme_option('seo_snippets'));
$soleng_meta = soleng_array_get_keys_by_value(soleng_get_theme_option('meta_parts'));
$soleng_counter = soleng_array_get_keys_by_value(soleng_get_theme_option('counters'));
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post_type_'.esc_attr(get_post_type()) 
												. ' post_format_'.esc_attr(str_replace('post-format-', '', get_post_format())) 
												);
		if ($soleng_seo) {
			?> itemscope="itemscope" 
			   itemprop="articleBody" 
			   itemtype="//schema.org/<?php echo esc_attr(soleng_get_markup_schema()); ?>"
			   itemid="<?php echo esc_url(get_the_permalink()); ?>"
			   content="<?php the_title_attribute(); ?>"<?php
		}
?>><?php

	do_action('soleng_action_before_post_data'); 

	// Structured data snippets
	if ($soleng_seo)
		get_template_part('templates/seo');

	// Featured image
	if ( soleng_is_off(soleng_get_theme_option('hide_featured_on_single'))
			&& !soleng_sc_layouts_showed('featured') 
			&& strpos(get_the_content(), '[trx_widget_banner]')===false) {
		do_action('soleng_action_before_post_featured'); 
		soleng_show_post_featured();
		do_action('soleng_action_after_post_featured'); 
	} else if (has_post_thumbnail()) {
		?><meta itemprop="image" itemtype="//schema.org/ImageObject" content="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>"><?php
	}

	// Title and post meta
	if ( (!soleng_sc_layouts_showed('title') || !soleng_sc_layouts_showed('postmeta')) && !in_array(get_post_format(), array('link', 'aside', 'status', 'quote')) ) {
		do_action('soleng_action_before_post_title'); 
		?>
		<div class="post_header entry-header">
			<?php
			if ((strpos($soleng_meta, 'categories') !== false)) {
			?>
			<div class="post_header_meta">
				<?php
				if ((strpos($soleng_meta, 'categories') !== false)) {
				?>
					<div class="post_header_meta_left">
						<?php
							if (strpos($soleng_meta, 'categories') !== false) {
								soleng_show_post_meta(apply_filters('soleng_filter_post_meta_args', array(
									'components' => 'categories'
									), 'excerpt', 1)
								);
							}
						?>
						</div><?php
				}
				?>
			</div>
			<?php
			}
			?>
			<?php
			// Post title
			if (!soleng_sc_layouts_showed('title')) {
				the_title( '<h3 class="post_title entry-title"'.($soleng_seo ? ' itemprop="headline"' : '').'>', '</h3>' );
			}
			
			// Post meta
			$soleng_components = soleng_array_get_keys_by_value(soleng_get_theme_option('meta_parts'));
			$soleng_counters = soleng_array_get_keys_by_value(soleng_get_theme_option('counters'));

			if (!empty($soleng_components))
				soleng_show_post_meta(apply_filters('soleng_filter_post_meta_args', array(
					'components' => $soleng_components,
					'counters' => $soleng_counters,
					'seo' => false
					), 'excerpt', 1)
				);
			?>
		</div><!-- .post_header -->
		<?php
		do_action('soleng_action_after_post_title'); 
	}

	do_action('soleng_action_before_post_content'); 

	// Post content
	?>
	<div class="post_content entry-content" itemprop="mainEntityOfPage">
		<?php
		the_content( );

		do_action('soleng_action_before_post_pagination'); 

		wp_link_pages( array(
			'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'soleng' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'soleng' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );

		// Taxonomies and share
		if ( is_single() && !is_attachment() ) {
			
			do_action('soleng_action_before_post_meta'); 

			?><div class="post_meta post_meta_single"><?php
				
				// Post taxonomies
				the_tags( '<span class="post_meta_item post_tags"><span class="post_meta_label">'.esc_html__('Tags:', 'soleng').'</span> ', '', '</span>' );

				// Share
				if (soleng_is_on(soleng_get_theme_option('show_share_links'))) {
					soleng_show_share_links(array(
							'type' => 'block',
							'caption' => 'Share',
							'before' => '<span class="post_meta_item post_share">',
							'after' => '</span>'
						));
				}
			?></div><?php

			do_action('soleng_action_after_post_meta'); 
		}
		?>
	</div><!-- .entry-content -->
	

	<?php
	do_action('soleng_action_after_post_content'); 

	// Author bio.
	if ( soleng_get_theme_option('show_author_info')==1 && is_single() && !is_attachment() && get_the_author_meta( 'description' ) ) {	
		do_action('soleng_action_before_post_author'); 
		get_template_part( 'templates/author-bio' );
		do_action('soleng_action_after_post_author'); 
	}

	do_action('soleng_action_after_post_data'); 
	?>
</article>
