const initDataTable = ($selector) =>
  $selector.DataTable({
    scrollX: true,
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        title: "Perhitungan Harga Sparepart Selesai",
        text: "Export",
        exportOptions: {
          columns: ":visible",
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        },
      },
    ],
  });

const swalConfirmation = Swal.mixin({
  customClass: "swal-font-small",
  confirmButtonText: "Ya",
});

const swalQuestion = swalConfirmation.mixin({
  cancelButtonText: "Tidak",
  cancelButtonColor: "#d33",
  showCancelButton: true,
});

const initSelect2 = ($selector, options) =>
  $selector.select2({
    ...options,
    width: "100%",
  });

const initSelect2Ajax = (
  $selector,
  { ajax: { url, processResults, type }, templateSelection }
) =>
  initSelect2($selector, {
    ajax: {
      url,
      type,
      processResults,
      dataType: "json",
      delay: 250,
      data: (params) => ({
        keyword: params.term,
      }),
    },
    minimumInputLength: 3,
    templateSelection,
  });

const initSelect2GetItems = ($selector) =>
  initSelect2Ajax($selector, {
    ajax: {
      type: "get",
      url: `${baseurl}PerhitunganHargaSparepart/Marketing/Input/getItemDetailsByKeyword`,
      processResults: (response) => ({
        results: response.map((v) => ({
          id: v.id,
          text: `${v.code}`,
          code: v.code,
          description: v.description,
        })),
      }),
    },
    templateSelection: (data) => {
      $(data.element)
        .parents("tr")
        .find(".txtPHSDescription")
        .val(data.description);
      return data.code;
    },
  });

const destroySelect2 = ($selector) => {
  if ($selector.data("select2")) {
    // NOTE!: cara ambil data attribute dari select2 ajax
    // const { code, description, id, text } = $selector.find(':selected').data().data;
    // $selector.data({
    //   code,
    //   description,
    //   id,
    //   text,
    // });
    $selector.select2("destroy");
  }
};

const initStylesheet = (...rules) => {
  const sheet = $(document.styleSheets).get(0);
  rules.forEach((rule) => {
    sheet.insertRule(rule, sheet.cssRules.length);
  });
};

$(".btnPHSAddRow").on("click", () => {
  const $row = $(/* html */ `
    <tr>
      <td class="t-body-middle">
        <!-- TODO: Reorder Number -->
        <span class="spnPHSRowNumber"></span>
      </td>
      <td class="t-body-middle">
        <input required type="text" class="form-control" name="product[]">
      </td>
      <td class="t-body-middle">
        <select required class="slc2PHSItem form-control" name="item_id[]"></select>
      </td>
      <td class="t-body-middle">
        <input type="text" class="txtPHSDescription form-control" readonly>
      </td>
      <td class="t-body-middle">
        <select required name="wrap_flag[]" class="slc2 form-control">
          <option selected="selected" disabled="disabled"></option>
          <option value="Y">Ya</option>
          <option value="N">Tidak</option>
        </select>
      </td>
      <td class="t-body-middle">
        <input required type="number" class="form-control" name="qty[]">
      </td>
      <td class="t-body-middle">
        <select required name="category[]" class="slc2 form-control">
          <option selected="selected" disabled="disabled"></option>
          <option value="VF">VF</option>
          <option value="F">F</option>
          <option value="M">M</option>
          <option value="S">S</option>
          <option value="VS">VS</option>
        </select>
      </td>
      <td class="t-body-middle">
        <select required name="competitor_flag[]" class="slc2 form-control">
          <option selected="selected" disabled="disabled"></option>
          <option value="Y">Ada</option>
          <option value="N">Tidak</option>
        </select>
      </td>
      <!-- TODO: Price Format 
      <td class="t-body-middle">
        <input required type="text" class="form-control" name="dpp_price_reference[]">
      </td> -->
      <td class="t-body-middle">
        <textarea required style="resize: vertical;" name="comments[]" class="form-control" rows="2"></textarea>
      </td>
      <td class="t-body-middle text-center">
        <button class="btn btn-danger btnPHSDeleteRow" type="button" data-toggle="tooltip"
          title="Hapus Baris Data">
          <i class="fa fa-times"></i>
        </button>
      </td>
    </tr>
  `);

  const $tbody = $(".tblPHSInput").children("tbody");
  const $rowClone = $row.clone();

  initSelect2($rowClone.find(".slc2"));
  initSelect2GetItems($rowClone.find(".slc2PHSItem"));
  $tbody.append($rowClone);
  $(".tblPHSInput").trigger("formatRowNumbers");
});

$(".tblPHSInput").on("click", ".btnPHSDeleteRow", (el) => {
  swalQuestion
    .fire({
      type: "question",
      title: "Apakah Anda yakin ingin menghapus baris data ini?",
      text: "Proses ini tidak dapat dibatalkan",
    })
    .then(({ value }) => {
      if (value) {
        $(el.currentTarget).parents("tr").remove();
        $(".tblPHSInput").trigger("formatRowNumbers");
      }
    });
});

