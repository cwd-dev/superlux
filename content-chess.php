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
$soleng_columns = empty($soleng_blog_style[1]) ? 1 : max(1, $soleng_blog_style[1]);
$soleng_expanded = !soleng_sidebar_present() && soleng_is_on(soleng_get_theme_option('expand_content'));
$soleng_post_format = get_post_format();
$soleng_post_format = empty($soleng_post_format) ? 'standard' : str_replace('post-format-', '', $soleng_post_format);
$soleng_animation = soleng_get_theme_option('blog_animation');
$soleng_meta = soleng_array_get_keys_by_value(soleng_get_theme_option('meta_parts'));
$soleng_counter = soleng_array_get_keys_by_value(soleng_get_theme_option('counters'));

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($soleng_columns).' post_format_'.esc_attr($soleng_post_format) ); ?>
	<?php echo (!soleng_is_off($soleng_animation) ? ' data-animation="'.esc_attr(soleng_get_animation_classes($soleng_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($soleng_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.the_title_attribute( array( 'echo' => false ) ) .'" icon="'.esc_attr(soleng_get_post_icon()).'"]');
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	soleng_show_post_featured( array(
											'class' => $soleng_columns == 1 ? 'soleng-full-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => soleng_get_thumb_size(
																	strpos(soleng_get_theme_option('body_style'), 'full')!==false
																		? ( $soleng_columns > 1 ? 'huge' : 'original' )
																		: (	$soleng_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header">
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
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$soleng_show_learn_more = !in_array($soleng_post_format, array('link', 'aside', 'status', 'quote'));
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
				soleng_show_layout($soleng_post_meta);
			}
			// More button
			if ( $soleng_show_learn_more ) {
				?><p><a class="more-link sc_button color_style_link2 sc_button_simple sc_button_size_normal" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Continue Reading', 'soleng'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>