$(document).ready(function() {
  $('#txtPeriodeCheck').datepicker({
    autoclose: true,
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years"
  });
  
	//DATEPICKER CHECK DATA
	$('.periode_mutasi').daterangepicker({
		"singleDatePicker": true,
		"timePicker": false,
		"timePicker24Hour": true,
		"showDropdowns": false,
		autoUpdateInput: false,
		locale: {
			cancelLabel: 'Clear'
		}
	});

	$('.periode_mutasi').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('MM/DD/YYYY'));
	});

	$('.periode_mutasi').on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
	});

  $('#txtPeriodeHitung').datepicker({
    autoclose: true,
    format: "mm/yyyy",
    viewMode: "months", 
    minViewMode: "months"
  });
  
  $('#txtPeriodeSearch').datepicker({
    autoclose: true,
    format: "mm/yyyy",
    viewMode: "months", 
    minViewMode: "months"
  });

  $('#txtPeriodeTahun').datepicker({
    autoclose: true,
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years"
  });

  $('#txtTglBerlakuPtkp').datepicker({ 
	autoclose: true,
	format: "yyyy-mm-dd",
 });
 $('#txtPeriodePengurangPajak').datepicker({ 
	autoclose: true,
	format: "yyyy-mm-dd",
 });
 $('#txtTglPengajuan').datepicker({ 
	autoclose: true,
	format: "yyyy-mm-dd",
 });
 $('.datepicker-erp-pr').datepicker({ 
	autoclose: true,
	format: "dd/mm/yyyy",
 });
  $('#txtPeriodeJst_new').datepicker({ 
	autoclose: true,
	format: "yyyy-mm-dd",
 });
 
   $('#txtPotTambLain').datepicker({ 
	autoclose: true,
	format: "yyyy-mm-dd",
 });
  $('#cmbKdBank').select2();
  $('.select2-txtDept').select2();
  $('.select2-txtBank').select2();
  $('#txtKodeStatusKerja').select2();
  $('#cmbKdHubunganKerja').select2();
  $('#cmbKdStatusKerja').select2();
  $('#cmbKdJabatan').select2();
  $('#cmbStat').select2({
	 minimumResultsForSearch: -1
  });
  $('#cmbIdLokasiKerja').select2();
  $('.select2-getNoind').select2({
    placeholder: "No Induk",
    allowClear: true,
    minimumInputLength: 2,
    ajax: {   
      url:baseurl+"PayrollManagement/HutangKaryawan/getNoind",
      dataType: 'json',
      type: "GET",
      data: function (params) {
        var queryParameters = {
          term: params.term
        }
        return queryParameters;
      },
      processResults: function (data) {
        return {
          results: $.map(data, function(obj) {
            return { id:obj.noind, text:obj.noind+' - '+obj.nama};
          })
        };
      }
    }
  });
  
  $('.money').mask('000,000,000,000,000', {reverse: true});
  
  $(".cmbNoindHeader").select2({
      minimumInputLength: 3,
      ajax: {   
        url:baseurl+"PayrollManagement/MasterPekerja/getNoind",
        dataType: 'json',
        type: "GET",
		placeholder: "[ Noind Pekerja ]",
        data: function (params) {
          var queryParameters = {
            term: params.term,
          }
          return queryParameters;
        },
        processResults: function (data) {
          return {
            results: $.map(data, function(obj) {
              return { id:obj.noind, text:obj.noind+' - '+obj.nama};
            })
          };
        }
      } 
    });
});

	var base = window.location.origin;
	var path = window.location.pathname.split( '/' );
	var baseURL = base+"/"+path[1]+"/";
	var ses_id = $('#txtSessionId').text();
	var timer;

    // $(document).ready(function(){
			// $.ajax({url: baseURL+"PayrollManagement/process"});
			// timer = window.setInterval(function(){refreshProgress()}, 1000);
    // });
	
    // function refreshProgress() {
      // $.ajax({
        // url: baseURL+"PayrollManagement/check?file="+ses_id,
		// dataType: 'json',
        // success:function(data){
			// console.log(data);
          // $("#progress").html('<div class="bar" style="width:'+data.percent+'%">'+data.message+'</div>');
		  // console.log(data.percent);
          // if (data.percent == 100) {
            // window.clearInterval(timer);
            // timer = window.setInterval(function(){completed()}, 1000);
          // }
        // }
      // });
    // }

    // function completed() {
      // $(".bar").html("Completed");
      // window.clearInterval(timer);
    // }

//INCREMENT FORM
	$('.increment-form').TouchSpin({
      verticalbuttons: true,
      verticalupclass: 'glyphicon glyphicon-plus',
      verticaldownclass: 'glyphicon glyphicon-minus'
    });

  $('#dataTables-masterStatusKerja').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
	$('#dataTables-riwayatPotDanaPensiun').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
	$('#dataTables-riwayatUpamk').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
	$('#dataTables-riwayatInsentifKemahalan').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
