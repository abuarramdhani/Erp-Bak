$(document).on("ifChecked", "#fingerYa", function () {
  // alert('oke');
  $("#fingerpindah").prop("hidden", false);
  $("select[name='txtFingerGanti']").attr("required", "required");
});

$(document).on("ifChecked", "#fingerTidak", function () {
  // alert('oke');
  $("#fingerpindah").prop("hidden", true);
  $("#MasterPekerja-Surat-FingerGanti").each(function () {
    //added a each loop here
    $(this).val(null).trigger("change");
  });
});

$(document).ready(function () {
  $("#MP_GajiCutoff").DataTable({});
  $("#dataTable-MasterLokasi").DataTable({
    dom: "flrtp",
  });
  $("#dataTable-ReffJamLembur").DataTable({
    dom: "flrtp",
  });

  $(".select-nama").select2({
    ajax: {
      url: baseurl + "MasterPekerja/Other/pekerja",
      dataType: "json",
      type: "get",
      data: function (params) {
        return { p: params.term };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.noind,
              text: item.noind + " - " + item.nama,
            };
          }),
        };
      },
      cache: true,
    },
    minimumInputLength: 2,
    placeholder: "Select Nama Pekerja",
    allowClear: false,
  });

  $(".select-nama-amplop").select2({
    ajax: {
      url: baseurl + "MasterPekerja/CetakAmplop/pekerja",
      dataType: "json",
      type: "get",
      data: function (params) {
        return { p: params.term };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.noind,
              text: item.noind + " - " + item.nama,
            };
          }),
        };
      },
      cache: true,
    },
    minimumInputLength: 2,
    placeholder: "Select Nama Pekerja ",
    allowClear: false,
  });

  $(function () {
    $("#tabel-idcard").DataTable({
      dom: "frt",
    });
  });

  $(function () {
    $("#tabel-amplop").DataTable({
      dom: "frt",
    });
  });

  $("#tbl").DataTable({
    dom: "Bfrtip",
    buttons: [
      "excel",
      {
        extend: "pdfHtml5",
        orientation: "landscape",
        pageSize: "A4",
      },
    ],
    // scrollX: true,
    // // scrollY: 400,
    // lengthMenu: [
    //     [10, 25, 50, 100, -1],
    //     [10, 25, 50, 100, "All"]
    // ],
  });

  function SelectNama() {
    var val = $("#NamaPekerja").val();
    if (val) {
      $("#CariPekerja").removeAttr("disabled", "disabled");
      $("#CariPekerja").removeClass("disabled");
    } else {
      $("#CariPekerja").attr("disabled", "disabled");
      $("#CariPekerja").addClass("disabled", "disabled");
    }
  }

  $(document).on("change", "#NamaPekerja", function () {
    SelectNama();
  });

  $(document).on("click", "#CariPekerja", function (e) {
    e.preventDefault();
    var nama = $("#NamaPekerja").val();
    var baru = $('input[name="noind_baru"]:checked').val();
    var noind = "";

    $.ajax({
      url: baseurl + "MasterPekerja/Other/DataIDCard",
      type: "get",
      data: { nama: nama, baru: baru },
    }).done(function (data) {
      var html = "";
      var data = $.parseJSON(data);

      console.log(data["worker"]);
      $("tbody#dataIDcard").empty(html);
      for (var i = 0; i < data["worker"].length; i++) {
        if (baru == "1") {
          noind = data["worker"][i][0]["no_induk"];
        } else {
          noind = data["worker"][i][0]["noind"];
        }

        html += "<tr>";
        html += "<td>" + (i + 1) + "</td>";
        html +=
          "<td>" +
          noind +
          '<input type="hidden" name="noind[]" value="' +
          data["worker"][i][0]["noind"] +
          '"></td>';
        html += "<td>" + data["worker"][i][0]["nama"] + "</td>";
        if (data["worker"][i][0]["jabatan"] != null) {
          html +=
            "<td>" +
            data["worker"][i][0]["jabatan"] +
            " " +
            data["worker"][i][0]["seksi"] +
            "</td>";
        } else {
          html += "<td>" + data["worker"][i][0]["seksi"] + "</td>";
        }
        html +=
          '<td><a style="cursor:pointer;" class="mpkOpnImg" target="_blank" data-url="' +
          data["worker"][i][0]["photo"] +
          '">PHOTO</td>';
        html +=
          '<td><input type="text" style="text-transform:uppercase" data-noind="' +
          data["worker"][i][0]["noind"] +
          '" class="form-control" name="nick[]" id="nickname" maxlength="10"></td>';
        html += "</tr>";
      }
      $("tbody#dataIDcard").append(html);
      $("#tampil-data").removeClass("hidden");
      $("#print_card").removeAttr("disabled", false);
      $("#print_card").removeClass("disabled");
    });
  });

  function SelectNamaAmplop() {
    var val = $("#NamaPekerjaCetakAmplop").val();
    if (val) {
      $("#CariPekerjaCetakAmplop").removeAttr("disabled", "disabled");
      $("#CariPekerjaCetakAmplop").removeClass("disabled");
    } else {
      $("#CariPekerjaCetakAmplop").attr("disabled", "disabled");
      $("#CariPekerjaCetakAmplop").addClass("disabled", "disabled");
    }
  }
  $(document).on("change", "#NamaPekerjaCetakAmplop", function () {
    SelectNamaAmplop();
  });

  $(document).on("click", "#CariPekerjaCetakAmplop", function (e) {
    e.preventDefault();
    var nama = $("#NamaPekerjaCetakAmplop").val();
    var noind = "";
    $.ajax({
      url: baseurl + "MasterPekerja/CetakAmplop/DataAmplop",
      type: "get",
      data: { nama: nama },
    }).done(function (data) {
      var html = "";
      var data = $.parseJSON(data);

      console.log(data["worker"]);
      $("tbody#dataAmplop").empty(html);
      for (var i = 0; i < data["worker"].length; i++) {
        noind = data["worker"][i][0]["noind"];

        html += "<tr>";
        html += "<td>" + (i + 1) + "</td>";
        html +=
          "<td>" +
          noind +
          '<input type="hidden" name="noind[]" value="' +
          data["worker"][i][0]["noind"] +
          '"></td>';
        html += "<td>" + data["worker"][i][0]["nama"] + "</td>";

        html += "<td>" + data["worker"][i][0]["seksi"] + "</td>";

        html += "</tr>";
      }
      $("tbody#dataAmplop").append(html);
      $("#tampil-data-amplop").removeClass("hidden");
      $("#print_amplop").removeAttr("disabled", false);
      $("#print_amplop").removeClass("disabled");
    });
  });

  function SelectNamaAmplop() {
    var val = $("#NamaPekerjaCetakAmplop").val();
    if (val) {
      $("#CariPekerjaCetakAmplop").removeAttr("disabled", "disabled");
      $("#CariPekerjaCetakAmplop").removeClass("disabled");
    } else {
      $("#CariPekerjaCetakAmplop").attr("disabled", "disabled");
      $("#CariPekerjaCetakAmplop").addClass("disabled", "disabled");
    }
  }
  $(document).on("change", "#NamaPekerjaCetakAmplop", function () {
    SelectNamaAmplop();
  });

  $(document).on("click", "#CariPekerjaCetakAmplop", function (e) {
    e.preventDefault();
    var nama = $("#NamaPekerjaCetakAmplop").val();
    var noind = "";
    $.ajax({
      url: baseurl + "MasterPekerja/CetakAmplop/DataAmplop",
      type: "get",
      data: { nama: nama },
    }).done(function (data) {
      var html = "";
      var data = $.parseJSON(data);

      console.log(data["worker"]);
      $("tbody#dataAmplop").empty(html);
      for (var i = 0; i < data["worker"].length; i++) {
        noind = data["worker"][i][0]["noind"];

        html += "<tr>";
        html += "<td>" + (i + 1) + "</td>";
        html +=
          "<td>" +
          noind +
          '<input type="hidden" name="noind[]" value="' +
          data["worker"][i][0]["noind"] +
          '"></td>';
        html += "<td>" + data["worker"][i][0]["nama"] + "</td>";

        html += "<td>" + data["worker"][i][0]["seksi"] + "</td>";

        html += "</tr>";
      }
      $("tbody#dataAmplop").append(html);
      $("#tampil-data-amplop").removeClass("hidden");
      $("#print_amplop").removeAttr("disabled", false);
      $("#print_amplop").removeClass("disabled");
    });
  });

  $("#tabel-idcard").on("click", ".mpkOpnImg", function () {
    let va = $(this).attr("data-url");
    Swal.fire({
      html:
        "<div style=\"background: url('" +
        va +
        "') no-repeat right center; background-size: contain; background-position: 50%; min-height: 420px;\"></div>",
    });
  });

  //Untuk Rekap Perizinan Dinas
  $("#PD_Cari").on("click", function () {
    let tanggal = $("#periodeRekap").val();
    let id = $(".RPD_id_rekap").val();
    let noind = $(".RPD_perNoind").val();
    let jenis = $("input:radio[class=RD_radioDinas]:checked").val();
    var loading = baseurl + "assets/img/gif/loadingquick.gif";

    if (jenis == "" || jenis == null) {
      swal.fire({
        title: "Peringatan",
        text: "Harap Memilih Jenis Rekap !",
        type: "warning",
        allowOutsideClick: false,
      });
    } else {
      $.ajax({
        type: "POST",
        data: {
          periodeRekap: tanggal,
          jenis: jenis,
          id: id,
          noind: noind,
        },
        url: baseurl + "PD/RekapPerizinanDinas/rekapbulanan",
        beforeSend: function () {
          swal.fire({
            html:
              "<div><img style='width: 320px; height: auto;'src='" +
              loading +
              "'><br><p>Sedang Proses....</p></div>",
            customClass: "swal-wide",
            showConfirmButton: false,
            allowOutsideClick: false,
          });
        },
        success: function (result) {
          swal.close();
          $("#areaRekapIzin").html(result);

          $(".tabel_rekap").DataTable({
            dom: "Bfrtip",
            buttons: ["excel", "pdf"],
            scrollX: true,
            fixedColumns: {
              leftColumns: 4,
            },
          });
        },
      });
    }
  });

  $(document).ready(function () {
    $("#RPD_ID").prop("hidden", true);
    $("#RPD_Noind").prop("hidden", true);
    $(".RD_radioDinas").on("ifChecked", function (event) {
      if ($(this).val() == "1") {
        $("#RPD_ID").prop("hidden", false);
        $("#RPD_Noind").prop("hidden", true);
      }
      if ($(this).val() == "2") {
        $("#RPD_ID").prop("hidden", true);
        $("#RPD_Noind").prop("hidden", false);
      }
    });
  });

  $(".tabel_izin").DataTable({
    ordering: false,
    paging: false,
    searching: false,
  });

  $("input.periodeRekap").daterangepicker({
    autoUpdateInput: false,
    locale: {
      cancelLabel: "Clear",
    },
  });

  $("input.periodeRekap").on("apply.daterangepicker", function (ev, picker) {
    $(this).val(
      picker.startDate.format("DD/MM/YYYY") +
      " - " +
      picker.endDate.format("DD/MM/YYYY")
    );
  });

  $("input.periodeRekap").on("cancel.daterangepicker", function (ev, picker) {
    $(this).val("");
  });
});
//Selesai

//Untuk Approve IKP
function getApprovalIKP(a, b, jenis) {
  var loading = baseurl + "assets/img/gif/loadingquick.gif";

  var txt = "";
  if (jenis == 1)
    txt = "Sudahkah Anda mengecek pekerja yang akan Izin Keluar Pribadi ?";
  else if (jenis == 2)
    txt = "Sudahkah Anda mengecek pekerja yang akan Izin Sakit Perusahaan ?";
  else
    txt = "Sudahkah Anda mengecek pekerja yang akan Izin Keluar Perusahaan ?";

  if (a == "1") {
    swal
      .fire({
        title: "Checking...",
        text: txt,
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "OK",
        allowOutsideClick: false,
      })
      .then((result) => {
        if (result.value) {
          swal
            .fire({
              title: "Peringatan",
              text: "Anda akan memberikan keputusan APPROVE !",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "OK",
              allowOutsideClick: false,
            })
            .then((result) => {
              if (result.value) {
                $.ajax({
                  beforeSend: function () {
                    Swal.fire({
                      html:
                        "<img style='width: 320px; height: auto;'src='" +
                        loading +
                        "'>",
                      text: "Loading...",
                      customClass: "swal-wide",
                      showConfirmButton: false,
                      allowOutsideClick: false,
                    });
                  },
                  data: {
                    keputusan: a,
                    id: b,
                  },
                  type: "post",
                  url: baseurl + "IKP/ApprovalAtasan/update",
                  success: function (data) {
                    Swal.fire({
                      title: "Izin Telah di Approve",
                      type: "success",
                      showCancelButton: false,
                      allowOutsideClick: false,
                    }).then((result) => {
                      Swal.fire({
                        html:
                          "<img style='width: 320px; height: auto;'src='" +
                          loading +
                          "'>",
                        text: "Loading...",
                        customClass: "swal-wide",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                      }).then(window.location.reload());
                    });
                  },
                });
              }
            });
        }
      });
  } else if (a == "0") {
    swal
      .fire({
        title: "Checking...",
        text: txt,
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "OK",
        allowOutsideClick: false,
      })
      .then((result) => {
        if (result.value) {
          swal
            .fire({
              title: "Peringatan",
              text: "Anda akan memberikan keputusan REJECT !",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "OK",
              allowOutsideClick: false,
            })
            .then((result) => {
              if (result.value) {
                $.ajax({
                  beforeSend: function () {
                    Swal.fire({
                      html:
                        "<img style='width: 320px; height: auto;'src='" +
                        loading +
                        "'>",
                      text: "Loading...",
                      customClass: "swal-wide",
                      showConfirmButton: false,
                      allowOutsideClick: false,
                    });
                  },
                  data: {
                    keputusan: a,
                    id: b,
                  },
                  type: "post",
                  url: baseurl + "IKP/ApprovalAtasan/update",
                  success: function (data) {
                    Swal.fire({
                      title: "Izin Telah di Reject",
                      type: "error",
                      showCancelButton: false,
                      allowOutsideClick: false,
                    }).then((result) => {
                      Swal.fire({
                        html:
                          "<img style='width: 320px; height: auto;'src='" +
                          loading +
                          "'>",
                        text: "Loading...",
                        customClass: "swal-wide",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                      }).then(window.location.reload());
                    });
                  },
                });
              }
            });
        }
      });
  }
}

function edit_pkj_ikp(id) {
  let table = $(".eachPekerjaEditIKP");

  $.ajax({
    type: "post",
    data: {
      id: id,
    },
    url: baseurl + "IKP/ApprovalAtasan/editPekerjaIKP",
    beforeSend: (a) => {
      table.html('<tr><td colspan="4">loading....</td></tr>');
    },
    dataType: "json",
    success: function (data) {
      $("#modal-approve-ikp").modal("show");
      $("#modal-id_ikp").val(data[0]["id"]);
      $("#modal-tgl_ikp").val(data[0]["created_date"]);
      $("#modal-keluar_ikp").val(function () {
        if (data[0]["wkt_keluar"] == null) {
          return "-";
        } else if (data[0]["wkt_keluar"] < "12:00:00") {
          return data[0]["wkt_keluar"] + " AM";
        } else {
          return data[0]["wkt_keluar"] + " PM";
        }
      });
      $("#modal-kep_ikp").val(data[0]["keperluan"]);

      let row;
      data.forEach((a) => {
        row += `<tr>
                            <td><input type="checkbox" class="checkAll_edit_ikp" value="${a.noind}"></td>
                            <td>${a.noind}</td>
                            <td>${a.nama}</td>
                        </tr>`;
      });
      table.html(row);

      $("input#checkAll_edit_ikp").on("ifChecked ifUnchecked", function (
        event
      ) {
        $(".checkAll_edit_ikp").prop(
          "checked",
          event.type == "ifChecked" ? true : false
        );
        $(this).prop("checked", event.type == "ifChecked" ? true : false);
      });
    },
  });
}

$("#app_edit_ikp").on("click", function () {
  var loading = baseurl + "assets/img/gif/loadingquick.gif";
  let jenis = $(this).val();
  let id = $("#modal-id_ikp").val();
  let ma = [];
  let checkbox = $("input:checkbox[class=checkAll_edit_ikp]:checked");
  checkbox.each(function () {
    ma.push($(this).val());
  });

  if (ma == null || ma == "") {
    swal.fire({
      title: "Peringatan",
      text: "Harap Pilih Pekerja",
      type: "warning",
      allowOutsideClick: false,
    });
  } else {
    swal
      .fire({
        title: "Checking...",
        text: "Sudahkah Anda mengecek pekerja yang akan Izin Keluar Pribadi ?",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "OK",
        allowOutsideClick: false,
      })
      .then((result) => {
        if (result.value) {
          swal
            .fire({
              title: "Peringatan",
              text: "Anda akan memberikan keputusan APPROVE !",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "OK",
              allowOutsideClick: false,
            })
            .then((result) => {
              if (result.value) {
                $.ajax({
                  type: "post",
                  data: {
                    jenis: jenis,
                    id: id,
                    pekerja: ma,
                  },
                  beforeSend: function () {
                    Swal.fire({
                      html:
                        "<img style='width: 320px; height: auto;'src='" +
                        loading +
                        "'>",
                      text: "Loading...",
                      customClass: "swal-wide",
                      showConfirmButton: false,
                      allowOutsideClick: false,
                    });
                  },
                  url: baseurl + "IKP/ApprovalAtasan/updatePekerja",
                  success: function (data) {
                    Swal.fire({
                      title: "Izin Telah di Approve",
                      type: "success",
                      showCancelButton: false,
                      allowOutsideClick: false,
                    }).then((result) => {
                      Swal.fire({
                        html:
                          "<img style='width: 320px; height: auto;'src='" +
                          loading +
                          "'>",
                        text: "Loading...",
                        customClass: "swal-wide",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                      }).then(window.location.reload());
                    });
                  },
                });
              }
            });
        }
      });
  }
});

$("#RPP_Cari").on("click", function () {
  let isi = $(this).val();
  // if (isi == '1') {
  alamat = baseurl + "RPP/RekapIKP/rekapbulanan";
  // } else {
  //     alamat = baseurl + 'PerizinanPribadi/RekapPerizinanSeksi/rekap'
  // }
  var tanggal = $("#periodeRekap").val();
  var jenis = $("input:radio[class=RD_radioDinas]:checked").val();
  var list_id = $(".RPD_id_rekap").val();
  var list_noind = $(".RPD_perNoind").val();
  var loading = baseurl + "assets/img/gif/loadingquick.gif";

  if (isi == "1" && (jenis == "" || jenis == null)) {
    swal.fire({
      title: "Peringatan",
      text: "Harap Memilih Jenis Rekap !",
      type: "warning",
      allowOutsideClick: false,
    });
  } else {
    $.ajax({
      type: "GET",
      data: {
        periodeRekap: tanggal,
        jenis: jenis,
        id: list_id,
        noind: list_noind,
        jenisPerseksi: isi,
      },
      url: alamat,
      beforeSend: function () {
        swal.fire({
          html:
            "<img style='width: 320px; height: auto;'src='" + loading + "'>",
          text: "Loading...",
          customClass: "swal-wide",
          showConfirmButton: false,
          allowOutsideClick: false,
        });
      },
      success: function (result) {
        swal.close();
        $("#areaRekapIKP").html(result);
        $(".tabel_rekap").DataTable({
          dom: "lfrtip",
          scrollX: true,
          fixedColumns: {
            leftColumns: 4,
          },
        });
      },
    });
  }
});

$("#izinRekapExcel").on("click", () => {
  let isi = $("#izinRekapExcel").val(),
    periodeRekap = $("#periodeRekap").val(),
    valbutton = "Excel",
    jenis = $("input:radio[class=RD_radioDinas]:checked").val(),
    alamat = baseurl + "RPP/RekapIKP/rekapbulanan";

  window.open(
    alamat +
    "?valButton=" +
    valbutton +
    "&periodeRekap=" +
    periodeRekap +
    "&jenisPerseksi=" +
    isi +
    "&jenis=" +
    jenis,
    "_blank"
  );
});

$("#izinRekapPDF").on("click", () => {
  let isi = $("#izinRekapPDF").val(),
    periodeRekap = $("#periodeRekap").val(),
    valbutton = "PDF",
    jenis = $("input:radio[class=RD_radioDinas]:checked").val(),
    alamat = baseurl + "RPP/RekapIKP/rekapbulanan";

  window.open(
    alamat +
    "?valButton=" +
    valbutton +
    "&periodeRekap=" +
    periodeRekap +
    "&jenisPerseksi=" +
    isi +
    "&jenis=" +
    jenis,
    "_blank"
  );
});

