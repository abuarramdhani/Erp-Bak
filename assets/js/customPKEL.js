$(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });

    
    $('#PK_slc_Pekerja').select2({ 
    	minimumInputLength: 3,
		allowClear: true,
		placeholder: 'tulis nama atau noind',
		ajax: {
			url: baseurl+"MasterPekerja/DataPekerjaKeluar/data_pekerja",
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {term: params.term,
						rd_keluar: $('input[name="rd_keluar"]:checked').val()
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

	$('#PK_txt_pekerjaanPekerja').select2({ 
		allowClear: true,
		placeholder: '',
		ajax: {
			url: baseurl+"MasterPekerja/DataPekerjaKeluar/data_pekerjaan",
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {term: params.term,
						kd_pekerjaan: $('#txt_kdPekerjaan').val()
						};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.kdpekerjaan,
							text: item.pekerjaan
						};
					})
					
				};
			},
		},
	});

	$('#PK-slc_provinsi_pekerja').on('change',function(){
		$('#PK-slc_kabupaten_pekerja').select2("val","");
		$('#PK-slc_kecamatan_pekerja').select2("val","");
		$('#PK-slc_desa_pekerja').select2("val","");
	})

	$('#PK-slc_provinsi_pekerja').select2({ 
    	minimumInputLength: 2,
		allowClear: true, 
		placeholder: 'Provinsi',
		ajax: {
			url: baseurl+"MasterPekerja/DataPekerjaKeluar/provinsiPekerja",
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {term: params.term};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.id_prov,
							text: obj.nama,
						};
					})
					
				};
			},
		},
	});


	$('#PK-slc_kabupaten_pekerja').select2({ 
    	minimumInputLength: 0,
		allowClear: true, 
		placeholder: 'Kabupaten',
		ajax: {
			url: baseurl+"MasterPekerja/DataPekerjaKeluar/kabupatenPekerja",
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {term: params.term,
						prov : $("#PK-slc_provinsi_pekerja").val(),
					};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (ok) {
						return {
							id: ok.id_kab,
							text: ok.nama,
						};
					})
					
				};
			},
		},
	});

	$('#PK-slc_kecamatan_pekerja').select2({ 
    	minimumInputLength: 0,
		allowClear: true, 
		placeholder: 'Kecamatan',
		ajax: {
			url: baseurl+"MasterPekerja/DataPekerjaKeluar/kecamatanPekerja",
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {term: params.term,
						kab : $("#PK-slc_kabupaten_pekerja").val(),
					};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (ok) {
						return {
							id: ok.id_kec,
							text: ok.nama,
						};
					})
					
				};
			},
		},
	});

	$('#PK-slc_desa_pekerja').select2({ 
    	minimumInputLength: 0,
		allowClear: true, 
		placeholder: 'Kelurahan',
		ajax: {
			url: baseurl+"MasterPekerja/DataPekerjaKeluar/desaPekerja",
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {term: params.term,
						kec : $("#PK-slc_kecamatan_pekerja").val(),
					};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (ok) {
						return {
							id: ok.id_kel,
							text: ok.nama,
						};
					})
					
				};
			},
		},
	});

	$('.PK-daterangepicker').daterangepicker({
		"showDropdowns": true,
		"autoApply": true,
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

	$('.PK-daterangepickersingledate').daterangepicker({
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

	$('.PK-daterangepickersingledatewithtime').daterangepicker({
	    "timePicker": true,
	    "timePicker24Hour": true,
	    "singleDatePicker": true,
	    "showDropdowns": true,
	    "autoApply": true,
	    "locale": {
	        "format": "YYYY-MM-DD HH:mm:ss",
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

