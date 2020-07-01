	// ----------NUMERIC & COMMA INPUT---------- //
	function isNumberKeyAndComma(evt)
	{
		var charCode = (evt.which) ? evt.which : event.keyCode
		if ( charCode == 46 ||charCode == 44 || (charCode < 58 && charCode > 47))
		return true;
		return false;
	}
	
	function isNumberKeyAndDot(evt)
	{
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode == 46 || (charCode < 58 && charCode > 47))
		return true;
		return false;
	}
	
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
	
	function isNumberKeyAndPoint(evt)
	{
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode == 45 || (charCode < 58 && charCode > 47))
		return true;
		return false;
	}
	
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
	
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
			"startDate": '9999-12-31 00:00:00',
			locale: {
					format: 'YYYY-MM-DD HH:mm:ss'
				},
		});
		$('.date-picker').daterangepicker({
			"singleDatePicker": true,
			"timePicker": true,
			"timePicker24Hour": true,
			"showDropdowns": false,
			locale: {
					format: 'YYYY-MM-DD HH:mm:ss'
				},
		});

		var d = new Date();

		var hour = d.getHours();
		var minute = d.getMinutes();

		var now = hour+':'+minute;

		$('.time-pickers').timepicker({
			showMeridian: false,
			defaultTime: now,
			minuteStep: 1,
		});
	});

	$(document).ready(function() {
		$("#employee_position_table").DataTable({
			"dom": '<"pull-left"f>trip',
			"info": false,
			language: {
				search: "Search : ",
			},
			"columnDefs": [
				{
					"targets": [ -1 ],
					"searchable": false,
					"orderable": false,
				},
				{
					"targets": [ 0 ],
					"searchable": false,
					"orderable": false,
					"width": 20
				}
			],
			"processing": true,
			"serverSide": true,
			"ajax":{
				url : baseurl+"Outstation/employee-position/show-employee-position",
				type: "post",
				error: function(){
					//$("#employee_position_table").append('<tbody class="text-center"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
					//$("#employee_position_table_processing").css("display","none");
				}
			}
		});

		$("#accomodation_table").DataTable({
			"dom": '<"pull-left"f>tip',
			"info": false,
			language: {
				search: "Search : ",
			},
			"columnDefs": [
				{
					"targets": [ -1 ],
					"searchable": false,
					"orderable": false,
				},
				{
					"targets": [ 0 ],
					"searchable": false,
					"orderable": false,
					"width": 20
				}
			],
			"processing": true,
			"serverSide": true,
			"ajax":{
				url : baseurl+"Outstation/accomodation-allowance/show-accomodation-allowance",
				type: "post",
				error: function(){
					//$("#employee_position_table").append('<tbody class="text-center"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
					//$("#employee_position_table_processing").css("display","none");
				}
			}
		});

		$("#meal_table").DataTable({
			"dom": '<"pull-left"f>tip',
			"info": false,
			language: {
				search: "Search : ",
			},
			"columnDefs": [
				{
					"targets": [ -1 ],
					"searchable": false,
					"orderable": false,
				},
				{
					"targets": [ 0 ],
					"searchable": false,
					"orderable": false,
					"width": 20
				}
			],
			"processing": true,
			"serverSide": true,
			"ajax":{
				url : baseurl+"Outstation/meal-allowance/show-meal-allowance",
				type: "post",
				error: function(){
					//$("#employee_position_table").append('<tbody class="text-center"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
					//$("#employee_position_table_processing").css("display","none");
				}
			}
		});

		$("#ush_table").DataTable({
			"dom": '<"pull-left"f>tip',
			"info": false,
			language: {
				search: "Search : ",
			},
			"columnDefs": [
				{
					"targets": [ -1 ],
					"searchable": false,
					"orderable": false,
				},
				{
					"targets": [ 0 ],
					"searchable": false,
					"orderable": false,
					"width": 20
				}
			],
			"processing": true,
			"serverSide": true,
			"ajax":{
				url : baseurl+"Outstation/ush/show-ush",
				type: "post",
				error: function(){
					//$("#employee_position_table").append('<tbody class="text-center"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
					//$("#employee_position_table_processing").css("display","none");
				}
			}
		});

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
	function check_before_save(modul){
		if (modul == 'new'){
			data = $("#new-ush").serialize();
			url = $("#new-ush").attr("action");
		}
		else{
			data = $("#update-ush").serialize();
			url = $("#update-ush").attr("action");
		}
		$.ajax({
				type:'POST',
				data:data,
				url:url,
				success:function(result)
				{
					$('#error-div').html(result);
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

		$('.input_money').maskMoney({prefix:'Rp', thousands:'.', decimal:',',precision:0});
	});

	$('#txt_employee_id').change(function(){
		$('#loadAjax').show();
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
			data:{employee_id:val,modul:"outstationposition"},
			url:baseurl+"Outstation/select-employee",
			success:function(result)
			{
				$('#outstation-position').html(result);
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
				$('#loadAjax').hide();
			}
		});
	});

//Simulation & Realization Detail
	$(document).ready(function() {
		function addCommas(nStr)
		{
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? ',' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + '.' + '$2');
			}
			
			return x1 + x2;
		}

		var table = $("#simulation_detail").DataTable({
							"dom": '<"pull-left">ti',
							"info": false,
							"paging": false,
							language: {
								"decimal": ",",
								"thousands": "."
							},
							"columnDefs": [{
								"targets": [ -1 ],
								"searchable": false
							}],
							"bDestroy": true,
							"footerCallback": function ( row, data, start, end, display ) {
								var api = this.api(), data;
								var intVal = function ( i ) {
									return typeof i === 'string' ?
										i.replace(/[\Rp,]/g, '')*1 :
										typeof i === 'number' ?
											i : 0;
									};

								total_meal = api
										.column( 3 )
										.data()
										.reduce( function (a, b) {
											return intVal(a) + intVal(b);
										}, 0 );
								total_accomodation = api
										.column( 4 )
										.data()
										.reduce( function (a, b) {
											return intVal(a) + intVal(b);
										}, 0 );
								total_ush = api
										.column( 6 )
										.data()
										.reduce( function (a, b) {
											return intVal(a) + intVal(b);
										}, 0 );
								total_all = api
										.column( 7 )
										.data()
										.reduce( function (a, b) {
											return intVal(a) + intVal(b);
										}, 0 );
								$( api.column( 3 ).footer() ).html(
									'Rp'+ addCommas(parseFloat(Math.round(total_meal * 100) / 100).toFixed(2))
								);
									$( api.column( 4 ).footer() ).html(
									'Rp'+ addCommas(parseFloat(Math.round(total_accomodation * 100) / 100).toFixed(2))
								);
									$( api.column( 6 ).footer() ).html(
									'Rp'+ addCommas(parseFloat(Math.round(total_ush * 100) / 100).toFixed(2))
								);
									$( api.column( 7 ).footer() ).html(
									'Rp'+ addCommas(parseFloat(Math.round(total_all * 100) / 100).toFixed(2))
								);
							}
						});
		table.on( 'order.dt search.dt', function () {
			table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			} );
		} ).draw();

		/*
		$('#submit-simulation').click(function(){
			$('.alert').alert('close');
			$('#loadAjax').show();
			$.ajax({
				type:'POST',
				data:$("#simulation-form").serialize(),
				url:baseurl+"Outstation/simulation/new/process",
				success:function(result)
				{
					$('#simulation_detail').dataTable().fnDestroy();
					$('#simulation_detail').html(result);
					var table = $("#simulation_detail").DataTable({
										"dom": '<"pull-left">ti',
										"info": false,
										"paging": false,
										language: {
											"decimal": ".",
											"thousands": ","
										},
										"columnDefs": [{
											"targets": [ -1 ],
											"searchable": false
										}],
										"bDestroy": true,
										"footerCallback": function ( row, data, start, end, display ) {
											var api = this.api(), data;
											var intVal = function ( i ) {
												return typeof i === 'string' ?
													i.replace(/[\Rp,]/g, '')*1 :
													typeof i === 'number' ?
														i : 0;
												};

											total_meal = api
													.column( 3 )
													.data()
													.reduce( function (a, b) {
														return intVal(a) + intVal(b);
													}, 0 );
											total_accomodation = api
													.column( 4 )
													.data()
													.reduce( function (a, b) {
														return intVal(a) + intVal(b);
													}, 0 );
											total_ush = api
													.column( 6 )
													.data()
													.reduce( function (a, b) {
														return intVal(a) + intVal(b);
													}, 0 );

											total_all = api
													.column( 7 )
													.data()
													.reduce( function (a, b) {
														return intVal(a) + intVal(b);
													}, 0 );

											$( api.column( 3 ).footer() ).html(
												'Rp'+ addCommas(parseFloat(Math.round(total_meal * 100) / 100).toFixed(2))
											);

											$( api.column( 4 ).footer() ).html(
												'Rp'+ addCommas(parseFloat(Math.round(total_accomodation * 100) / 100).toFixed(2))
											);

											$( api.column( 6 ).footer() ).html(
												'Rp'+ addCommas(parseFloat(Math.round(total_ush * 100) / 100).toFixed(2))
											);

											$( api.column( 7 ).footer() ).html(
												'Rp'+ addCommas(parseFloat(Math.round(total_all * 100) / 100).toFixed(2))
											);
										}
									});
					table.on( 'order.dt search.dt', function () {
						table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
							cell.innerHTML = i+1;
						} );
					} ).draw();
					$('#loadAjax').hide();
				},
				error: function() {
					$('#loadAjax').hide();
					document.getElementById("errordiv").innerHTML = '<div style="width: 50%;margin: 0 auto" class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Outstation Position/Destination/City Type Invalid!</div>';
				}
			});
		});
		*/

		$(".select2-component").select2({
			placeholder: function(){
				$(this).data('placeholder');
			},
			allowClear: true,
		});

		$(".select-employee").select2({
			  ajax: {
			        url: baseurl+'CateringManagement/PrintPP/Employee',
			        dataType: 'json',
			        delay: 250,
			        data: function (params) {
			          return {
			            q: params.term,
			        };
			        },
			        processResults: function (data) {
			          return {
			                results: $.map(data, function (item) {
			                    return {
			                      id: item.employee_id,
			                      text: item.employee_name,
			                    }
			                })
			            };
			      },
			      cache: true
			    },
			    minimumInputLength: 2,
			    allowClear: true,
			});

		$(document).on('click', '#add-row-printpp', function (){
			var count = $('#printpp tr').length;
			if(count >= 13) {
				alert('gak boleh lebih dari 13');
			} else {
				$(".multiRow:last .date").datepicker("destroy");
				var form = $('.multiRow').last().clone();

				$('#printpp').append(form);
				
				$(".multiRow:last .form-control").val("").change();

				$('.date').datepicker({
		    		"autoclose": true,
		    		"todayHiglight": true,
		    		"format": 'dd M yyyy'
		      	});	
			}
		});

		$(document).on('click', '.delete-row-printpp', function (e){
			e.preventDefault();
			var count = $('#printpp tr').length;
			if(count == 1) {
				alert('gak boleh dihapus, awas kalo dihapus');
			} else {
				$(this).closest('tr').remove();
			}
		});

		$(document).on('click', '.delete-row-update-printpp', function (e){
			e.preventDefault();
			var count = $('#printpp tr').length;
			var row = $(this);
			if(count == 1) {
				alert('gak boleh dihapus, awas kalo dihapus');
			} else {
				var id = $(this).attr('data-id');
				$.ajax({
					type: 'POST',
					data: {idKU: id},
					url:baseurl+"CateringManagement/PrintPP/deleteLines",
				})
				.done(function(data) {
					row.closest('tr').remove();
				});
			}
		});
		

		$('#add-row').on( 'click', function () {
			var new_form = $('<tr>').addClass('multiRow');
			var e = jQuery.Event( "click" );
			e.preventDefault();
			
			$(".multiRow:last .select2-component:last").select2("destroy");
			$('.multiRow').last().clone().appendTo(new_form).appendTo('#realization_detail');
			$(".multiRow:last .form-control").val("").change();
			
			$(".select2-component").select2({
				placeholder: function(){
					$(this).data('placeholder');
				},
				allowClear: true,
			});
			$('.input_money').maskMoney({prefix:'Rp', thousands:'.', decimal:',',precision:0});
			
			delete_row();

			$(".multiRow input").keyup(multInputs);
			$(".multiRow input").click(multInputs);
			$(".delete-row").click(multInputs);
			$("#add-row").click(multInputs);

		} );
		$("#add-row").click(multInputs);
		$(".multiRow input").keyup(multInputs);
		$(".multiRow input").click(multInputs);
		$(".delete-row").click(multInputs);

		function multInputs() {
			var grandTotal = 0;

			$("tr.multiRow").each(function () {
				var $qty = $('.quantity', this).val();
				var $nominal_with_Rp = $('.nominal', this).val();
				var $nominal_with_Dot = $nominal_with_Rp.replace(/Rp/g, '');
				var $nominal = $nominal_with_Dot.replace(/\./g, '');
				var $total = ($qty * 1) * ($nominal * 1);
				$('.total-nominal',this).val('Rp'+addCommas(parseFloat(Math.round($total * 100) / 100).toFixed(2)));
				grandTotal += $total;
			});
			$("#total-final").text('Rp'+addCommas(parseFloat(Math.round(grandTotal * 100) / 100).toFixed(2)));
		}

		$("#add-row").click();
		$(".delete-row:last").click();
		delete_row();
		function delete_row(){
			$('.delete-row').click(function(){
				var formCount = $("#realization_detail .multiRow").size();
				if(formCount <= 1){
					alert("Can't delete more form!");
				}
				else{
					$(this).closest('.multiRow').remove();
				}
			});
		}

		$('#submit-realization').click(function(){
			$('.alert').alert('close');
			$('#loadAjax').show();
			$.ajax({
				type:'POST',
				data:$("#realization-form").serialize(),
				url:baseurl+"Outstation/realization/new/process",
				success:function(result)
				{
					$('#estimate-allowance').html(result);
					$('#loadAjax').hide();
				},
				error: function() {
					$('#loadAjax').hide();
					document.getElementById("errordiv").innerHTML = '<div style="width: 50%;margin: 0 auto" class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Outstation Position/Destination/City Type Invalid!</div>';
				}
			});
		});

		$(document).on('change', '#area', function() {
			var destination = $(this).val();
			$('#area_lines').select2('val', destination);
			// var destination_name = $("#area option[value='"+destination+"']").text()
			// alert(destination);
			// $('#area_lines').val(destination);
			// $('#area_lines option[value='+destination+']').attr('selected','selected');
		});

		// $(document).on('change', '#area_lines', function() {
		// 	var destination = $(this).val();
		// 	// var destination_name = $("#area option[value='"+destination+"']").text()
		// 	alert(destination);
		// 	// $('#area_lines').val(destination);
		// });

		$('#submit-simulation').click(function(){
			$('.alert').alert('close');
			$('#loadAjax').show();
			$.ajax({
				type:'POST',
				data:$("#simulation-form").serialize(),
				url:baseurl+"Outstation/simulation/new/process",
				success:function(result)
				{
					$('#estimate-allowance').html(result);
					$('#loadAjax').hide();
				},
				error: function() {
					$('#loadAjax').hide();
					document.getElementById("errordiv").innerHTML = '<div style="width: 50%;margin: 0 auto" class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Outstation Position/Destination/City Type Invalid!</div>';
				}
			});
		});

	});


