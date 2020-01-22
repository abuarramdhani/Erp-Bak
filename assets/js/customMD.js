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
    }).then(function () {
      $.ajax({
        url: baseurl + 'MonitoringDO/SettingDO/countDO',
        type: 'POST',
        dataType: 'json',
        success: function(result) {
          $('#jumlah0').html('(' + result[0] + ')');
          $('#jumlah1').html('(' + result[1] + ')');
          $('#jumlah2').html('(' + result[2] + ')');
          $('#jumlah3').html('(' + result[3] + ')');
          $('#jumlah4').html('(' + result[4] + ')');

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
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

function approveMD() {
  var personid = $('#user_mdo').val();
  var id = $('#headerid_mdo').val();
  var rm = $('#rm_mdo').val();
  var rowID = $('#row_id').val();
  var order_number = $('#order_number').val();
  var atr_tampung_gan = $('#atr_tampung_gan').val();

  var pengecekan = $('tr[row-id="' + rowID + '"] input[name="cekdodo"]').val()

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
  } else {

    if (pengecekan === 'true') {
      $.ajax({
        url: baseurl + 'MonitoringDO/SettingDO/InsertDo',
        type: 'POST',
        data: {
          header_id: id,
          requests_number: rm,
          person_id: personid
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
            }).then(function() {
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
                $.ajax({
                  url: baseurl + 'MonitoringDO/SettingDO/countDO',
                  type: 'POST',
                  dataType: 'json',
                  success: function(result) {
                    $('#jumlah0').html('(' + result[0] + ')');
                    $('#jumlah1').html('(' + result[1] + ')');
                    $('#jumlah2').html('(' + result[2] + ')');
                    $('#jumlah3').html('(' + result[3] + ')');
                    $('#jumlah4').html('(' + result[4] + ')');

                  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.error();
                  }
                })
              })
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
        console.log(result.value[0]);
        if (result.value[0] === '1231313') {
          $.ajax({
            url: baseurl + 'MonitoringDO/SettingDO/InsertDo',
            type: 'POST',
            data: {
              header_id: id,
              requests_number: rm,
              person_id: personid
            },
            success: function(result) {
              console.log(result);

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.error();
            }
          }).then(function() {
            $.ajax({
              url: baseurl + 'MonitoringDO/SettingDO/insertDOtampung',
              type: 'POST',
              data: {
                header_id: id,
                requests_number: rm,
                order_number: order_number,
                array_atr: atr_tampung_gan.split(',')
              },
              success: function(result) {
                console.log(result);
                if (result != '') {
                  Swal.fire({
                    position: 'middle',
                    type: 'success',
                    title: 'Success inserting data',
                    showConfirmButton: false,
                    timer: 1500
                  })
                  $('#MyModal2').modal('hide');
                }
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.error();
              }
            })
          }).then(function() {
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
            $.ajax({
              url: baseurl + 'MonitoringDO/SettingDO/countDO',
              type: 'POST',
              dataType: 'json',
              success: function(result) {
                $('#jumlah0').html('(' + result[0] + ')');
                $('#jumlah1').html('(' + result[1] + ')');
                $('#jumlah2').html('(' + result[2] + ')');
                $('#jumlah3').html('(' + result[3] + ')');
                $('#jumlah4').html('(' + result[4] + ')');

              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.error();
              }
            })
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

function dodo1() {
  // dodo01.abort();
  $.ajax({
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
  $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/countDO',
    type: 'POST',
    dataType: 'json',
    success: function(result) {
      $('#jumlah0').html('(' + result[0] + ')');
      $('#jumlah1').html('(' + result[1] + ')');
      $('#jumlah2').html('(' + result[2] + ')');
      $('#jumlah3').html('(' + result[3] + ')');
      $('#jumlah4').html('(' + result[4] + ')');
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
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


function dodo2() {
  $.ajax({
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
  $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/countDO',
    type: 'POST',
    dataType: 'json',
    success: function(result) {
      $('#jumlah0').html('(' + result[0] + ')');
      $('#jumlah1').html('(' + result[1] + ')');
      $('#jumlah2').html('(' + result[2] + ')');
      $('#jumlah3').html('(' + result[3] + ')');
      $('#jumlah4').html('(' + result[4] + ')');
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
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

function dodo3() {
  $.ajax({
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
  $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/countDO',
    type: 'POST',
    dataType: 'json',
    success: function(result) {
      $('#jumlah0').html('(' + result[0] + ')');
      $('#jumlah1').html('(' + result[1] + ')');
      $('#jumlah2').html('(' + result[2] + ')');
      $('#jumlah3').html('(' + result[3] + ')');
      $('#jumlah4').html('(' + result[4] + ')');
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
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

function dodo4() {
  // dodo0().ajaxStop(function())
  $.ajax({
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
  $.ajax({
      url: baseurl + 'MonitoringDO/SettingDO/countDO',
      type: 'POST',
      dataType: 'json',
      success: function(result) {
        $('#jumlah0').html('(' + result[0] + ')');
        $('#jumlah1').html('(' + result[1] + ')');
        $('#jumlah2').html('(' + result[2] + ')');
        $('#jumlah3').html('(' + result[3] + ')');
        $('#jumlah4').html('(' + result[4] + ')');
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
}


function dodo0() {
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
  $.ajax({
    url: baseurl + 'MonitoringDO/SettingDO/countDO',
    type: 'POST',
    dataType: 'json',
    success: function(result) {
      $('#jumlah0').html('(' + result[0] + ')');
      $('#jumlah1').html('(' + result[1] + ')');
      $('#jumlah2').html('(' + result[2] + ')');
      $('#jumlah3').html('(' + result[3] + ')');
      $('#jumlah4').html('(' + result[4] + ')');
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

//punya dodo0
function detail(rm, id_header, rowID, order_number) {
  var personid = $('tr[row-id="' + rowID + '"] input[name="person_id"]').val();

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
      // console.log(result);
      $('#loadingArea').hide();
      $('div#table-area').show();
      $('div#table-area').html(result);

      $('#user_mdo').val(personid);
      $('#headerid_mdo').val(id_header);
      $('#rm_mdo').val(rm);
      $('#row_id').val(rowID);
      $('#order_number').val(order_number);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
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
      console.log(cekcekaja);
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
