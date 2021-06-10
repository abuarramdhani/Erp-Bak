const toastup2lLoading = (pesan) => {
  Swal.fire({
    toast: true,
    position: 'top-end',
    onBeforeOpen: () => {
       Swal.showLoading();
       $('.swal2-loading').children('button').css({'width': '20px', 'height': '20px'})
     },
    text: pesan
  })
}

const toastup2l = (type, message) => {
  Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  }).fire({
    customClass: 'swal-font-small',
    type: type,
    title: message
  })
}

function swalup2l(type, pesan) {
  Swal.fire({
    type: type,
    html:  `<div style="font-weight:400">${pesan}</div>`,
    text: '',
    showConfirmButton: false,
    showCloseButton: true,
  })
}

$(function() {
  if ($('.select2subinv_up2l').val() != undefined) {
    $('.select2subinv_up2l').select2();
    // setTimeout(function () {
    //   $.ajax({
    //     url: baseurl + 'ManufacturingOperationUP2L/Selep/SubInv',
    //     type: 'POST',
    //     dataType: 'JSON',
    //     data: {
    //       io : 101 //OPM
    //     },
    //     cache: false,
    //     beforeSend: function() {
    //       toastup2lLoading('Sedang Mengambil SubInv..');
    //     },
    //     success: function(result) {
    //       if (result != 0) {
    //         toastup2l('success', 'Selesai..');
    //         $('.select2subinv_up2l').html(result);
    //         $('.select2subinv_up2l').val('').trigger('change');
    //       }else {
    //         $('.select2subinv_up2l').html('');
    //       }
    //     },
    //     error: function(XMLHttpRequest, textStatus, errorThrown) {
    //       swalup2l('error', 'Koneksi Terputus...')
    //      console.error();
    //     }
    //   })
    // }, 2000);
  }
  $('.up2l_date_selep_88').daterangepicker({
    singleDatePicker: true,
    timePicker: true,
    autoclose: true,
    autoUpdateInput: false,
    locale: {
      format: "YYYY/MM/DD HH:mm:ss",
      cancelLabel: 'Clear'
    },
  });
  $('.up2l_date_selep_88').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY/MM/DD HH:mm:ss'));
      $(this).trigger('change');
  });
  $('.up2l_date_selep_88').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
  $('.up2l_date_selep_88').on('change', function () {
      let val = $(this).val().split(' ');
      $('.slcShift').val('').trigger('change');
      //SHIFT
      $.ajax({
          type: "POST",
          url: baseurl + 'ManufacturingOperationUP2L/Ajax/getShift',
          data: {
              tanggal: val[0]
          },
          dataType: "JSON",
          beforeSend: function () {
            toastup2lLoading('Sedang Memuat Data Shift..');
          },
          success: function (response) {
              //console.log(response);
              swal.close();
              var html = '';
              html += '<option></option>';
              for (var i = 0; i < response.length; i++) {
                  if (i == 0) {
                      html += '<option value="' + response[i]['DESCRIPTION'] + '">' + response[i]['DESCRIPTION'] + '</option>';
                  } else {
                      html += '<option value="' + response[i]['DESCRIPTION'] + '">' + response[i]['DESCRIPTION'] + '</option>';
                  }
              }
              $('.slcShift').html(html);
          }
      });
  });
})

function up2l_selep_reload_saya() {
  setTimeout(function () {
    location.reload();
  }, 200);
}

