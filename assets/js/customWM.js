//limbah B3

$(function() { 
	$('.dataTable-limbah').DataTable( {
      dom: 'frtip',
    });

    $('#txtTanggalKirimHeader').datepicker({
		"autoclose": true,
		"todayHiglight": true,
		"format": 'dd M yyyy'
  	});	

  	$('#txtTanggalTransaksiHeader').datepicker({
		"autoclose": true,
		"todayHiglight": true,
		"format": 'dd M yyyy'
  	});

  	$('#txtMaksPenyimpananHeader').datepicker({
		"autoclose": true,
		"todayHiglight": true,
		"format": 'dd M yyyy'
  	});

  	$('#txtTanggalKeluarHeader').datepicker({
		"autoclose": true,
		"todayHiglight": true,
		"format": 'dd M yyyy'
  	});

  	$("#periode").daterangepicker({  
      		"autoclose": true,
    		"todayHiglight": true,
    		locale: {
    			cancelLabel: 'Clear'
    		},
    		autoUpdateInput: false,
    });

    $('input[id="periode"]').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
	});

	$('input[id="periode"]').on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
	});

})