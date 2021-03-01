function DetailSPB(i) {
  //   console.log(s);
  var s = $("#no_spb" + i).val();
  var request = $.ajax({
    url: baseurl + "MonitoringSPB/List/DetailSPB",
    data: {
      s: s,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#tbl_spb").html(result);
    $("#mdl_detail_spb").modal("show");
  });
}
$(document).ready(function () {
  $(".status_spb").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });
});
$(document).ready(function () {
  $("#io_tjn").select2({
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
      url: baseurl + "MonitoringSPB/List/selectIOSpb",
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
              id: obj.ORGANIZATION_CODE,
              text: obj.ORGANIZATION_CODE,
            };
          }),
        };
      },
    },
  });
});
$(".search_spbeh").on("click", function () {
  var recipt_date = $("#rcpt_date").val();
  var io = $(".io_tjn").val();
  var status_transact = $("#stat_trans").val();
  var status_interorg = $("#stat_int").val();

  var request = $.ajax({
    url: baseurl + "MonitoringSPB/List/getListSPB",
    data: {
      recipt_date: recipt_date,
      io: io,
      status_transact: status_transact,
      status_interorg: status_interorg,
    },
    type: "POST",
    datatype: "html",
    beforeSend: function () {
      $("div#tbl_spb").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });

  request.done(function (result) {
    // console.log(result);
    $("div#tbl_spb").html(result);

    $("#list_SPB").DataTable({
      dom: "Bfrtip",
      buttons: [
        {
          extend: "excelHtml5",
          title: "",
          text: "Export Excel",

          exportOptions: {
            columns: ":visible",
            columns: [0, 1, 2, 3, 4, 5, 6, 7],
          },
        },
      ],
    });
  });
});
