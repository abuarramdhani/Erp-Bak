$(document).ready(function(){
  $(".subinv").select2({
    placeholder: 'Pilih Subinventory',
    // minimumInputLength: 2,
    allowClear: true,
    ajax: {
      url: baseurl + "MonitoringPendingTrx/Monitoring/getSubinv",
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
                return {id:obj.SUBINV, text:obj.SUBINV};
            })                      
        };
      }
    }
  });

  $(".loc").select2({
    placeholder: 'Pilih Locator',
    // minimumInputLength: 2,
    allowClear: true,
    ajax: {
      url: baseurl + "MonitoringPendingTrx/Monitoring/getLocator",
      dataType: 'json',
      type: "GET",
      data: function (params) {
        var queryParameters = {
            term: params.term,
            subinv: $('#slcSubinv option:selected').val()
        }
        return queryParameters;
      },
      processResults: function (data) {
      // console.log(data);
        return {
            results: $.map(data, function (obj) {
                return {id:obj.INVENTORY_LOCATION_ID, text:obj.SEGMENT1};
            })                      
        };
      }
    }
  });
});

$('#slcSubinv').on("select2:select", function(e) {
  var subinv = $('#slcSubinv option:selected').val();
  ajax = $.ajax({
    url: baseurl + 'MonitoringPendingTrx/Monitoring/checkLocator',
    data: {
      subinv: subinv
    },
    type: 'POST',
    beforeSend: function() {
    },
    success: function(result) {
      console.log(result[0]);
      if (result[0] > 0) {
        $('#slcLoc').removeAttr('disabled');
      }
      else {
        $("#slcLoc").select2("val", "");
        $('#slcLoc').attr('disabled',true);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
});


function cariPending(){
  var subinv = $('#slcSubinv option:selected').val();
  var loc = $('#slcLoc option:selected').val();
  var loc2 = $('#slcLoc option:selected').html();

  if (loc == undefined) {
    loc = '';
  }
  console.log(subinv+' '+loc);

  if (subinv == '') {
    Swal.fire(
      'Oops!',
      'Subinv belum dipilih!!!',
      'error'
    )
  }
  else {
    ajax = $.ajax({
      url: baseurl + 'MonitoringPendingTrx/Monitoring/getDataMonitoring',
      data: {
        subinv : subinv,
        loc : loc,
        loc2 : loc2
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
}

function detailData(req,jenis) {
  $.ajax({
    url: baseurl + 'MonitoringPendingTrx/Monitoring/getDetailMonitoring',
    type: 'POST',
    data: {
      req : req
    },
    beforeSend: function() {
      $('#loadingAreaDetail').show();
      $('div#tb_detail').hide();
    },
    success: function(result) {
      $('#loadingAreaDetail').hide();
      $('div#tb_detail').show();
      $('div#tb_detail').html(result);

      $('#noReq').html(req);
      $('#jenisDoc').html(jenis);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}