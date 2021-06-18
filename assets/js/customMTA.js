// Unactive karena dibuat pada tiap halaman index dan dipanggil di halaman index per menu sekalian
const toastMTA_ = (type, message) => {
  Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2500
  }).fire({
    customClass: 'swal-font-small',
    type: type,
    title: message
  })
}

// $(document).ready(function() {
  // $('.select-handling').select2({
  //     tags: true,
  //     allowClear:true,
  //     minimumInputLength: 0,
  //     placeholder: "Pilih Seksi",
  //     ajax: {
  //       url: baseurl + "MenjawabTemuanAudite/Handling/getSeksi",
  //       dataType: "JSON",
  //       type: "POST",
  //       cache: false,
  //       data: function(params) {
  //         return {
  //           term: params.term
  //         };
  //       },
  //       processResults: function(data) {
  //         return {
  //           results: $.map(data, function(obj) {
  //             return {
  //               id: obj.DESCRIPTION,
  //               text: obj.DESCRIPTION
  //             }
  //           })
  //         }
  //       }
  //     }
  // });

  // $('.tanggal-MTA').datepicker({
  //   autoclose: true,
  //   format: 'yyyy-mm-dd',
  //   todayHighlight: true,
  // });
// })

let index = 1;
$('.addAfter').click(function() {
    // $(this).parent().clone(true).appendTo($('#container-after-mta'));
    var count = $('#container-handling-mta').children().length;
    // console.log(count);
    c = count + parseInt(1);
    // console.log(c);
    $('.delAfter').show();
    // $('.delAfter'+index).show();
    index++;
    $('.delAfter'+(index-1)).show();
    $('.inp'+(index-1)).attr("readonly", true);
    $('#container-handling-mta').append(
      `<div class="form-group">
        <div class="col-lg-6">
          <input style="margin-left:0px;width:100%" type="file" class="form-control inp${index}" onchange="getGambar(this)" accept=".jpeg,.png,.jpg" name="foto_after[]" required>
        </div>
        <button type="button" id="delafter" class="btn btn-danger delAfter${index}" style="display:none"><i class="fa fa-times"></i></button>
        <div class="col-lg-12">
          <div class="imgWrap">
            <img src="" name="prev-handling" id='${index}' class="img-fluid" style="margin-top:7px;border-radius:10px">
          </div>
        </div>
      </div>`
    );
    $('.delAfter'+index).click(function() {
      var count2 = $('#container-handling-mta').children().length;
      // console.log(count2);
      c2 = count2 - parseInt(1);
      // console.log(c2);

      if (count2 > 1) {
        $(this).parent().remove();
      }
      if (c2 == 1) {
        // $('.delAfter'+index).hide();
        $('#delafter').hide();
        $('.delAfter').hide();
      }
    });
    // console.log(count);
    // $('.after-mta').replaceWith($('.after-mta').clone());
});

$('.delAfter').click(function() {
  var countb = $('#container-handling-mta').children().length;
  // console.log(countb);
  cb = countb - parseInt(1);
  // console.log(cb);

  if (countb > 1) {
    $(this).parent().remove();
  }
  if (cb == 1) {
    // $('.delAfter'+index).hide();
    $('#delafter').hide();
  }
});

function getGambarb(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#base-preview').attr('src', e.target.result).width('35%');
      $('#base-preview').addClass('img-thumbnail');
    };
    reader.readAsDataURL(input.files[0]);
  }
}

// function imagePreview() {
//   $('.after-mta').unbind('change').bind('change', function () {
//     var files = !!this.files ? this.files : [];
//     if (!files.length || !window.FileReader) return;
//     // if (/^image/.test(files[0].type)) {
//       var reader = new FileReader();
//       reader.readAsDataURL(files[0]);
//       reader.onload = function () {
//         $(this).next('.prev-handling').attr('src', this.result);
//       }
//     // }
//   });
// }

function getGambar(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#'+index).attr('src', e.target.result).width('35%');
      $('#'+index).addClass('img-thumbnail');
    };
    reader.readAsDataURL(input.files[0]);
  }
}

$('.select-handling').change(function(){
  if ($(this).val() != '') {
    $('#handlingMTA').removeAttr("disabled");
  }else {
    $('#handlingMTA').attr("disabled", true);
  }
})

