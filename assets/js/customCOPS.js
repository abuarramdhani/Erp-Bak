function inputangka(e, decimal) {
  var key;
  var keychar;
  if (window.event) {
    key = window.event.keyCode;
  } else if (e) {
    key = e.which;
  } else return true;
  keychar = String.fromCharCode(key);
  if (
    key == null ||
    key == 0 ||
    key == 8 ||
    key == 9 ||
    key == 13 ||
    key == 27
  ) {
    return true;
  } else if ("0123456789.".indexOf(keychar) > -1) {
    return true;
  } else if (decimal && keychar == ".") {
    return true;
  } else return false;
}
$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "ConsumablePPIC/MasterItem/loadview",
    type: "POST",
    beforeSend: function () {
      $("div#tabel_master_item").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    // console.log(result);
    $("div#tabel_master_item").html(result);
    $("#master_item").DataTable({
      scrollX: true,
      scrollY: 400,
      scrollCollapse: true,
      paging: true,
      info: true,
      searching: true,
    });
  });
});

function additem() {
  var request = $.ajax({
    url: baseurl + "ConsumablePPIC/MasterItem/additem",
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#additem").html(result);
    $("#modaladditem").modal("show");
    $("#ItemConsum").select2({
      allowClear: true,
      minimumInputLength: 1,
      ajax: {
        url: baseurl + "ConsumablePPIC/MasterItem/Itemmm",
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
                id: obj.ITEM_CODE,
                text: obj.ITEM_CODE + " - " + obj.DESCRIPTION,
              };
            }),
          };
        },
      },
    });
    $("#ItemConsum").on("change", function () {
      var item = $("#ItemConsum").val();
      $.ajax({
        url: baseurl + "ConsumablePPIC/MasterItem/cekItem",
        type: "POST",
        dataType: "json",
        data: { item: item },
        success: function (result) {
          // console.log(result);
          if (result == "ada") {
            $(".btn-add-master-item").attr("disabled", "disabled");
            Swal.fire({
              type: "error",
              title: "Tidak dapat melanjutkan proses",
              text: "Item ini sudah terdaftar",
            }).then(() => {
              $("#DescConsum").val("");
              $("#SatuanConsum").val("");
            });
          } else {
            $(".btn-add-master-item").removeAttr("disabled");
          }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          $.toaster(textStatus + " | " + errorThrown, name, "danger");
        },
      });
    });
    $("#ItemConsum").on("change", function () {
      var item = $("#ItemConsum").val();

      $.ajax({
        url: baseurl + "ConsumablePPIC/MasterItem/getDesc",
        type: "POST",
        dataType: "json",
        data: { item: item },
        beforeSend: function () {
          $("#DescConsum").val("Loading....");
        },
        success: function (result) {
          // console.log(result);
          $("#DescConsum").val(result);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          $.toaster(textStatus + " | " + errorThrown, name, "danger");
        },
      });
    });

    $("#ItemConsum").on("change", function () {
      var item = $("#ItemConsum").val();
      $.ajax({
        url: baseurl + "ConsumablePPIC/MasterItem/getUom",
        type: "POST",
        dataType: "json",
        data: { item: item },
        beforeSend: function () {
          $("#SatuanConsum").val("Loading....");
        },
        success: function (result) {
          // console.log(result);
          $("#SatuanConsum").val(result);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          $.toaster(textStatus + " | " + errorThrown, name, "danger");
        },
      });
    });
    $(".btn-add-master-item").on("click", function () {
      var ItemConsum = $("#ItemConsum").val();
      var DescConsum = $("#DescConsum").val();
      var SatuanConsum = $("#SatuanConsum").val();

      $.ajax({
        url: baseurl + "ConsumablePPIC/MasterItem/InsertMasterItem",
        type: "POST",
        dataType: "html",
        data: {
          ItemConsum: ItemConsum,
          DescConsum: DescConsum,
          SatuanConsum: SatuanConsum,
        },
        success: function (result) {
          Swal.fire({
            type: "success",
            title: "Berhasil",
          }).then(() => {
            $("#modaladditem").modal("hide");
            window.location.reload();
          });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          $.toaster(textStatus + " | " + errorThrown, name, "danger");
        },
      });
    });
  });
}

