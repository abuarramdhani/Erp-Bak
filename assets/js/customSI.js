$(document).ready(function(){

    $('.textareaKaizen').redactor({
        imageUpload: baseurl+'SystemIntegration/KaizenGenerator/Submit/upload',

        imageUploadErrorCallback: function(json)
        {
            alert(json.error);
        }          
    }); 
$('#txtPertimbangan').redactor({
        imageUpload: baseurl+'SystemIntegration/KaizenGenerator/Submit/upload',

        imageUploadErrorCallback: function(json)
        {
            alert(json.error);
        }          
    });

    $('#txtRencanaRealisasiSI, #txtEndDateSI, #txtStartDateSI ,.datetimeSI').datepicker({
    autoclose: true,
    todayHighlight: true
  });

  // $('#checkKaizenKomp').parent().attr('id', 'chkkkompsi');
  // $('#checkKaizenKomp').closest('div').find('ins').attr('id', 'chkkkompsi2');

  $('input#checkKaizenKomp').on('ifChecked', function (event){
    // return false;
    $(this).closest("input").attr('checked', true); 
    $('.komponenKaizenSI').removeAttr('disabled');         
  });
  $('input#checkKaizenKomp').on('ifUnchecked', function (event) {
      // return false;
      $(this).closest("input").attr('checked', false);
       $('.komponenKaizenSI').attr("disabled","disabled");
      $('.komponenKaizenSI').val(null).trigger('change');
  });

$('input#checkNextApprover').on('ifChecked',function(event){
    $('input#checkNextApprover').attr("checked","checked");
    $('select#slcApprover').removeAttr("disabled");
});

$('input#checkNextApprover').on('ifUnchecked',function(event){
    $('input#checkNextApprover').removeAttr("checked");
    $('select#slcApprover').attr("disabled","disabled");
    $('select#slcApprover').val(null).trigger('change');
});
  $('input#checkRealisasiKai').on('ifChecked', function (event){
    // return false;
    var name  = $(this).attr('data-class');
    $(this).closest("input").attr('checked', 'checked'); 
    $(this).parent().parent().parent().find(".must").removeAttr('disabled');  
    $(this).parent().parent().parent().find(".must").attr('required','required');  
        $('.'+name).redactor({
            imageUpload: baseurl+'SystemIntegration/KaizenGenerator/Submit/upload',

            imageUploadErrorCallback: function(json)
            {
                alert(json.error);
            }          
        });  
    checkFillRealisasi();      
  });
  $('input#checkRealisasiKai').on('ifUnchecked', function (event) {
      var name  = $(this).attr('data-class');
      // return false;
      $(this).closest("input").removeAttr('checked');
      $(this).parent().parent().parent().find(".must").attr("disabled","disabled");
      $(this).parent().parent().parent().find(".must").removeAttr('required');  
      $(this).closest("input.must").val(null).trigger('change');

        $('.'+name).redactor({
            imageUpload: baseurl+'SystemIntegration/KaizenGenerator/Submit/upload',

            imageUploadErrorCallback: function(json)
            {
                alert(json.error);
            }          
        });        
      $('.'+name).redactor('destroy');
      $('.'+name).val('');
      $('.'+name).attr('disabled','disabled');
    checkFillRealisasi();      
  });

    $('.select2si').select2({
     allowClear : true,
     tabindex : false
    });


$('#btnAprroveOkSI').click(function(){
      var id = $(this).attr('data-id');
      var level = $(this).attr('data-level');
      var next = $('#next').val();
      $('#hdnStatus').val(3);
      $('#levelApproval').val(level);
      $('#formReason').attr('action', baseurl+'SystemIntegration/MainMenu/ApprovalKaizen/C_ApprovalKaizen/result/'+id);
        if ((level == '2' || level == '3') && next == 0) {
          $('#btn_result').show();
          $('#btn_result2').hide();
          // $('#btn_result').attr('type','button');
          // $('#btn_result').closest('button').find('b').text('Selanjutnya');
        }else{
          // $('#btn_result').attr('type','submit');
          // $('#btn_result').closest('button').find('b').text('Submit');
          $('#btn_result').hide();
          $('#btn_result2').show();
        }
      $('#modalReason').modal('show');
});

$('#btnAprroveRealSI').click(function(){
      var id = $(this).attr('data-id');
      var level = $(this).attr('data-level');
      $('#hdnStatus').val(3);
      $('#levelApproval').val(level);
      $('#formReason').attr('action', baseurl+'SystemIntegration/MainMenu/ApprovalKaizen/C_ApprovalKaizen/resultRealisasi/'+id);
       $('#modalReason').modal('show');
});

$('#btnAprroveRevSI').click(function(){
      var id = $(this).attr('data-id');
      var level = $(this).attr('data-level');
      $('#hdnStatus').val(4);
      $('#levelApproval').val(level);
      $('#formReason').attr('action', baseurl+'SystemIntegration/MainMenu/ApprovalKaizen/C_ApprovalKaizen/result/'+id);
      // $('#btn_result').attr('type','submit');
      // $('#btn_result').closest('button').find('b').text('Submit');
      $('#btn_result').hide();
      $('#btn_result2').show();
      $('#formNextApprover').hide();
      $('#modalReason').modal('show');
});

$('#btnAprroveNotSI').click(function(){
      var id = $(this).attr('data-id');
      var level = $(this).attr('data-level');
      $('#hdnStatus').val(5);
      $('#levelApproval').val(level);
      $('#formReason').attr('action', baseurl+'SystemIntegration/MainMenu/ApprovalKaizen/C_ApprovalKaizen/result/'+id);
      // $('#btn_result').attr('type','submit');
      // $('#btn_result').closest('button').find('b').text('Submit');
      $('#btn_result').hide();
      $('#btn_result2').show();
      $('#formNextApprover').hide();
      $('#modalReason').modal('show');
});

  $(".tblSIKaizen").DataTable();
  // $("#tblKaizen").DataTable();
  // $("#tblKaizenCheck").DataTable();
  // $("#tblKaizenOkIde").DataTable();
  // $("#tblKaizenOk").DataTable();
  // $("#tblKaizenRevise").DataTable();
  // $("#tblKaizenReject").DataTable();
$(".komponenKaizenSI").select2({
   tags: true,
   allowClear:true,
   minimumInputLength: 3,
   ajax: {
        url: baseurl+"SystemIntegrationKaizenGenerator/Submit/getItem",
        dataType: 'json',
        type: 'get',
        data: function(params){
          return { p: params.term };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function(item) {
              return {
                id: item.INVENTORY_ITEM_ID,
                text: item.SEGMENT1+' -- '+item.ITEM_NAME,
              }
            })
          };
        },
        // cache: true
      },

  });

}); 


