// Check if page parent is set on edit screen. Return error message.

function validate(event, $parent) {
	var val = $parent.val();
	if (val == '0' || val == '') {
		error($parent);			
		event.stopImmediatePropagation();
		event.preventDefault();
		return false;
	} else {
		return true;
	}
}

function error($element) {
	$element
		.css('border','1px solid red')
		.after('<br /><span style="color:red" class="rpp_alert">Please select a page parent.</span>');
}

// parent validation
if (getOption_forceParent()) {

	jQuery('#publish').click( function(event) {
		
		var $parent = jQuery('#parent_id');
		validate(event, $parent);
		
	});

	jQuery('.inline-edit-save .save, #bulk_edit').click( function(event) {
		
		var $parent = jQuery('.inline-editor #post_parent');
		validate(event, $parent);	

	});

}

// quick edit modifications
jQuery(document).ready( function() { 
	if (getOption_removePages()) {
		jQuery('#post_parent option').each(function (i) {
	    	var val = parseInt(jQuery(this).attr('value'));
	    	if (jQuery.inArray(val, rpp_pages) == '-1' && val > 0) jQuery(this).remove();
	    });
	}
});