$("#SaranRekapExcel").on("click", () => {
  let periodeRekap = $("#periodeRekap").val(),
    valbutton = "Excel",
    alamat = baseurl + "PerizinanPribadi/RekapKritikan/tempelSaran";

  window.open(
    alamat + "?valButton=" + valbutton + "&tanggal=" + periodeRekap,
    "_blank"
  );
});

$("#SaranRekapPDF").on("click", () => {
  let periodeRekap = $("#periodeRekap").val(),
    valbutton = "PDF",
    alamat = baseurl + "PerizinanPribadi/RekapKritikan/tempelSaran";

  window.open(
    alamat + "?valButton=" + valbutton + "&tanggal=" + periodeRekap,
    "_blank"
  );
});

$("#RPP_Saran").on("click", function (params) {
  let tanggal = $("#periodeRekap").val(),
    valButton = "";

  $.ajax({
    type: "GET",
    data: {
      tanggal,
      valButton,
    },
    url: baseurl + "PerizinanPribadi/RekapKritikan/tempelSaran",
    beforeSend: function () {
      swal.fire({
        text: "waiting",
        showConfirmButton: false,
        allowOutsideClick: false,
      });
    },
    success: function (a) {
      swal.close();
      $("#tempelSaran").html(a);
      $(".tabel_rekap").DataTable({
        dom: "frtip",
        scrollX: true,
        fixedColumns: {
          leftColumns: 2,
        },
      });
    },
  });
});

function cekManualPerizinan(a, id) {
  let jenis = a;

  swal
    .fire({
      title:
        "Apakah anda yakin " +
        (a == "1" ? "ada" : "tidak ada") +
        " form manual ?",
      type: "question",
      showCancelButton: true,
      allowOutsideClick: false,
    })
    .then((a) => {
      if (a.value) {
        $.ajax({
          type: "POST",
          data: {
            id,
            jenis,
          },
          url: baseurl + "RPP/RekapIKP/updateManual",
          beforeSend: () => {
            swal.fire({
              text: "waiting",
              showConfirmButton: false,
              allowOutsideClick: false,
            });
          },
          success: (a) => {
            swal.close();
            if (a == "ok") {
              swal.fire({
                title: "OK",
                type: "success",
                showConfirmButton: false,
                timer: 500,
                position: "top",
              });
              // let keputusan = a == '1' ? '<a><span style="color: green" class="fa fa-check fa-2x"></span></a>' : '<a><span style="color: red" class="fa fa-close fa-2x"></span></a>'
              // tabelRekap.cell($(`[onclick="cekManualPerizinan(${jenis}, ${id})"]`).closest('td')).data(keputusan).draw();
              $("#RPP_Cari").click();
            } else {
              swal.fire({
                title: "Connection Error",
                type: "error",
                showConfirmButton: false,
                timer: 500,
                position: "top",
              });
            }
          },
        });
      }
    });
}

function childPribadiDelete(id) {
  $.ajax({
    type: "POST",
    data: {
      id,
    },
    url: baseurl + "RPP/RekapIKP/deleteData",
    success: () => {
      $("#RPP_Cari").click();
      mpk_showAlert("success", "Data Berhasil di Hapus !");
    },
  });
}

//Selesai

//  -------Master Pekerja--------------------------------------------start
$(function () {
  $(".monthpickerq").monthpicker({
    Button: false,
    dateFormat: "MM yy",
    autocomplete: "off",
  });

  $(".monthpickerq1").monthpicker({
    Button: false,
    dateFormat: "MM yy",
  });

  $(".MasterPekerja-daterangepicker").daterangepicker(
    {
      showDropdowns: true,
      autoApply: true,
      locale: {
        format: "YYYY-MM-DD",
        separator: " - ",
        applyLabel: "OK",
        cancelLabel: "Batal",
        fromLabel: "Dari",
        toLabel: "Hingga",
        customRangeLabel: "Custom",
        weekLabel: "W",
        daysOfWeek: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sa"],
        monthNames: [
          "Januari",
          "Februari",
          "Maret",
          "April",
          "Mei",
          "Juni",
          "Juli",
          "Agustus ",
          "September",
          "Oktober",
          "November",
          "Desember",
        ],
        firstDay: 1,
      },
    },
    function (start, end, label) {
      console.log(
        "New date range selected: ' + start.format('YYYY-MM-DD H:i:s') + ' to ' + end.format('YYYY-MM-DD H:i:s') + ' (predefined range: ' + label + ')"
      );
    }
  );

  $(".MasterPekerja-daterangepickersingledate").daterangepicker(
    {
      singleDatePicker: true,
      showDropdowns: true,
      autoApply: true,
      mask: true,
      locale: {
        format: "YYYY-MM-DD",
        separator: " - ",
        applyLabel: "OK",
        cancelLabel: "Batal",
        fromLabel: "Dari",
        toLabel: "Hingga",
        customRangeLabel: "Custom",
        weekLabel: "W",
        daysOfWeek: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sa"],
        monthNames: [
          "Januari",
          "Februari",
          "Maret",
          "April",
          "Mei",
          "Juni",
          "Juli",
          "Agustus ",
          "September",
          "Oktober",
          "November",
          "Desember",
        ],
        firstDay: 1,
      },
    },
    function (start, end, label) {
      console.log(
        "New date range selected: ' + start.format('YYYY-MM-DD H:i:s') + ' to ' + end.format('YYYY-MM-DD H:i:s') + ' (predefined range: ' + label + ')"
      );
    }
  );

  $(".MasterPekerja-daterangepickersingledatewithtime").daterangepicker(
    {
      timePicker: true,
      timePicker24Hour: true,
      singleDatePicker: true,
      showDropdowns: true,
      autoApply: true,
      locale: {
        format: "YYYY-MM-DD HH:mm",
        separator: " - ",
        applyLabel: "OK",
        cancelLabel: "Batal",
        fromLabel: "Dari",
        toLabel: "Hingga",
        customRangeLabel: "Custom",
        weekLabel: "W",
        daysOfWeek: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sa"],
        monthNames: [
          "Januari",
          "Februari",
          "Maret",
          "April",
          "Mei",
          "Juni",
          "Juli",
          "Agustus ",
          "September",
          "Oktober",
          "November",
          "Desember",
        ],
        firstDay: 1,
      },
    },
    function (start, end, label) {
      console.log(
        "New date range selected: ' + start.format('YYYY-MM-DD H:i:s') + ' to ' + end.format('YYYY-MM-DD H:i:s') + ' (predefined range: ' + label + ')"
      );
    }
  );
  //  }
  //  select3

  $(".slcMPSuratPengalamanKerjaPekerja").select2({
    searching: true,
    minimumInputLength: 3,
    placeholder: "No. Induk / Nama Pekerja",
    allowClear: false,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/PengalamanKerja/Pekerja",
      dataType: "json",
      delay: 500,
      type: "GET",
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.noind + " - " + obj.nama };
          }),
        };
      },
    },
  });

  $("#slcMPSuratPengalamanKerjaPekerja").change(function () {
    // buat yang seperti ini untuk yang bawah yang ngisi template
    var noind = $("#slcMPSuratPengalamanKerjaPekerja").val();
    if (noind) {
      $.ajax({
        type: "POST",
        data: { noind: noind },
        url: baseurl + "MasterPekerja/Surat/PengalamanKerja/detailPekerja",
        success: function (result) {
          var result = JSON.parse(result);
          // console.log(result[0]['seksi']);
          $("#txtMPSuratPengalamanKerjaSeksi").val(result[0]["seksi"]);
          $("#txtMPSuratPengalamanKerjaBidang").val(result[0]["bidang"]);
          $("#txtMPSuratPengalamanKerjaUnit").val(result[0]["unit"]);
          $("#txtMPSuratPengalamanKerjaDept").val(result[0]["dept"]);
          $("#txtMPSuratPengalamanKerjaMasuk").val(result[0]["masukkerja"]);
          $("#txtMPSuratPengalamanKerjaMasuk").val(result[0]["masukkerja"]);
          //var sampaiHtml = '<option value=""></option>';
          //sampaiHtml = sampaiHtml + '<option value="' + result[0]['akhkontrak'] + '">' + result[0]['akhkontrak'] + '</option>';
          //sampaiHtml = sampaiHtml + '<option value="1900-01-01">Tanggal dibuatnya surat keterangan ini dan masih bekerja</option>';
          //$('#txtMPSuratPengalamanKerjaSampai').html(sampaiHtml); // ini diganti isi template.
          var sampaiHtml =
            '<option value="' +
            result[0]["akhkontrak"] +
            '">' +
            result[0]["akhkontrak"] +
            "</option>";
          sampaiHtml =
            sampaiHtml +
            '<option value="1900-01-01">Tanggal dibuatnya surat keterangan ini dan masih bekerja</option>';
          $("#txtMPSuratPengalamanKerjaSampai").html(sampaiHtml); // ini diganti isi template.
          var JabatanHtml =
            '<option value="' +
            result[0]["jabatan"] +
            '">' +
            result[0]["jabatan"] +
            "</option>";
          JabatanHtml =
            JabatanHtml + '<option value="Administrasi">Administrasi</option>';
          JabatanHtml =
            JabatanHtml + '<option value="Operator">Operator</option>';
          $("#txtMPSuratPengalamanKerjaJabatan").html(JabatanHtml); // ini diganti isi template.
          $("#txtMPSuratPengalamanKerjaAlamat").val(result[0]["alamat"]);
          $("#txtMPSuratPengalamanKerjaDesa").val(result[0]["desa"]);
          $("#txtMPSuratPengalamanKerjaKab").val(result[0]["kab"]);
          $("#txtMPSuratPengalamanKerjaKec").val(result[0]["kec"]);
          $("#txtMPSuratPengalamanKerjaNIK").val(result[0]["nik"]);
          $("#txtMPSuratPengalamanKerjaKodesie").val(result[0]["kodesie"]);
          $("#txtMPSuratPengalamanKerjaAPD").val(result[0]["apd"]);
        },
      });
    }
  });

  $("#pengalaman").on("change", function () {
    // buat yang seperti ini untuk yang bawah yang ngisi template
    var kd = $("#pengalaman").val();
    if (kd) {
      $.ajax({
        type: "POST",
        data: { kd: kd }, // yang depan
        url:
          baseurl +
          "MasterPekerja/Surat/PengalamanKerja/DetailisiSuratPengalaman", // ini sudah ada controller nya ?
        success: function (result) {
          var result = JSON.parse(result);
          console.log(result);
          // console.log(result[0]['seksi']);

          var sampaiHtml = result[0]["isi_surat"];
          // $('.MasterPekerja-Surat-txaPreview').html(sampaiHtml); // ini diganti isi template.
          $(".MasterPekerja-Surat-txaPreview").redactor("set", sampaiHtml);
        },
      });
    }
  });

  // $('#template').select2({
  //   tags: true
  // })

  $("#template").on("change", function () {
    // buat yang seperti ini untuk yang bawah yang ngisi template
    var kd = $("#template").val();

    // algoritma
    // jika nambah surat baru maka insert ke database ? ya -> insertnya itu setelah klik tombol save kan bu?ya
    //edit , delete juga

    if (kd) {
      $.ajax({
        type: "POST",
        data: { kd: kd }, // yang depan
        url:
          baseurl +
          "MasterPekerja/Surat/PengalamanKerja/TemplateisiSuratPengalaman", // ini sudah ada controller nya ?
        success: function (result) {
          var result = JSON.parse(result);
          console.log(result);
          // console.log(result[0]['seksi']);

          if (!result) return;
          var sampaiHtml = result[0]["isi_surat"];
          // $('.MasterPekerja-Surat-txaPreview').html(sampaiHtml); // ini diganti isi template.
          $(".MasterPekerja-SuratPengalaman-txaPreview").redactor(
            "set",
            sampaiHtml
          );
        },
      });
    } else {
      $("#template_content").redactor("set", "");
    }
  });

  $(document).on("click", ".Modal_pdf_pengalaman", function () {
    var a = $(this).attr("data-value");
    var b = $(this).attr("data-noind");
    var c = $(this).attr("data-sampai");
    console.log(a);
    console.log(b);
    console.log(c);
    $.ajax({
      type: "get",
      dataType: "json",
      url: baseurl + "MasterPekerja/Surat/PengalamanKerja/ModalPDF/" + a,
      success: function (result) {
        var jbtn = result.data[0].jabatan;
        // alert(result.data[0].noind.indexOf("H"));
        if (result.data[0].noind.indexOf("H") == "0") {
          jbtn = "Operator";
        }
        $("#jabatan_pengalaman").val(jbtn).trigger("change");
        $("#nik_pengalaman").val(result.data[0].nik).trigger("change");
        const parsedDate = moment(result.data[0].pengalaman_tglcetak, [
          "YYYY/MM/DD",
        ]).format("YYYY-MM-DD");
        $("#pengalaman_tglCetak")
          .val(
            result.data[0].pengalaman_tglcetak
              ? parsedDate
              : moment().format("YYYY-MM-DD")
          ) // YYYY-MM-DD
          .trigger("change");
        // console.log("aaaaaaa", result.data[0].pengalaman_tglcetak);
        // console.log(parsedDate);
        $("#link_pengalaman").val(a);
        $("#noind_pengalaman").val(b);
        $("#sampai_pengalaman").val(c);
        $("#Modal_pdf_pengalaman").modal("show");
      },
    });
  });

  $(document).on('click', '#prev_Pengalaman', function () {
    let id = $('#link_pengalaman').val()
    $("#" + id).attr('style', 'color: blue');
  })

  $(".MasterPekerja-PerhitunganPesangon-DaftarPekerja").select2({
    allowClear: false,
    placeholder: "Pilih Pekerja",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MasterPekerja/PerhitunganPesangon/daftar_pekerja_aktif",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.pekerja };
          }),
        };
      },
    },
  });

  $("#txtProses")
    .datepicker({
      showDropdowns: true,
      autoApply: true,
      autoclose: true,
      format: "dd MM yyyy",
    })
    .on("change", function () {
      let wkt = moment($(this).val()).format("dd");
      $("#txtHariPrs").removeClass("ahad");

      $("#txtHariPrs").val(function () {
        if (wkt == "Su") {
          var styles = {
            color: "red",
            fontWeight: "bold",
          };
          $(this).css(styles);
          return "Minggu";
        } else if (wkt == "Mo") {
          $(this).css({ color: "", fontWeight: "" });
          return "Senin";
        } else if (wkt == "Tu") {
          $(this).css({ color: "", fontWeight: "" });
          return "Selasa";
        } else if (wkt == "We") {
          $(this).css({ color: "", fontWeight: "" });
          return "Rabu";
        } else if (wkt == "Th") {
          $(this).css({ color: "", fontWeight: "" });
          return "Kamis";
        } else if (wkt == "Fr") {
          $(this).css({ color: "", fontWeight: "" });
          return "Jumat";
        } else if (wkt == "Sa") {
          $(this).css({ color: "", fontWeight: "" });
          return "Sabtu";
        }
      });
    });

  $(document).on(
    "ifChecked",
    "#MasterPekerja-PerhitunganPesangon-HitungCuti",
    function () {
      $("#MasterPekerja-PerhitunganPesangon-StatusCuti").val("1");
    }
  );
  $(document).on(
    "ifUnchecked",
    "#MasterPekerja-PerhitunganPesangon-HitungCuti",
    function () {
      $("#MasterPekerja-PerhitunganPesangon-StatusCuti").val("0");
    }
  );

  $("#MasterPekerja-PerhitunganPesangon-DaftarPekerja").change(function () {
    var noind = $("#MasterPekerja-PerhitunganPesangon-DaftarPekerja").val();
    var cuti = $("#MasterPekerja-PerhitunganPesangon-StatusCuti").val();
    console.log("STATUS CUTI : " + cuti);
    if (noind) {
      $.ajax({
        type: "POST",
        data: { noind: noind, cuti: cuti },
        url: baseurl + "MasterPekerja/PerhitunganPesangon/detailPekerja",
        success: function (result) {
          if (result !== "Data Kosong") {
            var res = JSON.parse(result);
            $("#txtSeksi").val(res[0]["seksi"]);
            $("#txtUnit").val(res[0]["unit"]);
            $("#txtDepartemen").val(res[0]["departemen"]);
            $("#txtLokasi").val(res[0]["lokasi_kerja"]);
            $("#txtJabatan").val(res[0]["pekerjaan"]);
            $("#txtDiangkat").val(res[0]["diangkat"]);
            $("#txtAlamat").val(res[0]["alamat"]);
            $("#txtLahir").val(res[0]["tempat"]);
            $("#txtMasaKerja").val(res[0]["masakerja"]);
            if (cuti == "0") {
              $("#txtSisaCuti").val("0 hari");
            } else {
              $("#txtSisaCuti").val(res[0]["sisacuti"]);
            }
            $("#txtStatus").val(res[0]["alasan"]);
            $("#txtUangPesangon").val(res[0]["pengali"]);
            $("#txtUangUMPK").val(res[0]["upmk"]);
            $("#txtSisaCutiHari").val(res[0]["sisacutihari"]);
            $("#txtUangGantiRugi").val(res[0]["gantirugi"]);
            $("#txtTahun").val(res[0]["masakerja_tahun"]);
            $("#txtBulan").val(res[0]["masakerja_bulan"]);
            $("#txtHari").val(res[0]["masakerja_hari"]);
            $("#txtPasal").val(res[0]["pasal"]);
            $("#txtPesangon").val(res[0]["pesangon"]);
            $("#txtUPMK").val(res[0]["up"]);
            if (cuti == "0") {
              $("#txtCuti").val("0");
            } else {
              $("#txtCuti").val(res[0]["cuti"]);
            }
            $("#txtRugi").val(res[0]["rugi"]);
            $("#txtAkhir").val(res[0]["metu"]);
            $("#txtNPWP").val(res[0]["npwp"]);
            $("#txtNIK").val(res[0]["nik"]);
            $("#txtHariLmt").val(function () {
              if (res["hari_terakhir"] == "Sun") {
                var styles = {
                  color: "red",
                  fontWeight: "bold",
                };
                $(this).css(styles);
                return "Minggu";
              } else if (res["hari_terakhir"] == "Mon") {
                return "Senin";
              } else if (res["hari_terakhir"] == "Tue") {
                return "Selasa";
              } else if (res["hari_terakhir"] == "Wed") {
                return "Rabu";
              } else if (res["hari_terakhir"] == "Thu") {
                return "Kamis";
              } else if (res["hari_terakhir"] == "Fri") {
                return "Jumat";
              } else if (res["hari_terakhir"] == "Sat") {
                return "Sabtu";
              }
            });
          } else {
            swal.fire({
              title: "Data pekerja Tidak Ditemukan",
              text: "Mohon Lakukan Pengecekan Ulang Data Pekerja",
              type: "warning",
            });
          }
        },
      });
    }
  });

  //  Select2
  //  {
  $("#MasterPekerja-Surat-FingerGanti").select2({
    minimumInputLength: 1,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/finger_reference",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.id_lokasi + " - " + obj.device_name,
              text: obj.id_lokasi + " - " + obj.device_name,
            };
          }),
        };
      },
    },
  });

  $("#MasterPekerja-Surat-DaftarPekerja").select2({
    allowClear: false,
    placeholder: "Pilih Pekerja",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_pekerja_aktif",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.noind + " - " + obj.nama };
          }),
        };
      },
    },
  });

  $(".MasterPekerja-Surat-DaftarPekerja").select2({
    allowClear: false,
    placeholder: "Pilih Pekerja",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_pekerja_aktif",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.noind + " - " + obj.nama };
          }),
        };
      },
    },
  });

  $("#MasterPekerja-txtStatusjabatanBaru").select2({
    allowClear: false,
    placeholder: "Pilih Status Jabatan Upah",
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_nama_status",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.kd_status + " - " + obj.nama_status,
              text: obj.kd_status + " - " + obj.nama_status,
            };
          }),
        };
      },
    },
  });

  $("#MasterPekerja-txtNamaJabatanUpahBaru").select2({
    allowClear: false,
    placeholder: "Pilih Nama Jabatan Upah Baru",
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_nama_jabatan_upah",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.nama_jabatan, text: obj.nama_jabatan };
          }),
        };
      },
    },
  });

  $("#MasterPekerja-DaftarSeksi").select2({
    allowClear: false,
    placeholder: "Pilih Seksi",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_seksi",
      dataType: "json",
      delay: 500,
      type: "GET",
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.kodesie, text: obj.daftar_tseksi };
          }),
        };
      },
    },
  });

  $("#MasterPekerja-DaftarSeksi").change(function () {
    var kode_seksi = $(this).val();
    var kode_seksi = kode_seksi.substr(0, 7);

    $("#rowmutasi .select2-selection").css("background-color", "");
    $("#validMutasi").hide();

    $("#MasterPekerja-DaftarPekerjaan").select2({
      allowClear: false,
      placeholder: "Pilih Pekerjaan",
      ajax: {
        url: baseurl + "MasterPekerja/Surat/daftar_pekerjaan",
        dataType: "json",
        delay: 500,
        type: "GET",
        data: function (params) {
          return {
            term: params.term,
            kode_seksi: kode_seksi,
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (obj) {
              return {
                id: obj.kdpekerjaan,
                text: obj.kdpekerjaan + " - " + obj.pekerjaan,
              };
            }),
          };
        },
      },
    });
  });

  $(".MasterPekerja-SuratMutasi-DaftarSeksi").select2({
    allowClear: false,
    placeholder: "Pilih Seksi",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_seksi",
      dataType: "json",
      delay: 500,
      type: "GET",
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.kodesie, text: obj.daftar_tseksi };
          }),
        };
      },
    },
  });

  $(".MasterPekerja-SuratMutasi-DaftarSeksi").change(function () {
    var kode_seksi = $(this).val();
    var kode_seksi = kode_seksi.substr(0, 7);

    $("#MasterPekerja-SuratMutasi-DaftarPekerjaan").select2({
      allowClear: true,
      placeholder: "Pilih Pekerjaan",
      ajax: {
        url: baseurl + "MasterPekerja/Surat/daftar_pekerjaan",
        dataType: "json",
        delay: 500,
        type: "GET",
        data: function (params) {
          return {
            term: params.term,
            kode_seksi: kode_seksi,
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (obj) {
              return {
                id: obj.kdpekerjaan,
                text: obj.kdpekerjaan + " - " + obj.pekerjaan,
              };
            }),
          };
        },
      },
    });
  });

  $("#MasterPekerja-DaftarGolonganPekerjaan").select2({
    allowClear: true,
    placeholder: "Pilih Golongan Pekerjaan",
    ajax: {
      url:
        baseurl + "MasterPekerja/Surat/SuratMutasi/daftar_golongan_pekerjaan",
      dataType: "json",
      data: function (params) {
        return {
          term: params.term,
          kode_status_kerja: $("#MasterPekerja-Surat-DaftarPekerja")
            .val()
            .substr(0, 1),
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.golkerja, text: obj.golkerja };
          }),
        };
      },
    },
  });

  // var a = $('.MasterPekerja-Surat-DaftarPekerja').val();
  // alert(a);
  $(".MasterPekerja-SuratMutasi-DaftarGolongan").select2({
    // alert('a');
    allowClear: true,
    placeholder: "Pilih Golongan Pekerjaan",
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_golongan_pekerjaan",
      dataType: "json",
      data: function (params) {
        return {
          term: params.term,
          kode_status_kerja: $(".MasterPekerja-Surat-DaftarPekerja")
            .val()
            .substr(0, 1),
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.golkerja, text: obj.golkerja };
          }),
        };
      },
    },
  });

  $("#MasterPekerja-DaftarPekerjaan").select2({
    allowClear: false,
    placeholder: "Pilih Pekerjaan",
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_pekerjaan",
      dataType: "json",
      delay: 500,
      type: "GET",
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.kdpekerjaan,
              text: obj.kdpekerjaan + " - " + obj.pekerjaan,
            };
          }),
        };
      },
    },
  });

  $(".MasterPekerja-SuratMutasi-DaftarPekerjaan").select2({
    allowClear: true,
    placeholder: "Pilih Pekerjaan",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_pekerjaan",
      dataType: "json",
      delay: 500,
      type: "GET",
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.kdpekerjaan,
              text: obj.kdpekerjaan + " - " + obj.pekerjaan,
            };
          }),
        };
      },
    },
  });

  $("#MasterPekerja-DaftarKodeJabatan").select2({
    allowClear: false,
    placeholder: "Pilih Kode Jabatan",
    minimumInputLength: 1,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_kode_jabatan_kerja",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.kd_jabatan,
              text: obj.kd_jabatan + " - " + obj.jabatan,
            };
          }),
        };
      },
    },
  });

  $(".MasterPekerja-DaftarKodeJabatan").select2({
    allowClear: false,
    placeholder: "Pilih Kode Jabatan",
    minimumInputLength: 1,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_kode_jabatan_kerja",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.kd_jabatan,
              text: obj.kd_jabatan + " - " + obj.jabatan,
            };
          }),
        };
      },
    },
  });

  $("#MasterPekerja-DaftarLokasiKerja").select2({
    allowClear: false,
    placeholder: "Pilih Lokasi Kerja",
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_lokasi_kerja",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.id_ + " - " + obj.lokasi_kerja,
              text: obj.id_ + " - " + obj.lokasi_kerja,
            };
          }),
        };
      },
    },
  });

  $(".MasterPekerja-DaftarLokasiKerja").select2({
    allowClear: false,
    placeholder: "Pilih Lokasi Kerja",
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_lokasi_kerja",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.id_ + " - " + obj.lokasi_kerja,
              text: obj.id_ + " - " + obj.lokasi_kerja,
            };
          }),
        };
      },
    },
  });

  $(".MasterPekerja-DaftarTempatMakan").select2({
    allowClear: false,
    placeholder: "Pilih Tempat Makan",
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_tempat_makan",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.fs_tempat_makan, text: obj.fs_tempat_makan };
          }),
        };
      },
    },
  });

  $("#MasterPekerja-BAPSP3-DaftarPekerja").select2({
    allowClear: false,
    placeholder: "Pilih Pekerja",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_pekerja_sp3",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.noind + " - " + obj.nama };
          }),
        };
      },
    },
  });

  $("#MasterPekerja-BAPSP3-WakilPerusahaan").select2({
    allowClear: true,
    placeholder: "Pilih Wakil Perusahaan",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_pekerja_aktif",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.noind + " - " + obj.nama };
          }),
        };
      },
    },
  });

  $("#MasterPekerja-BAPSP3-TandaTangan1").select2({
    allowClear: true,
    placeholder: "Pilih Pekerja",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_pekerja_aktif",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.noind + " - " + obj.nama };
          }),
        };
      },
    },
  });

  $("#MasterPekerja-BAPSP3-TandaTangan2").select2({
    allowClear: true,
    placeholder: "Pilih Pekerja",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/daftar_pekerja_aktif",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.noind + " - " + obj.nama };
          }),
        };
      },
    },
  });

  //  Redactor WYSIWYG Text Editor
  //  {
  $("#MasterPekerja-txtPokokMasalah").redactor();
  $("#MasterPekerja-Surat-txaPreview").redactor();
  $(".MasterPekerja-Surat-txaPreview").redactor();
  $("#MasterPekerja-SuratPerbantuan-txaPreview").redactor();
  $(".MasterPekerja-SuratRotasi-txaPreview").redactor();
  $(".MasterPekerja-SuratUsiaLanjut-txaPreview").redactor();
  $(".MasterPekerja-SuratPromosi-txaPreview").redactor();
  $("#MasterPekerja-Surat-txaFormatSurat").redactor();
  $("#MasterPekerja-SuratDemosi-txaPreview").redactor();
  $("#MasterPekerja-SuratPengangkatanStaf-txaPreview").redactor();
  $(".MasterPekerja-SuratPengalaman-txaPreview").redactor();
  $(".preview-Lapkun").redactor();

  //  }

  //  }
});

