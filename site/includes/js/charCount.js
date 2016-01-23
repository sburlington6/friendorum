$(document).ready(function()
{
	/**
	* Character Counter for inputs and text areas
	*/
	$('.word_count').each(function()
	{
		// get current number of characters
		var length = $(this).val().length;
		// get current number of words
		//var length = $(this).val().split(/\b[\s,\.-:;]*/).length;
		// update characters
		$(this).parent().find('.counter').html( (200-length) + ' characters left');
		// bind on key up event
		$(this).keyup(function()
		{
			// get new length of characters
			var new_length = $(this).val().length;
			// get new length of words
			//var new_length = $(this).val().split(/\b[\s,\.-:;]*/).length;
			// update
			$(this).parent().find('.counter').html( (200-new_length) + ' characters left');
		
			//disable text area when there are too many characters
			if (new_length >= 200)
			{
				//$('#status').attr("disabled", true); 
				$('.word_count').parent().find('.counter').html('That\'s ' + new_length + ' too many characters');
			}
			else
			{
				$('#status').removeAttr("disabled"); 
			}
		
		
		});
		
		
		
	});

});