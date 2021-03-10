var i = 1;
function addRowPeriodicalMaintenance() {
  var namaMesin = $("#mesinPME").val();
  var kondisiMesin = $("#kondisi_mesin").val();
  var header = $("#header").val();
  var uraianKerja = $("#uraian_kerja").val();
  var standar = $("#standar").val();
  var periode = $("#periode").val();

  if (
    namaMesin === null ||
    kondisiMesin === null ||
    uraianKerja === null ||
    standar === null ||
    periode === null
  ) {
    swal.fire("Alert", "Isi data dengan lengkap", "error");
  } else {
    $("#tbodyPeriodicalMaintenance").append(
      '<tr class="clone"><td><input type="text" name="nama_mesin[]" value="' +
        namaMesin +
        '" readonly class="form-control"></td><td><input type="text" name="kondisi_mesin[]" value="' +
        kondisiMesin +
        '" readonly class="form-control"></td><td><input type="text" name="header[]" value="' +
        header +
        '" readonly class="form-control"></td><td><input type="text" name="uraian_kerja[]" value="' +
        uraianKerja +
        '" readonly class="form-control"></td><td><input type="text" name="standar[]" value="' +
        standar +
        '" readonly class="form-control"></td><td><input type="text" name="periode[]" value="' +
        periode +
        '" readonly class="form-control"></td><td><button onclick="Alert()" type="button" class="btn btn-md btn-danger btnRemoveUserResponsibility"><i class="fa fa-trash"></i></button></td></tr>'
    );

    document.getElementById("uraian_kerja").value = "";
    document.getElementById("standar").value = "";
    i++;
  }
}

$("#btnResetPME").click(function() {
  // $("#formInputPME")[0].reset();

  $(".select4")
    .val("")
    .trigger("change");
  $(".select2")
    .val("")
    .trigger("change");
  $("#lokasiPME").val("");
  $("#lantaiPME").val("");
  $("#areaPME").val("");
  $("#mesinPME").val("");
  $("#kondisi_mesin").val("");
  $("#header").val("");
  $("#uraian_kerja").val("");
  $("#standar").val("");
  $("#periode").val("");

  $("#lokasiPME").removeAttr("disabled");
  $("#lantaiPME").prop("disabled", true);
  $("#areaPME").prop("disabled", true);
  $("#mesinPME").prop("disabled", true);

  return false; 
});

function Alert() {
  Swal.fire({
    type: "success",
    title: "Data has been deleted!",
    showConfirmButton: false,
    timer: 1500
  });
}

function getPME(th) {
  $(document).ready(function() {
    var mesin = $('select[name="list_mesin"]').val();

    console.log(mesin);

    var request = $.ajax({
      url: baseurl + "PeriodicalMaintenance/Management/search",
      data: {
        mesin: mesin
      },
      type: "POST",
      datatype: "html"
    });
    $("#ResultPME").html("");
    $("#ResultPME").html(
      '<center><img style="width:100px; height:auto" src="' +
        baseurl +
        'assets/img/gif/loading14.gif"></center>'
    );

    request.done(function(result) {
      // console.log("sukses2");
      $("#ResultPME").html(result);

      $("#tablePME").DataTable({
        scrollX: true,
        scrollY: 400,
        scrollCollapse: true,
        paging: false,
        info: true,
        ordering: false
      });
    });
  });
}

function getDetailPME(th, no) {
  var title = $(th).text();
  $("#detail" + no).slideToggle("slow");
}