//  General Function
//  {
//  Surat-surat
//  {
$("#MasterPekerja-Surat-DaftarPekerja").change(function () {
  var noind = $("#MasterPekerja-Surat-DaftarPekerja").val();
  var kode_status_kerja = noind.substr(0, 1);
  if (noind) {
    $.ajax({
      type: "POST",
      data: { noind: noind },
      url: baseurl + "MasterPekerja/Surat/detail_pekerja",
      success: function (result) {
        var result = JSON.parse(result);
        $("#MasterPekerja-txtKodesieLama").val(
          result["kodesie"] + " - " + result["posisi"]
        );
        $("#MasterPekerja-txtPekerjaanLama").val(
          result["kode_pekerjaan"] + " - " + result["nama_pekerjaan"]
        );
        $("#MasterPekerja-txtGolonganKerjaLama").val(
          result["golongan_pekerjaan"]
        );
        $("#MasterPekerja-txtLokasiKerjaLama").val(
          result["kode_lokasi_kerja"] + " - " + result["nama_lokasi_kerja"]
        );
        $("#MasterPekerja-txtKdJabatanLama").val(
          result["kode_jabatan"] + " - " + result["jenis_jabatan"]
        );
        $("#MasterPekerja-txtJabatanLama").val(result["nama_jabatan"]);
        $("#MasterPekerja-txtTempatMakan1").val(result["tempat_makan1"]);
        $("#MasterPekerja-txtTempatMakan2").val(result["tempat_makan2"]);
        $("#MasterPekerja-txtStatusStaf").val(result["status_staf"]);
        $("#MasterPekerja-Surat-FingerAwal").val(
          result["id_lokasifinger"] + " - " + result["lokasi_finger"]
        );
        $("#MasterPekerja-txtStatusJabatanlama").val(
          result["kd_status"] + " - " + result["nama_status"]
        );
        $("#MasterPekerja-txtNamaJabatanUpahlama").val(
          result["nama_jabatan_upah"]
        );
      },
    });
    $("#MasterPekerja-DaftarGolonganPekerjaan").select2("val", "");
    $("#MasterPekerja-DaftarGolonganPekerjaan").select2({
      allowClear: false,
      placeholder: "Pilih Golongan Pekerjaan",
      ajax: {
        url: baseurl + "MasterPekerja/Surat/daftar_golongan_pekerjaan",
        dataType: "json",
        data: function (params) {
          return {
            term: params.term,
            kode_status_kerja: kode_status_kerja,
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (obj) {
              return { id: obj.golkerja, text: obj.golkerja };
            }),
          };
        },
      },
    });
  } else {
    $("#kodesieLama").select2();
    $("#MasterPekerja-DaftarGolonganPekerjaan").select2("val", "");
  }
});

$(".MasterPekerja-Surat-DaftarPekerja").change(function () {
  var noind = $(".MasterPekerja-Surat-DaftarPekerja").val();
  var kode_status_kerja = noind.substr(0, 1);
  if (noind) {
    $.ajax({
      type: "POST",
      data: { noind: noind },
      url: baseurl + "MasterPekerja/Surat/detail_pekerja",
      success: function (result) {
        var result = JSON.parse(result);
        console.log(result);
        $(".MasterPekerja-txtKodesieLama").val(
          result["kodesie"] + " - " + result["posisi"]
        );
        $(".MasterPekerja-txtPekerjaanLama").val(
          result["kode_pekerjaan"] + " - " + result["nama_pekerjaan"]
        );
        $(".MasterPekerja-txtGolonganKerjaLama").val(
          result["golongan_pekerjaan"]
        );
        $(".MasterPekerja-txtLokasiKerjaLama").val(
          result["kode_lokasi_kerja"] + " - " + result["nama_lokasi_kerja"]
        );
        $(".MasterPekerja-txtKdJabatanLama").val(
          result["kode_jabatan"] + " - " + result["jenis_jabatan"]
        );
        $(".MasterPekerja-txtJabatanLama").val(result["nama_jabatan"]);
        $(".MasterPekerja-txtTempatMakan1").val(result["tempat_makan1"]);
        $(".MasterPekerja-txtTempatMakan2").val(result["tempat_makan2"]);
        $(".MasterPekerja-txtStatusStaf").val(result["status_staf"]);
        $("#MasterPekerja-Surat-FingerAwal").val(
          result["id_lokasifinger"] + " - " + result["lokasi_finger"]
        );
        $("#MasterPekerja-txtStatusJabatanlama").val(
          result["kd_status"] + " - " + result["nama_status"]
        );
        $("#MasterPekerja-txtNamaJabatanUpahlama").val(
          result["nama_jabatan_upah"]
        );
      },
    });
    $(".MasterPekerja-SuratMutasi-DaftarGolongan").select2("val", "");
    $(".MasterPekerja-SuratMutasi-DaftarGolongan").select2({
      allowClear: true,
      placeholder: "Pilih Golongan Pekerjaan",
      ajax: {
        url: baseurl + "MasterPekerja/Surat/daftar_golongan_pekerjaan",
        dataType: "json",
        data: function (params) {
          return {
            term: params.term,
            kode_status_kerja: kode_status_kerja,
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (obj) {
              return { id: obj.golkerja, text: obj.golkerja };
            }),
          };
        },
      },
    });
  } else {
    $("#kodesieLama").select2();
    $(".MasterPekerja-SuratMutasi-DaftarGolongan").select2("val", "");
  }
});

$("#MasterPekerja-Surat-btnPreview").click(function () {
  // alert($('#MasterPekerja-txtLokasiKerjaLama').val());
  let fingerakhir = $("select[name='txtFingerGanti']").val();
  let tujuanmutasi = $("select[name='txtKodesieBaru']").val();
  let golkerja = $("select[name='txtGolonganPekerjaanBaru']").val();

  if (!tujuanmutasi) {
    Swal.fire("Oops!", "Mohon lengkapi form!", "warning");
    $("#MasterPekerja-DaftarSeksi").focus();
    $("#rowmutasi .select2-selection").css(
      "background-color",
      "rgba(255, 0, 0, 0.4)"
    );
    $("#validMutasi").show();
    return;
  }

  const pindah = $("#fingerYa").iCheck("update")[0].checked;

  if (pindah && !fingerakhir) {
    Swal.fire("Oops!", "Mohon lengkapi form!", "warning");
    $("#rowfinger .select2-selection").css(
      "background-color",
      "rgba(255, 0, 0, 0.4)"
    );
    $("#validFinger").show();
    return;
  }

  $("#surat-loading").attr("hidden", false);
  $(document).ajaxStop(function () {
    $("#surat-loading").attr("hidden", true);
  });
  $.ajax({
    type: "POST",
    data: $("#MasterPekerja-FormCreate").serialize(),
    url: baseurl + "MasterPekerja/Surat/SuratMutasi/prosesPreviewMutasi",
    dataType: "json",
    success: function (result) {
      console.log("result :" + result);
      if (result["status"]) {
        /*CKEDITOR.instances['MasterPekerja-Surat-txaPreview'].setData(result['preview']);*/
        $(".MasterPekerja-Surat-txaPreview").redactor("set", result["preview"]);
        $("#MasterPekerja-Surat-txtNomorSurat").val(result["nomor_surat"]);
        $("#MasterPekerja-Surat-txtHalSurat").val(result["hal_surat"]);
        $("#MasterPekerja-Surat-txtKodeSurat").val(result["kode_surat"]);
      } else {
        $("#surat-loading").attr("hidden", true);
        Swal.fire("Oops", "Error!", "error");
      }
    },
    error: (res) => {
      $("#surat-loading").attr("hidden", true);
      Swal.fire("Oops", "Error!", "error");
    },
  });
});

$("#MasterPekerja-SuratDemosi-btnPreview").click(function () {
  $("#surat-loading").attr("hidden", false);
  $(document).ajaxStop(function () {
    $("#surat-loading").attr("hidden", true);
  });
  $.ajax({
    type: "POST",
    data: $("#MasterPekerja-SuratDemosi-FormCreate").serialize(),
    url: baseurl + "MasterPekerja/Surat/SuratDemosi/prosesPreviewDemosi",
    success: function (result) {
      var result = JSON.parse(result);
      console.log(result);

      // CKEDITOR.instances['MasterPekerja-SuratDemosi-txaPreview'].setData(result['preview']);
      $("#MasterPekerja-SuratDemosi-txaPreview").redactor(
        "set",
        result["preview"]
      );
      $("#MasterPekerja-SuratDemosi-txtNomorSurat").val(result["nomorSurat"]);
      $("#MasterPekerja-SuratDemosi-txtHalSurat").val(result["halSurat"]);
      $("#MasterPekerja-SuratDemosi-txtKodeSurat").val(result["kodeSurat"]);
    },
  });
});

$("#MasterPekerja-SuratPromosi-btnPreview").click(function () {
  $("#surat-loading").attr("hidden", false);
  $(document).ajaxStop(function () {
    $("#surat-loading").attr("hidden", true);
  });
  $.ajax({
    type: "POST",
    data: $("#MasterPekerja-SuratPromosi-FormCreate").serialize(),
    url: baseurl + "MasterPekerja/Surat/SuratPromosi/prosesPreviewPromosi",
    success: function (result) {
      var result = JSON.parse(result);
      console.log(result);

      // CKEDITOR.instances['MasterPekerja-SuratPromosi-txaPreview'].setData(result['preview']);
      $(".MasterPekerja-SuratPromosi-txaPreview").redactor(
        "set",
        result["preview"]
      );
      $("#MasterPekerja-SuratPromosi-txtNomorSurat").val("val", "");
      $("#MasterPekerja-SuratPromosi-txtNomorSurat").val(result["nomorSurat"]);
      $("#MasterPekerja-SuratPromosi-txtHalSurat").val(result["halSurat"]);
      $("#MasterPekerja-SuratPromosi-txtKodeSurat").val(result["kodeSurat"]);
    },
  });
});
//    $('#MasterPekerja-DaftarGolonganPekerjaan').select2({
//     allowClear: false,
//     placeholder: 'Pilih Golongan Pekerjaan',
//     ajax:
//     {
//      url: baseurl+"MasterPekerja/Surat/SuratMutasi/cariGolonganPekerjaan",
//      dataType: 'json',
//      data: function (params){
//          return {
//              term: params.term,
//              kode_status_kerja: $('#MasterPekerja-Surat-DaftarPekerja').val().substr(0, 1)
//          }
//      },
//      processResults: function(data) {
//          return {
//              results: $.map(data, function(obj){
//                  return {id: obj.golkerja, text: obj.golkerja};
//              })
//          };
//      }
//  }
// });

$(".MasterPekerja-SuratPerbantuan-btnPreview").click(function () {
  $("#surat-loading").attr("hidden", false);
  $(document).ajaxStop(function () {
    $("#surat-loading").attr("hidden", true);
  });
  // alert('a');
  $.ajax({
    type: "POST",
    data: $("#MasterPekerja-SuratPerbantuan-FormCreate").serialize(),
    url:
      baseurl + "MasterPekerja/Surat/SuratPerbantuan/prosesPreviewPerbantuan",
    success: function (result) {
      var result = JSON.parse(result);
      console.log(result);

      // CKEDITOR.instances['MasterPekerja-SuratPerbantuan-txaPreview'].setData(result['preview']);
      $("#MasterPekerja-SuratPerbantuan-txaPreview").redactor(
        "set",
        result["preview"]
      );
      $("#MasterPekerja-SuratPerbantuan-txtNomorSurat").val(
        result["nomorSurat"]
      );
      $("#MasterPekerja-SuratPerbantuan-txtHalSurat").val(result["halSurat"]);
      $("#MasterPekerja-SuratPerbantuan-txtKodeSurat").val(result["kodeSurat"]);
    },
  });
});

$(".MasterPekerja-SuratRotasi-btnPreview").click(function () {
  $("#surat-loading").attr("hidden", false);
  $(document).ajaxStop(function () {
    $("#surat-loading").attr("hidden", true);
  });
  // var a = $('.MasterPekerja-Surat-DaftarPekerja').val(); alert(a);
  $.ajax({
    type: "POST",
    data: $("#MasterPekerja-SuratRotasi-FormCreate").serialize(),
    url: baseurl + "MasterPekerja/Surat/SuratRotasi/prosesPreviewRotasi",
    success: function (result) {
      var result = JSON.parse(result);
      console.log(result);

      // CKEDITOR.instances['MasterPekerja-SuratRotasi-txaPreview'].setData(result['preview']);
      $(".MasterPekerja-SuratRotasi-txaPreview").redactor(
        "set",
        result["preview"]
      );
      $(".MasterPekerja-SuratMutasi-txtNomorSurat").val(result["nomorSurat"]);
      $(".MasterPekerja-SuratMutasi-txtHalSurat").val(result["halSurat"]);
      $(".MasterPekerja-SuratMutasi-txtKodeSurat").val(result["kodeSurat"]);
    },
  });
});