// $('.sv-handling').click(function() {
//   var insert = "<?php $insert?>";
//   if (insert) {
//     toastMTA_('success', 'Success Insert Data to Database');
//   }else {
//     toastMTA_('error', 'Insert Data to Database Failed');
//   }
// })

let mta_handling, poin_penyimpangan = null;

const handling_mta = () =>{
  let area_handling = $('#area_handling').val();

  if (mta_handling != null) {
    mta_handling.abort();
    toastMTA_('warning', 'Data Request Canceled');
  }

  setTimeout(function () {
    mta_handling = $.ajax({
      url: baseurl + 'MenjawabTemuanAudite/Handling/getAjax',
      type: 'POST',
      data: {
        area_handling: area_handling,
      },
      cache: false,
      beforeSend: function () {
        $('.area_hand').html(`<div class="area_handling"></div>`);
        $('.area_handling').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                    <img style="width: 12%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
                                    <span style="font-size:13px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
                                </div>`);
      },
      success: function(result) {
        if (result != 0) {
          $('.area_hand').html(`<div class="area_handling"></div>`);
          $('.area_handling').html(result);
          $('#top').text(`Menampilkan Temuan Audite ${area_handling}`);
          toastMTA_('success', 'Success Load Data');
          mta_handling = null;
        }else if (result == 0) {
          $('.area_hand').html(`<div class="area_handling"></div>`);
          $('.area_handling').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                    <i class="fa fa-remove" style="color:#d60d00;font-size:45px;"></i><br>
                                    <h3 style="font-size:14px;font-weight:bold">Tidak ada data Temuan Audite ${area_handling}</h3>
                                </div>`);
          toastMTA_('error', 'Data is empty');
          mta_handling = null;
        }else {
          toastMTA_('Warning', 'Terdapat Kesalahan Saat Mengambil Data');
          mta_handling = null;
        }
      },
      eror: function (XMLHttpRequest, textStatus, errorThrown) {
        console.log();
        mta_handling = null;
      }
    })
  }, 50);
  // console.log(area_handling);
}

const poin_penyimpangan_handling = () =>{

  if (poin_penyimpangan != null) {
    poin_penyimpangan.abort();
  }

  setTimeout(function () {
    poin_penyimpangan = $.ajax({
      url: baseurl + 'MenjawabTemuanAudite/Handling/getPoinPenyimpangan',
      type: 'POST',
      data: {},
      cache: false,
      beforeSend: function () {
        $('.area_poin_penyimpangan').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                    <img style="width: 12%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
                                    <span style="font-size:13px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
                                </div>`);
      },
      success: function(result) {
        if (result != 0) {
          $('.area_poin_penyimpangan').html(result);
          poin_penyimpangan = null;
        }else if (result == 0) {
          $('.area_poin_penyimpangan').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                    <i class="fa fa-remove" style="color:#d60d00;font-size:45px;"></i><br>
                                    <h3 style="font-size:14px;font-weight:bold">Tidak ada data Poin Penyimpangan</h3>
                                </div>`);
          poin_penyimpangan = null;
        }else {
          poin_penyimpangan = null;
        }
      },
      eror: function (XMLHttpRequest, textStatus, errorThrown) {
        console.log();
        poin_penyimpangan = null;
      }
    })
  }, 50);
  // console.log(area_handling);
}

function updatePP() {
  var id = $('[name=id]').val();
  var poin = $('[name=editpp]').val();
  $.ajax({
    url: baseurl + 'MenjawabTemuanAudite/Handling/updatePP',
    type: 'POST',
    data: {
      id: id,
      poin_penyimpangan: poin,
    },
    cache: false,
    success: function () {
      toastMTA_('success', 'Data Berhasil Diupdate');
      $('#editpp').modal('hide');
      setTimeout(function () {
        poin_penyimpangan = $.ajax({
          url: baseurl + 'MenjawabTemuanAudite/Handling/getPoinPenyimpangan',
          type: 'POST',
          data: {},
          cache: false,
          beforeSend: function () {
            $('.area_poin_penyimpangan').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                        <img style="width: 12%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
                                        <span style="font-size:13px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
                                    </div>`);
          },
          success: function(result) {
            if (result != 0) {
              $('.area_poin_penyimpangan').html(result);
              poin_penyimpangan = null;
            }else if (result == 0) {
              $('.area_poin_penyimpangan').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                        <i class="fa fa-remove" style="color:#d60d00;font-size:45px;"></i><br>
                                        <h3 style="font-size:14px;font-weight:bold">Tidak ada data Poin Penyimpangan</h3>
                                    </div>`);
              poin_penyimpangan = null;
            }else {
              poin_penyimpangan = null;
            }
          },
          eror: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log();
            poin_penyimpangan = null;
          }
        })
      }, 400);
    },
  })
}

