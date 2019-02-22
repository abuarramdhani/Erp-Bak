$(document).ready(function() {
	$('.tgl-KMK').daterangepicker({
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
						console.log("New date range selected: ' + start.format('YYYY-MM-DD H:i:s') + ' to ' + end.format('YYYY-MM-DD H:i:s') + ' (predefined range: ' + label + ')");
					});

	$('#tbl_KMK').DataTable();
});