$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "MonitoringShipConfirmDO/ReadyToShipConfirm/ListReady",
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
  });
});
function DetDo(i) {
  //   console.log(i);
  $("#mdl_detail_do").modal("show");
  var request = $.ajax({
    url: baseurl + "MonitoringShipConfirmDO/ReadyToShipConfirm/ListDetailDo",
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
$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "MonitoringShipConfirmDO/OnProcess/ListProcess",
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
  });
});
