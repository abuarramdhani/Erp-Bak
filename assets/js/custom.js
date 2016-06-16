	// ----------NUMERIC & COMMA INPUT---------- //
	function isNumberKeyAndComma(evt)
	{
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode == 44 || (charCode < 58 && charCode > 47))
		return true;
		return false;
	}
	
	// ----------DATA TABLES---------- //
	$(document).ready(function(){
		$('#config').DataTable({
			"aoColumns": [ 
				null, // id
				null, // product
				null, // another column
				{ "bSortable": false,
					"bVisible": true }, //action column
			],
		});
	});

	$(document).ready(function() {
		$('#branch').DataTable( {
			"aoColumns": [ 
				null, // id
				null, // product
				null, // another column
				{ "bSortable": false,
					"bVisible": true }, //action column
			],
		});
	});

	$(document).ready(function(){
		$('#schedule').DataTable({
			"aoColumns": [ 
				null, // id
				null, // product
				null, // another column
				null, // another column
				null, // another column
				{ "bSortable": false,
					"bVisible": true }, //action column
			],
		});
	});

	$(document).ready(function(){
		$('#relation').DataTable({
			"aoColumns": [ 
				null, // id
				null, // product
				null, // another column
				null, // another column
				null, // another column
				null, // another column
				null, // another column
				{ "bSortable": false,
					"bVisible": true }, //action column
			],
		});
	});