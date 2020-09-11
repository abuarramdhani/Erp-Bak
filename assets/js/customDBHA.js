$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "DbHandling/MonitoringHandling/loadviewreqhand",
    type: "POST",
    beforeSend: function () {
      $("div#tabel_reqhand").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    // console.log(result);
    $("div#tabel_reqhand").html(result);
  });
});
$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "DbHandling/MonitoringHandling/loadviewreqhand2",
    type: "POST",
    beforeSend: function () {
      $("div#tabel_reqhand2").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    // console.log(result);
    $("div#tabel_reqhand2").html(result);
  });
});
$(document).ready(function () {
  var sarana = null;
  var produk = null;
  var seksi = null;
  var request = $.ajax({
    url: baseurl + "DbHandling/MonitoringHandling/loadviewdatahand",
    data: {
      sarana: sarana,
      produk: produk,
      seksi: seksi,
    },
    type: "POST",
    beforeSend: function () {
      $("div#tabel_datahand").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    // console.log(result);
    $("div#tabel_datahand").html(result);
    var datat = $("#datahandling").dataTable({
      paging: true,
      pageLength: 25,
      info: true,
    });
    $("#searchboxdatatable").on("keyup", function () {
      datat.fnFilter(this.value);
    });
  });
});
function showfilter() {
  var value = $("#filterselected").val();
  if (value == 1) {
    $("#showifbyprod").css("display", "block");
    $("#showifbysarana").css("display", "none");
    $("#showifbyseksi").css("display", "none");
    $("#filtersarana").select2("val", "");
    $("#filterseksi").select2("val", "");
    $("#filterproduk").removeAttr("disabled");
  } else if (value == 2) {
    $("#showifbysarana").css("display", "block");
    $("#showifbyseksi").css("display", "none");
    $("#showifbyprod").css("display", "none");
    $("#filterseksi").select2("val", "");
    $("#filterproduk").select2("val", "");
    $("#filtersarana").removeAttr("disabled");
  } else if (value == 3) {
    $("#showifbyseksi").css("display", "block");
    $("#showifbyprod").css("display", "none");
    $("#showifbysarana").css("display", "none");
    $("#filterproduk").select2("val", "");
    $("#filtersarana").select2("val", "");
    $("#filterseksi").removeAttr("disabled");
  }
}
function onchangefilter() {
  var sarana = $("#filtersarana").val();
  var produk = $("#filterproduk").val();
  var seksi = $("#filterseksi").val();
  // console.log(sarana, produk, seksi);
  var request = $.ajax({
    url: baseurl + "DbHandling/MonitoringHandling/loadviewdatahand",
    data: {
      sarana: sarana,
      produk: produk,
      seksi: seksi,
    },
    type: "POST",
    datatype: "html",
    beforeSend: function () {
      $("div#tabel_datahand").html(
        '<center><img id="loadingimg" style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    $("div#tabel_datahand").html(result);
    var datat = $("#datahandling").dataTable({
      paging: true,
      pageLength: 25,
      info: true,
    });
    $("#searchboxdatatable").on("keyup", function () {
      datat.fnFilter(this.value);
    });
  });
}
function reset() {
  // window.location.reload();
  $("#showifbyseksi").css("display", "none");
  $("#showifbyprod").css("display", "none");
  $("#showifbysarana").css("display", "none");
  $("#filterselected").select2("val", "");
  $("#filterproduk").select2("val", "");
  $("#filtersarana").select2("val", "");
  $("#filterseksi").select2("val", "");
  var sarana = null;
  var produk = null;
  var seksi = null;
  var request = $.ajax({
    url: baseurl + "DbHandling/MonitoringHandling/loadviewdatahand",
    data: {
      sarana: sarana,
      produk: produk,
      seksi: seksi,
    },
    type: "POST",
    beforeSend: function () {
      $("div#tabel_datahand").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    // console.log(result);
    $("div#tabel_datahand").html(result);
    var datat = $("#datahandling").dataTable({
      paging: true,
      pageLength: 25,
      info: true,
    });
    $("#searchboxdatatable").on("keyup", function () {
      datat.fnFilter(this.value);
    });
  });
}
function imgcarousel(id) {
  var proses = $("#proseshandling" + id).val();
  var request = $.ajax({
    url: baseurl + "DbHandling/MonitoringHandling/imgcarousel",
    data: {
      id: id,
      proses: proses,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#imgcar").html(result);
    $("#modalcarousel").modal("show");
  });
}
function imgcarousell(id) {
  var proses = $("#proseshandlingg" + id).val();
  var request = $.ajax({
    url: baseurl + "DbHandling/MonitoringHandling/imgcarousel",
    data: {
      id: id,
      proses: proses,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#imgcarr").html(result);
    $("#modalcarousell").modal("show");
  });
}
function proseshandling(id) {
  var proses = $("#proseshandling" + id).val();
  var request = $.ajax({
    url: baseurl + "DbHandling/MonitoringHandling/proseshandling",
    data: {
      id: id,
      proses: proses,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#prosess").html(result);
    $("#modalproseshandling").modal("show");
  });
}
function proseshandlingg(id) {
  var proses = $("#proseshandlingg" + id).val();
  var request = $.ajax({
    url: baseurl + "DbHandling/MonitoringHandling/proseshandling",
    data: {
      id: id,
      proses: proses,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#prosesss").html(result);
    $("#modalproseshandlingg").modal("show");
  });
}

function acc(id) {
  // console.log(id);
  Swal.fire({
    title: "Apa Anda Yakin?",
    text: "Akan Menerima Request Ini ?",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#b0bec5",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  }).then((result) => {
    // console.log("okay");
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "DbHandling/MonitoringHandling/updateterima",
        data: {
          id: id,
        },
        type: "POST",
        datatype: "html",
      });
      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Menerima",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.href = baseurl + "DbHandling/MonitoringHandling";
          // window.location.replace("DbHandling/MonitoringHandling");
        });
      });
    }
  });
}
function reject(id) {
  Swal.fire({
    title: "Apa Anda Yakin?",
    text: "Akan Menolak Request Ini ?",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#d73925",
    cancelButtonColor: "#b0bec5",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  }).then((result) => {
    console.log("okay");
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "DbHandling/MonitoringHandling/updatereject",
        data: {
          id: id,
        },
        type: "POST",
        datatype: "html",
      });
      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "error",
          title: "Request Ditolak",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.href = baseurl + "DbHandling/MonitoringHandling";
          // window.location.replace("DbHandling/MonitoringHandling");
        });
      });
    }
  });
}
$(document).ready(function () {
  $(".status_komp").select2({
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
      url: baseurl + "DbHandling/MonitoringHandling/statuskomp",
      dataType: "json",
      type: "GET",
      data: function (params) {
        var queryParameters = {
          term: params.term,
        };
        return queryParameters;
      },
      processResults: function (data) {
        // console.log(data);
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.id_status_komponen,
              text: obj.kode_status + " - " + obj.status,
            };
          }),
        };
      },
    },
  });
});
$(document).ready(function () {
  $("#kodekompp").select2({
    allowClear: true,
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "DbHandling/MonitoringHandling/kodekomp",
      dataType: "json",
      type: "GET",
      data: function (params) {
        var queryParameters = {
          term: params.term,
        };
        return queryParameters;
      },
      processResults: function (data) {
        // console.log(data);
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.SEGMENT1 + "&" + obj.DESCRIPTION,
              text: obj.SEGMENT1 + " - " + obj.DESCRIPTION,
            };
          }),
        };
      },
    },
  });
});
$(document).ready(function () {
  $(".prosesss").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });
});
$(document).ready(function () {
  $(".id_Seksi").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });
});
$(document).ready(function () {
  $(".prosesseksi").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });
});
$(document).ready(function () {
  $("#produkk").select2({
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
      url: baseurl + "DbHandling/MonitoringHandling/suggestproduk",
      dataType: "json",
      type: "GET",
      data: function (params) {
        var queryParameters = {
          term: params.term,
        };
        return queryParameters;
      },
      processResults: function (data) {
        // console.log(data);
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.FLEX_VALUE + "-" + obj.DESCRIPTION,
              text: obj.FLEX_VALUE + " - " + obj.DESCRIPTION,
            };
          }),
        };
      },
    },
  });
});
$(document).ready(function () {
  $("#saranahand").select2({
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
      url: baseurl + "DbHandling/MonitoringHandling/suggestsarana",
      dataType: "json",
      type: "GET",
      data: function (params) {
        var queryParameters = {
          term: params.term,
        };
        return queryParameters;
      },
      processResults: function (data) {
        // console.log(data);
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.id_master_handling,
              text: obj.kode_handling + " - " + obj.nama_handling,
            };
          }),
        };
      },
    },
  });
});
function angkaaa(e, decimal) {
  var key;
  var keychar;
  if (window.event) {
    key = window.event.keyCode;
  } else if (e) {
    key = e.which;
  } else return true;
  keychar = String.fromCharCode(key);
  if (
    key == null ||
    key == 0 ||
    key == 8 ||
    key == 9 ||
    key == 13 ||
    key == 27
  ) {
    return true;
  } else if ("0123456789.".indexOf(keychar) > -1) {
    return true;
  } else if (decimal && keychar == ".") {
    return true;
  } else return false;
}
$(document).ready(function () {
  $("#prosesss").on("change", function () {
    var pro = $("#prosesss").val();
    if (pro == "Linear") {
      $("#afterprosesslinier").css("display", "block");
      $("#afterprosesnonlinier").css("display", "none");
      $("#prosesnonlinear").attr("disabled", "disabled");
      $("#gambarprosesnonlinear").attr("disabled", "disabled");
      $("#id_Seksi").removeAttr("disabled");
      $("#prosesseksi").removeAttr("disabled");
      $("#gambarproses").removeAttr("disabled");
    } else {
      $("#afterprosesnonlinier").css("display", "block");
      $("#afterprosesslinier").css("display", "none");
      $("#prosesnonlinear").removeAttr("disabled");
      $("#gambarprosesnonlinear").removeAttr("disabled");
      $("#id_Seksi").attr("disabled", "disabled");
      $("#prosesseksi").attr("disabled", "disabled");
      $("#gambarproses").attr("disabled", "disabled");
    }
  });
});
$(document).ready(function () {
  $("#kodekompp").on("change", function () {
    var value = $(this).val();
    var vall = value.split("&");
    $("#namakomp").val(vall[1]);
    $("#kodekompp2").val(vall[0]);
  });
  $("#kodekompp").on("change", function () {
    var value = $(this).val();
    var vall = value.split("&");
    $.ajax({
      type: "POST",
      dataType: "json",
      data: { kode: vall[0] },
      url: baseurl + "DbHandling/MonitoringHandling/cekKodeKomp",
      success: function (result) {
        // console.log(result);
        if (result == 0) {
          // console.log("tampilkan simbol success dan inputkan yg lain");
          $(".showkalaukompbelomada").css("display", "block");
          $(".hideajakalaukompudahada").css("display", "block");
          $("#validationkomp").css("display", "none");
          $("#btnrev").css("display", "none");
          $(".savehand").removeAttr("disabled");
        } else {
          // console.log("append tombol revisi");
          $(".showkalaukompbelomada").css("display", "none");
          $(".hideajakalaukompudahada").css("display", "none");
          $("#validationkomp").css("display", "block");
          $("#btnrev").css("display", "block");
          $(".savehand").attr("disabled", "disabled");
          $("#btnrev").on("click", function () {
            revisidatahandling(result);
          });
        }
      },
    });
  });
});