$(".MasterPekerja-SuratUsiaLanjut-btnPreview").click(function () {
  $("#surat-loading").attr("hidden", false);
  $(document).ajaxStop(function () {
    $("#surat-loading").attr("hidden", true);
  });
  // var a = $('.MasterPekerja-Surat-DaftarPekerja').val(); alert(a);
  $.ajax({
    type: "POST",
    data: $("#MasterPekerja-SuratUsiaLanjut-FormCreate").serialize(),
    url:
      baseurl + "MasterPekerja/Surat/SuratUsiaLanjut/prosesPreviewUsiaLanjut",
    success: function (result) {
      var result = JSON.parse(result);
      console.log(result);

      // CKEDITOR.instances['MasterPekerja-SuratRotasi-txaPreview'].setData(result['preview']);
      $(".MasterPekerja-SuratUsiaLanjut-txaPreview").redactor(
        "set",
        result["preview"]
      );
      // $('.MasterPekerja-SuratUsiaLanjut-txtNomorSurat').val(result['nomorSurat']);
      // $('.MasterPekerja-SuratUsiaLanjut-txtHalSurat').val(result['halSurat']);
    },
  });
});

$("#MasterPekerja-SuratPengangkatanStaf-btnPreview").click(function () {
  $("#surat-loading").attr("hidden", false);
  $(document).ajaxStop(function () {
    $("#surat-loading").attr("hidden", true);
  });
  $.ajax({
    type: "POST",
    data: $("#MasterPekerja-SuratPengangkatanStaff-FormCreate").serialize(),
    url:
      baseurl +
      "MasterPekerja/Surat/SuratPengangkatanStaff/prosesPreviewPengangkatan",
    success: function (result) {
      var result = JSON.parse(result);
      console.log(result);

      // CKEDITOR.instances['MasterPekerja-SuratPengangkatan-txaPreview'].setData(result['preview']);
      $("#MasterPekerja-SuratPengangkatanStaf-txaPreview").redactor(
        "set",
        result["preview"]
      );
      $(".MasterPekerja-SuratMutasi-txtNomorSurat").val(result["nomorSurat"]);
      $(".MasterPekerja-SuratMutasi-txtHalSurat").val(result["halSurat"]);
      $(".MasterPekerja-SuratMutasi-txtKodeSurat").val(result["kodeSurat"]);
    },
  });
});

$("#MasterPekerja-BAPSP3-btnPreview").click(function () {
  if ($("#MasterPekerja-BAPSP3-DaftarPekerja").val() == "") {
    $.toaster("Mohon isi nomor induk pekerja", "", "danger");
    return;
  }
  $("#surat-loading").attr("hidden", false);
  $.ajax({
    async: true,
    type: "POST",
    data: $("#MasterPekerja-FormCreate").serialize(),
    url: baseurl + "MasterPekerja/Surat/BAPSP3/prosesPreviewBAPSP3",
    success: function (response) {
      try {
        response = JSON.parse(response);
        $("#MasterPekerja-Surat-txaPreview").redactor(
          "set",
          response["preview"]
        );
      } catch (e) {
        console.error(e);
        $.toaster("Terjadi kesalahan saat memuat preview", "", "danger");
      }
      $("#surat-loading").attr("hidden", true);
    },
    error: function (response) {
      console.error(response.status);
      $.toaster("Terjadi kesalahan saat memuat preview", "", "danger");
      $("#surat-loading").attr("hidden", true);
    },
  });
});

$("#MasterPekerja-BAPSP3-DaftarPekerja").change(function () {
  var noind = $("#MasterPekerja-BAPSP3-DaftarPekerja").val();
  if (noind) {
    $.ajax({
      type: "POST",
      data: { noind: noind },
      url: baseurl + "MasterPekerja/Surat/detail_pekerja",
      success: function (result) {
        var result = JSON.parse(result);
        $("#MasterPekerja-txtAlamatPekerja").val(result["alamat"]);
        $("#MasterPekerja-txtCustomJabatan").val(result["custom_jabatan"]);
        $("#MasterPekerja-txtNamaPerusahaan").val(result["nama_perusahaan"]);
        $("#MasterPekerja-txtAlamatPerusahaan").val(
          result["alamat_perusahaan"]
        );
      },
    });
  }
});

//  }

//  }
//  -------Master Pekerja----------------------------------------------end

// alert(top.location.pathname);
$(document).ready(function () {
  $(".jabatan").change(function () {
    var kd = $(".mpk-kdbaru").val();
    // alert(kd);
    var job = $(".kerja").val();
    var teks = $(".jabatan").val();
    var isi = $(".setjabatan").val().length;
    // if (isi < 1) {
    $.post(
      baseurl + "MasterPekerja/Surat/SuratDemosi/jabatan",
      {
        name: teks,
        job: job,
        kd: kd,
      },
      function (data, status) {
        // alert(data.trim());
        $(".setjabatan").val(data.trim().toUpperCase());
      }
    );
    // }
  });
  $(".mpk-kdbaru").change(function () {
    var kd = $(".mpk-kdbaru").val();
    // alert(kd);
    var job = $(".kerja").val();
    var teks = $(".jabatan").val();
    var isi = $(".setjabatan").val().length;
    // if (isi < 1) {
    $.post(
      baseurl + "MasterPekerja/Surat/SuratDemosi/jabatan",
      {
        name: teks,
        job: job,
        kd: kd,
      },
      function (data, status) {
        // alert(data.trim());
        $(".setjabatan").val(data.trim().toUpperCase());
      }
    );
    // }
  });
});
//-------------------------------------pengangkatan-----------------------------
$(document).ready(function () {
  var st = $(".stafStatus").val();
  if (st == "1") {
    st = "daftar_pekerja_pengangkatan_non";
  } else {
    st = "daftar_pekerja_pengangkatan";
  }
  $(".MasterPekerja-Surat-DaftarPekerja-staf").select2({
    allowClear: false,
    placeholder: "Pilih Pekerja",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/" + st,
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.noind + " - " + obj.nama };
          }),
        };
      },
    },
  });

  $(".MasterPekerja-Surat-DaftarPekerja-staf-pengangkatan").select2({
    allowClear: false,
    placeholder: "Pilih Pekerja",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/" + st,
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.noind + " - " + obj.nama };
          }),
        };
      },
    },
  });
});
$(".MasterPekerja-Surat-DaftarPekerja-staf").change(function () {
  var noind = $(".MasterPekerja-Surat-DaftarPekerja-staf").val();
  var kode_status_kerja = noind.substr(0, 1);
  if (noind) {
    $.ajax({
      type: "POST",
      data: { noind: noind },
      url: baseurl + "MasterPekerja/Surat/detail_pekerja",
      success: function (result) {
        var result = JSON.parse(result);

        $(".MasterPekerja-txtKodesieLama").val(
          result["kodesie"] + " - " + result["posisi"]
        );
        $(".MasterPekerja-txtPekerjaanLama").val(
          result["kode_pekerjaan"] + " - " + result["nama_pekerjaan"]
        );
        $(".MasterPekerja-txtGolonganKerjaLama").val(
          result["golongan_pekerjaan"]
        );
        $(".MasterPekerja-txtLokasiKerjaLama").val(
          result["kode_lokasi_kerja"] + " - " + result["nama_lokasi_kerja"]
        );
        $(".MasterPekerja-txtKdJabatanLama").val(
          result["kode_jabatan"] + " - " + result["jenis_jabatan"]
        );
        $(".MasterPekerja-txtJabatanLama").val(result["nama_jabatan"]);
        $(".MasterPekerja-txtTempatMakan1").val(result["tempat_makan1"]);
        $(".MasterPekerja-txtTempatMakan2").val(result["tempat_makan2"]);
        $(".MasterPekerja-txtStatusStaf").val(result["status_staf"]);
      },
    });
    $(".MasterPekerja-SuratMutasi-DaftarGolongan").select2("val", "");
    $(".MasterPekerja-SuratMutasi-DaftarGolongan").select2({
      allowClear: true,
      placeholder: "Pilih Golongan Pekerjaan",
      ajax: {
        url: baseurl + "MasterPekerja/Surat/daftar_golongan_pekerjaan",
        dataType: "json",
        data: function (params) {
          return {
            term: params.term,
            kode_status_kerja: kode_status_kerja,
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (obj) {
              return { id: obj.golkerja, text: obj.golkerja };
            }),
          };
        },
      },
    });
  } else {
    $("#kodesieLama").select2();
    $(".MasterPekerja-SuratMutasi-DaftarGolongan").select2("val", "");
  }
});

$(".MasterPekerja-Surat-DaftarPekerja-staf-pengangkatan").change(function () {
  var noind = $(".MasterPekerja-Surat-DaftarPekerja-staf-pengangkatan").val();
  var kode_status_kerja = noind.substr(0, 1);
  if (noind) {
    $.ajax({
      type: "POST",
      data: { noind: noind },
      url: baseurl + "MasterPekerja/Surat/detail_pekerja",
      success: function (result) {
        var result = JSON.parse(result);
        // alert(result);

        $(".MasterPekerja-txtKodesieLama").val(
          result["kodesie"] + " - " + result["posisi"]
        );
        $(".MasterPekerja-txtPekerjaanLama").val(
          result["kode_pekerjaan"] + " - " + result["nama_pekerjaan"]
        );
        $(".MasterPekerja-txtGolonganKerjaLama").val(
          result["golongan_pekerjaan"]
        );
        $(".MasterPekerja-txtLokasiKerjaLama").val(
          result["kode_lokasi_kerja"] + " - " + result["nama_lokasi_kerja"]
        );
        $(".MasterPekerja-txtKdJabatanLama").val(
          result["kode_jabatan"] + " - " + result["jenis_jabatan"]
        );
        $(".MasterPekerja-txtJabatanLama").val(result["nama_jabatan"]);
        $(".MasterPekerja-txtTempatMakan1").val(result["tempat_makan1"]);
        $(".MasterPekerja-txtTempatMakan2").val(result["tempat_makan2"]);
        $(".MasterPekerja-txtStatusStaf").val(result["status_staf"]);
        $(".MasterPekerja-txtjabatanDlLama").val(result["jabatan_dl"]);
        $("#MasterPekerja-Surat-FingerAwal").val(
          result["id_lokasifinger"] + " - " + result["lokasi_finger"]
        );
        // alert(result);
      },
    });
    $(".MasterPekerja-SuratMutasi-DaftarGolongan").select2("val", "");
    $(".MasterPekerja-SuratMutasi-DaftarGolongan").select2({
      allowClear: true,
      placeholder: "Pilih Golongan Pekerjaan",
      ajax: {
        url: baseurl + "MasterPekerja/Surat/daftar_golongan_pekerjaan",
        dataType: "json",
        data: function (params) {
          return {
            term: params.term,
            kode_status_kerja: kode_status_kerja,
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (obj) {
              return { id: obj.golkerja, text: obj.golkerja };
            }),
          };
        },
      },
    });
  } else {
    $("#kodesieLama").select2();
    $(".MasterPekerja-SuratMutasi-DaftarGolongan").select2("val", "");
  }
});

$(function () {
  $("#MasterPekerja-txtPokokMasalah").redactor(
    "set",
    "Sdr.   <strong>[nama_pekerja] ([noind_pekerja]) </strong>mendapat  Surat Peringatan Ke-3 yang berlaku sejak tanggal <strong>[tgl_berlaku_mulai] sampai dengan tanggal [tgl_berlaku_selesai]&nbsp;</strong>sehingga     berdasarkan Perjanjian Kerja Bersama CV. Karya Hidup Sentosa dan    Pasal 161 (1) UU No 13 Tahun 2003 tentang Ketenagakerjaan, apabila  yang bersangkutan melakukan pelanggaran kembali terhadap Perjanjian     Kerja Bersama selama berlakunya Surat Peringatan Ke-3 tersebut, maka    perusahaan akan melakukan Pemutusan Hubungan Kerja."
  );
  $(document).on("change", ".noind", function (event) {
    var isi = $(".noind").val();
    if (isi.substring(0, 1) == "J") {
      $(".MasterPekerja-txtNoindBaru").val(isi);
      $(".MasterPekerja-txtNoindBaru").attr("readonly", true);
    } else {
      $(".MasterPekerja-txtNoindBaru").val("");
      $(".MasterPekerja-txtNoindBaru").attr("readonly", false);
    }
  });
  if ($("select").hasClass("golker")) {
    // alert(top.location.pathname);
    var noind = $(".golker").val();
    var kode_status_kerja = noind.substr(0, 1);
    $(".MasterPekerja-SuratMutasi-DaftarGolongan").select2({
      allowClear: true,
      placeholder: "Pilih Golongan Pekerjaan",
      ajax: {
        url: baseurl + "MasterPekerja/Surat/daftar_golongan_pekerjaan",
        dataType: "json",
        data: function (params) {
          return {
            term: params.term,
            kode_status_kerja: kode_status_kerja,
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (obj) {
              return { id: obj.golkerja, text: obj.golkerja };
            }),
          };
        },
      },
    });
  } else {
    // alert('a');
  }
});

$(document).ready(function () {
  $("#tbl_lapkun").DataTable();

  $("#Saksi_Janji1").select2({
    placeholder: "Input Nama Saksi",
  });

  $("#Saksi_Janji2").select2({
    placeholder: "Input Nama Saksi",
  });

  $("#Saksi_Janji3").select2({
    placeholder: "Input Nama Saksi",
  });

  $("#usialanjut").DataTable();
});

$(document).on("ready", function () {
  $(".setupPekerjaan-cmbDepartemen").select2({
    minimumResultsForSearch: -1,
    allowClear: false,
    ajax: {
      url: baseurl + "MasterPekerja/SetupPekerjaan/daftarDepartemen",
      dataType: "json",
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            // if (obj.kode_departemen == '2') {
            //  return {id: obj.kode_departemen, text: obj.nama_departemen, disabled: true};
            // }
            return { id: obj.kode_departemen, text: obj.nama_departemen };
          }),
        };
      },
    },
  });

  $(document).on("change", ".setupPekerjaan-cmbDepartemen", function () {
    var departemen = $(this).val();
    // alert(departemen);
    if (departemen == "0") {
      $(".setupPekerjaan-cmbBidang").each(function () {
        //added a each loop here
        $(this).select2("destroy").val("").select2();
      });
      $(".setupPekerjaan-cmbUnit").each(function () {
        //added a each loop here
        $(this).select2("destroy").val("").select2();
      });
      $(".setupPekerjaan-cmbSeksi").each(function () {
        //added a each loop here
        $(this).select2("destroy").val("").select2();
      });

      $(".setupPekerjaan-cmbBidang").attr("disabled", "true");
      $(".setupPekerjaan-cmbUnit").attr("disabled", "true");
      $(".setupPekerjaan-cmbSeksi").attr("disabled", "true");
    } else {
      $(".setupPekerjaan-cmbBidang").each(function () {
        //added a each loop here
        $(this).select2("destroy").val("").select2();
      });
      $(".setupPekerjaan-cmbUnit").each(function () {
        //added a each loop here
        $(this).select2("destroy").val("").select2();
      });
      $(".setupPekerjaan-cmbSeksi").each(function () {
        //added a each loop here
        $(this).select2("destroy").val("").select2();
      });

      $(".setupPekerjaan-cmbBidang").removeAttr("disabled");
      $(".setupPekerjaan-cmbUnit").removeAttr("disabled");
      $(".setupPekerjaan-cmbSeksi").removeAttr("disabled");

      $(".setupPekerjaan-cmbBidang").select2({
        minimumResultsForSearch: -1,
        ajax: {
          url: baseurl + "MasterPekerja/SetupPekerjaan/daftarBidang",
          dataType: "json",
          data: function (params) {
            return {
              term: params.term,
              departemen: departemen,
            };
          },
          processResults: function (data) {
            return {
              results: $.map(data, function (obj) {
                return { id: obj.kode_bidang, text: obj.nama_bidang };
              }),
            };
          },
        },
      });
      $.ajax({
        data: { kodesie: departemen },
        url: baseurl + "MasterPekerja/SetupPekerjaan/getKodePekerjaan",
        type: "POST",
        success: function (data) {
          $("#txtKodeUrut").val(data);
        },
      });
    }
  });

  $(document).on("change", ".setupPekerjaan-cmbBidang", function () {
    var bidang = $(this).val();

    if (bidang.substr(bidang.length - 2) == "00") {
      $(".setupPekerjaan-cmbUnit").each(function () {
        //added a each loop here
        $(this).select2("destroy").val("").select2();
      });
      $(".setupPekerjaan-cmbSeksi").each(function () {
        //added a each loop here
        $(this).select2("destroy").val("").select2();
      });

      $(".setupPekerjaan-cmbUnit").attr("disabled", "true");
      $(".setupPekerjaan-cmbSeksi").attr("disabled", "true");
    } else {
      $(".setupPekerjaan-cmbUnit").each(function () {
        //added a each loop here
        $(this).select2("destroy").val("").select2();
      });
      $(".setupPekerjaan-cmbSeksi").each(function () {
        //added a each loop here
        $(this).select2("destroy").val("").select2();
      });

      $(".setupPekerjaan-cmbUnit").removeAttr("disabled");
      $(".setupPekerjaan-cmbSeksi").removeAttr("disabled");

      $(".setupPekerjaan-cmbUnit").select2({
        minimumResultsForSearch: -1,
        ajax: {
          url: baseurl + "MasterPekerja/SetupPekerjaan/daftarUnit",
          dataType: "json",
          data: function (params) {
            return {
              term: params.term,
              bidang: bidang,
            };
          },
          processResults: function (data) {
            return {
              results: $.map(data, function (obj) {
                return { id: obj.kode_unit, text: obj.nama_unit };
              }),
            };
          },
        },
      });
      $.ajax({
        data: { kodesie: bidang },
        url: baseurl + "MasterPekerja/SetupPekerjaan/getKodePekerjaan",
        type: "POST",
        success: function (data) {
          $("#txtKodeUrut").val(data);
        },
      });
    }
  });

  $(document).on("change", ".setupPekerjaan-cmbUnit", function () {
    var unit = $(this).val();

    if (unit.substr(unit.length - 2) == "00") {
      $(".setupPekerjaan-cmbSeksi").each(function () {
        //added a each loop here
        $(this).select2("destroy").val("").select2();
      });

      $(".setupPekerjaan-cmbSeksi").attr("disabled", "true");
    } else {
      $(".setupPekerjaan-cmbSeksi").each(function () {
        //added a each loop here
        $(this).select2("destroy").val("").select2();
      });

      $(".setupPekerjaan-cmbSeksi").removeAttr("disabled");

      $(".setupPekerjaan-cmbSeksi").select2({
        minimumResultsForSearch: -1,
        ajax: {
          url: baseurl + "MasterPekerja/SetupPekerjaan/daftarSeksi",
          dataType: "json",
          data: function (params) {
            return {
              term: params.term,
              unit: unit,
            };
          },
          processResults: function (data) {
            return {
              results: $.map(data, function (obj) {
                return { id: obj.kode_seksi, text: obj.nama_seksi };
              }),
            };
          },
        },
      });

      $.ajax({
        data: { kodesie: unit },
        url: baseurl + "MasterPekerja/SetupPekerjaan/getKodePekerjaan",
        type: "POST",
        success: function (data) {
          $("#txtKodeUrut").val(data);
        },
      });
    }
  });

  $(document).on("change", ".setupPekerjaan-cmbSeksi", function () {
    var unit = $(this).val();
    $.ajax({
      data: { kodesie: unit },
      url: baseurl + "MasterPekerja/SetupPekerjaan/getKodePekerjaan",
      type: "POST",
      success: function (data) {
        $("#txtKodeUrut").val(data);
      },
    });
  });
});

$(".nyobaaja").click(function () {
  $("#id_sangu").val($(this).attr("value"));
});

$(".prevSangu").click(function () {
  let a = $(this).attr("value");
  $.ajax({
    type: "get",
    dataType: "json",
    url: baseurl + "MasterPekerja/PerhitunganPesangon/getDataPreview/" + a,
    success: function (result) {
      $("#Psg_approver1").val(result.dataPreview[0].pengirim).trigger("change");
      $("#id_prev_sangu").val(result.dataPreview[0].id).trigger("change");
      $("#psg_tglCetak")
        .val(result.dataPreview[0].tgl_cetak_prev)
        .trigger("change");
      $("#Modal_Tertanda_Pesangon").modal("show");
    },
  });
});