function editRowPME(id) {
  // console.log(id);
  var request = $.ajax({
    url: baseurl + "PeriodicalMaintenance/Management/editSubManagement",
    data: {
      id: id
    },
    type: "POST",
    datatype: "html"
  });

  request.done(function(result) {
    // console.log(result);
    $("#subManagementEdit").html(result);
    $("#modalEditManagement").modal("show");

    $(".button-save-edit").on("click", function() {
      var subHeader = $("#subHeaderEdit").val();
      var standar = $("#standarEdit").val();
      var periode = $("#periodeEdit").val();

      var id = $("#idRowEdit").val();
      console.log(subHeader, standar, periode);
      var request = $.ajax({
        url: baseurl + "PeriodicalMaintenance/Management/updateSubManagement",
        data: {
          subHeader: subHeader,
          standar: standar,
          periode: periode,
          id: id
        },
        type: "POST",
        datatype: "html"
      });
      request.done(function() {
        $("#modalEditManagement").modal("hide");
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Mengedit Uraian Kerja",
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          var mesin = $('select[name="list_mesin"]').val();
          var request = $.ajax({
            url: baseurl + "PeriodicalMaintenance/Management/search",
            data: {
              mesin: mesin
            },
            type: "POST",
            beforeSend: function() {
              $("div#ResultPME").html(
                '<center><img style="width:100px; height:auto" src="' +
                  baseurl +
                  'assets/img/gif/loading14.gif"></center>'
              );
            }
          });
          request.done(function(result) {
            $("div#ResultPME").html(result);
          });
        });
      });
    });
  });
}

function deleteRowPME(id) {
  Swal.fire({
    title: "Apa Anda Yakin?",
    text: "Akan Menghapus Uraian Kerja ini ?",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#d73925",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak"
  }).then(result => {
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "PeriodicalMaintenance/Management/deleteSubManagement",
        data: {
          id: id
        },
        type: "POST",
        datatype: "html"
      });
      request.done(function(result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Menghapus",
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          var mesin = $('select[name="list_mesin"]').val();
          var request = $.ajax({
            url: baseurl + "PeriodicalMaintenance/Management/search",
            data: {
              mesin: mesin
            },
            type: "POST",
            beforeSend: function() {
              $("div#ResultPME").html(
                '<center><img style="width:100px; height:auto" src="' +
                  baseurl +
                  'assets/img/gif/loading14.gif"></center>'
              );
            }
          });
          request.done(function(result) {
            $("div#ResultPME").html(result);
          });
        });
      });
    }
  });
}

//

$("#lokasiPME").change(function() {
  var value = $(this).val();
  console.log(value);
  $("#lantaiPME").select2("val", null);
  $("#lantaiPME").prop("disabled", true);
  // $("#loadingLokasi").show();
  if ($("#lokasiPME").val() !== "" && $("#lokasiPME").val() !== null) {
    $("#loadingLokasi").html(
      '<center><img style="width:50px; height:auto" src="' +
        baseurl +
        'assets/img/gif/loading5.gif"></center>'
    );
  }
  
  $.ajax({
    type: "POST",
    data: { lokasi: value },
    url: baseurl + "PeriodicalMaintenance/Input/getLantai",
    success: function(result) {
      if (result != "<option></option>") {
        // $("#lantaiPME").removeAttr('disabled').html(result);
        // $("#loadingLokasi").hide();
        $("#loadingLokasi").html("");
        $("#lantaiPME")
          .prop("disabled", false)
          .html(result);
      } else {
      }
    }
  });
});

$("#lantaiPME").change(function() {
  var lokasi = $("#lokasiPME").val();
  var value = $(this).val();
  console.log(value);
  $("#areaPME").select2("val", null);
  $("#areaPME").prop("disabled", true);
  // $("#loadingLantai").show();
  if ($("#lantaiPME").val() !== "" && $("#lantaiPME").val() !== null) {
    $("#loadingLantai").html(
      '<center><img style="width:50px; height:auto" src="' +
        baseurl +
        'assets/img/gif/loading5.gif"></center>'
    );
  }
  
  $.ajax({
    type: "POST",
    data: {
      lokasi: lokasi,
      lantai: value
    },
    url: baseurl + "PeriodicalMaintenance/Input/getArea",
    success: function(result) {
      if (result != "<option></option>") {
        // $("#loadingLantai").hide();
        $("#loadingLantai").html("");
        $("#areaPME")
          .prop("disabled", false)
          .html(result);
      } else {
      }
    }
  });
});

