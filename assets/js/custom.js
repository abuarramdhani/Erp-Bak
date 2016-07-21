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

	//Date Picker
	$( document ).ready(function() {
		$('#txt_start_date').daterangepicker({
			"singleDatePicker": true,
			"timePicker": true,
			"timePicker24Hour": true,
			"showDropdowns": false,
			locale: {
					format: 'YYYY-MM-DD HH:mm:ss'
				},
		});
		$('#txt_end_date').daterangepicker({
			"singleDatePicker": true,
			"timePicker": true,
			"timePicker24Hour": true,
			"showDropdowns": false,
			locale: {
					format: 'YYYY-MM-DD HH:mm:ss'
				},
		});
	});

	$(document).ready(function() {
		var output_datatables = $("#data_table").DataTable({
			"dom": '<"pull-left"f>tip',
			"info": false,
			language: {
				search: "Search : ",
			},
			"columnDefs": [
            {
                "targets": [ -1 ],
                "searchable": false
            }
        ],
		});
		$('.dataTables_filter input[type="search"]').css(
			{'width':'400px','display':'inline-block'}
		);

		$('#show_deleted_data').change(function(){
			var modul_url = document.getElementById('toggle_button').value;
			var checkbox = document.getElementById('toggle_button');
			var value = '';
			updateToggle = checkbox.checked ? value='Y' : value='N';
			$.ajax({
				type:'POST',
				data:{show_data:value},
				url:baseurl+"Outstation"+modul_url,
				success:function(result)
				{
					$('#div_data_tables').html(result);
					var output_datatables = $("#data_table2").DataTable({
						"dom": '<"pull-left"f>tip',
						"info": false,
						language: {
							search: "Search : ",
						},
						"columnDefs": [
			            {
			                "targets": [ -1 ],
			                "searchable": false
			            }
			        ],
					});
					$('.dataTables_filter input[type="search"]').css(
						{'width':'400px','display':'inline-block'}
					);
				}
			});
		});



	});
	function checkDelete(url,value){
		$.ajax({
				type:'POST',
				data:{data_id:value},
				url:url,
				success:function(result)
				{
					$('#delete_type').html(result);
				}
			});
	}

	$(document).ready(function() {
		$(".select2").select2({
			placeholder: function(){
				$(this).data('placeholder');
			},
			allowClear: true,
		});
	});

	$('#txt_employee_id').change(function(){
		var val = $('#txt_employee_id').val();
		$.ajax({
			type:'POST',
			data:{employee_id:val,modul:'code'},
			url:baseurl+"Outstation/select-employee",
			success:function(result)
			{
				$('#employee_code').html(result);
			}
		});
		$.ajax({
			type:'POST',
			data:{employee_id:val,modul:"name"},
			url:baseurl+"Outstation/select-employee",
			success:function(result)
			{
				$('#employee_name').html(result);
			}
		});
		$.ajax({
			type:'POST',
			data:{employee_id:val,modul:"section"},
			url:baseurl+"Outstation/select-employee",
			success:function(result)
			{
				$('#section_name').html(result);
			}
		});
		$.ajax({
			type:'POST',
			data:{employee_id:val,modul:"unit"},
			url:baseurl+"Outstation/select-employee",
			success:function(result)
			{
				$('#unit_name').html(result);
			}
		});
		$.ajax({
			type:'POST',
			data:{employee_id:val,modul:"department"},
			url:baseurl+"Outstation/select-employee",
			success:function(result)
			{
				$('#department_name').html(result);
			}
		});
	});

	$(document).ready(function() {
		$("#simulation_detail").DataTable({
			"dom": '<"pull-left">ti',
			"info": false,
			language: {
				search: "Search : ",
			},
			"columnDefs": [
            {
                "targets": [ -1 ],
                "searchable": false
            }
        ],
		});

		function processSimulation(url,value){
			$.ajax({
				type:'POST',
				data:{data_id:value},
				url:url,
				success:function(result)
				{
					$('#delete_type').html(result);
				}
			});
		}
	});