function set_tosubinv_up2l(item_id, batch_no) {
  $.ajax({
    url: baseurl + 'ManufacturingOperationUP2L/Selep/update_subinv_complation',
    type: 'POST',
    dataType: 'JSON',
    data: {
      item_id : item_id,
      batch_no : batch_no,
      subinv : $('.select2subinv_up2l_complation').val()
    },
    cache:false,
    beforeSend: function() {
      Swal.fire({
        onBeforeOpen: () => {
           Swal.showLoading();
           $('.swal2-loading').children('button').css({'width': '40px', 'height': '40px'})
         },
        text: 'Mengupdate SUBINVENTORY..',
        allowOutsideClick: false,
      })
    },
    success: function(result_2) {
      if (result_2 == 100) {
        swalup2l('success', 'Sukses Melakukan Update SUBINVENTORY');
        up2l_refresh_complation();
      }else {
        swalup2l('warning', 'Terjadi Kesalahan Saat Melakukan Update SUBINVENTORY');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalup2l('error', 'Koneksi Terputus...')
     console.error();
    }
  })
}

$('#form_input_selep_master').on('submit', function(e) {
  e.preventDefault();
  $('#modalUP2LCreateKIB').modal('show');

  // dari trigger onclick sebelumnya
  $.ajax({
    url: baseurl + 'ManufacturingOperationUP2L/Selep/get_io_subinv_locator_tujuan',
    type: 'POST',
    dataType: 'JSON',
    data: {
      batch_no: $('#txtSelepBatchCetakKIB').val()
    },
    cache:false,
    beforeSend: function() {
      Swal.fire({
        onBeforeOpen: () => {
           Swal.showLoading();
           $('.swal2-loading').children('button').css({'width': '40px', 'height': '40px'})
         },
        text: 'Sedang Mengambil IO Tujuan, Sub Inv. Tujuan, Locator Tujuan.',
        allowOutsideClick: false,
      })
    },
    success: function(result) {
      toastup2l('success', 'Done.')
      console.log(result, 'get_io_subinv_locator_tujuan');
      $('.up2l_io_99').val(`${result.ORG_CODE} - ${result.ORG_ID}`);
      $('.up2l_subinv_99').val(result.SUBINVENTORY);
      $('.slc_up2l_locator').val(`${result.LOCATOR_CODE == null ? '' : result.LOCATOR_CODE} - ${result.LOCATOR_ID == null ? '' : result.LOCATOR_ID}`);

      //cek handling
      $.ajax({
        url: baseurl + 'ManufacturingOperationUP2L/Selep/get_qty_handling',
        type: 'POST',
        dataType: 'JSON',
        data: {
          component_code: $('#txtComponentCodeHeader').val(),
          org_code: result.ORG_CODE
        },
        cache:false,
        beforeSend: function() {
          Swal.fire({
            onBeforeOpen: () => {
               Swal.showLoading();
               $('.swal2-loading').children('button').css({'width': '40px', 'height': '40px'})
             },
            text: 'Sedang Mengecek Quantity Handling..',
            allowOutsideClick: false,
          })
        },
        success: function(result_2) {
          toastup2l('success', 'Done.');
          if (result_2 != 'gada') {
            $('#txtSelepQtyHandlingCetakKIB').val(result_2).attr('readonly', true);
          }else {
            $('#txtSelepQtyHandlingCetakKIB').val('').attr('readonly', false);
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        swalup2l('error', 'Koneksi Terputus...')
         console.error();
        }
      })

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalup2l('error', 'Koneksi Terputus...')
     console.error();
    }
  })
})

//ADB1BA0011E1MD
function settingUserSubinv() {
  $.ajax({
    url: baseurl + 'ManufacturingOperationUP2L/Selep/user_subinv',
    type: 'POST',
    // dataType: 'JSON',
    data: {
    },
    cache:false,
    beforeSend: function() {
      Swal.fire({
        onBeforeOpen: () => {
           Swal.showLoading();
           $('.swal2-loading').children('button').css({'width': '40px', 'height': '40px'})
         },
        text: 'Sedang Mengambil Data..',
        allowOutsideClick: false,
      })
    },
    success: function(result_2) {
      toastup2l('success', 'Done.');
      $('.area-setting-user-subinv').html(result_2);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalup2l('error', 'Koneksi Terputus...')
     console.error();
    }
  })
}

function up2l_refresh_complation() {
  $('#modalUP2LCompleteJob').modal('hide')
  setTimeout(function () {
    $('.btn-complate-job').trigger('click')
  }, 750);
}

$('.form_generate_kib_up2l').on('submit', function(e) {
   e.preventDefault();
   let form_data_utama = new FormData($('#form_input_selep_master').get(0));
   Swal.fire({
     onBeforeOpen: () => {
        Swal.showLoading();
        $('.swal2-loading').children('button').css({'width': '40px', 'height': '40px'})
      },
     text: 'Sedang menyimpan data Selep, KIB & Close Batch..',
     allowOutsideClick: false,
   })
   $.ajax({
     url: baseurl + 'ManufacturingOperationUP2L/Selep/create',
     type: 'POST',
     data : form_data_utama,
     contentType: false,
     cache: false,
     // async:false,
     processData: false,
     dataType: "JSON",
     beforeSend: function() {
       // $('#modalUP2LCompleteJob').modal('hide');
     },
     success: function(result) {
       if (result == 'done') {
         // swalup2l('success', `Data Selep Berhasil Tersimpan`);
         let form_data  = new FormData($('.form_generate_kib_up2l').get(0));
         $.ajax({
           url: baseurl + 'ManufacturingOperationUP2L/Selep/generate_kib',
           type: 'POST',
           data : form_data,
           contentType: false,
           cache: false,
           // async:false,
           processData: false,
           dataType: "JSON",
           beforeSend: function() {

           },
           success: function(result_2) {
             if (result_2.status == 500) {
               swalup2l('warning', 'Terjadi kesalahan, Qty Handling tidak boleh 0')
             }else if (result_2.status == 400) {
               swalup2l('warning', `${result_2.isi} (Complate Batch)`)
             }else if (result_2.status == 300) {
               swalup2l('warning', `${result_2.isi} (Close Batch)`)
             }else if (result_2.status == 100) {
               Swal.fire({
                 type: 'success',
                 html:  `<div style="font-weight:400">KIB berhasil tersimpan, klik link berikut untuk mencetak KIB ${result_2.isi}</div>`,
                 text: '',
                 showConfirmButton: false,
                 allowOutsideClick: false,
                 showCloseButton: false,
               });
               $('.btn-up2l-cetakkib').attr('disabled', true);
               setTimeout(function () {
                 // swal.close();
                 // location.reload();
                 $('#modalUP2LCreateKIB').modal('hide');
               }, 1000);
             }else {
               swalup2l('error', 'Hubungi ICT');
             }
           },
           error: function(XMLHttpRequest, textStatus, errorThrown) {
             swalup2l('error', XMLHttpRequest);
            console.error();
           }
         })

       }else {
         swalup2l('warning', 'Terjadi Kesalahan Saat Menginput Data Selep! Harap Coba lagi');
       }
     },
     error: function(XMLHttpRequest, textStatus, errorThrown) {
     swalup2l('error', XMLHttpRequest);
      console.error();
     }
   })


})

// function submit_up2l_selep_master() {
//   // $('.btn-up2l-save-selep').attr('disabled', false);
//   $('.btn-up2l-cetakkib').attr('disabled', true);
//   setTimeout(function () {
//     $('#modalUP2LCreateKIB').modal('hide');
//   }, 1500);
// }

$('.btn-up2l-cetakkib').on('click', function() {

})

// revisi
// $('.up2l_subinv_99').on('change', function() {
//   if ($(this).val() != '') {
//
//   let val_ = $(this).val().split(' - ');
//   let val = val_[0];
//     // numpang barang bekas
//     $.ajax({
//       url: baseurl + 'BarangBekas/pbbs/locator',
//       type: 'POST',
//       dataType: 'JSON',
//       data: {
//         subinv: val,
//         org_id: val_[1]
//       },
//       cache:false,
//       beforeSend: function() {
//         $('.up2l_locator').html('<b>Sedang Mengambil Locator...</b>');
//       },
//       success: function(result) {
//         if (result != 0) {
//           $('.up2l_locator').html(`<select class="slc_up2l_locator pbbs_loc" name="locator" style="width:100%" required >
//                                   <option selected value="">Select..</option>
//                                   ${result}
//                                   </select>`);
//           $('.slc_up2l_locator').select2();
//         }else {
//           $('.up2l_locator').html('<input type="text" readonly class="form-control slc_up2l_locator" name="locator" value="">')
//         }
//         // getOnhand();
//       },
//       error: function(XMLHttpRequest, textStatus, errorThrown) {
//       swalup2l('error', 'Koneksi Terputus...')
//        console.error();
//       }
//     })
//   }
//
// })
//
// $('.up2l_io_99').on('change', function() {
//   let val = $(this).val();
//   $.ajax({
//     url: baseurl + 'BarangBekas/pbbs/SubInv',
//     type: 'POST',
//     dataType: 'JSON',
//     data: {
//       io : val
//     },
//     cache: false,
//     beforeSend: function() {
//       Swal.fire({
//         onBeforeOpen: () => {
//            Swal.showLoading();
//            $('.swal2-loading').children('button').css({'width': '40px', 'height': '40px'})
//          },
//         text: 'Sedang Mengambil SubInv..'
//       })
//     },
//     success: function(result) {
//       if (result != 0) {
//         toastup2l('success', 'Selesai..');
//         $('.up2l_subinv_99').html(result);
//       }else {
//         swalup2l('warning', 'IO belum Open Period');
//         $('.up2l_subinv_99').html('');
//       }
//       $('.up2l_locator').html('<input type="text" readonly class="form-control slc_up2l_locator" name="locator" value="">');
//       $('.up2l_subinv_99').val('').trigger('change');
//     },
//     error: function(XMLHttpRequest, textStatus, errorThrown) {
//     swalPBB('error', 'Koneksi Terputus...')
//      console.error();
//     }
//   })
// })

$('.btn-complate-job').on('click', function() {
  let qty = $('#txtSelepQuantityConfrm').val();
  let batch_no = $('#txtSelepBatchConfrm').val();
  $.ajax({
    url: baseurl + 'ManufacturingOperationUP2L/Selep/check_detail_onhand',
    type: 'POST',
    dataType: 'JSON',
    data: {
      batch_no: batch_no
    },
    cache:false,
    beforeSend: function() {
      Swal.fire({
        onBeforeOpen: () => {
           Swal.showLoading();
           $('.swal2-loading').children('button').css({'width': '40px', 'height': '40px'})
         },
        text: 'Checking Onhand..',
        allowOutsideClick: false,
      })
    $('.alert-area-up2l-onhand-kurang').html('');
    $('#area-check-onhand-up2l').html('');
    },
    success: function(result) {
      toastup2l('success', 'Done.')
      console.log(result, 'Onhand');
      $('#area-check-onhand-up2l').html(result.data);
      $('.select2subinv_up2l_complation').select2();

      if (result.merah == 500) {
        $('.alert-area-up2l-onhand-kurang').html(`<div class="alert bg-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">
                  <i class="fa fa-close"></i>
                </span>
              </button>
              <strong>Tidak dapat melakukan complation job.</strong> Onhand tidak mencukupi / Sub. Inventory Ingredient belum disetting.</strong>
            </div>`)
        $('.btn-complation-up2l-2021').attr('disabled', true);
      }else {
        $('.alert-area-up2l-onhand-kurang').html('');
        $('.btn-complation-up2l-2021').attr('disabled', false);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalup2l('error', 'Koneksi Terputus...')
     console.error();
    }
  })
})

function completejobUP2L2021() {
  let qty = $('#txtSelepQuantityConfrm').val();
  let batch_no = $('#txtSelepBatchConfrm').val();
  console.log(qty, batch_no, 'ini di complate job');
  $.ajax({
    url: baseurl + 'ManufacturingOperationUP2L/Selep/batch_completion',
    type: 'POST',
    dataType: 'JSON',
    data: {
      batch_no: batch_no,
      qty: qty
    },
    cache:false,
    beforeSend: function() {
      // $('#modalUP2LCompleteJob').modal('hide');
      Swal.fire({
        onBeforeOpen: () => {
           Swal.showLoading();
           $('.swal2-loading').children('button').css({'width': '40px', 'height': '40px'})
         },
        text: 'Completion job..',
        allowOutsideClick: false,
      })
    },
    success: function(result_2) {
      if (result_2 != 'gada') {
        swalup2l('success', 'Completion Job <b>Berhasil</b>');
        $('#modalUP2LCompleteJob').modal('hide');
        $('.btn-complate-job').attr('disabled', true);
        $('.btn-up2l-cetakkib').attr('disabled', false);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalup2l('error', 'textStatus');
     console.error();
    }
  })
}

function create_batch_up2l(item, recipe_no, recipe_version, uom, job_date) {
  console.log(item, recipe_no, recipe_version, uom, job_date);
  console.log($(`#cek_sub_inv_tujuan_${recipe_no}`).text(),' disiniiii sub inv tujuan');
  if ($(`#cek_locator_code_${recipe_no}`).text() != '-' && $(`#cek_jml_locator_${recipe_no}`).text() == 0) {
      swalup2l('warning', `<b>Jumlah Locator di <span style="color:#002b65">${$(`#cek_locator_code_${recipe_no}`).text()}</span> tidak boleh 0</b>`);
  }else {
    if ($(`#cek_sub_inv_tujuan_${recipe_no}`).text() != '-') {
      let subinv = $('.select2subinv_up2l').val();
      let selepQtyHeader = $('#txtSelepQuantityHeader').val();
      console.log(subinv, 'ini sub inv 1');
      if (subinv == '' || subinv == null) {
        swalup2l('warning', 'Karena anda belum terdaftar di User Sub. Inventory, <br><b>Pilih Sub.Inv. terlebih dahulu!</b>');
      }else {
        $.ajax({
          url: baseurl + 'ManufacturingOperationUP2L/Selep/create_batch',
          type: 'POST',
          dataType: 'JSON',
          data: {
            item : item,
            recipe_no: recipe_no,
            recipe_version: recipe_version,
            uom: uom,
            subinv: subinv,
            qty: selepQtyHeader,
            job_date: job_date
          },
          cache:false,
          beforeSend: function() {
            Swal.fire({
              onBeforeOpen: () => {
                 Swal.showLoading();
                 $('.swal2-loading').children('button').css({'width': '40px', 'height': '40px'})
               },
              text: 'Creating Batch..',
              allowOutsideClick: false,
            })
            $('#modalMOreceip').modal('hide');
            $('#txtSelepComponentConfrm').val('');
            $('#txtSelepBatchConfrm').val('');
            $('#txtSelepQuantityConfrm').val('');

            $('#txtSelepBatchCetakKIB').val('');
            $('#txtSelepQtyCetakKIB').val('');
            $('#txtSelepSubInvFromCetakKIB').val('');
          },
          success: function(result) {
            console.log(result, 'status batch information');
            if (result.no_batch != 'gada') {
              toastup2l('success', 'No. Batch berhasil dibuat');
              $('#txtSelepBatchHeader').val(result.no_batch);

              $('.btn-complate-job').attr('disabled', false);
              $('.btn-up2l-back-selep').attr('disabled', true);
              $('#txtSelepQuantityHeader').attr('readonly', true);

              $('#txtComponentCodeHeader').select2('destroy').attr('readonly', true).attr('style', 'pointer-events:none;');

              $('#txtSelepComponentConfrm').val(item);
              $('#txtSelepBatchConfrm').val(result.no_batch);
              $('#txtSelepQuantityConfrm').val(selepQtyHeader);

              $('#txtSelepBatchCetakKIB').val(result.no_batch);
              $('#txtSelepQtyCetakKIB').val(selepQtyHeader);
              $('#txtSelepSubInvFromCetakKIB').val(subinv);

            }else {
              swalup2l('warning', `Failed to create batch <br> <b> [ ${result.reason} ] </b>`);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
          swalup2l('error', 'textStatus');
           console.error();
          }
        })
      }
    }else {
      swalup2l('warning', `Gudang tujuan pada no recipe ${recipe_no} tidak boleh kosong.`);
    }
  }

}

$('#txtComponentCodeHeader').on('change', function() {
  $('.btn-complate-job').attr('disabled', true);
  $('#txtSelepQuantityHeader').attr('readonly', false);
  $('#txtSelepBatchHeader').val('');
  $('#txtSelepBatchCetakKIB').val('');
  $('#txtSelepQtyCetakKIB').val('');
  $('#txtSelepSubInvFromCetakKIB').val('');
  $('.btn-up2l-cetakkib').attr('disabled', true);
  // $('.btn-up2l-save-selep').attr('disabled', true);
})

function createBatchMO() { //recipe
  let batch_number_cek = $('#txtSelepBatchHeader').val();
  let component_code = $('#txtComponentCodeHeader').val();
  let selepQtyHeader = $('#txtSelepQuantityHeader').val();
  let job_date = $('#txtSelepDate').val();
  if (component_code == null || selepQtyHeader == '' || job_date == '') {
    swalup2l('info', '<b>Selep Date</b>, <b>Component Code</b>, dan <b>Selep QTY Header</b> <br> Tidak boleh kosong!')
  }else {
    component_code = component_code.split(' | ')[0];
    let result_cek_987 = 0;
    if (batch_number_cek == '') {
      let tampung = [];
      $.ajax({
        url: baseurl + 'ManufacturingOperationUP2L/Selep/get_recipe',
        type: 'POST',
        dataType: 'JSON',
        data: {
          component_code : component_code,
        },
        cache:false,
        beforeSend: function() {
          Swal.fire({
            onBeforeOpen: () => {
               Swal.showLoading();
               $('.swal2-loading').children('button').css({'width': '40px', 'height': '40px'})
             },
            text: 'Check Recipe..',
            allowOutsideClick: false,
          })
        },
        success: function(result) {
          if (result != 'gada') {
            console.log(result_cek_987, 'ini lhoo');
            $('#mo_comp_code').text(`Create Batch (${component_code})`);
            $('#txtSelepQuantityHeaderModal').val(selepQtyHeader);
            // $('.select2subinv_up2l').val('').trigger('change');

            console.log(result);
            result.forEach((v,i)=>{
              console.log('hai'+i);
              let body = `<tr>
                            <td>${v.ITEM}</td>
                            <td>${v.ITEM_ID}</td>
                            <td>${v.RECIPE_ID}</td>
                            <td>${v.RECIPE_NO}</td>
                            <td>${v.RECIPE_VERSION}</td>
                            <td id="cek_sub_inv_tujuan_${v.RECIPE_NO}">${v.SUBINVENTORY == null ? '-' : v.SUBINVENTORY}</td>
                            <td>${v.UOM}</td>
                            <td id="cek_locator_code_${v.RECIPE_NO}">${v.LOCATOR_CODE == null ? '-' : v.LOCATOR_CODE}</td>
                            <td id="cek_jml_locator_${v.RECIPE_NO}">${v.JML_LOCATOR}</td>
                            <td><button type="button" class="btn btn-success create_batch_up2l_if_1" onclick="create_batch_up2l('${v.ITEM}', '${v.RECIPE_NO}', '${v.RECIPE_VERSION}', '${v.UOM}', '${job_date}')" name="button"><b> <i class="fa fa-check"></i> Pilih </b></button></td>
                          </tr>`;
              tampung.push(body);
              swal.close();
            });
            $('#area-up2l-body-recipe').html(tampung.join());
            $.ajax({
              url: baseurl + 'ManufacturingOperationUP2L/Selep/cek_user',
              type: 'POST',
              dataType: 'JSON',
              data: {
                noind : $('#up2l_user_login_2021').val(),
              },
              cache:false,
              beforeSend: function() {
                toastup2lLoading('Filtering subinv by user login..')
                $('.select2subinv_up2l').val('').trigger('change');
              },
              success: function(result_3) {
                if (result_3 != 'gada') {
                  //======================//===================
                  if (Number(result_3.length) == 1) {
                    $('.select2subinv_up2l').html(result_3.join('')).trigger('change');
                    console.log(result_3,'ini result dari recipt ');

                    // cek banyak recipt
                    if (result.length == 1) {
                      //delay modal akan show
                      setTimeout(function () {
                        if (result_3.length == 1) {
                          console.log('heiheiehiehi');
                          $('.create_batch_up2l_if_1').trigger('click');
                        }
                      }, 678);
                    }

                  }else if (Number(result_3.length) > 1) {
                    $('.select2subinv_up2l').html(result_3.join(''));
                    $('.select2subinv_up2l').val('').trigger('change');
                  }
                  //======================//===================
                }else {
                  $('.select2subinv_up2l').val('').trigger('change');
                }
                swal.close()
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                swalup2l('error', 'when get user');
               console.error();
              }
            });
            $('#modalMOreceip').modal('show');
          }else {
            swalup2l('warning', `Kode komponen <b>${component_code}</b> belum mempunyai recipe!`);
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          swalup2l('error', 'textStatus');
         console.error();
        }
      })
    }else {
      swalup2l('warning', '<b>No. Batch</b> sudah dibuat');
    }

  }
}
//edit rozin
// DATATABLE SERVERSIDE MOULD
const tblmould2021 = $('#tblMoulding2021').DataTable({
    // dom: '<"top"lf>rt<"bottom"ip><"clear">',
    ajax: {
      data: (d) => $.extend({}, d, {
        // org: null,    // optional
        // id_plan: null // optional
        bulan: null,
        tanggal: null,
      }),
      url: baseurl + "ManufacturingOperationUP2L/Moulding/buildMDataTable",
      type: 'POST',
    },
    language:{
      processing: "<div class='overlay custom-loader-background'><i class='fa fa-cog fa-spin custom-loader-color' style='color:#fff'></i></div>"
    },
    ordering: false,
    pageLength: 10,
    pagingType: 'first_last_numbers',
    processing: true,
    serverSide: true,
    preDrawCallback: function(settings) {
         if ($.fn.DataTable.isDataTable('#tblMoulding2021')) {
             var dt = $('#tblMoulding2021').DataTable();

             //Abort previous ajax request if it is still in process.
             var settings = dt.settings();
             if (settings[0].jqXHR) {
                 settings[0].jqXHR.abort();
             }
         }
     }
});
// DATATABLE SERVERSIDE CORE
const tblCore2021 = $('#tblCore2021').DataTable({
    // dom: 'rtp',
    ajax: {
      data: (d) => $.extend({}, d, {
        org: null,    // optional
        id_plan: null // optional
      }),
      url: baseurl + "ManufacturingOperationUP2L/Core/buildCDataTable",
      type: 'POST',
    },
    language:{
      processing: "<div class='overlay custom-loader-background'><i class='fa fa-cog fa-spin custom-loader-color' style='color:#fff'></i></div>"
    },
    ordering: false,
    pageLength: 10,
    pagingType: 'first_last_numbers',
    processing: true,
    serverSide: true,
    preDrawCallback: function(settings) {
         if ($.fn.DataTable.isDataTable('#tblCore2021')) {
             var dt = $('#tblCore2021').DataTable();

             //Abort previous ajax request if it is still in process.
             var settings = dt.settings();
             if (settings[0].jqXHR) {
                 settings[0].jqXHR.abort();
             }
         }
     }
});
// DATATABLE SERVERSIDE MIXING
const tblMix2021 = $('#tblMixing2021').DataTable({
    // dom: 'rtp',
    ajax: {
      data: (d) => $.extend({}, d, {
        org: null,    // optional
        id_plan: null // optional
      }),
      url: baseurl + "ManufacturingOperationUP2L/Mixing/buildMixDataTable",
      type: 'POST',
    },
    language:{
      processing: "<div class='overlay custom-loader-background'><i class='fa fa-cog fa-spin custom-loader-color' style='color:#fff'></i></div>"
    },
    ordering: false,
    pageLength: 10,
    pagingType: 'first_last_numbers',
    processing: true,
    serverSide: true,
    preDrawCallback: function(settings) {
         if ($.fn.DataTable.isDataTable('#tblMixing2021')) {
             var dt = $('#tblMixing2021').DataTable();

             //Abort previous ajax request if it is still in process.
             var settings = dt.settings();
             if (settings[0].jqXHR) {
                 settings[0].jqXHR.abort();
             }
         }
     }
});
// DATATABLE SERVERSIDE OTT
const tblOtt2021 = $('#tblMouldingOtt').DataTable({
    // dom: 'rtp',
    ajax: {
      data: (d) => $.extend({}, d, {
        org: null,    // optional
        id_plan: null // optional
      }),
      url: baseurl + "ManufacturingOperationUP2L/OTT/buildOttDataTable",
      type: 'POST',
    },
    language:{
      processing: "<div class='overlay custom-loader-background'><i class='fa fa-cog fa-spin custom-loader-color' style='color:#fff'></i></div>"
    },
    ordering: false,
    pageLength: 10,
    pagingType: 'first_last_numbers',
    processing: true,
    serverSide: true,
    preDrawCallback: function(settings) {
         if ($.fn.DataTable.isDataTable('#tblMouldingOtt')) {
             var dt = $('#tblMouldingOtt').DataTable();

             //Abort previous ajax request if it is still in process.
             var settings = dt.settings();
             if (settings[0].jqXHR) {
                 settings[0].jqXHR.abort();
             }
         }
     }
});
// DATATABLE SERVERSIDE ABSEN
const tblAbs2021 = $('#tblMouldingAbs').DataTable({
    // dom: 'rtp',
    ajax: {
      data: (d) => $.extend({}, d, {
        org: null,    // optional
        id_plan: null // optional
      }),
      url: baseurl + "ManufacturingOperationUP2L/Absen/buildAbsDataTable",
      type: 'POST',
    },
    language:{
      processing: "<div class='overlay custom-loader-background'><i class='fa fa-cog fa-spin custom-loader-color' style='color:#fff'></i></div>"
    },
    ordering: false,
    pageLength: 10,
    pagingType: 'first_last_numbers',
    processing: true,
    serverSide: true,
    preDrawCallback: function(settings) {
         if ($.fn.DataTable.isDataTable('#tblMouldingAbs')) {
             var dt = $('#tblMouldingAbs').DataTable();

             //Abort previous ajax request if it is still in process.
             var settings = dt.settings();
             if (settings[0].jqXHR) {
                 settings[0].jqXHR.abort();
             }
         }
     }
});
// DATATABLE SERVERSIDE SELEP
 $('#tblSelep_ss').DataTable({
    // dom: 'rtp',
    ajax: {
      data: (d) => $.extend({}, d, {
        // org: null,    // optional
        // id_plan: null // optional
      }),
      url: baseurl + "ManufacturingOperationUP2L/Selep/buildSelepDataTable",
      type: 'POST',
    },
    language:{
      processing: "<div class='overlay custom-loader-background'><i class='fa fa-cog fa-spin custom-loader-color' style='color:#fff'></i></div>"
    },
    ordering: false,
    pageLength: 10,
    pagingType: 'first_last_numbers',
    processing: true,
    serverSide: true,
    preDrawCallback: function(settings) {
         if ($.fn.DataTable.isDataTable('#tblSelep_ss')) {
             var dt = $('#tblSelep_ss').DataTable();

             //Abort previous ajax request if it is still in process.
             var settings = dt.settings();
             if (settings[0].jqXHR) {
                 settings[0].jqXHR.abort();
             }
         }
     }
});

// Search Bulan ditampilkan dengan serverside datatable
let cari_mould, refresh_mould = null;

const ref_mould = () =>{
  if (refresh_mould != null){
    refresh_mould.abort();
  }

  $('#sea_month').val(""); //Isi dari kolom bulan akan dihilangkan
  $('#sea_date').val(""); //Isi dari kolom tanggal akan dihilangkan

  refresh_mould = $.ajax({
    url: baseurl + 'ManufacturingOperationUP2L/Moulding/getAjax',
    type: 'POST',
    data:{
      bulan: null,
      tanggal: null,
    },
    cache:false,
    beforeSend: function() {
      $('.area_mould').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <img style="width: 13%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
                                  <span style="font-size:15px;font-weight:bold">Sedang memuat data...</span>
                              </div>`);
    },
    success: function(result) {
      // if (result != 0 && result != 10) {
        $('.area_mould').html(result);
      // }else if (result == 10) {
        // $('.area_mould').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  // <i class="fa fa-remove" style="color:#d60d00;font-size:45px;"></i><br>
                                  // <h3 style="font-size:14px;font-weight:bold">Tidak ada data yang sesuai</h3>
                              // </div>`);
      // }else {
        // toastTCTxc("Warning", "Terdapat Kesalahan saat mengambil data");
      // }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log();
    }
  })
}

const filter_mould = () =>{
  let bulan = $('#sea_month').val();
  let tanggal = $('#sea_date').val();

  if (cari_mould != null){
    cari_mould.abort();
  }

  cari_mould = $.ajax({
    url: baseurl + 'ManufacturingOperationUP2L/Moulding/getAjax',
    type: 'POST',
    data:{
      bulan: bulan,
      tanggal: tanggal,
    },
    cache:false,
    beforeSend: function() {
      $('.area_mould').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <img style="width: 13%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
                                  <span style="font-size:15px;font-weight:bold">Sedang memuat data...</span>
                              </div>`);
    },
    success: function(result) {
      // if (result != 0 && result != 10) {
        $('.area_mould').html(result);
        if (bulan != "") {
          $('#atas').text(`Menampilkan data pada ${bulan}`);
        }else if(tanggal != ""){
          $('#atas').text(`Menampilkan data pada ${tanggal}`);
        }
      // }else if (result == 10) {
        // $('.area_mould').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  // <i class="fa fa-remove" style="color:#d60d00;font-size:45px;"></i><br>
                                  // <h3 style="font-size:14px;font-weight:bold">Tidak ada data yang sesuai</h3>
                              // </div>`);}
      else {
        toastTCTxc("Warning", "Terdapat Kesalahan saat mengambil data");
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log();
    }
  })
}

function up2l_moulding_m() {
  $('#sea_month').prop('readonly', false);
  $('#sea_date').prop('readonly', true);
  $('#sea_date').val("");
}
function up2l_moulding_d() {
  $('#sea_month').prop('readonly', true);
  $('#sea_date').prop('readonly', false);
  $('#sea_month').val("");
}

// if ((bulan2 == null) && (tanggal2 == null)) {
//   $('#sea_date').prop("readonly", false);
//   $('#sea_date').prop("disabled", false);
//   $('#sea_month').prop("readonly", false);
//   $('#sea_month').prop("disabled", false);
// }else if ((bulan2 != null) && (tanggal2 == null)){
//   $('#sea_date').prop("readonly", true);
//   $('#sea_date').prop("disabled", true);
//   $('#sea_month').prop("readonly", false);
//   $('#sea_month').prop("disabled", false);
// }else {
//   $('#sea_date').prop("readonly", false);
//   $('#sea_date').prop("disabled", false);
//   $('#sea_month').prop("readonly", true);
//   $('#sea_month').prop("disabled", true);
// }

// Form Input dinamis scrap
  $('.add_field_scrap').click(function () {
    $('.jsSlcScrap').select2('destroy').end();
    $(this).parent().clone(true).appendTo($("#container-scrap"));
    $('.remove_field_scrap').show();
    $('.jsSlcScrap').select2({
        allowClear: true,
        placeholder: "Choose Scrap",
        ajax: {
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getScrap",
            dataType: 'json',
            type: "post",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.scrap_code + '|' + obj.description,
                            text: obj.scrap_code + " | " + obj.description
                        };
                    })
                };
            }
        }
    });
  });

  $('.remove_field_scrap').click(function () {
    var count = $('#container-scrap').children().length;
    // console.log(count);
    c = count - parseInt(1);
    // console.log(c);

    if (count > 1) {
      $(this).parent().remove();
    }

    if (c == 1) {
      $('.remove_field_scrap').hide();
    }
  });

  // Form Input dinamis bongkar
  $('.add_field_bongkar').click(function () {
    $(this).parent().clone(true).appendTo($("#container-bongkar"));
    $('.remove_field_bongkar').show();
  });

  $('.remove_field_bongkar').click(function () {
    var count = $('#container-bongkar').children().length;
    // console.log(count);
    c = count - parseInt(1);
    // console.log(c);

    if (count > 1) {
      $(this).parent().remove();
    }

    if (c == 1) {
      $('.remove_field_bongkar').hide();
    }
  });