//Stock Control
$(document).ready(function(){
	var assembling_table = $('#assembling').DataTable({
		"dom": 't',
	});
	assembling_table.on( 'order.dt search.dt', function () {
			assembling_table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			} );
		} ).draw();
	var counter = 0;
	$('#tmbh-row').on( 'click', function () {
		var rowAdd = assembling_table.row.add( [
			'',
			'<select style="width: 100%" name="txt_component['+counter+']" class="form-control select2" data-placeholder="Pilih Salah Satu!" required><option value=""></option></select>',
			'xxxx',
			'<input type="number" onkeypress="return isNumberKeyAndComma(event)" name="txt_qty[]" class="form-control quantity" required/>',
		] ).draw( false ).node();
		$(rowAdd).addClass('multiRow');

		$(".select2").select2({
			placeholder: function(){
				$(this).data('placeholder');
			},
			allowClear: true,
		});
	});

	var lapor_table = $("#lapor_detail").DataTable({
						"dom": 't',
						"info": false,
						"paging": false,
						"columnDefs": [{
							"targets": [ -1 ],
							"searchable": false
						}],
					});
	lapor_table.on( 'order.dt search.dt', function () {
		lapor_table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();

	$('#tmbh-row').on( 'click', function () {
		$.ajax({
			type: POST,
			url:baseurl+"StockControl/lapor-kekurangan/getItemList",
			success:function(result)
			{
				var rowAdd = lapor_table.row.add( [
					'',
					'<select style="width: 100%" name="txt_item[]" class="form-control select2" data-placeholder="Pilih Salah Satu!" required><option value=""></option>'+result+'</select>',
					'<input type="number" onkeypress="return isNumberKeyAndComma(event)" name="txt_qty[]" class="form-control quantity" style="width: 100%" required/>',
					'<p style="text-align: center"><span class="btn btn-primary btn-sm hps-row"><i class="fa fa-minus"></i></span></p>',
				] ).draw( false ).node();

				$(".select2").select2({
					placeholder: function(){
						$(this).data('placeholder');
					},
					allowClear: true,
				});

				$('.hps-row').on( 'click', function () {
					lapor_table
						.row($(this).parents('tr'))
						.remove()
						.draw();
				});
			}
		});

	});

	$('#tmbh-row').click();

	production_monitoring();
	function production_monitoring(){
		$('#production_monitoring').DataTable({
			responsive: false,
			"scrollX": true,
			scrollCollapse: true,
			"lengthChange": false,
			"dom": '<"pull-left"f>t',
			"paging": false,
			"info": false,
			language: {
				search: "_INPUT_",
			},
		});
		$('#production_monitoring_filter input[type="search"]').css(
			{'width':'400px','display':'inline-block'}
		);
		$('#production_monitoring_filter input').attr("placeholder", "Search...")
	}

	$('.filter_from').daterangepicker({
		"singleDatePicker": true,
		"timePicker": false,
		"timePicker24Hour": true,
		"showDropdowns": false,
		locale: {
			format: 'YYYY-MM-DD'
		},
	})

	getMinDate($("input[name='txt_date_from']").val());
	function getMinDate(min_date){
		$('.filter_to').daterangepicker({
			"singleDatePicker": true,
			"timePicker": false,
			"timePicker24Hour": true,
			"showDropdowns": false,
			locale: {
				format: 'YYYY-MM-DD'
			},
			"minDate":min_date
		})
	}

	$("input[name='txt_date_from']").change(function(){
		var date_from = $(this).val();
		getMinDate(date_from);
	})

	
	$("select[name='txt_area'], select[name='txt_subassy'], input[name='txt_date_from'], input[name='txt_date_to']").change(function(){
		$("#loadingImage").html('<img src="'+baseurl+'assets/img/gif/loading3.gif" style="width: 33px"/>');
		$("select[name='txt_area'], select[name='txt_subassy'], input[name='txt_date_from'], input[name='txt_date_to']").prop('disabled',false);
		var form = $('#filter-form');
		var data = $('#filter-form').serialize();
		$("select[name='txt_area'], select[name='txt_subassy'], input[name='txt_date_from'], input[name='txt_date_to']").prop('disabled',true);
		$.ajax({
			type: "POST",
			url:baseurl+"StockControl/stock-control-new/getData",
			data:data,
			success:function(result)
			{
				$("#table-full").html(result);
				production_monitoring();
				$("#loadingImage").html('');
				$("select[name='txt_area'], select[name='txt_subassy'], input[name='txt_date_from'], input[name='txt_date_to']").prop('disabled',false);
			},
			error:function()
			{
				$("#loadingImage").html('');
				$("select[name='txt_area'], select[name='txt_subassy'], input[name='txt_date_from'], input[name='txt_date_to']").prop('disabled',false);			
				alert('Something Error');
			}
		});
	});

	$('#dataTables-limbah').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'pdf'
      ]
    });

    $('#dataTables-limbahTransaksi').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
});


