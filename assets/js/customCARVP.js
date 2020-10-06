$(document).ready(function () {
  $("#hsl_imprt").dataTable({
    paging: false,
    info: false,
    scrollX: true,
  });
  $("#list_CAR").dataTable({
    paging: false,
    info: false,
    order: [[3, "desc"]],
  });
  $("#list_CARR").dataTable({
    paging: false,
    info: false,
    order: [[4, "desc"]],
  });
  $("#edit_CAR").dataTable({
    paging: false,
    info: false,
    scrollX: true,
  });
  $(".car_date").datepicker({
    format: "dd-M-yy",
    autoclose: true,
  });
  $(".itemm_code").select2({
    allowClear: true,
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "CARVP/ListData/getItem",
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
              id: obj.KODE,
              text: obj.KODE + " - " + obj.DESKRIPSI,
            };
          }),
        };
      },
    },
  });
});
function ReqApprCAR(i) {
  var n = $("#car" + i).val();
  var request = $.ajax({
    url: baseurl + "CARVP/ListData/ReqApprove",
    data: {
      n: n,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#getAppr").html(result);
    $("#mdl_req_appr").modal("show");
    $("#approver_car").select2({
      allowClear: true,
      minimumInputLength: 0,
      ajax: {
        url: baseurl + "CARVP/ListData/getApprover",
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
                id: obj.noind,
                text: obj.noind + " - " + obj.nama,
              };
            }),
          };
        },
      },
    });
  });
}
function ApproveReqCAR(i) {
  var no_car = $("#car_num" + i).val();
  Swal.fire({
    title: "Anda Yakin?",
    text: "Data Akan Di Approve dan dikirim kepada Vendor",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes",
  }).then((result) => {
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "CARVPkoor/Approval/updateApprove",
        data: {
          no_car: no_car,
        },
        type: "POST",
        datatype: "html",
      });
      request.done(function (result) {
        if (result == "Pesan Tidak Terkirim!") {
          var t = "error";
        } else {
          var t = "success";
        }
        Swal.fire({
          position: "top",
          type: t,
          title: result + ", Status Approved",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.reload();
        });
      });
    }
  });
}
function detailCAR(no) {
  var no_car = $("#car_num" + no).val();
  var request = $.ajax({
    url: baseurl + "CARVPkoor/Approval/DetailCAR",
    data: {
      no_car: no_car,
    },
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    $("#getCAR").html(result);
    $("#mdl_det_car").modal("show");
    $("#detail_CAR").dataTable({
      paging: false,
      info: false,
      scrollX: true,
    });
  });
}
function deleteCAR(i) {
  var no_car = $("#car" + i).val();
  Swal.fire({
    title: "Anda Yakin?",
    text: "Data Akan Di Hapus",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes",
  }).then((result) => {
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "CARVP/ListData/Hapusdata",
        data: {
          no_car: no_car,
        },
        type: "POST",
        datatype: "html",
      });
      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Dihapus",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.reload();
        });
      });
    }
  });
}
function deleteItem(id) {
  Swal.fire({
    title: "Anda Yakin?",
    text: "Item Akan Di Hapus",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes",
  }).then((result) => {
    if (result.value) {
      var request = $.ajax({
        url: baseurl + "CARVP/ListData/HapusItem",
        data: {
          id: id,
        },
        type: "POST",
        datatype: "html",
      });
      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Dihapus",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.reload();
        });
      });
    }
  });
}
function getDescription(i) {
  var item = $("#car_item_code" + i).val();
  $.ajax({
    url: baseurl + "CARVP/ListData/getDescription",
    data: { item: item },
    dataType: "json",
    type: "POST",
    success: function (result) {
      console.log(result);
      $("#desc_item" + i).val(result[0]["DESKRIPSI"]);
      $("#uom_item" + i).val(result[0]["SATUAN"]);
    },
  });
}
