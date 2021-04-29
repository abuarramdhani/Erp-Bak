const toastAGT = (type, message) => {
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

const toastAGTLoading = (pesan) => {
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

const swalAGTLoading = (pesan) => {
  Swal.fire({
    onBeforeOpen: () => {
       Swal.showLoading();
       $('.swal2-loading').children('button').css({'width': '40px', 'height': '40px'})
     },
    text: pesan
  })
}

const swalAGT = (type, title) => {
  Swal.fire({
    type: type,
    title: title,
    text: '',
    showConfirmButton: false,
    showCloseButton: false,
    timer: 1100

  })
}

$(document).ready(function () {
  setTimeout(function () {
    $('#qrcodeAGT').focus();
  }, 1000);

  //monitoring
  if ($('#mon_agt_2021').val() == 1) {
    agtMonJobRelease();
  }
})

function agtMonJobRelease() {
  $.ajax({
    url: baseurl + 'CompletionAssemblyGearTrans/action/jobrelease',
    type: 'POST',
    // dataType: 'JSON',
    data: {

    },
    cache:false,
    beforeSend: function() {
      $('.area-agt-job-release').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                            </div>`);
    },
    success: function(result) {
      $('.area-agt-job-release').html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalAGT('error', 'Terdapat Kesalahan, Coba Lagi...');
    $('.area-agt-job-release').html('');
    console.error();
    }
  })
}

function agtRunningAndon() {
  $.ajax({
    url: baseurl + 'CompletionAssemblyGearTrans/action/runningandon',
    type: 'POST',
    // dataType: 'JSON',
    data: {

    },
    cache:false,
    beforeSend: function() {
      $('.area-agt-running-andon').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                            </div>`);
    },
    success: function(result) {
      $('.area-agt-running-andon').html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalAGT('error', 'Terdapat Kesalahan, Coba Lagi...');
    $('.area-agt-running-andon').html('');
    console.error();
    }
  })
}

function agtHistoryAndon() {
  $.ajax({
    url: baseurl + 'CompletionAssemblyGearTrans/action/historyandon',
    type: 'POST',
    // dataType: 'JSON',
    data: {

    },
    cache:false,
    beforeSend: function() {
      $('.area-agt-history-andon').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                            </div>`);
    },
    success: function(result) {
      $('.area-agt-history-andon').html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalAGT('error', 'Terdapat Kesalahan, Coba Lagi...');
    $('.area-agt-history-andon').html('');
    console.error();
    }
  })
}


function update_pos_1(no_job, item_code, description, item_id) {
  swalAGTLoading(`Sedang menambahkan job ${no_job} di POS 1`);
  $.ajax({
    url: baseurl + 'CompletionAssemblyGearTrans/action/cekjobdipos1',
    type: 'POST',
    dataType: 'JSON',
    data: {
      no_job: no_job,
    },
    cache:false,
    success: function(result) {
      if (result == 200) {
        swalAGT('warning',`Nomor job ${no_job} sudah pernah dipakai sebelumnya`);
      }else {
        //insert job ke andon
        $.ajax({
          url: baseurl + 'CompletionAssemblyGearTrans/action/insertpos1',
          type: 'POST',
          dataType: 'JSON',
          data: {
            item_id: item_id,
            no_job: no_job,
            item_code: item_code,
            description: description
          },
          cache:false,
          beforeSend: function() {
          },
          success: function(result_1) {
            if (result_1 == 200) {
              swalAGT('success',`Sukses menambahkan job ${no_job} di POS 1`);
            }else {
              swalAGT('warning',`Gagal menambahkan job ${no_job} di POS 1, Coba lagi`);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
           swalAGT('error', 'Terdapat Kesalahan...');
           console.error();
          }
        })
      }

      setTimeout(function () {
        $('#qrcodeAGT').focus();
      }, 1500);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
     swalAGT('error', 'Terdapat Kesalahan...');
     console.error();
    }
  })

}

$('.dt-mon-agt').DataTable();

$('.btn-reset-agt').on('click', function () {
  $('#qrcodeAGT').val('').trigger('input');
})

// 1710840,10002
function ScanKartuBodyAGT(th) {
  let val = $(th).val();
  if (val != '') {
    $.ajax({
      url: baseurl + 'CompletionAssemblyGearTrans/action/jobold',
      type: 'POST',
      // dataType: 'JSON',
      data: {
        item_id: val,
      },
      cache:false,
      beforeSend: function() {
        $('#areaAGT').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                  <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                              </div>`);
      },
      success: function(result) {
        if (result != 0) {
          $('#areaAGT').html(result);
          $(th).val('');
        }else {
          $('#areaAGT').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                    <i class="fa fa-remove" style="color:#d60d00;font-size:45px;"></i><br>
                                    <h3 style="font-size:14px;font-weight:bold">Job Release Tidak Ditemukan</h3>
                                </div>`);
                                $(th).val('');
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalAGT('error', 'Terdapat Kesalahan, Coba Lagi...');
      $('#areaAGT').html('');
      $(th).val('');
       console.error();
      }
    })
  }else {
    $('#areaAGT').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                              <i class="fa fa-remove" style="color:#d60d00;font-size:45px;"></i><br>
                              <h3 style="font-size:14px;font-weight:bold">Harap Isi Form Input QRcode</h3>
                          </div>`);
                          $(th).val('');
  }

}
//
// $(document).ready(function () {
//   $(".slc_pbb_seksi").select2();
//   $(".slc_pbb").select2({
//     allowClear:true,
//   });
//
//   $('.slc_pbbns_item').select2({
//     tags: true,
//     allowClear:true,
//     minimumInputLength: 3,
//     placeholder: "Item Kode",
//     ajax: {
//       url: baseurl + "BarangBekas/pbbns/item_pbbns",
//       dataType: "JSON",
//       type: "POST",
//       cache: false,
//       data: function(params) {
//         return {
//           term: params.term
//         };
//       },
//       processResults: function(data) {
//         return {
//           results: $.map(data, function(obj) {
//             return {
//               id: obj.SEGMENT1==''?params.term:`${obj.SEGMENT1} - ${obj.PRIMARY_UOM_CODE} - ${obj.INVENTORY_ITEM_ID} - ${obj.ORGANIZATION_ID}`,
//               text: obj.SEGMENT1==''?params.term:`${obj.SEGMENT1} - ${obj.DESCRIPTION}`
//             }
//           })
//         }
//       }
//     }
//   })
//
//   $('input[name="pbb_tujuan"]').on('change', function () {
//     let val = $('input[name=pbb_tujuan]:checked').val();
//     $.ajax({
//       url: baseurl + 'BarangBekas/pbbs/locator',
//       type: 'POST',
//       dataType: 'JSON',
//       data: {
//         subinv: val,
//         org_id: 102
//       },
//       cache:false,
//       beforeSend: function() {
//         $('.pbb_locator_tujuan').html('<b>Sedang Mengambil Locator...</b>');
//       },
//       success: function(result) {
//         if (result != 0) {
//           $('.pbb_locator_tujuan').html(`<select class="slc_pbb_locator pbbs_loc" id="pbbtt_locator" name="locator" style="width:100%" required >
//                                   <option selected value="">Select..</option>
//                                   ${result}
//                                   </select>`);
//           $('.slc_pbb_locator').select2({
//             allowClear:true,
//           });
//         }else {
//           $('.pbb_locator_tujuan').html('-')
//         }
//       },
//       error: function(XMLHttpRequest, textStatus, errorThrown) {
//       swalPBB('error', 'Koneksi Terputus...')
//        console.error();
//       }
//     })
//   });
//
//
// $('.pbb_transact').select2({
//   // tags: true,
//   allowClear:true,
//   // minimumInputLength: 3,
//   placeholder: "Cari No Dokumen",
//   ajax: {
//     url: baseurl + "BarangBekas/transact/geDocBy",
//     dataType: "JSON",
//     type: "POST",
//     cache: false,
//     data: function(params) {
//       return {
//         term: params.term
//       };
//     },
//     processResults: function(data) {
//       return {
//         results: $.map(data, function(obj) {
//           return {
//             id: obj.DOCUMENT_NUMBER,
//             text: obj.DOCUMENT_NUMBER
//           }
//         })
//       }
//     }
//   }
// })
//
// })
