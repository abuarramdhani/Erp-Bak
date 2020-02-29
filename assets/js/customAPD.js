$("#group_add").click(function(e){
  var d = new Date();
  var n = d.getDate();
  if (n > 40) {
    // alert('Anda Terlambat Order');
    Swal.fire({
      type: 'error',
      title: 'Anda Terlambat Order!',
      text: 'Order dapat Dilakukan di Tanggal 1 - 10',
      animation: false,
          // showCancelButton: true,
          customClass: {
            popup: 'animated tada'
          }
        });
  }else{
    e.preventDefault();
    $('.apd-select2').last().select2("destroy");
    $('.multiinput').last().clone().appendTo('#tb_InputKebutuhanAPD tbody');
    $("tr:last .form-control").val("").end();
  // var idsekarang = Number($('tr:last input#txtKodeItem').attr('data-id'));
  var nomorr = Number($('#tb_InputKebutuhanAPD tr:last').find('input#txtKodeItem').attr('data-id'));
  // var tez = $('tr:last input#txtKodeItem').attr('data-id');

  nomorr = nomorr+1;
  // alert(nomorr);
  // alert(tez);
  $('#tb_InputKebutuhanAPD tr:last td#nomor').html(nomorr);
  $('#tb_InputKebutuhanAPD tr:last input#txtKodeItem').attr('data-id', nomorr);
  $('.apd-select2').select2({
    ajax:
    {
      url: baseurl+'P2K3_V2/Order/getItem',
      dataType: 'json',
      type: 'get',
      data: function (params) {
        return {s: params.term};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.kode_item,
              text: item.item,
            }
          })
        };
      },
      cache: true
    },
    minimumInputLength: 2,
    placeholder: 'Select Item',
    allowClear: true,
  });
}
});


$(document).on('click', '.group_rem', function(e){
  e.preventDefault();
  if($('.multiinput').size()>1){
    $(this).closest('tr').remove();
  }else{
    alert('Minimal harus ada satu baris tersisa');
  }
});

$("#group_add2").click(function(e){
  var d = new Date();
  var n = d.getDate();
  if (n > 300) {
    alert('Anda Terlambat Order');
    // Swal.fire(
    //   'Error',
    //   'Anda Terlambat Order!',
    //   'error',
    //   )
  }else{
    e.preventDefault();
    $('.apd-select2').last().select2("destroy");
    $('.multiinput').last().clone().appendTo('#tb_InputKebutuhanAPD tbody');
    $("tr:last .form-control").val("").end();
  // var idsekarang = Number($('tr:last input#txtKodeItem').attr('data-id'));
  var nomorr = Number($('#tb_InputKebutuhanAPD tr:last').find('input#txtKodeItem').attr('data-id'));
  // var tez = $('tr:last input#txtKodeItem').attr('data-id');

  nomorr = nomorr+1;
  // alert(nomorr);
  // alert(tez);
  $('#tb_InputKebutuhanAPD tr:last td#nomor').html(nomorr);
  $('#tb_InputKebutuhanAPD tr:last input#txtKodeItem').attr('data-id', nomorr);
  $('.apd-select2').select2({
    ajax:
    {
      url: baseurl+'P2K3_V2/Order/getItem',
      dataType: 'json',
      type: 'get',
      data: function (params) {
        return {s: params.term};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.kode_item,
              text: item.item,
            }
          })
        };
      },
      cache: true
    },
    minimumInputLength: 2,
    placeholder: 'Select Item',
    allowClear: true,
  });
}
});

$(function()
{
  $('.dataTable-p2k3').DataTable({
    dom: 'frtp',
  });

  $('.dataTable-p2k3Frezz').DataTable({
    dom: 'frtp',
    scrollX: true,
    fixedColumns:   {
      leftColumns: 3,
    },
  });

  $('.dataTable-p2k3Frezz4').DataTable({
    dom: 'frtp',
    scrollX: true,
    fixedColumns:   {
      leftColumns: 4,
    },
  });

  $('.apd-select2').select2({
    ajax:
    {
      url: baseurl+'P2K3_V2/Order/getItem',
      dataType: 'json',
      type: 'get',
      data: function (params) {
        return {s: params.term};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.kode_item,
              text: item.item,
            }
          })
        };
      },
      cache: true
    },
    minimumInputLength: 2,
    placeholder: 'Select Item',
    allowClear: true,
  });

});

