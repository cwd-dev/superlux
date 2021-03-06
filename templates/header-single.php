<?php
/**
 * The template to display the featured image in the single post
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0
 */

if ( get_query_var('soleng_header_image')=='' && is_singular() && has_post_thumbnail() && in_array(get_post_type(), array('post', 'page')) )  {
	$soleng_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
	if (!empty($soleng_src[0])) {
		soleng_sc_layouts_showed('featured', true);
		?><div class="sc_layouts_featured with_image without_content <?php echo esc_attr(soleng_add_inline_css_class('background-image:url('.esc_url($soleng_src[0]).');')); ?>"></div><?php
	}
}
?>