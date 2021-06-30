$(document).ready(function () {
  var view = document.getElementById("view_simulasihh");
  if (view) {
    $("#SelctKendaraAn").select2({
      allowClear: true,
    });
    $(document).on("focus", "input[type=number]", function (e) {
      $(this).on("wheel.disableScroll", function (e) {
        e.preventDefault();
      });
    });
    $(document).on("blur", "input[type=number]", function (e) {
      $(this).off("wheel.disableScroll");
    });
  }
});

function ChangePrecent(a, i, k) {
  // console.log(a, i, k);
  var lastdata = a + "-" + i + "-" + k; // ini untuk mengubah lastchange
  var value = $("#precentinput" + a + i + k).val(); // ini inputan angkanya
  var lastvalue = $(".lastvalue" + a + i + k).val(); // get inputan angkanya terakhir
  var percent = $("#precent" + a + i + k).val(); // ini presentase per produknya
  var presentasehidden = parseInt($(".presentasehidden" + k).val()); // ini presentase yg kesimpen
  var cekpresentasekeberapa = parseInt($(".cekpresentasekeberapa" + k).val()); // ini presentase yg keberapa
  var lastchange = $(".lastchange" + k).val(); // ini id id yg terakhir diinput

  if (lastdata == lastchange) {
    if (value == null || value == "") {
      // kalau value kosong
      value = 0;
      if (cekpresentasekeberapa == 1) {
        // cek presentase ke berapa dulu
        var hitung = 0;
      } else {
        var hitung = (presentasehidden - lastvalue * percent * 100).toFixed();
      }
    } else {
      // kalau tidak kosong
      var hitung = (presentasehidden + value * percent * 100).toFixed();
    }
    var precentage = hitung;
    $(".presentase" + k).html(precentage + "%");
    $(".presentasehidden" + k).val(precentage);
    $(".lastvalue" + a + i + k).val(value); // save value yg terakhir di input
  } else {
    if (value == null || value == "") {
      // kalau value kosong
      value = 0;
      if (cekpresentasekeberapa == 1) {
        // cek presentase ke berapa dulu
        var hitung = 0;
      } else {
        var hitung = (presentasehidden - lastvalue * percent * 100).toFixed();
      }
    } else {
      // kalau enggak kosong
      var hitung = (presentasehidden + value * percent * 100).toFixed();
    }
    var precentage = hitung;
    $(".presentase" + k).html(precentage + "%");
    $(".presentasehidden" + k).val(precentage);
    $(".cekpresentasekeberapa" + k).val(cekpresentasekeberapa + 1);
    $(".lastchange" + k).val(lastdata);
    $(".lastvalue" + a + i + k).val(value); // save value yg terakhir di input
  }
}
function CrtSims() {
  var kendaraan = $("#SelctKendaraAn").val();
  var request = $.ajax({
    url: baseurl + "MuatanTruk/Simulasi/CreateSimulasi",
    type: "POST",
    beforeSend: function () {
      $("div#TableSimUlasi").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
    data: {
      kendaraan: kendaraan,
    },
    datatype: "html",
  });
  request.done(function (result) {
    // console.log(result);
    $("div#TableSimUlasi").html(result);
  });
}
function HitungPresentase() {
  // var value = $("#jumlah_muatan_sims" + key + keys).val();
  var jml_muatan = [];
  $('[name="jumlah_muatan_sims"]')
    .map(function () {
      jml_muatan.push($(this).val());
    })
    .get();
  // var value_terakhir = parseInt($("#last_val_muatan_sims" + key + keys).val());
  // var presentase_value = $("#percent_muatan_sims" + key + keys).val();
  // var presentase_terakhir = parseInt($("#percent_muatan_kendaraan_hide").val());
  var presentase_value = [];
  $('[name="percent_muatan_sims"]')
    .map(function () {
      presentase_value.push($(this).val());
    })
    .get();

  $.ajax({
    url: baseurl + "MuatanTruk/Simulasi/HitungPresentase",
    type: "POST",
    dataType: "json",
    data: {
      jml_muatan: jml_muatan,
      presentase_value: presentase_value,
    },
    success: function (result) {
      $("#percent_muatan_kendaraan").html(result);
    },
  });

  // if (value == null || value == "") {
  //   var hitungan =
  //     presentase_terakhir - value_terakhir * presentase_value * 100;

  //   $("#percent_muatan_kendaraan_hide").val(hitungan.toFixed());
  //   $("#percent_muatan_kendaraan").html(hitungan.toFixed());
  //   $("#last_val_muatan_sims" + key + keys).val("0");
  // } else {
  //   var pengurang =
  //     presentase_terakhir - value_terakhir * presentase_value * 100;

  //   var hitungan = pengurang + value * presentase_value * 100;

  //   $("#percent_muatan_kendaraan_hide").val(hitungan.toFixed());
  //   $("#percent_muatan_kendaraan").html(hitungan.toFixed());
  //   $("#last_val_muatan_sims" + key + keys).val(value);
  // }
}
