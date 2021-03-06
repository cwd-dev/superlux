/* global jQuery:false */
/* global SOLENG_STORAGE:false */
/* global TRX_ADDONS_STORAGE:false */

(function() {
	"use strict";
	
	jQuery(document).on('action.add_googlemap_styles', soleng_trx_addons_add_googlemap_styles);
	jQuery(document).on('action.init_shortcodes', soleng_trx_addons_init);
	jQuery(document).on('action.init_hidden_elements', soleng_trx_addons_init);
	
	// Add theme specific styles to the Google map
	function soleng_trx_addons_add_googlemap_styles(e) {
		if (typeof TRX_ADDONS_STORAGE == 'undefined') return;
		TRX_ADDONS_STORAGE['googlemap_styles']['dark'] = [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":"0"},{"color":"#858585"},{"lightness":"0"}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#434343"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#434343"},{"lightness":"0"},{"gamma":"1.00"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#434343"},{"lightness":"0"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#323232"},{"lightness":"0"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#323232"},{"lightness":"0"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#323232"},{"lightness":"0"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#3c3c3c"},{"lightness":"0"}]}];
	}
	
	
	function soleng_trx_addons_init(e, container) {
		if (arguments.length < 2) var container = jQuery('body');
		if (container===undefined || container.length === undefined || container.length == 0) return;
		container.find('.sc_countdown_item canvas:not(.inited)').addClass('inited').attr('data-color', SOLENG_STORAGE['alter_link_color']);
	}

})();