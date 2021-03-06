<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

$soleng_post_format = get_post_format();
$soleng_post_format = empty($soleng_post_format) ? 'standard' : str_replace('post-format-', '', $soleng_post_format);
$soleng_animation = soleng_get_theme_option('blog_animation');
$soleng_meta = soleng_array_get_keys_by_value(soleng_get_theme_option('meta_parts'));
$soleng_counter = soleng_array_get_keys_by_value(soleng_get_theme_option('counters'));

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($soleng_post_format) ); ?>
	<?php echo (!soleng_is_off($soleng_animation) ? ' data-animation="'.esc_attr(soleng_get_animation_classes($soleng_animation)).'"' : ''); ?>
	><?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$soleng_hide_featured = !in_array($soleng_post_format, array('audio'));
	if ( $soleng_hide_featured ) {
	// Featured image
	soleng_show_post_featured(array( 'thumb_size' => soleng_get_thumb_size( strpos(soleng_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ) ));
	}
	// Title and post meta
	if (get_the_title() != '') {
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
			do_action('soleng_action_before_post_title'); 
			$soleng_show_title = !in_array($soleng_post_format, array('link', 'audio', 'aside', 'status', 'quote'));
			if ( $soleng_show_title ) {
				// Post title
				the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			}

			do_action('soleng_action_before_post_meta'); 

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
		</div><!-- .post_header --><?php
	}
	$soleng_show_featured = in_array($soleng_post_format, array('audio'));
	if ( $soleng_show_featured ) {
	// Featured image
	soleng_show_post_featured(array( 'thumb_size' => soleng_get_thumb_size( strpos(soleng_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ) ));
	}	
	// Post content
	?><div class="post_content entry-content"><?php
		if (soleng_get_theme_option('blog_content') == 'fullpost') {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'soleng' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'soleng' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {


			// Post content area
			?><div class="post_content_inner"><?php
				if (has_excerpt()) {
					echo wp_trim_words( get_the_excerpt(), 10, '...' );
				} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
					the_content( '' );
				} else if (in_array($soleng_post_format, array('link', 'aside', 'status'))) {
					the_content();
				} else if ($soleng_post_format == 'quote') {
					if (($quote = soleng_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
						soleng_show_layout(wpautop($quote));
					else
						echo wp_trim_words( get_the_excerpt(), 10, '...' );
				} else if (substr(get_the_content(), 0, 1)!='[') {
					echo wp_trim_words( get_the_excerpt(), 10, '...' );
				}
			?></div><?php
		}
	?></div><!-- .entry-content -->
		<?php
			if (soleng_get_theme_option('blog_content') == 'fullpost') {
					} else {
				$soleng_show_learn_more = !in_array($soleng_post_format, array('link', 'aside', 'status', 'quote'));
				// More button
				if ( $soleng_show_learn_more ) {
					?><div class="post_button">
						<div class="post_button_left">
							<a class="more-link sc_button color_style_link2 sc_button_simple sc_button_size_normal" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Continue Reading', 'soleng'); ?></a>
						</div>
					</div>
				<?php
				}
			}
		?>
</article>