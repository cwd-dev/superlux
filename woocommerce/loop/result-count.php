<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="soleng_shop_mode_buttons_result">
	<div class="soleng_shop_mode_buttons"><form action="<?php echo esc_url(soleng_get_current_url()); ?>" method="post"><input type="hidden" name="soleng_shop_mode" value="<?php echo esc_attr(soleng_storage_get('shop_mode')); ?>" /><a href="#" class="woocommerce_thumbs icon-shop1" title="<?php esc_attr_e('Show products as thumbs', 'soleng'); ?>"></a><a href="#" class="woocommerce_list icon-shop2" title="<?php esc_attr_e('Show products as list', 'soleng'); ?>"></a></form></div><p class="woocommerce-result-count">
		<?php
		if ( $total <= $per_page || -1 === $per_page ) {
			/* translators: %d: total results */
			printf( ($total === 1) ? esc_html__('Showing the single result', 'soleng') :  esc_html__('Showing all %d results', 'soleng'), $total );
		} else {
			$first = ( $per_page * $current ) - $per_page + 1;
			$last  = min( $total, $per_page * $current );
			/* translators: 1: first result 2: last result 3: total results */
			printf( _nx( 'Showing the single result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'soleng' ), $first, $last, $total );
		}
		?>
	</p>
</div>
