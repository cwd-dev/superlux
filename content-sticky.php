<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

$soleng_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$soleng_post_format = get_post_format();
$soleng_post_format = empty($soleng_post_format) ? 'standard' : str_replace('post-format-', '', $soleng_post_format);
$soleng_animation = soleng_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($soleng_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($soleng_post_format) ); ?>
	<?php echo (!soleng_is_off($soleng_animation) ? ' data-animation="'.esc_attr(soleng_get_animation_classes($soleng_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	soleng_show_post_featured(array(
		'thumb_size' => soleng_get_thumb_size($soleng_columns==1 ? 'big' : ($soleng_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($soleng_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			soleng_show_post_meta(apply_filters('soleng_filter_post_meta_args', array(), 'sticky', $soleng_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>