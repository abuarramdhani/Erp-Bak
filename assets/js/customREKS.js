$(document).ready(function () {
  var view = document.getElementById(
    "View_Create_Rekap_Data_Ekspedisi_Express"
  );
  if (view) {
    // $("#TblViewRekapEkspedisi").dataTable({
    //   paging: false,
    //   info: false,
    //   scrollCollapse: true,
    //   scrollX: true,
    //   searching: false,
    // });
    $("#tanggal_express").datepicker({
      format: "dd/mm/yyyy",
      autoclose: true,
    });
    $("#nomor_ekspedisi_express").select2({
      // allowClear: true,
      minimumInputLength: 2,
      ajax: {
        url: baseurl + "ReportEkspedisi/CreateReport/getNoSPBOSP",
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
                id: obj.NUMBER_NYAA,
                text: obj.NUMBER_NYAA,
              };
            }),
          };
        },
      },
    });
  }
});

function SPBorDOSP() {
  var value = $("#jenis_nomor_ekspedisi_express").val();

  if (value == "SPB") {
    var link = "getListNumSPB";
  } else {
    var link = "getListNumDOSP";
  }

  $("#nomor_ekspedisi_express").select2({
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
      url: baseurl + "ReportEkspedisi/CreateReport/" + link,
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
              id: obj.NUMBER_NYAA,
              text: obj.NUMBER_NYAA,
            };
          }),
        };
      },
    },
  });
}

