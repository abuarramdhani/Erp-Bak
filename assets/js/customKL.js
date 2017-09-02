$(document).ready(function() {
		
	var baseUrl = document.location.origin;
	$('.table_document').DataTable({
		 "paging": true,
		  "lengthChange": false,
		  "searching": false,
		  "ordering": true,
		  "info": true,
		  "autoWidth": true,
		  "scrollX": true,
		  "ajax": baseUrl+'/erp/CalibrationReport/Calibration/showDocument',
		  "columnDefs": [
							{ width: "2%", className: "text-center", "targets": [ 0 ] },
							{ width: "10%", className: "text-center", "targets": [ 1 ] },
							{ width: "10%", className: "text-center", "targets": [ 2 ] },
							{ width: "10%", className: "text-center", "targets": [ 5 ] },
							{ width: "10%", className: "text-center", "targets": [ 6 ] },
							{ width: "5%", className: "text-center", "targets": [ 7 ] },
							{ width: "10%", className: "text-center", "targets": [ 8 ] },
							{ width: "10%", className: "text-center", "targets": [ 10 ] }
						]
	});
	
	$('#seachDocument').click(function(){
		$('#modalSearch').modal('show');
	});
	
	$('#txsJudgement').select2({
		minimumResultsForSearch: -1,
	});
	
	$('#txtPeriode').daterangepicker();
	$('#txtTanggal').datepicker();
});