$(document).ready(function () {
    $('.tanggal-up2l').daterangepicker({
      showDropdowns: true,
      autoApply: true,
      todayHighlight: true,
      locale: {
        format: 'YYYY-MM-DD',
        separator: " - ",
        daysOfWeeks: ["Mg", "Sn", "Sl", "Rb", "Km" ,"Jm", "Sa"],
        monthNames: [
          "Januari",
          "Februari",
          "Maret",
          "Apil",
          "Mei",
          "Juni",
          "Juli",
          "Agustus",
          "September",
          "Oktober",
          "November",
          "Desember",
        ]
      },
    })

    $('.onBtn').click(function () {
        $('.onBtn').hide();
        $('.offBtn').show();
        $('input[name="txtJamPemotonganTarget"]').prop("disabled", false);
        $('input[name="txtKeteranganPemotonganTarget"]').val('');
        $('input[name="txtKeteranganPemotonganTarget"]').attr('maxlength','18');
    });

    $('.offBtn').click(function () {
        $('.onBtn').show();
        $('.offBtn').hide();
        $('input[name="txtJamPemotonganTarget"]').prop("disabled", true);
        $('input[name="txtKeteranganPemotonganTarget"]').val('');
        $('input[name="txtKeteranganPemotonganTarget"]').attr('maxlength','29');
    });

    $(function() {
      $('input[name="txtJamPemotonganTarget"]').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 1,
            timePickerSeconds: false,
            locale: {
                format: 'HH:mm'
            }
      }).on('show.daterangepicker', function (ev, picker) {
            picker.container.find(".calendar-table").hide();
      });
    });

    var tblItem = $('#masterItem').DataTable({
        dom: 'Bfrtip',
        columnDefs: [
            {
                orderable: false,
                className: 'select-checkbox',
                targets: 1
            }
        ],
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Master_Item ' + Math.random(),
                exportOptions: {
                    columns: ':visible',
                    modifier: {
                        selected: true
                            },
                    columns: [12, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                }
            }
        ],
        select: {
            style: 'multi',
            selector: 'td:nth-child(2)'
        },
        order: [[12, 'asc']],
        scrollX: true
    });
})

