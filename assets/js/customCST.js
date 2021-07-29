const toastCST = (type, message) => {
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

const toastCSTLoading = (pesan) => {
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

const swaCSTLarge = (type, a) =>{
  Swal.fire({
    allowOutsideClick: true,
    type: type,
    showConfirmButton: 'Ok!',
    html: a,
    // onBeforeOpen: () => {
    // Swal.showLoading()
    // }
  })
}

const swaCSTLoading = (a) =>{
  Swal.fire({
    allowOutsideClick: false,
    // type: type,
    // cancelButtonText: 'Ok!',
    html: `<div style="font-weight:400">${a}</div>`,
    onBeforeOpen: () => {
      Swal.showLoading()
    }
  })
}

$('.btncstslc').on('click', function() {
  let stat = $(this).attr('status');
  let htm
  if (stat == '+') {
    $('.monitoring-cst').hide();
    $('.addkebutuhan-cst').show();
    stat = '-'
    htm = ` <i class="fa fa-caret-square-o-left"></i> Kembali`
  }else if (stat == '-') {
    $('.monitoring-cst').show();
    $('.addkebutuhan-cst').hide();
    stat = '+'
    htm = ` <i class="fa fa-plus"></i> Tambah Pengajuan`
  }
  $(this).attr('status', stat);
  $(this).html(htm)
})

function runsctselect2() {
  $('.select2_inpkebutuhan_cst').select2({
    placeholder: "Item Desc..",
    templateSelection: (options) => {
      return options.id;
    },
    tags: true,
    allowClear:true,
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "consumableseksiv2/action/getitem",
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
              id: `${obj.DESCRIPTION}`,
              text:`${obj.DESCRIPTION} - ${obj.SEGMENT1}`,
              item_id: `${obj.INVENTORY_ITEM_ID}`,
              segment1: `${obj.SEGMENT1}`,
              uom: `${obj.PRIMARY_UOM_CODE}`
            }
          })
        }
      }
    }
  })

  $('.select2_inpkebutuhan_cst').on('change', function() {
    let segment1 = $(this).select2('data')[0].segment1
    let item_id = $(this).select2('data')[0].item_id
    let uom = $(this).select2('data')[0].uom
    $(this).parent().parent('tr').find('.item-code').val(segment1)
    $(this).parent().parent('tr').find('.item_id').val(item_id)
    $(this).parent().parent('tr').find('.uom').val(uom)
  })
}

$(document).ready(function () {
  runsctselect2()
  $('.tbl_cst_kebutuhan').dataTable()
  $('.tbl_cst_kebutuhan_ss').DataTable({
     // dom: 'rtp',
     ajax: {
       data: (d) => $.extend({}, d, {
         // org: null,    // optional
         // id_plan: null // optional
       }),
       url: baseurl + "consumableseksiv2/action/getkebutuhan",
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
          if ($.fn.DataTable.isDataTable('.tbl_cst_kebutuhan_ss')) {
              var dt = $('.tbl_cst_kebutuhan_ss').DataTable();
              //Abort previous ajax request if it is still in process.
              var settings = dt.settings();
              if (settings[0].jqXHR) {
                  settings[0].jqXHR.abort();
              }
          }
      }
  });
  $('.tbl_cst_pengajuan_seksi').dataTable()

  function pad(val) {
      var valString = val + "";
      if (valString.length < 2) {
      return "0" + valString;
      } else {
      return valString;
      }
  }

  $("input#periode_pengajuan").monthpicker({
    changeYear: true,
    dateFormat: "yy-mm",
  });

  $(".periode_track").monthpicker({
    changeYear: true,
    dateFormat: "yy-mm",
  });

  if ($('#consumabletimtrackv2').val() == 1) {
    $(".periode_track").on('click', function() {
      $('.datepicker').remove()
    })
  }

  $('.periode_pengajuan').on('change', function() {
    var d = new Date();
    var n = d.getFullYear();
    var m = d.getMonth() + 01;
    if (m < 10) {
      m = "0" + m;
    }
    console.log(m);
    var v = $(this).val().split("-");
    if (v[0] < n) {
      Swal.fire(
        "Tidak dapat melanjutkan proses",
        "Tahun tidak boleh lebih kecil dari tahun sekarang",
        "warning"
      );
      $(this).val(pad(n) + "-" + m);
    } else if (v[1] > n) {
      //oke
    } else if (v[1] < m) {
      Swal.fire(
        "Tidak dapat melanjutkan proses",
        "Bulan tidak boleh lebih kecil dari bulan sekarang",
        "warning"
      );
      $(this).val(pad(n) + "-" + m);
    }
  });
})

