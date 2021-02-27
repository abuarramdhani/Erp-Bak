$("#list_SPB").dataTable({
  paging: true,
  info: false,
});
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
