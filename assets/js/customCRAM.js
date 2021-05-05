$(document).ready(function () {
  var view = document.getElementById("ListVendorPenalty");
  if (view) {
    $.ajax({
      beforeSend: function () {
        $("div#DivTblListVendorPenalty").html(
          '<center><img style="width:100px; height:auto" src="' +
            baseurl +
            'assets/img/gif/loading11.gif"><br><label>Loading, Please Wait .....</label></center>'
        );
      },
      url: baseurl + "PenaltyCustomer/List/DataListVendor",
      success: function (response) {
        $("#DivTblListVendorPenalty").html(response);
        $("#TblListVendorPenalty").dataTable({
          paging: true,
          //   scrollX: true,
          //   scrollY: 500,
          info: true,
          searching: true,
        });
      },
    });
  }
});
$(document).ready(function () {
  var view = document.getElementById("divtabledetail");
  if (view) {
    var relasi = $("#relasi_id").val();
    $.ajax({
      beforeSend: function () {
        $("div#divtabledetail").html(
          '<center><img style="width:100px; height:auto" src="' +
            baseurl +
            'assets/img/gif/loading11.gif"><br><label>Loading, Please Wait .....</label></center>'
        );
      },
      url: baseurl + "PenaltyCustomer/List/TblDetailRelasi",
      data: {
        relasi: relasi,
      },
      type: "post",
      success: function (response) {
        $("#divtabledetail").html(response);
        $(".checksemuapenalty, .checkpenalty").iCheck({
          checkboxClass: "icheckbox_flat-green",
          radioClass: "iradio_flat-green",
        });
        $(document).on("ifChecked", ".checksemuapenalty", function () {
          $(".checkpenalty").iCheck("check");
        });
        $(document).on("ifUnchecked", ".checksemuapenalty", function () {
          $(".checkpenalty").iCheck("uncheck");
        });
        $("#TblListDetailPenalty").dataTable({
          paging: true,
          //   scrollX: true,
          //   scrollY: 500,
          info: true,
          searching: true,
        });
        $("#SlcCreateMultipleMiscRecipt").select2({
          allowClear: true,
          minimumResultsForSearch: Infinity,
        });
      },
    });
  }
});
function ModalCreateSingle(i) {
  var bayar = $("#total_byr_penalty" + i).val();
  var org = $("#org_id_penalty" + i).val();
  var inv_num = $("#invoice_num_penalty" + i).val();

  var request = $.ajax({
    url: baseurl + "PenaltyCustomer/List/ModalSingleRecipt",
    data: {
      bayar: bayar,
      org: org,
      inv_num: inv_num,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#misc_recipt").html(result);
    $("#mdl_create_recipt").modal("show");
    $("#datpckrrcptdate").datepicker({
      format: "yyyy/mm/dd",
      autoclose: true,
    });
    $("#SlcrcptMthd").select2({
      allowClear: true,
      // minimumInputLength: 0,
      minimumResultsForSearch: Infinity,
      ajax: {
        url: baseurl + "PenaltyCustomer/List/SelectReciptMethod",
        dataType: "json",
        type: "GET",
        data: function (params) {
          var queryParameters = {
            term: org,
          };
          return queryParameters;
        },
        processResults: function (data) {
          // console.log(data);
          return {
            results: $.map(data, function (obj) {
              return {
                id: obj.RECEIPT_METHOD_ID,
                text: obj.RECEIPT_METHOD,
              };
            }),
          };
        },
      },
    });
  });
}
function CreateMiscRecipt() {
  var inv_num = $("input[name ='inv_num[]']")
    .map(function () {
      return $(this).val();
    })
    .get();

  var nom_recipt = $("input[name ='nom_recipt[]']")
    .map(function () {
      return $(this).val();
    })
    .get();

  var org_id = $("input[name ='org_id[]']")
    .map(function () {
      return $(this).val();
    })
    .get();

  var recipt_method = $("select[name ='SlcrcptMthd']")
    .map(function () {
      return $(this).val();
    })
    .get();
  var receipt_date = $("input[name ='datpckrrcptdate']")
    .map(function () {
      return $(this).val();
    })
    .get();
  var comments = $("textarea[name ='commentsnyaa']")
    .map(function () {
      return $(this).val();
    })
    .get();

  // console.log(inv_num);
  $("#misc_recipt").css("display", "none");

  var request = $.ajax({
    url: baseurl + "PenaltyCustomer/List/CreateMiscRecipt",
    beforeSend: function () {
      $("div#loading_recipt").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"><br><label>Loading, Please Wait .....</label></center>'
      );
    },
    data: {
      nom_recipt: nom_recipt,
      org_id: org_id,
      inv_num: inv_num,
      recipt_method: recipt_method,
      receipt_date: receipt_date,
      comments: comments,
    },
    type: "POST",
    datatype: "html",
  });
  request.done(function (result) {
    // console.log(result);
    $("#mdl_create_recipt").modal("hide");
    Swal.fire({
      customClass: "swal-font-large",
      type: "success",
      title: "Berhasil",
      html: result,
      width: "800px",
    }).then(() => {
      window.location.reload();
    });
  });
}
function ModalCreateMultiple() {
  var value = $("#SlcCreateMultipleMiscRecipt").val();
  var organization = $("#organis_id").val();
  if (value == "CreateMultipleMiscRecipt") {
    var inv_num = [];
    var nom_penalty = [];
    var org_id = [];
    var chk = $(".checkpenalty").filter(":checked");
    $(chk).each(function () {
      var row_id = $(this).attr("data-row");
      var inv = $('.invoice_num_penalty[data-row="' + row_id + '"]').val();
      var nom = $('.total_byr_penalty[data-row="' + row_id + '"]').val();
      var org = $('.org_id_penalty[data-row="' + row_id + '"]').val();
      inv_num.push(inv);
      nom_penalty.push(nom);
      org_id.push(org);
    });
    var request = $.ajax({
      url: baseurl + "PenaltyCustomer/List/ModalMultipleRecipt",
      data: {
        nom_penalty: nom_penalty,
        org_id: org_id,
        inv_num: inv_num,
      },
      type: "POST",
      datatype: "html",
    });

    request.done(function (result) {
      // console.log(result);
      $("#misc_recipt").html(result);
      $("#mdl_create_recipt").modal("show");
      $("#datpckrrcptdate").datepicker({
        format: "yyyy/mm/dd",
        autoclose: true,
      });
      $("#SlcrcptMthd").select2({
        allowClear: true,
        // minimumInputLength: 0,
        minimumResultsForSearch: Infinity,
        ajax: {
          url: baseurl + "PenaltyCustomer/List/SelectReciptMethod",
          dataType: "json",
          type: "GET",
          data: function (params) {
            var queryParameters = {
              term: organization,
            };
            return queryParameters;
          },
          processResults: function (data) {
            // console.log(data);
            return {
              results: $.map(data, function (obj) {
                return {
                  id: obj.RECEIPT_METHOD_ID,
                  text: obj.RECEIPT_METHOD,
                };
              }),
            };
          },
        },
      });
    });
  }
}
