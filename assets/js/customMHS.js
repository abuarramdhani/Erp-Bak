$(document).ready(function(){
  $(".jenisSub").select2({
    placeholder: 'Pilih Subkon',
    // minimumInputLength: 2,
    allowClear: true,
    ajax: {
      url: baseurl + "MonitoringHandlingSubkon/Monitoring/getSubkon",
      dataType: 'json',
      type: "GET",
      data: function (params) {
        var queryParameters = {
            term: params.term,
        }
        return queryParameters;
      },
      processResults: function (data) {
      // console.log(data);
        return {
            results: $.map(data, function (obj) {
                return {id:obj.SEGMENT1, text:obj.DESCRIPTION};
            })                      
        };
      }
    }
  });

  $(".jenisHS").select2({
    placeholder: 'Pilih Handling',
    // minimumInputLength: 2,
    allowClear: true,
    ajax: {
      url: baseurl + "MonitoringHandlingSubkon/Monitoring/getHandling",
      dataType: 'json',
      type: "GET",
      data: function (params) {
        var queryParameters = {
            term: params.term,
        }
        return queryParameters;
      },
      processResults: function (data) {
      // console.log(data);
        return {
            results: $.map(data, function (obj) {
                return {id:obj.kode_handling, text:'[ ' + obj.kode_handling + ' ] ' +obj.nama_handling};
            })                      
        };
      }
    }
  });
});


function checkStock(){
  var subkon = $('#slcSubStock option:selected').val();
  var subname = $('#slcSubStock option:selected').html();
  var handling = $('#slcHanStock option:selected').val();

  ajax = $.ajax({
    url: baseurl + 'MonitoringHandlingSubkon/Stock/getDataStock',
    data: {
      subkon : subkon,
      subname : subname,
      handling : handling
    },
    type: 'POST',
    beforeSend: function() {
      $('#loadingArea2').show();
      $('div#tb_stock').hide();
    },
    success: function(result) {
      $('#loadingArea2').hide();       
      $('div#tb_stock').show();
      $('div#tb_stock').html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}


function cariHS(){
  var subkon = $('#slcJenisSub option:selected').val();
  var subname = $('#slcJenisSub option:selected').html();
  var handling = $('#slcHandling option:selected').val();
  var date = $('#slcDateRange').val();
  var status = $('#slcType option:selected').val();

  ajax = $.ajax({
    url: baseurl + 'MonitoringHandlingSubkon/Monitoring/getDataMonitoring',
    data: {
      subkon : subkon,
      subname : subname,
      handling : handling,
      date : date,
      status : status
    },
    type: 'POST',
    beforeSend: function() {
      $('#loadingArea').show();
      $('div#tb_monitoring').hide();
    },
    success: function(result) {
      $('#loadingArea').hide();       
      $('div#tb_monitoring').show();
      $('div#tb_monitoring').html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}


$(function(){
  $('#slcDateRange').daterangepicker({
    "todayHighlight" : true,
    "autoclose": true,
    locale: {
          format: 'DD MMMM YYYY'
        },
  });
  $('#slcDateRange').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('DD MMMM YYYY') + ' - ' + picker.endDate.format('DD MMMM YYYY'));
  });

  $('#slcDateRange').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
  });
});


function cetak(){
  var subkon = $('#slcSubkon option:selected').val();
  console.log(subkon);

  if (subkon == '') {
    Swal.fire(
      'Oops!',
      'Subkon belum dipilih!!!',
      'error'
    )
  }
  else {
    $('#linkCetak').attr('href',baseurl + "MonitoringHandlingSubkon/Cetak/cetakKIS/" + subkon);
  }
}


function editModal(locator,subkon,handling,nama_handling,saldo){
  $('#editSubkon').html(subkon);
  $('#editNamaHandling').html('[ ' + handling + ' ] ' + nama_handling);
  $('#txtEditSaldo').val(saldo);
  $('#editLoc').val(locator);
  $('#editHanId').val(handling);
}

function editSaldo(){
  var qty = $('#txtEditSaldo').val();
  var loc = $('#editLoc').val();
  var handling_code = $('#editHanId').val();

  ajax = $.ajax({
    url: baseurl + 'MonitoringHandlingSubkon/Stock/editSaldoAwal',
    data: {
      qty : qty,
      loc : loc,
      handling_code : handling_code
    },
    type: 'POST',
    beforeSend: function() {
    },
    success: function(result) {
      Swal.fire(
        'Success!',
        'Data berhasil diedit!!!',
        'success'
      );
      $('#editModal').modal('hide');
      checkStock();
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}