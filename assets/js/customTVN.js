function DetailTagihan(i) {
  //   console.log(s);
  var tgh = $("#nom_tgh" + i).val();
  var request = $.ajax({
    url: baseurl + "TagihanVendor/List/DetailTagihan",
    data: {
      tgh: tgh,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#tagihan_d").html(result);
    $("#mdl_tagihan_d").modal("show");
  });
}