$('#tblCore').DataTable({
    dom: 'frtip'
});
$('#tblMixing').DataTable({
    dom: 'frtip'
});
$('#tblMoulding').DataTable({
    dom: 'frtip'
}); //Ngaruh di absen dan OTT, nggak disentuh total sama edwin

$('#tblQualityControl').DataTable({
    initComplete: function () {
        this.api()
            .columns([5])
            .every(function () {
                var thsUP2L1 = this;
                var slcUP2L1 = $(
                        '<select class="form-control"><option selected value="">Semua Shift</option></select>'
                    )
                    .appendTo("#searchShiftUP2L")
                    .on("change", function () {
                        var val1 = $.fn.dataTable.util.escapeRegex($(this).val());
                        thsUP2L1.search(val1 ? "^" + val1 + "$" : "", true, false).draw();
                    });
                thsUP2L1
                    .data()
                    .unique()
                    .sort()
                    .each(function (d, j) {
                        slcUP2L1.append('<option value="' + d + '">' + d + "</option>");
                    });
            });
        this.api()
            .columns([11])
            .every(function () {
                var thsUP2L1 = this;
                var slcUP2L1 = $(
                        '<select class="form-control"><option selected value="">Semua Employee</option></select>'
                    )
                    .appendTo("#searchEmpUP2L")
                    .on("change", function () {
                        var val1 = $.fn.dataTable.util.escapeRegex($(this).val());
                        thsUP2L1.search(val1 ? "^" + val1 + "$" : "", true, false).draw();
                    });
                thsUP2L1
                    .data()
                    .unique()
                    .sort()
                    .each(function (d, j) {
                        slcUP2L1.append('<option value="' + d + '">' + d + "</option>");
                    });
            });
    },
    dom: 'frtip'
});
$('#tblSelep').DataTable({
    initComplete: function () {
        this.api()
            .columns([7])
            .every(function () {
                var thsUP2L1 = this;
                var slcUP2L1 = $(
                        '<select class="form-control"><option selected value="">Semua Shift</option></select>'
                    )
                    .appendTo("#searchSShiftUP2L")
                    .on("change", function () {
                        var val1 = $.fn.dataTable.util.escapeRegex($(this).val());
                        thsUP2L1.search(val1 ? "^" + val1 + "$" : "", true, false).draw();
                    });
                thsUP2L1
                    .data()
                    .unique()
                    .sort()
                    .each(function (d, j) {
                        slcUP2L1.append('<option value="' + d + '">' + d + "</option>");
                    });
            });
        this.api()
            .columns([8])
            .every(function () {
                var thsUP2L1 = this;
                var slcUP2L1 = $(
                        '<select class="form-control"><option selected value="">Semua Employee</option></select>'
                    )
                    .appendTo("#searchSEmpUP2L")
                    .on("change", function () {
                        var val1 = $.fn.dataTable.util.escapeRegex($(this).val());
                        thsUP2L1.search(val1 ? "^" + val1 + "$" : "", true, false).draw();
                    });
                thsUP2L1
                    .data()
                    .unique()
                    .sort()
                    .each(function (d, j) {
                        slcUP2L1.append('<option value="' + d + '">' + d + "</option>");
                    });
            });
    },
    dom: 'frtip'
});
$('#jobTable').DataTable({
    dom: 'frtip'
});
$('#rejectTable').DataTable({
    dom: 'frtip'
});
$('#MasterPersonal').DataTable({
    dom: 'frtip'
});
$('#masterScrap').DataTable({
    dom: 'frtip'
});
// $('#tglBerlaku').datepicker({
//     format: 'mm/dd/yyyy',
//     container: container,
//     todayHighlight: true,
//     autoclose: true,
// });

function getCompDescMO(th) {
    var val = $(th).val();
    var desc = val.split('|');
    desc = desc[1];
    $('input[name="component_description"]').val(desc);
}

