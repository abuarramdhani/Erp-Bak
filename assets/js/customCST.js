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
    $('.addkebutuhan-cst').fadeIn(400);
    stat = '-'
    htm = ` <i class="fa fa-caret-square-o-left"></i> Kembali`
  }else if (stat == '-') {
    $('.monitoring-cst').fadeIn(400);
    $('.addkebutuhan-cst').hide();
    stat = '+'
    htm = ` <i class="fa fa-plus"></i> Tambah Pengajuan`
  }
  $(this).attr('status', stat);
  $(this).html(htm)
})

$('.csttambahdataseksi').on('click', function() {
  let stat = $(this).attr('status');
  let htm
  if (stat == '+') {
    $('.areacsmmds').hide();
    $('.areacsmmdsadd').fadeIn(400);
    stat = '-'
    htm = ` <i class="fa fa-caret-square-o-left"></i> Kembali`
  }else if (stat == '-') {
    $('.areacsmmds').fadeIn(400);
    $('.areacsmmdsadd').hide();
    stat = '+'
    htm = ` <i class="fa fa-plus"></i> Tambah Seksi`
  }
  $(this).attr('status', stat);
  $(this).html(htm)
})

$('.btncstslckeb').on('click', function() {
  let stat = $(this).attr('status');
  let htm
  if (stat == '+') {
    $('.areamkeb').hide();
    $('.areapkeb').fadeIn(400);
    stat = '-'
    htm = ` <i class="fa fa-caret-square-o-left"></i> Kembali`
  }else if (stat == '-') {
    $('.areamkeb').fadeIn(400);
    $('.areapkeb').hide();
    stat = '+'
    htm = ` <i class="fa fa-plus"></i> Ajukan Kebutuhan`
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

function runsctselect2pengajuankeb() {
  $('.slccsmkeb').select2({
    placeholder: "Item Desc..",
    templateSelection: (options) => {
      return options.id;
    },
    tags: true,
    allowClear:true,
    // minimumInputLength: 1,
    ajax: {
      url: baseurl + "consumableseksiv2/action/getitempengajuan",
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
              uom: `${obj.PRIMARY_UOM_CODE}`,
              tglpengajuan: `${obj.PENGAJUAN_DATE}`
            }
          })
        }
      }
    }
  })

  $('.slccsmkeb').on('change', function() {
    let segment1 = $(this).select2('data')[0].segment1
    let item_id = $(this).select2('data')[0].item_id
    let uom = $(this).select2('data')[0].uom
    $(this).parent().parent('tr').find('.item-code').val(segment1)
    $(this).parent().parent('tr').find('.item_id').val(item_id)
    $(this).parent().parent('tr').find('.uom').val(uom)
    $(this).parent().parent('tr').find('.tglpengajuan').val($(this).select2('data')[0].tglpengajuan)
  })
}

function btnPlusKCIS() {
  $('#addrow_pengajuankeb').append(`<tr>
                                      <td class="text-center">${Number($('#addrow_pengajuankeb tr').length) + 1}</td>
                                      <td class="text-center">
                                        <input type="hidden" name="item_id[]" class="item_id" value="">
                                        <select class="slccsmkeb" required style="width:300px" name="description[]">
                                          <option value="" selected></option>
                                        </select>
                                      </td>
                                      <td class="text-center"><input type="text" class="form-control item-code" name="item_code[]" readonly="readonly"></td>
                                      <td class="text-center"><input type="number" required class="form-control" name="qty_kebutuhan[]" required="required"></td>
                                      <td class="text-center"><input type="text" class="form-control uom" readonly="readonly"></td>
                                      <td class="text-center"><input type="text" class="form-control tglpengajuan" readonly="readonly"></td>
                                      <td class="text-center">
                                        <button class="btn btn-default btn-sm" onclick="btnMinKCIS(this)">
                                          <i class="fa fa-minus"></i>
                                        </button>
                                      </td>
                                    </tr>`)
  runsctselect2pengajuankeb()
}

function btnMinKCIS(th) {
  $(th).parent().parent('tr').remove();
  $('#addrow_pengajuankeb tr').each((i,v)=>{
    $(v).find('td:first-child').html(Number(i)+1);
  })
}

