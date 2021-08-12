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
    text: pesan,
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


function agt_update_pos_submit() {
  $.ajax({
    url: baseurl + 'CompletionAssemblyGearTrans/action/updatepos',
    type: 'POST',
    dataType: 'JSON',
    data: {
      item_id: $('.agt_item_id').val(),
      status_job: $('.agt_pos').val()
    },
    cache:false,
    beforeSend: function() {
      toastAGTLoading('Sedang mengupdate data..');
    },
    success: function(result) {
      if (result == 200) {
        toastAGT('success', 'Berhasil diupdate');
        agtRunningAndon();
        $('#modal-agt-edit-pos').modal('toggle');
      }else {
        toastAGT('warning', 'Data gagal diupdate, coba lagi');
      }

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalAGT('error', 'Terdapat Kesalahan, Coba Lagi...');
    console.error();
    }
  })
}

function agt_update_pos(item_id, status_job, no_job) {
  $('#modal-agt-edit-pos').modal('toggle');
  $('.agt_pos').select2();
  $('#agt_nojob').text(no_job);
  $('.agt_pos').val(status_job).trigger('change');
  $('.agt_item_id').val(item_id);
}

function del_agt_andon_pos(item_id, s, date) {
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Anda tidak akan dapat mengembalikan ini!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus saja!'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: baseurl + 'CompletionAssemblyGearTrans/action/delpos',
        type: 'POST',
        dataType: 'JSON',
        data: {
          item_id: item_id,
          date_time: date
        },
        cache:false,
        beforeSend: function() {
          toastAGTLoading('Sedang menghapus data..');
        },
        success: function(result) {
          if (result == 200) {
            toastAGT('success', 'Data berhasil dihapus');
            if (s == 1) {
              agtRunningAndon();
            }else if (s == 2) {
              agtHistoryAndon();
            }else if (s == 3) {
              filter_history_agt();
            }
          }else {
            toastAGT('warning', 'Data gagal dihapus, coba lagi');
          }

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        swalAGT('error', 'Terdapat Kesalahan, Coba Lagi...');
        console.error();
        }
      })
    }
  })

}

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

function agtTimerAndon() {
  $.ajax({
    url: baseurl + 'CompletionAssemblyGearTrans/action/timerAndon',
    type: 'POST',
    // dataType: 'JSON',
    data: {

    },
    cache:false,
    beforeSend: function() {
      $('.area-time-andon').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                            </div>`);
    },
    success: function(result) {
      $('.area-time-andon').html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalAGT('error', 'Terdapat Kesalahan, Coba Lagi...');
    $('.area-time-andon').html('');
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
      item_id: item_id,
    },
    cache:false,
    success: function(result) {
      if (result == 200) {
        swalAGT('warning',`Qty Nomor job ${no_job} sudah terpenuhi`);
        $('.agt_alert_area').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">
                                        <i class="fa fa-close"></i>
                                      </span>
                                    </button>
                                    <strong>Qty Nomor job ${no_job} sudah terpenuhi</strong>
                                  </div>`);
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
              $('.agt_alert_area').html(`<div class="alert alert-success alert-dismissible" role="alert">
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">
                                              <i class="fa fa-close"></i>
                                            </span>
                                          </button>
                                          <strong><i class="fa fa-check-square"></i> Sukses menambahkan job ${no_job} di POS 1</strong>
                                        </div>`);

            }else {
              swalAGT('warning',`Gagal menambahkan job ${no_job} di POS 1, Coba lagi`);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
           swalAGT('error', 'Terdapat Kesalahan...');
           $('.agt_alert_area').html('')
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
  let cek = $('#agt_jenis_scan').val();
  if (cek == 'qr') {
    $('#qrcodeAGT').val('').trigger('change');
  }else if (cek == 'item_code') {
    $('.agt_get_item_code').val('').trigger('change')
  }
})

function byqrorkodeitem_agt(th) {
  let tipe = $('#agt_jenis_scan').val();
  if (tipe == 'qr') {
    $('#agt_jenis_scan').val('item_code');
    $('.agt_area_qr').hide()
    $('.agt_area_item').show()
    $(th).html('<b>By Item Code</b>').removeClass('btn-primary').addClass('btn-danger')
    $('.agt_get_item_code').select2({
      placeholder: "Ketikan kode item/ deskripsi item",
      minimumInputLength: 3,
      ajax: {
        url: baseurl + "CompletionAssemblyGearTrans/action/getitemcode",
        dataType: "JSON",
        type: "POST",
        data: function(params) {
          return {
            term: params.term
          };
        },
        processResults: function(data) {
          return {
            results: $.map(data, function(obj) {
              return {
                id: obj.INVENTORY_ITEM_ID,
                text: `${obj.SEGMENT1} - ${obj.DESCRIPTION}`
              }
            })
          }
        }
      }
    })
  }else {
    $('#agt_jenis_scan').val('qr');
    $('.agt_area_qr').show()
    $('.agt_area_item').hide()
    $(th).html('<b>By QR Code</b>').removeClass('btn-danger').addClass('btn-primary')
    setTimeout(function () {
      $('#qrcodeAGT').focus();
    }, 400);
  }

}

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
                                  <span style="font-size:14px;font-weight:bold">Sedang memproses data...</span>
                              </div>`);
      },
      success: function(result) {
        if (result != 0) {
          $('#areaAGT').html(result);
          $(th).val('');
          $('.submitagtjob').trigger('click');
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