$(window).load(function () {
    $('.slcUP2L2021').select2({
        placeholder: "",
    });

    $('.slcShift').select2({
        placeholder: "Shift",
    });

    $('.jsSlcComp').select2({
        allowClear: true,
        placeholder: "Choose Component Code",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getComponent",
            dataType: 'json',
            type: "post",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.kode_barang + " | " + obj.nama_barang + ' | ' + obj.kode_proses,
                            text: obj.kode_barang + " | " + obj.nama_barang + ' | ' + obj.kode_proses
                        };
                    })
                };
            },
            error: function (error, status) {
                console.log(error);
            }
        }
    });

    $('.jsSlcEmpl').select2({
        allowClear: true,
        placeholder: "Choose Employee",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getEmployee",
            dataType: 'json',
            type: "post",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.no_induk + '|' + obj.nama,
                            text: obj.no_induk + " | " + obj.nama
                        };
                    })
                };
            }
        }
    });

    $('.jsSlcScrap').select2({
        allowClear: true,
        placeholder: "Choose Scrap",
        ajax: {
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getScrap",
            dataType: 'json',
            type: "post",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.scrap_code + '|' + obj.description,
                            text: obj.scrap_code + " | " + obj.description
                        };
                    })
                };
            }
        }
    });


    $('.add_emp').click(function () {
        $('.jsSlcEmpl').select2('destroy').end();
        $(this).parent().clone(true).appendTo($("#container-employee"));
        $('.remove_emp').show();
        $('.jsSlcEmpl').select2({
            allowClear: true,
            placeholder: "Choose Employee",
            minimumInputLength: 3,
            ajax: {
                url: baseurl + "ManufacturingOperationUP2L/Ajax/getEmployee",
                dataType: 'json',
                type: "post",
                data: function (params) {
                    var queryParameters = {
                        term: params.term
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (obj) {
                            return {
                                id: obj.no_induk + '|' + obj.nama,
                                text: obj.no_induk + " | " + obj.nama
                            };
                        })
                    };
                }
            }
        });
    });


    $('.remove_emp').click(function () {
        var count = $('#container-employee').children().length;
        // console.log(count);
        c = count - parseInt(1);
        // console.log(c);

        if (count > 1) {
            $(this).parent().remove();
        }

        if (c == 1) {
            $('.remove_emp').hide()
        }
    });

    $('.selcDateUp2L').datepicker({
        autoclose: true,
        format: 'yyyy/mm/dd',
        todayHighlight: true
    });

    $('.time-form1.ajaxOnChange').datepicker({
        autoclose: true,
        format: 'yyyy/mm/dd',
        todayHighlight: true
    });

    $('.time-form1.ajaxOnChange').on('change', function (ev, picker) {
        $('.slcShift').val('').trigger('change');
        if ($('.time-form1').val() == '' || $('.time-form1').val() == null) {
            $('div#print_code_area').html('<div class="col-md-6">' +
                '<small>-- Select production date to generate print code --</small>' +
                '</div>');
        } else {
            $.ajax({
                url: baseurl + 'ManufacturingOperationUP2L/Ajax/getPrintCode',
                type: 'post',
                data: {
                    tanggal: $('.time-form1.ajaxOnChange').val()
                },
                beforeSend: function () {
                    $('div#print_code_area').html('<img src="' + baseurl + 'assets/img/gif/loading5.gif" style="width: auto; padding-left: 25px;">');
                },
                success: function (results) {
                    $('div#print_code_area').html(results);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
                }
            });
        }

        //SHIFT
        $.ajax({
            type: "POST",
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/getShift',
            data: {
                tanggal: $('.time-form1.ajaxOnChange').val()
            },
            dataType: "JSON",
            beforeSend: function () {
              toastup2lLoading('Sedang Memuat Data Shift..');
            },
            success: function (response) {
                //console.log(response);
                swal.close();
                var html = '';
                html += '<option></option>';
                for (var i = 0; i < response.length; i++) {
                    if (i == 0) {
                        html += '<option value="' + response[i]['DESCRIPTION'] + '">' + response[i]['DESCRIPTION'] + '</option>';
                    } else {
                        html += '<option value="' + response[i]['DESCRIPTION'] + '">' + response[i]['DESCRIPTION'] + '</option>';
                    }
                }
                $('.slcShift').html(html);
            }
        });

    });
});