$(document).ready(function () {
  runsctselect2()
  runsctselect2pengajuankeb()
  $('.tbl_cst_kebutuhan').dataTable()
  $('.tblcsmpengajuankeb').dataTable({
    // dom: 'rtp',
    ajax: {
      data: (d) => $.extend({}, d, {
        // org: null,    // optional
        // id_plan: null // optional
      }),
      url: baseurl + "consumableseksiv2/action/getpengajuankeb",
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
         if ($.fn.DataTable.isDataTable('.tblcsmpengajuankeb')) {
             var dt = $('.tblcsmpengajuankeb').DataTable();
             //Abort previous ajax request if it is still in process.
             var settings = dt.settings();
             if (settings[0].jqXHR) {
                 settings[0].jqXHR.abort();
             }
         }
     }
  })
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
    // console.log(m);
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

$('.savepengajuankeb').on('submit', function(e) {
  e.preventDefault()
  if ($('#addrow_pengajuankeb tr').length) {
    $.ajax({
    url: baseurl + 'consumableseksiv2/action/savepengajuankeb',
    type: 'POST',
    data : new FormData($(this).get(0)),
    contentType: false,
    cache: false,
    // async:false,
    processData: false,
    dataType: "JSON",
    beforeSend: function() {
      swaCSTLoading('Sedang memproses item pengajuan')
    },
    success: function(result) {
      if (result == 'done') {
        toastCST('success', `Item Berhasil Diajukan`);
        $('#addrow_pengajuankeb tr').remove();
        btnPlusKCIS();
        $('.tblcsmpengajuankeb').DataTable().ajax.reload();
        $('.btncstslckeb').trigger('click')
      }else if (result.status == 'wesono') {
        swaCSTLarge('warning', `${result.message}`);
      }else {
        toastCST('warning', 'Terjadi Kesalahan Saat Menyipkan Data. Coba lagi..');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaCSTLarge('error', `${XMLHttpRequest.responseText}`);
     console.error();
    }
   })
  }else {
    swaCSTLarge('info', 'Pilih item terlebih dahulu')
  }
})

$('.saveinputkebutuhan').on('submit', function(e) {
  e.preventDefault()
  if ($('#tambahannya_disini tr').length) {
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
      swaCSTLoading('Sedang memproses item pengajuan')
    },
    success: function(result) {
      if (result == 'done') {
        toastCST('success', `Item Berhasil Diajukan`);
        $('.tableinputkebutuhan tbody tr').remove();
        btnPlusIKCST();
        $('.tbl_cst_kebutuhan_ss').DataTable().ajax.reload();
        $('.btncstslc').trigger('click')
      }else if (result.status == 'wesono') {
        swaCSTLarge('warning', `${result.message}`);
      }else {
        toastCST('warning', 'Terjadi Kesalahan Saat Menyipkan Data. Coba lagi..');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaCSTLarge('error', `${XMLHttpRequest.responseText}`);
     console.error();
    }
   })
  }else {
    swaCSTLarge('info', `Pilih item dulu`);
  }
})

function reloadsstblpengajuanitem() {
  $('.tbl_cst_kebutuhan_ss').DataTable().ajax.reload();
}

function reloadsstblpengajuankebutuhan() {
  $('.tblcsmpengajuankeb').DataTable().ajax.reload();
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
          toastCST('success', `Item Berhasil Dihapus`);
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

function delcstpengajuan(id) {
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
      url: baseurl + 'consumableseksiv2/action/delpengajuan',
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
          toastCST('success', `Pengajuan Berhasil Dihapus`);
          $('.tblcsmpengajuankeb').DataTable().ajax.reload();
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
let apporreject = 1;
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
                                        <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                                    </div>`)
  },
  success: function(result) {
    $('.areaviewapprovalkeb').html(result)
  },
  error: function(XMLHttpRequest, textStatus, errorThrown) {
  swaCSTLarge('error', `${XMLHttpRequest}`);
   console.error();
  }
  })
}

function viewapprovalitem(kodesie) {
  $.ajax({
  url: baseurl + 'consumabletimv2/action/viewapprovalitem',
  type: 'POST',
  // data : {
  //   kodesie : kodesie
  // },
  cache: false,
  beforeSend: function() {
    $('.areaviewapprovalitem').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                        <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                        <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                                    </div>`)
  },
  success: function(result) {
    $('.areaviewapprovalitem').html(result)
  },
  error: function(XMLHttpRequest, textStatus, errorThrown) {
  swaCSTLarge('error', `${XMLHttpRequest}`);
   console.error();
  }
  })
}

$('.csttambahdataitem').on('click', function() {
  let stat = $(this).attr('status');
  let htm
  if (stat == '+') {
    $('.cstmasteritem').hide();
    $('.csttambahitem').fadeIn(400);
    stat = '-'
    htm = ` <i class="fa fa-caret-square-o-left"></i> Kembali`
  }else if (stat == '-') {
    $('.cstmasteritem').fadeIn(400);
    $('.csttambahitem').hide();
    stat = '+'
    htm = ` <i class="fa fa-plus"></i> Tambah Data Item`
  }
  $(this).attr('status', stat);
  $(this).html(htm)
})

