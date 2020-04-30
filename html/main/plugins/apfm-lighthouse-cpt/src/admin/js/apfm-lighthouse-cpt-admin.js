(function( $ ) {
	'use strict';
	
	// Manage image fields in widgets
	jQuery(document).ready(function($){
		if ( typeof wp.media !== 'undefined' ) {
			var _custom_media = true,
			_orig_send_attachment = wp.media.editor.send.attachment;
			$(document).on('click','.custommedia',function(e) {
				var send_attachment_bkp = wp.media.editor.send.attachment;
				var button = $(this);
				var id = button.attr('id');
				_custom_media = true;
					wp.media.editor.send.attachment = function(props, attachment){
					if ( _custom_media ) {
						$('input#'+id).val(attachment.id);
						$('span#preview'+id).css('background-image', 'url('+attachment.url+')');
						$('input#'+id).trigger('change');
					} else {
						return _orig_send_attachment.apply( this, [props, attachment] );
					};
				}
				wp.media.editor.open(button);
				return false;
			});
			
			$('.add_media').on('click', function(){
				_custom_media = false;
			});
			$(document).on('click', '.remove-media', function() {
				var parent = $(this).parents('p');
				parent.find('input[type="media"]').val('').trigger('change');
				parent.find('span').css('background-image', 'url()');
			});
		}

		// enable or disable dev and prod controls in lighthouse-cpt settings form depending on mode
		jQuery('#apfm_lighthouse_cptws3_mode').on('change', (e) => {
			if(jQuery('#apfm_lighthouse_cptws3_mode').val() == 'dev') {
				jQuery('.dev-control').show();
				jQuery('.prod-control').hide();
				jQuery('#apfm_lighthouse_cptws3_mode').addClass('dev');
				jQuery('#apfm_lighthouse_cptws3_mode').removeClass('prod');
			} else {
				jQuery('.dev-control').hide();
				jQuery('.prod-control').show();
				jQuery('#apfm_lighthouse_cptws3_mode').addClass('prod');
				jQuery('#apfm_lighthouse_cptws3_mode').removeClass('dev');
			}
		});

		// switch between success redirect and success message using after success control
		// jQuery('#lighthouse_cpt_widget_settings_after_success').on('change', (e) => {
		// 	if(jQuery('#lighthouse_cpt_widget_settings_after_success').val() == 'message') {
		// 		jQuery('.message-control').show();
		// 		jQuery('.redirect-control').hide();
		// 	} else {
		// 		jQuery('.message-control').hide();
		// 		jQuery('.redirect-control').show();
		// 	}
		// });
	});

})( jQuery );