function getJobData(th) {
    event.preventDefault();
    $.ajax({
        url: baseurl + 'ManufacturingOperationUP2L/Ajax/getJobData',
        type: 'post',
        data: $(th).serialize(),
        beforeSend: function () {
            $('div#jobTableArea').html('<img src="' + baseurl + 'assets/img/gif/loading5.gif" style="width: auto;">');
        },
        success: function (results) {
            $('div#jobTableArea').html(results);
            $('#jobTable').DataTable({
                dom: 'rtBp',
                buttons: ['excel', 'pdf']
            });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('div#jobTableArea').html('');
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
}

function modalReject(th, rowid) {
    $('form#rejectForm input[name="rowID"]').val(rowid);

    var jobNumber = $('div#parentData input[name="jobNumber"').val();
    var assyCode = $('div#parentData input[name="assyCode"').val();
    var assyDesc = $('div#parentData input[name="assyDesc"').val();
    var section = $('div#parentData input[name="section"').val();
    $('form#rejectForm input[name="jobNumber"]').val(jobNumber);
    $('form#rejectForm input[name="assyCode"]').val(assyCode);
    $('form#rejectForm input[name="assyDesc"]').val(assyDesc);
    $('form#rejectForm input[name="section"]').val(section);

    var compCode = $(th).closest('tr').find('input[name="compCode"]').val();
    var compDesc = $(th).closest('tr').find('input[name="compDesc"]').val();
    var qty = $(th).closest('tr').find('input[name="qty"]').val();
    var uom = $(th).closest('tr').find('input[name="uom"]').val();
    var subinv = $(th).closest('tr').find('input[name="subinv"]').val();
    $('form#rejectForm input[name="compCode"]').val(compCode);
    $('form#rejectForm input[name="compDesc"]').val(compDesc);
    $('form#rejectForm input[name="qty"]').val(qty);
    $('form#rejectForm input[name="uom"]').val(uom);
    $('form#rejectForm input[name="subinv"]').val(subinv);

    var qtyReject = $(th).closest('tr').find('td.rejectArea').attr('data-reject');
    var maxReturn = Number(qty) - Number(qtyReject);
    $('form#rejectForm input[name="returnQty"]').attr('max', maxReturn);
    $('form#rejectForm input[name="returnQty"]').val('');
    $('form#rejectForm textarea[name="returnInfo"]').val('');

    $('#rejectForm #btnSubmit').html('PROCEED');
    $('#modalReject').modal('show');
}

function proceedRejectComp() {
    event.preventDefault();
    var rowid = $('form#rejectForm input[name="rowID"]').val();
    $.ajax({
        type: 'POST',
        url: baseurl + 'ManufacturingOperationUP2L/Ajax/setRejectComp',
        data: $('form#rejectForm').serialize(),
        beforeSend: function () {
            $('#rejectForm #btnSubmit').html('<i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>');
        },
        success: function (results) {
            var data = JSON.parse(results);
            $('#rejectTable').DataTable().destroy();
            var rowCount = $('table#rejectTable tbody tr').length;
            var rowNumb = rowCount + 1;
            var rejectQty = $('table#jobTable tbody tr[row-id="' + rowid + '"] td.rejectArea').attr('data-reject');
            var picklistQty = $('table#jobTable tbody tr[row-id="' + rowid + '"] input[name="qty"]').val();
            var newRjctQty = Number(rejectQty) + Number(data[0]['return_quantity']);

            if ($('#generateBtnArea .btnReject').attr('disabled', true)) {
                $('#generateBtnArea .btnReject').attr('disabled', false);
            }
            $('table#jobTable tbody tr[row-id="' + rowid + '"] td.rejectArea').html(newRjctQty);
            if (newRjctQty == picklistQty) {
                $('table#jobTable tbody tr[row-id="' + rowid + '"] button').attr('disabled', true);
            }
            $('table#jobTable tbody tr[row-id="' + rowid + '"] td.rejectArea').attr('data-reject', newRjctQty);

            var deleteSendData = data[0]['replacement_component_id'] + "," + rowNumb + "," + rowid;
            var newRow = jQuery("<tr row-id='" + rowNumb + "'>" +
                "<td>" + rowNumb + "</td>" +
                "<td>" + data[0]['component_code'] + "</td>" +
                "<td>" + data[0]['component_description'] + "</td>" +
                "<td>" + data[0]['return_quantity'] + "</td>" +
                "<td>" + data[0]['uom'] + "</td>" +
                "<td>" + data[0]['return_information'] + "</td>" +
                "<td>" + data[0]['subinventory_code'] + "</td>" +
                "<td>" +
                "<a onclick='deleteRejectComp(" + deleteSendData + ");' class='btn btn-danger btn-block' data-toggle='tooltip' data-placement='left' title='Remove Reject Component'><i class='fa fa-minus'></i></a>" +
                "</td>" +
                "</tr>");
            jQuery("table#rejectTable").append(newRow);
            var subInvData = $('#modalFormReject input[name="subInvData"]').val();
            if (subInvData.trim() == '') {
                $('#modalFormReject input[name="subInvData"]').val(data[0]['subinventory_code']);
                $('#modalFormReject #subinvArea').html('<input type="radio" value="' + data[0]['subinventory_code'] + '"> ' + data[0]['subinventory_code']);
            } else {
                var subInvDataArr = subInvData.split(',');
                if (jQuery.inArray(data[0]['subinventory_code'], subInvDataArr) == -1) {
                    var subInvDataVal = subInvData + ',' + data[0]['subinventory_code'];
                    $('#modalFormReject input[name="subInvData"]').val(subInvDataVal);
                    $('#modalFormReject #subinvArea').html('<input type="radio" value="' + data[0]['subinventory_code'] + '"> ' + data[0]['subinventory_code']);
                }
            }
            $('#rejectTable').DataTable({
                dom: 'frtip'
            });
            $('#modalReject').modal('hide');
            $.toaster('New Reject Component Recorded!', 'Success', 'success');
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#modalReject').modal('hide');
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
}

function deleteRejectComp(replacement_component_id, rowNumb, rowid) {
    $.ajax({
        url: baseurl + 'ManufacturingOperationUP2L/Ajax/deleteRejectComp/' + replacement_component_id,
        success: function (results) {
            var data = JSON.parse(results);
            $('table#rejectTable tbody tr[row-id="' + rowNumb + '"]').remove();
            $('#rejectTable').DataTable().destroy();
            var rowCount = $('table#rejectTable tbody tr').length;
            if (rowCount == 0) {
                $('#generateBtnArea .btnReject').attr('disabled', true);
            }
            var rejectQty = $('table#jobTable tbody tr[row-id="' + rowid + '"] td.rejectArea').attr('data-reject');
            var newRjctQty = Number(rejectQty) + Number(data[0]['return_quantity']);
            $('table#jobTable tbody tr[row-id="' + rowid + '"] td.rejectArea').attr('data-reject', newRjctQty);
            $('#rejectTable').DataTable({
                dom: 'frtip'
            });
            $.toaster('Data was deleted!', 'Deleted', 'success');
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
}

function submitJobKIB(th, jobID) {
    window.open(baseurl + 'ManufacturingOperationUP2L/Job/ReplaceComp/submitJobKIB/' + jobID, '_blank');
}

function deleteMasterItem(id, rowid) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if (confirmDel) {
        $('.hapus').prop('disabled', true);
        $('tr[row-id="' + rowid + '"]').find('i.fa-trash').addClass('fa-spinner fa-spin').removeClass('fa-trash');
        $('.edit').prop('disabled', true);
        $.ajax({
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/deleteItem/' + id,
            success: function (results) {
                var data = JSON.parse(results);
                $('table#masterItem').DataTable().destroy();
                $('table#masterItem tbody tr[row-id="' + rowid + '"]').remove();
                $('table#masterItem').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['excel', 'pdf']
                });
                $.toaster('Data was deleted!', 'Deleted', 'success');
                $('.hapus').prop('disabled', false);
                $('tr[row-id="' + rowid + '"]').find('i.fa-trash').removeClass('fa-spinner fa-spin').addClass('fa-trash');
                $('.edit').prop('disabled', false);

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
            }
        })
    }
}

function editScr(th) {
    var qtyScr = $('#editQtyScrap' + th).html();
    var ambilScr = $('#editTypeScrap' + th).html();
    var ambilCdScr = $('#editCodeScrap' + th).html();

    $('.btnSubmitScrap').attr('onclick', 'updScr(' + th + ')');
    var valScrap = ambilCdScr + " | " + ambilScr;
    console.log(valScrap);

    // var optSlcScr = '<option selected value="' + valScrap + '">' + valScrap + '</option>';
    // var txtSlcdScrap = '<option selected value="' + valScrap + '">' + valScrap +'</option>';
    // $('#txtMdlScrap').val(ambilScr);
    // $('#txtMdlScrap').append(optSlcScr);
    // $('#txtMdlScrap option[value=' + valScrap +']').attr('selected', 'selected');
    // $('#txtScrap').val(type).change();
    // $('#mdlSlcBarang').val('1').trigger('change')
    // $('#mdlSlcBarang').select2({ id: valScrap2, text: valScrap2})
    // $('#mdlSlcBarang').val(valScrap2, 'selected');

    $('#txtMdlScrap').val(ambilCdScr + " | " + ambilScr).trigger('change');
    $('#newQtyScrap').val(qtyScr);
    $('#mdlEditScrap').modal('show');
}

function updScr(th) {
    var idScr = th;
    var qtyScr = $('#newQtyScrap').val();
    var typeScr = $('#txtMdlScrap').val();
    var splttypeScr = typeScr.split("|");

    $.ajax({
        method: 'POST',
        dataType: 'JSON',
        url: baseurl + "ManufacturingOperationUP2L/Moulding/updScr",
        data: {
            idScr: idScr,
            qtyScr: qtyScr,
            typeScr: typeScr
        },
        success: function (response) {
            if (response == 1) {
                $('#editTypeScrap' + th).html(splttypeScr[1]);
                $('#editCodeScrap' + th).html(splttypeScr[0]);
                $('#editQtyScrap' + th).html(qtyScr);
                $('#mdlEditScrap').modal('hide');
            }
        }
    })
}

function editBon(th) {

    var qtyBon = $('#editQtyBongkar' + th).html();
    // console.log(qtyBon);

    $('.btnSubmitBongkar').attr('onclick', 'updBon(' + th + ')');

    $('#newQtyBongkar').val(qtyBon);
    $('#mdlEditBongkar').modal('show');
}

function updBon(th) {
    var idBongkar = th;
    var qtyBon = $('#newQtyBongkar').val();

    $.ajax({
        method: 'POST',
        dataType: 'JSON',
        url: baseurl + "ManufacturingOperationUP2L/Moulding/updBon",
        data: {
            idBongkar: idBongkar,
            qtyBon: qtyBon,
        },
        success: function (response) {
            if (response == 1) {
                $('#editQtyBongkar' + th).html(qtyBon);
                $('#mdlEditBongkar').modal('hide');
            }
        }
    })
}

function delScr(ths) {
    $.ajax({
        method: 'post',
        url: baseurl + 'ManufacturingOperationUP2L/Moulding/delScr/' + ths,
        dataType: 'json',
        success: function (response) {
            if (response == 1) {
                $('tr[data="' + ths + '"]').remove()
            }
        }
    })
}

function delBon(ths) {
    $.ajax({
        method: 'post',
        url: baseurl + 'ManufacturingOperationUP2L/Moulding/delBon/' + ths,
        dataType: 'json',
        success: function (response) {
            if (response == 1) {
                $('tr[data="' + ths + '"]').remove()
            }
        }
    })
}

function deleteMasterScrap(id, rowid) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if (confirmDel) {
        $('.hapus').prop('disabled', true);
        $('tr[row-id="' + rowid + '"]').find('i.fa-trash').addClass('fa-spinner fa-spin').removeClass('fa-trash');
        $('.edit').prop('disabled', true);
        $.ajax({
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/deleteScrap/' + id,
            success: function (results) {
                var data = JSON.parse(results);
                $('table#masterScrap').DataTable().destroy();
                $('table#masterScrap tbody tr[row-id="' + rowid + '"]').remove();
                $('table#masterScrap').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['excel', 'pdf']
                });
                $.toaster('Data was deleted!', 'Deleted', 'success');
                $('.hapus').prop('disabled', false);
                $('tr[row-id="' + rowid + '"]').find('i.fa-trash').removeClass('fa-spinner fa-spin').addClass('fa-trash');
                $('.edit').prop('disabled', false);

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
            }
        })
    }
}

function deleteMasterPersonal(id, rowid) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if (confirmDel) {
        $('.hapus').prop('disabled', true);
        $('tr[row-id="' + rowid + '"]').find('i.fa-trash').addClass('fa-spinner fa-spin').removeClass('fa-trash');
        $('.edit').prop('disabled', true);
        $.ajax({
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/deletePerson/' + id,
            success: function (results) {
                var data = JSON.parse(results);
                $('table#MasterPersonal').DataTable().destroy();
                $('table#MasterPersonal tbody tr[row-id="' + rowid + '"]').remove();
                $('table#MasterPersonal').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['excel', 'pdf']
                });
                $.toaster('Data was deleted!', 'Deleted', 'success');
                $('.hapus').prop('disabled', false);
                $('tr[row-id="' + rowid + '"]').find('i.fa-trash').removeClass('fa-spinner fa-spin').addClass('fa-trash');
                $('.edit').prop('disabled', false);

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
            }
        })
    }
}

function editMasterItem(id) {
    $.ajax({
        url: baseurl + 'ManufacturingOperationUP2L/Ajax/editItem/' + id,
        success: function (results) {
            console.log(results);
            $('#editMasterItem').html(results);
        },
        error: function (results) {
            console.log('error');
        }
    })
}

function editMasterScrap(id) {
    $.ajax({
        url: baseurl + 'ManufacturingOperationUP2L/Ajax/editScrap/' + id,
        success: function (results) {
            console.log(results);
            $('#editMasterScrap').html(results);
        },
        error: function (results) {
            console.log('error');
        }
    })
}

function editMasterPerson(id) {
    $.ajax({
        url: baseurl + 'ManufacturingOperationUP2L/Ajax/editPerson/' + id,
        success: function (results) {
            console.log(results);
            $('#editMasterPerson').html(results);
        },
        error: function (results) {
            console.log('error');
        }
    })
}

function swnKuburan(th) {
    $('#inPuY').html('<img src="' + baseurl + 'assets/img/gif/loading5.gif" style="width: auto;">');
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: baseurl + "ManufacturingOperationUP2L/QualityControl/swnKuburan/" + th,
        beforeSend: function () {
            event.preventDefault();
        },
        success: function (res) {
            $('#component_code').val(res[0].component_code);
            $('#description').val(res[0].component_description);
            $('#production_date').val(res[0].selep_date.replace(" 00:00:00", ""));
            $('#shift').val(res[0].shift);
            $('#job_id').val(res[0].job_id);
            $('#selep_qty').val(res[0].selep_quantity);
            $('#mould_id').val(res[0].selep_id);
            $('#inPuY').html(`
            <br>
            <label for="checking_qty" class="control-label col-lg-6">Hasil Baik</label>
            <div class="col-lg-4">
            <input class="form-control" id="checking_qty" type="number" placeholder="Hasil Baik"> <br />
            </div>
            <label for="reject_qty" class="control-label col-lg-6">Jumlah Reject</label>
            <div class="col-lg-4">
            <input class="form-control" id="reject_qty" type="number" placeholder="Jumlah Reject" value="0"> <br />
            </div>
            <label for="repair_qty" class="control-label col-lg-6">Jumlah Repair</label>
            <div class="col-lg-4">
            <input class="form-control" id="repair_qty" type="number" placeholder="Jumlah Repair" value="0"> <br />
            </div>
            <br>`);
        },
        error: function (a, b, c) {
            console.log(b+c+a);
        }
    });
}

function checkQuantity(th) {
    var id = $('#mould_id').val().trim();
    var repair = $('#repair_qty').val().trim(); //input sendiri
    var scrap = $('#reject_qty').val().trim(); //input sendiri
    var quantity = $('#checking_qty').val().trim(); //input sendiri

    var date = $('#production_date').val().trim();
    var selep_qty = $('#selep_qty').val().trim();
    var employee = $('#job_id').val().trim();
    var component = $('#component_code').val().trim();
    var description = $('#description').val().trim();
    var shift = $('#shift').val().trim();
    var re = parseInt(selep_qty) - parseInt(quantity);

    if ((parseInt(scrap) + parseInt(quantity) + parseInt(repair)) > parseInt(selep_qty)) {
        alert('Jumlah melebihi quantity');
    } else {
        $.ajax({
            type: 'post',
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/addQuality',
            data: {
                REPAIR: repair,
                SCRAP: scrap,
                CHECK: quantity,
                CHECKING_DATE: date,
                COMPONENT: component,
                REMAIN: re,
                SHIFT: shift,
                EMPLOYEE: employee,
                DESCRIPTION: description,
                SELEPQTY: selep_qty,
                ID: id
            },
            success: function (results) {
                window.location.replace(baseurl + 'ManufacturingOperationUP2L/QualityControl');

            },
            error: function (error, status, f, s) {
                console.log(error);
            }
        });
    }
}