$('#dataTables-MasterJabatanUpah').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
$('#dataTables-masterJabatan').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

	$('#dataTables-masterSeksi').DataTable( {
	  "destroy": true,
	  "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-kantorAsal').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	$('#dataTables-riwayatGaji').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-lokasiKerja').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-masterBankInduk').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-masterBank').DataTable({
	  "destroy": true,
	  dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
	});
$('#dataTables-masterSekolahAsal').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
$('#dataTables-setgajiump').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-settarifpekerjasakit').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
$('#dataTables-standartJamTkpw').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-standartJamUmum').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-masterParamBpjs').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
$('#dataTables-masterParamPtkp').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
$('#dataTables-masterParameterTarifPph').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	

$('#dataTables-riwayatPenerimaKonpensasiLembur').DataTable( {
	  "destroy": true,
	  "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
$('#dataTables-masterParamKompJab').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
$('#dataTables-riwayatRekeningPekerja').DataTable( {
	  "destroy": true,
  dom: 'Bfrtip',
  buttons: [
	'excel'
  ]
});

$('#dataTables-masterParamPengurangPajak').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
$('#dataTables-transaksiPenggajian').DataTable( {
	  "destroy": true,
	  "scrollX": true,
  dom: 'Bfrtip',
  "autoWidth": true,
  buttons: [
	'excel'
  ]
});

$('#dataTables-konpensasiLembur').DataTable( {
	  "destroy": true,
	  "scrollX": true,
  dom: 'Bfrtip',
  "autoWidth": true,
  buttons: [
	'excel'
  ]
});
	
	
$('#dataTables-masterPekerja').DataTable( {
	  "destroy": true,
	  "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-riwayatSetAsuransi').DataTable( {
	  "destroy": true,
	  "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });	

$('#dataTables-masterParamKompUmum').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-riwayatParamKoperasi').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });
	
$('#dataTables-transaksiKlaimSisaCuti').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-transaksiHitungThr').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
	  "autoWidth": true,
      "scrollX": true,
      buttons: [
        'excel'
      ]
    });

$('#dataTables-transaksiHitungThrImport').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-kompTamb-lain').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ],
	  "columnDefs": [
							{ className: "text-center", "targets": [ 0 ] },
							{ className: "text-center", "targets": [ 1 ] },
							{ className: "text-center", "targets": [ 2 ] },
							{ className: "text-center", "targets": [ 3 ] },
							{ className: "text-right", "targets": [ 4 ] },
							{ className: "text-right", "targets": [ 5 ] }
							
						]
    });
	
$('#dataTables-kompTamb').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ],
	  "columnDefs": [
							{ className: "text-center", "targets": [ 0 ] },
							{ className: "text-center", "targets": [ 1 ] },
							{ className: "text-center", "targets": [ 2 ] },
							{ className: "text-center", "targets": [ 3 ] },
							{ className: "text-right", "targets": [ 4 ] },
							{ className: "text-center", "targets": [ 5 ] }
							
						]
    });
	
$('#dataTables-transaksiHutang').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ],
	  "columnDefs": [
							{ className: "text-center", "targets": [ 0 ] },
							{ className: "text-center", "targets": [ 1 ] },
							{ className: "text-center", "targets": [ 2 ] },
							{ className: "text-center", "targets": [ 3 ] },
							{ className: "text-center", "targets": [ 4 ] },
							{ className: "text-center", "targets": [ 5 ] },
							{ className: "text-right", "targets": [ 6 ] },
							{ className: "text-center", "targets": [ 7 ] }
							
						]
    });
	
$('#dataTables-transaksiHutang-list').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ],
	  "columnDefs": [
							{ className: "text-center", "targets": [ 0 ] },
							{ className: "text-center", "targets": [ 1 ] },
							{ className: "text-center", "targets": [ 2 ] },
							{ className: "text-right", "targets": [ 3 ] },
							{ className: "text-center", "targets": [ 4 ] }
							
						]
    });

$('#dataTables-daftarPekerjaSakit').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-dataGajianPersonalia').DataTable( {
	  "destroy": true,
	  "scrollX" : true,
      dom: 'Bfrtip',
      buttons: [
        'excel','pdf'
      ]
    });

$('#dataTables-transaksiKlaimDl').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-hutangKaryawan').DataTable( {
	  "destroy": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-reportMasterGaji').DataTable( {
	  "destroy": true,
	  "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-reportDanaPensiun').DataTable( {
    "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-reportPotonganKoperasi').DataTable( {
    "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-reportPotonganSPSI').DataTable( {
    "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

