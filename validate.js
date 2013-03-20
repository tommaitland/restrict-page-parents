/*

Basic jQuery script that hooks onto the save button, checks if a page parent exists and returns an error if it doesn't.

*/



jQuery('#publish').click( function(event) {
	
	var $parent = jQuery('#parent_id');
	
	var val = $parent.val();
		
	if (val == '') {
		
		$parent
			.css('border','1px solid red')
			.after('<br /><span style="color:red" class="rpp_alert">Please select a page parent.</span>');
					
		 event.stopImmediatePropagation();
			
		return false;
		
	} else {
		return true;
	}	
	
});