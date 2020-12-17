$(document).on('ready', function(){
	var tbl = $('table').DataTable({
		"rowsGroup": [1,2,3,-1]
	});
})