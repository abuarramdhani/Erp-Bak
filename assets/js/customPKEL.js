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