$("#perjanjianPHK").click(function () {
  let saksi1 = $("#Saksi_Janji1").val(),
    saksi2 = $("#Saksi_Janji2").val();

  if (saksi1 === null || saksi1 == "") {
    Swal.fire("Peringatan!", "Saksi 1 Harus Di Input!", "warning");
  } else {
    $("#Modal_Hadirin_Perjanjian").modal("hide");
  }
});

$("#form_cetak_sangu").submit(function (e) {
  e.preventDefault();
  a = $("#id_modal_cetak_sangu").val();
  this.submit();
  setTimeout(function () {
    window.open(a, "_self");
  }),
    100;
});

// JS untuk Memo Pemberitahuan Gaji Pekerja Cutoff

$(".deleteMemoCutoff").click(function () {
  let id = $(this).data("value");

  Swal.fire({
    title: "Apakah Anda Yakin?",
    text: "Mengapus data ini secara permanent !",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.value) {
      window.location.href =
        baseurl + "MasterPekerja/Surat/gajipekerjacutoff/deleteMemo/" + id;
    }
  });
  return false;
});

$(".btn_save_info")
  .prop("disabled", true)
  .click(function () { });
$(".MPK_tertandaInfo").select2("disabled", true);

$("#monthpickerq").on("change", function () {
  let periode = $(this).val();
  $("#surat-loading").removeAttr("hidden");

  $.ajax({
    method: "post",
    data: { ajaxPeriode: periode },
    url: baseurl + "MasterPekerja/Surat/gajipekerjacutoff/getDataPeriode",
    success: function (data) {
      $(".MPK-btnPratinjauCutoff")
        .prop("disabled", true)
        .click(function () { });
      $("#surat-loading").attr("hidden", true);
      if (data == "null") {
        swal.fire({
          title: "Peringatan",
          text: "Periode Cutoff tidak ditemukan",
          type: "warning",
          showConfirmButton: false,
        });
        window.location.href =
          baseurl + "MasterPekerja/Surat/gajipekerjacutoff/create_Info";
      }
      $("#periodikCutoff").html(data);
      $("#monthpickerq").val(periode);
      $("#MPK_infoPekerja").change(function () {
        let jenis = $(this).val();
        if (jenis == "nonstaf") {
          $("#groupPekerjaInfo").removeClass("hidden");
          $("#groupPekerjaStafInfo").addClass("hidden");
          $("#MPK-btnPratinjauCutoff")
            .prop("disabled", true)
            .click(function () { });
          $("#MPK_txtaAlasan").attr("readonly", true);
          $("#btnInfonext").click(function () {
            $("#MPK_txtaAlasan").attr("readonly", false);
            $("#MPK-btnPratinjauCutoff").prop("disabled", false);
          });
        } else if (jenis == "staf") {
          $("#groupPekerjaInfo").addClass("hidden");
          $("#groupAtasanInfo").addClass("hidden");
          $("#groupPekerjaStafInfo").removeClass("hidden");
          $("#MPK-btnPratinjauCutoff").prop("disabled", false);
          $("#MPK_txtaAlasan").attr("readonly", false);
        } else {
          $("#MPK-btnPratinjauCutoff")
            .prop("disabled", true)
            .click(function () { });
          $("#MPK_txtaAlasan").attr("readonly", true);
          $("#groupPekerjaInfo").addClass("hidden");
          $("#groupAtasanInfo").addClass("hidden");
          $("#groupPekerjaStafInfo").addClass("hidden");
        }

        $.ajax({
          method: "post",
          data: { jenis: jenis },
          url: baseurl + "MasterPekerja/Surat/gajipekerjacutoff/getAlasan",
          success: function (data) {
            if ((jenis = "nonstaf")) {
              $("#MPK_txtaAlasan").val(data);
              $("#MPK_txtaAlasan").text(data);
            } else if (jenis == "staf") {
              $("#MPK_txtaAlasan").val(data);
              $("#MPK_txtaAlasan").text(data);
            } else {
              $("#MPK_txtaAlasan").val("");
              $("#MPK_txtaAlasan").text("");
            }
          },
        });
      });

      $("#MPK_txtaIsi").redactor();

      $("#MPK-btnPratinjauCutoff").click(function () {
        $("#surat-loading").attr("hidden", false);
        let allnoind = [];
        let getnoind = $(".noind-staff").each(function () {
          let newind = $(this).text().trim();
          allnoind.push(newind);
        });
        let seksiname = [];
        let name = $(".namaSeksi").each(function () {
          let namesie = $(this).text().trim();
          seksiname.push(namesie);
        });

        let noindnstaf = [];
        let getnstaf = $(".noind-nonstaff").each(function () {
          let nstaf = $(this).text().trim();
          noindnstaf.push(nstaf);
        });
        let atasanA = [];
        let check = [];
        $(".classkuhehe").each(function () {
          let newats = $(this).val().trim();
          atasanA.push(newats);
          if (newats == "" || newats == null) {
            Swal.fire({
              title: "Peringatan",
              text: "Pastikan Anda telah mengisi parameter yang diperlukan. ;)",
              type: "warning",
            });
            $("#surat-loading").attr("hidden", true);
            check.push(true);
            return false;
          }
        });
        let jenis = $("#MPK_infoPekerja").val();
        let approval = $("#MPK_tertandaInfo").val();
        let alasan = $("#MPK_txtaAlasan").val();
        let period = $("#monthpickerq").val();

        if (check[0] == true) {
          return false;
        }

        if (allnoind == "" || allnoind == null || noindnstaf == "") {
          Swal.fire({
            title: "Peringatan",
            text: "Pastikan Anda telah mengisi parameter yang diperlukan. ;)",
            type: "warning",
          });
        } else {
          $.ajax({
            type: "POST",
            data: {
              allnoind: allnoind,
              jenis: jenis,
              approval: approval,
              alasan: alasan,
              nstaf: noindnstaf,
              noindA: atasanA,
              periodeBaru: period,
              seksiName: seksiname,
            },
            url:
              baseurl + "MasterPekerja/Surat/gajipekerjacutoff/isi_memo_cutoff",
            success: function (result) {
              $(".btn_save_info").prop("disabled", false);
              var result = JSON.parse(result);
              $("#MPK_txtaIsi").redactor("set", result["isi_txt_memo_cutoff"]);
              $("#surat-loading").attr("hidden", true);
            },
          });
        }
      });

      $(".deletenonstaf").click(function () {
        $(this).closest("tr").remove();
      });

      $(document).ready(function () {
        $("#MPK_tertandaInfo").select2({
          allowClear: true,
          placeholder: "Pilih Approval",
        });

        $("#MPK_infoPekerja").select2({
          allowClear: true,
          placeholder: "Pilih Status Pekerja",
        });
      });
    },
  });
});

function nextInfo() {
  $("#groupPekerjaInfo").addClass("hidden");
  $("#groupAtasanInfo").removeClass("hidden");

  let noindnstaf1 = [];
  let getnstaf1 = $(".noind-nonstaff").each(function () {
    let nstaf1 = $(this).text().trim();
    noindnstaf1.push(nstaf1);
  });
  $("#surat-loading").attr("hidden", false);
  $.ajax({
    method: "post",
    data: { noindnstaf: noindnstaf1 },
    url: baseurl + "MasterPekerja/Surat/gajipekerjacutoff/getTabel",
    success: function (data) {
      $("#surat-loading").attr("hidden", true);
      $("#groupAtasanInfo").html(data);
      $(document).ready(function () {
        $(".classkuhehe").select2({
          allowClear: true,
          placeholder: "Pilih Atasan",
        });
      });
    },
  });
}

//Perizinan Dinas
$(document).ready(function () {
  $(".tabel_izin").DataTable({
    ordering: false,
    paging: false,
    searching: false,
  });

  $(".tabel_rekap").DataTable({
    dom: "Bfrtip",
    buttons: ["excel", "pdf"],
    scrollX: true,
    fixedColumns: {
      leftColumns: 4,
    },
  });

  // $("input.periodeRekap").monthpicker({
  //   changeYear:true,
  //   dateFormat: 'yy-mm', });

  $("#app_edit_Dinas").on("click", function () {
    var loading = baseurl + "assets/img/gif/loadingquick.gif";
    let jenis = $(this).val();
    let id = $("#modal-id_dinas").val();
    let ket = $("#modal-kep_dinas").val();
    let out = $("#modal-keluar_dinas").val();
    let ma = [];
    let checkbox = $("input:checkbox[class=checkAll_edit_class]:checked");
    checkbox.each(function () {
      ma.push($(this).val());
    });

    let dt = new Date(),
      hours = dt.getHours(),
      minutes = dt.getMinutes(),
      seconds = dt.getSeconds(),
      timeEat = "090000";
    time = hours + "" + minutes + "" + seconds;

    if (ma == null || ma == "") {
      swal.fire({
        title: "Peringatan",
        text: "Harap Pilih Pekerja",
        type: "warning",
        allowOutsideClick: false,
      });
    } else {
      swal
        .fire({
          title: "Checking...",
          text: "Sudahkah Anda mengecek pekerja yang Berangkat Dinas ?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "OK",
          allowOutsideClick: false,
        })
        .then((result) => {
          if (result.value) {
            swal
              .fire({
                title: "Peringatan",
                text: "Anda akan memberikan keputusan APPROVE !",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "OK",
                allowOutsideClick: false,
              })
              .then((result) => {
                if (result.value) {
                  $.ajax({
                    type: "post",
                    data: {
                      jenis: jenis,
                      id: id,
                      pekerja: ma,
                      keluar: out,
                      ket: ket,
                    },
                    beforeSend: function () {
                      Swal.fire({
                        html:
                          "<img style='width: 320px; height: auto;'src='" +
                          loading +
                          "'>",
                        text: "Loading...",
                        customClass: "swal-wide",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                      });
                    },
                    url:
                      baseurl + "PerizinanDinas/AtasanApproval/updatePekerja",
                    dataType: "JSON",
                    success: function (data) {
                      Swal.fire({
                        title: "Izin Telah di Approve",
                        type: "success",
                        showCancelButton: false,
                        allowOutsideClick: false,
                      }).then((result) => {
                        if (result.value) {
                          if (time > timeEat) {
                            let pekerja = "";
                            for (let i = 0; i < data.length; i++) {
                              pekerja += i + 1 + ". " + data[i] + "<br>";
                            }

                            if (pekerja) {
                              swal.close();
                              Swal.fire({
                                title: "Warning !",
                                html:
                                  "<div><p align='left'>Pekerja berikut memilih makan di tempat dinas namun karena <b>waktu approve telah melebihi batas waktu pesan makan</b>, sehingga pekerja otomatis tidak dipesankan makan =<br>" +
                                  pekerja +
                                  "</p>",
                                type: "warning",
                                customClass: "swal-wide",
                                allowOutsideClick: false,
                              }).then((a) => {
                                if (a.value) {
                                  fun_reload();
                                }
                              });
                            } else {
                              fun_reload();
                            }
                          } else {
                            fun_reload();
                          }
                        }
                      });
                    },
                  });
                }
              });
          }
        });
    }
  });

  $("#modal-approve-dinas").on("hidden.bs.modal", function () {
    $(".icheckbox_flat-blue").removeClass("checked");
  });
});

function getApproval(a, b) {
  let loading = baseurl + "assets/img/gif/loadingquick.gif",
    dt = new Date(),
    hours = dt.getHours(),
    minutes = dt.getMinutes(),
    seconds = dt.getSeconds(),
    timeEat = "090000";

  hours = hours < 10 ? "0" + hours : hours;
  minutes = minutes < 10 ? "0" + minutes : minutes;
  seconds = seconds < 10 ? "0" + seconds : seconds;
  time = hours + "" + minutes + "" + seconds;

  if (a == "1") {
    swal
      .fire({
        title: "Checking...",
        text: "Sudahkah Anda mengecek pekerja yang Berangkat Dinas ?",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "OK",
        allowOutsideClick: false,
      })
      .then((result) => {
        if (result.value) {
          swal
            .fire({
              title: "Peringatan",
              text: "Anda akan memberikan keputusan APPROVE !",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "OK",
              allowOutsideClick: false,
            })
            .then((result) => {
              if (result.value) {
                $.ajax({
                  beforeSend: function () {
                    Swal.fire({
                      html:
                        "<img style='width: 320px; height: auto;'src='" +
                        loading +
                        "'>",
                      text: "Loading...",
                      customClass: "swal-wide",
                      showConfirmButton: false,
                      allowOutsideClick: false,
                    });
                  },
                  data: {
                    keputusan: a,
                    id: b,
                  },
                  type: "post",
                  url: baseurl + "PerizinanDinas/AtasanApproval/update",
                  dataType: "JSON",
                  success: function (data) {
                    swal.close();
                    Swal.fire({
                      title: "Izin Telah di Approve",
                      type: "success",
                      showCancelButton: false,
                      allowOutsideClick: false,
                    }).then((result) => {
                      if (result.value) {
                        if (time > timeEat) {
                          let pekerja = "";
                          for (let i = 0; i < data.length; i++) {
                            pekerja += i + 1 + ". " + data[i] + "<br>";
                          }

                          if (pekerja) {
                            swal.close();
                            Swal.fire({
                              title: "Warning !",
                              html:
                                "<div><p align='left'>Pekerja berikut memilih makan di tempat dinas namun karena <b>waktu approve telah melebihi batas waktu pesan makan</b>, sehingga pekerja otomatis tidak dipesankan makan =<br>" +
                                pekerja +
                                "</p>",
                              type: "warning",
                              customClass: "swal-wide",
                              allowOutsideClick: false,
                            }).then((a) => {
                              if (a.value) {
                                fun_reload();
                              }
                            });
                          } else {
                            fun_reload();
                          }
                        } else {
                          fun_reload();
                        }
                      }
                    });
                  },
                });
              }
            });
        }
      });
  } else if (a == "2") {
    swal
      .fire({
        title: "Peringatan",
        text: "Anda akan memberikan keputusan REJECT !",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "OK",
        allowOutsideClick: false,
      })
      .then((result) => {
        if (result.value) {
          $.ajax({
            beforeSend: function () {
              Swal.fire({
                html:
                  "<img style='width: 320px; height: auto;'src='" +
                  loading +
                  "'>",
                text: "Loading...",
                customClass: "swal-wide",
                showConfirmButton: false,
                allowOutsideClick: false,
              });
            },
            data: {
              keputusan: a,
              id: b,
            },
            type: "post",
            url: baseurl + "PerizinanDinas/AtasanApproval/update",
            success: function (data) {
              Swal.fire({
                title: "Izin Telah di Reject",
                type: "error",
                showCancelButton: false,
                allowOutsideClick: false,
              }).then((result) => {
                fun_reload();
              });
            },
          });
        }
      });
  }
}

function fun_reload() {
  let loading = baseurl + "assets/img/gif/loadingquick.gif";
  console.log("i am right here");

  Swal.fire({
    html: "<img style='width: 320px; height: auto;'src='" + loading + "'>",
    text: "Loading...",
    customClass: "swal-wide",
    showConfirmButton: false,
    allowOutsideClick: false,
  });
  window.location.reload(function (params) {
    swal.close();
  });
}

function edit_pkj_dinas(id) {
  let table = $(".eachPekerjaEdit");

  $.ajax({
    type: "post",
    data: {
      id: id,
    },
    url: baseurl + "PerizinanDinas/AtasanApproval/editPekerjaDinas",
    beforeSend: (a) => {
      table.html('<tr><td colspan="4">loading....</td></tr>');
    },
    dataType: "json",
    success: function (data) {
      $("#modal-approve-dinas").modal("show");
      $("#modal-id_dinas").val(data[0]["izin_id"]);
      $("#modal-tgl_dinas").val(data[0]["created_date"]);
      $("#modal-keluar_dinas").val(function () {
        if (data[0]["berangkat"] == null) {
          return "-";
        } else if (data[0]["berangkat"] < "12:00:00") {
          return data[0]["berangkat"] + " AM";
        } else {
          return data[0]["berangkat"] + " PM";
        }
      });
      $("#modal-kep_dinas").val(data[0]["keterangan"]);

      let row;
      data.forEach((a) => {
        row += `<tr>
                            <td><input type="checkbox" class="checkAll_edit_class" value="${a.noind
          }"></td>
                            <td>${a.noind}</td>
                            <td>${a.nama}</td>
                            <td>${a.tujuan == "" ? "-" : a.tujuan}</td>
                        </tr>`;
      });
      table.html(row);

      $("input#checkAll_edit").on("ifChecked ifUnchecked", function (event) {
        $(".checkAll_edit_class").prop(
          "checked",
          event.type == "ifChecked" ? true : false
        );
        $(this).prop("checked", event.type == "ifChecked" ? true : false);
      });
    },
  });
}

//Perizinan Dinas ALL
$(document).ready(function () {
  $("#modal-approve-dinas-All").on("hidden.bs.modal", function () {
    $(".icheckbox_flat-blue").removeClass("checked");
  });

  $("#modal-Atasan_dinasAll").select2({
    searching: true,
  });

  $("#app_edit_DinasAll").on("click", function () {
    let loading = baseurl + "assets/img/gif/loadingquick.gif";
    let jenis = $(this).val();
    let id = $("#modal-id_dinasAll").val();
    let atasan = $("#modal-Atasan_dinasAll").val();
    let ket = $("#modal-kep_dinasAll").val();
    let out = $("#modal-keluar_dinasAll").val();
    let tanggal = $("#modal-tgl_dinasAll").val();
    let alasan = $("#modal-AlasanAll").val();

    if (alasan == "" || alasan == null) {
      swal.fire({
        title: "Peringatan",
        text: "Alasan harap diisi !",
        type: "warning",
        allowOutsideClick: false,
      });
    } else if (atasan == null || atasan == "") {
      swal.fire({
        title: "Peringatan",
        text: "Harap Pilih Atasan !",
        type: "warning",
        allowOutsideClick: false,
      });
    } else {
      swal
        .fire({
          title: "Peringatan",
          text: "Anda yakin akan menyimpan perubahan ?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "OK",
          allowOutsideClick: false,
        })
        .then((result) => {
          if (result.value) {
            $.ajax({
              type: "post",
              data: {
                jenis,
                id,
                atasan,
                ket,
                keluar: out,
                tgl: tanggal,
                alasan,
              },
              beforeSend: function () {
                Swal.fire({
                  html:
                    "<img style='width: 320px; height: auto;'src='" +
                    loading +
                    "'>",
                  text: "Loading...",
                  customClass: "swal-wide",
                  showConfirmButton: false,
                  allowOutsideClick: false,
                });
              },
              url: baseurl + "PerizinanDinas/ApproveAll/updatePekerja",
              success: function (data) {
                if (data == "sama") {
                  swal.fire({
                    title: "Pemberitahuan",
                    text: "Atasan Masih Sama",
                    type: "info",
                    allowOutsideClick: false,
                  });
                } else {
                  Swal.fire({
                    title: "Approver Perizinan Telah Dialihkan",
                    type: "success",
                    showCancelButton: false,
                    allowOutsideClick: false,
                  }).then((result) => {
                    Swal.fire({
                      html:
                        "<img style='width: 320px; height: auto;'src='" +
                        loading +
                        "'>",
                      text: "Loading...",
                      customClass: "swal-wide",
                      showConfirmButton: false,
                      allowOutsideClick: false,
                    }).then(window.location.reload());
                  });
                }
              },
            });
          }
        });
    }
  });
});

function edit_pkj_dinas_all(id, btn_val) {
  let table = $(".eachPekerjaEditAll");

  $.ajax({
    type: "post",
    data: {
      id,
      btn_val,
    },
    url: baseurl + "PerizinanDinas/ApproveAll/editPekerjaDinas",
    beforeSend: (a) => {
      table.html('<tr><td colspan="4">loading....</td></tr>');
    },
    dataType: "json",
    success: function (data) {
      let keluar = "";
      if (btn_val == "1") {
        keluar = data[0]["berangkat"];
        $(".newText").text("Tujuan");
      } else {
        keluar = data[0]["wkt_keluar"];
        $(".newText").text("Keperluan");
      }

      $("#modal-id_dinasAll").val(
        btn_val == "1" ? data[0]["izin_id"] : data[0]["id"]
      );
      $("#modal-tgl_dinasAll").val(data[0]["created_date"]);
      $("#modal-keluar_dinasAll").val(function () {
        if (keluar == null) {
          return "-";
        } else if (keluar < "12:00:00") {
          return keluar + " AM";
        } else {
          return keluar + " PM";
        }
      });
      $("#modal-kep_dinasAll").val(
        btn_val == "1" ? data[0]["keterangan"] : data[0]["keperluan"]
      );
      $("#modal-AlasanAll").val("Atasan tidak berada ditempat");
      $("#modal-Atasan_dinasAll")
        .val(btn_val == "1" ? data[0]["atasan_aproval"] : data[0]["atasan"])
        .trigger("change");
      $("#app_edit_DinasAll").val(btn_val);
      $("#modal-approve-dinas-All").modal("show");

      let row;
      data.forEach((a) => {
        if (btn_val == "1") {
          keterangan = a.tujuan;
        } else {
          keterangan = a.keperluan;
        }
        row += `<tr>
                             <td>${a.noind}</td>
                             <td>${a.nama}</td>
                             <td>${keterangan == "" ? "-" : keterangan}</td>
                         </tr>`;
      });
      table.html(row);
    },
  });
}

