$(document).ready(function(){
  $(".subinv").select2({
    placeholder: 'Pilih Subinventory',
    // minimumInputLength: 2,
    allowClear: true,
    ajax: {
      url: baseurl + "HistoryBppbg/Monitoring/getSubinv",
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

  $(".item").select2({
    placeholder: 'Pilih Item',
    minimumInputLength: 3,
    allowClear: true,
    ajax: {
      url: baseurl + "HistoryBppbg/Monitoring/getItem",
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
                return {id:obj.SEGMENT1, text: '[ ' + obj.SEGMENT1 + ' ] ' + obj.DESCRIPTION};
            })                      
        };
      }
    }
  });
});

$('#bppbg').on("keypress",function(e){
    if (e.keyCode == 13) {
        return false;
    }
}); 

function cekBppbgHB(th) {
  var bppbg = $('#bppbg').val();
  // console.log(bppbg);

  var request = $.ajax({
    url: baseurl + 'HistoryBppbg/View/getData',
    data: {
        bppbg  : bppbg
    },
    type: "POST",
    datatype: 'html'
  });

  $('#tb_view').html('');
  $('#tb_view').html('<center><img style="width:70px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
  request.done(function(result){
    // console.log(result);
    $('#tb_view').html(result);
  })
}

function cari(){
  var subinv = $('#slcSubinv option:selected').val();
  var item = $('#slcItem option:selected').val();
  var status = $('#slcStatus option:selected').val();
  console.log(status + ' ' + item + ' ' + subinv);

  if (subinv == '') {
    Swal.fire(
      'Oops!',
      'Subinventory tidak boleh kosong!!!',
      'error'
    )
  }
  else {
    ajax = $.ajax({
      url: baseurl + 'HistoryBppbg/Monitoring/getDataMonitoring',
      data: {
        subinv : subinv,
        item : item,
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
}

function detailBon(bon) {
  var item = $('#slcItem option:selected').val();
  console.log(bon);


  $.ajax({
    url: baseurl + 'HistoryBppbg/Monitoring/getData',
    type: 'POST',
    data: {
      bon: bon,
      item : item
    },
    beforeSend: function() {
      $('#loadingAreaDetail').show();
      $('div#tb_detail').hide();
    },
    success: function(result) {
      $('#loadingAreaDetail').hide();
      $('div#tb_detail').show();
      $('div#tb_detail').html(result);

      $('#noBon').html(bon);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}