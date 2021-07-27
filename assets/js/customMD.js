const toastDO2021 = (type, message) => {
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

const toastDO2021Loading = (pesan) => {
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

const swalDO2021Loading = (pesan) => {
  Swal.fire({
    allowOutsideClick:false,
    onBeforeOpen: () => {
       Swal.showLoading();
       $('.swal2-loading').children('button').css({'width': '40px', 'height': '40px'})
     },
    text: pesan
  })
}

const swalDO2021 = (type, title) => {
  Swal.fire({
    type: type,
    title: title,
    text: '',
    showConfirmButton: false,
    showCloseButton: true,
  })
}

var ajax1  = null;
var ajax2  = null;
var ajax3  = null;
var ajax4  = null;
var ajax5  = null;
var ajax6  = null;

$(document).ready(function() {
  var checkDO = $('#punyaeDO').val();
  if (checkDO == 'trueDO') {
    $.ajax({
      url: baseurl + 'MonitoringDO/SettingDO/GetSetting',
      type: 'POST',
      beforeSend: function() {
        $('#loadingArea0').show();
        $('div.table_area_DO_0').hide();
      },
      success: function(result) {
        // console.log(result);
        $('#loadingArea0').hide();
        $('div.table_area_DO_0').show();
        $('div.table_area_DO_0').html(result);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    }).then(function() {
      // $.ajax({
      //   url: baseurl + 'MonitoringDO/SettingDO/countDO',
      //   type: 'POST',
      //   dataType: 'json',
      //   success: function(result) {
      //     $('#jumlah0').html('(' + result[0] + ')');
      //     $('#jumlah1').html('(' + result[1] + ')');
      //     $('#jumlah2').html('(' + result[2] + ')');
      //     $('#jumlah3').html('(' + result[3] + ')');
      //     $('#jumlah4').html('(' + result[4] + ')');
      //
      //   },
      //   error: function(XMLHttpRequest, textStatus, errorThrown) {
      //     console.error();
      //   }
      // })
    })

    // setInterval(reloadAjaxMD, 20000);
    // function reloadAjaxMD() {
    //   $.ajax({
    //     url: baseurl+'MonitoringDO/SettingDO/countDO',
    //     type: 'POST',
    //     dataType:'json',
    //     success: function(result) {
    //       $('#jumlah0').html('('+result[0]+')');
    //       $('#jumlah1').html('('+result[1]+')');
    //       $('#jumlah2').html('('+result[2]+')');
    //       $('#jumlah3').html('('+result[3]+')');
    //       $('#jumlah4').html('(' + result[4] + ')');

    //     },
    //     error: function(XMLHttpRequest, textStatus, errorThrown) {
    //       console.error();
    //     }
    //   })
    // }
  }
})

$('#tblMonitoringDOCetak').DataTable();

$('.uppercaseDO').keyup(function() {
  this.value = this.value.toUpperCase();
});

// function updateFlag(rm, hi, rowID) {
//   var plat = $('tr[row-id="' + rowID + '"] input[name="inputAsiap"]').val();
//   if (plat == '') {
//     Swal.fire({
//       position: 'middle',
//       type: 'warning',
//       title: 'input plat nomer can not be null.',
//       showConfirmButton: false,
//       timer: 1500
//     })
//   }else if (plat != '') {
//     $.ajax({
//       url: baseurl + 'MonitoringDO/SettingDO/insertplatnumber',
//       type: 'POST',
//       data: {
//         plat_nomer: plat,
//         rm: rm,
//         hi: hi,
//       },
//       beforeSend: function () {
//         Swal.showLoading()
//       },
//       success: function(result) {
//         console.log(result);
//         if (result != '') {
//           Swal.fire({
//             position: 'middle',
//             type: 'success',
//             title: 'Success inserting data',
//             showConfirmButton: false,
//             timer: 1500
//           })
//           $('tr[row-id="' + rowID + '"] button[name="buttonAsiap"]').attr('disabled', true);
//           $('tr[row-id="' + rowID + '"] input[name="inputAsiap"]').attr('disabled', true);
//         }
//       },
//       error: function(XMLHttpRequest, textStatus, errorThrown) {
//         console.error();
//       }
//     })
//   }
//   console.log(plat);
// }

function approveMD() {
  var personid = $('#user_mdo').val();
  var id = $('#headerid_mdo').val();
  var rm = $('#rm_mdo').val();
  var rowID = $('#row_id').val();
  var order_number = $('#order_number').val();
  var plat_number = $('#plat_number').val();
  var atr_tampung_gan = $('#atr_tampung_gan').val();

  var pengecekan = $('#checkDODO').val();

  $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/cek_checklist',
    type: 'POST',
    dataType : 'JSON',
    data: {
      rn: rm,
      no_ind: personid,
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result123) {
      console.log(result123);
      if (result123) {
        Swal.fire({
          position: 'middle',
          type: 'error',
          title: `Checklist belum dicetak!!`,
          showConfirmButton: true,
        }).then(function() {
          $('#MyModal2').modal('hide');
          $.ajax({
              url: baseurl + 'MonitoringDO/SettingDO/GetSetting',
              type: 'POST',
              beforeSend: function() {
                $('#loadingArea0').show();
                $('div.table_area_DO_0').hide();
              },
              success: function(result) {
                // console.log(result);
                $('#loadingArea0').hide();
                $('div.table_area_DO_0').show();
                $('div.table_area_DO_0').html(result);
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.error();
               }
            })
        })
      } else {

        if (personid === '') {
          Swal.fire({
            position: 'middle',
            type: 'error',
            title: 'Kolom User/Assign Kosong!',
            showConfirmButton: false,
            timer: 2500
          }).then(function() {
            $('#MyModal2').modal('hide');
          })
        } else if (plat_number === '') {
          Swal.fire({
            position: 'middle',
            type: 'error',
            title: 'Plat Nomor Kosong!',
            text: 'Silahkan hubungi pembelian',
            showConfirmButton: false,
            timer: 2500
          }).then(function() {
            $('#MyModal2').modal('hide');
          })
        } else {
          if (pengecekan == 1) {
            $.ajax({
              url: baseurl + 'MonitoringDO/SettingDO/UpdateDO',
              type: 'POST',
              data: {
                header_id: id,
                requests_number: rm,
                person_id: personid,
                plat_number:plat_number
              },
              beforeSend: function() {
                Swal.showLoading()
              },
              success: function(result) {
                // window.alert(result);
                if (result == 1) {
                  // window.alert('test');
                  Swal.fire({
                    position: 'middle',
                    type: 'success',
                    title: 'Success updating data',
                    showConfirmButton: false,
                    timer: 1500
                  }).then(function() {
                    $('tr[row-id="' + rowID + '"] select[name="person_id"]').attr('disabled', true);
                    $('tr[row-id="' + rowID + '"] button[name="buttondetail"]').attr('disabled', true);
                    $('tr[row-id="' + rowID + '"]').removeAttr("style");
                    $('tr[row-id="' + rowID + '"]').css({"background":"rgba(150,150,150,0.2)"});

                    //redirect ulang
                    var checkDO = $('#punyaeDO').val();
                    if (checkDO == 'trueDO') {
                      $.ajax({
                        url: baseurl + 'MonitoringDO/SettingDO/GetSetting',
                        type: 'POST',
                        beforeSend: function() {
                          $('#loadingArea0').show();
                          $('div.table_area_DO_0').hide();
                        },
                        success: function(result) {
                          // console.log(result);
                          $('#loadingArea0').hide();
                          $('div.table_area_DO_0').show();
                          $('div.table_area_DO_0').html(result);
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                          console.error();
                        }
                      }).then(function() {
                      })
                    }
                  })
                } else {
                  // window.alert('test_fail');
                  Swal.fire({
                    position: 'middle',
                    type: 'danger',
                    title: 'Failed..!!!',
                    showConfirmButton: false,
                    timer: 1500
                  })
                }
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.error();
              }
            }).then(function() {
              $('#MyModal2').modal('hide')
              // $('tr[row-id="' + rowID + '"] input[name="person_id"]').attr('disabled', true);
              // $('tr[row-id="' + rowID + '"] button[id="cekButton"]').attr('disabled', true);
            })

          } else {
            Swal.mixin({
              input: 'password',
              confirmButtonText: 'Submit',
              showCancelButton: true,
              progressSteps: ['1']
            }).queue([{
              title: 'Autentikasi',
              text: 'Masukan Password'
            }]).then((result) => {
              // console.log(result.value[0]);
              if (result.value[0] === '1231313') {
                $.ajax({
                  url: baseurl + 'MonitoringDO/SettingDO/UpdateDO',
                  type: 'POST',
                  data: {
                    header_id: id,
                    requests_number: rm,
                    person_id: personid,
                    plat_number:plat_number
                  },
                  success: function(result) {
                    // console.log(result);
                    if (result == 1) {
                      Swal.fire({
                        position: 'middle',
                        type: 'success',
                        title: 'Success inserting data',
                        showConfirmButton: false,
                        timer: 1500
                      }).then(function() {
                        $('#MyModal2').modal('hide')
                      })
                    }else {
                      Swal.fire({
                        position: 'middle',
                        type: 'danger',
                        title: 'Failed..!!!',
                        showConfirmButton: false,
                        timer: 1200
                      })
                    }

                  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.error();
                  }
                }).then(function() {
                    $('tr[row-id="' + rowID + '"] button[name="buttondetail"]').attr('disabled', true);
                    $('tr[row-id="' + rowID + '"] select[name="person_id"]').attr('disabled', true);
                    $('tr[row-id="' + rowID + '"]').removeAttr("style");
                    $('tr[row-id="' + rowID + '"]').css({"background":"rgba(150,150,150,0.2)"});

                    //redirect ulang
                    var checkDO = $('#punyaeDO').val();
                    if (checkDO == 'trueDO') {
                      $.ajax({
                        url: baseurl + 'MonitoringDO/SettingDO/GetSetting',
                        type: 'POST',
                        beforeSend: function() {
                          $('#loadingArea0').show();
                          $('div.table_area_DO_0').hide();
                        },
                        success: function(result) {
                          // console.log(result);
                          $('#loadingArea0').hide();
                          $('div.table_area_DO_0').show();
                          $('div.table_area_DO_0').html(result);
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                          console.error();
                        }
                      }).then(function() {
                      })
                    }
                  // $.ajax({
                  //   url: baseurl + 'MonitoringDO/SettingDO/GetSetting',
                  //   type: 'POST',
                  //   beforeSend: function() {
                  //     $('#loadingArea0').show();
                  //     $('div.table_area_DO_0').hide();
                  //   },
                  //   success: function(result) {
                  //     // console.log(result);
                  //     $('#loadingArea0').hide();
                  //     $('div.table_area_DO_0').show();
                  //     $('div.table_area_DO_0').html(result);
                  //   },
                  //   error: function(XMLHttpRequest, textStatus, errorThrown) {
                  //     console.error();
                  //   }
                  // })
                  // $.ajax({
                  //   url: baseurl + 'MonitoringDO/SettingDO/countDO',
                  //   type: 'POST',
                  //   dataType: 'json',
                  //   success: function(result) {
                  //     $('#jumlah0').html('(' + result[0] + ')');
                  //     $('#jumlah1').html('(' + result[1] + ')');
                  //     $('#jumlah2').html('(' + result[2] + ')');
                  //     $('#jumlah3').html('(' + result[3] + ')');
                  //     $('#jumlah4').html('(' + result[4] + ')');
                  //
                  //   },
                  //   error: function(XMLHttpRequest, textStatus, errorThrown) {
                  //     console.error();
                  //   }
                  // })
                })
              } else {
                Swal.fire({
                  position: 'middle',
                  type: 'error',
                  title: 'Wrong password !!!',
                  showConfirmButton: false,
                  timer: 1500
                })
              }
            })

          }

        }
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })

}



// ------------------- SIAP ASSIGN -------------------

function dodo0() {
  if(ajax2 != null) ajax2.abort()
  if(ajax4 != null) ajax4.abort()
  if(ajax3 != null) ajax3.abort()
  if(ajax5 != null) ajax5.abort()
  if(ajax6 != null) ajax6.abort()
ajax1 = $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/GetSetting',
    type: 'POST',
    beforeSend: function() {
      $('#loadingArea0').show();
      $('div.table_area_DO_0').hide();
    },
    success: function(result) {
      // console.log(result);
      $('#loadingArea0').hide();
      $('div.table_area_DO_0').show();
      $('div.table_area_DO_0').html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
     }
  })
}

//punya dodo0
function detail(rm, id_header, rowID, order_number, plat_number) {
  var personid = $('tr[row-id="' + rowID + '"] select[name="person_id"]').val();

  var cekapakahitemtelahmelakukanassign =  $('tr[row-id="' + rowID + '"] input[id="cekSudahAssign"]').val();
  $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/GetDetail',
    type: 'POST',
    data: {
      requests_number: rm,
    },
    beforeSend: function() {
      $('#loadingArea').show();
      $('div#table-area').hide();
    },
    success: function(result) {
      $('#loadingArea').hide();
      $('div#table-area').show();
      $('div#table-area').html(result);

      $('#user_mdo').val(personid);
      $('#headerid_mdo').val(id_header);
      $('#rm_mdo').val(rm);
      $('#row_id').val(rowID);
      $('#order_number').val(order_number);
      $('#plat_number').val(plat_number);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}



// ------------------- SUDAH ASSIGN -------------------

function dodo1() {
  // dodo01.abort();
  if(ajax2 != null) ajax2.abort()
  if(ajax1 != null) ajax1.abort()
  if(ajax3 != null) ajax3.abort()
  if(ajax5 != null) ajax5.abort()
  if(ajax6 != null) ajax6.abort()
  ajax2 =  $.ajax({
      url: baseurl + 'MonitoringDO/SettingDO/GetAssign',
      type: 'POST',
      beforeSend: function() {
        $('#loadingArea1').show();
        $('div.table_area_DO_1').hide();
      },
      success: function(result) {
        // console.log(result);
        $('#loadingArea1').hide();
        $('div.table_area_DO_1').show();
        $('div.table_area_DO_1').html(result);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  // $.ajax({
  //   url: baseurl + 'MonitoringDO/SettingDO/countDO',
  //   type: 'POST',
  //   dataType: 'json',
  //   success: function(result) {
  //     $('#jumlah0').html('(' + result[0] + ')');
  //     $('#jumlah1').html('(' + result[1] + ')');
  //     $('#jumlah2').html('(' + result[2] + ')');
  //     $('#jumlah3').html('(' + result[3] + ')');
  //     $('#jumlah4').html('(' + result[4] + ')');
  //   },
  //   error: function(XMLHttpRequest, textStatus, errorThrown) {
  //     console.error();
  //   }
  // })
}

function detailAssign(rm, rowID) {
  $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/GetAssignDetail',
    type: 'POST',
    data: {
      requests_number: rm,
    },
    beforeSend: function() {
      $('#loadingArea_Assign').show();
      $('div#table-area_Assign').hide();
    },
    success: function(result) {
      // console.log(result);
      $('#loadingArea_Assign').hide();
      $('div#table-area_Assign').show();
      $('div#table-area_Assign').html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}



// ------------------- SUDAH ALLOCATE -------------------

function dodo2() {
  if(ajax2 != null) ajax2.abort()
  if(ajax1 != null) ajax1.abort()
  if(ajax4 != null) ajax4.abort()
  if(ajax5 != null) ajax5.abort()
  if(ajax6 != null) ajax6.abort()
ajax3 =  $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/GetAllocate',
    type: 'POST',
    beforeSend: function() {
      $('#loadingArea2').show();
      $('div.table_area_DO_2').hide();
    },
    success: function(result) {
      // console.log(result);
      $('#loadingArea2').hide();
      $('div.table_area_DO_2').show();
      $('div.table_area_DO_2').html(result);

      // $('#user_mdo').val(personid);
      // $('#headerid_mdo').val(id_header);
      // $('#rm_mdo').val(rm);
      // $('#row_id').val(rowID);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
  // $.ajax({
  //   url: baseurl + 'MonitoringDO/SettingDO/countDO',
  //   type: 'POST',
  //   dataType: 'json',
  //   success: function(result) {
  //     $('#jumlah0').html('(' + result[0] + ')');
  //     $('#jumlah1').html('(' + result[1] + ')');
  //     $('#jumlah2').html('(' + result[2] + ')');
  //     $('#jumlah3').html('(' + result[3] + ')');
  //     $('#jumlah4').html('(' + result[4] + ')');
  //   },
  //   error: function(XMLHttpRequest, textStatus, errorThrown) {
  //     console.error();
  //   }
  // })
}

function detailAllocate(rm, rowID) {
  $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/GetAllocateDetail',
    type: 'POST',
    data: {
      requests_number: rm,
    },
    beforeSend: function() {
      $('#loadingArea_Terlayani').show();
      $('div#table-area_Terlayani').hide();
    },
    success: function(result) {
      // console.log(result);
      $('#loadingArea_Terlayani').hide();
      $('div#table-area_Terlayani').show();
      $('div#table-area_Terlayani').html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}



// ------------------- SUDAH TRANSACT -------------------

function dodo3() {
  if(ajax2 != null) ajax2.abort()
  if(ajax1 != null) ajax1.abort()
  if(ajax3 != null) ajax3.abort()
  if(ajax5 != null) ajax5.abort()
  if(ajax6 != null) ajax6.abort()
  ajax4 = $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/GetTransact',
    type: 'POST',
    beforeSend: function() {
      $('#loadingArea3').show();
      $('div.table_area_DO_3').hide();
    },
    success: function(result) {
      // console.log(result);
      $('#loadingArea3').hide();
      $('div.table_area_DO_3').show();
      $('div.table_area_DO_3').html(result);

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
  // $.ajax({
  //   url: baseurl + 'MonitoringDO/SettingDO/countDO',
  //   type: 'POST',
  //   dataType: 'json',
  //   success: function(result) {
  //     $('#jumlah0').html('(' + result[0] + ')');
  //     $('#jumlah1').html('(' + result[1] + ')');
  //     $('#jumlah2').html('(' + result[2] + ')');
  //     $('#jumlah3').html('(' + result[3] + ')');
  //     $('#jumlah4').html('(' + result[4] + ')');
  //   },
  //   error: function(XMLHttpRequest, textStatus, errorThrown) {
  //     console.error();
  //   }
  // })
}


function detailTransact(rm, rowID) {
  $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/GetTransactDetail',
    type: 'POST',
    data: {
      requests_number: rm,
    },
    beforeSend: function() {
      $('#loadingArea_Muat').show();
      $('div#table-area_Muat').hide();
    },
    success: function(result) {
      // console.log(result);
      $('#loadingArea_Muat').hide();
      $('div#table-area_Muat').show();
      $('div#table-area_Muat').html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}


function GetSudahCetakDetail(rm, rowID) {
  $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/GetSudahCetakDetail',
    type: 'POST',
    data: {
      requests_number: rm,
    },
    beforeSend: function() {
      $('#loadingArea_Muat').show();
      $('div#table-area_Muat').hide();
    },
    success: function(result) {
      // console.log(result);
      $('#loadingArea_Muat').hide();
      $('div#table-area_Muat').show();
      $('div#table-area_Muat').html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

// $(document).ready(function() {
    // startintervalcetak(2100000002);
// })

let do_cekcetak;
function startintervalcetak(rn) {
 // do_cekcetak = setInterval(function() {
   ceksudahcetak(rn);
 // }, 2000);
}

function ceksudahcetak(rn) {
  // $.ajax({
  //   url: baseurl + 'MonitoringDO/SettingDO/cek_sudah_cetak',
  //   type: 'POST',
  //   dataType:'JSON',
  //   data: {
  //     rn:rn,
  //   },
  //   beforeSend: function() {
  //   },
  //   success: function(result) {
  //     console.log(result.STATUS, 'ini statusnya');
  //     if (result.STATUS == 'C') {
  //        clearInterval(do_cekcetak);
  //        swalDO2021('success', 'Selesai.');
         dodo3();
  //     }
  //   },
  //   error: function(XMLHttpRequest, textStatus, errorThrown) {
  //     console.error();
  //   }
  // })
}

function runapi_interorg(tipe, request_number, org_id, subinv) {
  $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/cek_interog_blm',
    type: 'POST',
    dataType:'JSON',
    data: {
      rn:request_number,
    },
    beforeSend: function() {
      swalDO2021Loading('Mengecek Prosedur INTERORG SPB..')
    },
    success: function(result0) {
      if (result0 == '') {
        $.ajax({
          url: baseurl + 'MonitoringDO/SettingDO/runapi_interorg',
          type: 'POST',
          dataType:'JSON',
          data: {
            tipe: tipe,
            request_number: request_number,
            org_id: org_id,
            subinv: subinv
          },
          beforeSend: function() {
            swalDO2021Loading('Menjalankan Prosedur INTERORG SPB..')
          },
          success: function(result) {
            if (result == 200) {
              // swalDO2021('success', 'Berhasil menjalankan prosedur');
              // swalDO2021Loading('Sedang Mencetak Dokumen')
              $('#MyModalSPBKIT').modal('hide');
              startintervalcetak(request_number);
              window.open(baseurl+'MonitoringDO/PDF/'+request_number);
            }else {
              swalDO2021('warning', 'tipe dan request_number kosong');
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.error();
            swalDO2021('error', 'Terjadi kesalahan saat menjalankan prosedur INTERORG_SPB');
          }
        })
      }else {
        // swalDO2021Loading('Sedang Mencetak Dokumen')
        startintervalcetak(request_number);
        window.open(baseurl+'MonitoringDO/PDF/'+request_number);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
      swalDO2021('error', 'Terjadi kesalahan saat mengecek prosedur INTERORG_SPB');
    }
  })
}

$('.cetak_spbkit').on('submit', function() {
  event.preventDefault();
  let tipe = $('#tipe_spbkit').text();
  let request_number = $('#nospbkit').text();
  let org_id = $('#org_id_spbkit').val();
  let subinv = $('.select2subinv_spbkit').val();
  runapi_interorg(tipe, request_number, org_id, subinv);
})

function cetakDO(rn, tipe, header_id) {
  $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/cekDObukan',
    type: 'POST',
    dataType: 'JSON',
    data:{
      rn : rn,
    },
    beforeSend: function() {
      swalDO2021Loading('Mengecek Alamat..')
    },
    success: function(result) {
      if (result) {
        Swal.close()
        // dodo3();

        //tambahan kondisi 2021
        if (tipe == 'DO') {
          // swalDO2021Loading('Sedang Mencetak Dokumen')
          startintervalcetak(rn);
          window.open(baseurl+'MonitoringDO/PDF/'+rn)
        }else {
          $.ajax({
            url: baseurl + 'MonitoringDO/SettingDO/closeline',
            type: 'POST',
            dataType:'JSON',
            data: {
              header_id: header_id,
            },
            beforeSend: function() {
              swalDO2021Loading('Close Line..')
            },
            success: function(result_1) {
              // if (result_1) {
                if (tipe == 'SPB KIT') {

                  $.ajax({
                    url: baseurl + 'MonitoringDO/SettingDO/cek_interog_blm',
                    type: 'POST',
                    dataType:'JSON',
                    data: {
                      rn:rn,
                    },
                    beforeSend: function() {
                      swalDO2021Loading('Mengecek Prosedur INTERORG SPB..')
                    },
                    success: function(result0) {
                      if (result0 == '') {

                        $('#tipe_spbkit').text(tipe)
                        $('#nospbkit').text(rn)
                        $('#MyModalSPBKIT').modal({
                            backdrop: 'static'
                        });
                        $('.select2subinv_spbkit').val('').trigger('change');
                        //ambil org code
                        $.ajax({
                          url: baseurl + 'MonitoringDO/SettingDO/org_spbkit',
                          type: 'POST',
                          dataType:'JSON',
                          data: {
                            rn: rn,
                          },
                          beforeSend: function() {
                            toastDO2021Loading('Mencoba Mendapatkan ORGANIZATION ID..');
                          },
                          success: function(result_2) {
                            if (result_2 != '') {
                              toastDO2021('success', `ORGANIZATION ID Ditemukan ${result_2[0].ORGANIZATION_CODE} - ${result_2[0].ORGANIZATION_ID}`)
                              $('#org_code_spbkit').val(result_2[0].ORGANIZATION_CODE)
                              $('#org_id_spbkit').val(result_2[0].ORGANIZATION_ID)
                              //isi subinv
                              $('.select2subinv_spbkit').select2({
                                placeholder: "Pilih Sub.Inventory",
                                ajax: {
                                  url: baseurl + "MonitoringDO/SettingDO/subinv_spbkit",
                                  dataType: "JSON",
                                  type: "POST",
                                  cache: false,
                                  data: function(params) {
                                    return {
                                      term: params.term,
                                      org: result_2[0].ORGANIZATION_ID
                                    };
                                  },
                                  processResults: function(data) {
                                    return {
                                      results: $.map(data, function(obj) {
                                        return {
                                          id: obj.SUBINV,
                                          text: obj.SUBINV
                                        }
                                      })
                                    }
                                  }
                                }
                              });
                            }else {
                              toastDO2021('warning', `ORGANIZATION ID tidak Ditemukan, hubungi ICT`);
                            }
                          },
                          error: function(XMLHttpRequest, textStatus, errorThrown) {
                            console.error();
                          }
                        })

                      }else {
                        // swalDO2021Loading('Sedang Mencetak Dokumen')
                        startintervalcetak(rn);
                        window.open(baseurl+'MonitoringDO/PDF/'+rn);
                      }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                      console.error();
                      swalDO2021('error', 'Terjadi kesalahan saat mengecek prosedur INTERORG_SPB');
                    }
                  })


                }else if (tipe == 'SPB') {
                  runapi_interorg(tipe, rn, null, null);
                }else {
                  swalDO2021('warning', `Tipe dokumen ${tipe} tidak masuk dikondisi`);
                }
              // }else {
                // swalDO2021('warning', 'Gagal Close Line '+header_id);
              // }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.error();
            }
          })
        }

      }else {
        Swal.fire({
          position: 'middle',
          type: 'warning',
          title: 'Alamat belum lengkap!',
          text: 'Silahkan hubungi Marketing!'
        })
      }

      // dodo3();

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}



// ------------------- SUDAH CETAK -------------------

function dodo4() {
  if(ajax2 != null) ajax2.abort()
  if(ajax1 != null) ajax1.abort()
  if(ajax3 != null) ajax3.abort()
  if(ajax4 != null) ajax4.abort()
  if(ajax6 != null) ajax6.abort()
ajax5 = $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/GetSudahCetak',
    type: 'POST',
    beforeSend: function() {
      $('#loadingArea4').show();
      $('div.table_area_DO_4').hide();
    },
    success: function(result) {
      // console.log(result);
      $('#loadingArea4').hide();
      $('div.table_area_DO_4').show();
      $('div.table_area_DO_4').html(result);

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
  // $.ajax({
  //     url: baseurl + 'MonitoringDO/SettingDO/countDO',
  //     type: 'POST',
  //     dataType: 'json',
  //     success: function(result) {
  //       $('#jumlah0').html('(' + result[0] + ')');
  //       $('#jumlah1').html('(' + result[1] + ')');
  //       $('#jumlah2').html('(' + result[2] + ')');
  //       $('#jumlah3').html('(' + result[3] + ')');
  //       $('#jumlah4').html('(' + result[4] + ')');
  //     },
  //     error: function(XMLHttpRequest, textStatus, errorThrown) {
  //       console.error();
  //     }
  //   })
}



// ------------------- SIAP INTERORG -------------------

function dodo5() {
  if(ajax2 != null) ajax2.abort()
  if(ajax1 != null) ajax1.abort()
  if(ajax3 != null) ajax3.abort()
  if(ajax4 != null) ajax4.abort()
  if(ajax5 != null) ajax5.abort()
ajax6 = $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/GetSiapInterorg',
    type: 'POST',
    beforeSend: function() {
      $('#loadingArea5').show();
      $('div.table_area_DO_5').hide();
    },
    success: function(result) {
      // console.log(result);
      $('#loadingArea5').hide();
      $('div.table_area_DO_5').show();
      $('div.table_area_DO_5').html(result);

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
  // $.ajax({
  //     url: baseurl + 'MonitoringDO/SettingDO/countDO',
  //     type: 'POST',
  //     dataType: 'json',
  //     success: function(result) {
  //       $('#jumlah0').html('(' + result[0] + ')');
  //       $('#jumlah1').html('(' + result[1] + ')');
  //       $('#jumlah2').html('(' + result[2] + ')');
  //       $('#jumlah3').html('(' + result[3] + ')');
  //       $('#jumlah4').html('(' + result[4] + ')');
  //     },
  //     error: function(XMLHttpRequest, textStatus, errorThrown) {
  //       console.error();
  //     }
  //   })
}


function insertManual() {
  var rm = $('#nomorDO').val();
  var user = $('#person_id').val();

  $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/GetDetailCheck',
    type: 'POST',
    dataType: 'json',
    data: {
      requests_number: rm,
    },
    success: function(result_detail) {
      var cekcekaja

      for (var r in result_detail) {
        if (Number(result_detail[r].QUANTITY) < Number(result_detail[r].AV_TO_RES)) {
          cekcekaja = 'boleh'
        } else {
          cekcekaja = 'ora_oleh';
          break;
        }
      }
      // console.log(cekcekaja);
      if (cekcekaja === 'boleh') {
        $.ajax({
          url: baseurl + 'MonitoringDO/SettingDO/InsertManualDo',
          type: 'POST',
          data: {
            requests_number: rm,
            person_id: user,
          },
          success: function(result) {
            // console.log(result);

            if (result != '') {
              Swal.fire({
                position: 'middle',
                type: 'success',
                title: 'Success inserting data',
                showConfirmButton: false,
                timer: 1500
              })
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.error();
          }
        }).then(function() {
          $('#nomorDO').val('');
          $('#person_id').val('');
        })
      } else {
        Swal.fire({
          position: 'middle',
          type: 'error',
          title: 'Can\'t inserting Data',
          showConfirmButton: false,
          timer: 3000
        })
      }


    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })

}
