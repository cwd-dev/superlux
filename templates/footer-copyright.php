<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage SOLENG
 * @since SOLENG 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap<?php
				if (!soleng_is_inherit(soleng_get_theme_option('copyright_scheme')))
					echo ' scheme_' . esc_attr(soleng_get_theme_option('copyright_scheme'));
 				?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$soleng_copyright = soleng_prepare_macros(soleng_get_theme_option('copyright'));
				if (!empty($soleng_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $soleng_copyright, $soleng_matches)) {
						$soleng_copyright = str_replace($soleng_matches[1], date_i18n(str_replace(array('{', '}'), '', $soleng_matches[1])), $soleng_copyright);
					}
					// Display copyright
					echo wp_kses_data(nl2br($soleng_copyright));
				}
			?></div>
		</div>
	</div>
</div>
