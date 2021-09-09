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
  // if ($('#pbb_mon_stok_barkas').val()) {
  //   getmonpbbgrafik();
  //   console.log();
  // }
  if ($('.rekap_pbb').html() != undefined) {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear();
    if (dd < 10) {
      dd = '0' + dd;
    }
    if (mm < 10) {
      mm = '0' + mm;
    }
    var today = dd + '_' + mm + '_' + yyyy;
  }
  $('.pbb_default_datatable').dataTable();
  $('.rekap_pbb').dataTable({
    dom: 'Bfrtip',
    buttons: [
      'pageLength',
      {
        extend: 'excelHtml5',
        title: 'REKAP_PBB_' + today,
        exportOptions: {
          columns: ':visible',
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
        }
      }
     ],
  });
  $(".slc_pbb_seksi").select2();
  $(".slc_default_pbb").select2();
  $(".slc_pbb").select2({
    allowClear:true,
  });

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
              id: obj.SEGMENT1==''?params.term:`${obj.SEGMENT1} - ${obj.PRIMARY_UOM_CODE} - ${obj.INVENTORY_ITEM_ID} - ${obj.ORGANIZATION_ID}`,
              text: obj.SEGMENT1==''?params.term:`${obj.SEGMENT1} - ${obj.DESCRIPTION}`
            }
          })
        }
      }
    }
  })

  $('input[name="pbb_tujuan"]').on('change', function () {
    let val = $('input[name=pbb_tujuan]:checked').val();
    $.ajax({
      url: baseurl + 'BarangBekas/pbbs/locator',
      type: 'POST',
      dataType: 'JSON',
      data: {
        subinv: val,
        org_id: 102
      },
      cache:false,
      beforeSend: function() {
        $('.pbb_locator_tujuan').html('<b>Sedang Mengambil Locator...</b>');
      },
      success: function(result) {
        if (result != 0) {
          $('.pbb_locator_tujuan').html(`<select class="slc_pbb_locator pbbs_loc" id="pbbtt_locator" name="locator" style="width:100%" required >
                                  <option selected value="">Select..</option>
                                  ${result}
                                  </select>`);
          $('.slc_pbb_locator').select2({
            allowClear:true,
          });
        }else {
          $('.pbb_locator_tujuan').html('-')
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalPBB('error', 'Koneksi Terputus...')
       console.error();
      }
    })
  });


$('.pbb_transact').select2({
  // tags: true,
  allowClear:true,
  // minimumInputLength: 3,
  placeholder: "Cari No Dokumen",
  ajax: {
    url: baseurl + "BarangBekas/transact/geDocBy",
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
            id: obj.DOCUMENT_NUMBER,
            text: obj.DOCUMENT_NUMBER
          }
        })
      }
    }
  }
})

})

$('input[name="jenis_pbb"]').on('change', function() {
  let val = $('input[name="jenis_pbb"]:checked').val();
  if (val == 'PBB-NS') {
    $('.pbb_io').val(81).trigger('change');
  }else {
    $('.pbb_io').val('').trigger('change');
  }
})

