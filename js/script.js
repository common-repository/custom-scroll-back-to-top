jQuery(document).ready(function($) {
	$('input[name="opt_wptf_csbtt_type"]').on('click', function(){
		var s_option = $(this).val();
		$('.div_icon_options').slideUp('fast', function(){
			$(this).filter("[value='" +s_option+ "']").slideDown('fast', function(){
			});
		});
		
		// no icon
		if( s_option == 'no-icon' ) 
		{ 
			$('#txt_wptf_csbtt_icon_url').attr('value', ''); 
			$('input[name="opt_wptf_csbtt_icon_url"]').removeAttr('checked');
		}
	});
	
	$('input[name="opt_wptf_csbtt_icon_url"]').on('click', function(){
		var s_option = $(this).val();
		$('#txt_wptf_csbtt_icon_url').attr('value', s_option);
	});
	
	$('.opt_wptf_csbtt_font_color').wpColorPicker();

	$('.btn_media').on('click', function(event){
		event.preventDefault();
		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
		  title: 'Choose Icon',
		  button: {
			text: 'Set Icon',
		  },
		  multiple: false  // Set to true to allow multiple files to be selected
		});
		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
		  // We set multiple to false so only get one image from the uploader
		  attachment = file_frame.state().get('selection').first().toJSON();
		  // Do something with attachment.id and/or attachment.url here
		  //console.log(attachment);
		  $('#txt_wptf_csbtt_icon_url').attr('value', attachment.url);
		});
		// Finally, open the modal
		file_frame.open();
	});
});