function JenisAPD(hh){ 
  var id = $(hh).closest('tr').find('input#txtKodeItem'). 
  attr('data-id'); 
  var it = $("input[data-id='"+id+"']");
  var kode = $(hh).val();
  it.val(kode);
}

$(document).ready(function() {    
  function delSpesifikRow(th) {
    $(th).closest('tr').remove();  
  }

  $('#k3_periode').datepicker({
    autoclose : true,
  });

  $('#detailModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input').val(recipient)

        var NextId = $(event.relatedTarget).data('next-id')
        $('#id-input').val(NextId)
        var id = $('id-input').val();

        $.ajax({
          type: "POST",
          url: baseurl+"P2K3_V2/Order/detail",
          data: {
            id:id,
          },
          success: function (response) {
            $('#slcEcommerceSubInventory').removeAttr('disabled');
            $('#slcEcommerceOrganization').removeAttr('disabled');
            $('#btnTambahKriteriaPencarian').removeAttr('disabled');
            $('#submitExportExcelItemEcatalog').removeAttr('disabled');
            $('#searchResultTableItemBySubInventory').html(response);
            $('#tbItemTokoquick').DataTable();
          }
        });
      });


  $('.p2k3-daterangepicker').daterangepicker({
    "showDropdowns": true,
    "autoApply": true,
    "locale": {
      "format": "YYYY-MM-DD",
      "separator": " - ",
      "applyLabel": "OK",
      "cancelLabel": "Batal",
      "fromLabel": "Dari",
      "toLabel": "Hingga",
      "customRangeLabel": "Custom",
      "weekLabel": "W",
      "daysOfWeek": [
      "Mg",
      "Sn",
      "Sl",
      "Rb",
      "Km",
      "Jm",
      "Sa"
      ],
      "monthNames": [
      "Januari",
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus ",
      "September",
      "Oktober",
      "November",
      "Desember"
      ],
      "firstDay": 1
    }
  }, function(start, end, label) {
    console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
  });

  $('.p2k3-daterangepickersingledate').daterangepicker({
    "singleDatePicker": true,
    "showDropdowns": true,
    "autoApply": true,
    "mask": true,
    "locale": {
      "format": "YYYY-MM-DD",
      "separator": " - ",
      "applyLabel": "OK",
      "cancelLabel": "Batal",
      "fromLabel": "Dari",
      "toLabel": "Hingga",
      "customRangeLabel": "Custom",
      "weekLabel": "W",
      "daysOfWeek": [
      "Mg",
      "Sn",
      "Sl",
      "Rb",
      "Km",
      "Jm",
      "Sa"
      ],
      "monthNames": [
      "Januari",
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus ",
      "September",
      "Oktober",
      "November",
      "Desember"
      ],
      "firstDay": 1
    }
  }, function(start, end, label) {
    console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
  });

  $('.p2k3-daterangepickersingledatewithtime').daterangepicker({
    "timePicker": true,
    "timePicker24Hour": true,
    "singleDatePicker": true,
    "showDropdowns": true,
    "autoApply": true,
    "locale": {
      "format": "YYYY-MM-DD HH:mm:ss",
      "separator": " - ",
      "applyLabel": "OK",
      "cancelLabel": "Batal",
      "fromLabel": "Dari",
      "toLabel": "Hingga",
      "customRangeLabel": "Custom",
      "weekLabel": "W",
      "daysOfWeek": [
      "Mg",
      "Sn",
      "Sl",
      "Rb",
      "Km",
      "Jm",
      "Sa"
      ],
      "monthNames": [
      "Januari",
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus ",
      "September",
      "Oktober",
      "November",
      "Desember"
      ],
      "firstDay": 1
    }
  }, function(start, end, label) {
    console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
  }); 

  $('#exampleModalapd').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input').val(recipient)
      });

});
$(document).ready(function() {
  $('#tb_p2k3').DataTable( {
    "pagingType": "full_numbers"
  });
  $('#p2k3_adm_list_approve').DataTable( {
    "pagingType": "full_numbers"
  });
  $('#tb_InputKebutuhanAPDs').dataTable( {
    dom: 'frtp',
  });
  $('.tb_p2k3').dataTable( {
    dom: 'frtp',
  });
  

  // $('.p2k3_exp_perhitungan').click(function(){
  //   var judul = 'Perhitungan APD periode '+period+'.csv';
  //   // alert(judul);
  //   $(".p2k3_perhitungan").tableHTMLExport({
  //     type:'csv',
  //     filename: judul,
  //     ignoreColumns: '.ignore',
  //     ignoreRows: '.ignore'
  //   });
  // })

  // $('.p2k3_exp_perhitungan_pdf').click(function(){
  //   var judul = 'Perhitungan APD periode '+period+'.pdf';
  //   $(".p2k3_perhitungan").tableExport({type:'pdf',
  //    jspdf: {orientation: 'p',
  //    margins: {left:20, top:10},
  //    autotable: false}
  //  });
  // });
});


