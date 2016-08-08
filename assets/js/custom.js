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

		$('.input_money').maskMoney({prefix:'Rp', thousands:'.', decimal:',',precision:0});
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

		$('#submit-simulation').click(function(){
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
				}
			});
		});

		var table = $("#realization_detail").DataTable({
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
						});

		table.on( 'order.dt search.dt', function () {
			table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			} );
		} ).draw();


		var counter = counter_row;
		$('#add-row').on( 'click', function () {
			var rowAdd = table.row.add( [
				'',
				'<select style="width: 200px" name="txt_component['+counter+']" class="form-control select2" data-placeholder="Pilih Salah Satu!" required><option value=""></option></select>',
				'<input type="text" name="txt_info['+counter+']" class="form-control" required/>',
				'<input type="number" onkeypress="return isNumberKeyAndComma(event)" name="txt_qty['+counter+']" class="form-control quantity" required/>',
				'<input onkeypress="return isNumberKeyAndComma(event)" type="text" name="txt_component_nominal['+counter+']" class="form-control input_money nominal" required/>',
				'<input style="text-align: right;" type="text" name="txt_total['+counter+']" class="form-control total-nominal" required readonly/>',
				'<span class="btn btn-primary btn-sm delete-row"><i class="fa fa-minus"></i></span>',
			] ).draw( false ).node();
			$(rowAdd).addClass('multiRow');
			var component = data_Component;
			for(var item in component)
			{
				$('<option value="'+item+'">'+component[item]+'</option>').appendTo('select[name="txt_component['+counter+']"]');
			}
			counter++;
			document.getElementById('data_counter').value = counter;

			$('.delete-row').on( 'click', function () {
				table
					.row($(this).parents('tr'))
					.remove()
					.draw();
			} );
			

			$(".select2").select2({
				placeholder: function(){
					$(this).data('placeholder');
				},
				allowClear: true,
			});

			$('.input_money').maskMoney({prefix:'Rp', thousands:'.', decimal:',',precision:0});


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
		} );

		$('#add-row').click();


		$('#submit-realization').click(function(){
			$.ajax({
				type:'POST',
				data:$("#realization-form").serialize(),
				url:baseurl+"Outstation/realization/new/process",
				success:function(result)
				{
					$('#estimate-allowance').html(result);
				}
			});
		});
	});

	//------------------------REKAP TIMS.begin------------------
	//Date Picker
	$( document ).ready(function() {
		//-------begin.REKAP TIMS---------------
		$('#rekapBegin').daterangepicker({
			"singleDatePicker": true,
			"timePicker": true,
			"timePicker24Hour": true,
			"showDropdowns": false,
			locale: {
					format: 'YYYY-MM-DD HH:mm:ss'
				},
		});

		$('#rekapEnd').daterangepicker({
			"singleDatePicker": true,
			"timePicker": true,
			"timePicker24Hour": true,
			"showDropdowns": false,
			locale: {
					format: 'YYYY-MM-DD HH:mm:ss'
				},
		});
	});

	//DATA TABLE
	$(document).ready(function(){
		$('#monthRekap').DataTable({
			"ordering"	: false,
        	"info"		: false,
        	"searching"	: false,
        	"lengthChange": false,
		});
	});
	$(document).ready(function(){
		$('#personalT').DataTable({
			"ordering"	: false,
        	"info"		: false,
        	"searching"	: false,
        	"lengthChange": false,
		});
	});
	$(document).ready(function(){
		$('#personalI').DataTable({
			"ordering"	: false,
        	"info"		: false,
        	"searching"	: false,
        	"lengthChange": false,
		});
	});
	$(document).ready(function(){
		$('#personalM').DataTable({
			"ordering"	: false,
        	"info"		: false,
        	"searching"	: false,
        	"lengthChange": false,
		});
	});
	$(document).ready(function(){
		$('#personalIP').DataTable({
			"ordering"	: false,
        	"info"		: false,
        	"searching"	: false,
        	"lengthChange": false,
		});
	});
	$(document).ready(function(){
		$('#personalSP').DataTable({
			"ordering"	: false,
        	"info"		: false,
        	"searching"	: false,
        	"lengthChange": false,
		});
	});
	//-------------------------- Ambil Data Seksi.Rekap TIMS -----------------------------
	//AJAX JAVASCRIPT
	$(document).ready(function() {
		$('#departemen_select').change(function(){
			var value = $('#departemen_select').val();
			$.ajax({
				type:'POST',
				data:{data_name:value,modul:'bidang'},
				url:baseurl+"RekapTIMSPromosiPekerja/RekapTIMS/select-section",
				success:function(result)
				{
					$('#bidang_select').html(result);
				}
			});
		});
		$('#bidang_select').change(function(){
			var value = $('#bidang_select').val();
			$.ajax({
				type:'POST',
				data:{data_name:value,modul:'unit'},
				url:baseurl+"RekapTIMSPromosiPekerja/RekapTIMS/select-section",
				success:function(result)
				{
					$('#unit_select').html(result);
				}
			});
		});
		$('#unit_select').change(function(){
			var value = $('#unit_select').val();
			$.ajax({
				type:'POST',
				data:{data_name:value,modul:'seksi'},
				url:baseurl+"RekapTIMSPromosiPekerja/RekapTIMS/select-section",
				success:function(result)
				{
					$('#section_select').html(result);
				}
			});
		});
	});

	//---------------------------------REKAP TIMS.end-------------------------------