//JS untuk Transposition Plotting Job
$(document).ready(function () {
  $("#tanggalBerlaku").datepicker({
    autoclose: true,
    autoApply: true,
    format: "dd MM yyyy",
  });

  $("#TPJ_noind").on("change", function () {
    let noind = $(this).val();
    let loading = "assets/img/gif/loadingquick.gif";

    $.ajax({
      type: "post",
      dataType: "json",
      data: {
        noind: noind,
      },
      beforeSend: function () {
        Swal.fire({
          html:
            "<img style='width: 200px; height: auto;'src='" + loading + "'>",
          text: "Loading...",
          customClass: "swal-wide",
          showConfirmButton: false,
          allowOutsideClick: false,
        });
      },
      url: baseurl + "TranspositionPlottingJob/change",
      success: function (data) {
        swal.close();
        // $(this).find('select').prop("selected", false)
        $("#TPJ_pkj_saat_ini").val(
          data[0]["kd_pkj"] + " - " + data[0]["pekerjaan"]
        );
        let isi_data = "<option></option>";
        for (var i = 0; i < data["kerja"].length; i++) {
          isi_data +=
            "<option value='" +
            data["kerja"][i]["kdpekerjaan"] +
            "'>" +
            data["kerja"][i]["kdpekerjaan"] +
            " - " +
            data["kerja"][i]["pekerjaan"] +
            "</option>";
        }
        $("#TPJ_pekerjaan").html(isi_data);
      },
    });
  });

  $("#TPJ_reload").on("click", function () {
    let loading = "assets/img/gif/loadingquick.gif";

    Swal.fire({
      html: "<img style='width: 200px; height: auto;'src='" + loading + "'>",
      text: "Loading...",
      customClass: "swal-wide",
      showConfirmButton: false,
      allowOutsideClick: false,
    });
    window.location.reload(function () {
      swal.close();
    });
  });

  $("#TPJ_save").on("click", function () {
    let noind = $("#TPJ_noind").val();
    let pkj_lm = $("#TPJ_pkj_saat_ini").val();
    let pkj_now = $("#TPJ_pekerjaan").val();
    let date = $("#tanggalBerlaku").val();
    let loading = "assets/img/gif/loadingquick.gif";

    if (noind == "" || pkj_lm == "" || pkj_now == "" || date == "") {
      swal.fire({
        title: "Peringatan",
        text: "Parameter Belum Lengkap",
        type: "warning",
        allowOutsideClick: false,
        showCancelButton: false,
      });
    } else {
      swal
        .fire({
          title: "Peringatan",
          text: "Apakah Anda Yakin Mau Mengubah Data Pekerjaan ?",
          type: "question",
          allowOutsideClick: false,
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
        })
        .then((result) => {
          if (result.value) {
            $.ajax({
              type: "post",
              data: {
                noind: noind,
                pkj_lm: pkj_lm,
                pkj_now: pkj_now,
                date: date,
              },
              url: baseurl + "TranspositionPlottingJob/save",
              beforeSend: function () {
                Swal.fire({
                  html:
                    "<img style='width: 200px; height: auto;'src='" +
                    loading +
                    "'>",
                  text: "Loading...",
                  customClass: "swal-wide",
                  showConfirmButton: false,
                  allowOutsideClick: false,
                });
              },
              success: function (data) {
                swal
                  .fire({
                    title: "Success",
                    text: "Berhasil Mengganti Data Sesuai Tanggal Berlaku",
                    type: "success",
                    allowOutsideClick: false,
                    showCancelButton: false,
                  })
                  .then((result) => {
                    Swal.fire({
                      html:
                        "<img style='width: 200px; height: auto;'src='" +
                        loading +
                        "'>",
                      text: "Loading...",
                      customClass: "swal-wide",
                      showConfirmButton: false,
                      allowOutsideClick: false,
                    });
                    window.location.reload();
                  });
              },
            });
          }
        });
    }
  });
});

$(document).ready(function () {
  $("#psg_tglCetak").datepicker({
    autoclose: true,
    autoApply: true,
    format: "yyyy-mm-dd",
    todayHighlight: true,
  });
  $("#pengalaman_tglCetak")
    .datepicker({
      autoclose: true,
      autoApply: true,
      format: "yyyy-mm-dd",
      todayHighlight: true,
    })
    .datepicker("setDate", new Date());
  $("#tblSuratResign").DataTable({
    scrollX: true,
  });
  $(".SuratResignTanggalResign").datepicker({
    autoclose: true,
    autoApply: true,
    format: "yyyy-mm-dd",
  });

  $(".SuratResignDiterimaHubker").datepicker({
    autoclose: true,
    autoApply: true,
    format: "yyyy-mm-dd",
  });

  $(".SuratResignPekerja").select2({
    searching: true,
    minimumInputLength: 3,
    placeholder: "No. Induk / Nama Pekerja",
    allowClear: false,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/SuratResign/pekerjaAktif",
      dataType: "json",
      delay: 500,
      type: "GET",
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.noind + " - " + obj.nama };
          }),
        };
      },
    },
  });

  $("#tbl_mpkSt").DataTable({
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excel",
        title: "",
        filename: "Daftar Seksi",
        exportOptions: {
          columns: [0, 1, 2, 3, 4],
        },
      },
    ],
  });

  $("#dataTable_ipoto").dataTable();

  $("#mpk_cek_file").change(function () {
    var noind = $(this).val();
    $.ajax({
      type: "POST",
      data: {
        noind: noind,
      },
      url: baseurl + "MasterPekerja/upload-photo/cekFileFoto",
      success: function (result) {
        if (result == "1") {
          $("#mpk_warn_rtxt").show();
          $("#mpk_warn_rbtxt").text("Replace");
        } else {
          $("#mpk_warn_rtxt").hide();
          $("#mpk_warn_rbtxt").text("Submit");
        }
      },
      error: function (result) {
        alert("Error Please Try Again !");
      },
    });
  });

  $("#dataTable_ipoto").on("click", ".mpkshowimg", function () {
    var va = $(this).attr("data");
    $.ajax({
      type: "POST",
      data: {
        dt: va,
      },
      url: baseurl + "MasterPekerja/upload-photo/getFileFoto",
      success: function (result) {
        Swal.fire({
          html:
            "<div style=\"background: url('" +
            result +
            "') no-repeat right center; background-size: contain; background-position: 50%; min-height: 420px;\"></div>",
        });
      },
      error: function (result) {
        alert("Error Please Try Again !");
      },
    });
  });
});

$(document).on("click", function (e) {
  $('#formSebaranGejalaPusat [data-toggle="popover"]').popover();
  $('#formSebaranGejalaTuksono [data-toggle="popover"]').popover();
});

$(document).on("ready", function () {
  let dt = new Date(),
    d = dt.getDate(),
    m = dt.getMonth(),
    y = dt.getFullYear();

  $("#tblPendataanTidakHadir").DataTable({
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excel",
        title: "Data Pendataan Tidak Hadir " + d + "-" + m + "-" + y,
      },
    ],
    scrollX: true,
  });

  $("#tblPendataanBelumInput").DataTable({
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excel",
        title: "Data Belum Input Pendataan " + d + "-" + m + "-" + y,
      },
    ],
    scrollX: true,
  });
});

// Poliklinik
$(document).ready(function () {
  $("#tblPoliklinik").DataTable({
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excel",
        title: "",
        filename: "Kunjungan Poliklinik",
      },
    ],
  });

  $("#txtPoliklinikTanggal").daterangepicker(
    {
      timePicker: true,
      timePicker24Hour: true,
      singleDatePicker: true,
      showDropdowns: true,
      autoApply: true,
      locale: {
        format: "YYYY-MM-DD HH:mm:ss",
        separator: " - ",
        applyLabel: "OK",
        cancelLabel: "Batal",
        fromLabel: "Dari",
        toLabel: "Hingga",
        customRangeLabel: "Custom",
        weekLabel: "W",
        daysOfWeek: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sa"],
        monthNames: [
          "Januari",
          "Februari",
          "Maret",
          "April",
          "Mei",
          "Juni",
          "Juli",
          "Agustus ",
          "September",
          "Oktober",
          "November",
          "Desember",
        ],
        firstDay: 1,
      },
    },
    function (start, end, label) {
      console.log(
        "New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')"
      );
    }
  );

  $("#slcPoliklinikPekerja").select2({
    searching: true,
    minimumInputLength: 3,
    placeholder: "No. Induk / Nama Pekerja",
    allowClear: false,
    ajax: {
      url: baseurl + "MasterPekerja/Poliklinik/getPekerja",
      dataType: "json",
      delay: 500,
      type: "GET",
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.noind + " - " + obj.nama };
          }),
        };
      },
    },
  });

  $("#slcPoliklinikKeterangan").select2({
    searching: true,
    placeholder: "Keterangan",
    allowClear: true,
    tags: true,
    tokenSeparators: [","],
    ajax: {
      url: baseurl + "MasterPekerja/Poliklinik/getKeterangan",
      dataType: "json",
      delay: 500,
      type: "GET",
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.keterangan, text: obj.keterangan };
          }),
        };
      },
    },
  });

  $("#areaRekapIzin").on("click", ".btnDeldinas", function () {
    var id = $(this).attr("id");
    var ini = $(this);
    Swal.fire({
      title: 'Apa Anda yakin akan menghapus izin "' + id + '" ?',
      allowOutsideClick: true,
      allowEscapeKey: true,
      type: "question",
      showCancelButton: true,
    }).then(function (result) {
      if (result.value) {
        $(this).attr("disabled", true);
        $.ajax({
          type: "GET",
          url: baseurl + "PD/RekapPerizinanDinas/hapusini/" + id,
          data: { test: 12 },
          success: function (response) {
            $("#PD_Cari").click();
            mpk_showAlert("success", "Data Berhasil di Hapus !");
          },
        });
      }
    });
  });
});

function mpk_showAlert(icon, title) {
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.stopTimer);
      toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
  });

  Toast.fire({
    icon: icon,
    title: title,
  });
}

window.addEventListener("load", function () {
  if ($("#PD_Cari").get(0)) {
    $('input[name="PerSurat"]').eq(0).iCheck("check");
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();

    today = dd + "/" + mm + "/" + yyyy;
    $("#periodeRekap").val(today + " - " + today);
    $("#PD_Cari").trigger("click");
  }
  if ($("#RPP_Cari").get(0)) {
    $('input[name="PerSurat"]').eq(0).iCheck("check");
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();

    today = dd + "/" + mm + "/" + yyyy;
    $("#periodeRekap").val(today + " - " + today);
    $("#RPP_Cari").trigger("click");
  }
  if ($("#RPP_Saran").get(0)) {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();

    today = dd + "/" + mm + "/" + yyyy;
    $("#periodeRekap").val(today + " - " + today);
    $("#RPP_Saran").trigger("click");
  }
});

// Surat Tugas Start
$(document).ready(function () {
  $("#tblMPSuratTugasIndex").DataTable();
  $("#txaMPSuratTugasRedactor").redactor({
    buttonsHide: ["image"],
  });
  $("#txtMPSuratTugasTanggal").datepicker({
    autoclose: true,
    todayHiglight: true,
    format: "yyyy-mm-dd",
  });
  $(".slcMPSuratTugasPekerja").select2({
    searching: true,
    minimumInputLength: 3,
    placeholder: "No. Induk / Nama Pekerja",
    allowClear: false,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/SuratTugas/Pekerja",
      dataType: "json",
      delay: 500,
      type: "GET",
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.noind + " - " + obj.nama };
          }),
        };
      },
    },
  });

  $("#slcMPSuratTugasPekerja").on("change", function () {
    noind = $(this).val();
    $.ajax({
      data: { noind: noind },
      type: "GET",
      url: baseurl + "MasterPekerja/Surat/SuratTugas/Detail",
      error: function (xhr, status, error) {
        console.log(xhr);
        console.log(status);
        console.log(error);
        swal.fire({
          title: xhr["status"] + "(" + xhr["statusText"] + ")",
          html: xhr["responseText"],
          type: "error",
          confirmButtonText: "OK",
          confirmButtonColor: "#d63031",
        });
      },
      success: function (result) {
        obj = JSON.parse(result);
        $("#txaMPSuratTugasRedactor").redactor("set", "");
        $("#txtMPSuratTugasNomor").val(obj["nomor_surat"]);
        $("#txtMPSuratTugasNomor").prop("disabled", false);
        $("#slcMPSuratTugasApprover").prop("disabled", false);
        $("#txtMPSuratTugasTanggal").prop("disabled", false);
      },
    });
  });

  $("#txtMPSuratTugasNomor").on("change", function () {
    unlockPreview();
  });

  $("#slcMPSuratTugasApprover").on("change", function () {
    unlockPreview();
  });

  $("#txtMPSuratTugasTanggal").on("change", function () {
    unlockPreview();
  });

  $("#btnMPSuratTugasPreview").on("click", function () {
    noind = $("#slcMPSuratTugasPekerja").val();
    nomorSurat = $("#txtMPSuratTugasNomor").val();
    approver = $("#slcMPSuratTugasApprover").val();
    tanggal = $("#txtMPSuratTugasTanggal").val();
    $.ajax({
      data: {
        noind: noind,
        nomor: nomorSurat,
        approver: approver,
        tanggal: tanggal,
      },
      type: "GET",
      url: baseurl + "MasterPekerja/Surat/SuratTugas/Preview",
      error: function (xhr, status, error) {
        console.log(xhr);
        console.log(status);
        console.log(error);
        swal.fire({
          title: xhr["status"] + "(" + xhr["statusText"] + ")",
          html: xhr["responseText"],
          type: "error",
          confirmButtonText: "OK",
          confirmButtonColor: "#d63031",
        });
      },
      success: function (result) {
        obj = JSON.parse(result);
        $("#txaMPSuratTugasRedactor").redactor("set", obj["surat"]);
        $("#txtMPSuratTugasSurat").val(obj["surat"]);
        $("#btnMPSuratTugasSubmit").prop("disabled", false);
      },
    });
  });

  $("#txaMPSuratTugasRedactor").on("change", function () {
    isi_surat = $("#txaMPSuratTugasRedactor").val();
    $("#txtMPSuratTugasSurat").val(isi_surat);
  });
});

function unlockPreview() {
  nomorSurat = $("#txtMPSuratTugasNomor").val();
  approver = $("#slcMPSuratTugasApprover").val();
  tanggal = $("#txtMPSuratTugasTanggal").val();

  if (nomorSurat && approver && tanggal) {
    $("#btnMPSuratTugasPreview").prop("disabled", false);
    $("#txtMPSuratTugasSurat").val("");
    $("#txaMPSuratTugasRedactor").redactor("set", "");
    $("#btnMPSuratTugasSubmit").prop("disabled", true);
  } else {
    $("#btnMPSuratTugasPreview").prop("disabled", true);
    $("#txaMPSuratTugasRedactor").redactor("set", "");
    $("#txtMPSuratTugasSurat").val("");
    $("#btnMPSuratTugasSubmit").prop("disabled", true);
  }
}
// Surat Tugas End

// Surat Isolasi Mandiri Start

$(document).ready(function () {
  $("#tblMPSuratIsolasiMandiriIndex").DataTable({
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
      url: baseurl + "MasterPekerja/Surat/SuratIsolasiMandiri/ListPekerja",
      type: "post",
    },
    columnDefs: [
      {
        targets: [0],
        // "orderable":false,
        className: "text-center",
      },
      {
        targets: [1],
        // "orderable":false,
        className: "text-center",
      },
      {
        targets: [4],
        // "orderable":false,
        className: "text-center",
      },
      {
        targets: [5],
        // "orderable":false,
        className: "text-center",
      },
    ],
  });

  $("#txaMPSuratIsolasiMandiriRedactor").redactor({
    buttonsHide: ["image"],
  });

  $(".txtMPSuratIsolasiMandiriTanggal").datepicker({
    autoclose: true,
    todayHiglight: true,
    format: "yyyy-mm-dd",
  });

  $(".slcMPSuratIsolasiMandiriPekerja").select2({
    searching: true,
    minimumInputLength: 3,
    placeholder: "No. Induk / Nama Pekerja",
    allowClear: false,
    ajax: {
      url: baseurl + "MasterPekerja/Surat/SuratIsolasiMandiri/Pekerja",
      dataType: "json",
      delay: 500,
      type: "GET",
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.noind + " - " + obj.nama };
          }),
        };
      },
    },
  });

  $(
    "#txtMPSuratIsolasiMandiriNoSurat, #slcMPSuratIsolasiMandiriTo, #slcMPSuratIsolasiMandiriPekerja, #txtMPSuratIsolasiMandiriSurat, #txtMPSuratIsolasiMandiriCetakTanggal, #txtMPSuratIsolasiMandiriWawancaraTanggal, #txtMPSuratIsolasiMandiriMulaiIsolasiTanggal, #txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal, #txtMPSuratIsolasiMandiriJumlahHari, #slcMPSuratIsolasiMandiriStatus, #slcMPSuratIsolasiMandiriDibuat, #slcMPSuratIsolasiMandirimenyetujui, #slcMPSuratIsolasiMandiriMengetahui"
  ).on("change", function () {
    var simTo = $("#slcMPSuratIsolasiMandiriTo").val();
    var simPekerja = $("#slcMPSuratIsolasiMandiriPekerja").val();
    var simWawancara = $("#txtMPSuratIsolasiMandiriWawancaraTanggal").val();
    var simMulai = $("#txtMPSuratIsolasiMandiriMulaiIsolasiTanggal").val();
    var simSelesai = $("#txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal").val();
    var simHari = $("#txtMPSuratIsolasiMandiriJumlahHari").val();
    var simStatus = $("#slcMPSuratIsolasiMandiriStatus").val();
    var simDibuat = $("#slcMPSuratIsolasiMandiriDibuat").val();
    var simMenyetujui = $("#slcMPSuratIsolasiMandirimenyetujui").val();
    var simMengetahui = $("#slcMPSuratIsolasiMandiriMengetahui").val();
    var simCetak = $("#txtMPSuratIsolasiMandiriCetakTanggal").val();
    var simNo = $("#txtMPSuratIsolasiMandiriNoSurat").val();

    if (
      simTo &&
      simPekerja &&
      simWawancara &&
      simMulai &&
      simSelesai &&
      simHari &&
      simStatus &&
      simDibuat &&
      simMenyetujui &&
      simMengetahui &&
      simCetak &&
      simNo
    ) {
      $("#btnMPSuratIsolasiMandiriPreview").attr("disabled", false);
    } else {
      $("#btnMPSuratIsolasiMandiriPreview").attr("disabled", true);
      $("#btnMPSuratIsolasiMandiriSubmit").prop("disabled", true);
    }
  });

  $(
    "#txtMPSuratIsolasiMandiriMulaiIsolasiTanggal, #txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal"
  ).on("change", function () {
    mulai = $("#txtMPSuratIsolasiMandiriMulaiIsolasiTanggal").val();
    selesai = $("#txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal").val();

    if (mulai && selesai) {
      tgl_mulai = new Date(mulai + " 00:00:00");
      tgl_selesai = new Date(selesai + " 23:59:59");
      difftime = Math.abs(tgl_mulai - tgl_selesai);
      diffday = Math.ceil(difftime / (1000 * 60 * 60 * 24));

      $("#txtMPSuratIsolasiMandiriJumlahHari").val(diffday);
    } else {
      $("#txtMPSuratIsolasiMandiriJumlahHari").val("0");
    }
  });

  $("#btnMPSuratIsolasiMandiriPreview").on("click", function () {
    var simTo = $("#slcMPSuratIsolasiMandiriTo").val();
    var simPekerja = $("#slcMPSuratIsolasiMandiriPekerja").val();
    var simWawancara = $("#txtMPSuratIsolasiMandiriWawancaraTanggal").val();
    var simMulai = $("#txtMPSuratIsolasiMandiriMulaiIsolasiTanggal").val();
    var simSelesai = $("#txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal").val();
    var simHari = $("#txtMPSuratIsolasiMandiriJumlahHari").val();
    var simStatus = $("#slcMPSuratIsolasiMandiriStatus").val();
    var simDibuat = $("#slcMPSuratIsolasiMandiriDibuat").val();
    var simMenyetujui = $("#slcMPSuratIsolasiMandirimenyetujui").val();
    var simMengetahui = $("#slcMPSuratIsolasiMandiriMengetahui").val();
    var simCetak = $("#txtMPSuratIsolasiMandiriCetakTanggal").val();
    var simNo = $("#txtMPSuratIsolasiMandiriNoSurat").val();

    $.ajax({
      data: {
        simTo: simTo,
        simPekerja: simPekerja,
        simWawancara: simWawancara,
        simMulai: simMulai,
        simSelesai: simSelesai,
        simHari: simHari,
        simStatus: simStatus,
        simDibuat: simDibuat,
        simMenyetujui: simMenyetujui,
        simMengetahui: simMengetahui,
        simCetak: simCetak,
        simNo: simNo,
      },
      type: "GET",
      url: baseurl + "MasterPekerja/Surat/SuratIsolasiMandiri/Preview",
      error: function (xhr, status, error) {
        console.log(xhr);
        console.log(status);
        console.log(error);
        swal.fire({
          title: xhr["status"] + "(" + xhr["statusText"] + ")",
          html: xhr["responseText"],
          type: "error",
          confirmButtonText: "OK",
          confirmButtonColor: "#d63031",
        });
      },
      success: function (result) {
        obj = JSON.parse(result);
        console.log(obj);
        $("#txaMPSuratIsolasiMandiriRedactor").redactor("set", obj["surat"]);
        $("#txtMPSuratIsolasiMandiriSurat").val(obj["surat"]);
        $("#btnMPSuratIsolasiMandiriSubmit").prop("disabled", false);
      },
    });
  });
});

