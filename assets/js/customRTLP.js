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
let pause_detail =  $('.detailHistory_rtlp').DataTable();

function format_rtlp(d, no_job, line) {
  return `<div style="width:55%;float:right;font-weight:bold;padding-bottom:5px;font-size:13px;">${no_job} (Line ${line})</div>
          <div style="width:55%;float:right"class="detail_${line}_${no_job}"></div>`;
}

const detail_pause = (no_job, line, no) => {
  let tr = $(`tr[row-pause="${no}"]`);
  let row = pause_detail.row(tr);
  if (row.child.isShown()) {
    row.child.hide();
    tr.removeClass('shown');
  } else {
    row.child(format_rtlp(row.data(), no_job, line)).show();
    tr.addClass('shown');
    $.ajax({
      url: baseurl + 'RunningTimeLinePnP/setting/detail_pause',
      type: 'POST',
      async: true,
      dataType: 'JSON',
      data: {
        no_job : no_job,
        line : line
      },
      beforeSend: function() {
        $(`.detail_${line}_` + no_job).html(`<div id="loadingArea0">
                                              <center><img style="width: 3%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                             </div>`)
      },
      success: function(result) {
        let item = '';
        let push = [];

        function pad(d) {
            return (d < 10) ? '0' + d.toString() : d.toString();
        }

        result.forEach((v, i) => {
          let st  = ['00', '00', '00'];
          let stp = ['00', '00', '00'];

          if (v.Pause_Start !== null && v.Pause_Done !== null) {
            st  = v.Pause_Start.split(':');
            stp = v.Pause_Done.split(':');
          }

          item = `<tr>
                      <td><center>${Number(i)+1}</center></td>
                      <td><center>${v.Pause_Start}</center></td>
                      <td><center>${v.Pause_Done}</center></td>
                      <td><center>${pad(Number(stp[0]) - Number(st[0]))}:${pad(Number(stp[1]) - Number(st[1]))}:${pad(Number(stp[2]) - Number(st[2]))}</center></td>
                    </tr>`;
          push.push(item);
        })
        let join = push.join(' ');
        let html = `<table class="table table-striped table-bordered table-hover text-left" style="font-size:12px;float:right">
              <thead>
                <tr class="bg-success">
                  <th><center>No</center></th>
                  <th><center>Pause Start</center></th>
                  <th><center>Pause Done</center></th>
                  <th><center>Time Range</center></th>
                </tr>
              </thead>
              <tbody>
              ${join}
              </tbody>
            </table>`
        $(`.detail_${line}_` + no_job).html(html)
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }
}

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


// // get total seconds between the times
// var delta = Math.abs(date_future - date_now) / 1000;
//
// // calculate (and subtract) whole days
// var days = Math.floor(delta / 86400);
// delta -= days * 86400;
//
// // calculate (and subtract) whole hours
// var hours = Math.floor(delta / 3600) % 24;
// delta -= hours * 3600;
//
// // calculate (and subtract) whole minutes
// var minutes = Math.floor(delta / 60) % 60;
// delta -= minutes * 60;
//
// // what's left is seconds
// var seconds = delta % 60;  // in theory the modulus is not required

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

  start1[i] = (code, line, no_job, no) => {
    $('#cekline').val(line);
    let cek1_1 = $(`#val_to_cek1${i}`).val();

    jumlahEl1.forEach((w, j) => {
      $('#btnstart1' + j).attr("disabled", "disabled");
    })

    // if ($('#btnstart'+i).val() === 'Start') {
    intervalId1[i] = setInterval(startTimer1[i], 1000);
    $('#btnstart1' + i).removeAttr("disabled");
    $('#btnlanjut1' + i).removeAttr("disabled");
    $('#btnrestart1' + i).removeAttr("disabled");
    $('#btnfinish1' + i).removeAttr("disabled");
    const waktu_mulai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
    // console.log(waktu_mulai)
    if (cek1_1 === 'first_load') {
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/SetStart',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: waktu_mulai,
          line: 1,
          code: code,
          no_job: no_job
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
            swalRTLPToastrAlert('info', `Job Lane ${line} Diperbarui Dengan No Job ${no_job}.`)
            $(`#val_to_cek1${i}`).val('second_load');
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }else {
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/updateTimePause',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: waktu_mulai,
          line: 1,
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'error',
              text: 'Gagal Melakukan Insert Data (!)',
              showConfirmButton: false,
              timer: 1700
            })
          } else {
            swalRTLPToastrAlert('info', `No Job ${no_job} Line ${line} dilanjutkan kembali.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }

  }

  selesai1[i] = (code, line, no_job) => {
    if (intervalId1[i]) {
      clearInterval(intervalId1[i]);

      const waktu_selesai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;

      // console.log(waktu_selesai);
      // waktu yang digunakan
      const jm = document.getElementById(`hours1-${i}`).innerHTML;
      const mnt = document.getElementById(`minutes1-${i}`).innerHTML;
      const sec = document.getElementById(`seconds1-${i}`).innerHTML;
      const time_se_di_dapet = `${jm}:${mnt}:${sec}`;

      jumlahEl1.forEach((w, j) => {
        let cek_detik = $(`#seconds1-${j}`).html();
        let cek_menit = $(`#minutes1-${j}`).html();
        let cek_jam = $(`#hours1-${j}`).html();

        if (cek_detik == '00' && cek_menit == '00' && cek_jam == '00') {
          $('#btnstart1' + j).removeAttr("disabled");
          console.log('remove');
        }else {
          $('#btnstart1' + j).attr("disabled", "disabled");
          console.log('add');
        }
      })

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
          no_job: no_job,
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
            swalRTLPToastrAlert('error', `No Job ${no_job} Line ${line} Berhasil Dihentikan.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

  pause1[i] = (no_job, kode_item, no_param) => {
    if (intervalId1[i]) {
      clearInterval(intervalId1[i]);
      let start_pause = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
      // console.log(`${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`);
      // action
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/insertTimePause',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: start_pause,
          line: 1,
          code: kode_item,
          no_job: no_job,
          no: no_param
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'Danger',
              title: 'Gagal Melakukan Insert Data pada table Time_Pause_Record (!)',
              showConfirmButton: false,
              timer: 1700
            })
          }else {
            swalRTLPToastrAlert('warning', `Data Job Lane 1 dengan No Job ${no_job} Dijeda.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

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

  start2[i] = (code, line, no_job) => {
    $('#cekline').val(line);
    let cek2_2 = $(`#val_to_cek2${i}`).val();

    jumlahEl2.forEach((w, j) => {
      $('#btnstart2' + j).attr("disabled", "disabled");
    })
    // if ($('#btnstart'+i).val() === 'Start') {
    intervalId2[i] = setInterval(startTimer2[i], 1000);
    $('#btnstart2' + i).removeAttr("disabled");
    $('#btnlanjut2' + i).removeAttr("disabled");
    $('#btnrestart2' + i).removeAttr("disabled");
    $('#btnfinish2' + i).removeAttr("disabled");
    const waktu_mulai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
    if (cek2_2 == 'first_load') {
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/SetStart',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: waktu_mulai,
          line: 2,
          no_job: no_job,
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
            swalRTLPToastrAlert('info', `Job Lane ${line} Diperbarui Dengan No Job ${no_job}.`)
            $(`#val_to_cek2${i}`).val('second_load');
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }else {
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/updateTimePause',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: waktu_mulai,
          line: 2,
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'error',
              text: 'Gagal Melakukan Insert Data (!)',
              showConfirmButton: false,
              timer: 1700
            })
          } else {
            swalRTLPToastrAlert('info', `No Job ${no_job} Line ${line} dilanjutkan kembali.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

  selesai2[i] = (code, line, no_job) => {
    if (intervalId2[i]) {
      clearInterval(intervalId2[i]);

      const waktu_selesai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
      // waktu yang digunakan
      const jm = document.getElementById(`hours2-${i}`).innerHTML;
      const mnt = document.getElementById(`minutes2-${i}`).innerHTML;
      const sec = document.getElementById(`seconds2-${i}`).innerHTML;
      const time_se_di_dapet = `${jm}:${mnt}:${sec}`;

      jumlahEl2.forEach((w, j) => {
        let cek_detik = $(`#seconds2-${j}`).html();
        let cek_menit = $(`#minutes2-${j}`).html();
        let cek_jam = $(`#hours2-${j}`).html();

        if (cek_detik == '00' && cek_menit == '00' && cek_jam == '00') {
          $('#btnstart2' + j).removeAttr("disabled");
        }else {
          $('#btnstart2' + j).attr("disabled", "disabled");
        }
      })

      $('#btnstart2' + i).attr("disabled", "disabled"); // sesuai kondisi client antum
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
          no_job: no_job,
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
            swalRTLPToastrAlert('error', `No Job ${no_job} Line ${line} Berhasil Dihentikan.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

  pause2[i] = (no_job, kode_item, no_param) => {
    if (intervalId2[i]) {
      clearInterval(intervalId2[i]);
      let start_pause = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
      // console.log(`${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`);
      // action
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/insertTimePause',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: start_pause,
          line: 2,
          code: kode_item,
          no_job: no_job,
          no: no_param
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'Danger',
              title: 'Gagal Melakukan Insert Data pada table Time_Pause_Record (!)',
              showConfirmButton: false,
              timer: 1700
            })
          }else {
            swalRTLPToastrAlert('warning', `Data Job Lane 2 dengan No Job ${no_job} Dijeda.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
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

  start3[i] = (code, line, no_job) => {
    $('#cekline').val(line);

    let cek1_1 = $(`#val_to_cek3${i}`).val();

    jumlahEl3.forEach((w, j) => {
      $('#btnstart3' + j).attr("disabled", "disabled");
    })
    // if ($('#btnstart'+i).val() === 'Start') {
    intervalId3[i] = setInterval(startTimer3[i], 1000);
    $('#btnstart3' + i).removeAttr("disabled");
    $('#btnlanjut3' + i).removeAttr("disabled");
    $('#btnrestart3' + i).removeAttr("disabled");
    $('#btnfinish3' + i).removeAttr("disabled");
    const waktu_mulai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
    if (cek1_1 == 'first_load') {
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/SetStart',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: waktu_mulai,
          line: 3,
          no_job: no_job,
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
            swalRTLPToastrAlert('info', `Job Lane ${line} Diperbarui Dengan No Job ${no_job}.`)
            $(`#val_to_cek3${i}`).val('second_load');
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }else {
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/updateTimePause',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: waktu_mulai,
          line: 3,
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'error',
              text: 'Gagal Melakukan Insert Data (!)',
              showConfirmButton: false,
              timer: 1700
            })
          } else {
            swalRTLPToastrAlert('info', `No Job ${no_job} Line ${line} dilanjutkan kembali.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }

  }

  selesai3[i] = (code, line, no_job) => {
    if (intervalId3[i]) {
      clearInterval(intervalId3[i]);

      const waktu_selesai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
      // waktu yang digunakan
      const jm = document.getElementById(`hours3-${i}`).innerHTML;
      const mnt = document.getElementById(`minutes3-${i}`).innerHTML;
      const sec = document.getElementById(`seconds3-${i}`).innerHTML;
      const time_se_di_dapet = `${jm}:${mnt}:${sec}`;

      jumlahEl3.forEach((w, j) => {
        let cek_detik = $(`#seconds3-${j}`).html();
        let cek_menit = $(`#minutes3-${j}`).html();
        let cek_jam = $(`#hours3-${j}`).html();

        if (cek_detik == '00' && cek_menit == '00' && cek_jam == '00') {
          $('#btnstart3' + j).removeAttr("disabled");
        }else {
          $('#btnstart3' + j).attr("disabled", "disabled");
        }
      })

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
          no_job: no_job,
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
            swalRTLPToastrAlert('error', `No Job ${no_job} Line ${line} Berhasil Dihentikan.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

  pause3[i] = (no_job, kode_item, no_param) => {
    if (intervalId3[i]) {
      clearInterval(intervalId3[i]);
      let start_pause = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
      // console.log(`${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`);
      // action
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/insertTimePause',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: start_pause,
          line: 3,
          code: kode_item,
          no_job: no_job,
          no: no_param
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'Danger',
              title: 'Gagal Melakukan Insert Data pada table Time_Pause_Record (!)',
              showConfirmButton: false,
              timer: 1700
            })
          }else {
            swalRTLPToastrAlert('warning', `Data Job Lane 3 dengan No Job ${no_job} Dijeda.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
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

  start4[i] = (code, line, no_job) => {
    $('#cekline').val(line);
    // if ($('#btnstart'+i).val() === 'Start') {
    let cek1_1 = $(`#val_to_cek4${i}`).val();

    jumlahEl4.forEach((w, j) => {
      $('#btnstart4' + j).attr("disabled", "disabled");
    })

    intervalId4[i] = setInterval(startTimer4[i], 1000);
    $('#btnstart4' + i).removeAttr("disabled");
    $('#btnlanjut4' + i).removeAttr("disabled");
    $('#btnrestart4' + i).removeAttr("disabled");
    $('#btnfinish4' + i).removeAttr("disabled");
    const waktu_mulai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
    if (cek1_1 == 'first_load') {
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/SetStart',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: waktu_mulai,
          line: 4,
          no_job: no_job,
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
            swalRTLPToastrAlert('info', `Job Lane ${line} Diperbarui Dengan No Job ${no_job}.`)
            $(`#val_to_cek4${i}`).val('second_load');
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }else {
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/updateTimePause',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: waktu_mulai,
          line: line,
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'error',
              text: 'Gagal Melakukan Insert Data (!)',
              showConfirmButton: false,
              timer: 1700
            })
          } else {
            swalRTLPToastrAlert('info', `No Job ${no_job} Line ${line} dilanjutkan kembali.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

  selesai4[i] = (code, line, no_job) => {
    if (intervalId4[i]) {
      clearInterval(intervalId4[i]);

      const waktu_selesai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
      // waktu yang digunakan
      const jm = document.getElementById(`hours4-${i}`).innerHTML;
      const mnt = document.getElementById(`minutes4-${i}`).innerHTML;
      const sec = document.getElementById(`seconds4-${i}`).innerHTML;
      const time_se_di_dapet = `${jm}:${mnt}:${sec}`;

      jumlahEl4.forEach((w, j) => {
        let cek_detik = $(`#seconds4-${j}`).html();
        let cek_menit = $(`#minutes4-${j}`).html();
        let cek_jam = $(`#hours4-${j}`).html();

        if (cek_detik == '00' && cek_menit == '00' && cek_jam == '00') {
          $('#btnstart4' + j).removeAttr("disabled");
        }else {
          $('#btnstart4' + j).attr("disabled", "disabled");
        }
      })

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
          no_job: no_job,
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
            swalRTLPToastrAlert('error', `No Job ${no_job} Line ${line} Berhasil Dihentikan.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

  pause4[i] = (no_job, kode_item, no_param) => {
    if (intervalId4[i]) {
      clearInterval(intervalId4[i]);
      let start_pause = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
      // console.log(`${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`);
      // action
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/insertTimePause',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: start_pause,
          line: 4,
          code: kode_item,
          no_job: no_job,
          no: no_param
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'Danger',
              title: 'Gagal Melakukan Insert Data pada table Time_Pause_Record (!)',
              showConfirmButton: false,
              timer: 1700
            })
          }else {
            swalRTLPToastrAlert('warning', `Data Job Lane 4 dengan No Job ${no_job} Dijeda.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
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

  start5[i] = (code, line, no_job) => {
    $('.img-area-wipp').html(``);
    $('#cekline').val(line);

    let cek1_1 = $(`#val_to_cek5${i}`).val();
    jumlahEl5.forEach((w, j) => {
      $('#btnstart5' + j).attr("disabled", "disabled");
    })
    // if ($('#btnstart'+i).val() === 'Start') {
    intervalId5[i] = setInterval(startTimer5[i], 1000);
    $('#btnstart5' + i).removeAttr("disabled");
    $('#btnlanjut5' + i).removeAttr("disabled");
    $('#btnrestart5' + i).removeAttr("disabled");
    $('#btnfinish5' + i).removeAttr("disabled");
    const waktu_mulai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
    if (cek1_1 == 'first_load') {
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/SetStart',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: waktu_mulai,
          line: 5,
          no_job: no_job,
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
            swalRTLPToastrAlert('info', `Job Lane ${line} Diperbarui Dengan No Job ${no_job}.`)
            $(`#val_to_cek5${i}`).val('second_load');
            $('.img-area-wipp').html(`<div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                                        <div class="row">
                                          <div class="col-md-12">
                                            <label for="">Code Item : ${code}</label>
                                            <br>
                                            <center><img src="${baseurl}/assets/upload/wipp/setelah/${code}.png" style="max-width:100%;max-height:400px" class="img-fluid" alt="Responsive image"></center>
                                          </div>
                                        </div>
                                      </div>`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }else {
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/updateTimePause',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: waktu_mulai,
          line: 5,
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'error',
              text: 'Gagal Melakukan Insert Data (!)',
              showConfirmButton: false,
              timer: 1700
            })
          } else {
            swalRTLPToastrAlert('info', `No Job ${no_job} Line ${line} dilanjutkan kembali.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

  selesai5[i] = (code, line, no_job) => {
    if (intervalId5[i]) {
      clearInterval(intervalId5[i]);

      const waktu_selesai = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
      // waktu yang digunakan
      const jm = document.getElementById(`hours5-${i}`).innerHTML;
      const mnt = document.getElementById(`minutes5-${i}`).innerHTML;
      const sec = document.getElementById(`seconds5-${i}`).innerHTML;
      const time_se_di_dapet = `${jm}:${mnt}:${sec}`;

      jumlahEl5.forEach((w, j) => {
        let cek_detik = $(`#seconds5-${j}`).html();
        let cek_menit = $(`#minutes5-${j}`).html();
        let cek_jam = $(`#hours5-${j}`).html();

        if (cek_detik == '00' && cek_menit == '00' && cek_jam == '00') {
          $('#btnstart5' + j).removeAttr("disabled");
        }else {
          $('#btnstart5' + j).attr("disabled", "disabled");
        }
      })

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
          no_job: no_job,
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
            swalRTLPToastrAlert('error', `No Job ${no_job} Line ${line} Berhasil Dihentikan.`)
            $('.img-area-wipp').html(``)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

  pause5[i] = (no_job, kode_item, no_param) => {
    if (intervalId5[i]) {
      clearInterval(intervalId5[i]);
      let start_pause = `${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`;
      // console.log(`${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`);
      $.ajax({
        url: baseurl + 'RunningTimeLinePnP/setting/insertTimePause',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          waktu_mulai: start_pause,
          line: 5,
          code: kode_item,
          no_job: no_job,
          no: no_param
        },
        success: function(result) {
          if (!result) {
            Swal.fire({
              position: 'center',
              type: 'Danger',
              title: 'Gagal Melakukan Insert Data pada table Time_Pause_Record (!)',
              showConfirmButton: false,
              timer: 1700
            })
          }else {
            swalRTLPToastrAlert('warning', `Data Job Lane 5 dengan No Job ${no_job} Dijeda.`)
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
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