$(".tblPHSInput").on("formatRowNumbers", () => {
  const $tbody = $(".tblPHSInput").children("tbody");
  const $rowNumbers = $tbody.find(".spnPHSRowNumber");

  $rowNumbers.each((i, el) => {
    $(el).html(i + 1);
  });
});

$(".frmPHSInput").on("submit", (e) => {
  const $tbody = $(".tblPHSInput").children("tbody");
  const rowLength = $tbody.children().length;

  e.preventDefault();

  if (rowLength === 0) {
    swalConfirmation.fire({
      type: "warning",
      title: "Data yang Anda berikan belum sesuai",
      text: "Silahkan mengisikan data setidaknya 1 baris terlebih dahulu",
    });
  } else {
    swalQuestion
      .fire({
        type: "question",
        title: "Apakah data yang Anda berikan sudah benar?",
        text: "Data yang Anda tulis akan disimpan kedalam database",
      })
      .then(({ value }) => {
        if (value) {
          $(e.currentTarget).unbind("submit").trigger("submit");
        }
      });
  }
});

$(() => {
  initStylesheet(
    `.t-head-center {
      vertical-align: middle !important;
      text-align: center;
    }`,
    `.t-body-middle {
      vertical-align: middle !important;
    }
    `
  );
  initSelect2($(".slc2"));
  initSelect2GetItems($(".slc2PHSItem"));
  initDataTable($(".tblPHSView"));
  $(".btnPHSAddRow").trigger("click");
});
$(document).ready(function () {
  $(".tblPHSViewApproval").DataTable({
    scrollX: true,
    paging: false,
    scrollCollapse: true,
    scrollY: 500,
  });
  $(".CheckAprop").iCheck({
    checkboxClass: "icheckbox_flat-green",
  });
  $(".CheckSprAll, .CheckSprlist").iCheck({
    checkboxClass: "icheckbox_flat-blue",
  });
  $(".CheckSprAllMkt, .CheckSprlistMkt").iCheck({
    checkboxClass: "icheckbox_flat-blue",
  });
  $(document).on("ifChecked", ".CheckSprAll", function () {
    $(".CheckSprlist").iCheck("check");
  });
  $(document).on("ifUnchecked", ".CheckSprAll", function () {
    $(".CheckSprlist").iCheck("uncheck");
  });
  $(document).on("ifChecked", ".CheckSprAllMkt", function () {
    $(".CheckSprlistMkt").iCheck("check");
  });
  $(document).on("ifUnchecked", ".CheckSprAllMkt", function () {
    $(".CheckSprlistMkt").iCheck("uncheck");
  });
});
function ApproveMkt(i) {
  // console.log("haha");
  var request = $.ajax({
    url:
      baseurl + "PerhitunganHargaSparepart/Marketing/ReqApprove/ShowModalAprop",
    data: {
      i: i,
    },
    type: "POST",
    datatype: "html",
  });
  request.done(function (result) {
    $("#mdl_approve_mkt_kasi").modal("show");
    $("#approve_mkt_kasi").html(result);
    $(".piea_user").select2();
  });
}
function ApprMktToPIEA() {
  var chk = $(".CheckSprlistMkt").filter(":checked");
  order_id = [];
  $(chk).each(function () {
    var row_id = $(this).attr("data-row");
    var order_to_push = $('.NoOrdermkt[data-row="' + row_id + '"]').val();
    order_id.push(order_to_push);
  });

  var request = $.ajax({
    url:
      baseurl + "PerhitunganHargaSparepart/Marketing/ReqApprove/ApprMktToPIEA",
    data: {
      i: order_id,
      // piea_approver: piea_approver,
    },
    type: "POST",
    datatype: "html",
  });
  request.done(function (result) {
    Swal.fire({
      type: "success",
      title: "Berhasil Approve",
    }).then(() => {
      window.location.reload();
    });
  });
}
function RejectMkt() {
  var chk = $(".CheckSprlistMkt").filter(":checked");
  order_id = [];
  $(chk).each(function () {
    var row_id = $(this).attr("data-row");
    var order_to_push = $('.NoOrdermkt[data-row="' + row_id + '"]').val();
    order_id.push(order_to_push);
  });
  const { value: alasan } = Swal.fire({
    title: "Masukan Alasan",
    input: "text",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#d73925",
    cancelButtonColor: "#b0bec5",
    confirmButtonText: "Ok",
    cancelButtonText: "Cancel",
    inputValidator: (value) => {
      if (!value) {
        return "Masukan Alasan!";
      }
      if (value) {
        var request = $.ajax({
          url:
            baseurl +
            "PerhitunganHargaSparepart/Marketing/ReqApprove/RejectMkt",
          data: {
            id: order_id,
            alasan: value,
          },
          type: "POST",
          datatype: "html",
        });
        request.done(function (result) {
          Swal.fire({
            position: "top",
            type: "success",
            title: "Request Ditolak",
            showConfirmButton: false,
            timer: 1500,
          }).then(() => {
            window.location.reload();
          });
        });
      }
    },
  });
}