$("#areaPME").change(function() {
  var lokasi = $("#lokasiPME").val();
  var lantai = $("#lantaiPME").val();
  var value = $(this).val();
  console.log(value);
  $("#mesinPME").select2("val", null);
  $("#mesinPME").prop("disabled", true);
  // $("#loadingAreaPME").show();
  if ($("#areaPME").val() !== "" && $("#areaPME").val() !== null) {
    $("#loadingAreaPME").html(
      '<center><img style="width:50px; height:auto" src="' +
        baseurl +
        'assets/img/gif/loading5.gif"></center>'
    );
  }
  $.ajax({
    type: "POST",
    data: {
      lokasi: lokasi,
      lantai: lantai,
      area: value
    },
    url: baseurl + "PeriodicalMaintenance/Input/getMesin",
    success: function(result) {
      if (result != "<option></option>") {
        // $("#loadingAreaPME").hide();
        $("#loadingAreaPME").html("");
        $("#mesinPME")
          .prop("disabled", false)
          .html(result);
      } else {
      }
    }
  });
});

$("#mesinPME").change(function() {
  var value = $(this).val();
  console.log(value);
  if ($("#mesinPME").val() !== null) {
    $("#lokasiPME").prop("disabled", true);
    $("#lantaiPME").prop("disabled", true);
    $("#areaPME").prop("disabled", true);
    $("#mesinPME").prop("disabled", true);
  }

  var request = $.ajax({
    url: baseurl + "PeriodicalMaintenance/Input/getDataPrevious",
    data: {
      mesin: value
    },
    type: "POST",
    datatype: "html"
  });

  request.done(function(result) {
    console.log(result);
    $("#tbodyPreviousMPE").html(result);
    $("#tbodyPreviousMPE").fadeIn();
  });
});

function getCetak(th) {
  $(document).ready(function() {
    var tanggal = $("#tglCek").val();
    var mesin = $('select[name="list_mesin"]').val();

    console.log(mesin);

    var request = $.ajax({
      url: baseurl + "PeriodicalMaintenance/Monitoring/printForm",
      data: {
        tanggal: tanggal,
        mesin: mesin
      },
      type: "POST",
      datatype: "html"
    });
  });
}

$("#tglCek").change(function() {
  var value = $(this).val();
  console.log(value);
  $("#mesinMon").prop("disabled", true);
  if ($("#tglCek").val() !== "" && $("#tglCek").val() !== null) {
    $("#loadingTanggalPME").html(
      '<center><img style="width:100%; height:auto" src="' +
        baseurl +
        'assets/img/gif/loading5.gif"></center>'
    );
  }

  $.ajax({
    type: "POST",
    data: { date: value },
    url: baseurl + "PeriodicalMaintenance/Monitoring/getMesinByDate",
    success: function(result) {
      if (result != "<option></option>") {
        // $("#lantaiPME").removeAttr('disabled').html(result);
        $("#loadingTanggalPME").html("");
        $("#mesinMon")
          .prop("disabled", false)
          .html(result);
      } else {
        $("#loadingTanggalPME").html("");
        swal.fire("404", "Data pengecekan untuk tanggal ini tidak tersedia!", "error");
      }
    }
  });
});

function getPMEMon(th) {
  $(document).ready(function() {
    // var tanggal = $('input[name="tglCek"]').val();
    var tanggal = $("#tglCek").val();
    var mesin = $('select[name="mesinMon"]').val();

    console.log(tanggal, mesin);

    var request = $.ajax({
      url: baseurl + "PeriodicalMaintenance/Monitoring/searchMon",
      data: {
        tanggal: tanggal,
        mesin: mesin
      },
      type: "POST",
      datatype: "html"
    });
    $("#ResultPMEMon").html("");
    $("#ResultPMEMon").html(
      '<center><img style="width:100px; height:auto" src="' +
        baseurl +
        'assets/img/gif/loading14.gif"></center>'
    );

    request.done(function(result) {
      // console.log("sukses2");
      $("#ResultPMEMon").html(result);

      $("#tablePMEMon").DataTable({
        scrollX: true,
        scrollY: 400,
        scrollCollapse: true,
        paging: false,
        info: true,
        ordering: false
      });
    });
  });
}

