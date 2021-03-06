<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

$soleng_blog_style = explode('_', soleng_get_theme_option('blog_style'));
$soleng_columns = empty($soleng_blog_style[1]) ? 2 : max(2, $soleng_blog_style[1]);
$soleng_expanded = !soleng_sidebar_present() && soleng_is_on(soleng_get_theme_option('expand_content'));
$soleng_post_format = get_post_format();
$soleng_post_format = empty($soleng_post_format) ? 'standard' : str_replace('post-format-', '', $soleng_post_format);
$soleng_animation = soleng_get_theme_option('blog_animation');
$soleng_components = soleng_array_get_keys_by_value(soleng_get_theme_option('meta_parts'));
$soleng_counters = soleng_array_get_keys_by_value(soleng_get_theme_option('counters'));
$soleng_meta = soleng_array_get_keys_by_value(soleng_get_theme_option('meta_parts'));
$soleng_counter = soleng_array_get_keys_by_value(soleng_get_theme_option('counters'));

?><div class="<?php echo 'classic' == $soleng_blog_style[0] ? 'column' : 'masonry_item masonry_item'; ?>-1_<?php echo esc_attr($soleng_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_format_'.esc_attr($soleng_post_format)
					. ' post_layout_classic post_layout_classic_'.esc_attr($soleng_columns)
					. ' post_layout_'.esc_attr($soleng_blog_style[0]) 
					. ' post_layout_'.esc_attr($soleng_blog_style[0]).'_'.esc_attr($soleng_columns)
					); ?>
	<?php echo (!soleng_is_off($soleng_animation) ? ' data-animation="'.esc_attr(soleng_get_animation_classes($soleng_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	soleng_show_post_featured( array( 'thumb_size' => soleng_get_thumb_size($soleng_blog_style[0] == 'classic'
													? (strpos(soleng_get_theme_option('body_style'), 'full')!==false 
															? ( $soleng_columns > 2 ? 'classic' : 'classic' )
															: (	$soleng_columns > 2
																? ($soleng_expanded ? 'classic' : 'classic')
																: ($soleng_expanded ? 'classic' : 'classic')
																)
														)
													: (strpos(soleng_get_theme_option('body_style'), 'full')!==false 
															? ( $soleng_columns > 2 ? 'masonry-big' : 'full' )
															: (	$soleng_columns <= 2 && $soleng_expanded ? 'masonry-big' : 'masonry')
														)
								) ) );

	if ( !in_array($soleng_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			if ((strpos($soleng_meta, 'categories') !== false) || (strpos($soleng_meta, 'author') !== false) || (strpos($soleng_meta, 'date') !== false)) {
			?>
			<div class="post_header_meta">
				<?php
				if ((strpos($soleng_meta, 'categories') !== false) || (strpos($soleng_meta, 'author') !== false)) {
				?>
					<div class="post_header_meta_left">
						<?php
							if ((strpos($soleng_meta, 'categories') !== false) && (strpos($soleng_meta, 'author') !== false)) {
								soleng_show_post_meta(apply_filters('soleng_filter_post_meta_args', array(
									'components' => 'categories, author'
									), 'excerpt', 1)
								);
							} else if (strpos($soleng_meta, 'categories') !== false) {
								soleng_show_post_meta(apply_filters('soleng_filter_post_meta_args', array(
									'components' => 'categories'
									), 'excerpt', 1)
								);
							} else if (strpos($soleng_meta, 'author') !== false) {
								soleng_show_post_meta(apply_filters('soleng_filter_post_meta_args', array(
									'components' => 'author'
									), 'excerpt', 1)
								);
							}
						?>
						</div><?php
				}
				?><?php
					if (strpos($soleng_meta, 'date') !== false) {
						?><div class="post_header_meta_right">
						<?php
							soleng_show_post_meta(apply_filters('soleng_filter_post_meta_args', array(
								'components' => 'date'
								), 'excerpt', 1)
							);
						?>
						</div>
						<?php
						}
					?>
			</div>
			<?php
			}
			?>
			<?php
			if (strpos($soleng_meta, 'counters') !== false) {
				?><div class="post_button"><div class="post_button_right">
				<?php
					soleng_show_post_meta(apply_filters('soleng_filter_post_meta_args', array(
						'components' => 'counters',
						'counters' => $soleng_counter
						), 'excerpt', 1)
					);
				?>
				</div></div>
				<?php
			}
			?>
			<?php 
			do_action('soleng_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );

			?>
		</div><!-- .entry-header -->
		<?php
	}		
	?>

	<div class="post_content entry-content">
		<div class="post_content_inner">
			<?php
			$soleng_show_learn_more = false;
			if (has_excerpt()) {
				the_excerpt();
			} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
				the_content( '' );
			} else if (in_array($soleng_post_format, array('link', 'aside', 'status'))) {
				the_content();
			} else if ($soleng_post_format == 'quote') {
				if (($quote = soleng_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
					soleng_show_layout(wpautop($quote));
				else
					the_excerpt();
			} else if (substr(get_the_content(), 0, 1)!='[') {
				the_excerpt();
			}
			?>
		</div>
		<?php
		// Post meta
		if (in_array($soleng_post_format, array('link', 'aside', 'status', 'quote'))) {
			if (!empty($soleng_components))
				soleng_show_post_meta(apply_filters('soleng_filter_post_meta_args', array(
					'components' => $soleng_components,
					'counters' => $soleng_counters
					), $soleng_blog_style[0], $soleng_columns)
				);
		}
		// More button
		if ( $soleng_show_learn_more ) {
			?><p><a class="more-link sc_button color_style_link2 sc_button_simple sc_button_size_normal" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Continue Reading', 'soleng'); ?></a></p><?php
		}
		?>
	</div><!-- .entry-content -->

</article></div>