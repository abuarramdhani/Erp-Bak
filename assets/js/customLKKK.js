$(function () {
  $("#slcPekerja").select2({
    minimumInputLength: 3,
    allowClear: true,
    placeholder: "Pilih Pekerja",
    ajax: {
      url: baseurl + "MasterPekerja/ResumeMedis/data_pekerja",
      dataType: "json",
      type: "GET",
      data: function (params) {
        return {
          term: params.term,
        };
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
    },
  });

  $("#slcCabang").select2({
    minimumInputLength: 0,
    allowClear: true,
    placeholder: "Pilih Cabang",
    ajax: {
      url: baseurl + "MasterPekerja/ResumeMedis/data_perusahaan",
      dataType: "json",
      type: "GET",
      data: function (params) {
        return { q: params.term };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (cabang) {
            return {
              id: cabang.kode_mitra,
              text:
                cabang.kode_mitra +
                " - " +
                cabang.kota +
                " - " +
                cabang.keterangan,
            };
          }),
        };
      },
    },
  });

  $("#datepicker_laka, #datepicker_periksa").datepicker({
    format: "dd-mm-yyyy",
    separator: "-",
    todayHighlight: "TRUE",
    autoclose: true,
  });

  $("input").iCheck({
    checkboxClass: "icheckbox_square-blue",
    radioClass: "iradio_square-blue",
    increaseArea: "20%", // optional
  });

  $("#KecelakaanKerja-cmbNoindukPekerja").select2({
    minimumInputLength: 3,
    allowClear: true,
    placeholder: "Pilih Pekerja",
    ajax: {
      url: baseurl + "MasterPekerja/KecelakaanKerja/data_pekerja",
      dataType: "json",
      type: "GET",
      data: function (params) {
        return { term: params.term };
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
    },
  });
  $("#cetaktanterbpjs-pekerja_bpjs").select2({
    minimumInputLength: 3,
    allowClear: true,
    placeholder: "Pilih Pekerja",
    ajax: {
      url: baseurl + "MasterPekerja/TanTerBPJS/data_pekerja",
      dataType: "json",
      type: "GET",
      data: function (params) {
        return { term: params.term };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.noind,
              text: item.noind + " - " + item.nama + " - " + item.seksi,
            };
          }),
        };
      },
    },
  });

  $("#KecelakaanKerja-cmbCabangPerusahaan").select2({
    minimumInputLength: 0,
    allowClear: true,
    placeholder: "Pilih Cabang",
    ajax: {
      url: baseurl + "MasterPekerja/KecelakaanKerja/data_perusahaan",
      dataType: "json",
      type: "GET",
      data: function (params) {
        return { q: params.term };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (cabang) {
            return {
              id: cabang.kode_mitra,
              text:
                cabang.kode_mitra +
                " - " +
                cabang.kota +
                " - " +
                cabang.keterangan,
            };
          }),
        };
      },
    },
  });

  $("#tbl_perusahaan").dataTable({});

  $("#tbl_lkkk_1").dataTable({});
  $("#tbl_datacetak").dataTable({
    paging: true,
    lengthChange: false,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    deferRender: true,
    scroller: true,
  });

  $("#exampleModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data("whatever"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find(".modal-title").text("New message to " + recipient);
    modal.find(".modal-body input").val(recipient);

    // var nextId = document.getElementById('penggunaNext'); sek delud
    var NextId = $(event.relatedTarget).data("next-id");
    document.getElementById("modal-editTahap2").href =
      baseurl + "MasterPekerja/KecelakaanKerja/editTahap2/" + NextId;
    document.getElementById("modal-printTahap2").href =
      baseurl + "MasterPekerja/KecelakaanKerja/printTahap2/" + NextId;
    document.getElementById("modal-insertTahap2").href =
      baseurl + "MasterPekerja/KecelakaanKerja/nextKecelakaan/" + NextId;
  });

  $("#modalCetakBPJS").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data("whatever"); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find(".modal-title").text("New message to " + recipient);
    modal.find(".modal-body input").val(recipient);
  });

  $(".KecelakaanKerja-daterangepicker").daterangepicker(
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
        "New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')"
      );
    }
  );

  $(".KecelakaanKerja-daterangepickersingledate").daterangepicker(
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
        "New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')"
      );
    }
  );

  $(".KecelakaanKerja-daterangepickersingledatewithtime").daterangepicker(
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
});

function getalamat(th) {
  var id = $("#kk_it_tempatKecelakaan").val();
  var cmbCabangPerusahaan = $("#KecelakaanKerja-cmbCabangPerusahaan").val();
  if (id == "1") {
    $.ajax({
      url: baseurl + "MasterPekerja/KecelakaanKerja/getAlamatKK",
      data: {
        cmbCabangPerusahaan: cmbCabangPerusahaan,
      },
      type: "POST",
    }).success(function (data) {
      var json = data,
        obj = JSON.parse(json);
      $("#kk_it_alamatKecelakaan").val(obj.alamat);
      $("#it_alamatDesaKecelakaan").val(obj.desa);
      $("#it_alamatKecamatanKecelakaan").val(obj.kecamatan);
      $("#it_alamatKotaKecelakaan").val(obj.kota);
    });
  } else {
  }
}
function getalamatview(th) {
  var id = $("#kk_it_tempatKecelakaan2").val();
  var cmbCabangPerusahaan = $("#KecelakaanKerja-itCabangPerusahaan").val();
  if (id == "1") {
    $.ajax({
      url: baseurl + "MasterPekerja/KecelakaanKerja/getAlamatKK",
      data: {
        cmbCabangPerusahaan: cmbCabangPerusahaan,
      },
      type: "POST",
    }).success(function (data) {
      var json = data,
        obj = JSON.parse(json);
      $("#kk_it_alamatKecelakaan").val(obj.alamat);
      $("#it_alamatDesaKecelakaan").val(obj.desa);
      $("#it_alamatKecamatanKecelakaan").val(obj.kecamatan);
      $("#it_alamatKotaKecelakaan").val(obj.kota);
    });
  } else {
  }
}