// Surat Isolasi Mandiri End
//rekap kecelakaan kerja
$(document).ready(function () {
  var tabel = $("#mpk_tblRKK").DataTable();
  $("#mpk_rkpr").daterangepicker({
    singleDatePicker: false,
    timePicker: false,
    timePicker24Hour: true,
    showDropdowns: false,
    locale: {
      format: "YYYY-MM-DD",
    },
  });

  $(".mpk_rknopr").daterangepicker({
    singleDatePicker: true,
    timePicker: false,
    timePicker24Hour: true,
    showDropdowns: false,
    locale: {
      format: "YYYY-MM-DD",
    },
  });

  $(".mpk_slcpkj").select2({
    minimumInputLength: 2,
    placeholder: "Pilih Pekerja",
  });
  $(".mpk_slcpkjcas").select2({
    placeholder: "Pilih Salah Satu",
  });

  $(".mpk_slcpkj").change(function () {
    var val = $(this).val();
    var ini = $(this);
    $.ajax({
      type: "get",
      data: {
        term: val,
      },
      url: baseurl + "MasterPekerja/rekap/kecelakaan_kerja/get_detailpkjrk",
      success: function (data) {
        var obj = JSON.parse(data);
        ini.closest("div").find(".diz").eq(0).val(obj[0]["dept"]);
        ini.closest("div").find(".diz").eq(1).val(obj[0]["seksi"]);
      },
    });
  });

  $("#mpk_btnshwtbl").click(function () {
    var pr = $("#mpk_rkpr").val();
    $.ajax({
      type: "get",
      data: {
        periode: pr,
      },
      url: baseurl + "MasterPekerja/rekap/kecelakaan_kerja/rk_getKecelakaan",
      success: function (result) {
        $("#mpk_rkdivtbl").html(result);
        var tabel = $("#mpk_tblRKK").DataTable({
          dom: "Bfrtip",
          buttons: [
            {
              extend: "excelHtml5",
              messageTop: "",
              title: "",
              filename: "Rekap Kecelakaan kerja",
              exportOptions: {
                columns: ":visible",
              },
            },
            // {
            //     extend: 'pdfHtml5',
            //     messageTop:'',
            //     title:'',
            //     filename:'Rekap Kecelakaan kerja',
            //     orientation: 'landscape',
            //     exportOptions: {
            //         columns: ':visible'
            //     }
            // },
            "colvis",
          ],
          scrollX: false,
          fixedColumns: {
            leftColumns: 0,
          },
        });
      },
    });
  });

  $("#mpk_btnsbfrm").click(function () {
    var verif = true;
    $("#mpk_mdladdrk")
      .find("input")
      .each(function () {
        if ($(this).val().length == 0) {
          verif = false;
        }
      });
    $("#mpk_mdladdrk")
      .find("select")
      .each(function () {
        if ($(this).val().length == 0) {
          verif = false;
        }
      });
    if (verif == false) {
      alert("Harap Isi Semua Data!");
    } else {
      $.ajax({
        type: "post",
        data: $("#mpk_frmrkc").serialize(),
        url: baseurl + "MasterPekerja/rekap/kecelakaan_kerja/rk_addata",
        success: function (result) {
          var obj = JSON.parse(result);
          if (obj.status == "sukses") {
            $(".mpk_slcpkj").each(function () {
              $(this).select2("destroy").val("").select2({
                minimumInputLength: 2,
                placeholder: "Pilih Pekerja",
              });
            });
            $("#mpk_mdladdrk")
              .find("input")
              .each(function () {
                $(this).val("").trigger("change");
              });
            $("#mpk_mdladdrk").modal("hide");
            mpk_showAlert("success", "Berhasil Menambah Data");
          } else {
            alert("Input Gagal!");
          }
          $("#mpk_btnshwtbl").click();
        },
      });
    }
  });

  $("#mpk_rkdivtbl").on("click", ".mpk_btndelrk", function () {
    var noind = $(this).closest("tr").find("td").eq(2).text();
    var nama = $(this).closest("tr").find("td").eq(3).text();
    var id = $(this).val();
    swal
      .fire({
        title: "Anda yakin?",
        text: "Hapus Data " + noind + " - " + nama,
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "OK",
        allowOutsideClick: false,
      })
      .then((result) => {
        if (result.value) {
          mpk_delrkkc(id);
        }
      });
  });
  $("#mpk_rkdivtbl").on("click", ".mpk_btnuprk", function () {
    var id = $(this).val();
    $.ajax({
      type: "get",
      data: {
        id: id,
      },
      url: baseurl + "MasterPekerja/rekap/kecelakaan_kerja/getrkk_data",
      success: function (result) {
        var obj = JSON.parse(result);
        var ob = obj[0];
        console.log(ob["noind"] + " - " + ob["nama"].trim());
        $("#mpk_mdluprk .mpk_slcpkj")
          .val(ob["noind"] + " - " + ob["nama"].trim())
          .trigger("change");
        $("#mpk_mdluprk .mpk_slcpkj").attr("disabled", true);
        $("#mpk_mdluprk .mpk_rknopr").val(ob["tanggal"].substr(0, 10));
        $("#mpk_mdluprk .mpk_slcpkjcas")
          .val(ob["keterangan"])
          .trigger("change");
        $("#mpk_mdluprk .mpkinf").eq(0).val(ob["kondisi"]);
        $("#mpk_mdluprk .mpkinf").eq(1).val(ob["penyebab"]);
        $("#mpk_mdluprk .mpkinf").eq(2).val(ob["tindakan"]);
        $("#mpk_mdluprk #mpk_idrkk").val(ob["id_rkk"]);
        $("#mpk_mdluprk").modal("show");
      },
    });
  });

  $("#mpk_btnupfrm").click(function () {
    var verif = true;
    $("#mpk_mdluprk")
      .find("input")
      .each(function () {
        if ($(this).val().length == 0) {
          verif = false;
        }
      });
    $("#mpk_mdluprk")
      .find("select")
      .each(function () {
        if ($(this).val().length == 0) {
          verif = false;
        }
      });
    if (verif == false) {
      alert("Harap Isi Semua Data!");
    } else {
      $.ajax({
        type: "post",
        data: $("#mpk_frmrkcup").serialize(),
        url: baseurl + "MasterPekerja/rekap/kecelakaan_kerja/up_rkkdata",
        success: function (result) {
          var obj = JSON.parse(result);
          if (obj.status == "sukses") {
            $("#mpk_mdluprk").modal("hide");
            mpk_showAlert("success", "Berhasil Mengupdate Data");
          } else {
            alert("Gagal!");
          }
          $("#mpk_btnshwtbl").click();
        },
      });
    }
  });
});

function mpk_delrkkc(id) {
  $.ajax({
    type: "post",
    data: {
      id: id,
    },
    url: baseurl + "MasterPekerja/rekap/kecelakaan_kerja/del_rkkdata",
    success: function (result) {
      var obj = JSON.parse(result);
      if (obj.status == "sukses") {
        mpk_showAlert("success", "Berhasil Menghapus Data");
      } else {
        alert("Gagal!");
      }
      $("#mpk_btnshwtbl").click();
    },
  });
}

function loadingOnAjax(elemen) {
  $(document).ajaxStart(function () {
    $(elemen).show();
  });
  $(document).ajaxComplete(function () {
    $(elemen).hide();
  });
}

//daftar pekerja aktif
$(document).ready(function () {
  $(".mpk_dpatgl").daterangepicker({
    singleDatePicker: true,
    timePicker: false,
    timePicker24Hour: true,
    showDropdowns: false,
    locale: {
      format: "YYYY-MM-DD",
    },
  });

  $(".mpk_dpaslc").select2();
  $("#mpk_btnsrcdpa").click(function () {
    fakeLoading(0);
    $.ajax({
      type: "get",
      data: $("#mpk_dpadivfom").serialize(),
      url: baseurl + "MasterPekerja/DataPekerjaAktif/get_datapekerjaaktif",
      success: function (result) {
        var obj = JSON.parse(result);
        $("#mpk_dpadivtbl").html(obj.table);
        $("#mpk_dpadivtbl td").each(function () {
          if ($(this).text() == "0") {
            $(this).text("-");
          }
        });
        $("#mpk_tbldpa").DataTable({
          dom: "Bfrtip",
          buttons: [
            {
              extend: "excelHtml5",
              messageTop: "   ",
              title:
                "Data Jumlah Pekerja Aktif Per Tanggal " +
                obj.tanggal +
                " (" +
                obj.lokasi +
                ")",
              filename: "Data Pekerja Aktif",
              exportOptions: {
                columns: ":visible",
              },
            },
            {
              extend: "pdfHtml5",
              messageTop: "   ",
              title:
                "Data Jumlah Pekerja Aktif Per Tanggal " +
                obj.tanggal +
                " (" +
                obj.lokasi +
                ")",
              filename: "Data Pekerja Aktif",
              exportOptions: {
                columns: ":visible",
              },
              customize: function (doc) {
                doc.defaultStyle.fontSize = 8;
                doc.styles.tableHeader.fontSize = 8;
                doc.pageMargins = [10, 10, 10, 10];
                var rowCount = doc.content[2].table.body.length;
                for (i = 1; i < rowCount; i++) {
                  doc.content[2].table.body[i][0].alignment = "center";
                  doc.content[2].table.body[i][1].alignment = "left";
                  doc.content[2].table.body[i][2].alignment = "center";
                  doc.content[2].table.body[i][3].alignment = "center";
                  doc.content[2].table.body[i][4].alignment = "center";
                  doc.content[2].table.body[i][5].alignment = "center";
                  doc.content[2].table.body[i][6].alignment = "center";
                  doc.content[2].table.body[i][7].alignment = "center";
                  doc.content[2].table.body[i][8].alignment = "center";
                  doc.content[2].table.body[i][9].alignment = "center";
                  doc.content[2].table.body[i][10].alignment = "center";
                  doc.content[2].table.body[i][11].alignment = "center";
                  doc.content[2].table.body[i][12].alignment = "center";
                  doc.content[2].table.body[i][13].alignment = "center";
                  doc.content[2].table.body[i][14].alignment = "center";
                  doc.content[2].table.body[i][15].alignment = "center";
                  if (doc.content[2].table.body[i][0].text != "") {
                    doc.content[2].table.body[i][1].bold = true;
                  }
                }
              },
            },
            "colvis",
          ],
          fixedHeader: true,
          scrollX: false,
          columns: [
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false },
          ],
          order: [],
          paging: false,
        });
        fakeLoading(1);
      },
    });
  });
});
//disnaker
$(document).ready(function () {
  // $(document).on('click','#mpk_btndisnAK', function(){
  //     window.open(baseurl+'MasterPekerja/disnaker/export_pkjaktif');
  // });
  // $(document).on('click','#mpk_btndisnRE', function(){
  //     window.open(baseurl+'MasterPekerja/disnaker/export_pkjresign');
  // });

  $(".mpk_btnajxdisn").click(function () {
    var va = $(this).val();
    var tgl = $(".mpk_rknopr").val();
    var pr = $("#mpk_mntpicker").val();
    var lokasi = $(".mpk_dpaslc").val();
    var x = 0;
    if (typeof tgl !== "undefined") {
      x += tgl.length;
    }
    if (typeof pr !== "undefined") {
      x += pr.length;
    }
    if (x < 6) {
      console.log("kosong");
      return false;
    }
    fakeLoading(0);
    $.ajax({
      type: "get",
      data: {
        type: va,
        tanggal: tgl,
        periode: pr,
        lokasi: lokasi,
      },
      url: baseurl + "MasterPekerja/disnaker/ajx_tbldisnaker",
      success: function (result) {
        $("#tbl_divdishidd").show();
        $("#mpk_divftbldis").html(result);
        $("#mpk_tbldisnker").DataTable({
          scrollX: true,
          fixedColumns: {
            leftColumns: 2,
          },
        });
      },
      complete: function (result) {
        fakeLoading(1);
      },
    });
  });

  $("#mpk_mntpicker").monthpicker({
    changeYear: true,
    dateFormat: "yy-mm",
  });
});

// sim forklift start
$(document).ready(function () {
  var tblMPKSimForkliftList = $("#tblMPKSimForkliftList").dataTable({
    lengthMenu: [
      [5, 10, 25, 50, -1],
      ["5 rows", "10 rows", "25 rows", "50 rows", "Show all"],
    ],
    dom: "Bfrtip",
    buttons: ["copy", "csv", "excel", "pdf", "print", "pageLength"],
  });

  $(".slcMPKSimForkliftCariPekerja").select2({
    placeholder: "Cari Pekerja",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MasterPekerja/SimForklift/cariPekerja",
      dataType: "json",
      delay: 500,
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return { id: obj.noind, text: obj.noind + " - " + obj.nama };
          }),
        };
      },
    },
  });

  $("#btnMPKSimForkliftTambahPekerja").on("click", function () {
    var pekerja = $(".slcMPKSimForkliftCariPekerja").val();
    if (pekerja) {
      $("#tblMPKSimForkliftTambahPekerja tbody").html("");
      for (var i = 0; i < pekerja.length; i++) {
        var month = [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December",
        ];
        var cur_date = new Date();
        var date_a = month[cur_date.getMonth()] + " " + cur_date.getFullYear();
        cur_date.setFullYear(cur_date.getFullYear() + 5);
        var date_b = month[cur_date.getMonth()] + " " + cur_date.getFullYear();
        $("#ldgMPKSimForkliftTambahLoading").show();
        $.ajax({
          method: "GET",
          url: baseurl + "MasterPekerja/SimForklift/cariPekerja/" + pekerja[i],
          error: function (xhr, status, error) {
            $("#ldgMPKSimForkliftTambahLoading").hide();
            swal.fire({
              title: xhr["status"] + "(" + xhr["statusText"] + ")",
              html: xhr["responseText"],
              type: "error",
              confirmButtonText: "OK",
              confirmButtonColor: "#d63031",
            });
          },
          success: function (data) {
            var obj = JSON.parse(data);
            var tr = "<tr>";
            tr +=
              '<td><input type="text" class="form-control" value="' +
              obj.noind +
              '" disabled></td>';
            tr +=
              '<td><input type="text" class="form-control" value="' +
              obj.nama +
              '"></td>';
            tr +=
              '<td><input type="text" class="form-control" value="' +
              obj.seksi +
              '"></td>';
            tr +=
              '<td><select class="slcMPKSimForkliftGantiJenis" style="width: 100%"><option>Utama</option><option>Cadangan</option></select></td>';
            tr +=
              '<td><input type="text" class="form-control txtMPKSimForkliftMulaiBerlaku" value="' +
              date_a +
              '"></td>';
            tr +=
              '<td><input type="text" class="form-control txtMPKSimForkliftAkhirBerlaku" value="' +
              date_b +
              '"></td>';
            tr += '<td class="text-center">';
            tr +=
              '<button type="button" class="btn btn-danger btnMPKSimForkliftHapusPekerja" title="Hapus"><span class="fa fa-trash"></span></button>';
            tr +=
              '<img class="imgMPKSimForkliftSimpanPekerja" src="' +
              baseurl +
              "assets/img/gif/spinner.gif" +
              '" style="display: none;"/>';
            tr +=
              '<span class="fa fa-check fa-2x spnMPKSimForkliftSimpanPekerjaSukses" style="display: none;color: green;"></span>';
            tr +=
              '<span class="fa fa-times fa-2x spnMPKSimForkliftSimpanPekerjaGagal" style="display: none;color: red;"></span></td>';
            tr += "</tr>";
            $("#tblMPKSimForkliftTambahPekerja tbody").append(tr);

            $("#tblMPKSimForkliftTambahPekerja .slcMPKSimForkliftGantiJenis").last().select2();

            $("#tblMPKSimForkliftTambahPekerja .txtMPKSimForkliftMulaiBerlaku").last().datepicker({
              autoclose: true,
              todayHiglight: true,
              format: "MM yyyy",
              viewMode: "months",
              minViewMode: "months",
            });

            $("#tblMPKSimForkliftTambahPekerja .txtMPKSimForkliftAkhirBerlaku").last().datepicker({
              autoclose: true,
              todayHiglight: true,
              format: "MM yyyy",
              viewMode: "months",
              minViewMode: "months",
            });
            $("#ldgMPKSimForkliftTambahLoading").hide();
          },
        });
      }
      $(".slcMPKSimForkliftCariPekerja").val("").trigger("change");
      $("#btnMPKSimForkliftSimpanPekerja").show();
    } else {
      Swal.fire(
        "Peringatan !!!",
        "Pastikan Data Pekerja Sudah Terisi",
        "warning"
      );
    }
  });

  $("#tblMPKSimForkliftTambahPekerja").on("click", ".btnMPKSimForkliftHapusPekerja", function () {
    $(this).closest("tr").remove();
  });

  $("#btnMPKSimForkliftSimpanPekerja").on("click", function () {
    var tr_all = $("#tblMPKSimForkliftTambahPekerja tbody tr");
    if (tr_all && tr_all.length > 0) {
      $("#ldgMPKSimForkliftTambahLoading").show();
      $("#tblMPKSimForkliftTambahPekerja").find(".btnMPKSimForkliftHapusPekerja").hide();
      $("#tblMPKSimForkliftTambahPekerja").find(".spnMPKSimForkliftSimpanPekerjaSukses").hide();
      $("#tblMPKSimForkliftTambahPekerja").find(".spnMPKSimForkliftSimpanPekerjaGagal").hide();
      $("#tblMPKSimForkliftTambahPekerja").find(".imgMPKSimForkliftSimpanPekerja").show();
      $("#btnMPKSimForkliftSimpanPekerja").hide();
      $("#tblMPKSimForkliftTambahPekerja").find("input").attr("disabled", "disabled");
      $("#tblMPKSimForkliftTambahPekerja").find("select").attr("disabled", "disabled");
      var diproses = 0;
      $("#tblMPKSimForkliftTambahPekerja tbody tr").each(function (index, element) {
        var noind = $(this).find("td:nth(0) input").val();
        var nama = $(this).find("td:nth(1) input").val();
        var seksi = $(this).find("td:nth(2) input").val();
        var jenis = $(this).find("td:nth(3) select").val();
        var awal = $(this).find("td:nth(4) input").val();
        var akhir = $(this).find("td:nth(5) input").val();
        var row = $(this);
        $.ajax({
          method: "POST",
          url: baseurl + "MasterPekerja/SimForklift/simpan",
          data: {
            noind: noind,
            nama: nama,
            seksi: seksi,
            jenis: jenis,
            awal: awal,
            akhir: akhir,
          },
          error: function (xhr, status, error) {
            diproses++;
            if (diproses >= tr_all.length) {
              $("#ldgMPKSimForkliftTambahLoading").hide();
            }
            row.find(".imgMPKSimForkliftSimpanPekerja").hide();
            row.find(".spnMPKSimForkliftSimpanPekerjaGagal").show();
            swal.fire({
              title: xhr["status"] + "(" + xhr["statusText"] + ")",
              html: xhr["responseText"],
              type: "error",
              confirmButtonText: "OK",
              confirmButtonColor: "#d63031",
            });
          },
          success: function (data) {
            diproses++;
            if (diproses >= tr_all.length) {
              $("#ldgMPKSimForkliftTambahLoading").hide();
            }
            $('.slcMPKSimForkliftCariPekerja').val("").trigger('change');
            $('#btnMPKSimForkliftSimpanPekerja').show();
          }
        })
      })
    } else {
      Swal.fire(
        'Peringatan !!!',
        'Pastikan Data Pekerja Sudah Terisi',
        'warning'
      )
    }
  })

  $('#tblMPKSimForkliftTambahPekerja').on('click', '.btnMPKSimForkliftHapusPekerja', function () {
    $(this).closest('tr').remove();
  })

  $('#btnMPKSimForkliftSimpanPekerja').on('click', function () {
    var tr_all = $('#tblMPKSimForkliftTambahPekerja tbody tr');
    if (tr_all && tr_all.length > 0) {
      $('#ldgMPKSimForkliftTambahLoading').show();
      $('#tblMPKSimForkliftTambahPekerja').find('.btnMPKSimForkliftHapusPekerja').hide();
      $('#tblMPKSimForkliftTambahPekerja').find('.spnMPKSimForkliftSimpanPekerjaSukses').hide();
      $('#tblMPKSimForkliftTambahPekerja').find('.spnMPKSimForkliftSimpanPekerjaGagal').hide();
      $('#tblMPKSimForkliftTambahPekerja').find('.imgMPKSimForkliftSimpanPekerja').show();
      $('#btnMPKSimForkliftSimpanPekerja').hide();
      $('#tblMPKSimForkliftTambahPekerja').find('input').attr("disabled", "disabled");
      $('#tblMPKSimForkliftTambahPekerja').find('select').attr("disabled", "disabled");
      var diproses = 0;
      $('#tblMPKSimForkliftTambahPekerja tbody tr').each(function (index, element) {
        var noind = $(this).find('td:nth(0) input').val();
        var nama = $(this).find('td:nth(1) input').val();
        var seksi = $(this).find('td:nth(2) input').val();
        var jenis = $(this).find('td:nth(3) select').val();
        var awal = $(this).find('td:nth(4) input').val();
        var akhir = $(this).find('td:nth(5) input').val();
        var row = $(this);
        $.ajax({
          method: 'POST',
          url: baseurl + 'MasterPekerja/SimForklift/simpan',
          data: { noind: noind, nama: nama, seksi: seksi, jenis: jenis, awal: awal, akhir: akhir },
          error: function (xhr, status, error) {
            diproses++;
            if (diproses >= tr_all.length) {
              $('#ldgMPKSimForkliftTambahLoading').hide();
            }
            row.find('.imgMPKSimForkliftSimpanPekerja').hide();
            row.find('.spnMPKSimForkliftSimpanPekerjaGagal').show();
            swal.fire({
              title: xhr['status'] + "(" + xhr['statusText'] + ")",
              html: xhr['responseText'],
              type: "error",
              confirmButtonText: 'OK',
              confirmButtonColor: '#d63031',
            })
          },
          success: function (data) {
            diproses++;
            if (diproses >= tr_all.length) {
              $('#ldgMPKSimForkliftTambahLoading').hide();
            }
            row.find('.imgMPKSimForkliftSimpanPekerja').hide();
            if (data == "sukses") {
              row.find('.spnMPKSimForkliftSimpanPekerjaSukses').show();
            } else {
              row.find('.spnMPKSimForkliftSimpanPekerjaGagal').show();
              swal.fire({
                title: "ERROR",
                html: data,
                type: "error",
                confirmButtonText: 'OK',
                confirmButtonColor: '#d63031',
              })
            }
          }
        })
      })
    } else {
      Swal.fire(
        'Peringatan !!!',
        'Pastikan Sudah Ada Data Pekerja Di Tabel',
        'warning'
      )
    }
  })

  $(document).on('ifChecked', '#chkMPKSimForkliftCheckAll', function () {
    var table_data = tblMPKSimForkliftList.fnGetNodes();
    $('.chkMPKSimForkliftCheckOne', table_data).iCheck('check');
    checkSimForkliftChecked(tblMPKSimForkliftList);
  })

  $(document).on('ifUnchecked', '#chkMPKSimForkliftCheckAll', function () {
    var table_data = tblMPKSimForkliftList.fnGetNodes();
    $('.chkMPKSimForkliftCheckOne', table_data).iCheck('uncheck');
    checkSimForkliftChecked(tblMPKSimForkliftList);
  })

  $(document).on('ifChecked', '.chkMPKSimForkliftCheckOne', function () {
    checkSimForkliftChecked(tblMPKSimForkliftList);
  })

  $(document).on('ifUnchecked', '.chkMPKSimForkliftCheckOne', function () {
    checkSimForkliftChecked(tblMPKSimForkliftList);
  })

  $('#btnSimForkliftCetakPdf, #btnSimForkliftCetakImg, #btnSimForkliftCetakCrl').on('click', function () {
    if (!($(this).attr('disabled'))) {
      window.open($(this).attr('href'), '_blank');
    }
  })

  $('#tblMPKSimForkliftList').on('click', '.btnMPKSimForkliftHapus', function () {
    var id_sim = $(this).attr('data-id');
    Swal.fire({
      title: 'Hapus Data ?',
      text: "Apakah Anda Yakin Ingin Menghapus Data ini ?",
      type: 'success',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          method: 'POST',
          url: baseurl + 'MasterPekerja/SimForklift/Hapus',
          data: { id_sim: id_sim },
          error: function (xhr, status, error) {
            swal.fire({
              title: xhr['status'] + "(" + xhr['statusText'] + ")",
              html: xhr['responseText'],
              type: "error",
              confirmButtonText: 'OK',
              confirmButtonColor: '#d63031',
            })
          },
          success: function (data) {
            if (data == "sukses") {
              Swal.fire(
                'Sukses !!!',
                'Data Berhasil Dihapus',
                'success'
              ).then(() => {
                window.location.reload();
              })
            } else {
              swal.fire({
                title: "ERROR",
                html: data,
                type: "error",
                confirmButtonText: 'OK',
                confirmButtonColor: '#d63031',
              })
            }
          }
        })
      }
    })
  })
})