function runtimselect2() {
  $('.select2_cstmsib').select2({
    placeholder: "Item Desc..",
    templateSelection: (options) => {
      return options.id;
    },
    tags: true,
    allowClear:true,
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "consumabletimv2/action/getitem",
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
              id: `${obj.SEGMENT1}`,
              text:`${obj.DESCRIPTION} - ${obj.SEGMENT1}`,
              item_id: `${obj.INVENTORY_ITEM_ID}`,
              desc: `${obj.DESCRIPTION}`,
              uom: `${obj.PRIMARY_UOM_CODE}`,
              leadtime: obj.LEADTIME == null ? '' : obj.LEADTIME,
              max_stok: obj.MAX_STOCK == null ? '' : obj.MAX_STOCK,
              min_stok: obj.MIN_STOCK == null ? '' : obj.MIN_STOCK,
              moq: obj.MOQ == null ?'' :  obj.MOQ,
            }
          })
        }
      }
    }
  })

  $('.select2_cstmsib').on('change', function() {
    // console.log($(this).select2('data')[0]);
    let desc = $(this).select2('data')[0].desc
    let item_id = $(this).select2('data')[0].item_id
    let uom = $(this).select2('data')[0].uom
    $(this).parent().parent('tr').find('input[name="description"]').val(desc)
    $(this).parent().parent('tr').find('.item_id').val(item_id)
    $(this).parent().parent('tr').find('input[name="uom"]').val(uom)

    $(this).parent().parent('tr').find('input[name="moq"]').val($(this).select2('data')[0].moq)
    $(this).parent().parent('tr').find('input[name="leadtime"]').val($(this).select2('data')[0].leadtime)
    $(this).parent().parent('tr').find('input[name="max_stock"]').val($(this).select2('data')[0].max_stok)
    $(this).parent().parent('tr').find('input[name="min_stock"]').val($(this).select2('data')[0].min_stok)
  })
}

function btnPlusMasterItem() {
  let no = Number($('#areaaddmsibitem tr').length) + 1
  $('#areaaddmsibitem').append(`<tr>
                                  <td>${no}</td>
                                  <td>
                                    <input type="hidden" name="item_id[]" class="item_id" value="">
                                    <select class="select2_cstmsib" required style="width:170px" name="kodeitem[]">
                                      <option value="" selected></option>
                                    </select>
                                  </td>
                                  <td>
                                    <input type="text" readonly class="form-control" name="description" value="">
                                  </td>
                                  <td>
                                    <input type="text" readonly class="form-control" name="uom" value="">
                                  </td>
                                  <td>
                                    <input type="text" readonly class="form-control" name="leadtime" value="">
                                  </td>
                                  <td>
                                   <input type="text" readonly class="form-control" name="moq" value="">
                                  </td>
                                  <td>
                                   <input type="text" readonly class="form-control" name="min_stock" value="">
                                  </td>
                                  <td>
                                   <input type="text" readonly class="form-control" name="max_stock" value="">
                                  </td>
                                  <td>
                                    <button class="btn btn-default btn-sm" onclick="cstitemmin(this)" style="border: 1px solid #a8a8a8;background:white">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </td>
                                </tr>`)
   runtimselect2()
}

function csmdataseksi() {
  $.ajax({
  url: baseurl + 'consumabletimv2/action/datacsmseksi',
  type: 'POST',
  cache: false,
  beforeSend: function() {
    $('.areadataseksi').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                        <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                        <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                                    </div>`)
  },
  success: function(result) {
    $('.areadataseksi').html(result)
  },
  error: function(XMLHttpRequest, textStatus, errorThrown) {
  swaCSTLarge('error', `${XMLHttpRequest.responseText}`);
   console.error();
  }
  })
}

function seksiblmmengajukan() {
  $.ajax({
    url: baseurl + 'consumabletimv2/action/seksiygblmmengajukan',
    type: 'POST',
    cache: false,
    beforeSend: function() {
      $('.areaseksiblmmengajukan').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                          <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                          <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                                      </div>`)
    },
    success: function(result) {
      $('.areaseksiblmmengajukan').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaCSTLarge('error', `${XMLHttpRequest.responseText}`);
     console.error();
    }
  })
}

$(document).ready(function() {
  if ($('#consumablepermintaanv2').val() == 1) {
    viewapprovalkeb()
    viewapprovalitem()
    seksiblmmengajukan()
  }
  if ($('#consumabletimsettingdatav2').val() == 1) {
    csmdataseksi()
    runtimselect2()
    $('.slc_csm_seksi').select2({
      placeholder: "Pilih Seksi..",
      tags: true,
      allowClear:true,
      minimumInputLength: 3,
      ajax: {
        url: baseurl + "consumabletimv2/action/getseksi",
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
                id: `${obj.seksi}`,
                text:`${obj.seksi}`,
                kodesie:`${obj.kodesie}`
              }
            })
          }
        }
      }
    })
    $('.slc_csm_employ').select2({
      placeholder: "Pilih Seksi Dulu..",
    })
    $('.tbl_cst_master_item').DataTable({
       // dom: 'rtp',
       ajax: {
         data: (d) => $.extend({}, d, {
           // org: null,    // optional
           // id_plan: null // optional
         }),
         url: baseurl + "consumabletimv2/action/getmasteritem",
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
            if ($.fn.DataTable.isDataTable('.tbl_cst_master_item')) {
                var dt = $('.tbl_cst_master_item').DataTable();
                //Abort previous ajax request if it is still in process.
                var settings = dt.settings();
                if (settings[0].jqXHR) {
                    settings[0].jqXHR.abort();
                }
            }
        }
    });

  }
})

