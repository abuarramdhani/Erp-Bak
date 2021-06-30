var currentUrl = window.location.href;

if (currentUrl.indexOf('ReadyToShipConfirm') !== -1) {
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
}
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
if (currentUrl.indexOf('OnProcess') !== -1) {
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
}

if (currentUrl.indexOf('AutoInvoiceKasie/FinishInvoice') === -1) {
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
} else {  
  $(document).ready(function () {
    var path = $("#path_inf").val();
    var request = $.ajax({
      type: 'get',
      url: baseurl + path + "/ListFinishKasie",
      dataType: 'json',
      cache: true,
      beforeSend: function () {
        $("div#ListFinish").html(
          '<center><img style="width:100px; height:auto" src="' +
            baseurl +
            'assets/img/gif/loading11.gif"><br><label>Loading Data, Please Wait</label></center>'
        );
      },
    });
    request.done(function (result) {
      var table_do_finish = $('<div class="panel-body">' +
      '<div class="col-md-12">' +
        '<table class="table table-bordered" id="tbl_do_finish">' +
          '<thead class="bg-green">' +
            '<tr>' +
              '<th class="text-center"><input type="checkbox" class="cekAllFinish"></th>' +
              '<th class="text-center">NO</th>' +
              '<th class="text-center">NO DO</th>' +
              '<th class="text-center">SO NUMBER</th>' +
              '<th class="text-center">OU</th>' +
              '<th class="text-center">INVOICE NUM</th>' +
              '<th class="text-center">INVOICE AMMOUNT</th>' +
              '<th class="text-center">RDO AMMOUNT</th>' +
              '<th class="text-center" style="width: 200px;">ACTION</th>' +
            '</tr>' +
          '</thead>' +
          '<tbody>' +
          '</tbody>' +
        '</table>' +
      '</div>');
      result.DoFinish.forEach(function (value, key) {
        var inv_amm = value['AMMOUNT_INVOICE'].toLocaleString();
        var rdo_amm = value['AMMOUNT_RDO'].toLocaleString();
        if (inv_amm != rdo_amm) {
          var bg = 'bg-warning';
        } else {
          var bg = '';
        }
        var angka = key + 1;
        table_do_finish.find('tbody').append(
          '<tr class="' + bg + '">' +
            '<td class="text-center"><input type="checkbox" class="cekListFinish" data-row="' + angka + '"></td>' +
            '<td class="text-center">' + angka + '</td>' +
            '<td class="text-center">' + value['WDD_BATCH_ID'] + ' <input type="hidden" class="wdd_batch_id" data-row="' + angka + '" value="' + value['WDD_BATCH_ID'] + '"></td>' +
            '<td class="text-center">' + value['OOH_ORDER_NUMBER'] + '</td>' +
            '<td class="text-center">' + value['NAME'] + '</td>' +
            '<td class="text-center">' + value['TRX_NUMBER'] + '</td>' +
            '<td class="text-center">' + inv_amm + '</td>' +
            '<td class="text-center">' + rdo_amm + '</td>' +
            '<td class="text-center">' +
              (function() {
                if (value['APPROVAL_FLAG'] == 'Y') {
                  return '<a class="btn btn-danger btn-sm" target="_blank" href="' + baseurl + 'AutoInvoice/FinishInvoice/CetakInvoice/' + value['CETAK_INVOICE_REQ_ID'] + '">Cetak Invoice</a>' +
                  '<a class="btn btn-danger btn-sm" target="_blank" href="' + baseurl + 'AutoInvoice/FinishInvoice/CetakRDO/' + value['CETAK_RDO_REQ_ID'] + '">Cetak RDO</a>';
                }
                return '';
              })() +
            '</td>' +
          '</tr>'
        )
      });

      console.log('success');

      $("div#ListFinish").html(table_do_finish);
      $("#tbl_do_finish").dataTable({
        paging: true,
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
}
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
