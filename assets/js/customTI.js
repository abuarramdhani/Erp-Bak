$(document).ready(function () {
  $("#btn_search_invoice").click(function () {
    $("#loading_invoice").html(
      "<center><img id='loading12' style='margin-top: 2%;' src='" +
        baseurl +
        "assets/img/gif/loading4.gif'/><br /></center><br />"
    );

    var nama_vendor = $("#nama_vendor").val();
    var po_number = $("#po_number").val();
    var any_keyword = $("#any_keyword").val();
    var invoice_number = $("#invoice_number").val();
    // tambahkan id dalam ajax
    var invoice_date_to = $("#invoice_date_to").val();
    var invoice_date_from = $("#invoice_date_from").val();
    // until here
    var action_date = $("#action_date").val();
    var sumber = $("#source_id").val();

    $.ajax({
      type: "POST",
      url: baseurl + "Monitoring/TrackingInvoice/btn_search",
      data: {
        nama_vendor: nama_vendor,
        po_number: po_number,
        any_keyword: any_keyword,
        invoice_number: invoice_number,
        // id data
        invoice_date_to: invoice_date_to,
        invoice_date_from: invoice_date_from,
        action_date: action_date,
        sumber: sumber,
      },
      success: function (response) {
        $("#loading_invoice").html(response);
        $("#tabel_search_tracking_invoice").DataTable();
      },
    });
  });

  $("#table_tracking_invoice").DataTable({
    pageLength: 10,
    paging: true,
    searching: true,
    buttons: ["excel"],
  });

  $(".invoice_date").datepicker({
    format: "d/m/yyyy",
    autoclose: true,
  });

  // $('#btnExport').click(function(){
  // 	$('.tabel_search_tracking_invoice').table2excel({
  // 		name : "Test",
  // 		filename : "Test.xlsx"
  // 	}

  // 	});
});

function mdlDetailTI(th) {
  var inv_id = th;

  $("#MdlTrackInv").modal("show");
  $(".modal-tabel").html(
    "<center><img id='loading12' style='margin-top: 2%;width:200px' src='" +
      baseurl +
      "assets/img/gif/loadingquick.gif'/><br /></center><br />"
  );
  $.ajax({
    type: "POST",
    url: baseurl + "Monitoring/TrackingInvoice/DetailInvoice",
    data: {
      id: inv_id,
    },
    success: function (response) {
      // console.log(response, 'data');
      $(".modal-tabel").html("");
      $(".modal-tabel").html(response);
    },
  });
}
$(document).ready(function () {
  $("#btn_search_r_invoice").click(function () {
    $("#loading_invoice").html(
      "<center><img id='loading12' style='margin-top: 2%;' src='" +
        baseurl +
        "assets/img/gif/loading11.gif'/><br /></center><br />"
    );

    var nama_vendor = $("#nama_vendor").val();
    var invoice_date_to = $("#invoice_date_to").val();
    var invoice_date_from = $("#invoice_date_from").val();

    $.ajax({
      type: "POST",
      url: baseurl + "Report/TrackingInvoice/btn_search",
      data: {
        nama_vendor: nama_vendor,
        invoice_date_to: invoice_date_to,
        invoice_date_from: invoice_date_from,
      },
      success: function (response) {
        $("#loading_invoice").html(response);
        $("#tabel_search_r_tracking_invoice").DataTable({
          dom: "Bfrtip",
          buttons: [
            {
              extend: "excel",
              text: "Report Tracking Invoice",
              title: "Report Tracking Invoice",
            },
          ],
        });
      },
    });
  });
});
