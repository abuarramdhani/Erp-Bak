$(document).ready(function(){
	  $(document).on('change', '.excell', function(){
    	$('.tomboll').removeAttr('disabled')
    	// $(this).parentsUntil('tr').find('input').attr('disabled', 'disabled')
	    // console.log('2')
    })

});