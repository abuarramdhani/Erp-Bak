const toastSK_ = (type, message) => {
    swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    }).fire({
        customClass: 'swal-font-small',
        type: type,
        title: message
    })
}

$(document).ready(function(){
    $('.select-2-status').select2({
            
    });
})

function deleteKalibrasi(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: baseurl + 'SettingKalibrasi/Setting/deleteKalibrasi',
            type: 'POST',
            data: {
              id: id,
            },
            cache: false,
            success: function () {
              $.ajax({
                url: baseurl + 'SettingKalibrasi/Setting/getKalibrasi',
                type: 'POST',
                data: {},
                cache: false,
                beforeSend: function () {
                  $('.area_kalibrasi').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                              <img style="width: 12%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
                                              <span style="font-size:13px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
                                          </div>`);
                },
                success: function (result) {
                  $('.area_kalibrasi').html(result);
                  toastSK_('success', 'Data Berhasil Dihapus');
                },
                eror: function (XMLHttpRequest, textStatus, errorThrown) {
                  console.log();
                }
              })
            }
          })
        }
      })
}

function updateKalibrasi(id, no_alat_ukur, jenis_alat_ukur, last_calibration, next_calibration, lead_time, status) {
    $('[name="upd_id"]').val(id);
    $('#no_alat_ukur_first').val(no_alat_ukur);
    $('#upd_no_alat_ukur').val(no_alat_ukur);
    $('#upd_jenis_alat_ukur').val(jenis_alat_ukur);
    $('#upd_last_calibration').val(last_calibration);
    $('#upd_next_calibration').val(next_calibration);
    $('#upd_lead_time').val(lead_time);
    $("select[name='upd_status'] option").filter(function () {
        return $(this).text() == status;
    }).prop('selected', true).trigger('change');
}

function kirimUpdate() {
    var no_alat_ukur_first = $('#no_alat_ukur_first').val();
    var id = $('[name="upd_id"]').val(); 
    var no_alat_ukur = $('#upd_no_alat_ukur').val();
    var jenis_alat_ukur = $('#upd_jenis_alat_ukur').val();
    var last_calibration = $('#upd_last_calibration').val();
    var next_calibration = $('#upd_next_calibration').val();
    var lead_time = $('#upd_lead_time').val();
    var status = $('select[name="upd_status"]').val();
    $.ajax({
        url: baseurl + 'SettingKalibrasi/Setting/updateKalibrasi',
        type: 'POST',
        data:{
            no_alat_ukur_first: no_alat_ukur_first,
            id: id,
            no_alat_ukur: no_alat_ukur,
            jenis_alat_ukur: jenis_alat_ukur,
            last_calibration: last_calibration,
            next_calibration: next_calibration,
            lead_time: lead_time,
            status: status
        },
        cache: false,
        success: function (result) {
          if (result == 10) {
            alert('No Alat Ukur sudah terdaftar! Silahkan ganti dengan No Alat Ukur lain.');
          }else{
            $('#updateKalibrasi').modal('hide');
            setTimeout(() => {
                Kalibrasi = $.ajax({
                    url: baseurl + 'SettingKalibrasi/Setting/getKalibrasi',
                    type: 'POST',
                    data:{},
                    cache:false,
                    beforeSend: function () {
                        $('.area_kalibrasi').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                                    <img style="width: 12%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
                                                    <span style="font-size:13px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
                                                </div>`);
                      },
                      success: function (result) {      
                          $('.area_kalibrasi').html(result);
                          toastSK_('success', 'Data Berhasil Diupdate');
                      },
                      eror: function (XMLHttpRequest, textStatus, errorThrown) {
                        console.log();
                      }
                })
            }, 450);            
          }
        }
    })    

}

function deleteKalibrasiInactive(id){
  Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: baseurl + 'SettingKalibrasi/Inactive/deleteKalibrasi',
          type: 'POST',
          data: {
            id: id,
          },
          cache: false,
          success: function () {
            $.ajax({
              url: baseurl + 'SettingKalibrasi/Inactive/getKalibrasiInactive',
              type: 'POST',
              data: {},
              cache: false,
              beforeSend: function () {
                $('.area_kalibrasi_inactive').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                            <img style="width: 12%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
                                            <span style="font-size:13px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
                                        </div>`);
              },
              success: function (result) {
                $('.area_kalibrasi_inactive').html(result);
                toastSK_('success', 'Data Berhasil Dihapus');
              },
              eror: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log();
              }
            })
          }
        })
      }
    })
}

function updateKalibrasiInactive(id, no_alat_ukur, jenis_alat_ukur, last_calibration, next_calibration, lead_time, status) {
  $('[name="upd_id_inactive"]').val(id);
  $('#no_alat_ukur_first_inactive').val(no_alat_ukur);
  $('#upd_no_alat_ukur_inactive').val(no_alat_ukur);
  $('#upd_jenis_alat_ukur_inactive').val(jenis_alat_ukur);
  $('#upd_last_calibration_inactive').val(last_calibration);
  $('#upd_next_calibration_inactive').val(next_calibration);
  $('#upd_lead_time_inactive').val(lead_time);
  $("select[name='upd_status_inactive'] option").filter(function () {
      return $(this).text() == status;
  }).prop('selected', true).trigger('change');
}

function kirimUpdateInactive() {
  var no_alat_ukur_first = $('#no_alat_ukur_first_inactive').val();
  var id = $('[name="upd_id_inactive"]').val();
  var no_alat_ukur = $('#upd_no_alat_ukur_inactive').val();
  var jenis_alat_ukur = $('#upd_jenis_alat_ukur_inactive').val();
  var last_calibration = $('#upd_last_calibration_inactive').val();
  var next_calibration = $('#upd_next_calibration_inactive').val();
  var lead_time = $('#upd_lead_time_inactive').val();
  var status = $('select[name="upd_status_inactive"]').val();
  $.ajax({
      url: baseurl + 'SettingKalibrasi/Inactive/updateKalibrasi',
      type: 'POST',
      data:{
          no_alat_ukur_first: no_alat_ukur_first,
          id: id,
          no_alat_ukur: no_alat_ukur,
          jenis_alat_ukur: jenis_alat_ukur,
          last_calibration: last_calibration,
          next_calibration: next_calibration,
          lead_time: lead_time,
          status: status
      },
      cache: false,
      success: function (result) {
        if (result == 10) {
          alert('No Alat Ukur sudah terdaftar! Silahkan ganti dengan No Alat Ukur lain.');
        }else{
          $('#updateKalibrasiInactive').modal('hide');
          setTimeout(() => {
              Kalibrasi = $.ajax({
                  url: baseurl + 'SettingKalibrasi/Inactive/getKalibrasiInactive',
                  type: 'POST',
                  data:{},
                  cache:false,
                  beforeSend: function () {
                      $('.area_kalibrasi_inactive').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                                  <img style="width: 12%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
                                                  <span style="font-size:13px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
                                              </div>`);
                    },
                    success: function (result) {      
                        $('.area_kalibrasi_inactive').html(result);
                        toastSK_('success', 'Data Berhasil Diupdate');
                    },
                    eror: function (XMLHttpRequest, textStatus, errorThrown) {
                      console.log();
                    }
              })
          }, 450);            
        }
      }
  })    

}