const toastRTA_ = (type, message) => {
  Swal.mixin({
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

$(document).ready(function () {
  $('.select-handling').select2({
    tags: true,
        allowClear:true,
        minimumInputLength: 0,
        placeholder: "Pilih Seksi",
        ajax: {
          url: baseurl + "RekapTemuanAudite/Handling/getSeksi",
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
                  id: obj.seksi,
                  text: obj.seksi
                }
              })
            }
          }
        }
  });
})

$('.select-handling').change(function(){
  if ($(this).val() != '') {
    $('#handlingRTA').removeAttr("disabled");
  }else {
    $('#handlingRTA').attr("disabled", true);
  }
})

let rta_handling = null;

const handling_rta = () =>{
  let seksi_handling = $('.select-handling').val();

  if (rta_handling != null) {
    rta_handling.abort();
    toastRTA_('warning', 'Data Request Canceled');
  }

  rta_handling = $.ajax({
    url: baseurl + 'RekapTemuanAudite/Handling/getDataAudite',
    type: 'POST',
    data: {
      seksi_handling: seksi_handling,
    },
    cache: false,
    beforeSend: function () {
      $('.rta_handling_area').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <img style="width: 12%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
                                  <span style="font-size:13px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
                              </div>`);
    },
    success: function(result) {
      if (result != 0) {
        $('.rta_handling_area').html(result);
        $('#top').text(`Menampilkan Daftar Temuan Audite ${seksi_handling}`);
        toastRTA_('success', 'Success Load Data');
        rta_handling = null;
      }else if (result == 0) {
        $('.rta_handling_area').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <i class="fa fa-remove" style="color:#d60d00;font-size:45px;"></i><br>
                                  <h3 style="font-size:14px;font-weight:bold">Tidak ada data Temuan Audite ${seksi_handling}</h3>
                              </div>`);
        rta_handling = null;
      }else {
        toastRTA_('Warning', 'Terdapat Kesalahan Saat Mengambil Data');
        rta_handling = null;
      }
    },
    eror: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log();
      rta_handling = null;
    }
  })
}