// $('#tanggal').datepicker({
//   changeMonth: true,
//   changeYear: true,
//   showButtonPanel: true,
//   dateFormat: 'MM - yy'
// }).focus(function() {
//   var thisCalendar = $(this);
//   $('.ui-datepicker-calendar').detach();
//   $('.ui-datepicker-close').click(function() {
//     var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
//     var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
//     thisCalendar.datepicker('setDate', new Date(year, month, 1));
//   });
// });

$("#tanggal").datepicker({
  dateFormat: 'mm/yy',
  changeMonth: true,
  changeYear: true,
  showButtonPanel: true,

  onClose: function(dateText, inst) {
    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
    $(this).val($.datepicker.formatDate('mm - yy', new Date(year, month, 1)));
  }
});

$("input.p2k3_tanggal_periode").monthpicker({
  changeYear:true,
  dateFormat: 'mm - yy', });

$(".monthPicker").focus(function () {
  $(".ui-datepicker-calendar").remove();
  $("#ui-datepicker-div").position({
    my: "center top",
    at: "center bottom",
    of: $(this)
  });
});


// get Apd umum
$(document).ready(function() {
  $('.k3_admin_standar').select2({
    ajax:
    {
      url: baseurl+'p2k3adm_V2/Admin/getSeksiAprove',
      dataType: 'json',
      type: 'get',
      data: function (params) {
        return {s: params.term};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.section_code,
              text: item.section_code+' - '+item.section_name,
            }
          })
        };
      },
      cache: true
    },
    minimumInputLength: 2,
    placeholder: 'Select Item',
    allowClear: true,
  });
  $('.k3_admin_monitorbon').select2({

  });

  $('#p2k3_addPkj').click(function(){
    // var ks = kodesie;
    // var angka;

    var d = new Date();
    var n = d.getDate();
    if (jmlOrder == 'true'){
      // Swal.fire({
      //   type: 'error',
      //   title: 'Anda Sudah Order!',
      //   text: 'Order hanya dapat dilakukan sekali dalam satu periode!',
      //   animation: false,
      //     // showCancelButton: true,
      //     customClass: {
      //       popup: 'animated shake'
      //     }
      //   })
      $('.modal-title').text('Anda Sudah Order!');
      $('#p2k3_mb').text('Order hanya dapat dilakukan sekali dalam satu periode!');
      $('#p2k3_modal').modal('show');
    }else if (n > 10) {
      // Swal.fire({
      //   type: 'error',
      //   title: 'Anda Terlambat Order!',
      //   text: 'Order dapat Dilakukan di Tanggal 1 - 10',
      //   animation: false,
      //     // showCancelButton: true,
      //     customClass: {
      //       popup: 'animated tada'
      //     }
      //   })
      $('.modal-title').text('Anda Terlambat Order!');
      $('#p2k3_mb').text('Order dapat Dilakukan di Tanggal 1 - 10');
      $('#p2k3_modal').modal('show');
    }else{
      window.location.replace(baseurl+"P2K3_V2/Order/reset");
    }
  });

  $('#pemakai_2s').select2({
    ajax:
    {
      url: baseurl+'P2K3_V2/Order/searchOracle',
      dataType: 'json',
      type: 'get',
      data: function (params) {
        return {s: params.term};
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.COST_CENTER,
              text: item.COST_CENTER+' - '+item.PEMAKAI,
            }
          })
        };
      },
      cache: true
    },
    placeholder: 'Select Item',
    allowClear: true,
  });

  $( '#pemakai_2').change(function() {
    $('#surat-loading').attr('hidden', false);
    var value = $(this).val();
    var hm = value.split('/');
    value = hm[0];
    $.ajax({
      type:'POST',
      data:{pemakai_2:value},
      url:baseurl+"P2K3_V2/Order/pemakai_2",
      success:function(result)
      { 
        a = result.split('|');
        $('#cost_center').val(a[0]);
        $('#kodCab1').val(a[1]);
        $('#surat-loading').attr('hidden', true);
        $('#cost_center').trigger('change');
      }
    });
  });

  $( '#p2k3_lokasi').change(function() {
    $('#surat-loading').attr('hidden', false);
    var value = $(this).val();
    $("#p2k3_gudang").select2('val', null);
    $("#p2k3_gudang").prop("disabled",true);
    $.ajax({
      type:'POST',
      data:{lokasi_id:value},
      url:baseurl+"P2K3_V2/Order/gudang",
      success:function(result)
      {
        $('#surat-loading').attr('hidden', true);
        if (result != '<option></option>') {
          $("#p2k3_gudang").prop("disabled",false).html(result);
          $("#p2k3_gudang").closest('div').addClass('bg-danger');
          $("#kode_barang").closest('div').removeClass('bg-danger');
        }else{
          $("#p2k3_gudang").closest('div').removeClass('bg-danger');
          $("#kode_barang").closest('div').addClass('bg-danger');
          $("#kode_barang").removeAttr('disabled');

        }
      }
    })
  });

  $('#p2k3_gudang').change(function(){
    $('#surat-loading').attr('hidden', false);
    $("#p2k3_locator").select2('val', null);
    $("#p2k3_locator").prop("disabled",true);
    var value = $(this).val();
    $.ajax({
      type:'POST',
      data:{gudang_id:value},
      url:baseurl+"P2K3_V2/Order/lokator",
      success:function(result)
      {
        $('#surat-loading').attr('hidden', true);
        if(result != '<option></option>'){
          $("#p2k3_locator").closest('.form-group').show();
          $("#p2k3_locator").prop("disabled",false).html(result);
        }
        else{
          $("#p2k3_locator").closest('.form-group').hide();
        }
      }
    })
  });

  // $('#cost_center').change(function(){

  // });

});