function btnPlusIKCST() {
  $('#tambahannya_disini').append(`<tr>
                                    <td class="text-center">
                                      <input type="hidden" name="item_id[]" class="item_id" value="">
                                      <select class="select2_inpkebutuhan_cst" required style="width:380px" name="description[]">
                                        <option value="" selected></option>
                                      </select>
                                    </td>
                                    <td class="text-center"><input type="text" name="item_code[]" class="form-control item-code" readonly="readonly"></td>
                                    <td class="text-center"><input type="number" required class="form-control" name="qty_kebutuhan[]" required="required"></td>
                                    <td class="text-center"><input type="text" class="form-control uom" readonly="readonly"></td>
                                    <td class="text-center">
                                      <button class="btn btn-default btn-sm" onclick="btnMinIKCST(this)">
                                        <i class="fa fa-minus"></i>
                                      </button>
                                    </td>
                                  </tr>`)
  runsctselect2()
}

function btnMinIKCST(th) {
  $(th).parent().parent('tr').remove();
}

$('.saveinputkebutuhan').on('submit', function(e) {
  e.preventDefault()
  $.ajax({
  url: baseurl + 'consumableseksiv2/action/savekebutuhan',
  type: 'POST',
  data : new FormData($(this).get(0)),
  contentType: false,
  cache: false,
  // async:false,
  processData: false,
  dataType: "JSON",
  beforeSend: function() {
    swaCSTLoading('Sedang menyimpan data')
  },
  success: function(result) {
    if (result == 'done') {
      toastCST('success', `Data Berhasil Tersimpan`);
      $('.tableinputkebutuhan tbody tr').remove();
      btnPlusIKCST();
      $('.tbl_cst_kebutuhan_ss').DataTable().ajax.reload();
      // $('#tambahitemcst').modal('hide');
      $('.btncstslc').trigger('click')
    }else {
      toastCST('warning', 'Terjadi Kesalahan Saat Menyipan Data. Coba lagi..');
    }
  },
  error: function(XMLHttpRequest, textStatus, errorThrown) {
  swaCSTLarge('error', XMLHttpRequest);
   console.error();
  }
 })
})

function reloadsstblkebutuhan() {
  $('.tbl_cst_kebutuhan_ss').DataTable().ajax.reload();
}

function delcstkebutuhan(id) {
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "....",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      $.ajax({
      url: baseurl + 'consumableseksiv2/action/delkebutuhan',
      type: 'POST',
      data : {
        id : id
      },
      cache: false,
      // async:false,
      dataType: "JSON",
      beforeSend: function() {
        // $('#modalUP2LCompleteJob').modal('hide');
        swaCSTLoading('Menghapus data')
      },
      success: function(result) {
        if (result == 'done') {
          toastCST('success', `Berhasil Dihapus`);
          $('.tbl_cst_kebutuhan_ss').DataTable().ajax.reload();
        }else {
          toastCST('warning', 'Terjadi Kesalahan Saat Menghapus Data! Harap Coba lagi');
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swaCSTLarge('error', XMLHttpRequest);
       console.error();
      }
      })
    }
  })

}

// ==================== area consumable tim v2 ======================== //
function viewapprovalkeb(kodesie) {
  $.ajax({
  url: baseurl + 'consumabletimv2/action/viewapprovalkeb',
  type: 'POST',
  // data : {
  //   kodesie : kodesie
  // },
  cache: false,
  beforeSend: function() {
    $('.areaviewapprovalkeb').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                        <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                        <span style="font-size:14px;font-weight:bold">Sedang memuat form input...</span>
                                    </div>`)
  },
  success: function(result) {
    $('.areaviewapprovalkeb').html(result)
  },
  error: function(XMLHttpRequest, textStatus, errorThrown) {
  swaCSTLarge('error', XMLHttpRequest);
   console.error();
  }
  })
}

$(document).ready(function() {
  if ($('#consumablepermintaanv2').val() == 1) {
    viewapprovalkeb()
  }
})