function lihatkebutuhanseksi(th, no) {
  var title = $(th).text();
  $("#lihatkebutuhanseksi" + no).slideToggle("slow");

  $(document).on("ifChecked", ".checksemwa" + no, function () {
    $(".daftarcheck" + no).iCheck("check");
  });

  $(document).on("ifUnchecked", ".checksemwa" + no, function () {
    $(".daftarcheck" + no).iCheck("uncheck");
  });

  $(".btn-Update-Approve-PPIC" + no).on("click", function () {
    var chk = $(".daftarcheck" + no).filter(":checked");
    var item = [];
    var id = [];
    $(chk).each(function () {
      var row_id = $(this).attr("data-row");
      var itemm = $('.ItemApprove[data-row="' + row_id + '"]').val();
      item.push(itemm);
      var idd = $('.IdApprove[data-row="' + row_id + '"]').val();
      id.push(idd);
    });
    $.ajax({
      type: "POST",
      url: baseurl + "ConsumablePPIC/Datamasuk/UpdateApprovePPIC",
      data: {
        item: item,
        id: id,
      },
      beforeSend: function () {
        $("div#lihatkebutuhanseksi" + no).html(
          '<center><img style="width:100px; height:auto" src="' +
            baseurl +
            'assets/img/gif/loading11.gif"></center>'
        );
      },
      success: function (response) {
        Swal.fire({
          type: "success",
          title: "Berhasil",
        }).then(() => {
          window.location.reload();
        });
      },
    });
  });
  $(".btn-Update-Reject-PPIC" + no).on("click", function () {
    var chk = $(".daftarcheck" + no).filter(":checked");
    var item = [];
    var id = [];
    $(chk).each(function () {
      var row_id = $(this).attr("data-row");
      var itemm = $('.ItemApprove[data-row="' + row_id + '"]').val();
      item.push(itemm);
      var idd = $('.IdApprove[data-row="' + row_id + '"]').val();
      id.push(idd);
    });
    $.ajax({
      type: "POST",
      url: baseurl + "ConsumablePPIC/Datamasuk/UpdateRejectPPIC",
      data: {
        item: item,
        id: id,
      },
      beforeSend: function () {
        $("div#lihatkebutuhanseksi" + no).html(
          '<center><img style="width:100px; height:auto" src="' +
            baseurl +
            'assets/img/gif/loading11.gif"></center>'
        );
      },
      success: function (response) {
        Swal.fire({
          type: "success",
          title: "Request di Reject",
        }).then(() => {
          window.location.reload();
        });
      },
    });
  });
}
function showdetailbon(th, no) {
  var title = $(th).text();
  $("#det" + no).slideToggle("slow");
}

// -------------------------------------- Consumable Seksi ----------------------------------------------------- //

$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "ConsumableSEKSI/Inputkebutuhan/loadvieww",
    type: "POST",
    beforeSend: function () {
      $("div#tabel_kebutuhan").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    // console.log(result);
    $("div#tabel_kebutuhan").html(result);
    $("#daftar_kebutuhan").DataTable({
      scrollX: true,
      scrollY: 400,
      scrollCollapse: true,
      paging: true,
      info: true,
      searching: true,
    });
  });
});