$('#dataTables-reportRiwayatMutasi').DataTable( {
    "scrollX": true,
	"bRetrieve": true,
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ]
    });

function getMaxHutang(noind){
  $.ajax({
    type:'POST',
    data:{noind: noind},
    url:baseurl+"PayrollManagement/HutangKaryawan/getMaxHutang",
    success:function(result)
    {
      $('#txtTotalHutang').attr("placeholder",result);
      $('#txtTotalHutang').attr("max",result);
      $('#max-hutang').text("* Max 2x Gaji Pokok ("+result+")");
	  
	  if(result == 0){
		  $('#save_hutang').attr('disabled','disabled');
	  }else{
		  $('#save_hutang').removeattr('disabled','disabled');
	  }
    }
  });
}

function getKlaimCuti(){
	var noind	= $("#txtNoind option:selected").val();
	var period	= $("#txtPeriodeHitung").val();
	var cuti	    = $("#txtSisaCuti").val();
	if(noind.length > 0 && period.length > 0 && cuti.length > 0){
		 $.ajax({
			type:'POST',
			data:{noind: noind, period:period, cuti:cuti},
			url:baseurl+"PayrollManagement/TransaksiKlaimSisaCuti/getKlaimCuti",
			success:function(result)
			{
			  $('#txtJumlahKlaim').val(result);
			}
		  });
	}
}

$('input.number').keyup(function(event) {
		  // format number
  $(this).val(function(index, value) {
	return value
	.replace(/\D/g, "")
	.replace(/\B(?=(\d{3})+(?!\d))/g, ".")
	;
  });
});

