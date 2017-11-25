function goBack() {
    window.history.back();
}

$(document).ready(function(){

	//DATATABLE
	$('#master-index').DataTable({
		"filter": true,
		"lengthChange": false,
		"ordering": false,
		"autoWidth": false,
		"scrollX": true,
	});

	//DATATABLE PENJADWALAN PAKET
	$('#tblpackagetraining').DataTable({
		"filter": false,
		"lengthChange": false,
		"ordering": false,
		"autoWidth": false,
		"scrollX": true,
	});

	//DATATABLE RECORD PELATIHAN
	$('#tblrecord').DataTable({
		"filter": false,
		"lengthChange": false,
		"ordering": false,
		"autoWidth": false,
		"scrollX": true,
	});

	//DATATABLE RECORD PELATIHAN (CALL)
	function recorddatatable(){
		$('#tblrecord').DataTable({
			"filter": false,
			"lengthChange": false,
			"ordering": false,
			"autoWidth": false,
			"scrollX": true,
		});
	}	

	//TIMEPICKER UNTUK FORM PENJADWALAN
	$('#TrainingStartTime').timepicker({
		showMeridian: false
	});

	//TIMEPICKER UNTUK FORM PENJADWALAN
	$('#TrainingEndTime').timepicker({
		showMeridian: false
	});

	//DATEPICKER UNTUK FORM PENJADWALAN
	// $('.singledateADM').daterangepicker({
	// 	"singleDatePicker": true,
	// 	"timePicker": false,
	// 	"timePicker24Hour": true,
	// 	"showDropdowns": false,
	// 	locale: {
	// 		format: 'DD/MM/YYYY'
	// 	},
	// });

	$('.singledateADM').datepicker({
    	format:'dd/mm/yyyy'
	});

	 $(".startdate").datepicker({
    	//format:'dd/mm/yyyy'
    });

    $(".enddate").datepicker({
    	//format:'dd/mm/yyyy'
    });

    $(".dday-tgl").datepicker({
    	//format:'dd/mm/yyyy'
    });
	
	$('.startdate').change(function() {
		var range 	= $('#dayrange').val();
		var rrange 	= parseInt(range)-1;
  		var date2 	= $('.startdate').datepicker('getDate', '+1d'); 
 		date2.setDate(date2.getDate()+rrange); 
  		$('.enddate').datepicker('setDate', date2);

  		$('.obclone').each(function(){
  			var range 	= $(this).find('.dday').val();
  			var rrange 	= parseInt(range)-1;
  			var date2 	= $('.startdate').datepicker('getDate', '+1d'); 
	 		date2.setDate(date2.getDate()+rrange); 
	  		$(this).find('.dday-tgl').datepicker('setDate', date2);
  		});
	});

	//SET START DATE APABILA DIGUNAKAN SAAT EDIT
	if (typeof $('#scheduledate').val() !== 'undefined'){
		var startDate = $('#scheduledate').val()
		$(".singledateADM").data('daterangepicker').setStartDate(startDate);
		$(".singledateADM").data('daterangepicker').setEndDate(startDate)
	};

	//SELECT ROOM
	$(".SlcRuang").select2({
		placeholder: "Ruang",
		tags: true,
	});

	//SELECT EMPLOYEE UNTUK CREATE INTERNAL TRAINER
	$(".js-slcInternalTrainer").select2({
		placeholder: "No Induk",
		minimumInputLength: 3,
		ajax: {		
			url:baseurl+"ADMPelatihan/MasterTrainer/GetNoInduk",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					type: $('select#slcInternalTrainer').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return { id:obj.NoInduk+'-'+obj.Nama, text:obj.NoInduk+' - '+obj.Nama};
					})
				};
			}
		}
	});

	//SELECT TUJUAN TRAINING
	$(".js-slcObjective").select2({
		placeholder: "Tujuan Pelatihan",
		minimumInputLength: 1,
		tags: true,
		ajax: {		
			url:baseurl+"ADMPelatihan/Penjadwalan/GetObjective",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					type: $('select#slcObjective').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return { id:obj.objective, text:obj.objective};
					})
				};
			}
		}	
	});

	//SELECT UNTUK PESERTA TRAINING STAFF
	$(".js-slcEmployee").select2({
		placeholder: "No Induk",
		minimumInputLength: 3,
		ajax: {		
			url:baseurl+"ADMPelatihan/MasterTrainer/GetNoInduk",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					type: $('select#slcEmployee').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return { id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
					})
				};
			}
		}	
	});

	//SELECT UNTUK PESERTA TRAINING NONSTAFF
	$(".js-slcApplicant").select2({
		placeholder: "Nama",
		minimumInputLength: 3,
		ajax: {		
			url:baseurl+"ADMPelatihan/MasterTrainer/GetApplicant",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					type: $('select#slcApplicant').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return { id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
					})
				};
			}
		}	
	});

	//SELECT UNTUK TRAINER PELATIHAN
	$(".js-slcTrainer").select2({
		placeholder: "No Induk",
		minimumInputLength: 3,
		ajax: {		
			url:baseurl+"ADMPelatihan/Penjadwalan/GetTrainer",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					type: $('select#slcTrainer').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return { id:obj.NoId, text:'('+obj.NoInduk+') '+obj.Nama};
					})
				};
			}
		}	
	});

	//FILTER
	$(document).ready(function() {
		$('#FilterRecord').click(function(){
			$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading12.gif" width="34px"/>');
			
			var start 		= $('input[name="TxtStartDate"]').val();
			var end 		= $('input[name="TxtEndDate"]').val();
			var status 		= $('input[name="TxtStatus"]').val();

			$.ajax({
				type: "POST",
				data:{
						start:start,
						end:end,
						status:status,
				},
				url:baseurl+"ADMPelatihan/C_Record/FilterRecord",
				success:function(result)
				{
					$('#loading').html('');
					$("#table-full").html(result);
					recorddatatable();
				}
			});
		});
	});

