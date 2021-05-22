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

$(document).ready(function () {

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
  },
);
});

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
    swalLPHLarge('error', textStatus)
     console.error();
    }
  })
}
$('.tanggal_lph_100').datepicker({
  todayBtn: "linked",
  language: "it",
  autoclose: true,
  todayHighlight: true,
  format: 'dd-mm-yyyy'
});
$('.LphTanggal').datepicker({
  todayHighlight: true,
  format: 'dd-M-yyyy',
  autoclose: true
});