$('.currency').onload(function(event) {
		  // format number
  $(this).val(function(index, value) {
	return value
	.replace(/\D/g, "")
	.replace(/\B(?=(\d{3})+(?!\d))/g, ".")
	;
  });
});
		
		
$(document).ready(function() {
  // alert('working');
  $('.datatables').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'excel'
        ],
        "scrollX": true,
        responsive: true,
      });


  $('#tblKondite').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'excel'
        ],
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        responsive: true,
        "ajax":{
          url : baseurl+"PayrollManagementNonStaff/ProsesGaji/Kondite/showList",
          type: "post",
          error: function(){
            //$("#tblKondite").append('<tbody class="text-center"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
            //$("#tblKondite_processing").css("display","none");
          }
        }
      });

  $('#tblDataAbsensi').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'excel'
        ],
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        responsive: true,
        "ajax":{
          url : baseurl+"PayrollManagementNonStaff/ProsesGaji/DataAbsensi/showList",
          type: "post",
          error: function(){
            //$("#tblDataAbsensi").append('<tbody class="text-center"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
            //$("#tblDataAbsensi_processing").css("display","none");
          }
        }
      });

  $('#tblDataLKHSeksi').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'excel'
        ],
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        responsive: true,
        "ajax":{
          url : baseurl+"PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/showList",
          type: "post",
          error: function(){
            //$("#tblDataLKHSeksi").append('<tbody class="text-center"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
            //$("#tblDataLKHSeksi_processing").css("display","none");
          }
        }
      });

  $('#tblTambahan').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'excel'
        ],
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        responsive: true,
        "ajax":{
          url : baseurl+"PayrollManagementNonStaff/ProsesGaji/Tambahan/showList",
          type: "post",
          error: function(){
            //$("#tblDataLKHSeksi").append('<tbody class="text-center"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
            //$("#tblDataLKHSeksi_processing").css("display","none");
          }
        }
      });

  $('#tblPotongan').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'excel'
        ],
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        responsive: true,
        "ajax":{
          url : baseurl+"PayrollManagementNonStaff/ProsesGaji/Potongan/showList",
          type: "post",
          error: function(){
            //$("#tblDataLKHSeksi").append('<tbody class="text-center"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
            //$("#tblDataLKHSeksi_processing").css("display","none");
          }
        }
      });

  $('#tblTargetBenda').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'excel'
        ],
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        responsive: true,
        "ajax":{
          url : baseurl+"PayrollManagementNonStaff/MasterData/TargetBenda/showList",
          type: "post",
          error: function(){
            //$("#tblDataLKHSeksi").append('<tbody class="text-center"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
            //$("#tblDataLKHSeksi_processing").css("display","none");
          }
        }
      });

  $('#tblMasterPekerja').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'excel'
        ],
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        responsive: true,
        "ajax":{
          url : baseurl+"PayrollManagementNonStaff/MasterData/MasterPekerja/showList",
          type: "post",
          error: function(){
            //$("#tblDataLKHSeksi").append('<tbody class="text-center"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
            //$("#tblDataLKHSeksi_processing").css("display","none");
          }
        }
      });

  $('#tblMasterGaji').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'excel'
        ],
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        responsive: true,
        "ajax":{
          url : baseurl+"PayrollManagementNonStaff/MasterData/DataGaji/showList",
          type: "post",
          error: function(){
            //$("#tblDataLKHSeksi").append('<tbody class="text-center"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
            //$("#tblDataLKHSeksi_processing").css("display","none");
          }
        }
      });

  $('#tblHasilGaji').DataTable( {
        dom: 'Bfrtip',
        buttons: [
          'excel'
        ],
        fixedColumns:{
            leftColumns: 5
        },
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        responsive: true,
        "ajax":{
          url : baseurl+"PayrollManagementNonStaff/ProsesGaji/HitungGaji/showList",
          type: "post",
          error: function(){
            //$("#tblDataLKHSeksi").append('<tbody class="text-center"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
            //$("#tblDataLKHSeksi_processing").css("display","none");
          }
        }
      });

  $('#btnCheckServer').click(function(){
    $(this).prop('disabled', true);
    $('#server-status').html('<i class="fa fa-spinner fa-2x faa-spin animated" style="color: #3c8dbc"></i>');
    $.ajax({
        url:baseurl+"PayrollManagementNonStaff/ProsesGaji/DataAbsensi/check_server",
        success:function(result)
        {
          if (result == 1) {
            $('#server-status').html('<i class="fa fa-check fa-2x faa-flash animated" style="color: green"></i>');
          }
          else{
            $('#server-status').html('<i class="fa fa-times fa-2x faa-flash animated" style="color: red"></i>');
          }
          $('#btnCheckServer').prop('disabled', false);
        },
        error:function()
        {
          $('#server-status').html('<i class="fa fa-times fa-2x faa-flash animated" style="color: red"></i>');
          $('#btnCheckServer').prop('disabled', false);
        }
      });
  });

  date_picker_non_staff();
  function date_picker_non_staff(){
    $('.date-picker-pr-non-staf').daterangepicker({
      "singleDatePicker": true,
      //"autoApply": true,
      "timePicker": false,
      "timePicker24Hour": false,
      "showDropdowns": false,
      locale: {
          format: 'YYYY-MM-DD'
        },
    });
  }

  date_picker_non_staff_with_time();
  function date_picker_non_staff_with_time(){
    $('.date-picker-pr-non-staf-with-time').daterangepicker({
      "singleDatePicker": true,
      //"autoApply": true,
      "timePicker": true,
      "timePicker24Hour": true,
      "showDropdowns": false,
      locale: {
          format: 'YYYY-MM-DD HH:mm:HH:mm:ss'
        },
    });
  }
  
  cmbKodesie();
  function cmbKodesie(){
    $(".cmbKodesie").select2({
      minimumInputLength: 3,
      ajax: {   
        url:baseurl+"PayrollManagementNonStaff/getKodesie",
        dataType: 'json',
        type: "GET",
        data: function (params) {
          var queryParameters = {
            term: params.term,
          }
          return queryParameters;
        },
        processResults: function (data) {
          return {
            results: $.map(data, function(obj) {
              return { id:obj.Kodesie, text:obj.Kodesie+' - '+obj.Seksi};
            })
          };
        }
      } 
    });
  }

  $('#btnCetakForm').click(function(){
    var noind = $('#cmbNoindHeader').val();
    var tgl1  = $('#txtTanggal1').val();
    var tgl2  = $('#txtTanggal2').val();

    var form = '';
    if (tgl1 > tgl2) {
      form += '<tr>'
            +   '<td colspan="8" class="text-center"><h4>End Date Must Be Greater Than Start Date</h4></td>'
            + '</tr>';
    }
    else{
      $('#cmbKodesie-loading').html('<i class="fa fa-spinner fa-2x faa-spin animated" style="color: #3c8dbc"></i>'); // spinner
      $.ajax({
        type:'POST',
        data:{noind:noind, tgl1:tgl1, tgl2:tgl2},
        url:baseurl+"PayrollManagementNonStaff/ProsesGaji/Kondite/getTglShift",
        success:function(result)
        {
          $('#FormWrapper').html(result);
        },
        error:function()
        {
          var form = '';
          form += '<tr>'
              +   '<td colspan="8" class="text-center"><h4>Something Error, Please try again</h4></td>'
              + '</tr>';
          $('#FormWrapper').html(form);
        }
      });
      // while(tgl1 <= tgl2){
      //   var day = ("0" + tgl1.getDate()).slice(-2);
      //   var month = ("0" + (tgl1.getMonth() + 1)).slice(-2);
      //   var year = tgl1.getFullYear();
      //   var full_date = year + '-' + month + '-' + day;
      //   form += '<tr>'
      //         +   '<td width="30%" class="text-center">'
      //         +     full_date
      //         +     '<input type="hidden" class="form-control" name="txtTanggalHeader[]" value="' + full_date + '" required>'
      //         +   '</td>'
      //         +   '<td width="7%"><input type="text" class="form-control text-center" name="txtMKHeader[]" placeholder="MK" required></td>'
      //         +   '<td width="7%"><input type="text" class="form-control text-center" name="txtBKIHeader[]" placeholder="BKI" required></td>'
      //         +   '<td width="7%"><input type="text" class="form-control text-center" name="txtBKPHeader[]" placeholder="BKP" required></td>'
      //         +   '<td width="7%"><input type="text" class="form-control text-center" name="txtTKPHeader[]" placeholder="TKP" required></td>'
      //         +   '<td width="7%"><input type="text" class="form-control text-center" name="txtKBHeader[]" placeholder="KB" required></td>'
      //         +   '<td width="7%"><input type="text" class="form-control text-center" name="txtKKHeader[]" placeholder="KK" required></td>'
      //         +   '<td width="7%"><input type="text" class="form-control text-center" name="txtKSHeader[]" placeholder="KS" required></td>'
      //         + '</tr>';

      //   var newDate = tgl1.setDate(tgl1.getDate() + 1);
      //   tgl1 = new Date(newDate);
      // }
    }
    // $('#FormWrapper').html(form);
    date_picker_non_staff();
    date_picker_non_staff_with_time();

    $('.approval').change(function(){
      var val = $(this).val();
      if (val == '1') {
        $(this).closest('tr').find('.approval-date').prop('readonly', false);
        $(this).closest('tr').find('.approval-by').prop('readonly', false);
      }
      else{
        $(this).closest('tr').find('.approval-date').prop('readonly', true);
        $(this).closest('tr').find('.approval-by').prop('readonly', true);
      }
    });

  })

  $('#cmbKodesie, #txtTanggal').change(function(){
    var val = $('#cmbKodesie').val();
    var tgl = $('#txtTanggal').val();
    $('#cmbKodesie').prop('disabled', true);
    $('#cmbKodesie-loading').html('<i class="fa fa-spinner fa-2x faa-spin animated" style="color: #3c8dbc"></i>');
    $.ajax({
      type:'POST',
      data:{kodesie:val,
            date:tgl,
      },
      url:baseurl+"PayrollManagementNonStaff/ProsesGaji/Kondite/getPekerja",
      success:function(result)
      {
        $('#FormWrapper').html(result);
        $('#cmbKodesie').prop('disabled', false);
        $('#cmbKodesie-loading').html('');
      },
      error:function()
      {
        var form = '';
        form += '<tr>'
            +   '<td colspan="8" class="text-center"><h4>Something Error, Please try again</h4></td>'
            + '</tr>';
        $('#FormWrapper').html(form);
        $('#cmbKodesie').prop('disabled', false);
        $('#cmbKodesie-loading').html('');
      }
    });
  })

  $('#btnImportDataAbsensi').click(function(){
    var loading_full =  '<div class="pace pace-active">'+
                        ' <div class="pace-progress" style="height:100px;width:80px" data-progress="100">'+
                        '  <div class="pace-progress-inner">'+
                        '  </div>'+
                        ' </div>'+
                        ' <div class="pace-activity">'+
                        ' </div>'+
                        '</div>';

    var file = $('input[name="file"]').val();
    var bulan = $('select[name="slcBulan"]').val();
    var tahun = $('input[name="txtTahun"]').val();

    $('#errorImportData').html('');
    $('#btnImportDataAbsensi').prop('disabled', true);

    if (file == '' || bulan == '' || tahun == '') {
      $('#errorImportData').html('<b style="color: red">Data belum lengkap</b>');
      $('#btnImportDataAbsensi').prop('disabled', false);
    }
    else{
      $('body').addClass('noscroll');
      $('#loadingAjax').addClass('overlay_loading');
      $('#loadingAjax').html(loading_full);

      var formDataAbsensi = new FormData($('#ImportDataAbsensi')[0]);

      //Import Request
      $.ajax({
        type:'POST',
        data:formDataAbsensi,
        url:$('#ImportDataAbsensi').attr('action'),
        success:function(result)
        {
          $('#errorImportData').html('<b style="color: #3c8dbc">Import Data Berhasil</b>');
          $('input[name="file_path"]').val('');
          $('input[name="file"]').val('');
          $('select[name="slcBulan"]').select2('val', null);
          $('input[name="txtTahun"]').val('');
          $('#btnImportDataAbsensi').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        error:function()
        {
          $('#errorImportData').html('<b style="color: red">Terjadi Kesalahan</b>');
          $('#btnImportDataAbsensi').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        contentType: false,
        processData: false
      });
    }
  });

  $('#btnPreClearData').click(function(){
    var loading_full =  '<div class="pace pace-active">'+
                        ' <div class="pace-progress" style="height:100px;width:80px" data-progress="100">'+
                        '  <div class="pace-progress-inner">'+
                        '  </div>'+
                        ' </div>'+
                        ' <div class="pace-activity">'+
                        ' </div>'+
                        '</div>';
    var bulan = $('select[name="slcBulan"]').val();
    var tahun = $('input[name="txtTahun"]').val();

    $('#errorClearData').html('');
    $('#btnPreClearData').prop('disabled', true);
    
    if (bulan == '' || tahun == '') {
      $('#errorClearData').html('<b style="color: red">Data belum lengkap</b>');
      $('#btnPreClearData').prop('disabled', false);
    }
    else{
      $('#btnPreClearData').prop('disabled', false);

      $('#clear-alert').modal();
      $('#btnClearData').click(function(){
        $('#clear-alert').modal('hide');
        $('#btnClearData').prop('disabled', true);

        $('body').addClass('noscroll');
        $('#loadingAjax').addClass('overlay_loading');
        $('#loadingAjax').html(loading_full);

        //Import Request
        $.ajax({
          type:'POST',
          data:$('#clearData').serialize(),
          url:$('#clearData').attr('action'),
          success:function(result)
          {
            $('#errorClearData').html('<b style="color: #3c8dbc">Hapus Data Berhasil</b>');
            $('input[name="file_path"]').val('');
            $('input[name="file"]').val('');
            $('select[name="slcBulan"]').select2('val', null);
            $('input[name="txtTahun"]').val('');
            $('#btnClearData').prop('disabled', false);

            $('body').removeClass('noscroll');
            $('#loadingAjax').html('');
            $('#loadingAjax').removeClass('overlay_loading');
          },
          error:function()
          {
            $('#errorClearData').html('<b style="color: red">Terjadi Kesalahan</b>');
            $('#btnClearData').prop('disabled', false);

            $('body').removeClass('noscroll');
            $('#loadingAjax').html('');
            $('#loadingAjax').removeClass('overlay_loading');
          }
        });
      });
    }
  });

  $('#btnImportDataLKH').click(function(){
    var loading_full =  '<div class="pace pace-active">'+
                        ' <div class="pace-progress" style="height:100px;width:80px" data-progress="100">'+
                        '  <div class="pace-progress-inner">'+
                        '  </div>'+
                        ' </div>'+
                        ' <div class="pace-activity">'+
                        ' </div>'+
                        '</div>';

    var file = $('input[name="file"]').val();
    var bulan = $('select[name="slcBulan"]').val();
    var tahun = $('input[name="txtTahun"]').val();

    $('#errorImportData').html('');
    $('#btnImportDataLKH').prop('disabled', true);

    if (file == '' || bulan == '' || tahun == '') {
      $('#errorImportData').html('<b style="color: red">Data belum lengkap</b>');
      $('#btnImportDataLKH').prop('disabled', false);
    }
    else{
      $('body').addClass('noscroll');
      $('#loadingAjax').addClass('overlay_loading');
      $('#loadingAjax').html(loading_full);


      var formDataLKH = new FormData($('#ImportDataLKH')[0]);

      //Import Request
      $.ajax({
        type:'POST',
        data:formDataLKH,
        url:$('#ImportDataLKH').attr('action'),
        success:function(result)
        {
          $('#errorImportData').html('<b style="color: #3c8dbc">Import Data Berhasil</b>');
          $('input[name="file_path"]').val('');
          $('input[name="file"]').val('');
          $('select[name="slcBulan"]').select2('val', null);
          $('input[name="txtTahun"]').val('');
          $('#btnImportDataLKH').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        error:function()
        {
          $('#errorImportData').html('<b style="color: red">Terjadi Kesalahan</b>');
          $('#btnImportDataLKH').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        contentType: false,
        processData: false
      });
    }
  });

  $('#btnImportDataKondite').click(function(){
    var loading_full =  '<div class="pace pace-active">'+
                        ' <div class="pace-progress" style="height:100px;width:80px" data-progress="100">'+
                        '  <div class="pace-progress-inner">'+
                        '  </div>'+
                        ' </div>'+
                        ' <div class="pace-activity">'+
                        ' </div>'+
                        '</div>';

    var file = $('input[name="file"]').val();

    $('#errorImportData').html('');
    $('#btnImportDataKondite').prop('disabled', true);

    if (file == '') {
      $('#errorImportData').html('<b style="color: red">Data belum lengkap</b>');
      $('#btnImportDataKondite').prop('disabled', false);
    }
    else{
      $('body').addClass('noscroll');
      $('#loadingAjax').addClass('overlay_loading');
      $('#loadingAjax').html(loading_full);


      var formDataKondite = new FormData($('#ImportDataKondite')[0]);

      //Import Request
      $.ajax({
        type:'POST',
        data:formDataKondite,
        url:$('#ImportDataKondite').attr('action'),
        success:function(result)
        {
          $('#errorImportData').html('<b style="color: #3c8dbc">Import Data Berhasil</b>');
          $('input[name="file_path"]').val('');
          $('input[name="file"]').val('');
          $('#btnImportDataKondite').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        error:function()
        {
          $('#errorImportData').html('<b style="color: red">Terjadi Kesalahan</b>');
          $('#btnImportDataKondite').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        contentType: false,
        processData: false
      });
    }
  });

  $('#btnImportDataPotongan').click(function(){
    var loading_full =  '<div class="pace pace-active">'+
                        ' <div class="pace-progress" style="height:100px;width:80px" data-progress="100">'+
                        '  <div class="pace-progress-inner">'+
                        '  </div>'+
                        ' </div>'+
                        ' <div class="pace-activity">'+
                        ' </div>'+
                        '</div>';

    var file = $('input[name="file"]').val();

    $('#errorImportData').html('');
    $('#btnImportDataPotongan').prop('disabled', true);

    if (file == '') {
      $('#errorImportData').html('<b style="color: red">Data belum lengkap</b>');
      $('#btnImportDataPotongan').prop('disabled', false);
    }
    else{
      $('body').addClass('noscroll');
      $('#loadingAjax').addClass('overlay_loading');
      $('#loadingAjax').html(loading_full);


      var formDataPotongan = new FormData($('#ImportDataPotongan')[0]);

      //Import Request
      $.ajax({
        type:'POST',
        data:formDataPotongan,
        url:$('#ImportDataPotongan').attr('action'),
        success:function(result)
        {
          $('#errorImportData').html('<b style="color: #3c8dbc">Import Data Berhasil</b>');
          $('input[name="file_path"]').val('');
          $('input[name="file"]').val('');
          $('#btnImportDataPotongan').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        error:function()
        {
          $('#errorImportData').html('<b style="color: red">Terjadi Kesalahan</b>');
          $('#btnImportDataPotongan').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        contentType: false,
        processData: false
      });
    }
  });

  $('#btnImportDataTambahan').click(function(){
    var loading_full =  '<div class="pace pace-active">'+
                        ' <div class="pace-progress" style="height:100px;width:80px" data-progress="100">'+
                        '  <div class="pace-progress-inner">'+
                        '  </div>'+
                        ' </div>'+
                        ' <div class="pace-activity">'+
                        ' </div>'+
                        '</div>';

    var file = $('input[name="file"]').val();

    $('#errorImportData').html('');
    $('#btnImportDataTambahan').prop('disabled', true);

    if (file == '') {
      $('#errorImportData').html('<b style="color: red">Data belum lengkap</b>');
      $('#btnImportDataTambahan').prop('disabled', false);
    }
    else{
      $('body').addClass('noscroll');
      $('#loadingAjax').addClass('overlay_loading');
      $('#loadingAjax').html(loading_full);


      var formDataTambahan = new FormData($('#ImportDataTambahan')[0]);

      //Import Request
      $.ajax({
        type:'POST',
        data:formDataTambahan,
        url:$('#ImportDataTambahan').attr('action'),
        success:function(result)
        {
          $('#errorImportData').html('<b style="color: #3c8dbc">Import Data Berhasil</b>');
          $('input[name="file_path"]').val('');
          $('input[name="file"]').val('');
          $('#btnImportDataTambahan').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        error:function()
        {
          $('#errorImportData').html('<b style="color: red">Terjadi Kesalahan</b>');
          $('#btnImportDataTambahan').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        contentType: false,
        processData: false
      });
    }
  });

  hitungGajiTable();
  function hitungGajiTable() {
    $('#tblHitungGaji').DataTable( {
          dom: 'Bfrtip',
          buttons: [
            'excel'
          ],
          "scrollX": true,
          "paging": false
          //scrollCollapse: true,
        });
  }

  $('#btnProsesGaji').click(function(){
    var loading_full =  '<div class="pace pace-active">'+
                        ' <div class="pace-progress" style="height:100px;width:80px" data-progress="100">'+
                        '  <div class="pace-progress-inner">'+
                        '  </div>'+
                        ' </div>'+
                        ' <div class="pace-activity">'+
                        ' </div>'+
                        '</div>';

    var seksi = $('select[name="cmbKodesie"]').val();
    var bulan = $('select[name="cmbBulan"]').val();
    var tahun = $('input[name="txtTahun"]').val();
    var tanggal = $('input[name="txtTglPembayaran"]').val();    

    $("#dbfsection").val(seksi);
    $("#dbfmonth").val(bulan);
    $("#dbfyear").val(tahun);
    $("#dbftanggal").val(tanggal);

    $('#errorProsesGaji').html('');
    $('#btnProsesGaji').prop('disabled', true);
    $('#btnPrintStrukAll').prop('disabled', true);

    if (seksi == '' || bulan == '' || tahun == '') {
      $('#errorProsesGaji').html('<b style="color: red">Data belum lengkap</b>');
      $('#btnProsesGaji').prop('disabled', false);
    }
    else{
      $('body').addClass('noscroll');
      $('#loadingAjax').addClass('overlay_loading');
      $('#loadingAjax').html(loading_full);

      //Hitung Request
      $.ajax({
        type:'POST',
        data:$('#ProsesGajiForm').serialize(),
        url:$('#ProsesGajiForm').attr('action'),
        success:function(result)
        {
          $('#errorProsesGaji').html('<b style="color: #3c8dbc">Hitung Gaji Berhasil</b>');
          $('#tblHitungGaji').DataTable().destroy();
          $('#prosesGaji').html(result);
          hitungGajiTable();
          //hitungGajiTable.destroy();
          // $('select[name="cmbKodesie"]').select2('val', null);
          // $('select[name="cmbBulan"]').select2('val', null);
          // $('input[name="txtTahun"]').val('');
          $('#btnProsesGaji').prop('disabled', false);
          if (result != '') {
            $('#btnPrintStrukAll').prop('disabled', false);
          }

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        error:function()
        {
          $('#errorProsesGaji').html('<b style="color: red">Terjadi Kesalahan</b>');
          $('#btnProsesGaji').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        }
      });
    }
  });

  $('#btnImportDataTarget').click(function(){
    var loading_full =  '<div class="pace pace-active">'+
                        ' <div class="pace-progress" style="height:100px;width:80px" data-progress="100">'+
                        '  <div class="pace-progress-inner">'+
                        '  </div>'+
                        ' </div>'+
                        ' <div class="pace-activity">'+
                        ' </div>'+
                        '</div>';

    var file = $('input[name="file"]').val();

    $('#errorImportData').html('');
    $('#btnImportDataTarget').prop('disabled', true);

    if (file == '') {
      $('#errorImportData').html('<b style="color: red">Data belum lengkap</b>');
      $('#btnImportDataTarget').prop('disabled', false);
    }
    else{
      $('body').addClass('noscroll');
      $('#loadingAjax').addClass('overlay_loading');
      $('#loadingAjax').html(loading_full);


      var formDataLKH = new FormData($('#ImportDataTarget')[0]);

      //Import Request
      $.ajax({
        type:'POST',
        data:formDataLKH,
        url:$('#ImportDataTarget').attr('action'),
        success:function(result)
        {
          $('#errorImportData').html('<b style="color: #3c8dbc">Import Data Berhasil</b>');
          $('input[name="file_path"]').val('');
          $('input[name="file"]').val('');
          $('#btnImportDataTarget').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        error:function()
        {
          $('#errorImportData').html('<b style="color: red">Terjadi Kesalahan</b>');
          $('#btnImportDataTarget').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        contentType: false,
        processData: false
      });
    }
  });

  $('#btnImportDataGaji').click(function(){
    var loading_full =  '<div class="pace pace-active">'+
                        ' <div class="pace-progress" style="height:100px;width:80px" data-progress="100">'+
                        '  <div class="pace-progress-inner">'+
                        '  </div>'+
                        ' </div>'+
                        ' <div class="pace-activity">'+
                        ' </div>'+
                        '</div>';

    var file = $('input[name="file"]').val();

    $('#errorImportData').html('');
    $('#btnImportDataGaji').prop('disabled', true);

    if (file == '') {
      $('#errorImportData').html('<b style="color: red">Data belum lengkap</b>');
      $('#btnImportDataGaji').prop('disabled', false);
    }
    else{
      $('body').addClass('noscroll');
      $('#loadingAjax').addClass('overlay_loading');
      $('#loadingAjax').html(loading_full);


      var formDataLKH = new FormData($('#ImportDataGaji')[0]);

      //Import Request
      $.ajax({
        type:'POST',
        data:formDataLKH,
        url:$('#ImportDataGaji').attr('action'),
        success:function(result)
        {
          $('#errorImportData').html('<b style="color: #3c8dbc">Import Data Berhasil</b>');
          $('input[name="file_path"]').val('');
          $('input[name="file"]').val('');
          $('#btnImportDataGaji').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        error:function()
        {
          $('#errorImportData').html('<b style="color: red">Terjadi Kesalahan</b>');
          $('#btnImportDataGaji').prop('disabled', false);

          $('body').removeClass('noscroll');
          $('#loadingAjax').html('');
          $('#loadingAjax').removeClass('overlay_loading');
        },
        contentType: false,
        processData: false
      });
    }
  });

});