function addkebutuhan() {
  var request = $.ajax({
    url: baseurl + "ConsumableSEKSI/Inputkebutuhan/addkebutuhan",
    type: "POST",
    datatype: "html",
  });

  request.done(function (result) {
    // console.log(result);
    $("#addkebutuhan").html(result);
    $("#modaladdkebutuhan").modal("show");
    $("#item_kebutuhan_consum1").select2({
      allowClear: true,
      minimumInputLength: 1,
      ajax: {
        url: baseurl + "ConsumableSEKSI/Inputkebutuhan/Itemmm",
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
                id: obj.item_code,
                text: obj.item_code + " - " + obj.item_desc,
              };
            }),
          };
        },
      },
    });
    $("#item_kebutuhan_consum1").on("change", function () {
      var item = $("#item_kebutuhan_consum1").val();

      $.ajax({
        url: baseurl + "ConsumableSEKSI/Inputkebutuhan/getDesc",
        type: "POST",
        dataType: "json",
        data: { item: item },
        beforeSend: function () {
          $("#desc_kebutuhan_consum1").val("Loading....");
        },
        success: function (result) {
          // console.log(result);
          $("#desc_kebutuhan_consum1").val(result);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          $.toaster(textStatus + " | " + errorThrown, name, "danger");
        },
      });
    });

    var button = document.getElementById("addnewneed");
    button.onclick = function () {
      var q = $("#urutan_kebutuhan").val();
      var a = parseFloat(q) + parseFloat(1);
      var itemsudahterpilih = [];
      $('select[name="item_kebutuhan_consum[]"]').each(function () {
        itemsudahterpilih.push($(this).val());
      });
      // console.log(itemsudahterpilih);
      $("#tambahannya_disini").append(
        '<tr><td class="text-center" style="width:50%"><select class="form-control select2 item_kebutuhan_consum" id="item_kebutuhan_consum' +
          a +
          '" style="width:100%" data-placeholder="Pilih Item" name="item_kebutuhan_consum[]" required="required"></select></td><td class="text-center" style="width:30%"><input type="text" class="form-control" id="desc_kebutuhan_consum' +
          a +
          '" readonly="readonly" /></td><td class="text-center"><input type="text" class="form-control" id="qty_kebutuhan_consum' +
          a +
          '" name="qty_kebutuhan_consum[]" /></td></tr>'
      );
      $("#urutan_kebutuhan").val(a);
      $("#item_kebutuhan_consum" + a).select2({
        allowClear: true,
        minimumInputLength: 1,
        ajax: {
          url: baseurl + "ConsumableSEKSI/Inputkebutuhan/Itemmm",
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
                  id: obj.item_code,
                  text: obj.item_code + " - " + obj.item_desc,
                };
              }),
            };
          },
        },
      });
      $("#item_kebutuhan_consum" + a).on("change", function () {
        var item = $("#item_kebutuhan_consum" + a).val();
        if (item != null) {
          $.ajax({
            url: baseurl + "ConsumableSEKSI/Inputkebutuhan/cekItem",
            type: "POST",
            dataType: "json",
            data: {
              item: item,
              itemsudahterpilih: itemsudahterpilih,
            },
            success: function (result) {
              if (result == 0) {
                // console.log(result);
                $.ajax({
                  url: baseurl + "ConsumableSEKSI/Inputkebutuhan/getDesc",
                  type: "POST",
                  dataType: "json",
                  data: { item: item },
                  beforeSend: function () {
                    $("#desc_kebutuhan_consum" + a).val("Loading....");
                  },
                  success: function (result) {
                    // console.log(result);
                    $("#desc_kebutuhan_consum" + a).val(result);
                  },
                  error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $.toaster(textStatus + " | " + errorThrown, name, "danger");
                  },
                });
              } else {
                Swal.fire({
                  type: "error",
                  title: "Maaf",
                  text: "Item tidak boleh sama",
                }).then(() => {
                  $("#item_kebutuhan_consum" + a).select2("val", "");
                });
              }
            },
          });
        }
      });
    };
  });
}
function insertkebutuhan() {
  var item_kebutuhan_consum = [];
  $('select[name="item_kebutuhan_consum[]"]').each(function () {
    item = $(this).val();
    if (item != null) {
      item_kebutuhan_consum.push(item);
    } else {
    }
  });
  var qty_kebutuhan_consum = [];
  $('input[name="qty_kebutuhan_consum[]"]').each(function () {
    var qty = $(this).val();
    if (qty != "") {
      qty_kebutuhan_consum.push(qty);
    } else {
    }
  });
  $.ajax({
    url: baseurl + "ConsumableSEKSI/Inputkebutuhan/insertkebutuhan",
    type: "POST",
    dataType: "html",
    data: {
      item_kebutuhan_consum: item_kebutuhan_consum,
      qty_kebutuhan_consum: qty_kebutuhan_consum,
    },
    success: function (result) {
      $("#modaladdkebutuhan").modal("hide");
      Swal.fire({
        type: "success",
        title: "Berhasil",
      }).then(() => {
        window.location.reload();
      });
    },
  });
}
$(document).ready(function () {
  $("#tbl_approval_kebutuhan").DataTable({
    scrollX: true,
    scrollY: 400,
    scrollCollapse: true,
    paging: false,
    info: false,
    searching: true,
    ordering: false,
    select: {
      style: "multi",
      selector: "td:nth-child(2)",
    },
  });
});

