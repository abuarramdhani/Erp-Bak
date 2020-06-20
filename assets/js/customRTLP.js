// ========================do something below the alert  =================

// ------------------------- GET TIME REV ALD ------------------------------//
const swalRTLPToastrAlert = (type, message) => {
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
const swalRKH = (type, title) => {
  Swal.fire({
    type: type,
    title: title,
    text: ''
  })
}

// $(document).ready(function() {
//   $('.tblwiip10').DataTable();
// 300000/4 = 75000; 30000; 2800
// })
let rtlp1 =  $('.tblwiip10').DataTable();

function format_wipp( d, kode_item ){
  return `<div class="detail_area${kode_item}"> </div>`;
}

const detail_rtlp = (id, no) => {
  let tr = $(`tr[data-rtlp=${id}_${no}]`);
  let row = rtlp1.row(tr);
  if ( row.child.isShown() ) {
      row.child.hide();
      tr.removeClass('shown');
  }
  else {
      row.child( format_wipp(row.data(), id)).show();
      tr.addClass('shown');
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/detail',
        type: 'POST',
        async: true,
        data: {
          kode_item: id,
        },
        beforeSend: function() {
          $('.detail_area'+id).html(`<div id="loadingArea0">
                                          <center><img style="width: 3%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                        </div>`)
        },
        success: function(result) {
          $('.detail_area'+id).html(result)
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
  }
}

const setDate = () => {
  swalRKH('info', 'Fitur ini baru didiskusikan.')
}

let start1 = [];
let pause1 = [];
let reset1 = [];
let selesai1 = [];

let start2 = [];
let pause2 = [];
let reset2 = [];
let selesai2 = [];

let start3 = [];
let pause3 = [];
let reset3 = [];
let selesai3 = [];

let start4 = [];
let pause4 = [];
let reset4 = [];
let selesai4 = [];

let start5 = [];
let pause5 = [];
let reset5 = [];
let selesai5 = [];

let startTimer1 = [];
let hours1 = [];
let minutes1 = [];
let seconds1 = [];

let startTimer2 = [];
let hours2 = [];
let minutes2 = [];
let seconds2 = [];

let startTimer3 = [];
let hours3 = [];
let minutes3 = [];
let seconds3 = [];

let startTimer4 = [];
let hours4 = [];
let minutes4 = [];
let seconds4 = [];

let startTimer5 = [];
let hours5 = [];
let minutes5 = [];
let seconds5 = [];

let totalSeconds_i1 = [];
let intervalId1 = [];

let totalSeconds_i2 = [];
let intervalId2 = [];

let totalSeconds_i3 = [];
let intervalId3 = [];

let totalSeconds_i4 = [];
let intervalId4 = [];

let totalSeconds_i5 = [];
let intervalId5 = [];

let detikk1 = [];
let menitt1 = [];
let jamm1 = [];

let detikk2 = [];
let menitt2 = [];
let jamm2 = [];

let detikk3 = [];
let menitt3 = [];
let jamm3 = [];

let detikk4 = [];
let menitt4 = [];
let jamm4 = [];

let detikk5 = [];
let menitt5 = [];
let jamm5 = [];


// const dataLength = $('#length').data('length');
const jumlahEl1 = $('.length1').find('.timer1').toArray();
const jumlahEl2 = $('.length2').find('.timer2').toArray();
const jumlahEl3 = $('.length3').find('.timer3').toArray();
const jumlahEl4 = $('.length4').find('.timer4').toArray();
const jumlahEl5 = $('.length5').find('.timer5').toArray();

jumlahEl1.forEach((v, i) => {
  hours1[i] = 0;
  minutes1[i] = 0;
  seconds1[i] = 0;
  totalSeconds_i1[i] = 0;

  intervalId1[i] = null;

  startTimer1[i] = () => {
    let line = $('#cekline').val();

    ++totalSeconds_i1[i];
    hours1[i] = Math.floor(totalSeconds_i1[i] / 3600);
    minutes1[i] = Math.floor((totalSeconds_i1[i] - hours1[i] * 3600) / 60);
    seconds1[i] = totalSeconds_i1[i] - (hours1[i] * 3600 + minutes1[i] * 60);

    function pad(val) {
      let valString = val + "";
      if (valString.length < 2) {
        return "0" + valString;
      } else {
        return valString;
      }
    }

    document.getElementById(`hours1-${i}`).innerHTML = pad(hours1[i]);
    document.getElementById(`minutes1-${i}`).innerHTML = pad(minutes1[i]);
    document.getElementById(`seconds1-${i}`).innerHTML = pad(seconds1[i]);
  }

  start1[i] = (code, line) => {
    $('#cekline').val(line);
    // if ($('#btnstart'+i).val() === 'Start') {
    intervalId1[i] = setInterval(startTimer1[i], 1000);
    $('#btnlanjut1' + i).removeAttr("disabled");
    $('#btnrestart1' + i).removeAttr("disabled");
    $('#btnfinish1' + i).removeAttr("disabled");
    const waktu_mulai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
    console.log(waktu_mulai);
    $.ajax({
      url: baseurl + 'RunningTimeLinePnP/setting/SetStart',
      type: 'POST',
      dataType: 'JSON',
      async: true,
      data: {
        waktu_mulai: waktu_mulai,
        line: 1,
        code: code
      },
      success: function(result) {
        if (!result) {
          Swal.fire({
            position: 'center',
            type: 'Danger',
            title: 'Gagal Melakukan Insert Data (!)',
            showConfirmButton: false,
            timer: 1700
          })
        } else {
          swalRTLPToastrAlert('info', `Job Lane ${line} Diperbarui Dengan Item ${code}.`)
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }

  selesai1[i] = (code, line) => {
    if (intervalId1[i]) {
      clearInterval(intervalId1[i]);

      const waktu_selesai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;

      console.log(waktu_selesai);
      // waktu yang digunakan
      const jm = document.getElementById(`hours1-${i}`).innerHTML;
      const mnt = document.getElementById(`minutes1-${i}`).innerHTML;
      const sec = document.getElementById(`seconds1-${i}`).innerHTML;
      const time_se_di_dapet = `${jm}:${mnt}:${sec}`;

      $('#btnstart1' + i).attr("disabled", "disabled"); // sesuai kondisi pasien antum
      $('#btnlanjut1' + i).attr("disabled", "disabled");
      $('#btnrestart1' + i).attr("disabled", "disabled");
      $('#btnfinish1' + i).attr("disabled", "disabled");

      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/SetFinish',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_selesai: waktu_selesai,
          line: 1,
          code: code,
          lama_waktu: time_se_di_dapet
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'error',
              title: 'Gagal Memperbarui Data, Hubungi (!)',
              showConfirmButton: false,
              timer: 1700
            })
          } else {
            swalRTLPToastrAlert('error', `Data Job Lane ${line} Item ${code} Berhasil Dihentikan.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

  pause1[i] = _ => {
    if (intervalId1[i]) {
      clearInterval(intervalId1[i]);
      console.log(`${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`);
      // action
    }
  };

  reset1[i] = _ => {
    totalSeconds_i1[i] = 0;
    document.getElementById(`hours1-${i}`).innerHTML = '00';
    document.getElementById(`minutes1-${i}`).innerHTML = '00';
    document.getElementById(`seconds1-${i}`).innerHTML = '00';
  };

})

jumlahEl2.forEach((v, i) => {
  hours2[i] = 0;
  minutes2[i] = 0;
  seconds2[i] = 0;
  totalSeconds_i2[i] = 0;

  intervalId2[i] = null;

  startTimer2[i] = () => {
    let line = $('#cekline').val();

    ++totalSeconds_i2[i];
    hours2[i] = Math.floor(totalSeconds_i2[i] / 3600);
    minutes2[i] = Math.floor((totalSeconds_i2[i] - hours2[i] * 3600) / 60);
    seconds2[i] = totalSeconds_i2[i] - (hours2[i] * 3600 + minutes2[i] * 60);

    function pad(val) {
      let valString = val + "";
      if (valString.length < 2) {
        return "0" + valString;
      } else {
        return valString;
      }
    }

    document.getElementById(`hours2-${i}`).innerHTML = pad(hours2[i]);
    document.getElementById(`minutes2-${i}`).innerHTML = pad(minutes2[i]);
    document.getElementById(`seconds2-${i}`).innerHTML = pad(seconds2[i]);
  }

  start2[i] = (code, line) => {
    $('#cekline').val(line);
    // if ($('#btnstart'+i).val() === 'Start') {
    intervalId2[i] = setInterval(startTimer2[i], 1000);
    $('#btnlanjut2' + i).removeAttr("disabled");
    $('#btnrestart2' + i).removeAttr("disabled");
    $('#btnfinish2' + i).removeAttr("disabled");
    const waktu_mulai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
    $.ajax({
      url: baseurl + 'RunningTimeLinePnP/setting/SetStart',
      type: 'POST',
      dataType: 'JSON',
      async: true,
      data: {
        waktu_mulai: waktu_mulai,
        line: 2,
        code: code
      },
      success: function(result) {
        if (!result) {
          Swal.fire({
            position: 'center',
            type: 'Danger',
            title: 'Gagal Melakukan Insert Data (!)',
            showConfirmButton: false,
            timer: 1700
          })
        } else {
          swalRTLPToastrAlert('info', `Job Lane ${line} Diperbarui Dengan Item ${code}.`)
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }

  selesai2[i] = (code, line) => {
    if (intervalId2[i]) {
      clearInterval(intervalId2[i]);

      const waktu_selesai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
      // waktu yang digunakan
      const jm = document.getElementById(`hours2-${i}`).innerHTML;
      const mnt = document.getElementById(`minutes2-${i}`).innerHTML;
      const sec = document.getElementById(`seconds2-${i}`).innerHTML;
      const time_se_di_dapet = `${jm}:${mnt}:${sec}`;

      $('#btnstart2' + i).attr("disabled", "disabled"); // sesuai kondisi pasien antum
      $('#btnlanjut2' + i).attr("disabled", "disabled");
      $('#btnrestart2' + i).attr("disabled", "disabled");
      $('#btnfinish2' + i).attr("disabled", "disabled");


      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/SetFinish',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_selesai: waktu_selesai,
          line: 2,
          code: code,
          lama_waktu: time_se_di_dapet
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'danger',
              title: 'Gagal Memperbarui Data, Hubungi (!)',
              showConfirmButton: false,
              timer: 1700
            })
          } else {
            swalRTLPToastrAlert('error', `Data Job Lane ${line} Item ${code} Berhasil Dihentikan.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

  pause2[i] = _ => {
    if (intervalId2[i]) {
      clearInterval(intervalId2[i]);
      console.log(`${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`);
      // action
    }
  };

  reset2[i] = _ => {
    totalSeconds_i2[i] = 0;
    document.getElementById(`hours2-${i}`).innerHTML = '00';
    document.getElementById(`minutes2-${i}`).innerHTML = '00';
    document.getElementById(`seconds2-${i}`).innerHTML = '00';
  };

})

jumlahEl3.forEach((v, i) => {
  hours3[i] = 0;
  minutes3[i] = 0;
  seconds3[i] = 0;
  totalSeconds_i3[i] = 0;

  intervalId3[i] = null;

  startTimer3[i] = () => {
    let line = $('#cekline').val();

    ++totalSeconds_i3[i];
    hours3[i] = Math.floor(totalSeconds_i3[i] / 3600);
    minutes3[i] = Math.floor((totalSeconds_i3[i] - hours3[i] * 3600) / 60);
    seconds3[i] = totalSeconds_i3[i] - (hours3[i] * 3600 + minutes3[i] * 60);

    function pad(val) {
      let valString = val + "";
      if (valString.length < 2) {
        return "0" + valString;
      } else {
        return valString;
      }
    }

    document.getElementById(`hours3-${i}`).innerHTML = pad(hours3[i]);
    document.getElementById(`minutes3-${i}`).innerHTML = pad(minutes3[i]);
    document.getElementById(`seconds3-${i}`).innerHTML = pad(seconds3[i]);
  }

  start3[i] = (code, line) => {
    $('#cekline').val(line);
    // if ($('#btnstart'+i).val() === 'Start') {
    intervalId3[i] = setInterval(startTimer3[i], 1000);
    $('#btnlanjut3' + i).removeAttr("disabled");
    $('#btnrestart3' + i).removeAttr("disabled");
    $('#btnfinish3' + i).removeAttr("disabled");
    const waktu_mulai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
    $.ajax({
      url: baseurl + 'RunningTimeLinePnP/setting/SetStart',
      type: 'POST',
      dataType: 'JSON',
      async: true,
      data: {
        waktu_mulai: waktu_mulai,
        line: 3,
        code: code
      },
      success: function(result) {
        if (!result) {
          Swal.fire({
            position: 'center',
            type: 'Danger',
            title: 'Gagal Melakukan Insert Data (!)',
            showConfirmButton: false,
            timer: 1700
          })
        } else {
          swalRTLPToastrAlert('info', `Job Lane ${line} Diperbarui Dengan Item ${code}.`)
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }

  selesai3[i] = (code, line) => {
    if (intervalId3[i]) {
      clearInterval(intervalId3[i]);

      const waktu_selesai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
      // waktu yang digunakan
      const jm = document.getElementById(`hours3-${i}`).innerHTML;
      const mnt = document.getElementById(`minutes3-${i}`).innerHTML;
      const sec = document.getElementById(`seconds3-${i}`).innerHTML;
      const time_se_di_dapet = `${jm}:${mnt}:${sec}`;

      $('#btnstart3' + i).attr("disabled", "disabled"); // sesuai kondisi pasien antum
      $('#btnlanjut3' + i).attr("disabled", "disabled");
      $('#btnrestart3' + i).attr("disabled", "disabled");
      $('#btnfinish3' + i).attr("disabled", "disabled");

      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/SetFinish',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_selesai: waktu_selesai,
          line: 3,
          code: code,
          lama_waktu: time_se_di_dapet
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'danger',
              title: 'Gagal Memperbarui Data, Hubungi (!)',
              showConfirmButton: false,
              timer: 1700
            })
          } else {
            swalRTLPToastrAlert('error', `Data Job Lane ${line} Item ${code} Berhasil Dihentikan.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

  pause3[i] = _ => {
    if (intervalId3[i]) {
      clearInterval(intervalId3[i]);
      console.log(`${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`);
      // action
    }
  };

  reset3[i] = _ => {
    totalSeconds_i3[i] = 0;
    document.getElementById(`hours3-${i}`).innerHTML = '00';
    document.getElementById(`minutes3-${i}`).innerHTML = '00';
    document.getElementById(`seconds3-${i}`).innerHTML = '00';
  };

})


jumlahEl4.forEach((v, i) => {
  hours4[i] = 0;
  minutes4[i] = 0;
  seconds4[i] = 0;
  totalSeconds_i4[i] = 0;

  intervalId4[i] = null;

  startTimer4[i] = () => {
    let line = $('#cekline').val();

    ++totalSeconds_i4[i];
    hours4[i] = Math.floor(totalSeconds_i4[i] / 3600);
    minutes4[i] = Math.floor((totalSeconds_i4[i] - hours4[i] * 3600) / 60);
    seconds4[i] = totalSeconds_i4[i] - (hours4[i] * 3600 + minutes4[i] * 60);

    function pad(val) {
      let valString = val + "";
      if (valString.length < 2) {
        return "0" + valString;
      } else {
        return valString;
      }
    }
    document.getElementById(`hours4-${i}`).innerHTML = pad(hours4[i]);
    document.getElementById(`minutes4-${i}`).innerHTML = pad(minutes4[i]);
    document.getElementById(`seconds4-${i}`).innerHTML = pad(seconds4[i]);
  }

  start4[i] = (code, line) => {
    $('#cekline').val(line);
    // if ($('#btnstart'+i).val() === 'Start') {
    intervalId4[i] = setInterval(startTimer4[i], 1000);
    $('#btnlanjut4' + i).removeAttr("disabled");
    $('#btnrestart4' + i).removeAttr("disabled");
    $('#btnfinish4' + i).removeAttr("disabled");
    const waktu_mulai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
    $.ajax({
      url: baseurl + 'RunningTimeLinePnP/setting/SetStart',
      type: 'POST',
      dataType: 'JSON',
      async: true,
      data: {
        waktu_mulai: waktu_mulai,
        line: 4,
        code: code
      },
      success: function(result) {
        if (!result) {
          Swal.fire({
            position: 'center',
            type: 'Danger',
            title: 'Gagal Melakukan Insert Data (!)',
            showConfirmButton: false,
            timer: 1700
          })
        } else {
          swalRTLPToastrAlert('info', `Job Lane ${line} Diperbarui Dengan Item ${code}.`)
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }

  selesai4[i] = (code, line) => {
    if (intervalId4[i]) {
      clearInterval(intervalId4[i]);

      const waktu_selesai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
      // waktu yang digunakan
      const jm = document.getElementById(`hours4-${i}`).innerHTML;
      const mnt = document.getElementById(`minutes4-${i}`).innerHTML;
      const sec = document.getElementById(`seconds4-${i}`).innerHTML;
      const time_se_di_dapet = `${jm}:${mnt}:${sec}`;

      $('#btnstart4' + i).attr("disabled", "disabled"); // sesuai kondisi pasien antum
      $('#btnlanjut4' + i).attr("disabled", "disabled");
      $('#btnrestart4' + i).attr("disabled", "disabled");
      $('#btnfinish4' + i).attr("disabled", "disabled");

      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/SetFinish',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_selesai: waktu_selesai,
          line: 4,
          code: code,
          lama_waktu: time_se_di_dapet
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'danger',
              title: 'Gagal Memperbarui Data, Hubungi (!)',
              showConfirmButton: false,
              timer: 1700
            })
          } else {
            swalRTLPToastrAlert('error', `Data Job Lane ${line} Item ${code} Berhasil Dihentikan.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

  pause4[i] = _ => {
    if (intervalId4[i]) {
      clearInterval(intervalId4[i]);
      console.log(`${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`);
      // action
    }
  };

  reset4[i] = _ => {
    totalSeconds_i4[i] = 0;
    document.getElementById(`hours4-${i}`).innerHTML = '00';
    document.getElementById(`minutes4-${i}`).innerHTML = '00';
    document.getElementById(`seconds4-${i}`).innerHTML = '00';
  };

})

jumlahEl5.forEach((v, i) => {
  hours5[i] = 0;
  minutes5[i] = 0;
  seconds5[i] = 0;
  totalSeconds_i5[i] = 0;

  intervalId5[i] = null;

  startTimer5[i] = () => {
    let line = '5';

    ++totalSeconds_i5[i];
    hours5[i] = Math.floor(totalSeconds_i5[i] / 3600);
    minutes5[i] = Math.floor((totalSeconds_i5[i] - hours5[i] * 3600) / 60);
    seconds5[i] = totalSeconds_i5[i] - (hours5[i] * 3600 + minutes5[i] * 60);

    function pad(val) {
      let valString = val + "";
      if (valString.length < 2) {
        return "0" + valString;
      } else {
        return valString;
      }
    }
    document.getElementById(`hours5-${i}`).innerHTML = pad(hours5[i]);
    document.getElementById(`minutes5-${i}`).innerHTML = pad(minutes5[i]);
    document.getElementById(`seconds5-${i}`).innerHTML = pad(seconds5[i]);
  }

  start5[i] = (code, line) => {
    $('.img-area-wipp').html(``);
    $('#cekline').val(line);
    // if ($('#btnstart'+i).val() === 'Start') {
    intervalId5[i] = setInterval(startTimer5[i], 1000);
    $('#btnlanjut5' + i).removeAttr("disabled");
    $('#btnrestart5' + i).removeAttr("disabled");
    $('#btnfinish5' + i).removeAttr("disabled");
    const waktu_mulai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
    $.ajax({
      url: baseurl + 'RunningTimeLinePnP/setting/SetStart',
      type: 'POST',
      dataType: 'JSON',
      async: true,
      data: {
        waktu_mulai: waktu_mulai,
        line: 5,
        code: code
      },
      success: function(result) {
        if (!result) {
          Swal.fire({
            position: 'center',
            type: 'Danger',
            title: 'Gagal Melakukan Insert Data (!)',
            showConfirmButton: false,
            timer: 1700
          })
        } else {
          swalRTLPToastrAlert('info', `Job Lane ${line} Diperbarui Dengan Item ${code}.`)
          $('.img-area-wipp').html(`<div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <label for="">Code Item : ${code}</label>
                                          <br>
                                          <center><img src="${baseurl}/assets/upload/wipp/${code}.png" style="max-width:100%;max-height:400px" class="img-fluid" alt="Responsive image"></center>
                                        </div>
                                      </div>
                                    </div>`)
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }

  selesai5[i] = (code, line) => {
    if (intervalId5[i]) {
      clearInterval(intervalId5[i]);

      const waktu_selesai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
      // waktu yang digunakan
      const jm = document.getElementById(`hours5-${i}`).innerHTML;
      const mnt = document.getElementById(`minutes5-${i}`).innerHTML;
      const sec = document.getElementById(`seconds5-${i}`).innerHTML;
      const time_se_di_dapet = `${jm}:${mnt}:${sec}`;

      $('#btnstart5' + i).attr("disabled", "disabled"); // sesuai kondisi pasien antum
      $('#btnlanjut5' + i).attr("disabled", "disabled");
      $('#btnrestart5' + i).attr("disabled", "disabled");
      $('#btnfinish5' + i).attr("disabled", "disabled");

      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/SetFinish',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_selesai: waktu_selesai,
          line: 5,
          code: code,
          lama_waktu: time_se_di_dapet
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'danger',
              title: 'Gagal Memperbarui Data, Hubungi (!)',
              showConfirmButton: false,
              timer: 1700
            })
          } else {
            swalRTLPToastrAlert('error', `Data Job Lane ${line} Item ${code} Berhasil Dihentikan.`)
            $('.img-area-wipp').html(``)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

  pause5[i] = _ => {
    if (intervalId5[i]) {
      clearInterval(intervalId5[i]);
      console.log(`${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`);
      // action
    }
  };

  reset5[i] = _ => {
    totalSeconds_i5[i] = 0;
    document.getElementById(`hours5-${i}`).innerHTML = '00';
    document.getElementById(`minutes5-${i}`).innerHTML = '00';
    document.getElementById(`seconds5-${i}`).innerHTML = '00';
  };
})

// ------------------------- END GET TIME REV ALD ------------------------------//
