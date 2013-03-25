// Check if page parent is set on edit screen. Return error message.

function error($element) {
	$element
		.css('border','1px solid red')
		.after('<br /><span style="color:red" class="rpp_alert">Please select a page parent.</span>');
}

jQuery('#publish').click( function(event) {
	
	var $parent = jQuery('#parent_id');
	
	var val = $parent.val();
		
	if (val == '') {
		
		error($parent);
		event.stopImmediatePropagation();
			
		return false;
		
	} else {
		return true;
	}	
	
});

jQuery('.inline-edit-save .save').click( function(event) {
	
	$parent_dropdown = jQuery('.inline-editor #post_parent');

	var val = $parent_dropdown.val();
		
	if (val == '0') {
		
		error($parent_dropdown);			
		event.stopImmediatePropagation();
			
		return false;
		
	} else {
		return true;
	}

});