//user
$(document).ready(function(){
	$(document).on('click','.btnRemoveUserResponsibility',function() {
		$(this).parents('td').parents('tr').remove();
	});
	$(document).on('click','.btnDeleteUserResponsibility',function() {
		var ths = $(this);
		var userResponsibilityId = ths.attr("id-user-responsibility")
		if (userResponsibilityId==0) {
			ths.parents('td').parents('tr').remove();
		}else{
			var confirmDeleteResponsibility = confirm('Delete menu ini?');
			if (confirmDeleteResponsibility) {
				ths.siblings('.loadingDeleteMenu').css('display','block');
				$.ajax({
					type: "POST",
					url: baseurl+"SystemAdministration/User/DeleteUserResponsibility/"+userResponsibilityId,
					success: function (response) {
						ths.siblings('.loadingDeleteMenu').css('display','none');
						ths.parents('td').parents('tr').remove();
						alert('menu deleted');
					}
				});
			}
		}
		
	});
});

$(document).ready(function(){

	$('#txtUsernameSys').on('keyup',function(){
		var user = $('#txtUsernameSys').val();

		$.ajax({
			data : {text : user},
			type : 'POST',
			url : baseurl+'SystemAdministration/User/getCheckUser',
			success : function(data){
				obj = JSON.parse(data);
				if (obj.length > 0) {
					$('#txtUsernameSysExist').html('Username sudah di daftarkan <a href="'+obj['0']['user_id']+'">Click Here</a>');
					$('#txtUsernameSysExistCollapse').collapse('show');
				}else{
					$('#txtUsernameSysExistCollapse').collapse('hide');
				}
			}
		})
	});

	$('#slcEmployeeSys').on('change',function(){
		var employee = $('#slcEmployeeSys').find(':selected').text();
		var employee = employee.substr(0,5);
		$.ajax({
			data : {text : employee},
			type : 'POST',
			url : baseurl+'SystemAdministration/User/getCheckEmployee',
			success : function(data){
				obj = JSON.parse(data);
				if (obj.length > 0) {
					$('#slcEmployeeExist').html('Employee sudah di daftarkan <a href="'+obj['0']['user_id']+'">Click Here</a>');
					$('#slcEmployeeExistCollapse').collapse('show');
				}else{
					$('#slcEmployeeExistCollapse').collapse('hide');
				}
			}
		})
	});
})