$(document).on('ifChecked', '.p2k3_chkAll', function(){
  $('.p2k3_chk').iCheck('check');
});
$(document).on('ifUnchecked', '.p2k3_chkAll', function(){
  $('.p2k3_chk').iCheck('uncheck');
});

/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<div class="slider">'+
    '<table class="table table-xs table-bordered">'+
    '<thead class="bg-info">'+
    '<tr>'+

    '<td>Kode Item</td>'+
    '<td>Nama Item</td>'+
    '<td>Jumlah Bon</td>'+
    '<td>Satuan</td>'+
    '</tr>'+
    '</thead>'+
    '<tbody>'+
    '<tr>'+
    '<td>'+d.kode_barang+'</td>'+
    '<td>'+d.nama_apd+'</td>'+
    '<td>'+d.jml_bon+'</td>'+
    '<td>'+d.satuan+'</td>'+
    '<tr>'+
    '<tbody>'+
    '</table>'+
    '</div>';
  }

  $(document).ready(function() {
    var table = $('.p2k3s_monitoringbon').DataTable({
        // "ajax": baseurl+"p2k3adm_V2/Admin/ajaxRow/"+kodes+"/"+period,
        "columns": [
        {
          "className":      'details-control',
          "orderable":      false,
          "data":           null,
          "defaultContent": ''
        },
        { "data": "no_bon" },
        { "data": "tgl_bon" },
        { "data": "seksi_pengebon" },
        { "data": "tujuan_gudang" },
        { "data": "keterangan" }
        ],
      });

    // Add event listener for opening and closing details
    $('.p2k3_monitoringbon tbody').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );

      if ( row.child.isShown() ) {
            // This row is already open - close it
            $('div.slider', row.child()).slideUp( function () {
              row.child.hide();
              tr.removeClass('shown');
            } );
          }
          else {
            // Open this row
            row.child( format(row.data()), 'no-padding' ).show();
            tr.addClass('shown');
            $('div.slider', row.child()).slideDown();
          }
        } );

    $('.p2k3_row_swow').click(function(){
      var val = $(this).closest('td').find('input').val();
      var clas = 'p2k3_row'+val;
      // alert(clas);
      $("."+clas).slideToggle("slow");
      // $("."+clas).css('display', 'block');
      var clas2 = $(this).find('img').attr('class');
      // alert (clas2);
      if (clas2 == '1') {
        $(this).find('img').attr('src', "../../assets/img/icon/details_close.png");
        $(this).find('img').attr('class', '2');
      }else{
        $(this).find('img').attr('src', "../../assets/img/icon/details_open.png");
        $(this).find('img').attr('class', '1');
      }
    })

    $('.p2k3_btn_bon').click(function(){
      var a = '0';
      var b = '0';
      $('.p2k3_inHasil').each(function(){
        if ($(this).val() < 0) {
          a = '1';
        }
      });
      $('.p2k3_inBon').each(function(){
        // alert($(this).val());
        if ($(this).val() > 0) {
          b = '1';
          // alert('as');
        }
      })
      if (a == '1') {
        Swal.fire({
          type: 'error',
          title: 'Oops...',
          text: 'Jumlah Bon Melebihi dari Sisa Saldo yang di Inputkaan!',
        });
        return false;
      }else if(b == '0'){
        Swal.fire({
          type: 'error',
          title: 'Oops...',
          text: 'Semua Jumlah Bon 0!',
        });
        return false;
      }
    });

    $('.et_add_email').click(function(){
      Swal.fire({
        title: 'Input email address',
        input: 'email',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showCancelButton: true,
        inputPlaceholder: 'Enter your email address'
      }).then(function(result) {
        if (result.value) {
         $('#surat-loading').attr('hidden', false);
         $.ajax({
          type: 'POST',
          url: baseurl+'p2k3adm_V2/Admin/addEmail',
          data: {email:result.value},
          success: function(response){
            location.reload();
          }
        });
       }
     });
    });

    $('.et_edit_email').click(function(){
      var em = $(this).closest('tr').find('td.et_em').text();
      var id = $(this).closest('tr').find('input').val();
      Swal.fire({
        title: 'Input email address',
        input: 'email',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showCancelButton: true,
        inputValue: em,
        inputPlaceholder: 'Enter your email address'
      }).then(function(result) {
        if (result.value) {
         $('#surat-loading').attr('hidden', false);
         $.ajax({
          type: 'POST',
          url: baseurl+'p2k3adm_V2/Admin/editEmail',
          data: {email:result.value, id:id},
          success: function(response){
            location.reload();
          }
        });
       }
     });
    });

    $('.et_del_email').click(function(){
      var em = $(this).closest('tr').find('td.et_em').text();
      var id = $(this).closest('tr').find('input').val();
      Swal.fire({
        allowOutsideClick: false,
        allowEscapeKey: false,
        showCancelButton: true,
        title: em,
        text: "Apa anda yakin ingin Menghapus Email Ini?",
        type: 'warning',
        focusCancel: true
      }).then(function(result) {
        if (result.value) {
         $('#surat-loading').attr('hidden', false);
         $.ajax({
          type: 'POST',
          url: baseurl+'p2k3adm_V2/Admin/hapusEmail',
          data: {id:id},
          success: function(response){
            location.reload();
          }
        });
       }
     });
    });

    $('.p2k3_detail_seksi').click(function(){
      var ks = $(this).val();
      $('#surat-loading').attr('hidden', false);
      $.ajax({
        url: baseurl+'P2K3_V2/Order/getJumlahPekerja',
        method: "POST",
        data: {ks:ks},
        success: function(data){
          
          $('#phone_result').html(data);
          $('#surat-loading').attr('hidden', true);
          $('#p2k3_detail_pekerja').modal('show');
        },
        error:function(xhr, ajaxOptions, thrownError){
          $.toaster(xhr+','+ajaxOptions+','+thrownError);
        }
      });
    });

    $('.p2k3_cek_hitung').click(function(){
      var pr = $('.p2k3_tanggal_periode').val();
      $('#surat-loading').attr('hidden', false);
      $.ajax({
        url: baseurl+'p2k3adm_V2/Admin/cekHitung',
        method: "POST",
        data: {pr:pr},
        success: function(data){
          $('#p2k3_result').html(data);
          $('#surat-loading').attr('hidden', true);
          $('#p2k3_cekError').modal('show');
          // alert(data.indexOf('center'));
          if (data.indexOf('center') > 10) {
            $('.p2k3_submit_hitung').css('cursor', 'not-allowed');
            $('.p2k3_submit_hitung').attr('data-original-title', 'Ada Error Pada data. Harap perbaiki sebelum melanjutkan');
            $('.p2k3_submit_hitung').attr('type', 'button');
          } else {
            $('.p2k3_submit_hitung').css('cursor', 'pointer');
            $('.p2k3_submit_hitung').attr('data-original-title', 'Data Aman klik untuk Melanjutkan');
            $('.p2k3_submit_hitung').attr('type', 'submit');
          }
        },
        error:function(xhr, ajaxOptions, thrownError){
          $.toaster(xhr+','+ajaxOptions+','+thrownError);
        }
      });
    });

    $('.p2k3_select2').select2({
      allowClear: false
    });

    $('.p2k3_select2Item').select2({
      allowClear: false,
      placeholder: 'Pilih Item',
      minimumInputLength: 2,
    });

    $('.et_edit_masterItem').click(function(){
      var kode = $(this).closest('tr').find('td.et_kode').text();
      var nama = $(this).closest('tr').find('td.et_item').text();
      var bulan = $(this).closest('tr').find('td.et_exbulan').text();
      $('#p2k3_kode_item').val(kode);
      $('#p2k3_kode_item2').val(kode);
      $('#p2k3_nama_item').val(nama);
      $('#p2k3_bulan_item').val(bulan);
      $('#p2k3_edit_item').modal("show");
    });

    $('.p2k3_see_image').click(function(){
      var file = $(this).val();
      var nama = $(this).attr('data-nama');
      var kode = $(this).attr('data-kode');
      // alert(file);
      Swal.fire({
        // title: file,
        // text: kode+' - '+nama,
        html: '<b>'+kode+' - '+nama+'</b>',
        imageUrl: baseurl+'assets/upload/P2K3/item/'+file,
        // imageWidth: 600,
        // imageHeight: 400,
        imageAlt: file,
        animation: false
      });
    });

    $('.p2k3_select2Item').change(function(){
      var satuan = $('option:selected', this).attr('data-satuan');
      // alert(satuan);
      $('#p2k3_setItem').val(satuan);
    });

    $(document).on('click', '.p2k3_to_input', function() {
      // alert($(this).closest('tr').find('input').val());
      $(this).closest('tr').find('input.p2k3_see_apd').trigger("click");
    });

    $(document).on('click', '.p2k3_see_apd_text', function() {
      var vall = $(this).text();
        $('#surat-loading').attr('hidden', false);
        $.ajax({
          type: 'POST',
          url: baseurl+'p2k3adm_V2/Admin/getFoto',
          data: {id:vall},
          success: function(response){
              // alert(response['foto']);
            $('#surat-loading').attr('hidden', true);
            if (response['foto'] == '-') {
              Swal.fire({
                html: '<b>Foto tidak di Temukan</b>',
                imageUrl: baseurl+'assets/img/notFound.png',
                imageAlt: 'not found',
                animation: false
              });
            }else{
              var file = response['foto'];
              Swal.fire({
                html: '<b>'+response['kode']+' - '+response['nama']+'</b>',
                imageUrl: baseurl+'assets/upload/P2K3/item/'+file,
                imageAlt: file,
                animation: false
              });
            }
          }
        });
    });
  });
