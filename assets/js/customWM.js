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

});


//Limbah Transaksi
$('#cmbJenisLimbahHeader').change(function(){
    var val = $('#cmbJenisLimbahHeader option:selected').val();
    if(val) {
      $.ajax({
        type:'POST',
        data:{cmbJenisLimbahHeader:val},
        url:baseurl+"WasteManagement/LimbahTransaksi/selectJenisLimbah",
        success:function(result)
        {
          var result = JSON.parse(result);

          $('#SatuanLimbah').val(result['limbah_satuan']);
          $('#SumberLimbah').val(result['sumber']);
        }

      });
    } else {
      $('#SatuanLimbah').val('');
      $('#SumberLimbah').val('');
    }
});

//Limbah Keluar
$('#cmbJenisLimbahKeluarHeader').change(function(){
    var val = $('#cmbJenisLimbahKeluarHeader option:selected').val();
    if(val) {
      $.ajax({
        type:'POST',
        data:{cmbJenisLimbahKeluarHeader:val},
        url:baseurl+"WasteManagement/LimbahKeluar/selectJenisLimbah",
        success:function(result)
        {
          var result = JSON.parse(result);

          $('#SatuanLimbahKeluar').val(result['limbah_satuan']);
          $('#SumberLimbahKeluar').val(result['sumber']);
        }

      });
    } else {
      $('#SatuanLimbahKeluar').val('');
      $('#SumberLimbahKeluar').val('');
    }
});