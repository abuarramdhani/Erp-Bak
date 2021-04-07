$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "AutoInvoice/ReadyToShipConfirm/ListReady",
    beforeSend: function () {
      $("div#ListReady").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"><br><label>Loading Data, Please Wait</label></center>'
      );
    },
  });
  request.done(function (result) {
    $("div#ListReady").html(result);
    $("#tbl_Ready_To_Ship_Confirm").dataTable({
      paging: false,
      scrollCollapse: true,
      scrollY: 400,
    });
    $(".PilihSemuaReady, .daftarReady").iCheck({
      checkboxClass: "icheckbox_flat-green",
      radioClass: "iradio_flat-green",
    });
    $(document).on("ifChecked", ".PilihSemuaReady", function () {
      $("div#ListReady").css("display", "none");
      $.ajax({
        beforeSend: function () {
          $("div#LoadingCheck").html(
            '<center><img style="width:100px; height:auto" src="' +
              baseurl +
              'assets/img/gif/loading11.gif"><br><label>Processing Check List, Please Wait</label></center>'
          );
        },
        success: function (res) {
          $("div#ListReady").css("display", "block");
          $("div#LoadingCheck").html("");
          $(".daftarReady").iCheck("check");
        },
      });
    });
    $(document).on("ifUnchecked", ".PilihSemuaReady", function () {
      $("div#ListReady").css("display", "none");
      $.ajax({
        beforeSend: function () {
          $("div#LoadingCheck").html(
            '<center><img style="width:100px; height:auto" src="' +
              baseurl +
              'assets/img/gif/loading11.gif"><br><label>Processing UnCheck List, Please Wait</label></center>'
          );
        },
        success: function (res) {
          $("div#ListReady").css("display", "block");
          $("div#LoadingCheck").html("");
          $(".daftarReady").iCheck("uncheck");
        },
      });
    });
    $(".slcProcesShip").select2();
  });
});
function DetDo(i) {
  //   console.log(i);
  $("#mdl_detail_do").modal("show");
  var request = $.ajax({
    url: baseurl + "AutoInvoice/ReadyToShipConfirm/ListDetailDo",
    data: {
      do: i,
    },
    dataType: "html",
    type: "post",
    beforeSend: function () {
      $("#tbl_do").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"><br><label>Loading Data, Please Wait</label></center>'
      );
    },
  });
  request.done(function (result) {
    // $("#mdl_detail_do").modal("show");
    $("#tbl_do").html(result);
  });
}
function ProcessShipConfirm() {
  $(".ProcessShipConfirm").attr("disabled", "disabled");
  var nomor_do = [];
  var chk = $(".daftarReady").filter(":checked");
  $(chk).each(function () {
    var row_id = $(this).attr("data-row");
    var do_to_push = $('.nom_DO[data-row="' + row_id + '"]').val();
    nomor_do.push(do_to_push);
  });
  //   console.log(nomor_do);
  var request = $.ajax({
    url: baseurl + "AutoInvoice/ReadyToShipConfirm/InsertProcessDO",
    data: {
      do: nomor_do,
    },
    dataType: "html",
    type: "post",
    beforeSend: function () {
      $(".loading_process").html(
        '<left><img style="width:30px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></left>'
      );
    },
  });
  request.done(function (result) {
    Swal.fire({
      position: "top",
      type: "success",
      title: "Berhasil",
      showConfirmButton: false,
      timer: 1500,
    }).then(() => {
      window.location.reload();
    });
  });
}
$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "AutoInvoice/OnProcess/ListProcess",
    beforeSend: function () {
      $("div#ListProcess").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"><br><label>Loading Data, Please Wait</label></center>'
      );
    },
  });
  request.done(function (result) {
    $("div#ListProcess").html(result);
    $("#tbl_do_on_process").dataTable({
      paging: false,
      scrollCollapse: true,
      scrollY: 400,
    });
  });
});
$(document).ready(function () {
  var path = $("#path_inf").val();
  var request = $.ajax({
    url: baseurl + path + "/ListFinish",
    beforeSend: function () {
      $("div#ListFinish").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"><br><label>Loading Data, Please Wait</label></center>'
      );
    },
  });
  request.done(function (result) {
    $("div#ListFinish").html(result);
    $("#tbl_do_finish").dataTable({
      paging: false,
      scrollCollapse: true,
      scrollY: 400,
    });
    $(".cekAllFinish, .cekListFinish").iCheck({
      checkboxClass: "icheckbox_flat-green",
      // radioClass: "iradio_flat-green",
    });
    $(document).on("ifChecked", ".cekAllFinish", function () {
      $("div#ListFinish").css("display", "none");
      $.ajax({
        beforeSend: function () {
          $("div#LoadingCheck").html(
            '<center><img style="width:100px; height:auto" src="' +
              baseurl +
              'assets/img/gif/loading11.gif"><br><label>Processing Check List, Please Wait</label></center>'
          );
        },
        success: function (res) {
          $("div#ListFinish").css("display", "block");
          $("div#LoadingCheck").html("");
          $(".cekListFinish").iCheck("check");
        },
      });
    });
    $(document).on("ifUnchecked", ".cekAllFinish", function () {
      $("div#ListFinish").css("display", "none");
      $.ajax({
        beforeSend: function () {
          $("div#LoadingCheck").html(
            '<center><img style="width:100px; height:auto" src="' +
              baseurl +
              'assets/img/gif/loading11.gif"><br><label>Processing UnCheck List, Please Wait</label></center>'
          );
        },
        success: function (res) {
          $("div#ListFinish").css("display", "block");
          $("div#LoadingCheck").html("");
          $(".cekListFinish").iCheck("uncheck");
        },
      });
    });
    $(".slcApproveFinish").select2();
  });
});
function ApproveFinish() {
  $(".ApproveFinish").attr("disabled", "disabled");
  var nomor_wdd = [];
  var chk = $(".cekListFinish").filter(":checked");
  $(chk).each(function () {
    var row_id = $(this).attr("data-row");
    var wdd_to_push = $('.wdd_batch_id[data-row="' + row_id + '"]').val();
    nomor_wdd.push(wdd_to_push);
  });
  var flag = $(".slcApproveFinish").val();
  //   console.log(nomor_do);
  var request = $.ajax({
    url: baseurl + "AutoInvoice/FinishInvoice/UpdateFlagFinish",
    data: {
      wdd: nomor_wdd,
      flag: flag,
    },
    dataType: "html",
    type: "post",
    beforeSend: function () {
      $(".loading_process").html(
        '<left><img style="width:30px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></left>'
      );
    },
  });
  request.done(function (result) {
    Swal.fire({
      position: "top",
      type: "success",
      title: "Berhasil",
      showConfirmButton: false,
      timer: 1500,
    }).then(() => {
      window.location.reload();
    });
  });
}
