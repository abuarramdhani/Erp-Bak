$(document).ready(function(){

	$('.select-nama-prs').select2({
		ajax: {
		    url: baseurl+"Presensi/PresensiDL/get_js_pekerja",
		    dataType: 'json',
		    type: "get",
		    data: function (params) {
		      return { p: params.term };
		    },
		    processResults: function (data) {
		      return {
		        results: $.map(data, function (item) {
		          return {
		            id: item.noind,
		            text: item.noind+' - '+item.nama,
		          }
		        })
		      };
		    },
		    cache: true
		  },
	  minimumInputLength: 2,
	  allowClear: false,
	});

	$('.select-kodesie-prs').select2({
		ajax: {
		    url: baseurl+"Presensi/PresensiDL/get_js_seksi",
		    dataType: 'json',
		    type: "get",
		    data: function (params) {
		      return { p: params.term };
		    },
		    processResults: function (data) {
		      return {
		        results: $.map(data, function (item) {
		          return {
		            id: item.kodesie,
		            text: item.kodesie+' - '+item.seksi,
		          }
		        })
		      };
		    },
		    cache: true
		  },
	  minimumInputLength: 2,
	  allowClear: false,
	});

	$('.select-pencarian-prs').select2({
	  minimumInputLength: 0,
	  allowClear: false,
	});

	$(document).on("change", "#idNoind_prs", function () {
		 var noind_length = $(this).val();
		$.ajax({
	        type: "POST",
	        url: baseurl+"Presensi/PresensiDL/seksi_disabled",
	        data: ({ noind : noind_length}),
	        dataType: "json",
	        success: function(data) {
	           $('.select-kodesie-prs').select2('data', {kodesie: data});
	        },
	        error: function() {
	            alert('Not Found');
	        }
	    });
	});

	$('.prs-table-presensi-dl').DataTable({
		searching: true,
		lengthChange: false,
	});

});

// 	-------Presensi Catering--------------------------------------------start
	$(function()
	{
		// 	Daterangepicker
		// 	{
				$('.PresensiCatering-daterangepickersingledate').daterangepicker({
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
		//	}

		// 	Datatables
		//	{
				$('#PresensiCatering-tabelRekapTransaksiCatering').DataTable({
					scrollX: false,
					lengthChange: false,
					paging: false,
				});
		//	}
	});

// 	-------Presensi Catering----------------------------------------------end

