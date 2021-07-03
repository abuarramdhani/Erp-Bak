$(document).ready(function () {
  var view = document.getElementById("MonitoringItemIntransit");
  if (view) {
    $(".IoItemIntransit").select2({
      allowClear: true,
      minimumInputLength: 0,
      ajax: {
        url: baseurl + "MonitoringItemIntransit/Monitoring/getIo",
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
                id: obj.ORGANIZATION_ID,
                text: obj.ORGANIZATION_CODE,
              };
            }),
          };
        },
      },
    });
    $("#IoItemIntransitFrom").on("change", function () {
      $("#SubInvIntransitFrom").removeAttr("disabled");
      $("#SubInvIntransitFrom").select2({
        allowClear: true,
        minimumInputLength: 0,
        ajax: {
          url: baseurl + "MonitoringItemIntransit/Monitoring/getSubinv",
          dataType: "json",
          type: "GET",
          data: function (params) {
            var queryParameters = {
              term: $("#IoItemIntransitFrom").val(),
            };
            return queryParameters;
          },
          processResults: function (data) {
            // console.log(data);
            return {
              results: $.map(data, function (obj) {
                return {
                  id: obj.SECONDARY_INVENTORY_NAME,
                  text:
                    "(" + obj.SECONDARY_INVENTORY_NAME + ") " + obj.DESCRIPTION,
                };
              }),
            };
          },
        },
      });
    });
    $("#IoItemIntransitTo").on("change", function () {
      $("#SubInvIntransitTo").removeAttr("disabled");
      $("#SubInvIntransitTo").select2({
        allowClear: true,
        minimumInputLength: 0,
        ajax: {
          url: baseurl + "MonitoringItemIntransit/Monitoring/getSubinv",
          dataType: "json",
          type: "GET",
          data: function (params) {
            var queryParameters = {
              term: $("#IoItemIntransitTo").val(),
            };
            return queryParameters;
          },
          processResults: function (data) {
            // console.log(data);
            return {
              results: $.map(data, function (obj) {
                return {
                  id: obj.SECONDARY_INVENTORY_NAME,
                  text:
                    "(" + obj.SECONDARY_INVENTORY_NAME + ") " + obj.DESCRIPTION,
                };
              }),
            };
          },
        },
      });
    });
    $(".DateItemIntransit").datepicker({
      format: "dd/mm/yyyy",
      autoclose: true,
    });
  }
});
function SearchItemInvItransit() {
  $.ajax({
    url: baseurl + "MonitoringItemIntransit/Monitoring/getDataItemItransit",
    type: "POST",
    dataType: "html",
    data: {
      io_from: $("#IoItemIntransitFrom").val(),
      subinv_from: $("#SubInvIntransitFrom").val(),
      io_to: $("#IoItemIntransitTo").val(),
      subinv_to: $("#SubInvIntransitTo").val(),
      date_from: $("#DateIntransitFrom").val(),
      date_to: $("#DateIntransitTo").val(),
    },
    beforeSend: function () {
      $("div#tabel_item_intransit").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
    success: function (result) {
      $("div#tabel_item_intransit").html(result);
      $(".TblMonIntransit").DataTable({
        paging: false,
        info: false,
        scrollCollapse: true,
        scrollX: true,
        scrollY: 500,
      });
    },
  });
}
