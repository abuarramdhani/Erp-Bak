$(".frm_create_memo_komisi_penjualan").on("submit", function (e) {
  $(".btnCrtMemoKomisi").attr("disabled", "disabled");
  $(".btnlayoutMemoKomisi").attr("disabled", "disabled");

  e.preventDefault();
  $.ajax({
    url: baseurl + "KomisiPenjualanMarketing/CreateMemo/ImportFileMemo",
    type: "POST",
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData: false,
    dataType: "html",
    beforeSend: function () {
      $("div.loadingMemoKomisi").html(
        '<img style="width:30px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif">'
      );
    },
    success: function (result) {
      // console.log(result);
      // window.location.reload();
      window.location.href = result;
      // win.focus();
    },
  });
});
function CreateInvoiceKomisi() {
  $("#BtnInvoiceMemoKoMisi").attr("disabled", "disabled");
  var value = $("#NomorMemoKoMisi").val();
  $.ajax({
    url: baseurl + "KomisiPenjualanAkuntansi/CreateInvoice/ApiCreateInvoice",
    type: "POST",
    data: {
      value: value,
    },
    dataType: "json",
    beforeSend: function () {
      $("div.loadingMemoKomisi").html(
        '<img style="width:30px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif">'
      );
    },
    success: function (result) {
      if ((result = "success")) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Create Invoice",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.reload();
        });
      } else {
        Swal.fire({
          position: "top",
          type: "error",
          title: "Ada nomor Invoice yang sama",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.reload();
        });
      }
    },
  });
}
