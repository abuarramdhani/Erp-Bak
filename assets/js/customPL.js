function goBack() {
    window.history.back();
}


$(document).ready(function(){
	// SETTIMEOUT Z-INDEX
	$(document).on('show.bs.modal', '.modal', function () {
	    var zIndex = 1050 + (10 * $('.modal:visible').length);
	    $(this).css('z-index', zIndex);
	    setTimeout(function() {
	        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
	    }, 0);
	});

	// DATEPICKER ADM_PELATIHAN
	$('.singledateADM').datepicker({
    	format:'dd/mm/yyyy',
    	autoclose: true
	});
	$('#txtTanggalUndanganPelatihan').datepicker({
    	"autoclose": true,
		"todayHiglight": true,
		"format": 'dd MM yyyy'
	});
	$('#txtWaktuUndanganPelatihan').timepicker({
    	maxHours:24,
  		showMeridian:false,
	});
	$('.singledateADM_Que').datepicker({
    	format:'yyyy/mm/dd',
    	autoclose: true
	});

	$('.singledateADM_Range').daterangepicker({
		"todayHighlight" : true
	});

	//DATATABLE
	$('#master-index').DataTable({
		"filter": true,
		"lengthChange": false,
		"ordering": false,
		"autoWidth": false,
		"scrollX": true,
	});

	// DATATABLE UNDANGAN
	$('.datatable-undangan-adm').DataTable({
		dom: 'frtp',
	});
	$(document).ready(function(){
		$('.data-tims-personal').DataTable({
			"dom": '<"pull-left"f>t<"pull-right"p>',
        	"info"		: false,
        	"searching"	: false,
        	"lengthChange": false,
        	"pageLength": 5
		});
		$('.datatable-tarikdatapekerja').DataTable({
			retrieve : true,
			"info"		: true,
	    	"searching"	: true,
	    	"lengthChange": true,
		});
	});
	$(document).ready(function(){
		$('.data-tims-personal').DataTable({
			"dom": '<"pull-left"f>t<"pull-right"p>',
        	"info"		: false,
        	"searching"	: false,
        	"lengthChange": false,
        	"pageLength": 5
		});
		$('.datatable-tarikshiftpekerja').DataTable({
			retrieve : true,
			"info"		: true,
	    	"searching"	: true,
	    	"lengthChange": true,
		});
	});

	// SELECT2 UNDANGAN
	$('#txtPesertaUndanganPelatihan').select2({
		maximumSelectionLength : 15,
		allowClear: true,
		placeholder: "Peserta"
	});

	//DATATABLE PENJADWALAN PAKET
	$('#tblpackagetraining').DataTable({
		"filter": false,
		"lengthChange": false,
		"ordering": false,
		"autoWidth": false,
		"scrollX": true,
		"paging":false
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

	$(".startdate").datepicker({
    	//format:'dd/mm/yyyy',
    	autoclose: true
    });

    $(".enddate").datepicker({
    	//format:'dd/mm/yyyy',
    	autoclose: true
    });

    $(".dday-tgl").datepicker({
    	//format:'dd/mm/yyyy',
    	autoclose: true
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

	// ALERT DATEPICKER
	$('#checkdateSch').change(function(){
		var selectedDate = $('#checkdateSch').datepicker('getDate'); 
		var now = new Date(); now.setHours(0,0,0,0); 
		if (selectedDate < now) {  
			alert('Set tanggal salah, cek kembali tanggal yang di pilih');
		} 
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
	$(".js-slcEmployeeTraining").select2({
		placeholder: "No Induk",
		minimumInputLength: 3,
		ajax: {		
			url:baseurl+"ADMPelatihan/MasterTrainer/GetNoIndukTraining",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					training: $('#txtNamaPelatihan').val()
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
						return { id:obj.purpose, text:obj.purpose};
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
		placeholder: "No Induk / Nama Pekerja",
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

	//SELECT TRAINER UNTUK REPORT
	$(".js-slcReportTrainer").select2({
		placeholder: "Nama Trainer",
		minimumInputLength: 3,
		ajax: {		
			url:baseurl+"ADMPelatihan/Report/GetTrainerFilter",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					type: $('select#slcReportTrainer').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return { 
							id:obj.trainer_id, 
							text:obj.trainer_name
						};
					})
				};
			}
		}
	});

	//SELECT UNIT UNTUK REPORT
	$(".js-slcReportUnit").select2({
		placeholder: "Nama Unit",
		minimumInputLength: 3,
		ajax: {		
			url:baseurl+"ADMPelatihan/Report/GetUnitFilter",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					type: $('select#slcReportUnit').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return { 
							id:obj.unit, 
							text:obj.unit
						};
					})
				};
			}
		}
	});
	//SELECT DEPARTEMEN UNTUK REPORT
	$(".js-slcReportDepartemen").select2({
		placeholder: "Nama Departemen",
		minimumInputLength: 3,
		ajax: {		
			url:baseurl+"ADMPelatihan/Report/GetDeptFilter",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					type: $('select#slcReportDepartemen').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return { 
							id:obj.dept, 
							text:obj.dept
						};
					})
				};
			}
		}
	});

	//SELECT PELATIHAN UNTUK REPORT1
	$(".js-slcReportTraining").select2({
		placeholder: "Nama Training",
		minimumInputLength: 3,
		ajax: {		
			url:baseurl+"ADMPelatihan/Report/GetTrainingFilter",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					type: $('select#slcReportTraining').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return { 
							id:obj.Nama_Training, 
							text:obj.Nama_Training
						};
					})
				};
			}
		}
	});

	//SELECT NAMA PELATIHAN YANG SUDAH SELESAI UNTUK CUSTOM REPORT
	$(".js-slcNamaTraining").select2({
		placeholder: "Nama Pelatihan",
		minimumInputLength: 3,
		ajax: {		
			url:baseurl+"ADMPelatihan/Report/GetPelatihanNama",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					type: $('select#nama').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return { id:obj.scheduling_name, text:obj.scheduling_name};
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
					console.log(result);
					$('#loading').html('');
					$("#table-full").html(result);
					recorddatatable();
				}
			});
		});
	});

	//GET REPORT4
	$(document).ready(function() {	
		$('#SearchReportQue').click(function(){
			$('#loading').html('<img src="'+baseurl+'assets/img/gif/loading12.gif" width="34px"/>');
			
			var pelatihan	= $('select[name=slcReportTraining]').val();
			var date 		= $('input[name=txtDate1]').val();
			var trainer		= $('select[name=slcReportTrainer]').val();

			$.ajax({
				type: "POST",
				data:{
						pelatihan:pelatihan,
						date:date,
						trainer:trainer,
				},
				url:baseurl+"ADMPelatihan/C_Report/GetReport4",
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
	// ADD SAAT EDIT
	function AddSegment(base){
		if (base == 'edit') {
			var disable = 'disabled';
			var onkeyup = 'onkeyup="insertKuesAjax(event, this)"';
		}else{
			var disable = '';
			var onkeyup = '';
		}
		var e = jQuery.Event( "click" );
		var n = $('#tbodyQuestionnaireSegment tr').length;
		counter = n+1;

        var newRow = jQuery("<tr class='clone' row-id='"+counter+"'>"
									+"<td >"+ counter +" </td>"
									+"<td>"
										+"<input "+onkeyup+" id='segment' name='txtSegment[]' class='form-control segment' data-toggle='tooltip' data-placement='top' title='Tekan Enter untuk Menyimpan'> "
										+"<input type='hidden' name='idSegment[]' value='0'>"
									+"</td>"
									+"<td>"
										+"<a href='javascript:void(0);' class='btn btn-danger btn-xs' id='DelSegment' title='Hapus Baris' onclick='delSpesifikRow121("+counter+",0)'><i class='fa fa-remove'></i>Delete</a>"
										+"<a "+disable+" data-id='segment-button' href='"+baseurl+"ADMPelatihan/MasterQuestionnaire/Edit' data-toggle='modal'  class='btn btn-xs btn-warning' style='margin:2px'><i class='fa fa-search'></i></i> Statement</a>"
									+"</td>"
									+"</tr>");
			jQuery("#tbodyQuestionnaireSegment").append(newRow);
			
	}
	// ADD SAAT CREATE
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

	//MENAMBAH ROW UNTUK STATEMENT KUESIONER (MASTER QUESTIONNAIRE STATEMENT)
	function AddStatement(id){
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
			var tbID = String('tblStatement');
			var tbodyID = String('tbodyStatementC');
			counter = n+1;
	        var newRow = jQuery("<tr class='clone' row-id='"+counter+"'>"
										+"<td >"+ counter +" </td>"
										+"<td>"
											+"<input id='statement"+numb+"' name='"+inputName+"[]' class='form-control statement'> "
										+"</td>"
										+"<td>"
											+"<a href='javascript:void(0);' class='btn btn-danger btn-xs' id='DelStatment' title='Hapus Baris' onclick='delCreateStatement("+numb+","+counter+","+id+",0)'><i class='fa fa-remove'></i>Delete</a>"
										+"</td>"
										+"</tr>");
				jQuery("#tbodyStatementC"+id).append(newRow);
		}

	//MENGHAPUS ROW UNTUK STATEMENT KUESIONER (MASTER QUESTIONNAIRE STATEMENT)
	function delStatRow(id){
			var rowCount = $("#tbodyStatementC"+id+" tr").size();
			if(rowCount > 1){
				$("#tbodyStatementC"+id+" tr:last").remove();
			}else{
				alert('Minimal harus ada satu baris tersisa');
			}
		}

	//MENAMBAH ROW UNTUK OBJECTIVE (MASTER TRAINING) >> UNTUK TUJUAN
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
							return { id:obj.purpose, text:obj.purpose};
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
							return { id:obj.purpose, text:obj.purpose};
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
			$("select#slcEmployee:last").val("").change();
		}else{
			alert('Jumlah peserta sudah maksimal');
		}
	}

	// TAMBAHKAN PARTISIPAN SAAT EDIT
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

	// DELETE ROW SAAT CREATE SEGMENT
	function delCreateSegment(rowid,segmentid) {
		if (segmentid == '0') {
			$('#tblQuestionnaireSegment #tbodyQuestionnaireSegmentC tr[row-id="'+rowid+'"]').remove();
		}
	}

	// DELETE ROW SAAT CREATE SEGMENT ESSAY
	function delCreateSegmentEssay(rowid,segmentid) {
		if (segmentid == '0') {
			$('#tblQuestionnaireSegmentEssay #tbodyQuestionnaireSegmentEssay tr[row-id="'+rowid+'"]').remove();
		}
	}

	// DELETE ROW SAAT CREATE STATEMENT
	function delCreateStatement(tbID,rowid,id,statementid) {
		if (statementid == '0') {
			$('#tblStatement'+tbID+' #tbodyStatementC'+id+' tr[row-id="'+rowid+'"]').remove();
		}
	}

	// DELETE ROW SAAT CREATE SEGMENT EDIT
	function delSpesifikRow121(rowid,segmentid) {
		// if (segmentid == '0') {
		// 	$('#tblQuestionnaireSegment #tbodyQuestionnaireSegment tr[row-id="'+rowid+'"]').remove();
		// }else{
			$.ajax({
				type:'POST',
				url:baseurl+"ADMPelatihan/MasterQuestionnaire/delSeg/"+segmentid,
				success:function(result)
				{
					$('#tblQuestionnaireSegment #tbodyQuestionnaireSegment tr[row-id="'+rowid+'"]').remove();
				}
			});
		// }
		
	}

	// DELETE ROW SAAT CREATE STATEMENT EDIT
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

	// DELETE ROW PARTISIPAN DI RECORD
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

	// SAVE SEGMEN DENGAN ENTER DI MASTER KUESIONER
	function insertKuesAjax(event, th){
		event.preventDefault();
		if (event.keyCode === 13) {
			var quID = $('input[name="txtQuestionnaireId"]').val();
			var quName = $('input[name="txtQuestionnaireName"]').val();
			var quesId = $(th).attr('data-id');
			var value = $(th).val();
			$.ajax({
				url : baseurl+"ADMPelatihan/MasterQuestionnaire/editSave/"+quID,
				type: 'POST',
				data: {
					accessType : 'ajax',
					txtQuestionnaireName : quName,
					txtSegment : value, 
					txtQuestionnaireId : quID,
					idSegment : quID,
					lineId : quesId,
				},
				success:function(result)
				{
					// console.log(result);
					$(th).closest('tr').find('a[data-id="segment-button"]').removeAttr("disabled"); 
					$(th).closest('tr').find('a[data-id="segment-button"]').attr("href", baseurl+"ADMPelatihan/MasterQuestionnaire/EditStatement/"+quID+'/'+result);
				}
			})
			window.location.href=window.location.href;
		}
	}

	// MODAL SHOW PESERTA DI RECORD BY SECTION
	function showModPar(schid,section){
		$.ajax({
			type: "POST",
			data:{
				section:section
			},
			url:baseurl+"ADMPelatihan/Report/GetTrainingPrtcp/"+schid,
			success:function(result)
			{
				$('div#showModPar').modal('show');
				$('#showModPar table tbody').html(result);
			}
		});
	}
	// MODAL SHOW PESERTA DI REKAP PRESENTASE TRAINING
	function showModParHadir(schid){
		$.ajax({
			type: "POST",
			data:{
				schid:schid
			},
			url:baseurl+"ADMPelatihan/Report/Rekap/GetDetailParticipant/"+schid,
			success:function(result)
			{
				// $('#showModParHadir table tbody').html(result);
				// $('div#showModParHadir').modal('show');
				
				$('div#ModalHadir').html(result);
				$('#showModParHadir').modal('show');
			}
		});
	}

	// WARNING NILAI MINIMAL
		// STAF
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
		// NONSTAF
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

	// UNTUK MODAL SHOW RECORD JENIS PAKET (BELUM TERLAKSANA)
	function recordPackage(id) {
		$.ajax({
			type: "POST",
			url:baseurl+"ADMPelatihan/Record/GetPackageID/"+id,
			success:function(result)
			{
				$('div#modalPaketArea').html(result);
				$('#rincian_paket').modal('show');
			}
		});
	}
	// UNTUK MODAL SHOW RECORD JENIS PAKET (SUDAH TERLAKSANA)
	function recordPackageFinish(id) {
		$.ajax({
			type: "POST",
			url:baseurl+"ADMPelatihan/Record/GetPackageIDfinish/"+id,
			success:function(result)
			{
				$('div#modalPaketAreafinish').html(result);
				$('#rincian_paket_finished').modal('show');
			}
		});
	}
	// MODAL DELETE RECORD JENIS PAKET
	function showModalDel(schid,schname) {
		$('#showModalDel .modal-body b#data-id').html(schname);
		$('#showModalDel .modal-body a').attr('href', baseurl+'ADMPelatihan/Record/Delete/'+schid);
		$('#showModalDel').modal('show');
	}
	// MODAL DELETE MATERI DI MASTER MATERI
	function showDeleteMateri(materiname) {
		$('#showDeleteMateri .modal-body b#data-id').html(materiname);
		$('#showDeleteMateri .modal-body a').attr('href', baseurl+'ADMPelatihan/MasterTrainingMaterial/delete/'+materiname);
		$('#showDeleteMateri').modal('show');
	}
	// ADD SAAT CREATE TRAINER EXPERIENCE
	function AddPengalaman(){
		var e = jQuery.Event( "click" );
		var n = $('#tbodyTrainerPengalaman tr').length;
		counter = n+1;
		var delCoun = '"'+counter+'"';
		var delIdex = '0';
		var delTrainer = '0';

        var newRow = jQuery("<tr class='clone' row-id='"+counter+"'>"
								+"<td >"+counter+" </td>"
								+"<td>"
									+"<input name='txtPengalaman[]' class='form-control segment' placeholder='Pengalaman Trainer' id='txtPengalaman[]'> "
									// +"<input type='hidden' name='txtPengalaman[]' value='0'>"
									+'<input type="text" name="idPengalaman[]" value="0" hidden>'
								+"</td>"
								+"<td>"
									+"<input name='txtTanggalPengalaman[]' class='form-control singledateADM' placeholder='Tanggal' id='txtTanggalPengalaman[]'>"
								+"</td>"
								+"<td>"
									+"<a href='javascript:void(0);' class='btn btn-danger btn-xs' id='DelPengalaman' title='Hapus Baris' onclick='delPengalaman("+delCoun+","+delTrainer+","+delIdex+")'><i class='fa fa-remove'></i>Delete</a>"
								+"</td>"
							+"</tr>");
		jQuery("#tbodyTrainerPengalaman").append(newRow);
		$('.singledateADM').datepicker({
    		format:'dd/mm/yyyy',
    		autoclose: true
		});	
	}
	// DELETE ROW SAAT TRAINER EXPERIENCE
	function delPengalaman(rowid,trainer_id,idex) {
		if (idex == '0') {
			$('#tblPengalaman #tbodyTrainerPengalaman tr[row-id="'+rowid+'"]').remove();
		}else{
			$.ajax({
				type:'POST',
				url:baseurl+"ADMPelatihan/MasterTrainer/delete_exp/"+trainer_id+'/'+idex,
				success:function(result)
				{
					$('#tblPengalaman #tbodyTrainerPengalaman tr[row-id="'+rowid+'"]').remove();
				}
			});
		}
	}

	// ADD SAAT CREATE SERTIFIKAT TRAINER 
	function AddSertifikat(){
		var e = jQuery.Event( "click" );
		var n = $('#tbodyTrainerSertifikat tr').length;
		counter = n+1;
		var delCoun = '"'+counter+'"';
		var delSert = '0';
		var delTrainer = '0';

        var newRow = jQuery("<tr class='clone' row-id='"+counter+"'>"
								+"<td >"+counter+"</td>"
								+"<td>"
									+"<input name='txtSertifikat[]' class='form-control segment' data-placement='top' placeholder='Nama Training' id='txtSertifikat[]'>"
									// +"<input type='hidden' name='txtSertifikat[]' value='0'>"
									+'<input type="text" name="idsertifikat[]" value="0" hidden>'
								+"</td>"
								+"<td>"
									+"<input name='txtTanggalSertifikat[]' class='form-control singledateADM' placeholder='Tanggal' id='txtTanggalSertifikat[]'>"
								+"</td>"
								+"<td>"
									+"<a href='javascript:void(0);'class='btn btn-danger btn-xs' id='DelSertifikat' title='Hapus Baris' onclick='delSertifikat("+delCoun+","+delTrainer+","+delSert+")'><i class='fa fa-remove'></i>Delete</a>"
								+"</td>"
							+"</tr>");
		jQuery("#tbodyTrainerSertifikat").append(newRow);	
        $('.singledateADM').datepicker({
	    	format:'dd/mm/yyyy',
	    	autoclose: true
		});
	}
	// DELETE ROW SAAT SERTIFIKAT TRAINER
	function delSertifikat(rowid,trainer_id,idser) {
		if (idser == '0') {
			$('#tblSertifikat #tbodyTrainerSertifikat tr[row-id="'+rowid+'"]').remove();
		}else{
			$.ajax({
				type:'POST',
				url:baseurl+"ADMPelatihan/MasterTrainer/delete_sertifikat/"+trainer_id+'/'+idser,
				success:function(result)
				{
					$('#tblSertifikat #tbodyTrainerSertifikat tr[row-id="'+rowid+'"]').remove();
				}
			});
		}
	}
	// ADD SAAT CREATE TIM TRAINER 
	function AddTim(){
		var e = jQuery.Event( "click" );
		var n = $('#tbodyTrainerTim tr').length;
		counter = n+1;
		var delCoun = '"'+counter+'"';
		var delTeam = '0';
		var delTrainer = '0';

        var newRow = jQuery("<tr class='clone' row-id='"+counter+"'>"
								+"<td >"+counter+"</td>"
								+"<td>"
									+"<input id='segment' name='txtKegiatan[]' class='form-control segment' data-placement='top' placeholder='Nama Training' id='txtKegiatan[]'>"
									// +"<input type='hidden' name='txtKegiatan[]' value='0'>"
									+'<input type="text" name="idteam[]" value="0" hidden>'
								+"</td>"
								+"<td>"
									+"<input name='txtTanggalkegiatan[]' class='form-control singledateADM' placeholder='Tanggal' id='txtTanggalkegiatan[]'>"
								+"</td>"
								+"<td>"
									+"<input name='txtJabatan[]' class='form-control segment'  data-placement='top' placeholder='Jabatan' id='txtJabatan[]'>"
								+"</td>"
								+"<td>"
									+"<a href='javascript:void(0);'class='btn btn-danger btn-xs' id='DelTrainerTim' title='Hapus Baris' onclick='DelTrainerTim("+delCoun+","+delTrainer+","+delTeam+")'><i class='fa fa-remove'></i>Delete</a>"
								+"</td>"
							+"</tr>");
		jQuery("#tbodyTrainerTim").append(newRow);	
        $('.singledateADM').datepicker({
	    	format:'dd/mm/yyyy',
	    	autoclose: true
		});
	}
	// DELETE ROW SAAT TIM TRAINER
	function DelTrainerTim(rowid,trainer_id,idteam) {
		if (idteam == '0') {
			$('#tblTim #tbodyTrainerTim tr[row-id="'+rowid+'"]').remove();
		}else{
			$.ajax({
				type:'POST',
				url:baseurl+"ADMPelatihan/MasterTrainer/delete_team/"+trainer_id+'/'+idteam,
				success:function(result)
				{
					$('#tblTim #tbodyTrainerTim tr[row-id="'+rowid+'"]').remove();
				}
			});
		}
	}

	//ADD ROW UNTUK CREATE REPORT EVAL REAKSI
	function AddEvalReaksi(){
		var e = jQuery.Event( "click" );
		var n = $('#tbodyEvalReaksi tr').length;
		counter = n+1;
		var delCoun = '"'+counter+'"';
		var delEval = '0';
		var del = '0';

        var newRow = jQuery("<tr class='clone' row-id='"+counter+"'>"
								+"<td >"+counter+"</td>"
								+"<td>"
									+"<input id='txtKomEval[]' name='txtKomEval[]' class='form-control segment' data-placement='top' placeholder='Komponen Evaluasi' id='txtKomEval[]'>"
									// +"<input type='hidden' name='txtKegiatan[]' value='0'>"
									+'<input type="text" name="idEvalReaksi[]" id="idEvalReaksi[]" value="0" hidden>'
								+"</td>"
								+"<td>"
									+"<input name='txtKomRata[]' class='form-control' placeholder='Rata-rata' id='txtKomRata[]'>"
								+"</td>"
								+"<td>"
									+"<a href='javascript:void(0);'class='btn btn-danger btn-xs' id='DelEvalReaksi' title='Hapus Baris' onclick='DelEvalReaksi("+delCoun+","+del+","+delEval+")'><i class='fa fa-remove'></i>Delete</a>"
								+"</td>"
							+"</tr>");
        jQuery("#tbodyEvalReaksi").append(newRow);	
	}

	// DELETE ROW UNTUK CREATE REPORT EVAL REAKSI
	function DelEvalReaksi(rowid,report_id,ideval) {
		if (ideval == '0') {
			$('#tblEvalReaksi #tbodyEvalReaksi tr[row-id="'+rowid+'"]').remove();
		}else{
			$.ajax({
				type:'POST',
				url:baseurl+"ADMPelatihan/Report/delete_reaksi/"+report_id+'/'+ideval,
				success:function(result)
				{
					$('#tblEvalReaksi #tbodyEvalReaksi tr[row-id="'+rowid+'"]').remove();
				}
			});
		}
	}

	//ADD ROW UNTUK CREATE REPORT EVAL PEMBELAJARAN
	function AddEvalPembelajaran(){
		var e = jQuery.Event( "click" );
		var n = $('#tbodyEvalPembelajaran tr').length;
		counter = n+1;
		var delCoun = '"'+counter+'"';
		var delEval = '0';
		var del = '0';

        var newRow = jQuery("<tr class='clone' row-id='"+counter+"'>"
								+"<td >"+counter+"</td>"
								+"<td>"
									+"<input id='txtnamaPsrt[]' name='txtnamaPsrt[]' class='form-control segment' data-placement='top' placeholder='Nama' id='txtnamaPsrt[]'>"
									// +"<input type='hidden' name='txtKegiatan[]' value='0'>"
									+'<input type="text" name="idEvalPemb[]" id="idEvalPemb[]" value="0" hidden>'
								+"</td>"
								+"<td>"
									+"<input name='txtnoindPsrt[]' class='form-control' placeholder='Nomor Induk' id='txtnoindPsrt[]'>"
								+"</td>"
								+"<td>"
									+"<input name='txtpreTest[]' class='form-control' placeholder='nilai Pre-test' id='txtpreTest[]' type='number'>"
								+"</td>"
								+"<td>"
									+"<input name='txtpostTest[]' class='form-control' placeholder='nilai Post-test' id='txtpostTest[]' type='number'>"
								+"</td>"
								+"<td>"
									+"<a href='javascript:void(0);'class='btn btn-danger btn-xs' id='DelEvalPem' title='Hapus Baris' onclick='DelEvalPem("+delCoun+","+del+","+delEval+")'><i class='fa fa-remove'></i>Delete</a>"
								+"</td>"
							+"</tr>");
        jQuery("#tbodyEvalPembelajaran").append(newRow);	
	}

	// DELETE ROW UNTUK CREATE REPORT EVAL REAKSI
	function DelEvalPem(rowid,report_id,ideval) {
		if (ideval == '0') {
			$('#tblEvalPembelajaran #tbodyEvalPembelajaran tr[row-id="'+rowid+'"]').remove();
		}else{
			$.ajax({
				type:'POST',
				url:baseurl+"ADMPelatihan/Report/delete_pembelajaran/"+report_id+'/'+ideval,
				success:function(result)
				{
					$('#tblEvalPembelajaran #tbodyEvalPembelajaran tr[row-id="'+rowid+'"]').remove();
				}
			});
		}
	}

	//ONCHANGE BUAT CREATE REPORT
	function funKatPelatihan() {
		var x = document.getElementById('KatPelatihan').value;
		if (x) {
			$('select#nama').removeAttr('disabled');
			$('input#tanggal').removeAttr('disabled');

			if (x == 0) {
				$('#idNama').val('0');
				$('#idTanggal').val('0');
				
				$("select#nama").select2({
					placeholder: "Judul Pelatihan",
					minimumInputLength: 3,
					tags: true,
					ajax: {
						url:baseurl+"ADMPelatihan/Report/GetPelatihanNama",
						dataType: 'json',
						type: "GET",
						data: function (params) {
							var queryParameters = {
								term: params.term,
								type: $('select#nama').val()
							}
							return queryParameters;
						},
						processResults: function (data) {
							return {
								results: $.map(data, function(obj) {
									return { id:obj.scheduling_name, text:obj.scheduling_name};
								})
							};
						}
					}	
				}); 
			}
			else{
				$('#idNama').val('1');
				$('#idTanggal').val('1');
				
				$("select#nama").select2({
					placeholder: "Judul Pelatihan",
					minimumInputLength: 3,
					tags: true,
					ajax: {
						url:baseurl+"ADMPelatihan/Report/GetPelatihanPaketNama",
						dataType: 'json',
						type: "GET",
						data: function (params) {
							var queryParameters = {
								term: params.term,
								type: $('select#nama').val()
							}
							return queryParameters;
						},
						processResults: function (data) {
							return {
								results: $.map(data, function(obj) {
									return { id:obj.package_scheduling_name, text:obj.package_scheduling_name};
								})
							};
						}
					}	
				}); 
			}
		}
	}
	function funGetPelatihan() 
	{
		var nama =  document.getElementById('nama').value;
		var tanggal = document.getElementById('tanggal').value;
		var idNama = document.getElementById('idNama').value;
		var idTanggal = document.getElementById('idTanggal').value;

		if (nama && tanggal) {
			$.ajax({
				type:'POST',
				data: 	{
							nama:nama,
							tanggal:tanggal,
							idNama:idNama,
							idTanggal:idTanggal
						},
				url:baseurl+"ADMPelatihan/Report/GetDataPelatihan",
				success:function(result) 
				{
					var result = JSON.parse(result);
					console.log(result);

					// PESERTA PELATIHAN-------------------------------------------------------------------
					$('input#txtPesertaPelatihan').val(result['participant_number']);
					if (idNama == 1) {
						$('input#txtPesertaHadir').val(result['participant_number']);	
					}else{
						$('input#txtPesertaHadir').val(result['participant'][0]['jumlah']);	
					}
					
					//NAMA TRAINER-------------------------------------------------------------------------
					var nama=[];
					var idt=[];
					console.log(result['trainer']);
					if (idNama == 1) {
						for (var i = 0; i < result['trainer'].length; i++) {
							for (var j = 0; j < result['trainer_onpkg'].length; j++) {
								// JIKA SEMUA PELATIHAN TRAINERNYA BEDA
								if (result['trainer'][i]['trainer_id'] == result['trainer_onpkg'][j] && result['trainer'].length == result['trainer_onpkg'].length) {
									// console.log('beda');
									nama.push(result['trainer_fix'][i]);
									idt.push(result['trainer_onpkg'][i]);
								}
								// JIKA SEMUA PELATIHAN TRAINERNYA SAMA
								else{
									// console.log('sama');
									var array_with_duplicates_id = result['trainer_onpkg'];
									var array_with_duplicates_name = result['trainer_fix'];

									// HAPUS ID YANG DUPLICATE
									var unique_array_id = [];
									function removeDuplicates_id(arr_id) {
										for (var k = 0; k < arr_id.length; k++) {
											if (unique_array_id.indexOf(arr_id[k]) == -1) {
												unique_array_id.push(arr_id[k]);
											}
										}return unique_array_id;
									}
									// HAPUS NAMA YANG DUPLICATE
									var unique_array_name = [];
									function removeDuplicates_name(arr_name) {
										for (var l = 0; l < arr_name.length; l++) {
											if (unique_array_name.indexOf(arr_name[l]) == -1) {
												unique_array_name.push(arr_name[l]);
											}
										}return unique_array_name;
									}

									if (result['trainer'][i]['trainer_id'] == removeDuplicates_id(array_with_duplicates_id)) {
										// console.log('masuk array duplicate');
										nama = removeDuplicates_name(array_with_duplicates_name);
										idt = unique_array_id;
									}
									// ADA YANG DUPLICATE ADA YANG BEDA
									else{
										if (removeDuplicates_id(array_with_duplicates_id).includes(result['trainer'][i]['trainer_id'])) {
											// console.log('masuk array duplicate tapi ada yang tidak duplicate juga');
											nama = removeDuplicates_name(array_with_duplicates_name);
											idt = unique_array_id;
										}
									}
								}
							}
						}
					// console.log(unique_array_id);
					// console.log(unique_array_name);
					console.log(nama);					
					console.log(idt);					
					}else{
						for (var i = 0; i < result['trainer'].length; i++) {
							for (var j = 0; j < result['idTrainer'].length; j++) {
								if (result['trainer'][i]['trainer_id'] == result['idTrainer'][j]) {
									nama.push(result['trainer'][i]['trainer_name']);
									idt.push(result['trainer'][i]['trainer_id']);
								}
							}
						}
					}
					var namagabung = nama.join(' , ');
					var idtgabung  = idt.join(' , ');
					$('input#txtPelaksana').val(namagabung);
					$('input#idtrainerOnly').val(idt);
					
					// -----------------------------------------------------------------------------------
				}
			});
			$.ajax({
				type:'POST',
				data: 	{
							nama:nama,
							tanggal:tanggal,
							idNama:idNama,
							idTanggal:idTanggal
						},
				url:baseurl+"ADMPelatihan/Report/GetTabelReaksi",
				success:function(result) 
				{
					$('#tbevalReaksi').html(result);
				}
			});
			$.ajax({
				type:'POST',
				data: 	{
							nama:nama,
							tanggal:tanggal,
							idNama:idNama,
							idTanggal:idTanggal
						},
				url:baseurl+"ADMPelatihan/Report/GetTabelPembelajaran",
				success:function(result) 
				{
					$('#tbevalPembelajaran').html(result);
				}
			});
		}else{
			$('#txtPesertaPelatihan').val('');
			$('#txtPesertaHadir').val('');
			$('#txtPelaksana').val('');
			$('#txtPelaksana').val('');
		}
	}

	//ADM Cabang
$(function(){
	$('#txtPeriodePresensiHarian').daterangepicker({
		"todayHighlight" : true,
		"autoclose": true,
		locale: {
					format: 'DD MMMM YYYY'
				},
	});
	$('#txtPeriodePresensiHarian').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('DD MMMM YYYY') + ' - ' + picker.endDate.format('DD MMMM YYYY'));
	});

	$('#txtPeriodePresensiHarian').on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
	});
});

