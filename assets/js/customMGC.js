$(document).ready(function() {
    $(".select_MGC").select2();
})
const swalMGCLarge = (type, a) =>{
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

let pod, aktual_out, aktual_in = null;
function getpodMGC() {
  let planid = $('#planid').val();
  if (pod != null) {
    pod.abort();
  }
  if (pod != null) {
    aktual_out.abort();
  }
  if (pod != null) {
    aktual_in.abort();
  }

  $.ajax({
      url: baseurl + 'MonitoringGudangCustomable/Monitoring/getmaster',
      type: 'POST',
      // dataType: 'JSON',
      data: {
        planid : planid,
      },
      cache:false,
      beforeSend: function() {
        // swalLoadingCKMB('Sedang Memproses Data...');
        $('.area_mgc').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                  <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                              </div>`);
      },
      success: function(result) {
        $('.area_mgc').html(result);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalMGCLarge('error', textStatus)
       console.error();
      }
    })
  // console.log(planid);
}

// const toastCKMBExc = (type, message) => {
//   Swal.mixin({
//     toast: true,
//     position: 'top-end',
//     showConfirmButton: false,
//     timer: 3000
//   }).fire({
//     customClass: 'swal-font-small',
//     type: type,
//     title: message
//   })
// }
//
// const toastCKMBLoading = (pesan) => {
//   Swal.fire({
//     toast: true,
//     position: 'top-end',
//     onBeforeOpen: () => {
//        Swal.showLoading();
//        $('.swal2-loading').children('button').css({'width': '20px', 'height': '20px'})
//      },
//     text: pesan
//   })
// }
// // b0595
// // 123456

//
//
// $(document).ready(function() {
//   $('.select2_ckmb').select2({
//      placeholder: "Type Engine",
//      allowClear: true,
//   });
//
//   $(".tanggal_ckmb").daterangepicker(
//   {
//     showDropdowns: true,
//     autoApply: true,
//     locale: {
//       format: "YYYY-MM-DD",
//       separator: " - ",
//       applyLabel: "OK",
//       cancelLabel: "Batal",
//       fromLabel: "Dari",
//       toLabel: "Hingga",
//       customRangeLabel: "Custom",
//       weekLabel: "W",
//       daysOfWeek: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sa"],
//       monthNames: [
//         "Januari",
//         "Februari",
//         "Maret",
//         "April",
//         "Mei",
//         "Juni",
//         "Juli",
//         "Agustus ",
//         "September",
//         "Oktober",
//         "November",
//         "Desember",
//       ],
//       firstDay: 1,
//     },
//   },
// );
// })
//
// const filter_ckmb = () => {
//   const param = $('.tanggal_ckmb').val();
//   // const param_2 = $('.select2_ckmb').val();
//
// }
//
// $('.ckmb_pdf_cek').on('change', function () {
//   $('.ckmb_data').hide();
//   $('.ckmb_if_change').show()
// })