$('#rmthreadkai').click(function(){
  $('#threadmorekai').show();
  $('#rmthreadkai').hide();
  $('#rlthreadkai').show();
});

$('#rlthreadkai').click(function(){
  $('#threadmorekai').hide();
  $('#rlthreadkai').hide();
  $('#rmthreadkai').show();
});




$('#btn_result').click(function(){
  var val = $('#txtReason').val();
  $('#formReasonApprover').slideUp('slow');
  $('#formNextApprover').slideDown('slow');
   $('#next').val(1);
  // $('#btn_result').attr('type','submit');
  // $('#btn_result').closest('button').find('b').text('Submit');
   $('#btn_result').hide();
  $('#btn_result2').show();
  $('c').text(val);
});

$('#btn_batal').click(function(){
  $('#formNextApprover').slideUp('slow');
  $('#formReasonApprover').slideDown('slow');
  $('#txtReason').val('');
   $('#next').val(0);
   $('#btn_result2').hide();
   $('#btn_result').show();
});




$('.siSlcTgr').change(function(){
  var type = $('input[name="typeApp"]').val();
  var a = $('select[name="SlcAtasanLangsung"]').val();
  var b = $('select[name="SlcAtasanAtasanLangsung"]').val();
  // var c = $('select[name="SlcAtasanDepartment"]').val();
  var value = [a,b];

  var checkFill = function(val){
    if (type == 1) {
      if ( (a !== "") && (b !== "") && (val == 1) ) {
        $('#subApprSI').removeAttr("disabled");
      }else{
        $('#subApprSI').attr("disabled","disabled");
      };
    }else{
      if (a !== "") {
        $('#subApprSI').removeAttr("disabled");
      }else{
        $('#subApprSI').attr("disabled","disabled");
      }
    }
  }

  var error = function(sel){
    for (var i = 0; i < sel.length; i++) {
      $('.sel'+sel[i]).addClass('has-error');
    }
  }

  if (type == 1) {
      if (typeof a !== typeof undefined && a !== false){
        if ((a == b) && (a !== "" && b !== "") ){
            var select = [1,2];
            $('#subApprSI').attr("disabled","disabled");
            error(select);
            checkFill(0);
          }
          // else if((a == c) && (a !== "" && c !== "")){
          //   var select = [1,3];
          //   error(select);
          //   $('#subApprSI').attr("disabled","disabled");
          //   checkFill(0);
          // }else if((b == c) && (c !== "" && b !== "")){
          //   var select = [2,3];
          //   error(select);
          //   $('#subApprSI').attr("disabled","disabled");
          //   checkFill(0);
          // }else if( ((b == c) && (a == b)) && (a !== "" && b !== "" && c !== "") ){
          //   var select = [1,2,3];
          //   error(select);
          //   $('#subApprSI').attr("disabled","disabled");
          //   checkFill(0);
          // }
          else{
            $('.sel1').removeClass('has-error');
            $('.sel2').removeClass('has-error');
            // $('.sel3').removeClass('has-error');
          $('#subApprSI').removeAttr("disabled");
            checkFill(1);
          }
      }else{
            checkFill(1);
      }

    }else{
      checkFill(0);
    }
});