function p2k3_val(){
  var max = $('#pw2k3_maxpkj').val();
  var staf = $("input[name='staffJumlah']").val();
  var values = $("input[name='pkjJumlah\\[\\]']")
  .map(function(){return $(this).val();}).get();
  var jumlah = Number(staf);

  for (var i = 0; i < values.length; i++) {
    jumlah += Number(values[i]);
  }
      // alert(jumlah);
      if (jumlah > Number(max)) {
        Swal.fire({
          type: 'error',
          title: 'Jumlah Pekerja Melebihi Batas',
          text: 'Maksimal Jumlah Pekerja adalah '+max,
        });
        return false;
      }else{
        return true;
      }
    }

    $(document).on('click', '.p2k3_see_apd', function() {
      var nama = $(this).closest('tr').find('select.apd-select2').text();
      nama = $.trim(nama);
      // console.log(nama);
      var vall = $(this).val();
      if (vall.length < 2) {
        // alert(vall);
      }else{
      $('#surat-loading').attr('hidden', false);
        $.ajax({
          type: 'POST',
          url: baseurl+'p2k3adm_V2/Admin/getFoto',
          data: {id:vall},
          success: function(response){
              // alert(response['foto']);
            $('#surat-loading').attr('hidden', true);
            if (response['foto'] == '-') {
              Swal.fire({
                html: '<b>Foto tidak di Temukan</b>',
                imageUrl: baseurl+'assets/img/notFound.png',
                imageAlt: 'not found',
                animation: false
              });
            }else{
              var file = response['foto'];
              Swal.fire({
                html: '<b>'+vall+' - '+response['nama']+'</b>',
                imageUrl: baseurl+'assets/upload/P2K3/item/'+file,
                imageAlt: file,
                animation: false
              });
            }
          }
        });
      }
    });