// $('.deletePP').on('click', function () {
//   var id = $(this).attr("data-id");
//   var confirmation = confirm("Are you sure to delete this data ?");
//
//   if (confirmation == true) {
//     $.ajax({
//       url: baseurl + 'MenjawabTemuanAudite/Handling/deletePoinPenyimpangan',
//       type: 'POST',
//       data: {
//         id: id,
//       },
//       cache: false,
//       success: function () {
//         toastMTA_('success', 'Data Berhasil Dihapus');
//         setTimeout(function () {
//           poin_penyimpangan = $.ajax({
//             url: baseurl + 'MenjawabTemuanAudite/Handling/getPoinPenyimpangan',
//             type: 'POST',
//             data: {},
//             cache: false,
//             beforeSend: function () {
//               $('.area_poin_penyimpangan').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
//                                           <img style="width: 12%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
//                                           <span style="font-size:13px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
//                                       </div>`);
//             },
//             success: function(result) {
//               if (result != 0) {
//                 $('.area_poin_penyimpangan').html(result);
//                 poin_penyimpangan = null;
//               }else if (result == 0) {
//                 $('.area_poin_penyimpangan').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
//                                           <i class="fa fa-remove" style="color:#d60d00;font-size:45px;"></i><br>
//                                           <h3 style="font-size:14px;font-weight:bold">Tidak ada data Poin Penyimpangan</h3>
//                                       </div>`);
//                 poin_penyimpangan = null;
//               }else {
//                 poin_penyimpangan = null;
//               }
//             },
//             eror: function (XMLHttpRequest, textStatus, errorThrown) {
//               console.log();
//               poin_penyimpangan = null;
//             }
//           })
//         }, 400)
//       },
//     })
//   }
// })

// let mta_5s, mta_handling, mta_ky = null;
//
// const handling_mta = () =>{
//   let area_handling = $('.select-handling').val();
//
//   if (mta_handling != null) {
//     mta_handling.abort();
//     toastMTA_('warning', 'Data Request Canceled');
//   }
//
//   mta_handling = $.ajax({
//     url: baseurl + 'MenjawabTemuanAudite/Handling/getAjax',
//     type: 'POST',
//     data: {
//       area_handling: area_handling,
//     },
//     cache: false,
//     beforeSend: function () {
//       $('.area_hand').html(`<div class="area_handling"></div>`);
//       $('.area_handling').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
//                                   <img style="width: 12%;" src="${baseurl}assets/img/gif/loading14.gif"><br>
//                                   <span style="font-size:13px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
//                               </div>`);
//     },
//     success: function(result) {
//       if (result != 0) {
//         $('.area_hand').html(`<div class="area_handling"></div>`);
//         $('.area_handling').html(result);
//         $('#atas').text(`Menampilkan Temuan Audite ${area_handling}`);
//         toastMTA_('success', 'Success Load Data');
//         mta_handling = null;
//       }else if (result == 0) {
//         $('.area_hand').html(`<div class="area_handling"></div>`);
//         $('.area_handling').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
//                                   <i class="fa fa-remove" style="color:#d60d00;font-size:45px;"></i><br>
//                                   <h3 style="font-size:14px;font-weight:bold">Tidak ada data Temuan Audite ${area_handling}</h3>
//                               </div>`);
//         $('#top').text(`Menampilkan Temuan Audite ${area_handling}`);
//         mta_handling = null;
//       }else {
//         toastMTA_('Warning', 'Terdapat Kesalahan Saat Mengambil Data');
//         mta_handling = null;
//       }
//     },
//     eror: function (XMLHttpRequest, textStatus, errorThrown) {
//       console.log();
//     }
//   })
// }
