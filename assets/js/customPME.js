var i = 1;
function addRowPeriodicalMaintenance() {
  var noDoc = $("#no_dokumen").val();
  var noRev = $("#no_revisi").val();
  var revDate = $("#tgl_revisi").val();

  var namaMesin = $("#machineMPA").val();
  var kondisiMesin = $("#kondisi_mesin").val();
  var header = $("#header").val();
  var uraianKerja = $("#uraian_kerja").val();
  var standar = $("#standar").val();
  var periode = $("#periodeMPA").val();

  if (
    noDoc === null ||
    noRev === null ||
    revDate === null ||
    namaMesin === null ||
    kondisiMesin === null ||
    uraianKerja === null ||
    standar === null ||
    periode === null
  ) {
    swal.fire("Alert", "Isi data dengan lengkap", "error");
  } else {
    $("#tbodyPeriodicalMaintenance").append(
      '<tr class="clone"><td> <input type="hidden" name="no_dokumen[]" value="'+
      noDoc +'"> <input type="hidden" name="no_revisi[]" value="'+
      noRev +'"> <input type="hidden" name="tgl_revisi[]" value="'+
      revDate +'"> <input type="text" name="nama_mesin[]" value="' +
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
  $("#no_dokumen").val("");
  $("#no_revisi").val("");
  $("#tgl_revisi").val("");
  $("#machineMPA").val("");
  $("#kondisi_mesin").val("");
  $("#header").val("");
  $("#uraian_kerja").val("");
  $("#standar").val("");
  $("#periode").val("");

  $("#no_dokumen").removeAttr("disabled");
  $("#no_revisi").removeAttr("disabled");
  $("#tgl_revisi").removeAttr("disabled");
  $("#machineMPA").removeAttr("disabled");

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

$("#machineMPA").change(function() {
  var value = $(this).val();
  console.log(value);
  if ($("#machineMPA").val() !== null) {
    $("#no_dokumen").prop("disabled", true);
    $("#no_revisi").prop("disabled", true);
    $("#tgl_revisi").prop("disabled", true);
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
    var nodoc = $('select[name="nodocMPA"]').val();

    console.log(mesin);
    var request = $.ajax({
      url: baseurl + "PeriodicalMaintenance/Monitoring/printForm",
      data: {
        nodoc : nodoc
      },
      type: "POST",
      datatype: "html"
    });
  });
}

function getPMEMon(th) {
  $(document).ready(function() {
    var nodoc = $('select[name="nodocMPA"]').val();

    console.log(nodoc);

    var request = $.ajax({
      url: baseurl + "PeriodicalMaintenance/Monitoring/searchMon",
      data: {
        nodoc : nodoc
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
  var nodoc = $('select[name="nodocMPA"]').val();

  console.log(nodoc);

  var request = $.ajax({
    url: baseurl + "PeriodicalMaintenance/Monitoring/editSubMonitoring",
    data: {
      nodoc: nodoc,
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
      console.log(subHeader, standar, periode, durasi, kondisi, catatan, id, nodoc);
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
          nodoc : nodoc
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
          var request = $.ajax({
            url: baseurl + "PeriodicalMaintenance/Monitoring/searchMon",
            data: {
              nodoc: nodoc
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
    var nodoc = $('select[name="nodocMPA"]').val();
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "PeriodicalMaintenance/Monitoring/deleteSubMonitoring",
        data: {
          id: id,
          nodoc : nodoc
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
          var nodoc = $('select[name="nodocMPA"]').val();

          var request = $.ajax({
            url: baseurl + "PeriodicalMaintenance/Monitoring/searchMon",
            data: {
              nodoc : nodoc
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

function approveMPA(nodoc, id) {

  console.log(nodoc, id);

  if(id === "tblStaffMtn")
  {
      $("#modalApprovalMPA").modal("show");
  
      $(".btn-approve-mpa").on("click", function() {
        var req2 = $("#reqSeksiysb").val();
  
        console.log(req2);
        var request = $.ajax({
          url: baseurl + "PeriodicalMaintenance/Approval/updateApproval1",
          data: {
            req2: req2,
            nodoc : nodoc
          },
          type: "POST",
          datatype: "html"
        });
        request.done(function() {
          $("#modalApprovalMPA").modal("hide");
          Swal.fire({
            position: "top",
            type: "success",
            title: "Berhasil Approve Staff Maintenance!",
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            window.location.reload();
          });
        });
      });
  } else if(id === "tblSeksiTerkait"){
    Swal.fire({
      title: "Apa Anda Yakin?",
      text: "Akan Melakukan Approve?",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#00a65a",
      cancelButtonColor: "#d73925",
      confirmButtonText: "Ya",
      cancelButtonText: "Tidak"
    }).then(result => {
      if (result.value) {
        var request = $.ajax({
          url: baseurl + "PeriodicalMaintenance/Approval/updateApproval2",
          data: {
            nodoc : nodoc
          },
          type: "POST",
          datatype: "html"
        });
        request.done(function(result) {
          Swal.fire({
            position: "top",
            type: "success",
            title: "Berhasil Approve Seksi Terkait!",
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            window.location.reload();
          });
        });
      }
    });
  }
}
