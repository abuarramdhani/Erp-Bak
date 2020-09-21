function angka(e, decimal) {
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
  $("#lko_input_method").select2({
    minimumResultsForSearch: Infinity,
  });
});
$(document).ready(function () {
  var request = $.ajax({
    url: baseurl + "LaporanKerjaOperator/Input/LoadView",
    beforeSend: function () {
      $("div#view_input_data").html(
        '<center><img style="width:100px; height:auto" src="' +
          baseurl +
          'assets/img/gif/loading11.gif"></center>'
      );
    },
  });
  request.done(function (result) {
    $("div#view_input_data").html(result);
    $(".tgl_LKO").css("display", "");
    $("#tbl_hasil_lko").dataTable({
      paging: false,
      scrollX: true,
      searching: true,
      info: false,
      fixedColumns: {
        leftColumns: 3,
      },
    });
  });
});
function addlist() {
  var request = $.ajax({
    url: baseurl + "LaporanKerjaOperator/Input/Addlist",
  });
  request.done(function (result) {
    $("#modal_add_list").modal("show");
    $("#Listt").html(result);
    $("#employee_ind_weld").select2({
      allowClear: true,
      minimumInputLength: 1,
      ajax: {
        url: baseurl + "LaporanKerjaOperator/Input/listEmployee",
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
    $("#employee_ind_weld").on("change", function () {
      v = $(this).val();
      var request = $.ajax({
        url: baseurl + "LaporanKerjaOperator/Input/getName",
        data: {
          v: v,
        },
        dataType: "json",
        type: "POST",
      });
      request.done(function (result) {
        $("#employee_name_weld").val(result);
      });
    });
    $("#employee_tgl_weld").datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
    });
    $("#employee_act_weld").on("keyup", function () {
      var act = $(this).val();
      var tgt = $("#employee_tgt_weld").val();

      var percent = (act / tgt) * 100;
      $("#employee_percent_weld").val(percent.toLocaleString());
    });
    $(".button_save_list").on("click", function () {
      var tgl = $("#employee_tgl_weld").val();
      var ind = $("#employee_ind_weld").val();
      var nama = $("#employee_name_weld").val();
      var work = $("#employee_workdesc_weld").val();
      var tgt = $("#employee_tgt_weld").val();
      var act = $("#employee_act_weld").val();
      var percent = $("#employee_percent_weld").val();
      var shift = $("#employee_shift_weld").val();
      var ket = $("#employee_ket_weld").val();
      var mk = $("#employee_mk_weld").val();
      var i = $("#employee_i_weld").val();
      var bk = $("#employee_bk_weld").val();
      var tkp = $("#employee_tkp_weld").val();
      var kp = $("#employee_kp_weld").val();
      var ks = $("#employee_ks_weld").val();
      var kk = $("#employee_kk_weld").val();
      var pk = $("#employee_pk_weld").val();
      var request = $.ajax({
        url: baseurl + "LaporanKerjaOperator/Input/InsertDataa",
        data: {
          tgl: tgl,
          ind: ind,
          nama: nama,
          work: work,
          tgt: tgt,
          act: act,
          percent: percent,
          shift: shift,
          ket: ket,
          mk: mk,
          i: i,
          bk: bk,
          tkp: tkp,
          kp: kp,
          ks: ks,
          kk: kk,
          pk: pk,
        },
        type: "POST",
      });
      request.done(function (result) {
        Swal.fire({
          position: "top",
          type: "success",
          title: "Berhasil Menambah Data",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.reload();
        });
      });
    });
  });
}
function modalprint() {
  var request = $.ajax({
    url: baseurl + "LaporanKerjaOperator/Input/ModalPrint",
  });
  request.done(function (result) {
    $("#modal_print").modal("show");
    $("#tglll").html(result);
    $("#tgl_lko").datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
    });
  });
}
