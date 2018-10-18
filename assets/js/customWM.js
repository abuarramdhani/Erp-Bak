//limbah B3

$(function() { 
	$('.dataTable-limbah').DataTable( {
      dom: 'frtp',
    });

  $('.dataTable-Simple').DataTable( {
      dom: 'frtp',
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

  	$('#txtTanggalKeluarHeader').datepicker({
		"autoclose": true,
		"todayHiglight": true,
		"format": 'dd M yyyy'
  	});

    $('#txtSimplePeriode').datepicker({
      "autoclose": true,
      "todayHiglight": true,
      "format":'MM yyyy',
      "viewMode":'months',
      "minViewMode":'months'
    });

    $('#txtTanggalDihasilkan').datepicker({
      "autoclose": true,
      "todayHiglight": true,
      "format":'dd MM yyyy'
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


//date interval for maks penyimpanan
$(document).on('change', '#txtTanggalTransaksiHeader', function(){
  var tgl = $(this).val();
  
  if (tgl) {
    var date = new Date(tgl);
    var newdate = new Date(date);
    newdate.setDate(newdate.getDate() + 90);
    var nd = new Date(newdate);
    var dd = ("0" + nd.getDate()).slice(-2);
    var mm = ("0" + (nd.getMonth() + 1)).slice(-2);
    var y = nd.getFullYear();
    var someFormattedDate = dd + '-' + mm + '-' + y;

    $('#txtMaksPenyimpananHeader').val(someFormattedDate);
  }else{
    $('#txtMaksPenyimpananHeader').val('');
  }
});


function CekApproval(){
  var cekLimbahMasuk = $("input.cekLimbahMasuk:checked").length;
  var cekLimbahKeluar = $("input.cekLimbahKeluar:checked").length;

  if (cekLimbahMasuk > 0) {
    $('#ApproveLimbahMasuk').removeAttr('disabled', 'disabled');
    $('#RejectLimbahMasuk').removeAttr('disabled', 'disabled');
  }else{
    $('#ApproveLimbahMasuk').attr('disabled', 'disabled');
    $('#RejectLimbahMasuk').attr('disabled', 'disabled');
  }

  if (cekLimbahKeluar > 0) {
    $('#ApproveLimbahKeluar').removeAttr('disabled', 'disabled');
    $('#RejectLimbahKeluar').removeAttr('disabled', 'disabled');
  }else{
    $('#ApproveLimbahKeluar').attr('disabled', 'disabled');
    $('#RejectLimbahKeluar').attr('disabled', 'disabled');
  }
}

$('input.cekLimbahMasuk').on('change', function(){
  CekApproval();
});

$('input.cekLimbahKeluar').on('change', function(){
  CekApproval();
});

$(document).on('click', '#ApproveLimbahMasuk', function(e){
  e.preventDefault();
  // var idMasuk = $('input.cekLimbahMasuk:checked').attr('data-limbah-masuk');
  var idMasuk = '';
    $('input.cekLimbahMasuk:checked').each(function(index){
      var id = $(this).attr('data-limbah-masuk');
      idMasuk += id+',';
    });

  var check = confirm("Apakah anda yakin ingin melakukan approve pada data tersebut?");
  if (check) {
    $.ajax({
        url: baseurl+"WasteManagement/LimbahTransaksi/ApproveLimbahMasuk",
        type: "POST",
        data: {idMasuk: idMasuk}
      }).done(function(data) {
        window.location = baseurl+"WasteManagement";
      });
  }else{
    alert("batal melakukan approve");
  }
});

$(document).on('click', '#RejectLimbahMasuk', function(e){
  e.preventDefault();

  var idMasuk = '';
    $('input.cekLimbahMasuk:checked').each(function(index){
      var id = $(this).attr('data-limbah-masuk');
      idMasuk += id+',';
    });

  var check = confirm("Apakah anda yakin ingin melakukan reject pada data tersebut?");
  if (check) {
    $.ajax({
        url: baseurl+"WasteManagement/LimbahTransaksi/RejectLimbahMasuk",
        type: "POST",
        data: {idMasuk: idMasuk}
      }).done(function(data) {
        window.location = baseurl+"WasteManagement";
      });
  }else{
    alert("batal melakukan reject");
  }
});

$(document).on('click', '#ApproveLimbahKeluar', function(e){
  e.preventDefault();

  var idKeluar = '';
    $('input.cekLimbahKeluar:checked').each(function(index){
      var id = $(this).attr('data-limbah-keluar');
      idKeluar += id+',';
    });

  var check = confirm("Apakah anda yakin ingin melakukan approve pada data tersebut?");
  if (check) {
    $.ajax({
        url: baseurl+"WasteManagement/LimbahKeluar/ApproveLimbahKeluar",
        type: "POST",
        data: {idKeluar: idKeluar}
      }).done(function(data) {
        window.location = baseurl+"WasteManagement";
      });
  }else{
    alert("batal melakukan approve");
  }

});

$(document).on('click', '#RejectLimbahKeluar', function(e){
  e.preventDefault();

  var idKeluar = '';
    $('input.cekLimbahKeluar:checked').each(function(index){
      var id = $(this).attr('data-limbah-keluar');
      idKeluar += id+',';
    });

  var check = confirm("Apakah anda yakin ingin melakukan reject pada data tersebut?");
  if (check) {
    $.ajax({
        url: baseurl+"WasteManagement/LimbahKeluar/RejectLimbahKeluar",
        type: "POST",
        data: {idKeluar: idKeluar}
      }).done(function(data) {
        window.location = baseurl+"WasteManagement";
      });
  }else{
    alert("batal melakukan reject");
  }

});

$(document).on('click','#btnSubmitSimple',function(e){
  var limjenis = $('#txtSimpleLimbahJenis').val();
  var limperiode = $('#txtSimplePeriode').val();
  if (limjenis == '' || limperiode == '') {
    alert("data masih kosong !!");
  }else{
    $.ajax({
        type : 'POST',
        url  : baseurl+"WasteManagement/Simple/Create",
        data : {jenis : limjenis, periode : limperiode},
        success : function(e){
          window.location = baseurl+"WasteManagement/Simple";
        }
    });
  }
});

$(document).on('click','#btnCloseSimple',function(e){
  $('#Simple-Create').modal("hide");
});
