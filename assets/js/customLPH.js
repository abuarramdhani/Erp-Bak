const toastLPH = (type, message) => {
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

const toastLPHLoading = (pesan) => {
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
const swaLPHLarge = (type, a) =>{
  Swal.fire({
    allowOutsideClick: true,
    type: type,
    cancelButtonText: 'Ok!',
    html: a,
    // onBeforeOpen: () => {
    // Swal.showLoading()
    // }
  })
}
const swaLPHLoading = (a) =>{
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

function lph_empty_form() {
  $.ajax({
    url: baseurl + 'LaporanProduksiHarian/action/getEmptyRKH',
    type: 'POST',
    // dataType: 'JSON',
    data: {
    },
    cache:false,
    beforeSend: function() {
      $('.area-lph-2021').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                    <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                    <span style="font-size:14px;font-weight:bold">Sedang memuat form input...</span>
                                </div>`);
    },
    success: function(result) {
      $('.area-lph-2021').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaLPHLarge('error', textStatus)
     console.error();
    }
  })
}

$(document).ready(function () {
  $('.lphgetEmployee').select2({
    minimumInputLength: 2,
    placeholder: "Employee",
    ajax: {
      url: baseurl + "PengirimanBarangInternal/Input/employee",
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
              id: obj.employee_code,
              text: `${obj.employee_name} - ${obj.employee_code}`
            }
          })
        }
      }
    }
  })
  $(".LphTanggal").daterangepicker({
    singleDatePicker: true,
    timePicker: false,
    autoclose: true,
    locale: {
      format: "DD-MM-YYYY",
    },
  });
  $(".tanggal_lph_99").daterangepicker(
  {
    showDropdowns: true,
    autoApply: true,
    locale: {
      format: "DD-MM-YYYY",
      separator: " - ",
      applyLabel: "OK",
      cancelLabel: "Batal",
      fromLabel: "Dari",
      toLabel: "Hingga",
      customRangeLabel: "Custom",
      weekLabel: "W",
      daysOfWeek: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sa"],
      monthNames: [
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
        "Desember",
      ],
      firstDay: 1,
    },
  });

if ($('.area-lph-2021').html() != undefined) {
 lph_empty_form();
}

});

$('.lph_tdl_add').on('change', function() {
  let t = $(this).val().split('-');
  let d = new Date(`${t[2]}-${t[1]}-${t[0]}`);
  var weekday = new Array(7);
  weekday[0] = "Sunday";
  weekday[1] = "Monday";
  weekday[2] = "Tuesday";
  weekday[3] = "Wednesday";
  weekday[4] = "Thursday";
  weekday[5] = "Friday";
  weekday[6] = "Saturday";
  var n = weekday[d.getDay()];
  let menit, standar
  if (n == 'Friday' || n == 'Saturday') {
    menit = 360;
    standar = 330;
  }else {
    menit = 420;
    standar = 390;
  }
  $('.lph_waktu_kerja').text(menit);
  $('.lph_w_standar_efk').text(standar);
})

$("#lph_search_rkh").on('submit', function (e) {
  e.preventDefault();
  let tanggal = $('.lph_search_tanggal').val();
  let shift = $('.lph_shift_dinamis').val();
  let no_induk = $('.lph_search_pekerja').val();
  $.ajax({
    url: baseurl + 'LaporanProduksiHarian/action/getRKH',
    type: 'POST',
    // dataType: 'JSON',
    data: {
      tanggal : tanggal,
      shift : shift,
      no_induk : no_induk
    },
    cache:false,
    beforeSend: function() {
      $('.area-lph-2021').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                            </div>`);
    },
    success: function(result) {
      if (result != 'gada') {
        toastLPH('success', 'Selesai.')
        $('.area-lph-2021').html(result)
      }else {
        // swaLPHLarge('warning', 'Data tidak ditemukan');
        $('.area-lph-2021').html(`<center style="font-weight:bold;margin-bottom:13px;"><i class="fa fa-warning"></i> Data tidak ditemukan</center>`);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaLPHLarge('error', textStatus)
     console.error();
    }
  })
})

function lph_filter_shift(th) {
  $.ajax({
    url: baseurl + 'LaporanProduksiHarian/action/getShift',
    type: 'POST',
    dataType: 'JSON',
    data: {
      tanggal : $(th).val(),
    },
    cache:false,
    beforeSend: function() {
      $('.lph_shift_dinamis').val('').trigger('change');
      toastLPHLoading('Sedang Mengambil Shift...');
    },
    success: function(result) {
      // console.log(result);
      if (result != 0) {
        toastLPH('success', 'Selesai.');
        $('.lph_shift_dinamis').html(result);
      }else {
        toastLPH('warning', 'koneksi terputus, coba lagi nanti');
        $('.lph_shift_dinamis').html('');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaLPHLarge('error', textStatus)
     console.error();
    }
  })
}

$(".tanggal_lph_99").on('change', function() {
  let val = $(this).val().split(' - ');
  if (val[0] != val[1]) {
    $('.lph_cetak_rkh').attr('disabled', true);
  }else {
    $('.lph_cetak_rkh').attr('disabled', false);
  }
})

const lphgetmon = () => {
  $.ajax({
    url: baseurl + 'LaporanProduksiHarian/action/getmon',
    type: 'POST',
    // dataType: 'JSON',
    data: {
      range_date : $('.tanggal_lph_99').val(),
      shift : $('.lph_pilih_shift').val(),
    },
    cache:false,
    beforeSend: function() {
      // swalLoadingCKMB('Sedang Memproses Data...');
      $('.area-lph-monitoring').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                            </div>`);
    },
    success: function(result) {
      $('.area-lph-monitoring').html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaLPHLarge('error', textStatus)
     console.error();
    }
  })
}
