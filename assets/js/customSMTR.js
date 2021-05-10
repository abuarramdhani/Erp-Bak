$(document).ready(function () {
  $("#tbl_simulasi").DataTable({
    paging: false,
    info: false,
    scrollCollapse: true,
    // scrollY: 400,
    scrollX: true,
    fixedColumns: {
      leftColumns: 2,
    },
    order: [[1, "desc"]],
  });
});
$(document).on("focus", "input[type=number]", function (e) {
  $(this).on("wheel.disableScroll", function (e) {
    e.preventDefault();
  });
});
$(document).on("blur", "input[type=number]", function (e) {
  $(this).off("wheel.disableScroll");
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