$('.buttonsi').click(function(){
  $('.custNotifBody').slideToggle('slow');
});


$('input#checkKaizenKomp').on('ifChecked',function(){
  if($(this).is(':checked')){
    $('.komponenKaizenSI').removeAttr('disabled');
  }else{
    $('.komponenKaizenSI').attr("disabled","disabled");
    $('.komponenKaizenSI').val(null).trigger('change');
    // $('.select2-selection__choice').remove();
  }
});

$('#SIlaporkanKai').click(function(){
  var kaizen_id = $(this).attr('data-id');
  var request = $.ajax ({
        url : baseurl+"SystemIntegration/KaizenGenerator/MyKaizen/report",
        data : {
            id: kaizen_id
        },
        type : "POST",
        dataType: "html"
    });
    $(this).parent().html('<img id="dingdingload" src="'+baseurl+'assets/img/gif/spinner.gif">');

    request.done(function(output) {
       $('#dingdingload').parent().html(' <span style="background-color: #f8f9fa" class="label btn-light btn-real-dis" >Laporkan <b class="fa fa-check-circle text-info"></b>'+
                          '</span><br>('+output+')');     
       $('#SIpdf').removeClass('btn-default disabled');          
       $('#SIpdf').addClass('btn-info');          

               
    });
});

$(document).ready(function(){

  if(typeof(realisasiSIpage) != "undefined" && realisasiSIpage !== null) {
      $('.select2').prepend('<div class="disabled-select"></div>');
  }

})

function openTabSI(th, tab){
  $('.tabcontent').hide();
  $('.tablinks').removeClass('active');
  $('#'+tab).show();
  $(th).addClass('active');
}


function getDelDataSI(th){
  var kaizen_id = $(th).attr('data-id');
  var judul = $(th).closest('tr').find('#judul').text();
 $('#deljudul').html('');
 $('#deljudul').append(judul);
 $('#delUrlSI').attr('href', '');
 $('#delUrlSI').attr('href', baseurl+'SystemIntegration/KaizenGenerator/Delete/'+kaizen_id);
}


// function giveValueSIKomp(th){
//    if ($(th).children().hasClass('checked')){
//     $('.komponenKaizenSI').attr("disabled","disabled");
//     $('.komponenKaizenSI').val(null).trigger('change');
//   }else{
//     $('.komponenKaizenSI').removeAttr('disabled');
//   }

// }


function checkFillRealisasi(){
  var Standarisasi  = $('textarea[name="txtNomorWI"]').val();
  var tglsosialisasi = $('input[name="txtTanggalPelaksanaan"]').val();
  var methodSosialisasi = $('textarea[name="txtMetodeSosialisasi"]').val();
  var Standarisasi = $('input[name="chkStandarisasiRealisasi"]').val();
  var Sosialisasi = $('input[name="chkSosialisasiRealisasi"]').val();

  if (($('input[name="chkStandarisasiRealisasi"]').is(':checked')) && ($('input[name="chkSosialisasiRealisasi"]').is(':checked')) ) {
      $("#btnSubmitRealisasi").removeAttr("disabled");
  }else{
      $("#btnSubmitRealisasi").attr("disabled","disabled");
  }

}

