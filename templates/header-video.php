<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0.14
 */
$soleng_header_video = soleng_get_header_video();
$soleng_embed_video = '';
if (!empty($soleng_header_video) && !soleng_is_from_uploads($soleng_header_video)) {
	if (soleng_is_youtube_url($soleng_header_video) && preg_match('/[=\/]([^=\/]*)$/', $soleng_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$soleng_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($soleng_header_video) . '[/embed]' ));
			$soleng_embed_video = soleng_make_video_autoplay($soleng_embed_video);
		} else {
			$soleng_header_video = str_replace('/watch?v=', '/embed/', $soleng_header_video);
			$soleng_header_video = soleng_add_to_url($soleng_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$soleng_embed_video = '<iframe src="' . esc_url($soleng_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php soleng_show_layout($soleng_embed_video); ?></div><?php
	}
}
?>