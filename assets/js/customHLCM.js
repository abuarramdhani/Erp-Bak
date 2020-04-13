$(document).ready(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional 
    }); 
 
    $('#select_pekerjacbg').change(function(){
    var val = $('#select_pekerjacbg option:selected').val();
    if(val) {
    	// alert (val);
      $.ajax({
        type:'POST',
        data:{loker:val},
        url:baseurl+"HitungHlcm/DataGaji/getDataGaji",
        success:function(result)
        {
         var result = JSON.parse(result);

          $('#kepalatukang').val(result['kepalatukang']);
          $('#tukang').val(result['tukang']);
          $('#serabutan').val(result['serabutan']);
          $('#tenaga').val(result['tenaga']);
          $('#uangmakan').val(result['uangmakan']);
          $('#uangmakanpuasa').val(result['uangmakanpuasa']);
        }

      		});
    	} else {
     
    	}
	});

	$('#select_datapekerjacbg').change(function(){
    var val = $('#select_datapekerjacbg option:selected').val();
    if(val) {
    	// alert (val);
      $.ajax({
        type:'POST',
        data:{loker:val},
        url:baseurl+"HitungHlcm/DataPekerja/getDataPekerja",
        success:function(result)
        {
         $('#tbody_datapekerja').html(result);
        }

      		});
    	} else {
     
    	}
	});
    
   $("#button_edit").click(function(event){
   		var data = $('#button_edit').attr('data');
   		event.preventDefault();
   		if (data == '1') {
   			// alert (data);
		   $('#kepalatukang').prop("readonly", false);
		   $('#tukang').prop("readonly", false);
		   $('#serabutan').prop("readonly", false);
		   $('#tenaga').prop("readonly", false);
		   $('#uangmakan').prop("readonly", false);
		   $('#uangmakanpuasa').prop("readonly", false);
		   $("#button_edit").attr("data","0");

   		} else if(data == '0'){
   			// alert (data);
		   $('#kepalatukang').prop("readonly", true);
		   $('#tukang').prop("readonly", true);
		   $('#serabutan').prop("readonly", true);
		   $('#tenaga').prop("readonly", true);
		   $('#uangmakan').prop("readonly", true);
		   $('#uangmakanpuasa').prop("readonly", true);
		   $("#button_edit").attr('data','1');
   		}
	});

   $('#slc_noinddatapekerja').select2({
    	minimumInputLength: 3,
		allowClear: true,
		placeholder: 'Pilih Pekerja',
		ajax: {
			url: baseurl+"HitungHlcm/DataPekerja/ambilpekerja",
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {term: params.term,
				lokasi_kerja: $("#select_pekerjacbg").val(),
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.noind,
							text: item.noind+' - '+item.nama
						};				
					})
					
				};
			},
		},
	});

   $('#noinduk_pekerja').select2({
    	minimumInputLength: 3,
		allowClear: true,
		placeholder: 'Pilih Pekerja',
		ajax: {
			url: baseurl+"HitungHlcm/Approval/ambilpekerja",
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {term: params.term,
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.noind,
							text: item.noind
						};				
					})
					
				};
			},
		},
	});

   $('#slc_bank').select2({
    	minimumInputLength: 2,
		allowClear: true,
		placeholder: 'Pilih Bank',
		ajax: {
			url: baseurl+"HitungHlcm/DataPekerja/ambilBank",
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {term: params.term};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.code_bank,
							text: item.code_bank+' - '+item.nama_bank
						};				
					})
					
				};
			},
		},
	});

   $('#noindPekerja').select2({
    	minimumInputLength: 3,
		allowClear: true,
		placeholder: 'Pilih Pekerja',
		ajax: {
			url: baseurl+"HitungHlcm/SlipGaji/ambilPekerja",
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {term: params.term};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.noind,
							text: item.noind+' - '+item.nama
						};				
					})
					
				};
			},
		},
	});

   $('#slc-hlcm-tampot-noind').select2({
   		minimumInputLength: 3,
		allowClear: true,
		placeholder: 'Pilih Pekerja',
		ajax: {
			url: baseurl+"HitungHlcm/TambahanPotongan/noind_pekerja",
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {term: params.term};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.noind,
							text: item.noind+' - '+item.nama
						};				
					})
					
				};
			},
		},
   });

   $('#slc_noinddatapekerja').change(function(){
    var val = $('#slc_noinddatapekerja').val();
    if(val) {
    	// alert (val);
      $.ajax({
        type:'POST',
        data:{noind:val},
        url:baseurl+"HitungHlcm/DataPekerja/namaChange",
        success:function(result)
        {
         var result = JSON.parse(result);

          $('#namapekerja').val(result['nama']);
          $('#pekerjaanpekerja').val(result['pekerjaan']);
        }

      		});
    	} else {
     
    	}
	});

   $('#noinduk_pekerja').change(function(){
    var val = $('#noinduk_pekerja').val();
    if(val) {
    	// alert (val);
      $.ajax({
        type:'POST',
        data:{noind:val},
        url:baseurl+"HitungHlcm/Approval/namaChange",
        success:function(result)
        {
         var result = JSON.parse(result);

          $('#namapekerja').val(result['nama']);
          $('#jabatanpekerja').val(result['jabatan']);
        }

      		});
    	} else {
     
    	}
	});

   $('#HLCMOvertime-datatable').dataTable();

   $('#hlcm-tbl-potongantambahan-history').dataTable();

   $('#table_prosesgaji').dataTable({
          "paging": true,
          "lengthChange": true,
          "iDisplayLength" : -1,
          "searching": true,
          "ordering": true,
		  "info": true,
          "autoWidth": false,
          "scrollX": true,
		  "deferRender" : true
   });

   $('#hlcm-tbl-detailpresensi').dataTable({
   		"scrollX": true,
   		fixedColumns:   {
            leftColumns: 2
        }
   });

   $('#hlcm-tbl-potongantambahan').dataTable({
   		"scrollX": true,
   		fixedColumns:   {
            leftColumns: 6
        }
   });

   $('#hlcm-tbl-detailpresensi-waktu').dataTable();

   $('#hlcm-tbl-arsippresensi').dataTable();

	$('.prosesgaji-daterangepicker').daterangepicker({
		"showDropdowns": true,
		"autoApply": false,
		"locale": {
		    "format": "YYYY-MM-DD",
		    "separator": " - ",
		    "applyLabel": "OK",
		    "cancelLabel": "Batal",
		    "fromLabel": "Dari",
		    "toLabel": "Hingga",
		    "customRangeLabel": "Custom",
		    "weekLabel": "W",
		    "daysOfWeek": [
		        "Mg",
		        "Sn",
		        "Sl",
		        "Rb",
		        "Km",
		        "Jm",
		        "Sa"
		    ],
		    "monthNames": [
		        "Januari",
		        "Februari",
		        "Maret",
		        "April",
		        "Mei",
		        "Juni",
		        "Juli",
		        "Agustus ",
		        "September",
		        "Oktober",
		        "November",
		        "Desember"
		    ],
		    "firstDay": 1
		}
	}, function(start, end, label) {
	  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
	});

	$('.overtimephl-daterangepicker').daterangepicker({
		"showDropdowns": true,
		"autoApply": false,
		"locale": {
		    "format": "YYYY-MM-DD",
		    "separator": " - ",
		    "applyLabel": "OK",
		    "cancelLabel": "Batal",
		    "fromLabel": "Dari",
		    "toLabel": "Hingga",
		    "customRangeLabel": "Custom",
		    "weekLabel": "W",
		    "daysOfWeek": [
		        "Mg",
		        "Sn",
		        "Sl",
		        "Rb",
		        "Km",
		        "Jm",
		        "Sa"
		    ],
		    "monthNames": [
		        "Januari",
		        "Februari",
		        "Maret",
		        "April",
		        "Mei",
		        "Juni",
		        "Juli",
		        "Agustus ",
		        "September",
		        "Oktober",
		        "November",
		        "Desember"
		    ],
		    "firstDay": 1
		}
	}, function(start, end, label) {
	  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
	});

	$('.prosesgaji-daterangepickersingledate').daterangepicker({
		"singleDatePicker": true,
		"showDropdowns": true,
		"autoApply": true,
		"mask": true,
		"locale": {
		    "format": "YYYY-MM-DD",
		    "separator": " - ",
		    "applyLabel": "OK",
		    "cancelLabel": "Batal",
		    "fromLabel": "Dari",
		    "toLabel": "Hingga",
		    "customRangeLabel": "Custom",
		    "weekLabel": "W",
		    "daysOfWeek": [
		        "Mg",
		        "Sn",
		        "Sl",
		        "Rb",
		        "Km",
		        "Jm",
		        "Sa"
		    ],
		    "monthNames": [
		        "Januari",
		        "Februari",
		        "Maret",
		        "April",
		        "Mei",
		        "Juni",
		        "Juli",
		        "Agustus ",
		        "September",
		        "Oktober",
		        "November",
		        "Desember"
		    ],
		    "firstDay": 1
		}
	}, function(start, end, label) {
	  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
	});

	$('.hlcm-presensipekerja-daterangepickersingledate').daterangepicker({
		"singleDatePicker": true,
		"showDropdowns": true,
		"autoApply": true,
		"mask": true,
		"locale": {
		    "format": "YYYY-MM-DD",
		    "separator": " - ",
		    "applyLabel": "OK",
		    "cancelLabel": "Batal",
		    "fromLabel": "Dari",
		    "toLabel": "Hingga",
		    "customRangeLabel": "Custom",
		    "weekLabel": "W",
		    "daysOfWeek": [
		        "Mg",
		        "Sn",
		        "Sl",
		        "Rb",
		        "Km",
		        "Jm",
		        "Sa"
		    ],
		    "monthNames": [
		        "Januari",
		        "Februari",
		        "Maret",
		        "April",
		        "Mei",
		        "Juni",
		        "Juli",
		        "Agustus ",
		        "September",
		        "Oktober",
		        "November",
		        "Desember"
		    ],
		    "firstDay": 1
		}
	}, function(start, end, label) {
	  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
	});
	
});


 $(document).ready(function(){
 	$('#txtMulaiBerlakuPekerjaanHlcm').datepicker({
 		"autoclose": true,
	    "todayHiglight": true,
	    "autoApply": true,
	    "format":'yyyy-mm-dd',
 	});

 	$('.cmbNoindHlcm').select2({
		placeholder: "Noind",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url		: baseurl+'HitungHlcm/UbahPekerjaan/CariPekerja',
			dataType: 'json',
			delay	: 500,
			type 	: 'GET',
			data 	: function(params){
				return {
					term: params.term
				}
			},
			processResults: function (data){
				return {
					results: $.map(data, function(obj){
						return {id: obj.noind, text: obj.noind};
					})
				}
			}
		}
 	});

 	$('.cmbNoindHlcm').on('change',function(){
 		var noind = $('.cmbNoindHlcm').find(':selected').text();

 		$.ajax({
 			data 	: {term :noind},
 			type 	: 'GET',
 			url		: baseurl+'HitungHlcm/UbahPekerjaan/CariPekerja',
 			success : function(data){
 				var obj = JSON.parse(data);
 				$('#txtNamaPekerjaHlcm').val(obj[0]['nama']);
 				$('#txtNamaPekerjaHlcm2').val(obj[0]['nama']);
 				$('#txtPekerjaanLamaHlcm').val(obj[0]['kode_pekerjaan']);
 				$('#txtPekerjaanLamaHlcm2').val(obj[0]['kode_pekerjaan']+' - '+obj[0]['pekerjaan']);
 			}
 		});

 		$.ajax({
 			data 	: {term :noind},
 			type 	: 'GET',
 			url		: baseurl+'HitungHlcm/UbahPekerjaan/CariPekerjaBaru',
 			success : function(data){
 				var obj = JSON.parse(data);
 				$('#txtPekerjaanBaruHlcm').val(obj[0]['kd_pkj']);
 				$('#txtPekerjaanBaruHlcm2').val(obj[0]['kd_pkj']+' - '+obj[0]['pekerjaan']);
 			}
 		});
 	});
 });

 $(document).ready(function(){
 	$('#hlcm-detailpresensi-pkjoff').on('click', function(){
 		cek = $(this).val();
 		if(cek == "Off"){
 			$(this).val("On");
 			$(this).removeClass("btn-danger");
 			$(this).addClass("btn-success");
 		}else{
 			$(this).val("Off");
 			$(this).removeClass("btn-success");
 			$(this).addClass("btn-danger");
 		}
 	});
 	$('input[name*=txt-hlcm-tam-gp]').on('keyup', function(){
 		tam_gp = $(this).val().replace(/[^0-9.]/g, "");
 		$(this).val(tam_gp);
 	});

 	$('select[name*=slc-hlcm-tampot-periode]').change(function(){
 		hlcm_cekdata();
 	});

 	$('select[name*=slc-hlcm-tampot-noind]').change(function(){
 		hlcm_cekdata();
 	});

 	$('#hlcm-tbl-detailpresensi').on('click','td',function(){
 		hlcm_noind_detail_presensi = $(this).closest('tr').find('td:first-child').text();
 		hlcm_periode_detail_presensi = $(this).closest('tr').find('input').val();
 		// console.log(hlcm_noind_detail_presensi + hlcm_periode_detail_presensi);
 		$.ajax({
			data : {noind : hlcm_noind_detail_presensi, periode : hlcm_periode_detail_presensi},
			type : 'POST',
			url : baseurl+"HitungHlcm/DetailPresensi/lihatwaktuabsen",
			success : function(data){
				t = $('#hlcm-tbl-detailpresensi-waktu').dataTable();
				t.fnClearTable();
				obj = JSON.parse(data);
				for (var i = 0; i < obj.length; i++) {
					t.fnAddData([
						obj[i]['tanggal'],
						obj[i]['nama'],
						obj[i]['waktu']
						]);
				}
			}
		});
 	});

 	$('#hlcm-detailpresensi-keterangan').on('keyup',function(){
 		values = $(this).val();
 		if(values.length > 0){
 			$('#hlcm-detailpresensi-collapse-ket').html('<i>Klik tombol Simpan Untuk menyimpan data</i>');
 			$('#hlcm-detailpresensi-collapse-ket').css('color','green');
 		}else{
 			$('#hlcm-detailpresensi-collapse-ket').html('<i>Mohon untuk mengisi Keterangan</i>');
 			$('#hlcm-detailpresensi-collapse-ket').css('color','red');
 		}
 	});

	$('#hlcm-detailpresensi-jenpres').on('change', function(){
		$('#hlcm-detailpresensi-simpan').hide();
		$('#hlcm-detailpresensi-cetak').hide();
	});

	$('#hlcm-detailpresensi-jentam').on('change', function(){
		$('#hlcm-detailpresensi-simpan').hide();
		$('#hlcm-detailpresensi-cetak').hide();
	});

	$('#hlcm-detailpresensi-cutoff-awal').on('change', function(){
		$('#hlcm-detailpresensi-simpan').hide();
		$('#hlcm-detailpresensi-cetak').hide();
	});

	$('#hlcm-detailpresensi-cutoff-akhir').on('change', function(){
		$('#hlcm-detailpresensi-simpan').hide();
		$('#hlcm-detailpresensi-cetak').hide();
	});

	$('#hlcm-detailpresensi-cutoff-awal-pkjoff').on('change', function(){
		$('#hlcm-detailpresensi-simpan').hide();
		$('#hlcm-detailpresensi-cetak').hide();
	});

	$('#hlcm-detailpresensi-cutoff-akhir-pkjoff').on('change', function(){
		$('#hlcm-detailpresensi-simpan').hide();
		$('#hlcm-detailpresensi-cetak').hide();
	});

	$('#hlcm-detailpresensi-pkjoff').on('change', function(){
		$('#hlcm-detailpresensi-simpan').hide();
		$('#hlcm-detailpresensi-cetak').hide();
	});

	$('#hlcm-rekappresensi-cutoff').on('change', function(){
		$('#hlcm-detailpresensi-keterangan').val('');
	});

	$(document).on('ifChecked','input#hlcm-prosesgaji-puasa',function(event){
		$('#periodeGaji').prop('disabled', false);
	});

	$(document).on('ifUnchecked','input#hlcm-prosesgaji-puasa',function(event){
		$('#periodeGaji').prop('disabled', true);
	});
 });

 function hlcm_cekdata(){
 	noind 	= $('select[name*=slc-hlcm-tampot-noind]').val();
	periode = $('select[name*=slc-hlcm-tampot-periode]').val();
	periode_text = $('select[name*=slc-hlcm-tampot-periode] option:selected').text();
	
	if (noind != null && periode.length != null) {
		$.ajax({
			data : {noind : noind, periode : periode},
			type : 'POST',
			url : baseurl+"HitungHlcm/TambahanPotongan/lihatdata",
			success : function(data){
				obj = JSON.parse(data);
				if (obj.length > 0) {
					$('input[name*=txt-hlcm-tam-gp').prop('disabled',true);
					$('input[name*=txt-hlcm-tam-um').prop('disabled',true);
					$('input[name*=txt-hlcm-tam-lembur').prop('disabled',true);
					$('input[name*=txt-hlcm-pot-gp').prop('disabled',true);
					$('input[name*=txt-hlcm-pot-um').prop('disabled',true);
					$('input[name*=txt-hlcm-pot-lembur').prop('disabled',true);
					$('input[name*=txt-hlcm-tam-gp').val(obj['0']['tam_gp']);
					$('input[name*=txt-hlcm-tam-um').val(obj['0']['tam_um']);
					$('input[name*=txt-hlcm-tam-lembur').val(obj['0']['tam_lembur']);
					$('input[name*=txt-hlcm-pot-gp').val(obj['0']['pot_gp']);
					$('input[name*=txt-hlcm-pot-um').val(obj['0']['pot_um']);
					$('input[name*=txt-hlcm-pot-lembur').val(obj['0']['pot_lembur']);
					$('#hlcm-label-pot-tam').html('No. Induk ' + obj['0']['noind'] + " Sudah Memiliki Data Potongan / Tambahan");
					$('#hlcm-label-pot-tam').show();
				}else{
					$('input[name*=txt-hlcm-tam-gp').prop('disabled',false);
					$('input[name*=txt-hlcm-tam-um').prop('disabled',false);
					$('input[name*=txt-hlcm-tam-lembur').prop('disabled',false);
					$('input[name*=txt-hlcm-pot-gp').prop('disabled',false);
					$('input[name*=txt-hlcm-pot-um').prop('disabled',false);
					$('input[name*=txt-hlcm-pot-lembur').prop('disabled',false);
					$('input[name*=txt-hlcm-tam-gp').val("");
					$('input[name*=txt-hlcm-tam-um').val("");
					$('input[name*=txt-hlcm-tam-lembur').val("");
					$('input[name*=txt-hlcm-pot-gp').val("");
					$('input[name*=txt-hlcm-pot-um').val("");
					$('#hlcm-label-pot-tam').hide();
				};
			}
		});
	}else if(periode.length != null){
		$.ajax({
			data : {periode : periode},
			type : 'POST',
			url : baseurl+"HitungHlcm/TambahanPotongan/lihatdata",
			success : function(data){
				obj = JSON.parse(data);
				if (obj.length > 0) {
					$('input[name*=txt-hlcm-tam-gp').prop('disabled',true);
					$('input[name*=txt-hlcm-tam-um').prop('disabled',true);
					$('input[name*=txt-hlcm-tam-lembur').prop('disabled',true);
					$('input[name*=txt-hlcm-pot-gp').prop('disabled',true);
					$('input[name*=txt-hlcm-pot-um').prop('disabled',true);
					$('input[name*=txt-hlcm-pot-lembur').prop('disabled',true);
					$('#hlcm-label-pot-tam').html('Periode ' + periode_text + " Sudah Memiliki Data Potongan / Tambahan, <br>Silahkan Input Per No Induk");
					$('#hlcm-label-pot-tam').show();
				}else{
					$('input[name*=txt-hlcm-tam-gp').prop('disabled',false);
					$('input[name*=txt-hlcm-tam-um').prop('disabled',false);
					$('input[name*=txt-hlcm-tam-lembur').prop('disabled',false);
					$('input[name*=txt-hlcm-pot-gp').prop('disabled',false);
					$('input[name*=txt-hlcm-pot-um').prop('disabled',false);
					$('input[name*=txt-hlcm-pot-lembur').prop('disabled',false);
					$('input[name*=txt-hlcm-tam-gp').val("");
					$('input[name*=txt-hlcm-tam-um').val("");
					$('input[name*=txt-hlcm-tam-lembur').val("");
					$('input[name*=txt-hlcm-pot-gp').val("");
					$('input[name*=txt-hlcm-pot-um').val("");
					$('input[name*=txt-hlcm-pot-lembur').val("");
					$('#hlcm-label-pot-tam').hide();
				};
			}
		});
	}
 }

 function hlcmPresensiPekerjaLihat(){
 	hlcm_var_1 = $('#hlcm-detailpresensi-jenpres').val();
 	hlcm_var_2 = $('#hlcm-detailpresensi-jentam').val();
 	hlcm_var_3 = $('#hlcm-detailpresensi-cutoff-awal').val();
 	hlcm_var_4 = $('#hlcm-detailpresensi-cutoff-akhir').val();
 	hlcm_var_5 = $('#hlcm-detailpresensi-cutoff-awal-pkjoff').val();
 	hlcm_var_6 = $('#hlcm-detailpresensi-cutoff-akhir-pkjoff').val();
 	hlcm_var_7 = $('#hlcm-detailpresensi-pkjoff').val();
 	$('.loading').show();
 	$.ajax({
 		data : {
 				kom_1: hlcm_var_1,
				kom_2: hlcm_var_2,
				kom_3: hlcm_var_3,
				kom_4: hlcm_var_4,
				kom_5: hlcm_var_5,
				kom_6: hlcm_var_6,
				kom_7: hlcm_var_7
				},
		type : 'GET',
		url : baseurl+"HitungHlcm/DetailPresensi/lihatdata",
		success : function(data){
			obj = JSON.parse(data);
			t = $('#hlcm-tbl-detailpresensi-waktu').dataTable();
			t.fnClearTable();
			tt = $('#hlcm-tbl-detailpresensi').dataTable();
			tt.fnDestroy();
			$('.loading').hide();
			$('#hlcm-detailpresensi-simpan').show();
			$('#hlcm-detailpresensi-cetak').show();

			$('#hlcm-tbl-detailpresensi').find('thead').html(obj['header']);
			$('#hlcm-tbl-detailpresensi').find('tbody').html(obj['body']);

			$('#hlcm-tbl-detailpresensi').dataTable({
		   		"scrollX": true,
		   		fixedColumns:   {
		            leftColumns: 2
		        }
		   });
		}
 	});
 }

 function hlcmPresensiPekerjaCetak(){
 	hlcm_var_1 = $('#hlcm-detailpresensi-jenpres').val();
 	hlcm_var_2 = $('#hlcm-detailpresensi-jentam').val();
 	hlcm_var_3 = $('#hlcm-detailpresensi-cutoff-awal').val();
 	hlcm_var_4 = $('#hlcm-detailpresensi-cutoff-akhir').val();
 	hlcm_var_5 = $('#hlcm-detailpresensi-cutoff-awal-pkjoff').val();
 	hlcm_var_6 = $('#hlcm-detailpresensi-cutoff-akhir-pkjoff').val();
 	hlcm_var_7 = $('#hlcm-detailpresensi-pkjoff').val();

 	window.open( baseurl + "HitungHlcm/DetailPresensi/cetakdetailpresensi?kom_1=" + hlcm_var_1 + "&kom_2=" + hlcm_var_2 + "&kom_3=" + hlcm_var_3 + "&kom_4=" + hlcm_var_4 + "&kom_5=" + hlcm_var_5 + "&kom_6=" + hlcm_var_6 + "&kom_7=" + hlcm_var_7,'_blank');
 }

 function hlcmPresensiPekerjaSimpan(){
 	keterangan = $('#hlcm-detailpresensi-keterangan').val();
 	if (keterangan.length > 0) {
		hlcm_var_1 = $('#hlcm-detailpresensi-jenpres').val();
	 	hlcm_var_2 = $('#hlcm-detailpresensi-jentam').val();
	 	hlcm_var_3 = $('#hlcm-detailpresensi-cutoff-awal').val();
	 	hlcm_var_4 = $('#hlcm-detailpresensi-cutoff-akhir').val();
	 	hlcm_var_5 = $('#hlcm-detailpresensi-cutoff-awal-pkjoff').val();
	 	hlcm_var_6 = $('#hlcm-detailpresensi-cutoff-akhir-pkjoff').val();
	 	hlcm_var_7 = $('#hlcm-detailpresensi-pkjoff').val();

	 	// window.open( baseurl + "HitungHlcm/DetailPresensi/simpandetailpresensi?kom_1=" + hlcm_var_1 + "&kom_2=" + hlcm_var_2 + "&kom_3=" + hlcm_var_3 + "&kom_4=" + hlcm_var_4 + "&kom_5=" + hlcm_var_5 + "&kom_6=" + hlcm_var_6 + "&kom_7=" + hlcm_var_7,'_blank');
	 	$('.loading').show();
	 	$.ajax({
	 		data : {
	 				kom_1: hlcm_var_1,
					kom_2: hlcm_var_2,
					kom_3: hlcm_var_3,
					kom_4: hlcm_var_4,
					kom_5: hlcm_var_5,
					kom_6: hlcm_var_6,
					kom_7: hlcm_var_7,
					kom_8: keterangan
					},
			type : 'GET',
			url : baseurl+"HitungHlcm/DetailPresensi/simpandetailpresensi",
			success : function(data){
				$('#hlcm-detailpresensi-collapse-ket').html('<i>Mohon untuk mengisi Keterangan</i>');
 				$('#hlcm-detailpresensi-collapse-ket').css('color','red');
				$('#hlcm-detailpresensi-collapse').collapse('hide');
				$('#hlcm-detailpresensi-keterangan').val('');
				$('.loading').hide();
				Swal.fire(data,'','success');
			}
	 	});
 	}else{
 		$('#hlcm-detailpresensi-collapse').collapse('show');
 	}
	 	
 }

 function hlcmRekapPresensiPekerjaSimpan(){
 	keterangan = $('#hlcm-detailpresensi-keterangan').val();
 	console.log(keterangan.length);
 	if (keterangan.length > 0) {
 		$('#hlcm-detailpresensi-collapse-ket').html('<i>Mohon untuk mengisi Keterangan</i>');
		$('#hlcm-detailpresensi-collapse-ket').css('color','red');
		$('#hlcm-detailpresensi-collapse').collapse('hide');
		$('#hlcm-rekappresensi-simpan').click();
		$('#hlcm-detailpresensi-keterangan').val('');
 	}else{
 		$('#hlcm-detailpresensi-collapse').collapse('show');
 	}
 }

 function showDetailHistoryPotonganTambahanHLCM(noind,periode){
 	
 	$.ajax({
 		data : {periode : periode,noind: noind},
		type : 'POST',
		url : baseurl+"HitungHlcm/TambahanPotongan/detailHistory",
		success : function(data){
			$('#hlcm-modal-body-potongantambahan-history').html("");
			var obj = JSON.parse(data);
			console.log(obj);
			for (var i = 0; i < obj.length; i++) {
				icon = "";
				color = "";
				if (obj[i]['kegiatan'] == "Created") {
					icon = "plus";
					color= "success";
				}else if(obj[i]['kegiatan'] == "Before Edit"){
					icon= "pencil";
					color= "info";
				}else if(obj[i]['kegiatan'] == "After Edit"){
					icon= "pencil";
					color= "primary";
				}else{
					icon= "trash";
					color= "danger";
				}
				if (i%2 == 1) {
					text = " <li class=\"timeline-inverted\"> <div class=\"timeline-badge " + color + "\"><i class=\"glyphicon glyphicon-" + icon + "\"></i></div><div class=\"timeline-panel\"> <div class=\"timeline-heading\"> <h4 class=\"timeline-title\">hlcm-header</h4> <p><small class=\"text-muted\"><i class=\"glyphicon glyphicon-time\"></i> hlcm-waktu</small></p></div><div class=\"timeline-body\"> <p>hlcm-body</p></div></div></li>";
					text = text.replace("hlcm-header", obj[i]['kegiatan']);
					text = text.replace("hlcm-waktu",obj[i]['waktu'] + " oleh " +obj[i]['action_user']);
					text = text.replace("hlcm-body","<table style=\"width: 100%\"><tr><td colspan='6'>Tambahan</td></tr><tr><td>GP</td><td>" + obj[i]['pgp'] + "</td><td>x Rp. </td><td style=\"text-align: right\">" + obj[i]['pgp_perhari'] + "</td><td> = Rp. </td><td style=\"text-align: right\">" + obj[i]['pnominal_gp'] + "</td></tr><tr><td>UM</td><td>" + obj[i]['pum'] + "</td><td>x Rp. </td><td style=\"text-align: right\">" + obj[i]['pum_perhari'] + "</td><td> = Rp. </td><td style=\"text-align: right\">" + obj[i]['pnominal_um'] + "</td></tr><tr><td>LEMBUR</td><td>" + obj[i]['plembur'] + "</td><td>x Rp. </td><td style=\"text-align: right\">" + obj[i]['plembur_perjam'] + "</td><td> = Rp. </td><td style=\"text-align: right\">" + obj[i]['pnominal_lembur'] + "</td></tr><tr><td colspan='6'>Potongan</td></tr><tr><td>GP</td><td>" + obj[i]['tgp'] + "</td><td>x Rp. </td><td style=\"text-align: right\">" + obj[i]['tgp_perhari'] + "</td><td> = Rp. </td><td style=\"text-align: right\">" + obj[i]['tnominal_gp'] + "</td></tr><tr><td>UM</td><td>" + obj[i]['tum'] + "</td><td>x Rp. </td><td style=\"text-align: right\">" + obj[i]['tum_perhari'] + "</td><td> = Rp. </td><td style=\"text-align: right\">" + obj[i]['tnominal_um'] + "</td></tr><tr><td>LEMBUR</td><td>" + obj[i]['tlembur'] + "</td><td>x Rp. </td><td style =\"text-align: right\">" + obj[i]['tlembur_perjam'] + "</td><td> = Rp. </td><td style=\"text-align: right\">" + obj[i]['tnominal_lembur'] + "</td></tr></table>");
					$('#hlcm-modal-body-potongantambahan-history').append(text);
				}else{
					text = " <li> <div class=\"timeline-badge " + color + "\"><i class=\"glyphicon glyphicon-" + icon + "\"></i></div><div class=\"timeline-panel\"> <div class=\"timeline-heading\"> <h4 class=\"timeline-title\">hlcm-header</h4> <p><small class=\"text-muted\"><i class=\"glyphicon glyphicon-time\"></i> hlcm-waktu</small></p></div><div class=\"timeline-body\"> <p>hlcm-body</p></div></div></li>";
					text = text.replace("hlcm-header", obj[i]['kegiatan']);
					text = text.replace("hlcm-waktu",obj[i]['waktu'] + " oleh " +obj[i]['action_user']);
					text = text.replace("hlcm-body","<table style=\"width: 100%\"><tr><td colspan='6'>Tambahan</td></tr><tr><td>GP</td><td>" + obj[i]['pgp'] + "</td><td>x Rp. </td><td style=\"text-align: right\">" + obj[i]['pgp_perhari'] + "</td><td> = Rp. </td><td style=\"text-align: right\">" + obj[i]['pnominal_gp'] + "</td></tr><tr><td>UM</td><td>" + obj[i]['pum'] + "</td><td>x Rp. </td><td style=\"text-align: right\">" + obj[i]['pum_perhari'] + "</td><td> = Rp. </td><td style=\"text-align: right\">" + obj[i]['pnominal_um'] + "</td></tr><tr><td>LEMBUR</td><td>" + obj[i]['plembur'] + "</td><td>x Rp. </td><td style=\"text-align: right\">" + obj[i]['plembur_perjam'] + "</td><td> = Rp. </td><td style=\"text-align: right\">" + obj[i]['pnominal_lembur'] + "</td></tr><tr><td colspan='6'>Potongan</td></tr><tr><td>GP</td><td>" + obj[i]['tgp'] + "</td><td>x Rp. </td><td style=\"text-align: right\">" + obj[i]['tgp_perhari'] + "</td><td> = Rp. </td><td style=\"text-align: right\">" + obj[i]['tnominal_gp'] + "</td></tr><tr><td>UM</td><td>" + obj[i]['tum'] + "</td><td>x Rp. </td><td style=\"text-align: right\">" + obj[i]['tum_perhari'] + "</td><td> = Rp. </td><td style=\"text-align: right\">" + obj[i]['tnominal_um'] + "</td></tr><tr><td>LEMBUR</td><td>" + obj[i]['tlembur'] + "</td><td>x Rp. </td><td style =\"text-align: right\">" + obj[i]['tlembur_perjam'] + "</td><td> = Rp. </td><td style=\"text-align: right\">" + obj[i]['tnominal_lembur'] + "</td></tr></table>");
					$('#hlcm-modal-body-potongantambahan-history').append(text);
				}
			}
			$('#hlcm-modal-potongantambahan').modal('show');
		}
 	})
 	
 }

 $(document).ready(function(){
 	$(('#tblHLCMMOnitoringPengembalian')).DataTable();
 	
 	$('#txtHLCMIdulFitri').datepicker({
 		"autoclose": true,
	    "todayHiglight": true,
	    "autoApply": true,
	    "format":'yyyy-mm-dd',
 	});

 	$('#txtHLCMPengembalianTHRTanggal').datepicker({
 		"autoclose": true,
	    "todayHiglight": true,
	    "autoApply": true,
	    "format":'yyyy-mm-dd',
 	});

 	$('#txtHLCMIdulFitriBulanTHR').datepicker({
 		"autoclose": true,
	    "todayHiglight": true,
	    "autoApply": true,
	    "format":'yyyy-mm-dd',
 	});

 	$('#txtHLCMTanggalCetakTHR').datepicker({
 		"autoclose": true,
	    "todayHiglight": true,
	    "autoApply": true,
	    "format":'yyyy-mm-dd',
 	});

 	$('#txtHLCMPeriodeAwalTHR').datepicker({
 		"autoclose": true,
	    "todayHiglight": true,
	    "autoApply": true,
	    "format":'MM yyyy',
	    "viewMode":'months',
	    "minViewMode":'months'
 	});

 	$('#txtHLCMPeriodeAkhirTHR').datepicker({
 		"autoclose": true,
	    "todayHiglight": true,
	    "autoApply": true,
	    "format":'MM yyyy',
	    "viewMode":'months',
	    "minViewMode":'months'
 	});

 	$('.slcHLCMNoindTHRBulan').select2({
        searching: true,
        minimumInputLength: 3,
        placeholder: "No. Induk / Nama Pekerja",
        dropdownParent: $('#modal-HLCM-THRBulan'),
        allowClear: false,
        ajax: {
            url: baseurl + 'HitungHlcm/THR/PerhitunganBulan/cariPekerja',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + " - " + obj.nama };
                    })
                }
            }
        }
    });

    $('.slcHLCMNoindTHR').select2({
        searching: true,
        minimumInputLength: 3,
        placeholder: "No. Induk / Nama Pekerja",
        dropdownParent: $('#modal-HLCM-THR'),
        allowClear: false,
        ajax: {
            url: baseurl + 'HitungHlcm/THR/Perhitungan/cariPekerja',
            dataType: 'json',
            delay: 500,
            type: 'GET',
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.noind, text: obj.noind + " - " + obj.nama };
                    })
                }
            }
        }
    });

 	$('#txtHLCMIdulFitri').on('change',function(){
 		tanggal = $('#txtHLCMIdulFitri').val();
 		awal = $('#txtHLCMPeriodeAwalTHR').val();
 		akhir = $('#txtHLCMPeriodeAkhirTHR').val();

 		if (tanggal && awal && akhir) {
 			$('#btnHLCMHitungTHR').prop('disabled',false);
 		}else{
 			$('#btnHLCMHitungTHR').prop('disabled',true);
 		}
		$('#btnHLCMCetakTHR').prop('disabled',true);
 	})

 	$('#txtHLCMPeriodeAwalTHR').on('change',function(){
 		tanggal = $('#txtHLCMIdulFitri').val();
 		awal = $('#txtHLCMPeriodeAwalTHR').val();
 		akhir = $('#txtHLCMPeriodeAkhirTHR').val();
 		
 		if (tanggal && awal && akhir) {
 			$('#btnHLCMHitungTHR').prop('disabled',false);
 		}else{
 			$('#btnHLCMHitungTHR').prop('disabled',true);
 		}
		$('#btnHLCMCetakTHR').prop('disabled',true);
 	})

 	$('#txtHLCMPeriodeAkhirTHR').on('change',function(){
 		tanggal = $('#txtHLCMIdulFitri').val();
 		iawal = $('#txtHLCMPeriodeAwalTHR').val();
 		akhir = $('#txtHLCMPeriodeAkhirTHR').val();
 		
 		if (tanggal && awal && akhir) {
 			$('#btnHLCMHitungTHR').prop('disabled',false);
 		}else{
 			$('#btnHLCMHitungTHR').prop('disabled',true);
 		}
		$('#btnHLCMCetakTHR').prop('disabled',true);
 	})

 	$('#txtHLCMIdulFitriBulanTHR').on('change',function(){
 		tanggal = $('#txtHLCMIdulFitriBulanTHR').val();

 		if (tanggal) {
 			$('#btnHLCMHitungBulanTHR').prop('disabled',false);
 		}else{
 			$('#btnHLCMHitungBulanTHR').prop('disabled',true);
 		}
		$('#btnHLCMCetakBulanTHR').prop('disabled',true);
		$('#btnHLCMExportBulanTHR').prop('disabled',true);
 	})

 	$('#slcHCLMLokasiBulanTHR').on('change',function(){
 		tanggal = $('#txtHLCMIdulFitriBulanTHR').val();
 		
 		if (tanggal) {
 			$('#btnHLCMHitungBulanTHR').prop('disabled',false);
 		}else{
 			$('#btnHLCMHitungBulanTHR').prop('disabled',true);
 		}
		$('#btnHLCMCetakBulanTHR').prop('disabled',true);
		$('#btnHLCMExportBulanTHR').prop('disabled',true);
 	})

 	$('#btnHLCMHitungBulanTHR').on('click',function(){
 		lokasi = $('#slcHCLMLokasiBulanTHR').val();
 		tanggal = $('#txtHLCMIdulFitriBulanTHR').val();
 		
 		if (tanggal) {
 			if (lokasi) {
 				isiForm = {lokasi: lokasi, tanggal: tanggal}
 			}else{
 				isiForm = {tanggal: tanggal}
 			}
 			$.ajax({
 				data: isiForm,
	            type: 'POST',
	            url: baseurl + 'HitungHlcm/THR/PerhitunganBulan/hitung',
	            error: function(xhr,status,error){
	                console.log(xhr);
	                console.log(status);
	                console.log(error);
	                swal.fire({
	                    title: xhr['status'] + "(" + xhr['statusText'] + ")",
	                    html: xhr['responseText'],
	                    type: "error",
	                    confirmButtonText: 'OK',
	                    confirmButtonColor: '#d63031',
	                })
	            },
	            success: function(result){
	            	obj = JSON.parse(result);
	            	// console.log(obj);
	            	html = "";
	            	for (var i = 0; i < obj.length; i++) {
	            		html += "<tr>";
	            		html += "<td>";
	            		html += (i + 1);
	            		html += "</td>";
	            		html += "<td>";
	            		html += obj[i]['noind'];
	            		html += "</td>";
	            		html += "<td>";
	            		html += obj[i]['noind'];
	            		html += "</td>";
	            		html += "<td>";
	            		html += obj[i]['nama'];
	            		html += "</td>";
	            		html += "<td>";
	            		html += obj[i]['masuk'];
	            		html += "</td>";
	            		html += "<td>";
	            		html += obj[i]['masa_kerja'];
	            		html += "</td>";
	            		html += "<td>";
	            		html += obj[i]['bulan_thr'];
	            		html += "</td>";
	            		html += "</tr>";
	            	}
	            	$('#tbodyBulanTHR').html(html);
	            	$('#tblHLCMBulanTHR').DataTable();
					$('#btnHLCMCetakBulanTHR').prop('disabled',false);
					$('#btnHLCMExportBulanTHR').prop('disabled',false);
	            }
 			})
 		};
 	});

 	$('#btnHLCMCetakBulanTHR').on('click',function(){
 		lokasi = $('#slcHCLMLokasiBulanTHR').val();
 		tanggal = $('#txtHLCMIdulFitriBulanTHR').val();
 		
 		if (tanggal) {
 			if (lokasi) {
 				isiForm = '?lokasi=' + lokasi + '&tanggal=' + tanggal
 			}else{
 				isiForm = '?tanggal=' + tanggal
 			}
 			window.open(baseurl + 'HitungHlcm/THR/PerhitunganBulan/cetak' + isiForm,'_blank');
 		};
 	});

 	$('#btnHLCMExportBulanTHR').on('click',function(){
 		lokasi = $('#slcHCLMLokasiBulanTHR').val();
 		tanggal = $('#txtHLCMIdulFitriBulanTHR').val();
 		
 		if (tanggal) {
 			if (lokasi) {
 				isiForm = '?lokasi=' + lokasi + '&tanggal=' + tanggal
 			}else{
 				isiForm = '?tanggal=' + tanggal
 			}
 			window.open(baseurl + 'HitungHlcm/THR/PerhitunganBulan/export' + isiForm,'_blank');
 		};
 	});

 	$('.btnHLCMTHRCetakBulan').on('click',function(){
 		var lokasi = $(this).attr('data-lokasi');
 		var tanggal = $(this).attr('data-tanggal');
 		$('#txtTanggalIdulFitri').val(tanggal);
 		$('#txtLokasiKerja').val(lokasi);
 		$('#modal-HLCM-THRBulan').modal('show');
 	});

 	$('.modal-close-HLCM-THRBulan').on('click',function(){
 		$('#modal-HLCM-THRBulan').modal('hide');
 	})

 	$('.btnHLCMTHRCetak').on('click',function(){
 		var lokasi = $(this).attr('data-lokasi');
 		var tanggal = $(this).attr('data-tanggal');
 		$('#txtTanggalIdulFitri').val(tanggal);
 		$('#txtLokasiKerja').val(lokasi);
 		$('#modal-HLCM-THR').modal('show');
 	});

 	$('.modal-close-HLCM-THR').on('click',function(){
 		$('#modal-HLCM-THR').modal('hide');
 	})
 })