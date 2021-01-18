const toastCKMBExc = (type, message) => {
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

const toastCKMBLoading = (pesan) => {
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
// b0595
// 123456
const swalLoadingCKMB = (a) =>{
  Swal.fire({
    allowOutsideClick: true,
    title: 'Loading',
    // cancelButtonText: 'No, cancel!',
    html: a,
    onBeforeOpen: () => {
    Swal.showLoading()
    }
  })
}


$(document).ready(function() {
  $('.select2_ckmb').select2({
     placeholder: "Type Engine",
     allowClear: true,
  });

  $(".tanggal_ckmb").daterangepicker(
  {
    showDropdowns: true,
    autoApply: true,
    locale: {
      format: "YYYY-MM-DD",
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
})

const filter_ckmb = () => {
  const param = $('.tanggal_ckmb').val();
  const param_2 = $('.select2_ckmb').val();
  $.ajax({
    url: baseurl + 'CetakKIBMotorBensin/CKMB/getFilterByDate',
    type: 'POST',
    // dataType: 'JSON',
    data: {
      range_date : param,
      tipe : param_2,
    },
    cache:false,
    beforeSend: function() {
      // swalLoadingCKMB('Sedang Memproses Data...');
      $('.area_ckmb').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                <img style="width: 10%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                <span style="font-size:13px;">Sedang memuat data...</span>
                            </div>`);
    },
    success: function(result) {
      if (result != 0) {
        $('.area_ckmb').html(result);
        Swal.close();
      }else {
        toastCKMBExc('warning', 'Terdapat Kesalahan Saat Mengambil Data.');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalAppLarge('error', textStatus)
     console.error();
    }
  })
}
