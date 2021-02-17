const toastPBB = (type, message) => {
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

const toastPBBLoading = (pesan) => {
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

const swalPBB = (type, title) => {
  Swal.fire({
    type: type,
    title: title,
    text: '',
    showConfirmButton: false,
    showCloseButton: true,
  })
}

$(document).ready(function () {
  $(".slc_pbb_seksi").select2();
  $(".slc_pbb").select2();

  $('.slc_pbbns_item').select2({
    tags: true,
    allowClear:true,
    minimumInputLength: 3,
    placeholder: "Item Kode",
    ajax: {
      url: baseurl + "BarangBekas/pbbns/item_pbbns",
      dataType: "JSON",
      type: "POST",
      cache: false,
      data: function(params) {
        return {
          term: params.term
        };
      },
      processResults: function(data) {
        return {
          results: $.map(data, function(obj) {
            return {
              id: obj.SEGMENT1==''?params.term:`${obj.SEGMENT1} - ${obj.PRIMARY_UOM_CODE} - ${obj.INVENTORY_ITEM_ID}`,
              text: obj.SEGMENT1==''?params.term:`${obj.SEGMENT1} - ${obj.DESCRIPTION}`
            }
          })
        }
      }
    }
  })
})

const getOnhand = () => {
  // let item = $('.slc_pbb_item').val().split(' - ');
  // if (item[2] != undefined) {
  //   $.ajax({
  //     url: baseurl + 'BarangBekas/pbbs/onhand',
  //     type: 'POST',
  //     dataType: 'JSON',
  //     data: {
  //       org_id: 102,
  //       inv_item_id: item[2],
  //       subinv: $('.pbb_subinv').val(),
  //       locator_id: $('.slc_pbb_locator').val() === '' ? null : $('.slc_pbb_locator').val(),
  //     },
  //     cache:false,
  //     beforeSend: function() {
  //       $('#onhand').val('....');
  //       $('.btn_pbbs_submit').attr('disabled', 'disabled');
  //     },
  //     success: function(result) {
  //       $('#onhand').val(result[0].ONHAND);
  //       $('.btn_pbbs_submit').removeAttr('disabled');
  //     },
  //     error: function(XMLHttpRequest, textStatus, errorThrown) {
  //     swalPBB('error', 'Koneksi Terputus...')
  //      console.error();
  //     }
  //   })
  // }
}

$('.check_pbb_param').on('mouseover', function () {
  if ($('.slc_pbb_seksi').val() === '' || $('.pbb_subinv').val() === '') {
    swalPBB('warning', 'Seksi dan SubInv Wajib Diisi Terlebih Dahulu!');
  }
  if ($('.pbbs_loc').val() != undefined && $('.pbbs_loc').val() == '') {
    swalPBB('warning', 'Pilih Locator Terlebih Dahulu!');
  }
})

$('.check_locator__').on('mouseover', function () {
  if ($('.pbbs_loc').val() != undefined && $('.pbbs_loc').val() == '') {
    swalPBB('warning', 'Pilih Locator Terlebih Dahulu!');
  }
})

$('.check_pbbns_param').on('mouseover', function () {
  if ($('.slc_pbb_seksi').val() === '') {
    swalPBB('warning', 'Seksi Wajib Diisi Terlebih Dahulu!')
  }
})

$('.slc_pbb_seksi').on('change', function () {
  let cc = $(this).val().split(' ~ ');
  $('#pbb_cost_center').val(cc[1]);
})

$('.slc_pbb_item').on('change', function () {
  let give_uom = $(this).val().split(' - ');
  $('#pbb_uom').val(give_uom[1]);
  $('#onhand').val(give_uom[3]);
    // getOnhand();
})

$('.slc_pbbns_item').on('change', function () {
    let give_uom = $(this).val().split(' - ');
    $('#pbb_uom_1').val(give_uom[1]);
})

$('#jumlah').on('input', function () {
  // console.log( $('#onhand').val());
  if ($(this).val() > Number($('#onhand').val())) {
      swalPBB('warning', 'Jumlah stok tidak boleh melebihi OnHand!');
      $(this).val('');
  }
})

$('.pbb_subinv').on('change', function() {

  $('.pbbs_table tbody tr').each((i,v)=>{
    console.log(v);
    if (i != 0) {
      $(v).remove();
    }else {
      $('.slc_pbb_item').val('').trigger('change');
      $('#pbb_uom').val('');
      $('#onhand').val('');
      $('#jumlah').val('');
    }
  })

  let val_ = $(this).val().split(' - ');
  let val = val_[0];

    $.ajax({
      url: baseurl + 'BarangBekas/pbbs/locator',
      type: 'POST',
      dataType: 'JSON',
      data: {
        subinv: val
      },
      cache:false,
      beforeSend: function() {
        $('.pbb_locator').html('<b>Sedang Mengambil Locator...</b>');
      },
      success: function(result) {
        if (result != 0) {
          $('.pbb_locator').html(`<select class="slc_pbb_locator pbbs_loc" name="locator" style="width:100%" required >
                                  <option selected value="">Select..</option>
                                  ${result}
                                  </select>`);
          $('.slc_pbb_locator').select2();

          $('.slc_pbb_locator').on('change', function() {
            getOnhand();
          })
        }else {
          $('.pbb_locator').html('-')
        }
        // getOnhand();
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalPBB('error', 'Koneksi Terputus...')
       console.error();
      }
    }).done(()=>{
      $('.slc_pbb_item').select2({
        tags: true,
        allowClear:true,
        minimumInputLength: 3,
        placeholder: "Item Kode",
        ajax: {
          url: baseurl + "BarangBekas/pbbs/item",
          dataType: "JSON",
          type: "POST",
          cache: false,
          data: function(params) {
            return {
              term: params.term,
              subinv: val,
              locator: $('.slc_pbb_locator').val() === undefined ? '' : $('.slc_pbb_locator').select2('data')[0]['text'],
              org_id: val_[1],
            };
          },
          processResults: function(data) {
            return {
              results: $.map(data, function(obj) {
                return {
                  id: obj.SEGMENT1==''?params.term:`${obj.SEGMENT1} - ${obj.PRIMARY_UOM_CODE} - ${obj.INVENTORY_ITEM_ID} - ${obj.OH}`,
                  text: obj.SEGMENT1==''?params.term:`${obj.SEGMENT1} - ${obj.ITEM_DESC}`
                }
              })
            }
          }
        }
      })
    })
})

const btnPBBS = () => {

  if ($('.slc_pbb_seksi').val() === '') {
      swalPBB('warning', 'Seksi Wajib Diisi Terlebih Dahulu!');
  } else {
    let n = $('.pbbs_table tbody tr').length;
    let a = n + 1;
    $('#pbbs_set_row').append(`<tr row-id="${a}">
                          <td class="text-center">${a}</td>
                          <td class="text-center check_pbbns_param">
                            <select class="form-control slc_pbb_item_line" name="item_code[]" style="text-transform:uppercase !important;width:582px;" required>
                              <option selected="selected"></option>
                            </select>
                          </td>
                          <td class="text-center"><input type="text" class="form-control" id="onhand_${a}" name="onhand[]" readonly autocomplete="off"></td>
                          <td class="text-center"><input type="number" class="form-control jumlah_online" name="jumlah[]"></td>
                          <td class="text-center"><input type="text" class="form-control" id="pbb_uom_${a}" name="uom[]" readonly></td>
                          <td class="text-center">
                            <a class="btn btn-danger btn-sm" onclick="btnpbbs_min(${a})">
                              <i class="fa fa-minus"></i>
                            </a>
                          </td>
                        </tr>`);
//------
    let val_ = $('.pbb_subinv').val().split(' - ');
    let val = val_[0];
    $('.pbbs_table tbody tr[row-id="'+ a +'"] .slc_pbb_item_line').select2({
        tags: true,
        allowClear:true,
        minimumInputLength: 3,
        placeholder: "Item Kode",
        ajax: {
          url: baseurl + "BarangBekas/pbbs/item",
          dataType: "JSON",
          type: "POST",
          cache: false,
          data: function(params) {
            return {
              term: params.term,
              subinv: val,
              locator: $('.slc_pbb_locator').val() === undefined ? '' : $('.slc_pbb_locator').select2('data')[0]['text'],
              org_id: val_[1],
            };
          },
          processResults: function(data) {
            return {
              results: $.map(data, function(obj) {
                return {
                  id: obj.SEGMENT1==''?params.term:`${obj.SEGMENT1} - ${obj.PRIMARY_UOM_CODE} - ${obj.INVENTORY_ITEM_ID} - ${obj.OH}`,
                  text: obj.SEGMENT1==''?params.term:`${obj.SEGMENT1} - ${obj.ITEM_DESC}`
                }
              })
            }
          }
        }
    });

    $('.pbbs_table tbody tr[row-id="'+ a +'"] .slc_pbb_item_line').on('change', function () {
      let give_uom = $(this).val().split(' - ');
      $(`#pbb_uom_${a}`).val(give_uom[1]);
      $(`#onhand_${a}`).val(give_uom[3]);
    })

    $('.pbbs_table tbody tr[row-id="'+ a +'"] .jumlah_online').on('input', function () {
      if ($(this).val() > Number($(`#onhand_${a}`).val())) {
          swalPBB('warning', 'Jumlah stok tidak boleh melebihi OnHand!');
          $(this).val('');
      }
    })

  }

}

const btnpbbs_min = (a) => {
  $('.pbbs_table tbody tr[row-id="'+ a +'"]').remove();

  $('.pbbs_table tbody tr').each(function(i){
        $($(this).find('td')[0]).html(i+1);
    });
}

const btnPBBNS = () => {
  if ($('.slc_pbb_seksi').val() === '') {
      swalPBB('warning', 'Seksi Wajib Diisi Terlebih Dahulu!');
  } else {
    let n = $('.pbbns_table tbody tr').length;
    let a = n + 1;
    $('#pbbns_set_row').append(`<tr row-id="${a}">
                          <td class="text-center">${a}</td>
                          <td class="text-center check_pbbns_param">
                            <select class="form-control slc_pbb_item_line" name="item_code[]" style="text-transform:uppercase !important;width:600px;" required>
                              <option selected="selected"></option>
                            </select>
                          </td>
                          <td class="text-center"><input type="number" class="form-control" name="jumlah[]"></td>
                          <td class="text-center"><input type="text" class="form-control" id="pbb_uom_${a}" name="uom[]" readonly></td>
                          <td class="text-center">
                            <a class="btn btn-danger btn-sm" onclick="btnpbbns_min(${a})">
                              <i class="fa fa-minus"></i>
                            </a>
                          </td>
                        </tr>`);
//------
    $('.pbbns_table tbody tr[row-id="'+ a +'"] .slc_pbb_item_line').select2({
      tags: true,
      allowClear:true,
      minimumInputLength: 3,
      placeholder: "Item Kode",
      ajax: {
        url: baseurl + "BarangBekas/pbbns/item_pbbns",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: function(params) {
          return {
            term: params.term
          };
        },
        processResults: function(data) {
          return {
            results: $.map(data, function(obj) {
              return {
                id: obj.SEGMENT1==''?params.term:`${obj.SEGMENT1} - ${obj.PRIMARY_UOM_CODE} - ${obj.INVENTORY_ITEM_ID}`,
                text: obj.SEGMENT1==''?params.term:`${obj.SEGMENT1} - ${obj.DESCRIPTION}`
              }
            })
          }
        }
      }
    });

    $('.pbbns_table tbody tr[row-id="'+ a +'"] .slc_pbb_item_line').on('change', function () {
      let give_uom = $(this).val().split(' - ');
      $(`#pbb_uom_${a}`).val(give_uom[1]);
    })

  }

}

const btnpbbns_min = (a) => {
  $('.pbbns_table tbody tr[row-id="'+ a +'"]').remove();

  $('.pbbns_table tbody tr').each(function(i){
        $($(this).find('td')[0]).html(i+1);
    });
}

$('.pbb_transact').on('change', function () {
    const val = $(this).val();
    if (val === '') {
      $('.form-pbb-transact')[0].reset();
      $('#pbbt_subinv_check').attr('hidden', 'hidden');
      $('#pbbt_locator_check').attr('hidden', 'hidden');
      $('.pbbt_type').html('');
      $('.table_pbbt tbody tr').each((i,v) => {
        $(v).remove();
      })
    }else {
      $.ajax({
        url: baseurl + 'BarangBekas/transact/detail_document',
        type: 'POST',
        // dataType: 'JSON',
        data: {
          doc_num: val,
        },
        cache:false,
        beforeSend: function() {
          $('.submit-pbb-transact').attr('disabled', 'disabled');
          $('#pbbt_seksi').val('Sedang Mengambil Data ....');
          $('#pbbt_cost_center').val('Sedang Mengambil Data ....');
          $('.pbbt_area_item').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                        <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                        <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                                    </div>`);
        },
        success: function(result) {
          $('.submit-pbb-transact').removeAttr('disabled');
          $('.pbbt_area_item').html(result);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        swalPBB('error', 'Koneksi Terputus...')
         console.error();
        }
      })
    }

})

$('.submit-pbb-transact').on('click', function() {
  const doc_num = $('select[name="no_document"]').val();
  const cek_blm_selesai_timbang = $('button[data-target="#modal-pbb-transact-ambil-berat"]').text();
  if (cek_blm_selesai_timbang == '') {
    $.ajax({
      url: baseurl + 'BarangBekas/transact/transact_beneran',
      type: 'POST',
      dataType: 'JSON',
      data: {
        doc_num: doc_num,
      },
      cache:false,
      beforeSend: function() {
        toastPBBLoading('Sedang melakukan transact..')
      },
      success: function(result) {
        if (result == 1) {
          toastPBB('success', 'Sukses melakukan transact .. ')
        }else if (result == 76) {
          toastPBB('warning', `Dokumen ${doc_num} telah di-transact sebelumnya.`)
        }else {
          toastPBB('warning', 'Gagal melakukan transact, hubungi pihak yang berwajib!')
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalPBB('error', 'Koneksi Terputus...')
       console.error();
      }
    })
  }else {
    toastPBB('warning', 'Masih terdapat item yang belum selesai timbang, selesaikan dulu!');
  }
  console.log(cek_blm_selesai_timbang);

})

// const pbb_seksi = () => {
//   $.ajax({
//     url: baseurl + 'BarangBekas/pbbs/getSeksi',
//     type: 'POST',
//     // dataType: 'JSON',
//     cache:false,
//     beforeSend: function() {
//
//     },
//     success: function(result) {
//
//     },
//     error: function(XMLHttpRequest, textStatus, errorThrown) {
//     swalPBB('error', 'Koneksi Terputus...')
//      console.error();
//     }
//   })
// }

// $.ajax({
//   url: baseurl + 'BarangBekas/',
//   type: 'POST',
//   // dataType: 'JSON',
//   data: {
//     range_date : param,
//     // tipe : param_2,
//   },
//   cache:false,
//   beforeSend: function() {
//
//   },
//   success: function(result) {
//
//   },
//   error: function(XMLHttpRequest, textStatus, errorThrown) {
//   swalPBB('error', 'Koneksi Terputus...')
//    console.error();
//   }
// })