$('.add_scrap').click(function () {
    var type = [];
    var qty = [];
    $('.txtScrap').each((i,v)=>{
      type.push($(v).val());
    });
    $('.scrap_qty').each((i,v)=>{
      qty.push($(v).val());
    });
    var mould_qty = $('#mould_qty').val();
    var id = $('#mould_id').val();
    var jml = $('#jumlah_scrap').val();
    if (jml == '-') {
        total = parseInt(0);
    } else {
        total = jml;
    }
    var jumlah = parseInt(qty) + parseInt(total);

    console.log(jumlah);
    if (jumlah > mould_qty) {
        alert('Jumlah scrap melebihi quantity moulding');
    } else {
        $.ajax({
            type: 'post',
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/addScrap/',
            data: {
                id: id,
                qty: qty,
                type: type
            },
            success: function (results) {
                location.reload();
            },
            error: function (results) {
                alert('error');
            }
        });
    }
})

$('.add_bongkar').click(function () {
    var qty = [];
    $('.bongkar_qty').each((i,v)=>{
      qty.push($(v).val());
    })
    var mould_qty = $('#mould_qty').val();
    var id = $('#mould_id').val();
    var jml = $('#jumlah_bongkar').val();

    console.log(qty);
    console.log(mould_qty);
    console.log(id);
    console.log(jml);

    if (jml == '-') {
        total = parseInt(0);
    } else {
        total = jml;
    }

    var jumlah = parseInt(qty) + parseInt(total);

    console.log(jumlah);
    if (jumlah > mould_qty) {
        alert('Jumlah bongkar melebihi quantity moulding');
    } else {
        $.ajax({
            type: 'post',
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/addBongkar/',
            data: {
                id: id,
                qty: qty
            },
            success: function (results) {
                location.reload();
            },
            error: function (results) {
                alert('error');
            }
        });
    }
})

$("#tanggal_cetak").on("click", function () {

    var val = $('.time-form').val();
    console.log(val);

    $.ajax({
        url: baseurl + 'ManufacturingOperationUP2L/Ajax/getDatePrintCode',
        type: 'post',
        dataType: 'json',
        data: {
            TANGGAL: val
        },
        beforeSend: function () {
            $('div#jobTableArea').html('<img src="' + baseurl + 'assets/img/gif/loading5.gif" style="width: auto;">');
        },
        complete: function () {

        },
        success: function (results) {
            $("#tableQuality").empty();
            var html = '';
            $.each(results, function (i, data) {
                html += "<tr><td align='center'>" + (i + 1) + "</td>" +
                    "<td align='center'>" +
                    "<a href='" + baseurl + "ManufacturingOperationUP2L/QualityControl/read_detail/" + data.selep_id + "' data-toggle='tooltip' data-placement='bottom' title='Read Data'><i class='fa fa-list-alt fa-2x'></i></a>" +
                    "</td>" +
                    "<td>" + data.component_code + "</td>" +
                    "<td>" + data.component_description + "</td>" +
                    "<td>" + data.selep_date + "</td>" +
                    "<td>" + data.shift + "</td>" +
                    "<td>" + data.selep_quantity + "</td>" +
                    "<td>" + data.job_id + "</td></tr>";
            });

            $("#tableQuality").append(html);

        },
        error: function (textStatus, errorThrown) {
            $('div#jobTableArea').html('');
            console.log(textStatus);
            $.toaster(textStatus + ' | ' + errorThrown, name, 'danger');
        }
    });
});

function searchDateUP2L() {
    var dateQCUp2l = $('#dateQCUp2l').val();
    if (dateQCUp2l == ''){}
    else{
        $.ajax({
        dataType:"JSON",
        type:"POST",
        url: baseurl + 'ManufacturingOperationUP2L/QualityControl/selectByDate',
        data:{
            dateQCUp2l:dateQCUp2l
        },
        success: function () {
            alert('sukses')
        }
    })
    }
};

// QC Checking Qty OK dan Scrap

$('#mo_txtScrapQuantityHeader').on('change', function () {
    var txtSelepQuantityHeader = Number($('#mo_txtSelepQuantityHeader').val());
    var txtCheckingQuantityHeader = Number($('#mo_txtCheckingQuantityHeader').val());
    var txtScrapQuantityHeader = Number($('#mo_txtScrapQuantityHeader').val());
    if ((txtCheckingQuantityHeader + txtScrapQuantityHeader) >  txtSelepQuantityHeader) {
        alert("Jumlah Checking ditambah Scrap melebihi Selep Qty");
        $('#mo_txtCheckingQuantityHeader').val('');
    } else { }
})
$('#mo_txtCheckingQuantityHeader').on('change', function () {
    var txtSelepQuantityHeader = Number($('#mo_txtSelepQuantityHeader').val());
    var txtCheckingQuantityHeader = Number($('#mo_txtCheckingQuantityHeader').val());
    var txtScrapQuantityHeader = Number($('#mo_txtScrapQuantityHeader').val());
    if ((txtCheckingQuantityHeader + txtScrapQuantityHeader) >  txtSelepQuantityHeader) {
        alert("Jumlah Checking ditambah Scrap melebihi Selep Qty");
        $('#mo_txtScrapQuantityHeader').val('');
    } else { }
})

$(function () {
    $('#mo_button1').addClass('active');
    $('#mo_tab2').css("display", "none");
    $('#sear_2').css("display", "none");

    $('#ottShift').select2({
        allowClear: true,
        tags: true,
        placeholder: "ex : SHIFT 1",
        minimumInputLength: 7,
        ajax : {
            type: "GET",
            placeholder: 'Shift',
            url: baseurl + 'ManufacturingOperationUP2L/Ajax/getAllShift',
            dataType: "JSON",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                };
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.DESCRIPTION,
                            text: obj.DESCRIPTION
                        };
                    })
                };
            }
        }
    })
});

$('#mo_button1').click(function () {
    $('#mo_button1').addClass('active');
    $('#mo_button2').removeClass('active');
    $('#mo_tab2').css("display", "none");
    $('#mo_tab1').removeAttr('style');
    $('#sear_2').css("display", "none");
    $('#sear_1').removeAttr('style');
})

$('#mo_button2').click(function () {
    $('#mo_button2').addClass('active');
    $('#mo_button1').removeClass('active');
    $('#mo_tab1').css("display", "none");
    $('#mo_tab2').removeAttr('style');
    $('#sear_1').css("display", "none");
    $('#sear_2').removeAttr('style');
})

if($('#up2l_tmpl').val() == 'A1'){
    $('#mo_button2').hide();
    jQuery(function(){
        jQuery('#mo_button1').click();
     });
} else if ($('#up2l_tmpl').val() == 'A2'){
    $('#mo_button1').hide();
    jQuery(function(){
        jQuery('#mo_button2').click();
     });
}

$(function(){
    $('.ott_Name').select2();
    $('.ott_Abs').select2();
    $('#ottKodeP').select2();
})

$('.ottPlusBtn').click(function () {
  $('.ott_Name').select2('destroy').end();
  $(this).parent().clone(true).appendTo($('#container-emplott'));
  $('.ottTimesBtn').show();
  // var ottPlus =
  // `<br /><br /><select name="ottName[]" id="ott_Name" class="form-control ottName" required>
  // <option value="">Pilih Pekerja</option>
  // <option name="ottName" value="<?= $pekerja?>"><?= $pekerja?></option>
  // </select>`;
  //
  // $('#tmpNama').append(ottPlus);
  $('.ott_Name').select2(/*{
      minimumInputLength: 0,
      placeholder: 'Pilih Pekerja',
      allowClear: true,
      ajax: {
          method: 'GET',
          url: baseurl + 'ManufacturingOperationUP2L/Absen/pekerja',
          dataType: 'JSON',
          data: function (param) {
              return param.term
          },
          processResults: function (data) {
              return {
                  results: $.map(data, function (obj) {
                      return {
                          id: obj.no_induk + " | " + obj.nama,
                          text: obj.no_induk + " | " + obj.nama
                      };
                  })
              };
          }
      }
  }*/);
});

$('.ottTimesBtn').click(function () {
  var count = $('#container-emplott').children().length;
  // console.log(count);
  c = count - parseInt(1);
  // console.log(c);

  if (count > 1) {
    $(this).parent().remove();
  }
  if (c == 1) {
    $('.ottTimesBtn').hide();
  }
});

$('.addComp').click(function () {
    $('.jsSlcComp').select2('destroy').end();
    $(this).parent().clone(true).appendTo($("#container-comp"));
    $('.delComp').show();
    // var addCompMould =
    // `<hr><br /><div class="form-group">
    //     <label for="txtComponentCodeHeader" class="control-label col-lg-4">Component</label>
    //     <div class="col-lg-6">
    //         <select class="form-control jsSlcComp toupper" id="txtComponentCodeHeader" name="component_code[]" required data-placeholder="Component Code" onchange="getCompDescMO(this)">
    //             <option></option>
    //         </select>
    //     </div>
    // </div>
    //
    // <div class="form-group">
    //     <label for="txtMouldingQuantityHeader" class="control-label col-lg-4">Moulding Quantity</label>
    //     <div class="col-lg-6">
    //         <input type="number" placeholder="Moulding Quantity" name="txtMouldingQuantityHeader[]" id="txtMouldingQuantityHeader" class="form-control" />
    //     </div>
    // </div>`;
    // $('#container-component').append(addCompMould);
    $('.jsSlcComp').select2({
        allowClear: true,
        placeholder: "Choose Component Code",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getComponent",
            dataType: 'json',
            type: "post",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.kode_barang + " | " + obj.nama_barang + ' | ' + obj.kode_proses,
                            text: obj.kode_barang + " | " + obj.nama_barang + ' | ' + obj.kode_proses
                        };
                    })
                };
            },
            error: function (error, status) {
                console.log(error);
            }
        }
    });
});

$('.delComp').click(function () {
    var count = $('#container-comp').children().length;
    // console.log(count);
    c = count - parseInt(1);
    // console.log(c);

    if (count > 1) {
      $(this).parent().remove();
    }

    if (c == 1) {
      $('.delComp').hide();
    }
});

