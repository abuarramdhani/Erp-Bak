$(document).ready(function(){
	$('#presensiH-btnExcel_v1').on('click',function(){
		$('#form_presensiH').attr('action',baseurl+"AdmCabang/PresensiHarian/ExportExcel");
		$('#form_presensiH').submit();
	});
	$('#presensiH-btnExcel_v2').on('click',function(){
		// alert("sukses");
		$('#form_presensiH').attr('action',baseurl+"AdmCabang/PresensiHarian/ExportExcelv2");
		$('#form_presensiH').submit();
	});
	$('#presensiH-btnPDF_v1').on('click',function(){
		$('#form_presensiH').attr('action',baseurl+"AdmCabang/PresensiHarian/ExportPdf");
		$('#form_presensiH').submit();
	});
	$('#presensiH-btnPDF_v2').on('click',function(){
		// alert("sukses");
		$('#form_presensiH').attr('action',baseurl+"AdmCabang/PresensiHarian/ExportPdfv2");
		$('#form_presensiH').submit();
	});

});
$(document).ready(function(){
				$('.cmdaterange').daterangepicker({
				    "showDropdowns": true,
				    "autoApply": true,
				    "locale": {
				        "format": "DD-MM-YYYY",
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
				$('.cmsingledate').daterangepicker({
				    "singleDatePicker": true,
				    "showDropdowns": true,
				    "autoApply": true,
				    "locale": {
				        "format": "DD-MM-YYYY",
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

		$('#slc_seksibooking').select2({
			placeholder: "Seksi",
	    	minimumInputLength: 2,
			allowClear: true,
			ajax: {
				url: baseurl+"BookingKendaraan/CariMobil/cariseksi",
				dataType:'json',
				type: "GET",
				data: function (params) {
					return {term: params.term};
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {
							return {
								id: item.kodesie,
								text: item.kodesie+' - '+item.seksi
							};
						})
						
					};
				},
			},
		});
		$('#slc_picbooking').select2({
			placeholder: "PIC",
	    	minimumInputLength: 2,
			allowClear: true,
			ajax: {
				url: baseurl+"BookingKendaraan/CariMobil/cariPIC",
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

		$('#pengemudi_mobil').select2({
			placeholder: "Pengemudi",
	    	minimumInputLength: 2,
			ajax: {
				url: baseurl+"BookingKendaraan/CariMobil/cariPIC",
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
			allowClear: true,
		});

	

		$('#pemohon_booking').select2({
			placeholder: "Pemohon",
	    	minimumInputLength: 2,
			ajax: {
				url: baseurl+"BookingKendaraan/CariMobil/cariPIC",
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
			allowClear: true,
		});

		$('#tbl_booking_datatable').dataTable({
	          "paging": true,
	          "lengthChange": false,
	          "searching": false,
	          "ordering": true,
			  "info": true,
	          "autoWidth": false,
			  "deferRender" : true,
			  "scroller": true,
			  // "pageLength": 2,
		});

		$('#tbl_log_booking_kendaraan').dataTable({
	          "paging": true,
	          "lengthChange": false,
	          "searching": false,
	          "ordering": true,
			  "info": true,
	          "autoWidth": false,
			  "deferRender" : true,
			  "scroller": true,
			  // "pageLength": 2,
		});
		$('#tbl_data_booking_admin').dataTable({
	          "paging": true,
	          "lengthChange": false,
	          "searching": false,
	          "ordering": true,
			  "info": true,
	          "autoWidth": false,
			  "deferRender" : true,
			  "scroller": true,
			  // "pageLength": 2,
		});

		$('.cal_periode_booking').daterangepicker({
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




	$(function(){
		$('#tgl_caribooking').datepicker({
		      "autoclose": true,
		      "todayHiglight": true,
		      "format":'yyyy-mm-dd',
		      // "viewMode":'months',
		      // "minViewMode":'months'
		});

		
		
	});