$(document).on("ifChecked", ".checkAll", function () {
  $(".checkUpdate").iCheck("check");
  var chk = $(".checkUpdate").filter(":checked");
});
$(document).on("ifUnchecked", ".checkAll", function () {
  $(".checkUpdate").iCheck("uncheck");
});
$(".btn-Update-Approve").on("click", function () {
  var chk = $(".checkUpdate").filter(":checked");

  console.log(chk);
  var item = [];
  var id = [];
  $(chk).each(function () {
    var row_id = $(this).attr("data-row");
    var itemtopush = $('.itemUpdate[data-row="' + row_id + '"]').val();
    item.push(itemtopush);
    var idtopush = $('.idUpdate[data-row="' + row_id + '"]').val();
    id.push(idtopush);
  });
  $.ajax({
    type: "POST",
    url: baseurl + "ConsumableSEKSI/Approval/UpdateApproveAtasan",
    data: {
      item: item,
      id: id,
    },
    beforeSend: function () {
      $("div#tbl_approval").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
    success: function (response) {
      Swal.fire({
        type: "success",
        title: "Berhasil",
      }).then(() => {
        window.location.reload();
      });
    },
  });
});
$(".btn-Update-reject").on("click", function () {
  var chk = $(".checkUpdate").filter(":checked");
  var item = [];
  var id = [];

  $(chk).each(function () {
    var row_id = $(this).attr("data-row");
    var itemtopush = $('.itemUpdate[data-row="' + row_id + '"]').val();
    item.push(itemtopush);
    var idtopush = $('.idUpdate[data-row="' + row_id + '"]').val();
    id.push(idtopush);
  });

  $.ajax({
    type: "POST",
    url: baseurl + "ConsumableSEKSI/Approval/UpdateRejectAtasan",
    data: {
      item: item,
      id: id,
    },
    beforeSend: function () {
      $("div#tbl_approval").html(
        '<center><img id="loading_bon" style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
    success: function (response) {
      Swal.fire({
        type: "success",
        title: "Request di Reject",
      }).then(() => {
        window.location.reload();
      });
    },
  });
});
$(document).ready(function () {
  $("input.periodebon").monthpicker({
    changeYear: true,
    dateFormat: "yy-mm",
  });

  $(".periodebon").change(function () {
    var d = new Date();
    var n = d.getFullYear();
    var m = d.getMonth() + 01;
    if (m < 10) {
      m = "0" + m;
    }
    console.log(m);
    var v = $(this).val().split("-");
    if (v[0] < n) {
      Swal.fire(
        "Tidak dapat melanjutkan proses",
        "Tahun tidak boleh lebih kecil dari tahun sekarang",
        "warning"
      );
      $(this).val(pad(n) + "-" + m);
    } else if (v[1] > n) {
      //oke
    } else if (v[1] < m) {
      Swal.fire(
        "Tidak dapat melanjutkan proses",
        "Bulan tidak boleh lebih kecil dari bulan sekarang",
        "warning"
      );
      $(this).val(pad(n) + "-" + m);
    }
  });
});
$(document).ready(function () {
  $("input.periodebonn").monthpicker({
    changeYear: true,
    dateFormat: "yy-mm",
  });
});

function caridatabon() {
  var tanggal = $("#periodebon").val();
  if (tanggal == null) {
    $("#seksi_pengebonn").attr("disabled", "disabled");
  } else {
    $("#seksi_pengebonn").removeAttr("disabled");
  }
  // console.log(tanggal);
  var request = $.ajax({
    url: baseurl + "ConsumableSEKSI/Inputbon/loadtbodybon",
    data: { tanggal: tanggal },
    dataType: "html",
    type: "POST",
    beforeSend: function () {
      $("div#loadingbon").html(
        '<center><img id="loading_bon" style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    $("#tbodybon").html(result);
    $("#loading_bon").remove();
  });
}

function hitungsaldo(a) {
  $("#daftarbon" + a).iCheck("check");

  // console.log("onkeyup");
  var bon = $("#qtytobon" + a).val();
  var saldo = $("#kebutuhan" + a).val();
  var item = $("#itembon" + a).val();

  if (bon == "") {
    bon = 0;
  }
  var hasil = parseInt(saldo) - parseInt(bon);
  $("#saldotobon" + a).val(hasil);
  $("#qtytobon2" + a).val(bon);
  $("#saldotobontd" + a).html(hasil);

  if (parseInt(bon) > parseInt(saldo)) {
    Swal.fire(
      "Jumlah Bon tidak bisa melebihi Saldo",
      "*Saldo Item (" + item + ") = " + saldo,
      "warning"
    );
    $("#qtytobon" + a).val("");
    $("#saldotobon" + a).val(saldo);
    $("#saldotobontd" + a).html(saldo);
  }
}

$(document).on("ifChecked", ".bonsemwa", function () {
  $(".daftarbon").iCheck("check");
});
$(document).on("ifUnchecked", ".bonsemwa", function () {
  $(".daftarbon").iCheck("uncheck");
});

$(".btn-Bon").on("click", function () {
  var chk = $(".daftarbon").filter(":checked");
  var item = [];
  var kebutuhan = [];
  var qtybon = [];
  var saldo = [];
  var seksi_bon = $("#seksi_pengebon").val();
  var pemakai = $("#seksi_pemakai").val();
  var bon_ke = $("#subinvbon2").val();
  var seksi_pakai = $("#cocenter").val();
  var branch = $("#KoCab").val();
  var untuk = $("#tujuan_guna").val();
  var periodebon = $("#periodebon").val();
  var lokasi_bon = $("#lokasi_bon_id").val();

  $(chk).each(function () {
    var row_id = $(this).attr("data-row");
    var itemtopush = $('.itembon[data-row="' + row_id + '"]').val();
    item.push(itemtopush);
    var kebutuhantopush = $('.kebutuhan[data-row="' + row_id + '"]').val();
    kebutuhan.push(kebutuhantopush);
    var qtybontopush = $('.qtytobon[data-row="' + row_id + '"]').val();
    if (qtybontopush == "" || qtybontopush == 0) {
    } else {
      qtybon.push(qtybontopush);
    }
    var saldotopush = $('.saldotobon[data-row="' + row_id + '"]').val();
    saldo.push(saldotopush);
  });

  var qtytoinsert = qtybon.length;
  var chkk = chk.length;

  // console.log(chkk);

  if (chkk != 0) {
    if (seksi_pakai == "") {
      Swal.fire(
        "Tidak Bisa Melanjutkan Proses Bon",
        "Mohon Inputkan seksi",
        "warning"
      );
    } else if (untuk == "") {
      Swal.fire(
        "Tidak Bisa Melanjutkan Proses Bon",
        "Pilih tujuan penggunaan",
        "warning"
      );
    } else if (qtytoinsert != chkk) {
      Swal.fire(
        "Tidak Bisa Melanjutkan Proses Bon",
        "Mohon Inputkan jumlah bon yang masih kosong",
        "warning"
      );
    } else {
      var request = $.ajax({
        type: "POST",
        url: baseurl + "ConsumableSEKSI/Inputbon/Insertbon",
        data: {
          item: item,
          kebutuhan: kebutuhan,
          qtybon: qtybon,
          saldo: saldo,
          seksi_bon: seksi_bon,
          seksi_pakai: seksi_pakai,
          bon_ke: bon_ke,
          branch: branch,
          untuk: untuk,
          periodebon: periodebon,
          lokasi_bon: lokasi_bon,
          pemakai: pemakai,
        },
        beforeSend: function () {
          $("div#loadingkartubon").html(
            '<center><img id="loading_bon" style="width:100px; height:auto" src="' +
              baseurl +
              'assets/img/gif/loading11.gif"></center>'
          );
        },
      });
      request.done(function (result) {
        console.log(result);
        window.location.reload();
        var win = window.open(result, "_blank");
        win.focus();
      });
    }
  } else {
    Swal.fire(
      "Tidak Bisa Melanjutkan Proses Bon",
      "Pilih minimal 1 item untuk melakukan Bon",
      "warning"
    );
  }
});
$(document).ready(function () {
  $("#seksi_pengebonn").select2({
    allowClear: true,
    minimumInputLength: 1,
    ajax: {
      url: baseurl + "ConsumableSEKSI/Inputbon/searchseksi",
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
              id: obj.COST_CENTER,
              text: obj.COST_CENTER + " - " + obj.PEMAKAI,
            };
          }),
        };
      },
    },
  });
  $("#seksi_pengebonn").on("change", function () {
    var cost = $(this).val();
    $.ajax({
      type: "POST",
      data: { cost: cost },
      url: baseurl + "ConsumableSEKSI/Inputbon/getBranch",
      success: function (result) {
        console.log(result);
        $("#cocenter").val(cost);
        $("#KoCab").val(result.replace(/"/g, ""));
      },
    });
    $.ajax({
      type: "POST",
      data: { cost: cost },
      url: baseurl + "ConsumableSEKSI/Inputbon/getPemakai",
      success: function (result) {
        console.log(result);
        $("#cocenter").val(cost);
        $("#seksi_pemakai").val(result.replace(/"/g, ""));
      },
    });
  });
});
$(document).ready(function () {
  $("#seksi_pengebonn").on("change", function () {
    var value = $(this).val();
    console.log(value);
    $.ajax({
      type: "POST",
      data: { cc: value },
      url: baseurl + "ConsumableSEKSI/Inputbon/penggunaan",
      success: function (result) {
        console.log(result);
        $("#tujuan_guna").removeAttr("disabled");
        $("#tujuan_guna").html(result);
      },
    });
  });
});
function caridatabonseksi() {
  var tanggal = $("#periodebonseksi").val();
  var seksi = $("#seksibonseksi").val();

  // console.log(tanggal);
  var request = $.ajax({
    url: baseurl + "ConsumableSEKSI/Monitoringbon/loadtblmonitor",
    data: {
      tanggal: tanggal,
      seksi: seksi,
    },
    dataType: "html",
    type: "POST",
    beforeSend: function () {
      $("div#tblmonitor").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    $("div#tblmonitor").html(result);
  });
}
function caridatabonppic() {
  var tanggal = $("#periodebonseksi").val();
  var seksi = $("#pilseksi").val();

  // console.log(tanggal);
  var request = $.ajax({
    url: baseurl + "ConsumablePPIC/Monitoringbon/loadtblmonitor",
    data: {
      tanggal: tanggal,
      seksi: seksi,
    },
    dataType: "html",
    type: "POST",
    beforeSend: function () {
      $("div#tblmonitorppic").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    $("div#tblmonitorppic").html(result);
  });
}
// $(document).ready(function () {
//   var tanggal = null;
//   // console.log(tanggal);
//   var request = $.ajax({
//     url: baseurl + "ConsumableSEKSI/Monitoringbon/loadtblmonitor",
//     data: { tanggal: tanggal },
//     dataType: "html",
//     type: "POST",
//     beforeSend: function () {
//       $("div#tblmonitor").html(
//         '<center><img style="width:100px; height:auto" src="' +
//           baseurl +
//           'assets/img/gif/loading11.gif"></center>'
//       );
//     },
//   });
//   request.done(function (result) {
//     $("div#tblmonitor").html(result);
//   });
// });
function printulangkartubon(no) {
  // console.log(no);
  var request = $.ajax({
    type: "POST",
    url: baseurl + "ConsumableSEKSI/Monitoringbon/printpdf",
    data: {
      no: no,
    },
    beforeSend: function () {
      $(".loadingpprint" + no).html(
        '<center><img style="width:30px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    // console.log(result)
    window.open(result, "_blank");
    // window.location.reload();
  });
}
$(document).ready(function () {
  $("#pilseksi").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });
});
$(document).ready(function () {
  $("#pilhseksi").select2({
    allowClear: true,
    minimumResultsForSearch: Infinity,
  });
});
function monneed() {
  var seksi = $("#pilhseksi").val();

  var request = $.ajax({
    url: baseurl + "ConsumablePPIC/Monitoringkebutuhan/loadtblmonitor",
    data: {
      seksi: seksi,
    },
    dataType: "html",
    type: "POST",
    beforeSend: function () {
      $("div#monitoringkebutuhann").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    $("div#monitoringkebutuhann").html(result);
    $("#tbl_moneed").DataTable({
      scrollX: true,
      scrollY: 400,
      scrollCollapse: true,
      paging: false,
      info: false,
      searching: true,
    });
  });
}