$(document).ready(function(){
	$('#txt-Dashboard-ResponsibilitySearch').on('keyup', function(){
		var responsibilityBoxItems = $('.dashboard-responsibility');
		var responsibilityMenuItems = $('.treeview');
		var nama = $(this).val();
		responsibilityBoxItems.each(function(index, box){
			var namaResponsibility = $(box).attr('data-nama');
			if (namaResponsibility.toLowerCase().search(nama.toLowerCase()) >= 0) {
				$(box).find("a").html(namaResponsibility.toLowerCase().replace(nama.toLowerCase(),"<b>" + nama.toLowerCase() + "</b>"));
				// console.log($(box).find("a").html() + " --- " + namaResponsibility);
				$(box).show();
			}else{
				$(box).hide();
			}
		})
		// console.log(responsibilityMenuItems);
		responsibilityMenuItems.each(function(index, menu){
			if ($(menu).attr('data-nama')) {
				// console.log($(menu).attr('data-nama'));
				var namaResponsibility = $(menu).attr('data-nama');
				if (namaResponsibility.toLowerCase().search(nama.toLowerCase()) >= 0) {
					$(menu).find("a").html(namaResponsibility.toLowerCase().replace(nama.toLowerCase(),"<b style='color: blue'>" + nama.toLowerCase() + "</b>"));
					// console.log($(menu).find("a").html() + " --- " + namaResponsibility);
					$(menu).show();
				}else{
					$(menu).hide();
				}
			}
		})
	});
})