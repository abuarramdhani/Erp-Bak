$(document).ready(function () {
  var tableDSP = $("#tblWaitingListApproverDSP").DataTable({
    scrollY: "300px",
    scrollX: true,
    scrollCollapse: true,
  });

  $("#tblMonitoringDSP").DataTable({
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
                // console.log(resp[0]["ALAMAT"]);
                if (resp[0]["ALAMAT"].indexOf("#") != -1) {
                  var alamat = resp[0]["ALAMAT"].replace(/#/gi, "\n");
                  $(".alamatDSP").val(alamat);
                } else {
                  $(".alamatDSP").val(resp[0]["ALAMAT"]);
                }
              },
            });

            $.ajax({
              type: "POST",
              url: baseurl + "DPBSparepart/Admin/listBarang",
              data: { noDPB },
              success: function (response) {
                $(".btnCrateDPBDPS").css("display", "block");
                $(".noDODSP").removeAttr("readonly");
                $(".loadingSearchDODSP").css("display", "none");

                $(".tempatTabelDPS").html(response);
                $(".tblListBarangDPS").DataTable();
              },
            });
          }
        },
      });
    }
  });

  $(document).on("click", ".btnCrateDPBDPS", function () {
    var noDPB = $(".noDODSP").val();
    var jenis = $(".jenisDPS").val();
    var forward = $(".forwardDPS").val();
    var keterangan = $(".keteranganDPS").val();

    $.ajax({
      type: "POST",
      url: baseurl + "DPBSparepart/Admin/cekStok",
      data: { noDPB },
      dataType: "JSON",
      success: function (response) {
        if (response[0]["HASIL"] == "0") {
          $.ajax({
            type: "POST",
            url: baseurl + "DPBSparepart/Admin/cekStatusLine",
            data: { noDPB },
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
                  data: { noDPB, jenis, forward, keterangan },
                  success: function (response) {
                    swal.close();
                    swal.fire({
                      type: "success",
                      title: "Berhasil!",
                    });
                    $(".tempatTabelDPS").html("");
                    $(".jenisDPS").val("").trigger("change.select2");
                    $(".forwardDPS").val("").trigger("change.select2");
                    $(".keteranganDPS").val("");
                    $(".noDODSP").val("");
                    $(".alamatDSP").val("");
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
        } else {
          swal.fire({
            type: "error",
            title: "Stok tidak mencukupi!",
          });
        }
      },
    });
  });
});