$(document).ready(function () {
  $("#id_Seksi").on("change", function () {
    var value = $(this).val();
    // console.log(value);
    $("#prosesseksi").select2("val", null);
    $("#prosesseksi").prop("disabled", true);
    $.ajax({
      type: "POST",
      data: { segment1: value },
      url: baseurl + "DbHandling/MonitoringHandling/form",
      success: function (result) {
        if (result != "<option></option>") {
          $("#prosesseksi").prop("disabled", false).html(result);
        } else {
        }
      },
    });
  });
  $("#prosesseksi").on("change", function () {
    var proses = $("#prosesseksi").val();
    var id = $("#id_Seksi").val();
    $("#tulisann").html(proses);

    if (id == "Machining") {
      $("#previewkotakproses").css({
        "background-color": "#ffff00",
      });
      $("#warnanyadisini").css({
        "background-color": "#ffff00",
        color: "#ffff00",
      });
    } else if (id == "Gudang") {
      $("#previewkotakproses").css({
        "background-color": "#cccccc",
      });
      $("#warnanyadisini").css({
        "background-color": "#cccccc",
        color: "#cccccc",
      });
    } else if (id == "PnP") {
      $("#previewkotakproses").css({
        "background-color": "#ff8080",
      });
      $("#warnanyadisini").css({
        "background-color": "#ff8080",
        color: "#ff8080",
      });
    } else if (id == "Sheet Metal") {
      $("#previewkotakproses").css({
        "background-color": "#94bd5e",
      });
      $("#warnanyadisini").css({
        "background-color": "#94bd5e",
        color: "#94bd5e",
      });
    } else if (id == "UPPL") {
      $("#previewkotakproses").css({
        "background-color": "#ff00ff",
      });
      $("#warnanyadisini").css({
        "background-color": "#ff00ff",
        color: "#ff00ff",
      });
    } else if (id == "Perakitan") {
      $("#previewkotakproses").css({
        "background-color": "#99ccff",
      });
      $("#warnanyadisini").css({
        "background-color": "#99ccff",
        color: "#99ccff",
      });
    } else if (id == "Subkon") {
      $("#previewkotakproses").css({
        "background-color": "#ffcc99",
      });
      $("#warnanyadisini").css({
        "background-color": "#ffcc99",
        color: "#ffcc99",
      });
    }
  });
});
o = 1;
function appendproseslinear() {
  o += 1;
  $(".btnplus").css("display", "none");
  no = $('[name="nomorproses[]"').length + 1;
  $("#appendd").append(
    '<div class="panel-body"><div class="col-md-3" style="text-align: right;color:white"><label>Proses</label></div><div class="col-md-8" style="text-align: left;"><div class="col-md-2"><input type="text" name="nomorproses[]" class="form-control" readonly="readonly" value="' +
      no +
      '" /></div><div class="col-md-4"><select name="id_Seksi[]" style="width: 100%;" class="form-control select2 id_Seksi" id="id_Seksi' +
      o +
      '" data-placeholder="Identitas Seksi"><option></option><option value="UPPL">UPPL</option><option value="Sheet Metal">Sheet Metal</option><option value="Machining">Machining</option><option value="Perakitan">Perakitan</option><option value="PnP">PnP</option><option value="Gudang">Gudang</option><option value="Subkon">Subkon</option></select></div><div class="col-md-1"><div id="warnanyadisini' +
      o +
      '" style="background-color: white;color:white;font-size:14pt;padding:2px;">A</div></div><div class="col-md-4"><select style="width: 100%;" name="prosesseksi[]" disabled class="form-control select2 prosesseksi" id="prosesseksi' +
      o +
      '" data-placeholder="Proses Seksi"><option></option></select></div><div class="col-md-1"><button class="btn btn-danger btnminus"><i class="fa fa-minus"></i></button></div></div></div>'
  );
  $("#previewproses").append(
    '<span class="ktktktk"><div id="arrow' +
      o +
      '" style="display: inline-block;"><div style="height:75px; margin:20px;text-align:center;padding: 20px 0;"><i class="fa fa-arrow-right fa-2x"></i></div></div><div id="kotakk' +
      o +
      '" style="display: inline-block;"><div id="previewkotakproses' +
      o +
      '" style="border: 1px solid black;margin:10px;text-align:center;padding: 10px 0;"><p style="margin:10px" id="tulisann' +
      o +
      '"></p></div></div></span>'
  );
  $("#prosesseksi" + o).on("change", function () {
    var proses = $("#prosesseksi" + o).val();
    var id = $("#id_Seksi" + o).val();
    $("#tulisann" + o).html(proses);

    if (id == "Machining") {
      $("#previewkotakproses" + o).css({
        "background-color": "#ffff00",
      });
      $("#warnanyadisini" + o).css({
        "background-color": "#ffff00",
        color: "#ffff00",
      });
    } else if (id == "Gudang") {
      $("#previewkotakproses" + o).css({
        "background-color": "#cccccc",
      });
      $("#warnanyadisini" + o).css({
        "background-color": "#cccccc",
        color: "#cccccc",
      });
    } else if (id == "PnP") {
      $("#previewkotakproses" + o).css({
        "background-color": "#ff8080",
      });
      $("#warnanyadisini" + o).css({
        "background-color": "#ff8080",
        color: "#ff8080",
      });
    } else if (id == "Sheet Metal") {
      $("#previewkotakproses" + o).css({
        "background-color": "#94bd5e",
      });
      $("#warnanyadisini" + o).css({
        "background-color": "#94bd5e",
        color: "#94bd5e",
      });
    } else if (id == "UPPL") {
      $("#previewkotakproses" + o).css({
        "background-color": "#ff00ff",
      });
      $("#warnanyadisini" + o).css({
        "background-color": "#ff00ff",
        color: "#ff00ff",
      });
    } else if (id == "Perakitan") {
      $("#previewkotakproses" + o).css({
        "background-color": "#99ccff",
      });
      $("#warnanyadisini" + o).css({
        "background-color": "#99ccff",
        color: "#99ccff",
      });
    } else if (id == "Subkon") {
      $("#previewkotakproses" + o).css({
        "background-color": "#ffcc99",
      });
      $("#warnanyadisini" + o).css({
        "background-color": "#ffcc99",
        color: "#ffcc99",
      });
    }
  });
  $(document).on("click", ".btnminus", function () {
    $(".btnplus").css("display", "");

    $(this).parents(".panel-body").remove();

    $("#afterprosesslinier")
      .find('[name="nomorproses[]"]')
      .each(function (i, v) {
        $(this).val(i + 1);
      });
  });
  $(".id_Seksi").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });
  $(".prosesseksi").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });
  $("#id_Seksi" + o).on("change", function () {
    var value = $(this).val();
    // console.log(value);
    $("#prosesseksi" + o).select2("val", null);
    $("#prosesseksi" + o).prop("disabled", true);
    $.ajax({
      type: "POST",
      data: { segment1: value },
      url: baseurl + "DbHandling/MonitoringHandling/form",
      success: function (result) {
        if (result != "<option></option>") {
          $("#prosesseksi" + o)
            .prop("disabled", false)
            .html(result);
        } else {
        }
      },
    });
  });
  $("#prosesseksi" + o).on("change", function () {
    $(".btnplus").css("display", "");
  });
}
function readURL1(input) {
  // console.log(a);

  var sizee = (input.files[0].size / 1024 / 1024).toFixed(2);

  if (sizee > 2) {
    Swal.fire({
      type: "error",
      title: "Ukuran gambar tidak bisa lebih dari 2 MB",
    }).then(() => {
      $("#gambarproses").val("");
    });
  } else {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#previewgambwar").attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
}
var a = 0;
function appendinputgambar() {
  $(".btn_input_gambarr").css("display", "none");

  var i = $('[name="fotoproseslinear[]"').length + 1;

  a++;
  $("#appendinputgambar").append(
    '<span id="hihihi' +
      a +
      '"><div class="panel-body"><input type="hidden" name="urutangambar[]" value="' +
      a +
      '"/><div class="col-md-3" style="text-align: right;color:white"><label>Foto</label></div><div class="col-md-1" style="text-align: right;"><input class="form-control" readonly  name="fotoproseslinear[]" value="' +
      i +
      '" /></div><div class="col-md-5"><input id="imgee' +
      a +
      '" type="file" class="form-control" accept=".jpg, .png, ,jpeg" name="gambarproses[]" /></div><div class="col-md-1" style="text-align: right;"><a class="btn btn-danger btnminuss"><i class="fa fa-minus"></i></a></div></div><div class="panel-body "><div class="col-md-3" style="text-align: right;color:white"><label>Foto</label></div><div class="col-md-1" style="text-align: right;"></div><div class="col-md-5"><img style="width:100%" id="previewgambwar' +
      a +
      '"></div></div></span>'
  );
  $(document).on("click", ".btnminuss", function () {
    $("#afterprosesslinier")
      .find('[name="fotoproseslinear[]"]')
      .each(function (i, v) {
        $(this).val(i + 1);
      });
    var row = Number(
      $(this).parents(".panel-body").find('[name="urutangambar[]"]').val()
    );
    // console.log(row);
    $("#hihihi" + row).remove();
  });
  $("#imgee" + a).on("change", function () {
    $(".btn_input_gambarr").css("display", "");
    readURL(this, a);
  });
}
function readURL(input, a) {
  // console.log(a);
  var sizee = (input.files[0].size / 1024 / 1024).toFixed(2);

  if (sizee > 2) {
    Swal.fire({
      type: "error",
      title: "Ukuran gambar tidak bisa lebih dari 2 MB",
    }).then(() => {
      $("#imgee" + a).val("");
    });
  } else {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#previewgambwar" + a).attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
}
function tampilprosesnonlinear(input) {
  // console.log(input);
  var sizee = (input.files[0].size / 1024 / 1024).toFixed(2);

  if (sizee > 2) {
    Swal.fire({
      type: "error",
      title: "Ukuran gambar tidak bisa lebih dari 2 MB",
    }).then(() => {
      $("#prosesnonlinear").val("");
    });
  } else {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#prosesnonlinearimg").attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
}
function tampilgambarprosesnonlinear(input) {
  // console.log(a);
  var sizee = (input.files[0].size / 1024 / 1024).toFixed(2);

  if (sizee > 2) {
    Swal.fire({
      type: "error",
      title: "Ukuran gambar tidak bisa lebih dari 2 MB",
    }).then(() => {
      $("#gambarprosesnonlinear").val("");
    });
  } else {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#gambarprosesnonlinearimg").attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
}
var c = 0;
function appendinputgambar2() {
  $(".btn_input_gambar").css("display", "none");
  var p = $('[name="fotoprosesnonlinear[]"').length + 1;
  c++;
  $("#appendinputgambar2").append(
    '<span id="hehehe' +
      c +
      '"><div class="panel-body"><input type="hidden" value="' +
      c +
      '" name="inputgambwar[]"/><div class="col-md-3" style="text-align: right;color:white"><label>Foto</label></div><div class="col-md-1" style="text-align: right;"><input class="form-control" readonly name="fotoprosesnonlinear[]" value="' +
      p +
      '" /></div><div class="col-md-5"><input type="file" class="form-control" accept=".jpg, .png, ,jpeg" name="gambarprosesnonlinear[]" id="gambarprosesnonlinear' +
      c +
      '" /></div><div class="col-md-1" style="text-align: right;"><a class="btn btn-danger btnminusss"><i class="fa fa-minus"></i></a></div></div><div class="panel-body"><div class="col-md-3" style="text-align: right; color:white"><label>Foto</label></div><div class="col-md-1" style="text-align: right;"></div><div class="col-md-5"><img style="width:100%" id="gambarprosesnonlinearimg' +
      c +
      '"></div></div></span>'
  );
  $(document).on("click", ".btnminusss", function () {
    $("#afterprosesnonlinier")
      .find('[name="fotoprosesnonlinear[]"]')
      .each(function (i, v) {
        $(this).val(i + 1);
      });
    var row = Number(
      $(this).parents(".panel-body").find('[name="inputgambwar[]"]').val()
    );
    // console.log(row);
    $("#hehehe" + row).remove();
  });
  $("#gambarprosesnonlinear" + c).on("change", function () {
    $(".btn_input_gambar").css("display", "");

    tampilgambarprosesnonlinear2(this, c);
  });
}
function tampilgambarprosesnonlinear2(input, c) {
  // console.log(a);
  var sizee = (input.files[0].size / 1024 / 1024).toFixed(2);

  if (sizee > 2) {
    Swal.fire({
      type: "error",
      title: "Ukuran gambar tidak bisa lebih dari 2 MB",
    }).then(() => {
      $("#gambarprosesnonlinear" + c).val("");
    });
  } else {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#gambarprosesnonlinearimg" + c).attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
}

$(document).on("click", ".btnminus", function () {
  var btnrow =
    Number(
      $(this).parents(".panel-body").find('[name="nomorproses[]"]').val()
    ) - 2;
  $("#previewproses").children(`.ktktktk:eq(${btnrow})`).remove();
});
function revisidatahandling(id) {
  var request = $.ajax({
    url: baseurl + "DbHandling/MonitoringHandling/revHand",
    data: {
      id: id,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#revhand").html(result);
    $("#modalrevhand").modal("show");
    $(".StatKomp").select2({
      allowClear: true,
      minimumResultsForSearch: Infinity,
    });
    $(".SarAna").select2({
      allowClear: true,
      minimumResultsForSearch: Infinity,
    });
    $(".Pros_Es").select2({
      allowClear: true,
      minimumResultsForSearch: Infinity,
    });
    $(".idSek_si").select2({
      allowClear: true,
      minimumResultsForSearch: Infinity,
    });
    $(".Pro_sesSeksi").select2({
      allowClear: true,
      minimumResultsForSearch: Infinity,
    });
  });
}
function revisidatahandling2(id) {
  var request = $.ajax({
    url: baseurl + "DbHandlingSeksi/MonitoringHandling/revHand",
    data: {
      id: id,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#revhand").html(result);
    $("#modalrevhand").modal("show");
    $(".StatKomp").select2({
      allowClear: true,
      minimumResultsForSearch: Infinity,
    });
    $(".SarAna").select2({
      allowClear: true,
      minimumResultsForSearch: Infinity,
    });
    $(".Pros_Es").select2({
      allowClear: true,
      minimumResultsForSearch: Infinity,
    });
    $(".idSek_si").select2({
      allowClear: true,
      minimumResultsForSearch: Infinity,
    });
    $(".Pro_sesSeksi").select2({
      allowClear: true,
      minimumResultsForSearch: Infinity,
    });
  });
}
function getwarnaid(i) {
  var value = $("#Id_Sek_Si" + i).val();

  // console.log(value);
  if (value == "Machining") {
    $("#warna_Id_Seksi" + i).css({
      "background-color": "#ffff00",
      color: "#ffff00",
    });
    $("#Kotakk" + i).css("background-color", "#ffff00");
  } else if (value == "Gudang") {
    $("#warna_Id_Seksi" + i).css({
      "background-color": "#cccccc",
      color: "#cccccc",
    });
    $("#Kotakk" + i).css("background-color", "#cccccc");
  } else if (value == "PnP") {
    $("#warna_Id_Seksi" + i).css({
      "background-color": "#ff8080",
      color: "#ff8080",
    });
    $("#Kotakk" + i).css("background-color", "#ff8080");
  } else if (value == "Sheet Metal") {
    $("#warna_Id_Seksi" + i).css({
      "background-color": "#94bd5e",
      color: "#94bd5e",
    });
    $("#Kotakk" + i).css("background-color", "#94bd5e");
  } else if (value == "UPPL") {
    $("#warna_Id_Seksi" + i).css({
      "background-color": "#ff00ff",
      color: "#ff00ff",
    });
    $("#Kotakk" + i).css("background-color", "#ff00ff");
  } else if (value == "Perakitan") {
    $("#warna_Id_Seksi" + i).css({
      "background-color": "#99ccff",
      color: "#99ccff",
    });
    $("#Kotakk" + i).css("background-color", "#99ccff");
  } else if (value == "Subkon") {
    $("#warna_Id_Seksi" + i).css({
      "background-color": "#ffcc99",
      color: "#ffcc99",
    });
    $("#Kotakk" + i).css("background-color", "#ffcc99");
  }
  $.ajax({
    type: "POST",
    data: { segment1: value },
    url: baseurl + "DbHandling/MonitoringHandling/form",
    success: function (result) {
      $("#Pros_Seksi" + i).html(result);
    },
  });
}
function tuliskan(i) {
  var tulisan = $("#Pros_Seksi" + i).val();
  $("#tulisanKotakk" + i).html(tulisan);
}
function addprosess() {
  var r = $('[name="indexproses[]"]').length + 1 - 1;
  var q = $('[name="urutPros[]"]').length + 1;
  // console.log(r, q);

  $(".addPros").append(
    '<div class="panel-body"><input type="hidden" name="indexproses[]" value="' +
      r +
      '"/><div class="col-md-3" style="text-align:right;color:white"><label>Proses</label></div><div class="col-md-1"><input class="form-control" name="urutPros[]" value="' +
      q +
      '" readonly="readonly" type="text"/></div><div class="col-md-3"> <select style="width:100%" class="form-control select2 idSek_si" id="Id_Sek_Si' +
      r +
      '" onchange="getwarnaid(' +
      r +
      ')" data-placeholder="Select"><option></option><option value="UPPL">UPPL</option><option value="Sheet Metal">Sheet Metal</option><option value="Machining">Machining</option><option value="Perakitan">Perakitan</option><option value="PnP">PnP</option><option value="Gudang">Gudang</option><option value="Subkon">Subkon</option></select></div><div class="col-md-1" id="warna_Id_Seksi' +
      r +
      '" style="background-color: white;color:white;font-size:16pt;padding:2px;">A</div><div class="col-md-3"><select onchange="tuliskan(' +
      r +
      ')" data-placeholder="Select" style="width:100%" class="form-control select2 Pro_sesSeksi" name="ProSesSeksi[]" id="Pros_Seksi' +
      r +
      '"><option ></option></select></div><div class="col-md-1"><button class="btn btn-danger btn-hps' +
      r +
      '"><i class="fa fa-minus"></i></button></div></div>'
  );
  $("#preview_ProsSes").append(
    '<div style="display: inline-block;"><div class="arahpenunjuk" id="arrowprosSes' +
      r +
      '" style="height:75px;text-align:center;padding: 10px 0;"><i class="fa fa-arrow-right"></i></div></div><div style="display: inline-block;"><div class="kotakan" id="Kotakk' +
      r +
      '" style="border: 1px solid black;text-align:center;padding: 10px 0;"><p class="ketPrev" style="margin:10px" id="tulisanKotakk' +
      r +
      '"></p></div></div>'
  );
  if (q >= 1 && q <= 3) {
    var style_kotak = "60mm";
    var style_arrow = "20mm";
    var font = "12pt";
  } else if (3 < q && q <= 6) {
    var style_kotak = "40mm";
    var style_arrow = "15mm";
    var font = "10pt";
  } else if (6 < q && q <= 9) {
    var style_kotak = "20mm";
    var style_arrow = "10mm";
    var font = "9pt";
  } else {
    var style_kotak = "17mm";
    var style_arrow = "7mm";
    var font = "8pt";
  }
  $(".kotakan").css("width", style_kotak);
  $(".arahpenunjuk").css("width", style_arrow);
  $(".ketPrev").css("font-size", font);
  $(".idSek_si").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });
  $(".Pro_sesSeksi").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });

  $(document).on("click", ".btn-hps" + r, function () {
    $(this).parents(".panel-body").remove();
    $(".addPros")
      .find('[name="urutPros[]"]')
      .each(function (i, v) {
        $(this).val(i + 1);
      });
    $("#arrowprosSes" + r).remove();
    $("#Kotakk" + r).remove();

    var q = $('[name="urutPros[]"]').length + 1;

    if (q >= 1 && q <= 3) {
      var style_kotak = "60mm";
      var style_arrow = "20mm";
      var font = "12pt";
    } else if (3 < q && q <= 6) {
      var style_kotak = "40mm";
      var style_arrow = "15mm";
      var font = "10pt";
    } else if (6 < q && q <= 9) {
      var style_kotak = "20mm";
      var style_arrow = "10mm";
      var font = "9pt";
    } else {
      var style_kotak = "17mm";
      var style_arrow = "7mm";
      var font = "8pt";
    }
    $(".kotakan").css("width", style_kotak);
    $(".arahpenunjuk").css("width", style_arrow);
    $(".ketPrev").css("font-size", font);
  });
}
function addfoto() {
  var i = $('[name="indexGambr[]"]').length + 1 - 1;
  var u = $('[name="uRutGambar[]"]').length + 1;
  $(".addImg").append(
    '<div id="has' +
      i +
      '"><div class="panel-body"><input type="hidden" name="indexGambr[]" value="' +
      i +
      '"/><div class="col-md-3" style="text-align:right;color:white"><label>Foto</label></div><div class="col-md-1"><input class="form-control" name ="uRutGambar[]" value="' +
      u +
      '" readonly="readonly" type="text"/></div><div class="col-md-6"><input type="file" id="fotoHandling' +
      i +
      '" name="fotoHandling[]" onchange="PrevImg(this,' +
      i +
      ')" class="form-control" accept=".jpg, .png, ,jpeg"/></div><div class="col-md-1"><a class="btn btn-danger" onclick="deletpoto(' +
      i +
      ')"><i class="fa fa-minus"></i></a></div></div><div class="panel-body"><div class="col-md-3" style="text-align:right;color:white"><label>Foto</label></div><div class="col-md-8"><center><img id="showPrevImg' +
      i +
      '" style="width:50%"></center></div></div></div>'
  );
}
function deleteproses(d) {
  $(".haha" + d).remove();
  $(".addPros")
    .find('[name="urutPros[]"]')
    .each(function (i, v) {
      $(this).val(i + 1);
    });
  if (d == 0) {
    $("#Kotakk" + d).remove();
  } else {
    $("#arrowprosSes" + d).remove();
    $("#Kotakk" + d).remove();
  }
  var q = $('[name="urutPros[]"]').length + 1;
  if (q >= 1 && q <= 3) {
    var style_kotak = "60mm";
    var style_arrow = "20mm";
    var font = "12pt";
  } else if (3 < q && q <= 6) {
    var style_kotak = "40mm";
    var style_arrow = "15mm";
    var font = "10pt";
  } else if (6 < q && q <= 9) {
    var style_kotak = "20mm";
    var style_arrow = "10mm";
    var font = "9pt";
  } else {
    var style_kotak = "17mm";
    var style_arrow = "7mm";
    var font = "8pt";
  }
  $(".kotakan").css("width", style_kotak);
  $(".arahpenunjuk").css("width", style_arrow);
  $(".ketPrev").css("font-size", font);
}
function deletpoto(g) {
  $("#has" + g).remove();
  $(".addImg")
    .find('[name="uRutGambar[]"]')
    .each(function (i, v) {
      $(this).val(i + 1);
    });
}

function prosesonchange() {
  var valchanges = $(".Pros_Es").val();
  var value = $("#pronih").val();
  if (valchanges == "Linear") {
    if (value == "Linear") {
      $(".prosesawal").css("display", "block");
      $(".prosesiflinear").css("display", "none");
      $(".prosesifnonlinear").css("display", "none");
    } else {
      $(".prosesiflinear").css("display", "block");
      $(".prosesawal").css("display", "none");
      $(".prosesifnonlinear").css("display", "none");
    }
  } else {
    if (value == "Linear") {
      $(".prosesifnonlinear").css("display", "block");
      $(".prosesawal").css("display", "none");
      $(".prosesiflinear").css("display", "none");
    } else {
      $(".prosesawal").css("display", "block");
      $(".prosesiflinear").css("display", "none");
      $(".prosesifnonlinear").css("display", "none");
    }
  }
}
function appendiflinear() {
  var r = $('[name="indexprosess[]"]').length + 1 - 1;
  var q = $('[name="urutPross[]"]').length + 1;
  // console.log(r, q);
  $(".linierappend").append(
    '<div class="panel-body"><input type="hidden" name="indexprosess[]" value="' +
      r +
      '"/><div class="col-md-3" style="text-align:right;color:white"><label>Proses</label></div><div class="col-md-1"><input class="form-control" name="urutPross[]" value="' +
      q +
      '" readonly="readonly" type="text"/></div><div class="col-md-3"> <select style="width:100%" class="form-control select2 idSek_si" id="Id_Sek_Sii' +
      r +
      '" onchange="getwarnaidd(' +
      r +
      ')" data-placeholder="Select"><option></option><option value="UPPL">UPPL</option><option value="Sheet Metal">Sheet Metal</option><option value="Machining">Machining</option><option value="Perakitan">Perakitan</option><option value="PnP">PnP</option><option value="Gudang">Gudang</option><option value="Subkon">Subkon</option></select></div><div class="col-md-1" id="warna_Id_Seksii' +
      r +
      '" style="background-color: white;color:white;font-size:16pt;padding:2px;">A</div><div class="col-md-3"><select data-placeholder="Select" style="width:100%" onchange="tulis(' +
      r +
      ')" class="form-control select2 Pro_sesSeksi" name="ProSesSekksi[]" id="Pros_Seksii' +
      r +
      '"><option ></option></select></div><div class="col-md-1"><button class="btn btn-danger btn-hpss' +
      r +
      '"><i class="fa fa-minus"></i></button></div></div>'
  );
  $("#appendselectproses").append(
    '<div style="display: inline-block;"><div id="arrowprosSess' +
      r +
      '" style="height:75px; margin:10px;text-align:center;padding: 10px 0;"><i class="fa fa-arrow-right fa-2x"></i></div></div><div style="display: inline-block;"><div id="Kotakkk' +
      r +
      '" style="border: 1px solid black;margin:10px;text-align:center;padding: 10px 0;background-color: white"><p style="margin:10px" id="TulisKotakkk' +
      r +
      '" ></p></div></div>'
  );
  $(".idSek_si").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });
  $(".Pro_sesSeksi").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });

  $(document).on("click", ".btn-hpss" + r, function () {
    $(this).parents(".panel-body").remove();

    $(".linierappend")
      .find('[name="urutPross[]"]')
      .each(function (i, v) {
        $(this).val(i + 1);
      });
    $("#arrowprosSess" + r).remove();
    $("#Kotakkk" + r).remove();
  });
}
function getwarnaidd(i) {
  var value = $("#Id_Sek_Sii" + i).val();
  console.log(value);
  if (value == "Machining") {
    $("#warna_Id_Seksii" + i).css({
      "background-color": "#ffff00",
      color: "#ffff00",
    });
    $("#Kotakkk" + i).css("background-color", "#ffff00");
  } else if (value == "Gudang") {
    $("#warna_Id_Seksii" + i).css({
      "background-color": "#cccccc",
      color: "#cccccc",
    });
    $("#Kotakkk" + i).css("background-color", "#cccccc");
  } else if (value == "PnP") {
    $("#warna_Id_Seksii" + i).css({
      "background-color": "#ff8080",
      color: "#ff8080",
    });
    $("#Kotakkk" + i).css("background-color", "#ff8080");
  } else if (value == "Sheet Metal") {
    $("#warna_Id_Seksii" + i).css({
      "background-color": "#94bd5e",
      color: "#94bd5e",
    });
    $("#Kotakkk" + i).css("background-color", "#94bd5e");
  } else if (value == "UPPL") {
    $("#warna_Id_Seksii" + i).css({
      "background-color": "#ff00ff",
      color: "#ff00ff",
    });
    $("#Kotakkk" + i).css("background-color", "#ff00ff");
  } else if (value == "Perakitan") {
    $("#warna_Id_Seksii" + i).css({
      "background-color": "#99ccff",
      color: "#99ccff",
    });
    $("#Kotakkk" + i).css("background-color", "#99ccff");
  } else if (value == "Subkon") {
    $("#warna_Id_Seksii" + i).css({
      "background-color": "#ffcc99",
      color: "#ffcc99",
    });
    $("#Kotakkk" + i).css("background-color", "#ffcc99");
  }
  $.ajax({
    type: "POST",
    data: { segment1: value },
    url: baseurl + "DbHandling/MonitoringHandling/form",
    success: function (result) {
      $("#Pros_Seksii" + i).html(result);
    },
  });
}
function tulis(i) {
  var tulisan = $("#Pros_Seksii" + i).val();
  $("#TulisKotakkk" + i).html(tulisan);
}

