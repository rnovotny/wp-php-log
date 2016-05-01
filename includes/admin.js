jQuery(document).ready(function($){
	
	$('#rn_wpphp_delete_button').click(function() {
		if ( confirm(wpphp.confirm_text) ) {
			const nonce =  $('#rn_wpphp_delete_action_nonce').val()
			$.ajax({
				url: wpphp.ajax_url,
				data: { 'action':'rn_wpphp_delete_action', 'rn_wpphp_nonce':nonce },
				type: 'POST',
				datatype: 'text'
			}).success( function( returnedData ) {
				console.log('AJAX return: ' + returnedData  )
				if ( returnedData === 'success' ) {
					console.log("remove items...")
					$('.rn_wpphp_item').remove()
				}
			})

		} else {
			//DO NOTHING
		}
	})
	
	$('.rn_wpphp_show_var_dump').click(function() {
		$('.rn_wpphp_print_r').hide()
		$('.rn_wpphp_var_dump').show()

	})
	
	$('.rn_wpphp_show_print_r').click(function() {
		$('.rn_wpphp_var_dump').hide()
		$('.rn_wpphp_print_r').show()

	})
})