function cstitemmin(th) {
  $(th).parent().parent().remove()
  $('#areaaddmsibitem tr').each((i,v)=>{
    $(v).find('td:first-child').html(Number(i)+1);
  })
}

$('.savecstitem').on('submit', function(e) {
  e.preventDefault()
  if (Number($('#areaaddmsibitem tr').length)) {
    $.ajax({
    url: baseurl + 'consumabletimv2/action/savemasteritem',
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
      if (result.status == 'done') {
        toastCST('success', `Data Berhasil Tersimpan`);
        $('#areaaddmsibitem tr').remove();
        btnPlusMasterItem();
        $('.tbl_cst_master_item').DataTable().ajax.reload();
        $('.csttambahdataitem').trigger('click')
      }else if (result.status == 'wesono') {
        swaCSTLarge('warning', `${result.message}`);
      }else {
        toastCST('warning', 'Terjadi Kesalahan Saat Menyipan Data. Coba lagi..');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
     console.log(XMLHttpRequest);
     swaCSTLarge('error', `${XMLHttpRequest.responseText}`);
     console.error();
    }
   })
 }else {
   swaCSTLarge('info', `tambahkan item dulu.`);
 }
})

$('.savecsmseksi').on('submit', function(e) {
  e.preventDefault()
    $.ajax({
    url: baseurl + 'consumabletimv2/action/savecsmseksi',
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
      if (result.status == 'done') {
        toastCST('success', `Data Berhasil Tersimpan`);
        $('.savecsmseksi')[0].reset()
        $('.slc_csm_seksi').val('').trigger('change')
        $('.slc_csm_employ').val('').trigger('change')
        $('.csttambahdataseksi').trigger('click')
        csmdataseksi()
      }else if (result.status == 'wesono') {
        swaCSTLarge('warning', `${result.message}`);
      }else {
        toastCST('warning', 'Terjadi Kesalahan Saat Menyipan Data. Coba lagi..');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
     console.log(XMLHttpRequest);
     swaCSTLarge('error', `${XMLHttpRequest.responseText}`);
     console.error();
    }
   })
})

function slccsmemploy(kodesie) {
  $('.slc_csm_employ').select2({
    placeholder: "Employee Name..",
    tags: true,
    allowClear:true,
    minimumInputLength: 1,
    ajax: {
      url: baseurl + "consumabletimv2/action/employee",
      dataType: "JSON",
      type: "POST",
      cache: false,
      data: function(params) {
        return {
          term: params.term,
          kodesie: kodesie
        };
      },
      processResults: function(data) {
        return {
          results: $.map(data, function(obj) {
            return {
              id: `${obj.nama} - ${obj.noind}`,
              text:`${obj.nama} - ${obj.noind}`
            }
          })
        }
      }
    }
  })
}

$('.slc_csm_seksi').on('change', function() {
  let val = $(this).val().split(' - ')[1];
  let kodesie = $(this).select2('data')[0].kodesie;
  slccsmemploy(kodesie);

})

$('.csm_voip').on('input', function() {
  let val = $(this).val().length
  if (val > 5) {
    swaCSTLarge('info', 'panjang nomor maksimal 5')
    let new_ = $(this).val().substr(0,5)
    $(this).val(new_)
  }
})

function updatepicvoip() {
  let kodesie = $('#edtds_kodesie').val()
  let pic = $('#edtds_pic').val();
  let voip = $('#edtds_voip').val();
  if (pic != '' && voip != '') {
     $.ajax({
     url: baseurl + 'consumabletimv2/action/updatepicvoip',
     type: 'POST',
     data : {
       kodesie:kodesie,
       pic:pic,
       voip:voip
     },
     cache: false,
     // async:false,
     dataType: "JSON",
     beforeSend: function() {
       swaCSTLoading('Mengupdate...')
     },
     success: function(result) {
      if (result == 'done') {
        swaCSTLarge('success', 'Berhasil mengupdate data')
        csmdataseksi();
        $('#editmasterseksi').modal('hide');
      }else {
        swaCSTLarge('warning', 'Gagal melakukan update');
      }
     },
     error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.log(XMLHttpRequest);
      swaCSTLarge('error', `${XMLHttpRequest.responseText}`);
      console.error();
     }
    })
  }
}