//   $(document).on("ifChecked","#chkMPKSimForkliftCheckAll", function () {
//     var table_data = tblMPKSimForkliftList.fnGetNodes();
//     $(".chkMPKSimForkliftCheckOne", table_data).iCheck("check");
//     checkSimForkliftChecked(tblMPKSimForkliftList);
//   });

//     if (jumlah_checked > 0) {
//         var id_checked = {data: []};
//         checkbox_checked.each(function(){
//             id_checked.data.push($(this).val());
//         })
//         // console.log(id_checked);
//         var url_param = $.param(id_checked);
//         $('#btnSimForkliftCetakPdf').attr('href',baseurl + 'MasterPekerja/SimForklift/cetakpdf?' + url_param);
//         $('#btnSimForkliftCetakPdf').attr('disabled',false);
//         $('#btnSimForkliftCetakImg').attr('href',baseurl + 'MasterPekerja/SimForklift/cetakimg?' + url_param);
//         $('#btnSimForkliftCetakImg').attr('disabled',false);
//         $('#btnSimForkliftCetakCrl').attr('href',baseurl + 'MasterPekerja/SimForklift/cetakcrl?' + url_param);
//         $('#btnSimForkliftCetakCrl').attr('disabled',false);
//     }else{
//         $('#btnSimForkliftCetakPdf').attr('disabled',true);
//         $('#btnSimForkliftCetakImg').attr('disabled',true);
//         $('#btnSimForkliftCetakCrl').attr('disabled',true);
//     }
//   });
// });

function checkSimForkliftChecked(tblMPKSimForkliftList) {
  var table_data = tblMPKSimForkliftList.fnGetNodes();
  var checkbox_checked = $(".chkMPKSimForkliftCheckOne:checked", table_data);
  var jumlah_checked = checkbox_checked.length;

  if (jumlah_checked > 0) {
    var id_checked = { data: [] };
    checkbox_checked.each(function () {
      id_checked.data.push($(this).val());
    });
    // console.log(id_checked);
    var url_param = $.param(id_checked);
    $("#btnSimForkliftCetakPdf").attr("href", baseurl + "MasterPekerja/SimForklift/cetakpdf?" + url_param);
    $("#btnSimForkliftCetakPdf").attr("disabled", false);
    $("#btnSimForkliftCetakImg").attr("href", baseurl + "MasterPekerja/SimForklift/cetakimg?" + url_param);
    $("#btnSimForkliftCetakImg").attr("disabled", false);
    $("#btnSimForkliftCetakCrl").attr("href", baseurl + "MasterPekerja/SimForklift/cetakcrl?" + url_param);
    $("#btnSimForkliftCetakCrl").attr("disabled", false);
  } else {
    $("#btnSimForkliftCetakPdf").attr("disabled", true);
    $("#btnSimForkliftCetakImg").attr("disabled", true);
    $("#btnSimForkliftCetakCrl").attr("disabled", true);
  }
}
// sim forklift end

//Surat Pernyataan
$(document).ready(function () {
  getPekerjaTpribadi("#mpkpkjsuper");

  $(".mpktgljkk").datepicker({
    autoclose: true,
    autoApply: true,
    format: "yyyy-mm-dd",
    todayHighlight: true,
  });

  $("#mpklistrs").select2({
    ajax: {
      url: baseurl + "MasterPekerja/surat_pernyataan/getrsklinik",
      dataType: "json",
      type: "get",
      data: function (params) {
        return { txt: params.term };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.id,
              text: item.nmppk,
            };
          }),
        };
      },
      cache: true,
    },
    minimumInputLength: 2,
    placeholder: "Nama RS / Klinik",
    allowClear: false,
  });

  $("#mpklhubkrd").select2({
    ajax: {
      url: baseurl + "MasterPekerja/surat_pernyataan/get_hubkerd",
      dataType: "json",
      type: "get",
      data: function (params) {
        return { txt: params.term };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.noind,
              text: item.noind + " - " + item.nama,
            };
          }),
        };
      },
      cache: true,
    },
    minimumInputLength: 2,
    placeholder: "Pilih Salah satu",
    allowClear: false,
  });

  $("#mpslcnohubkrd").select2({
    tags: true,
    placeholder: "Masukan No HP",
  });

  $("#btnprvsuper").click(function () {
    var data = $("#mpkfrmsubper").serialize();
    var x = 0;
    $("#mpkfrmsubper input").each(function () {
      if ($(this).val() != "") x++;
    });
    $("#mpkfrmsubper select").each(function () {
      // alert($(this).val());
      if ($(this).val() != null) x++;
    });
    if (x >= 6) {
      $("#mpkbtnsbmsuper").attr("disabled", false);
    }
    console.log(x);
    window.open(
      baseurl + "MasterPekerja/surat_pernyataan/preview_super?" + data,
      "_blank"
    );
  });

  $("#mpktblsuper").DataTable();
});
//Surat Pernyataan end


//Daftar Nama Aktif
$(document).ready(function () {
  $("#MPK_NoIndukAktif").select2();
  $("#MPK_LokasiKerjaAktif").select2();

  $("#MPK_IsiRadio").select2({
    searching: true,
    minimumInputLength: 1,
    placeholder: "Cari sesuai kategori",
    allowClear: true,

    ajax: {
      url: baseurl + "MasterPekerja/cetak/GetIsiRadio",
      dataType: "json",
      delay: 500,
      type: "GET",
      data: function (params) {
        return {
          term: params.term,
          term2: $("input[name=optradio]:checked").val()
        };
      },

      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            if ($("input[name=optradio]:checked").val() == "dept") {
              return {
                id: obj.kode,
                text: obj.dept
              };
            } else if ($("input[name=optradio]:checked").val() == "unit") {
              return {
                id: obj.kode,
                text: obj.unit
              };
            } else {
              return {
                id: obj.kode,
                text: obj.seksi
              };
            }
          })
        };
      }
    }
  });

  $("#MPK_Datepicker").daterangepicker({
    singleDatePicker: true,
    timePicker: false,
    timePicker24Hour: true,
    showDropdowns: true,
    locale: {
      format: "YYYY-MM-DD",
      todayHighlight: true
    }
  });

  $("#MPK_TampilAktif").on("click", function () {
    let kodeinduk = $("#MPK_NoIndukAktif option:checked")
      .map(function () {
        return this.value;
      })
      .get()
      .join("%' OR tbl.noind LIKE '");

    let lokasi = $("#MPK_LokasiKerjaAktif").val();
    let kategori = $("#MPK_IsiRadio").val();
    let tanggal = $("#MPK_Datepicker").val();
    var tanggal2 = $.datepicker.formatDate(
      "dd MM yy",
      new Date($("#MPK_Datepicker").val())
    );

    var loading = baseurl + "assets/img/gif/loadingquick.gif";

    if (tanggal == "" || tanggal == null) {
      swal.fire({
        title: "Peringatan",
        text: "Harap Mengisi Tanggal !",
        type: "warning",
        allowOutsideClick: false
      });
    } else {
      $.ajax({
        type: "GET",
        data: {
          kodeinduk: kodeinduk,
          lokasi: lokasi,
          kategori: kategori,
          tanggal: tanggal,
          tanggal2: tanggal2
        },
        url: baseurl + "MasterPekerja/cetak/viewAll",
        beforeSend: function () {
          swal.fire({
            html: "<div><img style='width: 320px; height: auto;'src='" +
              loading +
              "'><br><p>Sedang Proses....</p></div>",
            customClass: "swal-wide",
            showConfirmButton: false,
            allowOutsideClick: false
          });
        },
        success: function (result) {
          swal.close();
          // console.log(result);
          $("#MPK_Tabledata").html(result);
          console.log(kodeinduk);
          $("#DataNamaAktif").DataTable({
            dom: "Bfrtip",
            buttons: [{
              extend: "excelHtml5",
              title: "Daftar Nama Aktif" + " - " + tanggal2
            },
            {
              extend: "pdfHtml5",
              title: "Daftar Nama Aktif" + " - " + tanggal2,
              orientation: "landscape",
              pageSize: "LEGAL"
            },
            {
              extend: "print",
              title: "Daftar Nama Aktif" + " - " + tanggal2
            }
            ]
          });
        }
      });
    }
  });
});
//End Daftar Nama Aktif

//Cetak Kategori
$(document).ready(function () {
  $("#TDP_Tariknoind").select2();
  $("#TDP_Tarikpendidikan").select2();
  $("#TDP_Tarikjenkel").select2();
  $("#TDP_Tariklokasi").select2();
  $("#TDP_Tarikstatus").select2();

  $("#TDP_Rangemasuk").daterangepicker({
    autoUpdateInput: false,
    showDropdowns: true,
    locale: {
      format: "DD/MM/YYYY",
      cancelLabel: "Clear"
    }
  });

  $("#TDP_Rangekeluar").daterangepicker({
    autoUpdateInput: false,
    showDropdowns: true,
    locale: {
      format: "DD/MM/YYYY",
      cancelLabel: "Clear"
    }
  });

  $('input[name="tdpdrp"]').on("apply.daterangepicker", function (ev, picker) {
    $(this).val(
      picker.startDate.format("YYYY-MM-DD") +
      " - " +
      picker.endDate.format("YYYY-MM-DD")
    );
  });

  $('input[name="tdpdrp"]').on("cancel.daterangepicker", function (ev, picker) {
    $(this).val("");
  });

  $(window).on('load', function () {
    $("input[name=rbt_TDPRange]").on("ifToggled", function () {
      if ($("#rbt_TDPRange1").prop("checked")) {
        $("#TDP_Rangemasuk").prop("disabled", false);
        $("#TDP_Rangekeluar").prop("disabled", true);
        $("#TDP_Rangekeluar").val("");
      } else {
        $("#TDP_Rangemasuk").prop("disabled", true);
        $("#TDP_Rangekeluar").prop("disabled", false);
        $("#TDP_Rangemasuk").val("");
      }
    });
  });

  $("#TDP_IsiKategoritarik").select2({
    searching: true,
    minimumInputLength: 1,
    placeholder: "Cari sesuai kategori",
    allowClear: true,

    ajax: {
      url: baseurl + "MasterPekerja/cetakkategori/GetKategori",
      dataType: "json",
      delay: 500,
      type: "GET",
      data: function (params) {
        return {
          term: params.term,
          term2: $("#TDP_Tarikkategori").val()
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            if ($("#TDP_Tarikkategori").val() == "Seksi") {
              return {
                id: obj.kode,
                text: obj.seksi
              };
            } else if ($("#TDP_Tarikkategori").val() == "Unit") {
              return {
                id: obj.kode,
                text: obj.unit
              };
            } else {
              return {
                id: obj.kode,
                text: obj.dept
              };
            }
          })
        };
      }
    }
  });

  $("#TDP_TarikDataAll").on("click", function () {
    let noind = $("#TDP_Tariknoind option:checked")
      .map(function () {
        return this.value;
      })
      .get()
      .join("%' OR tp.noind LIKE '");
    let pend = $("#TDP_Tarikpendidikan").val();
    let jenkel = $("#TDP_Tarikjenkel").val();
    let lokasi = $("#TDP_Tariklokasi").val();
    let kategori = $("#TDP_IsiKategoritarik").val();
    let status = $("input[name=tdpstatus]:checked").val();

    var rangemasuk = $("#TDP_Rangemasuk").val();
    var splitmasuk = rangemasuk.split(" - ");
    if (splitmasuk == "" || splitmasuk == null) {
      var startmasuk = "1000-01-01";
      var endmasuk = "1000-01-01";
    } else {
      var startmasuk = splitmasuk[0];
      var endmasuk = splitmasuk[1];
    }

    var rangekeluar = $("#TDP_Rangekeluar").val();
    var splitkeluar = rangekeluar.split(" - ");
    if (splitkeluar == "" || splitkeluar == null) {
      var startkeluar = "1000-01-01";
      var endkeluar = "1000-01-01";
    } else {
      var startkeluar = splitkeluar[0];
      var endkeluar = splitkeluar[1];
    }

    var arrselect = $(".chk_FilterTarikData:checked")
      .map(function () {
        return this.value;
      })
      .get()
      .join(", ");

    var loading = baseurl + "assets/img/gif/loadingquick.gif";

    if (arrselect.length == null || arrselect == "") {
      swal.fire({
        title: "Peringatan",
        text: "Pilih minimal 1 data untuk di tarik !",
        type: "warning",
        allowOutsideClick: false
      });
    }
    else {
      $.ajax({
        type: "POST",
        data: {
          noind: noind,
          pend: pend,
          jenkel: jenkel,
          lokasi: lokasi,
          kategori: kategori,
          rangekeluarstart: startkeluar,
          rangekeluarend: endkeluar,
          rangemasukstart: startmasuk,
          rangemasukend: endmasuk,
          arrselect: arrselect,
          status: status
        },
        url: baseurl + "MasterPekerja/cetakkategori/GetFilter",
        beforeSend: function () {
          console.log(kategori)
          swal.fire({
            html: "<div><img style='width: 320px; height: auto;'src='" +
              loading +
              "'><br><p>Sedang Proses....</p></div>",
            customClass: "swal-wide",
            showConfirmButton: false,
            allowOutsideClick: false
          });
        },
        success: function (result) {
          swal.close();
          $("#Div_viewall").html(result);
          $(".chk_FilterTarikData:not(:checked)").each(function () {
            var tdphide = "." + $(this).attr("name");
            $(tdphide).remove();
          });

          $("#TDP_viewall").DataTable({
            dom: "Bfrtip",
            buttons: [{
              extend: "excelHtml5",
              title: "Cetak Kategori",
              customizeData: function (data) {
                var tblnik = data.header.indexOf("NIK");
                for (var i = 0; i < data.body.length; i++) {
                  data.body[i][tblnik] = '\u200C' + data.body[i][tblnik]; 
                }
              }
            }],
            initComplete: function (settings, json) {
              $("#TDP_viewall").wrap(
                "<div style='overflow:auto; width:100%;position:relative;'></div>"
              );
            },
          });
        }
      });
    }
  });
});

  //End Cetak Kategori