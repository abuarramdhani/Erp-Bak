$(function () {
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
		   $("#button_edit").attr("data","0");

   		} else if(data == '0'){
   			// alert (data);
		   $('#kepalatukang').prop("readonly", true);
		   $('#tukang').prop("readonly", true);
		   $('#serabutan').prop("readonly", true);
		   $('#tenaga').prop("readonly", true);
		   $('#uangmakan').prop("readonly", true);
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
        }

      		});
    	} else {
     
    	}
	});

   $('#table_prosesgaji').dataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
		  "info": true,
          "autoWidth": false,
		  "deferRender" : true,
		  "scroller": true,
   });


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

	// $('.KecelakaanKerja-daterangepickersingledate').daterangepicker({
	// 	"singleDatePicker": true,
	// 	"showDropdowns": true,
	// 	"autoApply": true,
	// 	"mask": true,
	// 	"locale": {
	// 	    "format": "YYYY-MM-DD",
	// 	    "separator": " - ",
	// 	    "applyLabel": "OK",
	// 	    "cancelLabel": "Batal",
	// 	    "fromLabel": "Dari",
	// 	    "toLabel": "Hingga",
	// 	    "customRangeLabel": "Custom",
	// 	    "weekLabel": "W",
	// 	    "daysOfWeek": [
	// 	        "Mg",
	// 	        "Sn",
	// 	        "Sl",
	// 	        "Rb",
	// 	        "Km",
	// 	        "Jm",
	// 	        "Sa"
	// 	    ],
	// 	    "monthNames": [
	// 	        "Januari",
	// 	        "Februari",
	// 	        "Maret",
	// 	        "April",
	// 	        "Mei",
	// 	        "Juni",
	// 	        "Juli",
	// 	        "Agustus ",
	// 	        "September",
	// 	        "Oktober",
	// 	        "November",
	// 	        "Desember"
	// 	    ],
	// 	    "firstDay": 1
	// 	}
	// }, function(start, end, label) {
	//   console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
	// });

	// $('.KecelakaanKerja-daterangepickersingledatewithtime').daterangepicker({
	//     "timePicker": true,
	//     "timePicker24Hour": true,
	//     "singleDatePicker": true,
	//     "showDropdowns": true,
	//     "autoApply": true,
	//     "locale": {
	//         "format": "YYYY-MM-DD HH:mm:ss",
	//         "separator": " - ",
	//         "applyLabel": "OK",
	//         "cancelLabel": "Batal",
	//         "fromLabel": "Dari",
	//         "toLabel": "Hingga",
	//         "customRangeLabel": "Custom",
	//         "weekLabel": "W",
	//         "daysOfWeek": [
	//             "Mg",
	//             "Sn",
	//             "Sl",
	//             "Rb",
	//             "Km",
	//             "Jm",
	//             "Sa"
	//         ],
	//         "monthNames": [
	//             "Januari",
	//             "Februari",
	//             "Maret",
	//             "April",
	//             "Mei",
	//             "Juni",
	//             "Juli",
	//             "Agustus ",
	//             "September",
	//             "Oktober",
	//             "November",
	//             "Desember"
	//         ],
	//         "firstDay": 1
	//     }
	// }, function(start, end, label) {
	//   console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
	// });	
	
});


 