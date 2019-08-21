//master Presensi Pekerja Keluar

$(function(){
	$('#txtPeriodeGajiPKJKeluar').daterangepicker({
  		"autoclose": true,
 		"todayHiglight": true,
 		locale: {
     			cancelLabel: 'Clear',
     			"format": "YYYY-MM-DD",
				"separator": " - ",
     		}
    });

	$('#txtPeriodePuasaPKJKeluar').daterangepicker({
  		"autoclose": true,
 		"todayHiglight": true,
 		locale: {
     			cancelLabel: 'Clear',
     			"format": "YYYY-MM-DD",
				"separator": " - ",
     		}
    });

	$('#txtTglCetakPKJKeluar').datepicker({
  		"autoclose": true,
		"todayHiglight": true,
		"format": 'yyyy-mm-dd'
    });

	
});

$(document).ready(function(){
	var tblexist = $('#table-gaji-pekerja-keluar').html();
	if(tblexist){
		var table = $('#table-gaji-pekerja-keluar').DataTable({
			// fixedHeader		: true,
			scrollY			: '400px',
			scrollX			: true,
			scrollCollapse	: true,
			columnDefs: [
	            { width: 200, targets: 0 }
	        ],
		});

		new $.fn.dataTable.FixedColumns( table, {
			leftColumns: 4
		} );
	}
});

$(document).ready(function(){
	$('#txtPuasaPKJKeluar').on('ifChecked',function(){
		$('#txtPeriodePuasaPKJKeluar').prop("disabled", false);
	});
	$('#txtPuasaPKJKeluar').on('ifUnchecked',function(){
		$('#txtPeriodePuasaPKJKeluar').prop("disabled", true);
	});

	$('.slcPekerjaGajiPKJKeluar').select2({
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		disabled : true,
		ajax:
		{
			url: baseurl+'MasterPresensi/ReffGaji/PekerjaKeluar/getPekerja',
			dataType: 'json',
			delay: 500,
			type: 'GET',
			data: function(params){
				return {
					term: params.term,
					kode: status
				}
			},
			processResults: function (data){
				return {
					results: $.map(data, function(obj){
						return {id: obj.nomor, text: obj.noind + " - " + obj.nama};
					})
				}
			}
		}
	});
});

$(document).on('change', '#slcStatusPekerja', function(){
	var status = $(this).val();
	if (status == "") {
		$('.slcPekerjaGajiPKJKeluar').prop("disabled", true);
		$(".slcPekerjaGajiPKJKeluar").val(null).trigger("change"); 
	}else{
		$('.slcPekerjaGajiPKJKeluar').prop("disabled", false);
		$('.slcPekerjaGajiPKJKeluar').select2({
			searching: true,
			minimumInputLength: 3,
			allowClear: false,
			ajax:
			{
				url: baseurl+'MasterPresensi/ReffGaji/PekerjaKeluar/getPekerja',
				dataType: 'json',
				delay: 500,
				type: 'GET',
				data: function(params){
					return {
						term: params.term,
						kode: status
					}
				},
				processResults: function (data){
					return {
						results: $.map(data, function(obj){
							return {id: obj.nomor, text: obj.noind + " - " + obj.nama};
						})
					}
				}
			}
		});
	}
});

$(document).on('ready', function(){
	$('.dataTable-pekerjaKeluar-detail').dataTable({
		scrollY:        "300px",
		paging: false
	});
});