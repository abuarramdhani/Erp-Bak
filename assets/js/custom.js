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
	
	$(document).ready(function(){
		$('#reportShowAllTable').DataTable({
			"filter": false,
		});
	});
	
	$(document).ready(function(){
		$('#reportBranchTable').DataTable({
			"filter": false,
		});
	});
	
	$(document).ready(function(){
		$('#reportRelationTable').DataTable({
			"filter": false,
		});
	});

//Date Picker Report All
$( document ).ready(function() {
	$('#reportAll').daterangepicker({
		"singleDatePicker": true,
		"showDropdowns": true,
		"maxDate": moment(),
		format: 'dddd, DD MMMM, YYYY',
		dayNamesMin: [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ],
	});
});

//Date Picker Report Branch
$( document ).ready(function() {
	$('#reportBranch').daterangepicker({
		"singleDatePicker": true,
		"showDropdowns": true,
		"maxDate": moment(),
		format: 'dddd, DD MMMM, YYYY',
		dayNamesMin: [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ],
	});
});