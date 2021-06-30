$(document).ready(function () {
  var tableDSP = $("#tblWaitingListApproverDSP").DataTable({
    scrollY: "300px",
    scrollX: true,
    scrollCollapse: true,
  });
  var tableDSP = $("#tblRejectedListApproverDSP").DataTable({
    scrollY: "300px",
    scrollX: true,
    scrollCollapse: true,
  });
  $(document).on("click", ".btnReqNumberDSP", function () {
    var reqNumber = $(this).html();

    $("#mdlDSP-" + reqNumber).modal("show");

    if ($(".dataDSP-" + reqNumber).html() == "") {
      $(".loadingDetailDSP-" + reqNumber).css("display", "block");
      $.ajax({
        type: "post",
        url: baseurl + "DPBSparepart/Approver/getDetail",
        data: { reqNumber },
        success: function (response) {
          $(".loadingDetailDSP-" + reqNumber).hide();
          $(".dataDSP-" + reqNumber).append(response);
        },
      });
    }
  });

  $(document).on("click", ".btnRejectDSP", function () {
    var reqNum = $(this).val();
    var prn = $(this);
    Swal.fire({
      title: "Tunggu!",
      text: "Apakah Anda yakin untuk mereject order ini ?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          beforeSend: () => {
            Swal.fire({
              customClass: "swal-font-small",
              title: "Loading",
              onBeforeOpen: () => {
                Swal.showLoading();
              },
              allowOutsideClick: false,
            });
          },
          type: "POST",
          url: baseurl + "DPBSparepart/Approver/updateStatus",
          data: {
            reqNum,
            status: "N",
          },
          success: function (response) {
            if (response == 1) {
              swal.close();
              swal.fire({
                type: "success",
                title: "Berhasil reject !",
              });
              tableDSP.rows(prn.parentsUntil("tbody")).remove().draw();
            }
          },
        });
      }
    });
  });

  $(document).on("click", ".btnApproveDSP", function () {
    var reqNum = $(this).val();
    var prn = $(this);
    Swal.fire({
      title: "Tunggu!",
      text: "Apakah Anda yakin untuk approve order ini ?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya",
    }).then((result) => {
      if (result.value) {
        swal.fire({
          type: "warning",
          title: "Silahkan Tunggu !",
        });
        $.ajax({
          beforeSend: () => {
            Swal.fire({
              customClass: "swal-font-small",
              title: "Loading",
              onBeforeOpen: () => {
                Swal.showLoading();
              },
              allowOutsideClick: false,
            });
          },
          type: "POST",
          url: baseurl + "DPBSparepart/Approver/updateStatus",
          data: {
            reqNum,
            status: "Y",
          },
          success: function (response) {
            if (response == 1) {
              swal.close();
              swal.fire({
                type: "success",
                title: "Berhasil approve !",
              });
              tableDSP.rows(prn.parentsUntil("tbody")).remove().draw();
            }
          },
        });
      }
    });
  });

  $(document).on("change", ".noDODSP", function () {
    $(".alamatDSP").val("");
    $(".tempatTabelDPS").html("");
    var noDPB = $(this).val();

    if (noDPB) {
      $(this).attr("readonly", "readonly");
      $(".loadingSearchDODSP").css("display", "block");

      $.ajax({
        type: "POST",
        url: baseurl + "DPBSparepart/Admin/checkNoDPB",
        data: { noDPB },
        dataType: "JSON",
        success: function (response) {
          if (response.length == 0) {
            swal.fire({
              type: "warning",
              title: "DO/SPB tidak ada atau sudah pernah diinput",
            });

            $(".alamatDSP").val("");
            $(".tempatTabelDPS").html("");
            $(".noDODSP").removeAttr("readonly");
            $(".loadingSearchDODSP").css("display", "none");
          } else {
            $.ajax({
              type: "POST",
              url: baseurl + "DPBSparepart/Admin/getAlamat",
              data: { noDPB },
              dataType: "JSON",
              success: function (resp) {
                // console.log(resp[0]);
                if (resp[0]["ALAMAT_SO"] == null) {
                  $(".alamatDSP").val(" - ");
                } else {
                  if (resp[0]["ALAMAT_SO"].indexOf("#") != -1) {
                    var alamat = resp[0]["ALAMAT_SO"].replaceAll(/#/gi, "\n");
                    $(".alamatDSP").val(alamat);
                  } else {
                    $(".alamatDSP").val(resp[0]["ALAMAT_SO"]);
                  }
                }
                if (resp[0]["ORG_ID"] == null) {
                  $(".org_idd").val("");
                } else {
                  $(".org_idd").val(resp[0]["ORG_ID"]);
                }
                if (resp[0]["SUBINV"] == null) {
                  $(".subinvv").val("");
                } else {
                  $(".subinvv").val(resp[0]["SUBINV"]);
                }
                if (resp[0]["ALAMAT_KIRIM"] == null) {
                  // $(".alamatkirimDSP").val(" - ");
                } else {
                  if (resp[0]["ALAMAT_KIRIM"].indexOf("#") != -1) {
                    var alamat = resp[0]["ALAMAT_KIRIM"].replaceAll(
                      /#/gi,
                      "\n"
                    );
                    $(".alamatkirimDSP").val(alamat);
                  } else {
                    $(".alamatkirimDSP").val(resp[0]["ALAMAT_KIRIM"]);
                  }
                }
                if (resp[0]["DESCRIPTION"] == null) {
                  $(".deskripsiDSP").val(" - ");
                } else {
                  if (resp[0]["DESCRIPTION"].indexOf("#") != -1) {
                    var deskripsi = resp[0]["DESCRIPTION"].replaceAll(
                      /#/gi,
                      "\n"
                    );
                    $(".deskripsiDSP").val(deskripsi);
                  } else {
                    $(".deskripsiDSP").val(resp[0]["DESCRIPTION"]);
                  }
                }

                if (resp[0]["TGL_KIRIM"] == null) {
                  $(".tanggalDSP").val(" - ");
                } else {
                  if (resp[0]["TGL_KIRIM"].indexOf("#") != -1) {
                    var tanggal = resp[0]["TGL_KIRIM"].replaceAll(/#/gi, "\n");
                    $(".tanggalDSP").val(tanggal);
                  } else {
                    $(".tanggalDSP").val(resp[0]["TGL_KIRIM"]);
                  }
                }

                if (resp[0]["EKSPEDISI"] == null) {
                  // $(".ekspedisiDSP").val(" - ");
                  $(".ekspedisiDSP").html(
                    '<option></option><option value="ADEX">ADEX</option><option value="BARANG TRUK">BARANG TRUK</option><option value="INDIE">INDIE</option><option value="KGP">KGP</option><option value="POS KILAT KHUSUS">POS KILAT KHUSUS</option><option value="QDS 1">QDS 1</option><option value="QDS 2">QDS 2</option><option value="SADANA">SADANA</option><option value="TAM">TAM</option><option value="JPM">JPM</option><option value="JNE OKE">JNE OKE</option><option value="JNE REGULER">JNE REGULER</option><option value="JNE YES">JNE YES</option><option value="JNE TRUCKING">JNE TRUCKING</option><option value="J&T REGULER / EZ">J&T REGULER / EZ</option><option value="J&T DFOD">J&T DFOD</option><option value="TIKI ECO">TIKI ECO</option><option value="TIKI REGULER">TIKI REGULER</option><option value="TIKI ONS">TIKI ONS</option><option value="SICEPAT GOKIL">SICEPAT GOKIL</option><option value="SICEPAT REGULER">SICEPAT REGULER</option><option value="SICEPAT SIUNTUNG">SICEPAT SIUNTUNG</option><option value="LION PARCEL">LION PARCEL</option><option value="GRAB / GOJEK">GRAB / GOJEK</option><option value="PENGAMBILAN DI KANTOR">PENGAMBILAN DI KANTOR</option><option value="JNE CTC YES">JNE CTC YES</option>'
                  );
                } else {
                  if (resp[0]["EKSPEDISI"].indexOf("#") != -1) {
                    var ekspedisi = resp[0]["EKSPEDISI"].replaceAll(
                      /#/gi,
                      "\n"
                    );
                    var data = {
                      id: ekspedisi,
                      text: ekspedisi,
                    };

                    var newOption = new Option(
                      data.text,
                      data.id,
                      false,
                      false
                    );
                    $(".ekspedisiDSP").append(newOption).trigger("change");
                    $(".ekspedisiDSP")
                      .append(
                        '<option value="ADEX">ADEX</option><option value="BARANG TRUK">BARANG TRUK</option><option value="INDIE">INDIE</option><option value="KGP">KGP</option><option value="POS KILAT KHUSUS">POS KILAT KHUSUS</option><option value="QDS 1">QDS 1</option><option value="QDS 2">QDS 2</option><option value="SADANA">SADANA</option><option value="TAM">TAM</option><option value="JPM">JPM</option><option value="JNE OKE">JNE OKE</option><option value="JNE REGULER">JNE REGULER</option><option value="JNE YES">JNE YES</option><option value="JNE TRUCKING">JNE TRUCKING</option><option value="J&T REGULER / EZ">J&T REGULER / EZ</option><option value="J&T DFOD">J&T DFOD</option><option value="TIKI ECO">TIKI ECO</option><option value="TIKI REGULER">TIKI REGULER</option><option value="TIKI ONS">TIKI ONS</option><option value="SICEPAT GOKIL">SICEPAT GOKIL</option><option value="SICEPAT REGULER">SICEPAT REGULER</option><option value="SICEPAT SIUNTUNG">SICEPAT SIUNTUNG</option><option value="LION PARCEL">LION PARCEL</option><option value="GRAB / GOJEK">GRAB / GOJEK</option><option value="PENGAMBILAN DI KANTOR">PENGAMBILAN DI KANTOR</option><option value="JNE CTC YES">JNE CTC YES</option>'
                      )
                      .trigger("change");
                  } else {
                    // $(".ekspedisiDSP").val(resp[0]["EKSPEDISI"]);
                    var data = {
                      id: resp[0]["EKSPEDISI"],
                      text: resp[0]["EKSPEDISI"],
                    };

                    var newOption = new Option(
                      data.text,
                      data.id,
                      false,
                      false
                    );
                    $(".ekspedisiDSP").append(newOption).trigger("change");
                    $(".ekspedisiDSP")
                      .append(
                        '<option value="ADEX">ADEX</option><option value="BARANG TRUK">BARANG TRUK</option><option value="INDIE">INDIE</option><option value="JNE">JNE</option><option value="JNT">JNT</option><option value="KGP">KGP</option><option value="POS">POS</option><option value="QDS 1">QDS 1</option><option value="QDS 2">QDS 2</option><option value="SADANA">SADANA</option><option value="TAM">TAM</option><option value="TIKI">TIKI</option><option value="JPM">JPM</option>'
                      )
                      .trigger("change");
                  }
                }

                if (resp[0]["SO"] == null) {
                  $(".inputSODSP").val(" - ");
                } else {
                  if (resp[0]["SO"].indexOf("#") != -1) {
                    var so = resp[0]["SO"].replace(/#/gi, "\n");
                    $(".inputSODSP").val(so);
                  } else {
                    $(".inputSODSP").val(resp[0]["SO"]);
                  }
                }

                if (resp[0]["OPK"] == null) {
                  $(".inputOPKDSP").val(" - ");
                } else {
                  if (resp[0]["OPK"].indexOf("#") != -1) {
                    var opk = resp[0]["OPK"].replace(/#/gi, "\n");
                    $(".inputOPKDSP").val(opk);
                  } else {
                    $(".inputOPKDSP").val(resp[0]["OPK"]);
                  }
                }
                var org = resp[0]["ORG_ID"];
                var subinv = resp[0]["SUBINV"];
                $.ajax({
                  type: "POST",
                  url: baseurl + "DPBSparepart/Admin/listBarang",
                  data: { noDPB, org, subinv },
                  success: function (response) {
                    $(".btnCrateDPBDPS").css("display", "block");
                    $(".noDODSP").removeAttr("readonly");
                    $(".loadingSearchDODSP").css("display", "none");

                    $(".tempatTabelDPS").html(response);
                    $(".tblListBarangDPS").DataTable();

                    function cekSisaQty() {
                      // Cek jika ada sisa yang minus
                      let allocate = $(".tempatTabelDPS tbody tr")
                        .toArray()
                        .map((e) => $(e).find(".allocateQty").html());

                      let sisa = allocate.filter((a) => a < 0);

                      // Cek jika ada input yang masih kosong
                      let kosong = $(".tempatTabelDPS tbody tr")
                        .toArray()
                        .map((e) => $(e).find(".noReqQty").val());

                      // console.log(`sisa yang minus : ${sisa.length}`);
                      // console.log(`input kosong : ${kosong.includes("")}`);

                      if (kosong.includes("") || sisa.length > 0) {
                        $(".btnCrateDPBDPS").prop("disabled", true);
                      } else {
                        $(".btnCrateDPBDPS").prop("disabled", false);
                      }
                    }
                    cekSisaQty();

                    // Jika input kosong tampil spbQty
                    $(".noReqQty").focus(function () {
                      let spbQty = parseInt($(this).parent().prev().html());
                      let atrQty = parseInt($(this).parent().next().html());
                      let sisaQty = $(this).parent().next().next();

                      if (this.value == 0) {
                        this.value = spbQty;
                        sisaQty.html(parseInt(atrQty) - parseInt(this.value));
                      } else {
                        sisaQty.html(parseInt(atrQty) - parseInt(this.value));
                      }
                      cekSisaQty();
                    });

                    // Jika mengubah nilai reqQty
                    $(".noReqQty").keyup(function () {
                      let spbQty = parseInt($(this).parent().prev().html());
                      let atrQty = parseInt($(this).parent().next().html());
                      let sisaQty = $(this).parent().next().next();

                      if (this.value == 0) {
                        sisaQty.html("");
                      } else {
                        sisaQty.html(parseInt(atrQty) - parseInt(this.value));
                      }

                      if (this.value > spbQty) {
                        this.value = spbQty;
                        sisaQty.html(parseInt(atrQty) - parseInt(this.value));
                      }
                      cekSisaQty();
                    });
                  },
                });
              },
            });
          }
        },
      });
    }
  });

  $(".form-horizontal").on("click", ".btnCrateDPBDPS", function () {
    var noDPB = $(".noDODSP").val();
    var jenis = $(".jenisDPS").val();
    var forward = $(".forwardDPS").val();
    var keterangan = $(".keteranganDPS").val();
    var ekspedisi = $(".ekspedisiDSP").val();
    var alamat_kir = $(".alamatkirimDSP").val();
    var org = $(".org_idd").val();
    var subinv = $(".subinvv").val();

    if (forward == null || forward == "") {
      swal.fire({
        type: "error",
        title: "Pilih Forward To !",
      });
    } else {
      var alamat_kirim = alamat_kir.replaceAll("\n", "#");
      let lines = $(".tempatTabelDPS tbody tr")
        .toArray()
        .map((e) => ({
          lineId: $(e).find(".lineid").html(),
          reqQty: $(e).find(".noReqQty").val(),
          allocateQty:
            parseInt($(e).find(".atrQty").html()) -
            parseInt($(e).find(".noReqQty").val()),
        }));
      $.ajax({
        type: "POST",
        url: baseurl + "DPBSparepart/Admin/cekStatusLine",
        data: { noDPB, org, subinv },
        dataType: "JSON",
        success: function (response) {
          if (response[0]["HASIL_LINE"] == "0") {
            $.ajax({
              beforeSend: () => {
                Swal.fire({
                  customClass: "swal-font-small",
                  title: "Loading",
                  onBeforeOpen: () => {
                    Swal.showLoading();
                  },
                  allowOutsideClick: false,
                });
              },
              type: "POST",
              url: baseurl + "DPBSparepart/Admin/createDPB",
              data: {
                noDPB,
                jenis,
                forward,
                keterangan,
                lines,
                ekspedisi,
                alamat_kirim,
                org,
                subinv,
              },
              success: function (response) {
                swal.close();
                swal.fire({
                  type: "success",
                  title: "Berhasil!",
                });
                // $(".tempatTabelDPS").html("");
                // $(".jenisDPS").val("").trigger("change.select2");
                // $(".forwardDPS").val("").trigger("change.select2");
                // $(".keteranganDPS").val("");
                // $(".noDODSP").val("");
                // $(".alamatDSP").val("");
                window.location.reload();
              },
            });
          } else if (response[0]["HASIL_LINE"] == "99999") {
            swal.fire({
              type: "error",
              title: "Alamat belum lengkap!",
            });
          } else if (response[0]["HASIL_LINE"] == "77777") {
            swal.fire({
              type: "error",
              title: "DO/SPB line bukan SP/YSP!",
            });
          } else {
            swal.fire({
              type: "error",
              title:
                "DO/SPB sudah transact sebagian silahkan masukan nomor lain!",
            });
          }
        },
      });
    }
  });

  $("#tblRejectedListApproverDSP").on("click", ".btnResubmit", function () {
    let id = $(this).attr("data-id");
    let tr = $(this).parent().parent();

    Swal.fire({
      title: "Are you sure?",
      text: "Anda yakin akan Re-submit SPB/DO ini?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya",
      cancelButtonText: "Tidak",
    }).then((result) => {
      if (result.value == true) {
        $.ajax({
          type: "POST",
          url: baseurl + "DPBSparepart/Admin/reSubmitDPB",
          data: { id },
          success: function () {
            Swal.fire(
              "Re-submit!",
              "Request SPB/DO berhasil di submit ulang",
              "success"
            );
            tr.hide();
          },
        });
      } else if (result.dismiss == "cancel") {
        console.log("Batal reSubmit");
      }
    });
  });
});
$(".btnEditDSP").on("click", function () {
  var value = $(this).val();
  var eks = $("#EksToEdit" + value).val();
  // console.log(value);
  $.ajax({
    type: "POST",
    url: baseurl + "DPBSparepart/Approver/MdlEditEkspedisi",
    data: {
      req: value,
      eks: eks,
    },
    success: function (response) {
      $("#Mdl_Ed_Eks").modal("show");
      $("#Ed_Eks").html(response);
      $("#EkspedisiEdit").select2({
        allowClear: true,
      });
    },
  });
});
function updateEkspedisi() {
  var eks = $("#EkspedisiEdit").val();
  var req = $("#reqNuMber").val();
  // console.log(eks, req);
  $.ajax({
    type: "POST",
    url: baseurl + "DPBSparepart/Approver/UpdateEkspedisi",
    data: {
      req: req,
      eks: eks,
    },
    success: function (response) {
      Swal.fire({
        position: "top",
        type: "success",
        title: "Berhasil Update Ekspedisi",
        showConfirmButton: false,
        timer: 1500,
      }).then(() => {
        window.location.reload();
      });
    },
  });
}
$(document).ready(function () {
  var view = document.getElementById("view_arsippp");
  if (view) {
    $.ajax({
      beforeSend: function () {
        $("div#arsipDepebeh").html(
          '<center><img style="width:100px; height:auto" src="' +
            baseurl +
            'assets/img/gif/loading11.gif"><br><label>Loading, Please Wait .....</label></center>'
        );
      },
      url: baseurl + "DPBSparepart/Admin/getArsipDPB",
      success: function (response) {
        $("#arsipDepebeh").html(response);
        var date = new Date();
        date.setDate(date.getDate() - 30);

        var datenow = new Date();
        datenow.setDate(datenow.getDate());

        var dateago = date.toISOString().split("T")[0];
        var datetoday = datenow.toISOString().split("T")[0];

        $(".tblarsipdpb").dataTable({
          paging: false,
          scrollX: true,
          scrollY: 500,
          searching: true,
          dom: "Bfrtip",
          buttons: [
            {
              extend: "excelHtml5",
              title: "Arsip SPB / DO Tanggal " + dateago + " s/d " + datetoday,
            },
          ],
        });
      },
    });
  }
});
$(document).ready(function () {
  $(".datespbeh").datepicker({
    format: "dd/mm/yyyy",
    autoclose: true,
  });
});
function SearchArsSPBDO() {
  var date1 = $("#dtfrmsp").val();
  var date2 = $("#dtotsp").val();

  var date1input = $("#dtfrminput").val();
  var date2input = $("#dtoinput").val();

  $.ajax({
    beforeSend: function () {
      $("div#arsipDepebeh").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"><br><label>Loading, Please Wait .....</label></center>'
      );
    },
    url: baseurl + "DPBSparepart/Admin/getArsipDPBbyDate",
    data: {
      datefrom: date1,
      dateto: date2,
      dateinput1: date1input,
      dateinput2: date2input,
    },
    dataType: "html",
    type: "post",
    success: function (response) {
      $("#arsipDepebeh").html(response);
      $(".tblarsipdpb").dataTable({
        paging: false,
        scrollX: true,
        scrollY: 500,
        searching: true,
        dom: "Bfrtip",
        buttons: [
          {
            extend: "excelHtml5",
            title: "Arsip SPB DO Tanggal " + date1 + " sampai " + date2,
          },
        ],
      });
    },
  });
}
$(document).ready(function () {
  var view = document.getElementById("V_Monitoring_List");
  if (view) {
    ajax1 = $.ajax({
      url: baseurl + "DPBSparepart/Approver/getNormal",
      type: "POST",
      beforeSend: function () {
        $("#loadingAreanormal").show();
        $("div.table_area_normal").hide();
      },
      success: function (result) {
        // console.log(result);
        $("#loadingAreanormal").hide();
        $("div.table_area_normal").show();
        $("div.table_area_normal").html(result);
        $("div.table_area_urgent").html("");
        $("div.table_area_eceran").html("");
        $("div.table_area_bagro").html("");
        $("div.table_area_ecommerce").html("");
        $(".tblMonitoringDSP").DataTable({
          scrollY: "300px",
          scrollX: true,
          scrollCollapse: true,
        });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      },
    });
  }
});
function normalll() {
  if (ajax2 != null) ajax2.abort();
  if (ajax3 != null) ajax3.abort();

  ajax1 = $.ajax({
    url: baseurl + "DPBSparepart/Approver/getNormal",
    type: "POST",
    beforeSend: function () {
      $("#loadingAreanormal").show();
      $("div.table_area_normal").hide();
    },
    success: function (result) {
      // console.log(result);
      $("#loadingAreanormal").hide();
      $("div.table_area_normal").show();
      $("div.table_area_normal").html(result);
      $("div.table_area_urgent").html("");
      $("div.table_area_eceran").html("");
      $("div.table_area_bagro").html("");
      $("div.table_area_ecommerce").html("");
      $(".tblMonitoringDSP").DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
      });
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    },
  });
}
function urgentttt() {
  if (ajax1 != null) ajax1.abort();
  if (ajax3 != null) ajax3.abort();

  ajax1 = $.ajax({
    url: baseurl + "DPBSparepart/Approver/geturgent",
    type: "POST",
    beforeSend: function () {
      $("#loadingAreaurgent").show();
      $("div.table_area_urgent").hide();
    },
    success: function (result) {
      // console.log(result);
      $("#loadingAreaurgent").hide();
      $("div.table_area_urgent").show();
      $("div.table_area_urgent").html(result);
      $("div.table_area_normal").html("");
      $("div.table_area_eceran").html("");
      $("div.table_area_bagro").html("");
      $("div.table_area_ecommerce").html("");
      $(".tblMonitoringDSP").DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
      });
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    },
  });
}
function ecerannnn() {
  if (ajax1 != null) ajax1.abort();
  if (ajax2 != null) ajax2.abort();

  ajax1 = $.ajax({
    url: baseurl + "DPBSparepart/Approver/geteceran",
    type: "POST",
    beforeSend: function () {
      $("#loadingAreaeceran").show();
      $("div.table_area_eceran").hide();
    },
    success: function (result) {
      // console.log(result);
      $("#loadingAreaeceran").hide();
      $("div.table_area_eceran").show();
      $("div.table_area_eceran").html(result);
      $("div.table_area_normal").html("");
      $("div.table_area_urgent").html("");
      $("div.table_area_bagro").html("");
      $("div.table_area_ecommerce").html("");
      $(".tblMonitoringDSP").DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
      });
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    },
  });
}
function bagroooo() {
  if (ajax1 != null) ajax1.abort();
  if (ajax2 != null) ajax2.abort();

  ajax1 = $.ajax({
    url: baseurl + "DPBSparepart/Approver/getbagro",
    type: "POST",
    beforeSend: function () {
      $("#loadingAreabagro").show();
      $("div.table_area_bagro").hide();
    },
    success: function (result) {
      // console.log(result);
      $("#loadingAreabagro").hide();
      $("div.table_area_bagro").show();
      $("div.table_area_bagro").html(result);
      $("div.table_area_normal").html("");
      $("div.table_area_urgent").html("");
      $("div.table_area_eceran").html("");
      $("div.table_area_ecommerce").html("");
      $(".tblMonitoringDSP").DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
      });
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    },
  });
}
function ecommerceee() {
  if (ajax1 != null) ajax1.abort();
  if (ajax2 != null) ajax2.abort();

  ajax1 = $.ajax({
    url: baseurl + "DPBSparepart/Approver/getecommerce",
    type: "POST",
    beforeSend: function () {
      $("#loadingAreaecommerce").show();
      $("div.table_area_ecommerce").hide();
    },
    success: function (result) {
      // console.log(result);
      $("#loadingAreaecommerce").hide();
      $("div.table_area_ecommerce").show();
      $("div.table_area_ecommerce").html(result);
      $("div.table_area_normal").html("");
      $("div.table_area_urgent").html("");
      $("div.table_area_eceran").html("");
      $("div.table_area_bagro").html("");

      $(".tblMonitoringDSP").DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
      });
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    },
  });
}