function ApprovePIEA(i) {
  var master_item = $("#checkApropMKTMastItem" + i).val();
  var bom = $("#checkApropMKTBOM" + i).val();
  var routing = $("#checkApropMKTRouting" + i).val();
  var chk = 0;
  // console.log(master_item, bom, routing);
  if (master_item == "" || master_item == null) {
  } else {
    chk += 1;
  }
  if (bom == "" || bom == null) {
  } else {
    chk += 1;
  }
  if (routing == "" || routing == null) {
  } else {
    chk += 1;
  }
  // console.log(chk);
  if (master_item == "N") {
    Swal.fire({
      type: "error",
      title:
        "Tidak Bisa Melanjutkan Proses, Masih ada item yang data belum lengkap",
      showConfirmButton: true,
    });
  } else if (bom == "N") {
    Swal.fire({
      type: "error",
      title:
        "Tidak Bisa Melanjutkan Proses, Masih ada item yang data belum lengkap",
      showConfirmButton: true,
    });
  } else if (routing == "N") {
    Swal.fire({
      type: "error",
      title:
        "Tidak Bisa Melanjutkan Proses, Masih ada item yang datanya belum lengkap",
      showConfirmButton: true,
    });
  } else if (chk == 3) {
    Swal.fire({
      title: "Apa Anda Yakin data Komponen yg anda isi sudah benar?",
      text: "Request ini akan di Approve",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#00a65a",
      cancelButtonColor: "#d73925",
      confirmButtonText: "Ya",
      cancelButtonText: "Tidak",
    }).then((result) => {
      if (result.value) {
        // console.log("approve");
        var request = $.ajax({
          url: baseurl + "PerhitunganHargaSparepart/PIEA/ApprovePIEA",
          data: {
            i: i,
            master_item: master_item,
            bom: bom,
            routing: routing,
          },
          type: "POST",
          datatype: "html",
        });
        request.done(function (result) {
          Swal.fire({
            position: "top",
            type: "success",
            title: "Berhasil Approve",
            showConfirmButton: false,
            timer: 1500,
          }).then(() => {
            window.location.reload();
          });
        });
      }
    });
  } else {
    Swal.fire({
      type: "error",
      title:
        "Tidak Bisa Melanjutkan Proses, Pilihan pada kolom komponen belum lengkap",
      showConfirmButton: true,
    });
  }
}
function RejectPIEA(i) {
  const { value: alasan } = Swal.fire({
    title: "Masukan Alasan",
    input: "text",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#d73925",
    cancelButtonColor: "#b0bec5",
    confirmButtonText: "Ok",
    cancelButtonText: "Cancel",
    inputValidator: (value) => {
      if (!value) {
        return "Masukan Alasan!";
      }
      if (value) {
        var request = $.ajax({
          url: baseurl + "PerhitunganHargaSparepart/PIEA/RejectPIEA",
          data: {
            id: i,
            alasan: value,
          },
          type: "POST",
          datatype: "html",
        });
        request.done(function (result) {
          Swal.fire({
            position: "top",
            type: "success",
            title: "Request Ditolak",
            showConfirmButton: false,
            timer: 1500,
          }).then(() => {
            window.location.reload();
          });
        });
      }
    },
  });
}
function ChangeButtonApproveAkt() {
  var ref = $("#ref_harga").val();
  if (ref == null || ref == "") {
    $("#btnApprAkt").attr("disabled", "disabled");
  } else {
    $("#btnApprAkt").removeAttr("disabled", "disabled");
  }

  // console.log(ref);
}
function RejectAkt() {
  var i = 1;
  const { value: alasan } = Swal.fire({
    title: "Masukan Alasan",
    input: "text",
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#d73925",
    cancelButtonColor: "#b0bec5",
    confirmButtonText: "Ok",
    cancelButtonText: "Cancel",
    inputValidator: (value) => {
      if (!value) {
        return "Masukan Alasan!";
      }
      if (value) {
        var request = $.ajax({
          url: baseurl + "PerhitunganHargaSparepart/Accountancy/RejectAkt",
          data: {
            id: i,
            alasan: value,
          },
          type: "POST",
          datatype: "html",
        });
        request.done(function (result) {
          Swal.fire({
            position: "top",
            type: "success",
            title: "Request Ditolak",
            showConfirmButton: false,
            timer: 1500,
          }).then(() => {
            window.location.reload();
          });
        });
      }
    },
  });
}
$(".frm_Appr_Akt").on("submit", function (e) {
  e.preventDefault();
  $.ajax({
    url: baseurl + "PerhitunganHargaSparepart/Accountancy/ApproveAkt",
    type: "POST",
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData: false,
    dataType: "json",
    success: function (result) {
      var chk = $(".CheckSprlist").filter(":checked");
      // console.log(chk);
      order_id = [];
      $(chk).each(function () {
        var row_id = $(this).attr("data-row");
        var order_to_push = $('.no_order_nya[data-row="' + row_id + '"]').val();
        order_id.push(order_to_push);
      });
      var request = $.ajax({
        url: baseurl + "PerhitunganHargaSparepart/Accountancy/ApproveAkttbl",
        data: {
          order_id: order_id,
          result: result,
        },
        dataType: "html",
        type: "post",
      });
      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Order Finished",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.reload();
        });
      });
    },
  });
});
