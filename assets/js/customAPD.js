$("#group_add").click(function(e){
  var d = new Date();
  var n = d.getDate();
  if (n > 10) {
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
  $('.dataTable-p2k3').dataTable( {
    dom: 'frtp',
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


$(".monthPicker").focus(function () {
  $(".ui-datepicker-calendar").hide();
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
      $("."+clas).slideToggle();
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

  //   $('.et_add_email').click(function(){
  //     star();
  //     async function star(){
  //       const {value: email} = await Swal.fire({
  //         title: 'Input email address',
  //         input: 'email',
  //         inputPlaceholder: 'Enter your email address',
  //       })

  //       if (email) {
  //         $('#surat-loading').attr('hidden', false);
  //         $.ajax({
  //           type: 'POST',
  //           url: baseurl+'p2k3adm_V2/Admin/addEmail',
  //           data: {email:email},
  //           success: function(response){
  //             location.reload();
  //           }
  //         });
  //       }
  //     }
  //   });

  //   $('.et_edit_email').click(function(){
  //     var em = $(this).closest('tr').find('td.et_em').text();
  //     var id = $(this).closest('tr').find('input').val();
  //     star();
  //     async function star(){
  //       const {value: email} = await Swal.fire({
  //         title: 'Edit email address',
  //         input: 'email',
  //         inputPlaceholder: 'Enter your email address',
  //         inputValue: em,
  //       })

  //       if (email) {
  //         $('#surat-loading').attr('hidden', false);
  //         $.ajax({
  //           type: 'POST',
  //           url: baseurl+'p2k3adm_V2/Admin/editEmail',
  //           data: {email:email, id:id},
  //           success: function(response){
  //             location.reload();
  //           }
  //         });
  //       }
  //     }
  //   });

  //   $('.et_del_email').click(function(){
  //     var em = $(this).closest('tr').find('td.et_em').text();
  //     var id = $(this).closest('tr').find('input').val();
  //     Swal.fire({
  //       title: em,
  //       text: "Apa anda yakin ingin Menghapus Email Ini?",
  //       type: 'warning',
  //       showCancelButton: true,
  //       confirmButtonColor: '#3085d6',
  //       cancelButtonColor: '#d33',
  //       confirmButtonText: 'Yes, delete it!'
  //     }).then((result) => {
  //       if (result.value) {
  //         $('#surat-loading').attr('hidden', false);
  //         $.ajax({
  //           type: 'POST',
  //           url: baseurl+'p2k3adm_V2/Admin/hapusEmail',
  //           data: {id:id},
  //           success: function(response){
  //             location.reload();
  //           }
  //         });
  //       }
  //     })
  //   });
  });