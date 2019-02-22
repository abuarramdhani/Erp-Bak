$(document).ready(function(){
	$('.datatable-ma').DataTable({
		retrieve : true,
		dom: 'Bfrtip',
	    buttons: [
	        'excel',
	        'pdf'
	    ]
	});
});

// target start
//create start
$(document).on('click','#btnCancelTargetAdmin',function(e){
  $('#target-Create').modal("hide");
});

$(document).on('click','#btnSubmitTargetAdmin',function(e){
  var target = $('input[name="txtTargetWaktuTarget"]').val();
  var pekerjaan = $('input[name="txtNamaPekerjaanTarget"]').val();
  var urut = $('input[name="txtKode"]').val();
 
  if (target == '' || pekerjaan == '' || urut == '') {
    alert("data masih kosong !!");
  }else{
    $.ajax({
        type : 'POST',
        url  : baseurl+"ManagementAdmin/Target/Create",
        data : {target : target, pekerjaan : pekerjaan,urut : urut},
        success : function(e){
          window.location = baseurl+"ManagementAdmin/Target";
        }
    });
  }
});
//create end

//update start
$(document).on('click','#btnUpdateDataTargetPekerjaan',function(e){
	var target = $(this).attr('data-targetwaktu');
	var pekerjaan = $(this).attr('data-pekerjaan');
	var id = $(this).attr('data-idtarget');
	var no = $(this).attr('data-nouruttarget');

	$('#txtUpdateTargetWaktu').val(target);
	$('#txtUpdatePekerjaan').val(pekerjaan);
	$('#txtUpdateId').val(id);
	$('#txtUpdateUrut').val(no);

  $('#target-update').modal("show");
});
$(document).on('click','#btnCancelUpdateTargetAdmin',function(e){
  $('#target-update').modal("hide");
});

$(document).on('click','#btnSubmitUpdateTargetAdmin',function(e){
  var target = $('#txtUpdateTargetWaktu').val();
  var pekerjaan = $('#txtUpdatePekerjaan').val();
  var id = $('#txtUpdateId').val();
  if (target == '' || pekerjaan == '') {
    alert("data masih kosong !!");
  }else{
    $.ajax({
        type : 'POST',
        url  : baseurl+"ManagementAdmin/Target/Update",
        data : {target : target, pekerjaan : pekerjaan,id : id},
        success : function(e){
          window.location = baseurl+"ManagementAdmin/Target";
        }
    });
  }
});

// update end
// target end

//pekerja start
//create start
$(document).ready(function(){
	$('.selectPekerjaMasterMA').select2({
		dropdownParent: $('#pekerja-Create'),
		placeholder: "Noind",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'ManagementAdmin/Pekerja/CariPekerja',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params){
				return {
					term: params.term
				}
			},
			processResults: function (data){
				return {
					results: $.map(data, function(obj){
						return {id: obj.employee_id, text: obj.employee_code};
					})
				}
			}
		}
	});
});

$('.selectPekerjaMasterMA').on('change',function(){
	var noind = $('.selectPekerjaMasterMA').find(':selected').text();
	var employee_id = $('.selectPekerjaMasterMA').find(':selected').val();
	$.ajax({
		type: 'POST',
		data: {id : employee_id},
		url: baseurl+'ManagementAdmin/Pekerja/CariNamaPekerja',
		success: function(data){
			$('input[name="txtNamaPekerja"]').val(data);
		}
	});
});

$(document).on('click','#btnCancelPekerja',function(e){
  $('#pekerja-Create').modal("hide");
});

$(document).on('click','#btnSubmitPekerja',function(e){
  	var noind = $('.selectPekerjaMasterMA').find(':selected').text();
	var employee_id = $('.selectPekerjaMasterMA').find(':selected').val();
	var nama = $('input[name="txtNamaPekerja"]').val();
	$.ajax({
		type: 'POST',
		data: {id : employee_id,noind : noind,nama : nama},
		url: baseurl+'ManagementAdmin/Pekerja/AddPekerja',
		success: function(data){
			 window.location = baseurl+"ManagementAdmin/Pekerja";
		}
	});
});
//create end
//pekerja end

//proses start
//awal start
$(document).ready(function(){
	$('.selectPekerjaProses').select2({
		placeholder: "Pekerja",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'ManagementAdmin/Proses/CariPekerja',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params){
				return {
					term: params.term
				}
			},
			processResults: function (data){
				return {
					results: $.map(data, function(obj){
						return {id: obj.id_pekerja, text: obj.noind+" - "+obj.nama_pekerja};
					})
				}
			}
		}
	});

	$('.selectPekerjaanProses').select2({
		placeholder: "Pekerjaan",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'ManagementAdmin/Proses/CariPekerjaan',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params){
				return {
					term: params.term
				}
			},
			processResults: function (data){
				return {
					results: $.map(data, function(obj){
						return {id: obj.target_waktu, text: obj.pekerjaan};
					})
				}
			}
		}
	});

	$('input[name="txtJumlahDocument"]').on('keyup',function(){
		var target = $('select[name="selectPekerjaanProses"]').find(':selected').val();
		var jumlah = $('input[name="txtJumlahDocument"]').val();
		if (target !== '' && jumlah !== '') {
			var total = parseInt(target)*parseInt(jumlah);
			$('input[name="txtTargetTotal"]').val(total);
		}
	});

	$('select[name="selectPekerjaanProses"]').on('change',function(){
		var target = $('select[name="selectPekerjaanProses"]').find(':selected').val();
		var pekerjaan = $('select[name="selectPekerjaanProses"]').find(':selected').text();
		var jumlah = $('input[name="txtJumlahDocument"]').val();
		if (target !== '' && jumlah !== '') {
			var total = parseInt(target)*parseInt(jumlah);
			$('input[name="txtTargetTotal"]').val(total);
		}

		$('input[name="selectPekerjaanProses"]').val(pekerjaan);
	});
});
//awal end
//proses end

//Monitoring start
//pending start
$(document).on('click','#btnCancelPendingAdmin',function(e){
  $('#pending-Create').modal("hide");
});

function ModalTampilPending(btn){
	var id = $(btn).closest('tr').find('button').attr('data-id');
	$('input[name="txtId"]').val(id);
	$('#pending-Create').modal("show");
}
//pending end
//monitoring start
$(document).ready(function(){
	$('.selectPekerjaanMonitoring').select2({
		placeholder: "Pekerjaan",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'ManagementAdmin/Proses/CariPekerjaan',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params){
				return {
					term: params.term
				}
			},
			processResults: function (data){
				return {
					results: $.map(data, function(obj){
						return {id: obj.id_target, text: obj.pekerjaan};
					})
				}
			}
		}
	});
});
//monioring end
//Monitoring end
//Manual start
//cetak start
$(document).ready(function(){
	$('#txtPeriodeCetak').daterangepicker({
		"autoclose": true,
		"todayHiglight": true,
		locale:{
			"format": 'YYYY-MM-DD'
		}
		
	});
});
//cetak end
//input start
$(document).ready(function(){
	$('.tanggalPelaksanaan').datepicker({
		"autoclose": true,
      	"todayHiglight": true,
      	"autoApply": true,
      	"format":'yyyy-mm-dd',

	});
	$('.waktuPelaksanaan').timepicker({
  		maxHours:24,
  		showMeridian:false,
  		showSeconds: true
  	});
});
//input end
//manual end