function previewimagenonlinier(input) {
  var sizee = (input.files[0].size / 1024 / 1024).toFixed(2);

  if (sizee > 2) {
    Swal.fire({
      type: "error",
      title: "Ukuran gambar tidak bisa lebih dari 2 MB",
    }).then(() => {
      $("#pros_non_linier").val("");
    });
  } else {
    $("#imgnonlinier").css("display", "none");
    $("#previewimgchange").css("display", "block");
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#previewimgchange").attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
}
function previewimagenonlinier2(input) {
  var sizee = (input.files[0].size / 1024 / 1024).toFixed(2);

  if (sizee > 2) {
    Swal.fire({
      type: "error",
      title: "Ukuran gambar tidak bisa lebih dari 2 MB",
    }).then(() => {
      $("#proses_non_2").val("");
    });
  } else {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#PrevImaGe").attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
}
function PrevImg(input, g) {
  var sizee = (input.files[0].size / 1024 / 1024).toFixed(2);

  if (sizee > 2) {
    Swal.fire({
      type: "error",
      title: "Ukuran gambar tidak bisa lebih dari 2 MB",
    }).then(() => {
      $("#fotoHandling" + g).val("");
    });
  } else {
    $("#hideifprev" + g).css("display", "none");
    $("#showPrevImg" + g).css("display", "block");

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#showPrevImg" + g).attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
}
// ------------------------------------------------- Set Data Master ----------------------------------------------------//
$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "DbHandling/SetDataMaster/loadviewmasterhandling",
    type: "POST",
    beforeSend: function () {
      $("div#tabel_master_handling").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    // console.log(result);
    $("div#tabel_master_handling").html(result);
  });
});
$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "DbHandling/SetDataMaster/loadviewmasterproseksi",
    type: "POST",
    beforeSend: function () {
      $("div#tabel_masterpro_seksi").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    // console.log(result);
    $("div#tabel_masterpro_seksi").html(result);
  });
});
$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "DbHandling/SetDataMaster/loadviewmasterstatkomp",
    type: "POST",
    beforeSend: function () {
      $("div#tabel_masterstat_komp").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    // console.log(result);
    $("div#tabel_masterstat_komp").html(result);
  });
});
function tambahmasterhandling() {
  var no_order = 1;

  var request = $.ajax({
    url: baseurl + "DbHandling/SetDataMaster/tambahmasterhandling",
    data: {
      no_order: no_order,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#masterhandlingadd").html(result);
    $("#modaltambahmasterhandling").modal("show");

    $("#kodehandling").on("keyup", function () {
      var kode = $("#kodehandling").val();
      var request = $.ajax({
        url: baseurl + "DbHandling/SetDataMaster/checkkodehandling",
        data: {
          kode: kode,
        },
        type: "POST",
        datatype: "html",
      });

      request.done(function (result) {
        // console.log(result);
        if (result == 0) {
          $("#simbolverifykode").html(
            '<i class="fa fa-check-square-o fa-2x" style="color:green;" ></i>'
          );
          $(".buttonsave").removeAttr("disabled");
          $("#kodehandling").css("border-color", "");
          $("#keterangansimbol").css("display", "none");
        } else {
          $("#simbolverifykode").html(
            '<i class="fa fa-ban fa-2x" style="color:red;" ></i>'
          );
          $(".buttonsave").attr("disabled", "disabled");
          $("#kodehandling").css("border-color", "red");
          $("#keterangansimbol").css("display", "block");
        }
      });
    });
    $(".buttonsave").on("click", function () {
      var namahandling = $("#namahandling").val();
      var kodehandling = $("#kodehandling").val();
      var request = $.ajax({
        url: baseurl + "DbHandling/SetDataMaster/insertmasterhandling",
        data: {
          namahandling: namahandling,
          kodehandling: kodehandling,
        },
        type: "POST",
        datatype: "html",
      });
      request.done(function () {
        $("#modaltambahmasterhandling").modal("hide");
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Menambah Master Handling",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          var request = $.ajax({
            url: baseurl + "DbHandling/SetDataMaster/loadviewmasterhandling",
            type: "POST",
            beforeSend: function () {
              $("div#tabel_master_handling").html(
                '<center><img style="width:100px; height:auto" src="' +
                  baseurl +
                  'assets/img/gif/loading11.gif"></center>'
              );
            },
          });
          request.done(function (result) {
            $("div#tabel_master_handling").html(result);
          });
        });
      });
    });
  });
}
function editmasterhandling(id) {
  // console.log(id);
  var request = $.ajax({
    url: baseurl + "DbHandling/SetDataMaster/editmasterhandling",
    data: {
      id: id,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#masterhandlingedit").html(result);
    $("#modaleditmasterhandling").modal("show");

    $("#kodehandlingedit").on("keyup", function () {
      var kode = $("#kodehandlingedit").val();
      var id = $("#idhandlingedit").val();
      var request = $.ajax({
        url: baseurl + "DbHandling/SetDataMaster/checkkodehandling2",
        data: {
          kode: kode,
          id: id,
        },
        type: "POST",
        datatype: "html",
      });

      request.done(function (result) {
        // console.log(result);
        if (result == 0) {
          $("#simbolverifykode2").html(
            '<i class="fa fa-check-square-o fa-2x" style="color:green;" ></i>'
          );
          $(".button-save-edit").removeAttr("disabled");
          $("#kodehandlingedit").css("border-color", "");
          $("#keterangansimbol2").css("display", "none");
        } else {
          $("#simbolverifykode2").html(
            '<i class="fa fa-ban fa-2x" style="color:red;" ></i>'
          );
          $(".button-save-edit").attr("disabled", "disabled");
          $("#kodehandlingedit").css("border-color", "red");
          $("#keterangansimbol2").css("display", "block");
        }
      });
    });
    $(".button-save-edit").on("click", function () {
      var namahandling = $("#namahandlingedit").val();
      var kodehandling = $("#kodehandlingedit").val();
      var id = $("#idhandlingedit").val();
      // console.log(namahandling, kodehandling, id);
      var request = $.ajax({
        url: baseurl + "DbHandling/SetDataMaster/updatemasterhandling",
        data: {
          namahandling: namahandling,
          kodehandling: kodehandling,
          id: id,
        },
        type: "POST",
        datatype: "html",
      });
      request.done(function () {
        $("#modaleditmasterhandling").modal("hide");
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Mengedit Master Handling",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          var request = $.ajax({
            url: baseurl + "DbHandling/SetDataMaster/loadviewmasterhandling",
            type: "POST",
            beforeSend: function () {
              $("div#tabel_master_handling").html(
                '<center><img style="width:100px; height:auto" src="' +
                  baseurl +
                  'assets/img/gif/loading11.gif"></center>'
              );
            },
          });
          request.done(function (result) {
            $("div#tabel_master_handling").html(result);
          });
        });
      });
    });
  });
}
function hapusmasterhandling(id) {
  Swal.fire({
    title: "Apa Anda Yakin?",
    text: "Akan Menghapus Master Handling Ini ?",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#d73925",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  }).then((result) => {
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "DbHandling/SetDataMaster/hapusdatamasterhandling",
        data: {
          id: id,
        },
        type: "POST",
        datatype: "html",
      });
      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Menghapus",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          var request = $.ajax({
            url: baseurl + "DbHandling/SetDataMaster/loadviewmasterhandling",
            type: "POST",
            beforeSend: function () {
              $("div#tabel_master_handling").html(
                '<center><img style="width:100px; height:auto" src="' +
                  baseurl +
                  'assets/img/gif/loading11.gif"></center>'
              );
            },
          });
          request.done(function (result) {
            $("div#tabel_master_handling").html(result);
          });
        });
      });
    }
  });
}
function tambahmasterprosesseksi() {
  var request = $.ajax({
    url: baseurl + "DbHandling/SetDataMaster/tambahmasterprosesseksi",
  });
  request.done(function (result) {
    // console.log(result);
    $("#masterproseksiadd").html(result);
    $("#modaltambahmasterproseksi").modal("show");
    $(".idseksi").select2({
      allowClear: true,
      minimumResultsForSearch: Infinity,
    });
    $(".idseksi").on("change", function () {
      var idseksi = $(".idseksi").val();
      // console.log(idseksi);
      if (idseksi == "Machining") {
        $("#simbolwarnaidentitasseksi").css({
          "background-color": "#ffff00",
          color: "#ffff00",
        });
      } else if (idseksi == "Gudang") {
        $("#simbolwarnaidentitasseksi").css({
          "background-color": "#cccccc",
          color: "#cccccc",
        });
      } else if (idseksi == "PnP") {
        $("#simbolwarnaidentitasseksi").css({
          "background-color": "#ff8080",
          color: "#ff8080",
        });
      } else if (idseksi == "Sheet Metal") {
        $("#simbolwarnaidentitasseksi").css({
          "background-color": "#94bd5e",
          color: "#94bd5e",
        });
      } else if (idseksi == "UPPL") {
        $("#simbolwarnaidentitasseksi").css({
          "background-color": "#ff00ff",
          color: "#ff00ff",
        });
      } else if (idseksi == "Perakitan") {
        $("#simbolwarnaidentitasseksi").css({
          "background-color": "#99ccff",
          color: "#99ccff",
        });
      } else if (idseksi == "Subkon") {
        $("#simbolwarnaidentitasseksi").css({
          "background-color": "#ffcc99",
          color: "#ffcc99",
        });
      }
    });
    $(".btn-save-proses").on("click", function () {
      var identitasseksi = $("#identitasseksi").val();
      var namaseksi = $("#namaseksi").val();
      var request = $.ajax({
        url: baseurl + "DbHandling/SetDataMaster/insertmasterprosesseksi",
        data: {
          identitasseksi: identitasseksi,
          namaseksi: namaseksi,
        },
        type: "POST",
        datatype: "html",
      });
      request.done(function (result) {
        $("#modaltambahmasterproseksi").modal("hide");
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Menambah Master Proses Seksi",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          var request = $.ajax({
            url: baseurl + "DbHandling/SetDataMaster/loadviewmasterproseksi",
            type: "POST",
            beforeSend: function () {
              $("div#tabel_masterpro_seksi").html(
                '<center><img style="width:100px; height:auto" src="' +
                  baseurl +
                  'assets/img/gif/loading11.gif"></center>'
              );
            },
          });
          request.done(function (result) {
            // console.log(result);
            $("div#tabel_masterpro_seksi").html(result);
          });
        });
      });
    });
  });
}
function editmasterprosesseksi(id) {
  var request = $.ajax({
    url: baseurl + "DbHandling/SetDataMaster/editmasterprosesseksi",
    data: {
      id: id,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#masterproseksiedit").html(result);
    $("#modaleditmasterproseksi").modal("show");
    $(".idseksii").select2({
      allowClear: true,
      minimumResultsForSearch: Infinity,
    });
    $(".idseksii").on("change", function () {
      var idseksi = $(".idseksii").val();
      // console.log(idseksi);
      if (idseksi == "Machining") {
        $("#simbolwarnaa").css({
          "background-color": "#ffff00",
          color: "#ffff00",
        });
      } else if (idseksi == "Gudang") {
        $("#simbolwarnaa").css({
          "background-color": "#cccccc",
          color: "#cccccc",
        });
      } else if (idseksi == "PnP") {
        $("#simbolwarnaa").css({
          "background-color": "#ff8080",
          color: "#ff8080",
        });
      } else if (idseksi == "Sheet Metal") {
        $("#simbolwarnaa").css({
          "background-color": "#94bd5e",
          color: "#94bd5e",
        });
      } else if (idseksi == "UPPL") {
        $("#simbolwarnaa").css({
          "background-color": "#ff00ff",
          color: "#ff00ff",
        });
      } else if (idseksi == "Perakitan") {
        $("#simbolwarnaa").css({
          "background-color": "#99ccff",
          color: "#99ccff",
        });
      } else if (idseksi == "Subkon") {
        $("#simbolwarnaa").css({
          "background-color": "#ffcc99",
          color: "#ffcc99",
        });
      }
    });
    $(".btn-save-proses-edit").on("click", function () {
      var identitasseksi = $("#identitasseksi2").val();
      var namaseksi = $("#seksieya").val();
      var id = $("#idmastprosseksi").val();
      var request = $.ajax({
        url: baseurl + "DbHandling/SetDataMaster/updatemasterprosesesseksi",
        data: {
          identitasseksi: identitasseksi,
          namaseksi: namaseksi,
          id: id,
        },
        type: "POST",
        datatype: "html",
      });
      request.done(function (result) {
        $("#modaleditmasterproseksi").modal("hide");
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Mengedit Master Proses Seksi",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          var request = $.ajax({
            url: baseurl + "DbHandling/SetDataMaster/loadviewmasterproseksi",
            type: "POST",
            beforeSend: function () {
              $("div#tabel_masterpro_seksi").html(
                '<center><img style="width:100px; height:auto" src="' +
                  baseurl +
                  'assets/img/gif/loading11.gif"></center>'
              );
            },
          });
          request.done(function (result) {
            // console.log(result);
            $("div#tabel_masterpro_seksi").html(result);
          });
        });
      });
    });
  });
}
function hapusmasterprosesseksi(id) {
  Swal.fire({
    title: "Apa Anda Yakin?",
    text: "Akan Menghapus Master Proses Seksi Ini ?",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#d73925",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  }).then((result) => {
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "DbHandling/SetDataMaster/hapusdatamasterproses",
        data: {
          id: id,
        },
        type: "POST",
        datatype: "html",
      });
      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Menghapus",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          var request = $.ajax({
            url: baseurl + "DbHandling/SetDataMaster/loadviewmasterproseksi",
            type: "POST",
            beforeSend: function () {
              $("div#tabel_masterpro_seksi").html(
                '<center><img style="width:100px; height:auto" src="' +
                  baseurl +
                  'assets/img/gif/loading11.gif"></center>'
              );
            },
          });
          request.done(function (result) {
            // console.log(result);
            $("div#tabel_masterpro_seksi").html(result);
          });
        });
      });
    }
  });
}
function tambahmasterstatkomp() {
  var request = $.ajax({
    url: baseurl + "DbHandling/SetDataMaster/tambahmasterstatkomp",
  });
  request.done(function (result) {
    $("#masterstatkompadd").html(result);
    $("#modaltambahmasterstatkomp").modal("show");
    $("#kodestat").on("keyup", function () {
      var kode = $("#kodestat").val();
      var request = $.ajax({
        url: baseurl + "DbHandling/SetDataMaster/checkkodestatkomp",
        data: {
          kode: kode,
        },
        type: "POST",
        datatype: "html",
      });

      request.done(function (result) {
        // console.log(result);
        if (result == 0) {
          $("#simbolverifykodee").html(
            '<i class="fa fa-check-square-o fa-2x" style="color:green;" ></i>'
          );
          $(".buttonsavestat").removeAttr("disabled");
          $("#kodestat").css("border-color", "");
          $("#keterangansimboll").css("display", "none");
        } else {
          $("#simbolverifykodee").html(
            '<i class="fa fa-ban fa-2x" style="color:red;" ></i>'
          );
          $(".buttonsavestat").attr("disabled", "disabled");
          $("#kodestat").css("border-color", "red");
          $("#keterangansimboll").css("display", "block");
        }
      });
    });
    $(".buttonsavestat").on("click", function () {
      var nama = $("#namastat").val();
      var kode = $("#kodestat").val();
      // console.log(namahandling, kodehandling, id);
      var request = $.ajax({
        url: baseurl + "DbHandling/SetDataMaster/addmasterstatkomp",
        data: {
          nama: nama,
          kode: kode,
        },
        type: "POST",
        datatype: "html",
      });
      request.done(function () {
        $("#modaltambahmasterstatkomp").modal("hide");
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Menambah Status Komponen",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          var request = $.ajax({
            url: baseurl + "DbHandling/SetDataMaster/loadviewmasterstatkomp",
            type: "POST",
            beforeSend: function () {
              $("div#tabel_masterstat_komp").html(
                '<center><img style="width:100px; height:auto" src="' +
                  baseurl +
                  'assets/img/gif/loading11.gif"></center>'
              );
            },
          });
          request.done(function (result) {
            $("div#tabel_masterstat_komp").html(result);
          });
        });
      });
    });
  });
}
function editmasterstatkomp(id) {
  var request = $.ajax({
    url: baseurl + "DbHandling/SetDataMaster/editmasterstatkomp",
    data: {
      id: id,
    },
    type: "POST",
    datatype: "html",
  });
  request.done(function (result) {
    $("#masterstatkompp").html(result);
    $("#modaleditmasterstatkom").modal("show");
    $("#kodestatedit").on("keyup", function () {
      var kode = $("#kodestatedit").val();
      var request = $.ajax({
        url: baseurl + "DbHandling/SetDataMaster/checkkodestatkomp2",
        data: {
          kode: kode,
          id: id,
        },
        type: "POST",
        datatype: "html",
      });

      request.done(function (result) {
        // console.log(result);
        if (result == 0) {
          $("#simbolverifykodeee").html(
            '<i class="fa fa-check-square-o fa-2x" style="color:green;" ></i>'
          );
          $(".buttonsavestatedit").removeAttr("disabled");
          $("#kodestatedit").css("border-color", "");
          $("#keterangansimbolll").css("display", "none");
        } else {
          $("#simbolverifykodeee").html(
            '<i class="fa fa-ban fa-2x" style="color:red;" ></i>'
          );
          $(".buttonsavestatedit").attr("disabled", "disabled");
          $("#kodestatedit").css("border-color", "red");
          $("#keterangansimbolll").css("display", "block");
        }
      });
    });
    $(".buttonsavestatedit").on("click", function () {
      var nama = $("#namastatedit").val();
      var kode = $("#kodestatedit").val();
      // console.log(namahandling, kodehandling, id);
      var request = $.ajax({
        url: baseurl + "DbHandling/SetDataMaster/updatestatkomp",
        data: {
          nama: nama,
          kode: kode,
          id: id,
        },
        type: "POST",
        datatype: "html",
      });
      request.done(function () {
        $("#modaleditmasterstatkom").modal("hide");
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Mengedit Status Komponen",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          var request = $.ajax({
            url: baseurl + "DbHandling/SetDataMaster/loadviewmasterstatkomp",
            type: "POST",
            beforeSend: function () {
              $("div#tabel_masterstat_komp").html(
                '<center><img style="width:100px; height:auto" src="' +
                  baseurl +
                  'assets/img/gif/loading11.gif"></center>'
              );
            },
          });
          request.done(function (result) {
            $("div#tabel_masterstat_komp").html(result);
          });
        });
      });
    });
  });
}
function deletestatkomp(id) {
  Swal.fire({
    title: "Apa Anda Yakin?",
    text: "Akan Menghapus Status Ini ?",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#d73925",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
  }).then((result) => {
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "DbHandling/SetDataMaster/deletestatkomp",
        data: {
          id: id,
        },
        type: "POST",
        datatype: "html",
      });
      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Menghapus",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          var request = $.ajax({
            url: baseurl + "DbHandling/SetDataMaster/loadviewmasterstatkomp",
            type: "POST",
            beforeSend: function () {
              $("div#tabel_masterstat_komp").html(
                '<center><img style="width:100px; height:auto" src="' +
                  baseurl +
                  'assets/img/gif/loading11.gif"></center>'
              );
            },
          });
          request.done(function (result) {
            $("div#tabel_masterstat_komp").html(result);
          });
        });
      });
    }
  });
}
// --------------------------------------------------- MondHand Seksi ----------------------------------------------
$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "DbHandlingSeksi/MonitoringHandling/loadviewreqhand",
    type: "POST",
    beforeSend: function () {
      $("div#tabel_reqhandseksi").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    // console.log(result);
    $("div#tabel_reqhandseksi").html(result);
  });
});
$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "DbHandlingSeksi/MonitoringHandling/loadviewreqhand2",
    type: "POST",
    beforeSend: function () {
      $("div#tabel_reqhandseksi2").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    // console.log(result);
    $("div#tabel_reqhandseksi2").html(result);
  });
});
$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "DbHandlingSeksi/MonitoringHandling/loadviewdatahand",
    type: "POST",
    beforeSend: function () {
      $("div#tabel_datahandseksi").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    // console.log(result);
    $("div#tabel_datahandseksi").html(result);
  });
});
$(document).ready(function () {
  $("#komponen_Seksi").select2({
    allowClear: true,
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "DbHandlingSeksi/MonitoringHandling/kodekomp",
      dataType: "json",
      type: "GET",
      data: function (params) {
        var queryParameters = {
          term: params.term,
        };
        return queryParameters;
      },
      processResults: function (data) {
        // console.log(data);
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.SEGMENT1 + "&" + obj.DESCRIPTION,
              text: obj.SEGMENT1 + " - " + obj.DESCRIPTION,
            };
          }),
        };
      },
    },
  });
});
$(document).ready(function () {
  $("#komponen_Seksi").on("change", function () {
    var value = $(this).val();
    var vall = value.split("&");
    $("#nam_komp_seksi").val(vall[1]);
    $("#komponen_Seksi2").val(vall[0]);
  });
  $("#komponen_Seksi").on("change", function () {
    var value = $(this).val();
    var vall = value.split("&");
    $.ajax({
      type: "POST",
      dataType: "json",
      data: { kode: vall[0] },
      url: baseurl + "DbHandlingSeksi/MonitoringHandling/cekKodeKomp",
      success: function (result) {
        // console.log(result);
        if (result == 0) {
          // console.log("tampilkan simbol success dan inputkan yg lain");
          $(".showkalaukompbelomadaseksi").css("display", "block");
          $(".hideajakalaukompudahadaseksi").css("display", "block");
          $("#validationkompseksi").css("display", "none");
          $("#btnrevseksi").css("display", "none");
        } else {
          // console.log("append tombol revisi");
          $(".showkalaukompbelomadaseksi").css("display", "none");
          $(".hideajakalaukompudahadaseksi").css("display", "none");
          $("#validationkompseksi").css("display", "block");
          $("#btnrevseksi").css("display", "block");
          $("#btnrevseksi").on("click", function () {
            revisidatahandling2(result);
          });
        }
      },
    });
  });
});
$(document).ready(function () {
  $(".Stat_Komp_seksi").select2({
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
      url: baseurl + "DbHandlingSeksi/MonitoringHandling/statuskomp",
      dataType: "json",
      type: "GET",
      data: function (params) {
        var queryParameters = {
          term: params.term,
        };
        return queryParameters;
      },
      processResults: function (data) {
        // console.log(data);
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.id_status_komponen,
              text: obj.kode_status + " - " + obj.status,
            };
          }),
        };
      },
    },
  });
});
$(document).ready(function () {
  $("#produk_seksi").select2({
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
      url: baseurl + "DbHandlingSeksi/MonitoringHandling/suggestproduk",
      dataType: "json",
      type: "GET",
      data: function (params) {
        var queryParameters = {
          term: params.term,
        };
        return queryParameters;
      },
      processResults: function (data) {
        // console.log(data);
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.FLEX_VALUE + "-" + obj.DESCRIPTION,
              text: obj.FLEX_VALUE + " - " + obj.DESCRIPTION,
            };
          }),
        };
      },
    },
  });
});
$(document).ready(function () {
  $("#Sar_Hand_Seksi").select2({
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
      url: baseurl + "DbHandlingSeksi/MonitoringHandling/suggestsarana",
      dataType: "json",
      type: "GET",
      data: function (params) {
        var queryParameters = {
          term: params.term,
        };
        return queryParameters;
      },
      processResults: function (data) {
        // console.log(data);
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.id_master_handling,
              text: obj.kode_handling + " - " + obj.nama_handling,
            };
          }),
        };
      },
    },
  });
});
$(document).ready(function () {
  $(".Pro_seksi").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });
});
$(document).ready(function () {
  $("#Pro_seksi").on("change", function () {
    var pro = $("#Pro_seksi").val();
    if (pro == "Linear") {
      $("#iflinier").css("display", "block");
      $("#ifnonlinier").css("display", "none");
      $("#Id_S_eksi0").removeAttr("disabled");
      $("#pros_s_eksi0").removeAttr("disabled");
      $("#gmbr0").removeAttr("disabled");
      $("#pros_n_linear").attr("disabled", "disabled");
      $("#fotohandlingnonlinier0").attr("disabled", "disabled");
    } else {
      $("#ifnonlinier").css("display", "block");
      $("#iflinier").css("display", "none");
      $("#Id_S_eksi0").attr("disabled", "disabled");
      $("#pros_s_eksi0").attr("disabled", "disabled");
      $("#gmbr0").attr("disabled", "disabled");
      $("#pros_n_linear").removeAttr("disabled");
      $("#fotohandlingnonlinier0").removeAttr("disabled");
    }
  });
});
var a = 0;
function appendfoto() {
  $(".inp_Foto").css("display", "none");

  var i = $('[name="u_fotohandlinglinier[]"').length + 1;

  a++;
  $("#inputgambarnew").append(
    '<span id="hahaha' +
      a +
      '"><div class="panel-body"><input type="hidden" name="u_gambar[]" value="' +
      a +
      '"/><div class="col-md-3" style="text-align: right;color:white"><label>Foto</label></div><div class="col-md-1" style="text-align: right;"><input class="form-control" readonly  name="u_fotohandlinglinier[]" value="' +
      i +
      '" /></div><div class="col-md-5"><input id="gmbr' +
      a +
      '" type="file" class="form-control" accept=".jpg, .png, ,jpeg" name="fotohandlinglinier[]" /></div><div class="col-md-1" style="text-align: right;"><a class="btn btn-danger btnminuss"><i class="fa fa-minus"></i></a></div></div><div class="panel-body "><div class="col-md-3" style="text-align: right;color:white"><label>Foto</label></div><div class="col-md-1" style="text-align: right;"></div><div class="col-md-5"><img style="width:100%" id="prevFoto' +
      a +
      '"></div></div></span>'
  );
  $(document).on("click", ".btnminuss", function () {
    $("#iflinier")
      .find('[name="u_fotohandlinglinier[]"]')
      .each(function (i, v) {
        $(this).val(i + 1);
      });
    var row = Number(
      $(this).parents(".panel-body").find('[name="u_gambar[]"]').val()
    );
    // console.log(row);
    $("#hahaha" + row).remove();
  });
  $("#gmbr" + a).on("change", function () {
    $(".inp_Foto").css("display", "");
    viewGambar(this, a);
  });
}
function viewGambar(input, a) {
  // console.log(a);
  var sizee = (input.files[0].size / 1024 / 1024).toFixed(2);

  if (sizee > 2) {
    Swal.fire({
      type: "error",
      title: "Ukuran gambar tidak bisa lebih dari 2 MB",
    }).then(() => {
      $("#gmbr" + a).val("");
    });
  } else {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#prevFoto" + a).attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
}
$(document).ready(function () {
  $(".Id_S_eksi").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });
});
function getSeksiandprev(i) {
  var value = $("#Id_S_eksi" + i).val();
  // console.log(value);
  $("#pros_s_eksi" + i).select2("val", null);
  $("#pros_s_eksi" + i).prop("disabled", true);
  $.ajax({
    type: "POST",
    data: { segment1: value },
    url: baseurl + "DbHandling/MonitoringHandling/form",
    success: function (result) {
      if (result != "<option></option>") {
        $("#pros_s_eksi" + i)
          .prop("disabled", false)
          .html(result);
      } else {
      }
    },
  });
  $("#pros_s_eksi" + i).on("change", function () {
    var proses = $("#pros_s_eksi" + i).val();
    var id = $("#Id_S_eksi" + i).val();
    $("#textt" + i).html(proses);

    if (id == "Machining") {
      $("#kotak_proses" + i).css({
        "background-color": "#ffff00",
      });
      $("#warnaea" + i).css({
        "background-color": "#ffff00",
        color: "#ffff00",
      });
    } else if (id == "Gudang") {
      $("#kotak_proses" + i).css({
        "background-color": "#cccccc",
      });
      $("#warnaea" + i).css({
        "background-color": "#cccccc",
        color: "#cccccc",
      });
    } else if (id == "PnP") {
      $("#kotak_proses" + i).css({
        "background-color": "#ff8080",
      });
      $("#warnaea" + i).css({
        "background-color": "#ff8080",
        color: "#ff8080",
      });
    } else if (id == "Sheet Metal") {
      $("#kotak_proses" + i).css({
        "background-color": "#94bd5e",
      });
      $("#warnaea" + i).css({
        "background-color": "#94bd5e",
        color: "#94bd5e",
      });
    } else if (id == "UPPL") {
      $("#kotak_proses" + i).css({
        "background-color": "#ff00ff",
      });
      $("#warnaea" + i).css({
        "background-color": "#ff00ff",
        color: "#ff00ff",
      });
    } else if (id == "Perakitan") {
      $("#kotak_proses" + i).css({
        "background-color": "#99ccff",
      });
      $("#warnaea" + i).css({
        "background-color": "#99ccff",
        color: "#99ccff",
      });
    } else if (id == "Subkon") {
      $("#kotak_proses" + i).css({
        "background-color": "#ffcc99",
      });
      $("#warnaea" + i).css({
        "background-color": "#ffcc99",
        color: "#ffcc99",
      });
    }
  });
}
var o = 1;
function iflinear() {
  o += 1;
  $(".btnplus").css("display", "none");
  no = $('[name="u_proses[]"').length + 1;
  $(".addhere").append(
    '<div class="panel-body"><div class="col-md-3" style="text-align: right;color:white"><label>Proses</label></div><div class="col-md-8" style="text-align: left;"><div class="col-md-2"><input type="text" class="form-control" name="u_proses[]" readonly="readonly" value="' +
      no +
      '" /></div><div class="col-md-4"><select onchange="getSeksiandprev(' +
      o +
      ')" style="width: 100%;" class="form-control select2 Id_S_eksi" id="Id_S_eksi' +
      o +
      '" name="Id_S_eksi[]" data-placeholder="Identitas Seksi"><option></option><option value="UPPL">UPPL</option><option value="Sheet Metal">Sheet Metal</option><option value="Machining">Machining</option><option value="Perakitan">Perakitan</option><option value="PnP">PnP</option><option value="Gudang">Gudang</option><option value="Subkon">Subkon</option></select></div><div class="col-md-1"><div id="warnaea' +
      o +
      '" style="background-color: white;color:white;font-size:14pt;padding:2px;">A</div></div><div class="col-md-4"><select style="width: 100%;" class="form-control select2 pros_s_eksi" name="pros_s_eksi[]" disabled id="pros_s_eksi' +
      o +
      '" data-placeholder="Proses Seksi"><option></option></select></div><div class="col-md-1"><a class="btn btn-danger btn-hapus-ajah' +
      o +
      '"><i class="fa fa-minus"></i></a></div></div></div>'
  );
  $("#prevPros").append(
    '<div id="arrowss' +
      o +
      '" style="display: inline-block;"><div style="height:75px; margin:20px;text-align:center;padding: 20px 0;"><i class="fa fa-arrow-right fa-2x"></i></div></div><div id="kotakk' +
      o +
      '" style="display: inline-block;"><div id="kotak_proses' +
      o +
      '" style="border: 1px solid black;margin:10px;text-align:center;padding: 10px 0;"><p style="margin:10px" id="textt' +
      o +
      '"></p></div></div>'
  );
  $(".Id_S_eksi").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });
  $(".pros_s_eksi").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });
  $(document).on("click", ".btn-hapus-ajah" + o, function () {
    $(this).parents(".panel-body").remove();
    $(".addhere")
      .find('[name="u_proses[]"]')
      .each(function (i, v) {
        $(this).val(i + 1);
      });
    $("#arrowss" + o).remove();
    $("#kotak_proses" + o).remove();
  });
}
function viewprosnonlinier(input) {
  var sizee = (input.files[0].size / 1024 / 1024).toFixed(2);

  if (sizee > 2) {
    Swal.fire({
      type: "error",
      title: "Ukuran gambar tidak bisa lebih dari 2 MB",
    }).then(() => {
      $("#pros_n_linear").val("");
    });
  } else {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#prev_proses_n_linear").attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
}
var c = 0;
function append_foto_non_linear() {
  $(".inp_foto_non_linear").css("display", "none");
  var p = $('[name="u_fotohandlingnonlinier[]"').length + 1;
  c++;
  $("#appendinputfotononlinier").append(
    '<span id="hehehe' +
      c +
      '"><div class="panel-body"><input type="hidden" value="' +
      c +
      '" name="inputgambarnonlinier[]"/><div class="col-md-3" style="text-align: right;color:white"><label>Foto</label></div><div class="col-md-1" style="text-align: right;"><input class="form-control" readonly name="u_fotohandlingnonlinier[]" value="' +
      p +
      '" /></div><div class="col-md-5"><input type="file" class="form-control" accept=".jpg, .png, ,jpeg" name="fotohandlingnonlinier[]" id="fotohandlingnonlinier' +
      c +
      '" /></div><div class="col-md-1" style="text-align: right;"><a class="btn btn-danger btnminusss"><i class="fa fa-minus"></i></a></div></div><div class="panel-body"><div class="col-md-3" style="text-align: right; color:white"><label>Foto</label></div><div class="col-md-1" style="text-align: right;"></div><div class="col-md-5"><img style="width:100%" id="prevFotoNonLinear' +
      c +
      '"></div></div></span>'
  );
  $(document).on("click", ".btnminusss", function () {
    $("#ifnonlinier")
      .find('[name="u_fotohandlingnonlinier[]"]')
      .each(function (i, v) {
        $(this).val(i + 1);
      });
    var row = Number(
      $(this)
        .parents(".panel-body")
        .find('[name="inputgambarnonlinier[]"]')
        .val()
    );
    // console.log(row);
    $("#hehehe" + row).remove();
  });
  $("#fotohandlingnonlinier" + c).on("change", function () {
    $(".inp_foto_non_linear").css("display", "");

    viewGambarnonlinier(this, c);
  });
}
function viewGambarnonlinier(input, a) {
  // console.log(a);
  var sizee = (input.files[0].size / 1024 / 1024).toFixed(2);

  if (sizee > 2) {
    Swal.fire({
      type: "error",
      title: "Ukuran gambar tidak bisa lebih dari 2 MB",
    }).then(() => {
      $("#fotohandlingnonlinier" + a).val("");
    });
  } else {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#prevFotoNonLinear" + a).attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
}
function slideshow(id) {
  var proses = $("#prosesHand" + id).val();
  var request = $.ajax({
    url: baseurl + "DbHandlingSeksi/MonitoringHandling/imgcarousel",
    data: {
      id: id,
      proses: proses,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#fotodisini").html(result);
    $("#mdl-carousel").modal("show");
  });
}
function showproses(id) {
  var proses = $("#prosesHand" + id).val();
  var request = $.ajax({
    url: baseurl + "DbHandlingSeksi/MonitoringHandling/proseshandling",
    data: {
      id: id,
      proses: proses,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#IniProsesnya").html(result);
    $("#ModalPros").modal("show");
  });
}
function slideshoww(id) {
  var proses = $("#proseshandlinggg" + id).val();
  var request = $.ajax({
    url: baseurl + "DbHandlingSeksi/MonitoringHandling/imgcarousel",
    data: {
      id: id,
      proses: proses,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#slidedhow").html(result);
    $("#mdl-slide").modal("show");
  });
}
function prosesshow(id) {
  var proses = $("#proseshandlinggg" + id).val();
  var request = $.ajax({
    url: baseurl + "DbHandlingSeksi/MonitoringHandling/proseshandling",
    data: {
      id: id,
      proses: proses,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#prosesea").html(result);
    $("#mdl-proses").modal("show");
  });
}