function LastKlikedButonnn(a) {
  $("#LastKlikedButon").val(a);
}
function ChgEkspedisi() {
  var eks = $("#ekspedisi_express").val();
  $("#name_ekspedisi_express").val(eks);
}
$(".FormSubmitDataRekapEkspedisi").on("submit", function (e) {
  e.preventDefault();
  $("#ekspedisi_express").attr("disabled", "disabled");

  var getLasKlikedButton = $("#LastKlikedButon").val();
  var resi_express = $("#resi_express").val();
  var tanggal_express = $("#tanggal_express").val();
  var nomor_ekspedisi_express = $("#nomor_ekspedisi_express").val();
  var collynya_express = $("#collynya_express").val();
  var beratnya_express = $("#beratnya_express").val();
  var eks = $("#name_ekspedisi_express").val();

  // console.log(weigh);

  if (eks == "SADANA") {
    if (beratnya_express < 400 || beratnya_express == 400) {
      var sisa = beratnya_express - 10;
      var biaya = 50000 + sisa * 850;
    } else {
      var biaya = beratnya_express * 850;
    }
  } else if (eks == "JPM") {
    if (beratnya_express < 100 || beratnya_express == 100) {
      var sisa = beratnya_express - 10;
      var biaya = 50000 + sisa * 850;
    } else {
      var biaya = beratnya_express * 850;
    }
  } else if (eks == "TAM") {
    var biaya = beratnya_express * 850;
  }

  if (getLasKlikedButton == 1) {
    $.ajax({
      url: baseurl + "ReportEkspedisi/CreateReport/GetDatatoAppend",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        if (response[0]["TYPE"] == "SPB") {
          $("#AppendRowRekapEkspedisi").append(
            '<tr id="RowToeleteExpress' +
              response["URUTAN_RANDOM"] +
              '"><td class="text-center"><input type="hidden" name="index_express[]" value="' +
              response[0]["URUTAN_RANDOM"] +
              '">' +
              tanggal_express +
              '<input type="hidden" name="DateKirimExpress[]" value="' +
              tanggal_express +
              '"><input type="hidden" name="jenis_no_express[]" value="' +
              response[0]["TYPE"] +
              '"></td><td class="text-center">' +
              resi_express +
              '<input type="hidden" name="no_resi_express[]" value="' +
              resi_express +
              '"></td><td class="text-center"><input type="hidden" name="cost_center_express[]" value="' +
              response[0]["COST_CENTER"] +
              '">' +
              response[0]["COST_CENTER"] +
              '</td><td class="text-center"><input type="hidden" name="relasi_express[]" value="' +
              response[0]["EXPEDISI"] +
              '">' +
              response[0]["EXPEDISI"] +
              '<input type="hidden" name="relasi_id_express[]" value="' +
              response[0]["EXP_ID"] +
              '"></td><td class="text-center"><input type="hidden" name="tujuan_express[]" value="' +
              response[0]["CITY"] +
              '">' +
              response[0]["CITY"] +
              '</td><td class="text-center" id="no_express' +
              response[0]["URUTAN_RANDOM"] +
              '">SPB ' +
              response[0]["SPB_DOSP"] +
              '<input type="hidden" id="i_no_express' +
              response[0]["URUTAN_RANDOM"] +
              '" name="no_express[]" value="' +
              response[0]["SPB_DOSP"] +
              '"></td><td class="text-center">' +
              collynya_express +
              '<input type="hidden" name="colly_express[]" value="' +
              collynya_express +
              '"></td><td class="text-center">' +
              beratnya_express +
              '<input type="hidden" name="berat_express[]" value="' +
              beratnya_express +
              '"></td><td class="text-center">' +
              biaya +
              '<input type="hidden" name="biaya_express[]" value="' +
              biaya +
              '"></td><td class="text-center"><button class="btn btn-danger" onclick="DeleteExpress(' +
              response["URUTAN_RANDOM"] +
              ')">Delete</button></td></tr>'
          );
        } else {
          $("#AppendRowRekapEkspedisi").append(
            '<tr id="RowToeleteExpress' +
              response["URUTAN_RANDOM"] +
              '"><td class="text-center"><input type="hidden" name="index_express[]" value="' +
              response[0]["URUTAN_RANDOM"] +
              '">' +
              tanggal_express +
              '<input type="hidden" name="DateKirimExpress[]" value="' +
              tanggal_express +
              '"><input type="hidden" name="jenis_no_express[]" value="' +
              response[0]["TYPE"] +
              '"></td><td class="text-center">' +
              resi_express +
              '<input type="hidden" name="no_resi_express[]" value="' +
              resi_express +
              '"></td><td class="text-center"><input type="hidden" name="cost_center_express[]" value="' +
              response[0]["TUJUAN"] +
              '">' +
              response[0]["TUJUAN"] +
              '</td><td class="text-center"><input type="hidden" name="relasi_express[]" value="' +
              response[0]["PARTY_NAME"] +
              '">' +
              response[0]["PARTY_NAME"] +
              '<input type="hidden" name="relasi_id_express[]" value="' +
              response[0]["EXP_ID"] +
              '"></td><td class="text-center"><input type="hidden" name="tujuan_express[]" value="' +
              response[0]["CITY"] +
              '">' +
              response[0]["CITY"] +
              '</td><td class="text-center" id="no_express' +
              response[0]["URUTAN_RANDOM"] +
              '">DOSP ' +
              response[0]["SPB_DOSP"] +
              '<input type="hidden" id="i_no_express' +
              response[0]["URUTAN_RANDOM"] +
              '" name="no_express[]" value="' +
              response[0]["SPB_DOSP"] +
              '"></td><td class="text-center">' +
              collynya_express +
              '<input type="hidden" name="colly_express[]" value="' +
              collynya_express +
              '"></td><td class="text-center">' +
              beratnya_express +
              '<input type="hidden" name="berat_express[]" value="' +
              beratnya_express +
              '"></td><td class="text-center">' +
              biaya +
              '<input type="hidden" name="biaya_express[]" value="' +
              biaya +
              '"></td><td class="text-center"><button class="btn btn-danger" onclick="DeleteExpress(' +
              response["URUTAN_RANDOM"] +
              ')">Delete</button></td></tr>'
          );
        }
        $("#resi_express").val("");
        $("#tanggal_express").val("");
        $("#nomor_ekspedisi_express").select2("val", "");
        $("#collynya_express").val("");
        $("#beratnya_express").val("");
      },
    });
  } else {
    $.ajax({
      url: baseurl + "ReportEkspedisi/CreateReport/ExpInsert",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      dataType: "html",
      success: function (response) {
        window.location.href = baseurl + response;
      },
    });
  }
});
function hitungExpress(a) {
  var eks = $("#name_ekspedisi_express").val();
  var weigh = $("#berat_express" + a).val();

  // console.log(weigh);

  if (eks == "SADANA") {
    if (weigh < 400 || weigh == 400) {
      var sisa = weigh - 10;
      var biaya = 50000 + sisa * 850;
    } else {
      var biaya = weigh * 850;
    }
    $("#biaya_express" + a).val(biaya);
  } else if (eks == "JPM") {
    if (weigh < 100 || weigh == 100) {
      var sisa = weigh - 10;
      var biaya = 50000 + sisa * 850;
    } else {
      var biaya = weigh * 850;
    }
    $("#biaya_express" + a).val(biaya);
  } else if (eks == "TAM") {
    var biaya = weigh * 850;

    $("#biaya_express" + a).val(biaya);
  }
}
function DeleteExpress(i) {
  $("#RowToeleteExpress" + i).remove();
}
function DeleteDataExpress(i) {
  $("#RowAPus" + i).remove();
  $.ajax({
    url: baseurl + "ReportEkspedisi/HistoryReport/DeleteDataExpres",
    type: "POST",
    data: { data_id: i },
    dataType: "html",
    success: function (response) {},
  });
}
$(".FormEditDataRekapEkspedisi").on("submit", function (e) {
  e.preventDefault();

  var getLasKlikedButton = $("#LastKlikedButon").val();

  if (getLasKlikedButton == 1) {
    $.ajax({
      url: baseurl + "ReportEkspedisi/CreateReport/GetDatatoAppendEdit",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#AppendRowRekapEkspedisi").append(
          ' <tr id="RowAPus' +
            response[0]["DATA_ID"] +
            '"><td class="text-center">' +
            response[0]["TANGGAL_RESI"] +
            '<input type="hidden" name="DataIDExpress[]" value="' +
            response[0]["DATA_ID"] +
            '"></td><td class="text-center">' +
            response[0]["NO_RESI"] +
            '</td><td class="text-center">' +
            response[0]["COST_CENTER"] +
            '</td><td class="text-center">' +
            response[0]["RELASI"] +
            '</td><td class="text-center">' +
            response[0]["CITY"] +
            '</td><td class="text-center"> ' +
            response[0]["INDEX_TYPE"] +
            " " +
            response[0]["NOMOR"] +
            '</td><td class="text-center">' +
            response[0]["COLLY"] +
            '</td><td class="text-center">' +
            response[0]["QTY"] +
            '</td><td class="text-center">' +
            response[0]["BIAYA"] +
            '</td><td class="text-center"><a class="btn btn-danger" onclick="DeleteDataExpress(' +
            response[0]["DATA_ID"] +
            ')">Delete</a></td></tr>'
        );
      },
    });
  } else {
    $.ajax({
      url: baseurl + "ReportEkspedisi/HistoryReport/ExpInsert2",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      dataType: "html",
      success: function (response) {
        window.location.href = baseurl + response;
      },
    });
  }
});