function getDetailPMEMon(th, no) {
  var title = $(th).text();
  $("#detail" + no).slideToggle("slow");
}

function editRowPMEMon(id) {
  // console.log(id);
  var tanggal = $("#tglCek").val();
  var mesin = $('select[name="mesinMon"]').val();

  console.log(tanggal, mesin, id);

  var request = $.ajax({
    url: baseurl + "PeriodicalMaintenance/Monitoring/editSubMonitoring",
    data: {
      tanggal: tanggal,
      mesin: mesin,
      id: id
    },
    type: "POST",
    datatype: "html"
  });

  request.done(function(result) {
    // console.log(result);
    $("#subMonitoringEdit").html(result);
    $("#modalEditMonitoring").modal("show");

    $(".button-save-mon").on("click", function() {
      var subHeader = $("#subHeaderEditMon").val();
      var standar = $("#standarEditMon").val();
      var periode = $("#periodeEditMon").val();
      var durasi = $("#durasiEditMon").val();
      var kondisi = $("#kondisiEditMon").val();
      var catatan = $("#catatanEditMon").val();

      var id = $("#idRowEditMon").val();
      console.log(subHeader, standar, periode, durasi, kondisi, catatan, id, tanggal, mesin);
      var request = $.ajax({
        url: baseurl + "PeriodicalMaintenance/Monitoring/updateSubMonitoring",
        data: {
          subHeader: subHeader,
          standar: standar,
          periode: periode,
          durasi: durasi,
          kondisi: kondisi,
          catatan: catatan,
          id: id,
          tanggal :tanggal,
          mesin : mesin
        },
        type: "POST",
        datatype: "html"
      });
      request.done(function() {
        $("#modalEditMonitoring").modal("hide");
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Mengedit Uraian Kerja",
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          // var mesin = $('select[name="mesinMon"]').val();
          var request = $.ajax({
            url: baseurl + "PeriodicalMaintenance/Monitoring/searchMon",
            data: {
              mesin: mesin,
              tanggal : tanggal
            },
            type: "POST",
            beforeSend: function() {
              $("div#ResultPMEMon").html(
                '<center><img style="width:100px; height:auto" src="' +
                  baseurl +
                  'assets/img/gif/loading14.gif"></center>'
              );
            }
          });
          request.done(function(result) {
            $("div#ResultPMEMon").html(result);
          });
        });
      });
    });
  });
}


function deleteRowPMEMon(id) {
  Swal.fire({
    title: "Apa Anda Yakin?",
    text: "Akan Menghapus Uraian Kerja ini ?",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#d73925",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak"
  }).then(result => {
    var tanggal = $("#tglCek").val();
    var mesin = $('select[name="mesinMon"]').val();
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "PeriodicalMaintenance/Monitoring/deleteSubMonitoring",
        data: {
          id: id,
          tanggal : tanggal, 
          mesin : mesin
        },
        type: "POST",
        datatype: "html"
      });
      request.done(function(result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Menghapus",
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          var tanggal = $("#tglCek").val();
          var mesin = $('select[name="mesinMon"]').val();
          var request = $.ajax({
            url: baseurl + "PeriodicalMaintenance/Monitoring/searchMon",
            data: {
              mesin: mesin,
              tanggal : tanggal
            },
            type: "POST",
            beforeSend: function() {
              $("div#ResultPMEMon").html(
                '<center><img style="width:100px; height:auto" src="' +
                  baseurl +
                  'assets/img/gif/loading14.gif"></center>'
              );
            }
          });
          request.done(function(result) {
            $("div#ResultPMEMon").html(result);
          });
        });
      });
    }
  });
}