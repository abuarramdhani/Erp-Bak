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

    $('#txtRencanaRealisasiSI, #txtEndDateSI, #txtStartDateSI').datepicker({
    autoclose: true,
    todayHighlight: true
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

  $("#tblKaizen").DataTable();
  $("#tblKaizenCheck").DataTable();
  $("#tblKaizenOkIde").DataTable();
  $("#tblKaizenOk").DataTable();
  $("#tblKaizenRevise").DataTable();
  $("#tblKaizenReject").DataTable();
$(".komponenKaizenSI").select2({
   tags: true,
   // closeOnSelect: false,
   // tokenSeparators: [','],
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
   // templateSelection: function(selection) {
   //      if(selection.selected) {
   //          return $.parseHTML('<span class="customclass">' + selection.text + '</span>');
   //      }
   //      else {
   //          return $.parseHTML('<span class="customclass">' + selection.text + '</span>');
   //      }
   //  }

  });

  // $("#komponenKaizenSI").on("select2:select", function(e) { 
  // $("li[aria-selected='true']").addClass("customclass");
  // $("li[aria-selected='false']").removeClass("customclass");
  // $('.select2-search-choice:not(.my-custom-css)', this).addClass('my-custom-css');
  // });

  // $("#komponenKaizenSI").on("select2:unselect", function(e) { 
  // $("li[aria-selected='false']").removeClass("customclass");
  // });

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

$('#checkNextApprover').click(function(){
  if($('#checkNextApprover').is(':checked')){
    $('#checkNextApprover').closest('div').find('select').removeAttr("disabled");
  }else{
    $('#checkNextApprover').closest('div').find('select').attr("disabled","disabled");
    $('#checkNextApprover').closest('div').find('select').val(null).trigger('change');
  }
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
  var c = $('select[name="SlcAtasanDepartment"]').val();
  var value = [a,b,c];

  var checkFill = function(val){
    if (type == 1) {
      if ( (a !== "") && (b !== "") && (c !== "") && (val == 1) ) {
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
        if ((a == b) && (a !== "" && b !== "") ){
            var select = [1,2];
            $('#subApprSI').attr("disabled","disabled");
            error(select);
            checkFill(0);
          }else if((a == c) && (a !== "" && c !== "")){
            var select = [1,3];
            error(select);
            $('#subApprSI').attr("disabled","disabled");
            checkFill(0);
          }else if((b == c) && (c !== "" && b !== "")){
            var select = [2,3];
            error(select);
            $('#subApprSI').attr("disabled","disabled");
            checkFill(0);
          }else if( ((b == c) && (a == b)) && (a !== "" && b !== "" && c !== "") ){
            var select = [1,2,3];
            error(select);
            $('#subApprSI').attr("disabled","disabled");
            checkFill(0);
          }else{
            $('.sel1').removeClass('has-error');
            $('.sel2').removeClass('has-error');
            $('.sel3').removeClass('has-error');
          $('#subApprSI').removeAttr("disabled");
            checkFill(1);
          }
    }else{
      checkFill(0);
    }
});



$('.buttonsi').click(function(){
  $('.custNotifBody').slideToggle('slow');
});

$('#checkKaizenKomp').change(function(){
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
       $('#dingdingload').parent().html(' <span class="label label-success btn-real-dis" >Laporkan <b class="fa fa-check-circle"></b>'+
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