$(function(){
	$('#txtTanggalPelatihanUndangan').datepicker({
    	format:'yyyy-mm-dd',
    	autoclose: true
	});

	$('.txtNamaPelatihanUndangan').select2({
		dropdownParent: $('#import-Pelatihan-Create'),
	})
});

$(document).on('ready',function(){
	$('#txtTanggalPelatihanUndangan').on('change',function(){
		var tanggalUndangan = $('#txtTanggalPelatihanUndangan').val();
		
		$.ajax({
			data 	: {tanggal:tanggalUndangan},
			type 	: 'POST',
			url 	: baseurl+'ADMPelatihan/Cetak/Undangan/CariUndangan',
			success : function(data){
				obj = JSON.parse(data);
				var opsi = "";
				for (var i = 0; i <= (obj.length - 1); i++) {
					opsi += '<option value="'+obj[i]['scheduling_id']+'">'+obj[i]['scheduling_name']+' - trainer '+obj[i]['trainer_name']+'</option>';
				}
				$('#txtNamaPelatihanUndangan').html(opsi);
				$('.txtNamaPelatihanUndangan').select2({
					dropdownParent: $('#import-Pelatihan-Create'),
				})
			}
		});
	});
	$(document).on('click','#btnCancelPelatihanUndangan',function(e){
	  	$('#import-Pelatihan-Create').modal("hide");
	});
	$('#btnSubmitImportPelatihan').on('click',function(){
		var sched_id = $('#txtNamaPelatihanUndangan').val();
		var tanggalUndangan = $('#txtTanggalPelatihanUndangan').val();

		if (sched_id) {
			$.ajax({
				data 	: {schedule_id : sched_id},
				type 	: 'POST',
				url		: baseurl+'ADMPelatihan/Cetak/Undangan/CariUndanganLengkap',
				success : function(data){
					obj = JSON.parse(data);
					$('#txtTanggalUndanganPelatihan').datepicker('update',obj[0]['tgl']);
					$('#txtWaktuUndanganPelatihan').val(obj[0]['wkt']);
					$('#txtTempatUndanganPelatihan').val(obj[0]['tempat']);
					$('#txtAcaraUndanganPelatihan').val(obj[0]['scheduling_name']);
					
				}
			});

			$.ajax({
				data 	: {schedule_id : sched_id},
				type 	: 'POST',
				url 	: baseurl+'ADMPelatihan/Cetak/Undangan/CariUndanganPeserta',
				success : function(data){
					obj = JSON.parse(data);
					var opsi = "";
					for (var i = 0; i <= obj.length - 1; i++) {
						opsi += '<option value="'+obj[i]['noind']+'" selected>'+obj[i]['participant_name']+'</option>';
					}
					$('#txtPesertaUndanganPelatihan').html(opsi);
					$('#txtPesertaUndanganPelatihan').select2();
				}
			})

			$('#import-Pelatihan-Create').modal("hide");
		}else{
			alert('Gagal Mencari Pelatihan, Pastikan Nama Pelatihan Terisi !!');
		}

			
	});
});