function addcompSelep() {
    var addCompMould =
    `<hr><br /><div class="form-group">
        <label for="txtComponentCodeHeader" class="control-label col-lg-4">Component</label>
        <div class="col-lg-6">
            <select class="form-control jsSlcComp toupper" id="txtComponentCodeHeader" name="component_code[]" required data-placeholder="Component Code">
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="txtSelepQuantityHeader" class="control-label col-lg-4">Selep Quantity</label>
        <div class="col-lg-6">
            <input type="number" placeholder="Selep Quantity" name="txtSelepQuantityHeader[]" id="txtSelepQuantityHeader" class="form-control" />
        </div>
    </div>

    <div class="form-group">
        <label for="txtKeterangan" class="control-label col-lg-4">Keterangan</label>
        <div class="col-lg-6">
            <select name="txtKeterangan[]" class="form-control">
                <option value="">null</option>
                <option value="RE">RE</option>
            </select>
        </div>
    </div>`;
    $('#container-component').append(addCompMould);
    $('.jsSlcComp').select2({
        allowClear: true,
        placeholder: "Choose Component Code",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getComponent",
            dataType: 'json',
            type: "post",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.kode_barang + " | " + obj.nama_barang + ' | ' + obj.kode_proses,
                            text: obj.kode_barang + " | " + obj.nama_barang + ' | ' + obj.kode_proses
                        };
                    })
                };
            },
            error: function (error, status) {
                console.log(error);
            }
        }
    });
}

function delcompSelep() {
    var delCompMould =
    `<div class="form-group">
        <label for="txtComponentCodeHeader" class="control-label col-lg-4">Component</label>
        <div class="col-lg-6">
            <select class="form-control jsSlcComp toupper" id="txtComponentCodeHeader" name="component_code[]" required data-placeholder="Component Code">
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="txtSelepQuantityHeader" class="control-label col-lg-4">Selep Quantity</label>
        <div class="col-lg-6">
            <input type="number" placeholder="Selep Quantity" name="txtSelepQuantityHeader[]" id="txtSelepQuantityHeader" class="form-control" />
        </div>
    </div>

    <div class="form-group">
        <label for="txtKeterangan" class="control-label col-lg-4">Keterangan</label>
        <div class="col-lg-6">
            <select name="txtKeterangan[]" class="form-control">
                <option value="">null</option>
                <option value="RE">RE</option>
            </select>
        </div>
    </div>`;
    $('#container-component').html(delCompMould);

    $('.jsSlcComp').select2({
        allowClear: true,
        placeholder: "Choose Component Code",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getComponent",
            dataType: 'json',
            type: "post",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.kode_barang + " | " + obj.nama_barang + ' | ' + obj.kode_proses,
                            text: obj.kode_barang + " | " + obj.nama_barang + ' | ' + obj.kode_proses
                        };
                    })
                };
            },
            error: function (error, status) {
                console.log(error);
            }
        }
    });
}

function add_emp_selep() {
    var emp_selep = `<hr><div class="form-group employee">
                    <label for="txtSelepQuantityHeader" class="control-label col-lg-4">Nama</label>
                    <div class="col-lg-6">
                        <select class="form-control jsSlcEmpl toupper" id="txtEmployeeHeader" name="txt_employee[]" required data-placeholder="Employee Name">
                            <option></option>
                        </select>
                    </div>`;
    $('#container-employee').append(emp_selep);
    $('.jsSlcEmpl').select2({
        allowClear: true,
        placeholder: "Choose Employee",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getEmployee",
            dataType: 'json',
            type: "post",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.no_induk + '|' + obj.nama,
                            text: obj.no_induk + " | " + obj.nama
                        };
                    })
                };
            }
        }
    });
}
function remove_emp_selep() {
    var emp_selep = `
        <div class="form-group employee">
        <label for="txtSelepQuantityHeader" class="control-label col-lg-4">Nama</label>
        <div class="col-lg-6">
            <select class="form-control jsSlcEmpl toupper" id="txtEmployeeHeader" name="txt_employee[]" required data-placeholder="Employee Name">
                <option></option>
            </select>
        </div>
    `;
    $('#container-employee').html(emp_selep);
    $('.jsSlcEmpl').select2({
        allowClear: true,
        placeholder: "Choose Employee",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + "ManufacturingOperationUP2L/Ajax/getEmployee",
            dataType: 'json',
            type: "post",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return {
                            id: obj.no_induk + '|' + obj.nama,
                            text: obj.no_induk + " | " + obj.nama
                        };
                    })
                };
            }
        }
    });
}

$('.abs').click(function () {
  $('.ott_Abs').select2('destroy').end();
  $(this).parent().clone(true).appendTo($("#container-abs"));
  $('.unAbs').show();
  // var copy = `
  //             <hr><div class="form-group">
  //             <label for="absName" class="control-label">Nama</label>
  //             <select class="form-control jsSlcEmpl toupper" id="txtEmployeeHeader" name="txt_employee[]" required data-placeholder="Employee Name">
  //                 <option></option>
  //             </select>
  //             </div>`;
  //             $('.ini_absen_ta').append(copy);
      $('.ott_Abs').select2(/*{
      allowClear: true,
      placeholder: "Choose Employee",
      minimumInputLength: 3,
      ajax: {
          url: baseurl + "ManufacturingOperationUP2L/Ajax/getEmployee",
          dataType: 'json',
          type: "post",
          data: function (params) {
              var queryParameters = {
                  term: params.term
              }
              return queryParameters;
          },
          processResults: function (data) {
              return {
                  results: $.map(data, function (obj) {
                      return {
                          id: obj.no_induk + '|' + obj.nama,
                          text: obj.no_induk + " | " + obj.nama
                      };
                  })
              };
          }
      }
  }*/);
});

$('.unAbs').click(function () {
    var count = $('#container-abs').children().length;
    // console.log(count);
    c = count - parseInt(1);
    // console.log(c);

    if (count > 1) {
      $(this).parent().remove();
    }
    if (c == 1) {
      $('.unAbs').hide();
    }
    // var copy = `
    // <div class="form-group"> <br />
    // <label for="absName" class="control-label">Nama</label>
    // <select class="form-control jsSlcEmpl toupper" id="txtEmployeeHeader" name="txt_employee[]" required data-placeholder="Employee Name">
    //     <option></option>
    // </select>
    // </div>`;
    // $('.ini_absen_ta').html(copy);
})


$('.addCompCore').click(function () {
  $('.jsSlcComp').select2('destroy').end();
  $(this).parent().clone(true).appendTo($("#container-compcore"));
  $('.delcompCore').show();
  // var addCompCore =
  // `<hr><br /><div class="form-group">
  //     <label for="txtComponentCodeHeader" class="control-label col-lg-4">Component</label>
  //     <div class="col-lg-6">
  //         <select class="form-control jsSlcComp toupper" id="txtComponentCodeHeader" name="component_code[]" required data-placeholder="Component Code">
  //             <option></option>
  //         </select>
  //     </div>
  // </div>
  //
  // <div class="form-group">
  //     <label for="txtCoreQuantityHeader" class="control-label col-lg-4">Core Quantity</label>
  //     <div class="col-lg-6">
  //         <input type="number" placeholder="Core Quantity" name="txtCoreQuantityHeader[]" id="txtCoreQuantityHeader" class="form-control" />
  //     </div>
  // </div>`;
  // $('#container-component').append(addCompCore);
  $('.jsSlcComp').select2({
    allowClear: true,
    placeholder: "Choose Component Code",
    minimumInputLength: 3,
    ajax: {
        url: baseurl + "ManufacturingOperationUP2L/Ajax/getComponent",
        dataType: 'json',
        type: "post",
        data: function (params) {
            var queryParameters = {
                term: params.term
            }
            return queryParameters;
        },
        processResults: function (data) {
            return {
                results: $.map(data, function (obj) {
                    return {
                        id: obj.kode_barang + " | " + obj.nama_barang + ' | ' + obj.kode_proses,
                        text: obj.kode_barang + " | " + obj.nama_barang + ' | ' + obj.kode_proses
                    };
                })
            };
        },
        error: function (error, status) {
            console.log(error);
        }
    }
  });
});

$('.delcompCore').click(function () {
  var count = $('#container-compcore').children().length;
  // console.log(count);
  c = count - parseInt(1);
  // console.log(c);

  if (count > 1) {
    $(this).parent().remove();
  }
  if (c == 1) {
    $('.delcompCore').hide();
  }
});

$('.addCompMixing').click(function () {
  $('.jsSlcComp').select2('destroy').end();
  $(this).parent().clone(true).appendTo($("#container-compmix"));
  $('.delcompMixing').show();
  // var addCompMixing =
  // `<hr><br /><div class="form-group">
  //     <label for="txtComponentCodeHeader" class="control-label col-lg-4">Component</label>
  //     <div class="col-lg-6">
  //         <select class="form-control jsSlcComp toupper" id="txtComponentCodeHeader" name="component_code[]" required data-placeholder="Component Code">
  //             <option></option>
  //         </select>
  //     </div>
  // </div>
  //
  // <div class="form-group">
  //     <label for="txtMixingQuantityHeader" class="control-label col-lg-4">Mixing Quantity</label>
  //     <div class="col-lg-6">
  //         <input type="number" placeholder="Mixing Quantity" name="txtMixingQuantityHeader[]" id="txtMixingQuantityHeader" class="form-control" />
  //     </div>
  // </div>`;
  // $('#container-component').append(addCompMixing);
  $('.jsSlcComp').select2({
      allowClear: true,
      placeholder: "Choose Component Code",
      minimumInputLength: 3,
      ajax: {
          url: baseurl + "ManufacturingOperationUP2L/Ajax/getComponent",
          dataType: 'json',
          type: "post",
          data: function (params) {
              var queryParameters = {
                  term: params.term
              }
              return queryParameters;
          },
          processResults: function (data) {
              return {
                  results: $.map(data, function (obj) {
                      return {
                          id: obj.kode_barang + " | " + obj.nama_barang + ' | ' + obj.kode_proses,
                          text: obj.kode_barang + " | " + obj.nama_barang + ' | ' + obj.kode_proses
                      };
                  })
              };
          },
          error: function (error, status) {
              console.log(error);
          }
      }
  });
});

$('.delcompMixing').click(function () {
  var count = $('#container-compmix').children().length;
  // console.log(count);
  c = count - parseInt(1);
  // console.log(c);

  if (count > 1) {
    $(this).parent().remove();
  }
  if (c == 1) {
    $('.delcompMixing').hide();
  }
});