//-----------------------------------------------REPORT----------------------------------
	
	//SELECT EMPLOYEE UNTUK REPORT
	$(".js-slcReportEmployee").select2({
		placeholder: "Nama",
		minimumInputLength: 3,
		ajax: {		
			url:baseurl+"ADMPelatihan/Report/GetNoInduk",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					type: $('select#slcReportEmployee').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return { id:obj.Nama, text:obj.NoInduk+' - '+obj.Nama};
					})
				};
			}
		}
	});

	//SELECT SEKSI UNTUK REPORT
	$(".js-slcReportSection").select2({
		placeholder: "Nama Seksi",
		minimumInputLength: 3,
		ajax: {		
			url:baseurl+"ADMPelatihan/Report/GetSeksi",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					type: $('select#slcReportSection').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return {
							id:obj.Nama_Seksi,
							text:obj.Nama_Seksi
						};
					})
				};
			}
		}
	});

	//GET REPORT1
	$(document).ready(function() {	
		$('#SearchReport1').click(function(){
			$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading12.gif" width="34px"/>');
			
			var name 		= $('select[name="slcReportEmployee"]').val();

			$.ajax({
				type: "POST",
				data:{
						name:name,
				},
				url:baseurl+"ADMPelatihan/C_Report/GetReport1",
				success:function(result)
				{
					$('#loading').html('');
					$("#table-full").html(result);
					recorddatatable();
				}
			});
		});
	});

	//GET REPORT2
	$(document).ready(function() {	
		$('#SearchReport2').click(function(){
			$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading12.gif" width="34px"/>');
			
			var section 	= $('select[name=slcReportSection]').val();
			var year 		= $('select[name="slcTahun"]').val();

			$.ajax({
				type: "POST",
				data:{
						section:section,
						year:year,
				},
				url:baseurl+"ADMPelatihan/C_Report/GetReport2",
				success:function(result)
				{
					$('#loading').html('');
					$("#table-full").html(result);
					recorddatatable();
				}
			});
		});
	});

	//GET REPORT3
	$(document).ready(function() {	
		$('#SearchReport3').click(function(){
			$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading12.gif" width="34px"/>');
			
			var date1 		= $('input[name="txtDate1"]').val();
			var date2 		= $('input[name="txtDate2"]').val();

			$.ajax({
				type: "POST",
				data:{
						date1:date1,
						date2:date2,
				},
				url:baseurl+"ADMPelatihan/C_Report/GetReport3",
				success:function(result)
				{
					$('#loading').html('');
					$("#table-full").html(result);
					recorddatatable();
				}
			});
		});
	});

	//GET REKAP TRAINING
	$(document).ready(function() {	
		$('#SearchRekapTraining').click(function(){
			$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading12.gif" width="34px"/>');
			
			var date1 	= $('input[name=txtDate1]').val();
			var date2 		= $('input[name=txtDate2]').val();

			$.ajax({
				type: "POST",
				data:{
						date1:date1,
						date2:date2,
				},
				url:baseurl+"ADMPelatihan/Report/GetRkpTraining",
				success:function(result)
				{	
					// console.log(result);
					$('#loading').html('');
					$("#table-full").html(result);
					recorddatatable();
				}
			});
		});
	});

	//GET PERSENTASE PESERTA TRAINING
	$(document).ready(function() {	
		$('#SearchPersenPeserta').click(function(){
			$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading12.gif" width="34px"/>');
			
			var date1 		= $('input[name=txtDate1]').val();
			var date2 		= $('input[name=txtDate2]').val();

			$.ajax({
				type: "POST",
				data:{
						date1:date1,
						date2:date2,
				},
				url:baseurl+"ADMPelatihan/Report/GetPercentParticipant",
				success:function(result)
				{	
					// console.log(result);
					$('#loading').html('');
					$("#table-full").html(result);
					recorddatatable();
				}
			});
		});
	});

	//GET EFEKTIVITAS TRAINING
	$(document).ready(function() {	
		$('#SearchEfektifTrain').click(function(){
			$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading12.gif" width="34px"/>');
			
			var date1 		= $('input[name=txtDate1]').val();
			var date2 		= $('input[name=txtDate2]').val();

			$.ajax({
				type: "POST",
				data:{
						date1:date1,
						date2:date2,
				},
				url:baseurl+"ADMPelatihan/Report/GetEfektivitasTraining",
				success:function(result)
				{	
					// console.log(result);
					$('#loading').html('');
					$("#table-full").html(result);
					recorddatatable();
				}
			});
		});
	});

});
	
	//MENAMBAH ROW UNTUK TRAINING (MASTER PACKAGE)
	function AddTraining(base){
		var newgroup = $('<tr>').addClass('clone');
		var e = jQuery.Event( "click" );
		e.preventDefault();
		$("select#Training:last").select2("destroy");
		
		$('.clone').last().clone().appendTo(newgroup).appendTo('#tbodyTrainingPackage');

		$("select#Training").select2({
			placeholder: "Pelatihan",
			allowClear : true,
		});

		$("select#Training:last").select2({
			placeholder: "Pelatihan",
			allowClear : true,
		});

		$("select#Training:last").val("").change();
		$("input#objective:last").val("").change();
	}

	//MENAMBAH ROW UNTUK SEGMENT KUESIONER (MASTER QUESTIONNAIRE SEGMENT)
	function AddSegment(base){
		if (base == 'edit') {
			var disable = 'disabled';
			var onkeyup = 'onkeyup="insertKuesAjax(event, this)"';
		}else{
			var disable = '';
			var onkeyup = '';
		}
		// var newgroup = $('<tr>').addClass('clone');
		var e = jQuery.Event( "click" );
		// e.preventDefault();
		
		// $('.clone').last().clone().appendTo(newgroup).appendTo('#tbodyQuestionnaireSegment'
		var n = $('#tbodyQuestionnaireSegment tr').length;
		counter = n+1;

        var newRow = jQuery("<tr class='clone' row-id='"+counter+"'>"
									+"<td >"+ counter +" </td>"
									+"<td>"
										+"<input "+onkeyup+" id='segment' name='txtSegment[]' class='form-control segment' data-toggle='tooltip' data-placement='top' title='Tekan Enter untuk Menyimpan'> "
										+"<input type='hidden' name='idSegment[]' value='0'>"
									+"</td>"
									+"<td>"
										+"<a href='javascript:void(0);' class='btn btn-danger btn-xs' id='DelSegment' title='Hapus Baris' onclick='delSpesifikRow("+counter+",0)'><i class='fa fa-remove'></i>Delete</a>"
										+"<a "+disable+" data-id='segment-button' href='"+baseurl+"ADMPelatihan/MasterQuestionnaire/Edit' data-toggle='modal'  class='btn btn-xs btn-warning' style='margin:2px'><i class='fa fa-search'></i></i> Statement</a>"
									+"</td>"
									+"</tr>");
			jQuery("#tbodyQuestionnaireSegment").append(newRow);
			
	}
	function AddSegmentCreate(base){
			var e = jQuery.Event( "click" );
			var n = $('#tbodyQuestionnaireSegmentC tr').length;
			counter = n+1;

	        var newRow = jQuery("<tr class='clone' row-id='"+counter+"'>"
										+"<td >"+ counter +" </td>"
										+"<td>"
											+"<input id='segment' name='txtSegment[]' class='form-control segment' placeholder='Nama Bagian'> "
											+"<input type='hidden' name='idSegment[]' value='0'>"
										+"</td>"
										+"<td>"
											+"<a href='javascript:void(0);' class='btn btn-danger btn-xs' id='DelSegment' title='Hapus Baris' onclick='delCreateSegment("+counter+",0)'><i class='fa fa-remove'></i>Delete</a>"
										+"</td>"
										+"</tr>");
				jQuery("#tbodyQuestionnaireSegmentC").append(newRow);
				
		}

	//MENAMBAH ROW UNTUK SEGMENT KUESIONER (MASTER QUESTIONNAIRE SEGMENT)
	// function AddSegmentEssay(base){
	// 	var newgroup = $('<tr>').addClass('cclone');
	// 	var e = jQuery.Event( "click" );
	// 	e.preventDefault();
		
	// 	$('.cclone').last().clone().appendTo(newgroup).appendTo('#tbodyQuestionnaireSegmentEssay');

	// 	$("input#segmentessay:last").val("").change();
	// }
	function  AddSegmentEssayC(base){
			var e = jQuery.Event( "click" );
			var n = $('#tbodyQuestionnaireSegmentEssay tr').length;
			counter = n+1;

			var newRow = jQuery("<tr class='clone' row-id='"+counter+"'>"
									+"<td >"+ counter +" </td>"
									+"<td>"
										+"<input id='segmentessay' name='txtSegmentEssay[]' class='form-control segmentessay' placeholder='Nama Bagian'>"
										+"<input type='hidden' name='idSegment[]' value='0'>"
									+"</td>"
									+"<td>"
										+"<a href='javascript:void(0);' class='btn btn-danger btn-xs' id='DelSegment' title='Hapus Baris' onclick='delCreateSegmentEssay("+counter+",0)'><i class='fa fa-remove'></i>Delete</a>"
									+"</td>"
									+"</tr>");
			jQuery("#tbodyQuestionnaireSegmentEssay").append(newRow);
	}


	//MENGHAPUS ROW UNTUK STATEMENT KUESIONER (MASTER QUESTIONNAIRE STATEMENT)
	// function delStatRow(id){
	// 	var rowCount = $("#tbodyStatement"+id+" tr").size();
	// 	if(rowCount > 1){
	// 		$("#tbodyStatement"+id+" tr:last").remove();
	// 	}else{
	// 		alert('Minimal harus ada satu baris tersisa');
	// 	}
	// }
	function delStatRow(id){
			var rowCount = $("#tbodyStatementC"+id+" tr").size();
			if(rowCount > 1){
				$("#tbodyStatementC"+id+" tr:last").remove();
			}else{
				alert('Minimal harus ada satu baris tersisa');
			}
		}

	//MENAMBAH ROW UNTUK STATEMENT KUESIONER (MASTER QUESTIONNAIRE STATEMENT)
	function AddStatement(id){
		// var newgroup = $('<tr>').addClass('clone'+id);
		// e.preventDefault();
		// $('.clone'+id).last().clone().appendTo(newgroup).appendTo('#tbodyStatement'+id);
		// $("input#statement"+id+":last").val("").change();


		var e = jQuery.Event( "click" );
		var n = $('#tbodyStatement tr').length;
		counter = n+1;
        var newRow = jQuery("<tr class='clone' row-id='"+counter+"'>"
									+"<td >"+ counter +" </td>"
									+"<td>"
										+"<input id='statement' name='txtStatement[]' class='form-control statement'> "
										+"<input type='hidden' name='idStatement[]' value='0'>"
									+"</td>"
									+"<td>"
										+"<a href='javascript:void(0);' class='btn btn-danger btn-xs' id='DelStatement' title='Hapus Baris' onclick='delSpesifikRowSt("+counter+",0)'><i class='fa fa-remove'></i>Delete</a>"
									+"</td>"
									+"</tr>");
			jQuery("#tbodyStatement").append(newRow);
	}

	function AddStatementC(numb,id,inputName){
			var n = $('#tbodyStatementC'+id+' tr').length;
			// n=1;
			var tbID = String('tblStatement');
			var tbodyID = String('tbodyStatementC');
			counter = n+1;
	        var newRow = jQuery("<tr class='clone' row-id='"+counter+"'>"
										+"<td >"+ counter +" </td>"
										+"<td>"
											+"<input id='statement"+numb+"' name='"+inputName+"[]' class='form-control statement'> "
										+"</td>"
										+"<td>"
											+"<a href='javascript:void(0);' class='btn btn-danger btn-xs' id='DelSegment' title='Hapus Baris' onclick='delCreateStatement("+numb+","+counter+","+id+",0)'><i class='fa fa-remove'></i>Delete</a>"
										+"</td>"
										+"</tr>");
				jQuery("#tbodyStatementC"+id).append(newRow);
		}

	//MENAMBAH ROW UNTUK OBJECTIVE (MASTER TRAINING)
	function AddObjective(base){
		var newgroup = $('<tr>').addClass('obclone');
		var e = jQuery.Event( "click" );
		e.preventDefault();
		$("select#slcObjective:last").select2("destroy");		

		$('.obclone').last().clone().appendTo(newgroup).appendTo('#tbodyObjective');
		
		$(".js-slcObjective").select2({
			placeholder: "Tujuan Pelatihan",
			minimumInputLength: 1,
			tags: true,
			ajax: {		
				url:baseurl+"ADMPelatihan/Penjadwalan/GetObjective",
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term,
						type: $('select#slcObjective').val()
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id:obj.objective, text:obj.objective};
						})
					};
				}
			}	
		});

		$(".js-slcObjective:last").select2({
			placeholder: "Tujuan Pelatihan",
			minimumInputLength: 1,
			tags: true,
			ajax: {		
				url:baseurl+"ADMPelatihan/Penjadwalan/GetObjective",
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term,
						type: $('select#slcObjective').val()
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id:obj.objective, text:obj.objective};
						})
					};
				}
			}	
		});

		$("select#slcObjective:last").val("").change();
	}
	
	//MENAMBAH ROW UNTUK DAFTAR PESERTA (PENJADWALAN TRAINING)
	function AddApplicant(base){
		var row = $('input#jmlpeserta').val();
		var maxrow = parseInt(row)+1;
		var table = document.getElementById("tblParticipant");
		var rowCount = table.rows.length;

		if(rowCount < maxrow){
			
			var newgroup = $('<tr>').addClass('clone');
			var e = jQuery.Event( "click" );
			e.preventDefault();
			$("select#slcApplicant:last").select2("destroy");

			$('.clone').last().clone().appendTo(newgroup).appendTo('#tbodyParticipant');

			$(".js-slcApplicant").select2({
				placeholder: "Nama",
				minimumInputLength: 3,
				ajax: {		
					url:baseurl+"ADMPelatihan/MasterTrainer/GetApplicant",
					dataType: 'json',
					type: "GET",
					data: function (params) {
						var queryParameters = {
							term: params.term,
							type: $('select#slcApplicant').val()
						}
						return queryParameters;
					},
					processResults: function (data) {
						return {
							results: $.map(data, function(obj) {
								return { id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
							})
						};
					}
				}	
			});

			$(".js-slcApplicant:last").select2({
				placeholder: "Nama",
				minimumInputLength: 3,
				ajax: {		
					url:baseurl+"ADMPelatihan/MasterTrainer/GetApplicant",
					dataType: 'json',
					type: "GET",
					data: function (params) {
						var queryParameters = {
							term: params.term,
							type: $('select#slcApplicant').val()
						}
						return queryParameters;
					},
					processResults: function (data) {
						return {
							results: $.map(data, function(obj) {
								return { id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
							})
						};
					}
				}	
			});

			$("select#slcApplicant:last").val("").change();
			delete_row();
		}else{
			alert('Jumlah peserta sudah maksimal');
		}
		
	}

	//MENAMBAH ROW UNTUK DAFTAR PESERTA (PENJADWALAN TRAINING)
	function AddParticipant(base){
		var row = $('input#jmlpeserta').val();
		var maxrow = parseInt(row)+1;
		var table = document.getElementById("tblParticipant");
		var rowCount = table.rows.length;
		var nomer = 0;
		var nomer = rowCount;

		if(rowCount < maxrow){
			var e = jQuery.Event( "click" );
			e.preventDefault();
			var newRow = jQuery("<tr class='clone' row-id='"+nomer+"'>"
									+"<td >"+ nomer +" </td>"
									+"<td>"
										+"<div class='input-group'>"
											+"<div class='input-group-addon'>"
												+"<i class='glyphicon glyphicon-user'></i>"
											+"</div>"
											+"<select class='form-control js-slcEmployee' name='slcEmployee[]' id='slcEmployee'>"
												+"<option value=''></option>"
											+"</select>"
										+"</div>"
									+"</td>"
									+"<td>"
										+"<button type='button' class='btn btn-danger list-del' onclick='deleteRowAjax("+nomer+",0,0)'><i class='fa fa-remove'></i></button>"
									+"</td>"
								+"</tr>");
			jQuery("#tblParticipant").append(newRow);

			$("select#slcEmployee").select2({
						placeholder: "No Induk",
						minimumInputLength: 3,
						tags: true,
						ajax: {
							url:baseurl+"ADMPelatihan/MasterTrainer/GetNoInduk",
							dataType: 'json',
							type: "GET",
							data: function (params) {
								var queryParameters = {
									term: params.term,
									type: $('select#slcEmployee').val()
								}
								return queryParameters;
							},
							processResults: function (data) {
								return {
									results: $.map(data, function(obj) {
										return { id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
									})
								};
							}
						}	
					}); 

			$("select#slcEmployee:last").select2({
						placeholder: "No Induk",
						minimumInputLength: 3,
						tags: true,
						ajax: {		
							url:baseurl+"ADMPelatihan/MasterTrainer/GetNoInduk",
							dataType: 'json',
							type: "GET",
							data: function (params) {
								var queryParameters = {
									term: params.term,
									type: $('select#slcEmployee').val()
								}
								return queryParameters;
							},
							processResults: function (data) {
								return {
									results: $.map(data, function(obj) {
										return { id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
									})
								};
							}
						}	
					});

		// alert(rowCount);
			$("select#slcEmployee:last").val("").change();
		}else{
			alert('Jumlah peserta sudah maksimal');
		}
	}

	function AddParticipantEdit(base){
		var row = $('input#jmlpeserta').val();
		var maxrow = parseInt(row)+1;
		var table = document.getElementById("tblParticipant");
		var rowCount = table.rows.length;
		var nomer = 0;
		var nomer = rowCount;

		if(rowCount < maxrow){
			var e = jQuery.Event( "click" );
			e.preventDefault();
			var newRow = jQuery("<tr class='clone' row-id='"+nomer+"'>"
									+"<td >"+ nomer +" </td>"
									+"<td>"
										+"<div class='input-group'>"
											+"<div class='input-group-addon'>"
												+"<i class='glyphicon glyphicon-user'></i>"
											+"</div>"
											+"<select class='form-control js-slcEmployee' name='slcEmployee[]' id='slcEmployee'>"
												+"<option value=''></option>"
												+"<input type='text' name='txtParticipantID' value='0' hidden>"
											+"</select>"
										+"</div>"
									+"</td>"
									+"<td>"
										+"<?php"
										+"$participant_status='Unconfirmed';"
											+"if($pt['status']==1){$participant_status='Hadir';}"
											+"if($pt['status']==2){$participant_status='Tidak Hadir';}"									
											+"echo $participant_status;"
											+"?>"
										+"</td>"
									+"<td>"
										+"<button type='button' class='btn btn-danger list-del' onclick='deleteRowAjax("+nomer+",0,0)'><i class='fa fa-remove'></i></button>"
									+"</td>"
								+"</tr>");
			jQuery("#tblParticipant").append(newRow);

			$("select#slcEmployee").select2({
						placeholder: "No Induk",
						minimumInputLength: 3,
						tags: true,
						ajax: {
							url:baseurl+"ADMPelatihan/MasterTrainer/GetNoInduk",
							dataType: 'json',
							type: "GET",
							data: function (params) {
								var queryParameters = {
									term: params.term,
									type: $('select#slcEmployee').val()
								}
								return queryParameters;
							},
							processResults: function (data) {
								return {
									results: $.map(data, function(obj) {
										return { id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
									})
								};
							}
						}	
					}); 

			$("select#slcEmployee:last").select2({
						placeholder: "No Induk",
						minimumInputLength: 3,
						tags: true,
						ajax: {		
							url:baseurl+"ADMPelatihan/MasterTrainer/GetNoInduk",
							dataType: 'json',
							type: "GET",
							data: function (params) {
								var queryParameters = {
									term: params.term,
									type: $('select#slcEmployee').val()
								}
								return queryParameters;
							},
							processResults: function (data) {
								return {
									results: $.map(data, function(obj) {
										return { id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
									})
								};
							}
						}	
					});

			$("select#slcEmployee:last").val("").change();
		}else{
			alert('Jumlah peserta sudah maksimal');		
		}
	}

	function AddParticipantSchedule(base) {
		var row = $('input#jmlpeserta').val();
		var maxrow = parseInt(row)+1;
		var table = document.getElementById("tblParticipant");
		var rowCount = table.rows.length;
		var nomer = 0;
		var nomer = rowCount;

		if(rowCount < maxrow){
			var e = jQuery.Event( "click" );
			e.preventDefault();
			var newRow = jQuery("<tr class='clone'>"
									+"<td >"+ nomer +"</td>"
									+"<td>"
										+"<div class='input-group'>"
											+"<div class='input-group-addon'>"
												+"<i class='glyphicon glyphicon-user'></i>"
											+"</div>"
											+"<select class='form-control js-slcEmployee' name='slcEmployee[]' id='slcEmployee' required>"
												+"<option value=''></option>"
											+"</select>"
										+"</div>"
									+"</td>"
									+"<td>"
										+"<button type='button' class='btn btn-danger list-del'><i class='fa fa-remove'></i></button>"
									+"</td>"
								+"</tr>");
			jQuery("#tblParticipant").append(newRow);
		
		$("select#slcEmployee").select2({
						placeholder: "No Induk",
						minimumInputLength: 3,
						tags: true,
						ajax: {
							url:baseurl+"ADMPelatihan/MasterTrainer/GetNoInduk",
							dataType: 'json',
							type: "GET",
							data: function (params) {
								var queryParameters = {
									term: params.term,
									type: $('select#slcEmployee').val()
								}
								return queryParameters;
							},
							processResults: function (data) {
								return {
									results: $.map(data, function(obj) {
										return { id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
									})
								};
							}
						}	
					}); 

			$("select#slcEmployee:last").select2({
						placeholder: "No Induk",
						minimumInputLength: 3,
						tags: true,
						ajax: {		
							url:baseurl+"ADMPelatihan/MasterTrainer/GetNoInduk",
							dataType: 'json',
							type: "GET",
							data: function (params) {
								var queryParameters = {
									term: params.term,
									type: $('select#slcEmployee').val()
								}
								return queryParameters;
							},
							processResults: function (data) {
								return {
									results: $.map(data, function(obj) {
										return { id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
									})
								};
							}
						}	
					});

			$("select#slcEmployee:last").val("").change();
		}else{
			alert('Jumlah peserta sudah maksimal');		
		}

	}

	//DELETE ROW UNTUK DAFTAR PESERTA (PENJADWALAN TRAINING)
	delete_row();
	function delete_row(){
		$('.list-del').click(function(){
			var formCount = $("#tbodyParticipant .clone").size();
			if(formCount <= 1){
				alert("Can't delete more form!");
			}
			else{
				$(this).closest('.clone').remove();
			}
		});
	}

	$(function() {
    	$('#divobjective').hide(); 
    	$('#slcStatus').change(function(){
        	if($('#slcStatus').val() == 1) {
           		$('#divobjective').show(); 
       		} else {
            	$('#divobjective').hide(); 
        	} 
    	});
	});

function delCreateSegment(rowid,segmentid) {
	if (segmentid == '0') {
		$('#tblQuestionnaireSegment #tbodyQuestionnaireSegmentC tr[row-id="'+rowid+'"]').remove();
	}
}
function delCreateSegmentEssay(rowid,segmentid) {
	if (segmentid == '0') {
		$('#tblQuestionnaireSegmentEssay #tbodyQuestionnaireSegmentEssay tr[row-id="'+rowid+'"]').remove();
	}
}
function delCreateStatement(tbID,rowid,id,statementid) {
	if (statementid == '0') {
		$('#tblStatement'+tbID+' #tbodyStatementC'+id+' tr[row-id="'+rowid+'"]').remove();
	}
}

function delSpesifikRow(rowid,segmentid) {
	if (segmentid == '0') {
		$('#tblQuestionnaireSegment #tbodyQuestionnaireSegment tr[row-id="'+rowid+'"]').remove();
	}else{
		$.ajax({
			type:'POST',
			url:baseurl+"ADMPelatihan/MasterQuestionnaire/delSeg/"+segmentid,
			success:function(result)
			{
				$('#tblQuestionnaireSegment #tbodyQuestionnaireSegment tr[row-id="'+rowid+'"]').remove();
			}
		});
	}
	
}

function delSpesifikRowSt(rowid,statementid) {
	if(statementid == '0'){
			$('#tblQuestionnaireStatement #tbodyStatement tr[row-id="'+rowid+'"]').remove();
	}
	else{
		$.ajax({
			type:'POST',
			url:baseurl+"ADMPelatihan/MasterQuestionnaire/delSt/"+statementid,
			success:function(result)
			{
				$('#tblQuestionnaireStatement #tbodyStatement tr[row-id="'+rowid+'"]').remove();
			}
		});
	}
	
}

function deleteRowAjax(rowid,dataID,schID) {
	if(dataID == '0'){
			$('#tblParticipant #tbodyParticipant tr[row-id="'+rowid+'"]').remove();
	}else{
		$.ajax({
			type:'POST',
			url:baseurl+"ADMPelatihan/Record/deleteParticipant/"+dataID+'/'+schID,
			success:function(result)
			{
				$('#tblParticipant #tbodyParticipant tr[row-id="'+rowid+'"]').remove();
			}
		})
	}
}
function insertKuesAjax(event, th){
	event.preventDefault();
	if (event.keyCode === 13) {
		var quID = $('input[name="txtQuestionnaireId"]').val();
		var quesId = $(th).attr('data-id');
		var value = $(th).val();
		$.ajax({
			url : baseurl+"ADMPelatihan/MasterQuestionnaire/editSave/"+quID,
			type: 'POST',
			data: {
				accessType : 'ajax',
				txtSegment : value, 
				txtQuestionnaireId : quID,
				idSegment : quID,
				lineId : quesId,
			},
			success:function(result)
			{
				$(th).closest('tr').find('a[data-id="segment-button"]').removeAttr("disabled"); 
				$(th).closest('tr').find('a[data-id="segment-button"]').attr("href", baseurl+"ADMPelatihan/MasterQuestionnaire/EditStatement/"+quID+'/'+result);
			}
		})
	}
}


// MODAL SHOW PESERTA DI SECTION
function showModPar(schid,section){
	$.ajax({
		type: "POST",
		data:{
			section:section
		},
		url:baseurl+"ADMPelatihan/Report/GetTrainingPrtcp/"+schid,
		success:function(result)
		{
			$('#showModPar table tbody').html(result);
			$('div#showModPar').modal('show');
		}
	});
}

// WARNING NILAI MINIMAL
function stafKKM(th,col,row) {
	var kkm = $('input#kkmStaff').val();
	var nilai = $(th).val();

	if (nilai < kkm) {
		$('tr[row-id="'+row+'"] td[col-id="'+col+'"]').addClass('has-error');
		console.log(kkm);
		console.log(nilai);
	}else{
		$('tr[row-id="'+row+'"] td[col-id="'+col+'"]').removeClass('has-error');
		$('tr[row-id="'+row+'"] td[col-id="'+col+'"]').addClass('has-success');
	}

}

function nonstafKKM(th,col,row) {
	var kkm = $('input#kkmNonStaff').val();
	var nilai = $(th).val();

	if (nilai < kkm) {
		$('tr[row-id="'+row+'"] td[col-id="'+col+'"]').addClass('has-error');
		console.log(kkm);
		console.log(nilai);
	}else{
		$('tr[row-id="'+row+'"] td[col-id="'+col+'"]').removeClass('has-error');
		$('tr[row-id="'+row+'"] td[col-id="'+col+'"]').addClass('has-success');
	}
}