function slc_pbb_item_nons(elem) {
  $(`.${elem}`).select2({
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
          subinv: '-',
          locator: '-',
          org_id: 81,
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
}

$('.pbb_io').on('change', function() {
  let val = $(this).val();
  if (val == 81) {
    $('.pbb_sudah_pilih_io').html(` - <input type="hidden" name="subinv" value="">`)
    $('.pbb_locator').html('-')
    slc_pbb_item_nons('slc_pbb_item')
  }else {
    $('.pbb_sudah_pilih_io').html(`<select class="form-control slc_pbb pbb_subinv" name="subinv" style="width:100%">
                                    <option value="">Select..</option>
                                  </select>`);
    $('.pbb_subinv').select2();
    if (val!='') {
      $.ajax({
        url: baseurl + 'BarangBekas/pbbs/SubInv',
        type: 'POST',
        dataType: 'JSON',
        data: {
          io : val
        },
        cache: false,
        beforeSend: function() {
          toastPBBLoading('Sedang Mengambil SubInv..');
        },
        success: function(result) {
          if (result != 0) {
            toastPBB('success', 'Selesai..');
            $('.pbb_subinv').html(result);
            $('.pbb_subinv').val('').trigger('change');
            $('.pbb_locator').html('-')
          }else {
            swalPBB('warning', 'IO belum Open Period');
            $('.pbb_subinv').html('');
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        swalPBB('error', 'Koneksi Terputus...')
         console.error();
        }
      })
    }

    // pbb_subinv_change
    $('.pbb_subinv').on('change', function() {

      if ($(this).val() != '') {

      $('.pbbs_table tbody tr').each((i,v)=>{
        // console.log(v);
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
            subinv: val,
            org_id: val_[1]
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
                let val_9 = $('.pbb_subinv').val().split(' - ')
                $('.pbbs_table tbody tr').each((i,v)=>{
                  // console.log(v);
                  if (i != 0) {
                    $(v).remove();
                  }else {
                    $('.slc_pbb_item').val('').trigger('change');
                    $('#pbb_uom').val('');
                    $('#onhand').val('');
                    $('#jumlah').val('');
                  }
                })
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
                        subinv: val_9[0],
                        locator: $('.slc_pbb_locator').select2('data')[0]['text'],
                        org_id: val_9[1],
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
                $('.slc_pbb_item').val('').trigger('change');
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
      }
    })
    //end change pbb
  }
})

$('.pbb_sudah_pilih_io').on('click', function() {
  if ($('.pbb_io').val() == '') {
    swalPBB('warning','Pilih IO Dulu!');
  }
})

// =============
$('.pbb_io_tujuan').on('change', function() {
  let val = $(this).val();
  if (val != '') {
    $.ajax({
      url: baseurl + 'BarangBekas/pbbs/SubInv',
      type: 'POST',
      dataType: 'JSON',
      data: {
        io : val
      },
      cache: false,
      beforeSend: function() {
        toastPBBLoading('Sedang Mengambil SubInv..');
      },
      success: function(result) {
        if (result != 0) {
          toastPBB('success', 'Selesai..');
          $('.pbb_subinv_tujuan').html(result);
          $('.pbb_subinv_tujuan').val('').trigger('change');
          $('.pbb_locator_tujuan').html('-')
        }else {
          swalPBB('warning', 'IO belum Open Period');
          $('.pbb_subinv_tujuan').html('');
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalPBB('error', 'Koneksi Terputus...')
       console.error();
      }
    })
    $.ajax({
      url: baseurl + 'BarangBekas/pbbs/item_barkas',
      type: 'POST',
      dataType: 'JSON',
      data: {
        // subinv: val,
        // locator: $('.slc_pbb_locator_tujuan').val() === undefined ? '' : $('.slc_pbb_locator_tujuan').select2('data')[0]['id'],
        org_id: val,
      },
      cache:false,
      beforeSend: function() {
       toastPBBLoading('Sedang mengambil item barkas..')
      },
      success: function(result) {
          console.log(result, 'heiii');
        if (result != 0) {
          $('.slc_default_pbb').html(`<option selected value="">Select..</option>${result}`);
          toastPBB('success', 'Selesai');
        }else {
          $('.slc_default_pbb').html('<option selected value="">Empty Item..</option>')
          toastPBB('warning', `Item barkas tidak ditemukan`);
        }
        $('.slc_default_pbb').select2();
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalPBB('error', 'Koneksi Terputus...')
       console.error();
      }
    })
  }
})

$('.pbb_sudah_pilih_io_tujuan').on('click', function() {
  if ($('.pbb_io_tujuan').val() == '') {
    swalPBB('warning','Pilih IO Dulu!');
  }
})

// ===========

// function getmonpbbgrafik() {
$('.form_submit_filter_grafik').on('submit', function (e) {
  e.preventDefault();
  $.ajax({
    url: baseurl + 'BarangBekas/pbbs/submit_filter_grafik',
    type: 'POST',
    // dataType: 'JSON',
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData:false,
    beforeSend: function() {
      toastPBBLoading('Sedang memproses data..')
    },
    success: function(result) {
      let onhand = [];
      let max_stok = [];
      let segment1 = [];
      let oh_un_max_stok = [];
      let data_result = JSON.parse(result);
      // console.log(data_result);
      data_result.forEach((v,i) => {
        segment1.push(v.SEGMENT1)
        onhand.push(v.MAX_QUANTITY == null ? 0 : v.ONHAND)
        max_stok.push(v.MAX_QUANTITY == null ? 0 : (Number(v.MAX_QUANTITY) - Number(v.ONHAND)))
        oh_un_max_stok.push(v.MAX_QUANTITY == null ? v.ONHAND : 0)
      })
      // console.log(onhand);
      $('.pbb_grafik_mon').html(`<div style="padding:1px 10px 1px 10px;display:inline;background:#ef476f"></div>&nbsp; OnHand;&nbsp;&nbsp;&nbsp;
      <div style="padding:1px 10px 1px 10px;display:inline;background:#06d6a0"></div>&nbsp Available Space;&nbsp;&nbsp;&nbsp;
       <div style="padding:1px 10px 1px 10px;display:inline;background:#073b4c"></div>&nbsp Onhand With Unlimited Max Stok;&nbsp;&nbsp;&nbsp;<br>
      <canvas id="pbbChart" style="width:100%;margin-top:20px" height="500"></canvas>`)

      const labels = segment1;
      const data = {
        labels: labels,
        datasets: [
          {
            label: 'Onhand',
            data: onhand,
            stack: 0,
            backgroundColor: '#ef476f',
          },
          {
            label: 'available space',
            data: max_stok,
            stack: 0,
            backgroundColor: '#06d6a0',
          },
          {
            label: 'onhand with unlimited Max stok',
            data: oh_un_max_stok,
            stack: 0,
            backgroundColor: '#073b4c',
          },
        ]
      };

      const config = {
        type: 'bar',
        data: data,
        options: {
          plugins: {
            title: {
              display: true,
              text: 'Stok Barkas'
            },
          },
          responsive: true,
          // tooltips: {
          //   mode: 'index',
          //   intersect: true,
          //   enable: true
          // },
          // states: {
          //   hover: false,
          // },
          scales: {
            xAxes: [{
              stacked: true,
              gridLines: {
                display: false
              },
            }],
            yAxes: [{
              stacked: true,
            }],
          }, // scales
          legend: {
            display: false
          },
          showTooltips: true,
            onAnimationComplete: function() {
              this.showTooltip(this.datasets[0].points, true);
            },
          }
        };
    let ctx = document.getElementById('pbbChart').getContext('2d');
    let pbbChart = new Chart(ctx, config);
    toastPBB('success', 'done')
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalPBB('error', 'Koneksi Terputus...')
     console.error();
    }
  })
})
// }

$('.form_submit_pbbs').on('submit', function (e) {
  e.preventDefault();
  let form = new FormData(this);
  // $(this).get(0)
  // cek max - onhand
  let es = $('.estimasi_berat');
  let item_barkas_cek = [];
  let estimasi_berat = [];
  $('.item_barkas').each((i,v)=>{
    item_barkas_cek.push($(v).val());
    estimasi_berat.push($(es[i]).val());
  })

  $.ajax({
    url: baseurl + 'BarangBekas/pbbs/cek_max_onhand',
    type: 'POST',
    dataType: 'JSON',
    data: {
      item_barkas : item_barkas_cek,
      estimasi_berat : estimasi_berat,
      subinv: $('.pbb_subinv_tujuan').val().split(' - ')[0],
      locator: $('.slc_pbb_locator_tujuan').val(),
      io: $('.pbb_io_tujuan').val()
    },
    cache: false,
    beforeSend: function() {
      toastPBBLoading('Mengecek ketersediaan barkas');
    },
    success: function(result_0) {
      if (result_0.status == 200) {
        $.ajax({
          url: baseurl + 'BarangBekas/pbbs/submit_pbbs',
          type: 'POST',
          // dataType: 'JSON',
          data: form,
          contentType: false,
          cache: false,
          processData:false,
          beforeSend: function() {
            toastPBBLoading('Sedang memproses data..')
          },
          success: function(result) {
            let result_1 = JSON.parse(result);
            if (result_1.status == 100) {
              toastPBB('success', `Data berhasil disimpan dengan no dokumen ${result_1.no_doc}`);
              $('.form_submit_pbbs')[0].reset();
              $('.pbbs_table tbody tr').each((i,v)=>{
                if (i != 0) {
                  $(v).remove();
                }else {
                  $('.slc_pbb_item').val('').trigger('change');
                  $('#pbb_uom').val('');
                  $('#onhand').val('');
                  $('#jumlah').val('');
                }
              });
              $('.slc_pbb_seksi').trigger('change');
              $('.pbb_subinv').trigger('change');
              $('.slc_pbb_locator').trigger('change');
              setTimeout(function () {
                window.open(`${baseurl}BarangBekas/pbbs/pdf/${result_1.no_doc}`);
              }, 1500);
            }else {
              toastPBB('warning', 'Gagal melakukan insert data, hubungi pihak yang berwajib!');
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
          swalPBB('error', 'Koneksi Terputus...')
           console.error();
          }
        })
      }else {
        swalPBB('warning', `${result_0.message}`);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalPBB('error', 'Koneksi Terputus...')
     console.error();
    }
  })

})

$('.form_submit_pbbns').on('submit', function (e) {
  e.preventDefault();
  $.ajax({
    url: baseurl + 'BarangBekas/pbbns/submit_pbbns',
    type: 'POST',
    // dataType: 'JSON',
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData:false,
    beforeSend: function() {
      toastPBBLoading('Sedang memproses data..')
    },
    success: function(result) {
      if (result != 11) {
        toastPBB('success', `Data berhasil disimpan dengan no dokumen ${result}`);
        $('.form_submit_pbbns')[0].reset();
        $('.pbbns_table tbody tr').each((i,v)=>{
          if (i != 0) {
            $(v).remove();
          }else {
            $('.slc_pbbns_item').val('').trigger('change');
            $('#jumlah').val('');
            $('#pbb_uom_1').val('');
          }
        });
        $('.slc_pbb_seksi').trigger('change');
        setTimeout(function () {
          window.open(`${baseurl}BarangBekas/pbbns/pdf/${result}`);
        }, 1500);
      }else {
        toastPBB('warning', 'Gagal melakukan insert data, hubungi pihak yang berwajib!');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalPBB('error', 'Koneksi Terputus...')
     console.error();
    }
  })
})

const getOnhand = () => {

}

$('.check_pbb_param').on('click', function () {
  if (($('.slc_pbb_seksi').val() === '' || $('.pbb_subinv').val() === '') && $('.pbb_io').val() != 81) {
    swalPBB('warning', 'Seksi dan SubInv Wajib Diisi Terlebih Dahulu!');
  }else if ($('.pbb_io').val() == 81 && $('.slc_pbb_seksi').val() === '') {
    swalPBB('warning', 'Seksi Wajib Diisi Terlebih Dahulu!');
  }
  if ($('.pbbs_loc').val() != undefined && $('.pbbs_loc').val() == '') {
    swalPBB('warning', 'Pilih Locator Terlebih Dahulu!');
  }
})

$('.check_locator__').on('click', function () {
  if ($('.pbbs_loc').val() != undefined && $('.pbbs_loc').val() == '') {
    swalPBB('warning', 'Pilih Locator Terlebih Dahulu!');
  }
})

$('.check_locator_tujuan').on('click', function () {
  if ($('.pbbs_loc_tujuan').val() != undefined && $('.pbbs_loc_tujuan').val() == '') {
    swalPBB('warning', 'Pilih Locator Barkas Terlebih Dahulu!');
  }
})

$('.check_pbbns_param').on('click', function () {
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

$('.pbb_subinv_tujuan').on('change', function() {

  if ($(this).val() != '') {

    $('.pbbs_table tbody tr').each((i,v)=>{
      $(v).find('.slc_default_pbb').val('').trigger('change');
      $(v).find('.estimasi_berat').val('');
    })

  let val_ = $(this).val().split(' - ');
  let val = val_[0];

    $.ajax({
      url: baseurl + 'BarangBekas/pbbs/locator',
      type: 'POST',
      dataType: 'JSON',
      data: {
        subinv: val,
        org_id: val_[1]
      },
      cache:false,
      beforeSend: function() {
        $('.pbb_locator_tujuan').html('<b>Sedang Mengambil Locator...</b>');
      },
      success: function(result) {
        if (result != 0) {
          $('.pbb_locator_tujuan').html(`<select class="slc_pbb_locator_tujuan pbbs_loc_tujuan" style="width:100%" required >
                                  <option value="">Pilih Item</option>
                                  ${result}
                                  </select>`);

          $('.slc_pbb_locator_tujuan').on('change', function() {
            let val_9 = $('.pbb_subinv_tujuan').val().split(' - ')
            $('.pbbs_table tbody tr').each((i,v)=>{
              $(v).find('.slc_default_pbb').val('').trigger('change');
              $(v).find('.estimasi_berat').val('');
            })
          })
        }else {
          $('.pbb_locator_tujuan').html('-')
        }

        $('.slc_pbb_locator_tujuan').select2();
        // getOnhand();
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalPBB('error', 'Koneksi Terputus...')
       console.error();
      }
    }).done(()=>{

    })
  }
})

const btnPBBS = () => {

  if ($('.slc_pbb_seksi').val() === '') {
      swalPBB('warning', 'Seksi Wajib Diisi Terlebih Dahulu!');
  } else {
    let n = $('.pbbs_table tbody tr').length;
    let a = n + 1;
    let ambil = $('#pbb_item_barkas').html();
    let select_ = `<select class="form-control slc_default_pbb item_barkas" name="item_barkas[]" style="width:250px" required>
                    ${ambil}
                  </select>`;
    $('#pbbs_set_row').append(`<tr row-id="${a}">
                          <td class="text-center">${a}</td>
                          <td class="text-center check_pbbns_param">
                            <select class="form-control slc_pbb_item_line" name="item_code[]" style="text-transform:uppercase !important;width:250px;" required>
                              <option selected="selected"></option>
                            </select>
                          </td>
                          <td class="text-center"><input type="text" class="form-control" id="onhand_${a}" name="onhand[]" readonly autocomplete="off"></td>
                          <td class="text-center"><input type="number" class="form-control jumlah_online" name="jumlah[]"></td>
                          <td class="text-center"><input type="text" class="form-control" id="pbb_uom_${a}" name="uom[]" readonly></td>
                          <td>${select_}</td>
                          <td><input type="number" class="form-control estimasi_berat" name="estimasi_berat[]" required></td>
                          <td class="text-center">
                            <a class="btn btn-danger btn-sm" onclick="btnpbbs_min(${a})">
                              <i class="fa fa-minus"></i>
                            </a>
                          </td>
                        </tr>`);
//------
console.log($('.pbb_io').val(), 'cekcekcek');
    if ($('.pbb_subinv').val() == undefined && $('.pbb_io').val() == 81) {
      slc_pbb_item_nons('pbbs_table tbody tr[row-id="'+ a +'"] .slc_pbb_item_line')
    }else {
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
                subinv: val_[0],
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
    }
    $('.slc_default_pbb').select2()

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
                id: obj.SEGMENT1==''?params.term:`${obj.SEGMENT1} - ${obj.PRIMARY_UOM_CODE} - ${obj.INVENTORY_ITEM_ID} - ${obj.ORGANIZATION_ID}`,
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
        url: baseurl + 'BarangBekas/transact/apakah_sudah_trasact',
        type: 'POST',
        dataType: 'JSON',
        data: {
          doc_num: val,
        },
        cache:false,
        beforeSend: function() {
          toastPBB('info', `Sedang Mengecek Status Dokumen ${val}...`)
        },
        success: function(cek_apakahhh) {
          if (cek_apakahhh != 1) {
            toastPBB('success', `Selesai..`)
          }else {
            toastPBB('warning', `Dokumen ${val} telah di-transact sebelumnya.`)
          }
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
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        swalPBB('error', 'Koneksi Terputus, Coba lagi...')
         console.error();
        }
      })

    }

})

$('.submit-pbb-transact').on('click', function() {
  const doc_num = $('select[name="no_document"]').val();
  const cek_blm_selesai_timbang = $('button[data-target="#modal-pbb-transact-ambil-berat"]').text();
  const subinv_tujuan = $('input[name=pbb_tujuan]:checked').val();
  const locator_tujuan = $('#pbbtt_locator').val() == undefined ? null : $('#pbbtt_locator').val();
  const item_id_tujuan = $('#pbbtt_item').val();

  if (doc_num != '') {
    if (subinv_tujuan != undefined && locator_tujuan != '' && item_id_tujuan != '') {
      if (cek_blm_selesai_timbang == '') {
        let tampung_berat_timbang = [];
        $('.t_berat_timbang').each((i,v) =>{
          let l = $(v).text().trim();
          let b = l.split(' ');
          tampung_berat_timbang.push(b[0]);
        })
        $.ajax({
          url: baseurl + 'BarangBekas/transact/transact_beneran',
          type: 'POST',
          dataType: 'JSON',
          data: {
            doc_num: doc_num,
            subinv_tujuan: subinv_tujuan,
            locator_tujuan: locator_tujuan,
            item_id_tujuan: item_id_tujuan,
            berat_timbang: tampung_berat_timbang
          },
          cache:false,
          beforeSend: function() {
            toastPBBLoading('Sedang melakukan transact..')
          },
          success: function(result) {
            if (result == 1) {
              toastPBB('success', 'Sukses melakukan transact .. ');
              $('.pbb_transact').val('').trigger('change');
              $('.slc_pbb').val('').trigger('change');
              $('slc_pbb_locator').val('').trigger('change');
            }else if (result == 76) {
              toastPBB('warning', `Dokumen ${doc_num} telah di-transact sebelumnya.`)
            }else if (result == 86) {
              toastPBB('warning', `Terjadi kesalahan saat melakukan insert di misc_issue_receipt`)
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
    }else {
      toastPBB('warning', 'Sebelum melakukan transact, lengkapi form input tujuan dulu!');
    }
  }else {
    toastPBB('warning', 'Sebelum melakukan transact, pilih no dokumen dulu!');
  }


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