$(document).ready(function(){
  $('.et_add_email_seksi').click(function(){
    Swal.fire({
      title: 'Input email address',
      input: 'email',
      allowOutsideClick: false,
      allowEscapeKey: false,
      showCancelButton: true,
      inputPlaceholder: 'Enter your email address'
    }).then(function(result) {
      if (result.value) {
       $('#surat-loading').attr('hidden', false);
       $.ajax({
        type: 'POST',
        url: baseurl+'P2K3_V2/Order/addEmailSeksi',
        data: {email:result.value},
        success: function(response){
          location.reload();
        }
      });
     }
   });
  });

  $('.et_edit_email_seksi').click(function(){
      var em = $(this).closest('tr').find('td.et_em').text();
      var id = $(this).closest('tr').find('input').val();
      Swal.fire({
        title: 'Input email address',
        input: 'email',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showCancelButton: true,
        inputValue: em,
        inputPlaceholder: 'Enter your email address'
      }).then(function(result) {
        if (result.value) {
         $('#surat-loading').attr('hidden', false);
         $.ajax({
          type: 'POST',
          url: baseurl+'P2K3_V2/Order/editEmailSeksi',
          data: {email:result.value, id:id},
          success: function(response){
            location.reload();
          }
        });
       }
     });
    });

  $('.et_del_email_seksi').click(function(){
      var em = $(this).closest('tr').find('td.et_em').text();
      var id = $(this).closest('tr').find('input').val();
      Swal.fire({
        allowOutsideClick: false,
        allowEscapeKey: false,
        showCancelButton: true,
        title: em,
        text: "Apa anda yakin ingin Menghapus Email Ini?",
        type: 'warning',
        focusCancel: true
      }).then(function(result) {
        if (result.value) {
         $('#surat-loading').attr('hidden', false);
         $.ajax({
          type: 'POST',
          url: baseurl+'P2K3_V2/Order/hapusEmailSeksi',
          data: {id:id},
          success: function(response){
            location.reload();
          }
        });
       }
     });
    });

  $('.p2k3_tbl_frezz').DataTable({
    dom: 'frtp',
    scrollX: true,
    "paging": false,
    // scrollX: "100%",
    "ordering": false,
    scrollCollapse: true,
    fixedColumns:   {
      leftColumns: 4,
    },
  });

  $('.p2k3_tbl_frezz_nos').DataTable({
    dom: 'frtp',
    // scrollX: true,
    "paging": false,
    // scrollX: "100%",
    "ordering": false,
    scrollCollapse: true,
    fixedColumns:   {
      leftColumns: 4,
    },
  });

  $('.dataTable_p2k3Frezz_noOrder').DataTable({
    dom: 'frtp',
    scrollX: true,
    "ordering": false,
    fixedColumns:   {
      leftColumns: 3,
    },
  });

  $('.p2k3_tbl_datamasuk').DataTable();

  $('.p2k3_tanggal_periode').change(function(){
    var d = new Date();
    var n = d.getFullYear();
    var m = d.getMonth()+01;
    var v = $(this).val().split(' - ');
    if (v[1] < n) {
      alert('Periode tidak boleh lebih kecil dari bulan sekarangasdad');
      $(this).val(pad(m)+' - '+n);
    }else if(v[1] > n){
      //oke
    }else if (v[0] < m) {
      alert('Periode tidak boleh lebih kecil dari bulan sekarang');
      $(this).val(pad(m)+' - '+n);
    }
  });
});

function erp_checkPopUp()
{
    setTimeout(function() {
        var newWin = window.open(url);
        if(!newWin || newWin.closed || typeof newWin.closed=='undefined') 
        { 
            alert('Popup Tidak Aktif (Blocked)!\nMohon Aktifkan Pop up Untuk melanjutkan, lalu refresh/reload Halaman ini!');
            $('#p2k3_popup').modal({backdrop: 'static', keyboard: false});
        }else{
            newWin.close();
        }
    }, 500);
}

function pad(d) {
    return (d < 10) ? '0' + d.toString() : d.toString();
}