var timer2 = "05:00";
var interval = setInterval(function () {
  var timer = timer2.split(":");
  //by parsing integer, I avoid all extra string processing
  var minutes = parseInt(timer[0], 10);
  var seconds = parseInt(timer[1], 10);
  --seconds;
  minutes = seconds < 0 ? --minutes : minutes;
  seconds = seconds < 0 ? 59 : seconds;
  seconds = seconds < 10 ? "0" + seconds : seconds;
  //minutes = (minutes < 10) ?  minutes : minutes;
  $(".hitungmundyur").html(minutes + ":" + seconds);
  if (minutes < 0) clearInterval(interval);
  //check if both minutes and seconds are 0
  if (seconds <= 0 && minutes <= 0) {
    clearInterval(interval);
    $("#kode_akses").val("");
    $("#btn_req").removeAttr("disabled");
  }
  timer2 = minutes + ":" + seconds;
}, 1000);

function AksesERPbyOTP() {
  //   alert("masok");
  var kode = $("#kode_akses").val();
  var key_akses = $("#key_akses").val();
  var user_name = $("#user_name").val();
  var password_u = $("#password_u").val();

  if (key_akses == null || key_akses == "") {
    Swal.fire({
      position: "top",
      type: "error",
      title: "Masukan Kode",
      showConfirmButton: true,
    });
  } else if (key_akses != kode) {
    if (kode == null || kode == "") {
      Swal.fire({
        position: "top",
        type: "error",
        title: "Kode Sudah Kadaluarsa Silahkan Request Ulang kode",
        showConfirmButton: true,
      });
    } else {
      Swal.fire({
        position: "top",
        type: "error",
        title: "Kode Salah",
        showConfirmButton: true,
      });
    }
  } else {
    // console.log(kode);
    var akses_masuk_atasan = "Y";
    var request = $.ajax({
      url: baseurl + "LoginAtasan",
      data: {
        username: user_name,
        password: password_u,
        akses_masuk_atasan: akses_masuk_atasan,
      },
      type: "POST",
      datatype: "html",
    });

    request.done(function (result) {
      window.location.href = baseurl;
    });
  }
}
