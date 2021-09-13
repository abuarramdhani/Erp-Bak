$(document).ready(function () {
  $("#slcNoind")
    .select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: "Pilih pekerja",
      ajax: {
        url: baseurl + "SystemIntegration/KaizenPekerjaTks/input/getEmployees",
        type: "get",
        dataType: "json",
        delay: 250,
        cache: true,
        data: function (params) {
          return {
            searchTerm: params.term,
          };
        },
        processResults: function (data) {
          return {
            results: data.map((a) => {
              return {
                id: a.noind,
                text: a.noind + " - " + a.name,
                name: a.name,
                section_code: a.section_code,
                section: a.section_name,
                unit: a.unit_name,
              };
            }),
          };
        },
      },
    })
    .on("select2:select", function (e) {
      $("#employeeName").val(e.params.data.name);
      $("#employeeSection").val(e.params.data.section);
      $("#employeeUnit").val(e.params.data.unit);
      $("#sectionCode").val(e.params.data.section_code);
    })
    .on("select2:unselect", function () {
      $("#employeeName").val("");
      $("#employeeSection").val("");
      $("#employeeUnit").val("");
      $("#sectionCode").val("");
    });

  let tb1 = $("#tableDetailKaizen").DataTable();

  const toggleIcon = {
    open: {
      url: baseurl + "assets/img/icon/details_open.png",
      title: "Show detail",
    },
    close: {
      url: baseurl + "assets/img/icon/details_close.png",
      title: "Hide detail",
    },
  };

  let table = $("#tableRekapKaizen").DataTable({
    ajax: {
      url: baseurl + "SystemIntegration/KaizenPekerjaTks/rekap/getAllKaizen",
      type: "GET",
      dataType: "JSON",
    },
    drawCallback() {
      // init tooltop
      $('[data-toggle="tooltip"]').tooltip();
    },
    columns: [
      {
        className:
          "details-control text-center cursor-pointer hover-gray disable-select",
        orderable: false,
        data: null,
        render() {
          return `
            <img data-toggle="tooltip" data-title="${toggleIcon.open.title}" src="${toggleIcon.open.url}" />
          `;
        },
      },
      {
        data: "no",
      },
      {
        className: "noind",
        data: "no_ind",
      },
      {
        data: "name",
      },
      {
        data: "section",
      },
      {
        data: "total",
      },
    ],
  });

  $("#tableRekapKaizen tbody").on("click", "td.details-control", function () {
    var tr = $(this).closest("tr");
    const $toggleIcon = $(this).find("img");

    var row = table.row(tr);
    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass("shown");
      $toggleIcon.attr("src", toggleIcon.open.url);
      $toggleIcon.attr("data-original-title", toggleIcon.open.title);
    } else {
      $.ajax({
        type: "get",
        url:
          baseurl + "SystemIntegration/KaizenPekerjaTks/rekap/getKaizenByNoind",
        dataType: "json",
        data: {
          noind: $(this).parent().find("td.noind").html(),
        },
        success: function (result) {
          $toggleIcon.attr("src", toggleIcon.close.url);
          $toggleIcon.attr("data-original-title", toggleIcon.close.title);
          row.child(format(result.data)).show();
          tr.addClass("shown");
        },
      });
    }
  });

  $("#tableRekapKaizen tbody").on("click", "button.btnEditKaizen", function () {
    const validationData = {
      currentUser:$('#tableRekapKaizen').data('username'),
      currentSectionCode:$('#tableRekapKaizen').data('sectioncode'),
      createdBy: $(this).data('createdby'),
      sectionCode: $(this).data('sectioncode'),
      section: $(this).data('section')
    }
    const isValid = adminValidation(validationData)
    if (!isValid.valid) {
      Swal.fire({
        title: 'Tindakan Dilarang',
        text: `Data ini hanya dapat diubah oleh admin user ${isValid.createdBy} atau pekerja seksi ${isValid.section}`,
        type: 'warning'
      })
      return
    }
    $(this)
      .parent()
      .parent()
      .find(".slcKaizenCategory")
      .attr("disabled", false);
    $(this)
      .parent()
      .parent()
      .find(".inpKaizenCategory")
      .attr("disabled", false);
    $(this).parent().parent().find(".btnSimpanKaizen").removeClass("hidden");
    $(this).parent().parent().find(".btnBatalKaizen").removeClass("hidden");
    $(this).parent().parent().find(".editFileKaizen").removeClass("hidden");
    $(this).parent().parent().find(".btnLihatFile").addClass("hidden");
    $(this).parent().parent().find(".btnEditKaizen").addClass("hidden");
    $(this).parent().parent().find(".btnDeleteKaizen").addClass("hidden");
  });

  $("#tableRekapKaizen tbody").on(
    "click",
    "button.btnBatalKaizen",
    function () {
      $(this)
        .parent()
        .parent()
        .find(".slcKaizenCategory")
        .attr("disabled", true);
      $(this)
        .parent()
        .parent()
        .find(".inpKaizenCategory")
        .attr("disabled", true);
      $(this).parent().parent().find(".btnSimpanKaizen").addClass("hidden");
      $(this).parent().parent().find(".btnBatalKaizen").addClass("hidden");
      $(this).parent().parent().find(".btnEditKaizen").removeClass("hidden");
      $(this).parent().parent().find(".btnDeleteKaizen").removeClass("hidden");
      $(this).parent().parent().find(".editFileKaizen").addClass("hidden");
      $(this).parent().parent().find(".btnLihatFile").removeClass("hidden");
    }
  );

  $("#tableRekapKaizen tbody").on(
    "click",
    "button.btnSimpanKaizen",
    function () {
      $(this)
        .parent()
        .parent()
        .find(".slcKaizenCategory")
        .attr("disabled", true);
      $(this)
        .parent()
        .parent()
        .find(".inpKaizenCategory")
        .attr("disabled", true);
      $(this).parent().parent().find(".btnSimpanKaizen").addClass("hidden");
      $(this).parent().parent().find(".btnBatalKaizen").addClass("hidden");
      $(this).parent().parent().find(".btnEditKaizen").removeClass("hidden");
      $(this).parent().parent().find(".btnDeleteKaizen").removeClass("hidden");
      $(this).parent().parent().find(".editFileKaizen").addClass("hidden");
      $(this).parent().parent().find(".btnLihatFile").removeClass("hidden");
    }
  );

  $("#tableRekapKaizen tbody").on(
    "click",
    "button.btnSimpanKaizen",
    function (e) {
      e.preventDefault();

      let tr = $(this).parent().parent();
      console.log(tr);
      let id = $(this).attr("data-id");
      let old_file = $(this).attr("data-file");
      let kategori = tr.find(".slcKaizenCategory").val();
      let title = tr.find(".inpKaizenCategory").val();

      let gambar = tr.find("input.editGambarKaizen").get(0);
      gambar = gambar.files && gambar.files[0];
      console.log(gambar);

      let data = new FormData();
      data.append("file", gambar);
      data.append("id", id);
      data.append("old_file", old_file);
      data.append("kategori", kategori);
      data.append("title", title);

      $.ajax({
        type: "POST",
        url:
        baseurl + "SystemIntegration/KaizenPekerjaTks/rekap/updateKaizenKu",
        processData: false,
        contentType: false,
        dataType: "json",
        data,
        success: function (result) {
          if (result.statusCode == 200) {
            table.ajax.reload();
            Swal.fire("Updated!", "Kaizen berhasil diupdate", "success");
          } else {
            table.ajax.reload();
            Swal.fire("Unupdated!", "Kaizen gagal diupdate", "warning");
          }
        },
      });
    }
  );

  $("#tableRekapKaizen tbody").on(
    "click",
    "button.btnDeleteKaizen",
    function () {
      let id = $(this).attr("data-id");
      let kaizen_file = $(this).attr("data-file");
      const validationData = {
        currentUser:$('#tableRekapKaizen').data('username'),
        currentSectionCode:$('#tableRekapKaizen').data('sectioncode'),
        createdBy: $(this).data('createdby'),
        sectionCode: $(this).data('sectioncode'),
        section: $(this).data('section')
      }
      const isValid = adminValidation(validationData)
      if (!isValid.valid) {
        Swal.fire({
          title: 'Tindakan Dilarang',
          text: `Data ini hanya dapat dihapus oleh admin user ${isValid.createdBy} atau pekerja seksi ${isValid.section}`,
          type: 'warning'
        })
        return
      }

      Swal.fire({
        title: "Anda Yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.value == true) {
          $.ajax({
            type: "post",
            url:
              baseurl +
              "SystemIntegration/KaizenPekerjaTks/rekap/deleteKaizenKu",
            dataType: "json",
            data: {
              id: id,
              kaizen_file: kaizen_file,
            },
            success: function (result) {
              console.log(result.statusCode);
              if (result.statusCode == 200) {
                table.ajax.reload();
                Swal.fire("Deleted!", "Kaizen berhasil dihapus", "success");
              } else if (result.statusCode == 201) {
                table.ajax.reload();
                Swal.fire("Undeleted!", "Kaizen gagal dihapus", "warning");
              } else {
                table.ajax.reload();
                Swal.fire("Undeleted!", "Kaizen gagal dihapus", "warning");
              }
            },
          });
        }
      });
    }
  );
  function adminValidation({ currentUser, currentSectionCode, createdBy, sectionCode, section }) {
    return {
      section,
      createdBy,
      valid:(currentUser == createdBy) || (currentSectionCode.toString().substr(0,8) == sectionCode.toString().substr(0,8))
    }
  }
});

function format(d) {
  let dt = "";
  let i = 1;
  d.forEach(function (data) {
    dt += `
    
    <tr class="cekForm">
      <td>${i++}</td>
      <td>
      <select style="width: 100px" name="slcKaizenCategory" class="slcKaizenCategory form-control" required disabled>
              <option value=""></option>
              <option value="Process" ${
                data.kaizen_category == "Process" ? "selected" : ""
              }>Process</option>
              <option value="Quality" ${
                data.kaizen_category == "Quality" ? "selected" : ""
              }>Quality</option>
              <option value="Handling" ${
                data.kaizen_category == "Handling" ? "selected" : ""
              }>Handling</option>
              <option value="5S" ${
                data.kaizen_category == "5S" ? "selected" : ""
              }>5S</option>
              <option value="Safety" ${
                data.kaizen_category == "Safety" ? "selected" : ""
              }>Safety</option>
              <option value="Yokoten" ${
                data.kaizen_category == "Yokoten" ? "selected" : ""
              }>Yokoten</option>
      </select>
      </td>
      <td><input name="inpKaizenCategory" type="text" class="inpKaizenCategory form-control" value=" ${
        data.kaizen_title
      }" disabled></td>
      <td>${
        data.updated_at == null || data.updated_at == ""
          ? data.created_at
          : data.updated_at
      }</td>
      <td class="row">
      <a class="btn btn-sm btn-success btnLihatFile" data-file="${
        data.kaizen_file
      }" href="${
      baseurl + "assets/upload/uploadKaizenTks/" + data.kaizen_file
    }" target="_blank">
      <i style="margin-right: 5px;" class="fa fa-file"></i><span>Lihat File<span>
      </a>
      <form class="editFileKaizen hidden">
      <input name="inputFile" type="file" class="editGambarKaizen form-control-file" accept=".jpg, .png, .jpeg, .pdf" >
      </form>
      </td>
      <td style="display: flex; justify-content: center;">
      <button class="btn btn-sm btn-success btnSimpanKaizen hidden" data-file="${
        data.kaizen_file
      }" data-id="${data.kaizen_id}" style="margin-right: 8px;">Simpan</button>
      <button data-section="${data.section}" data-sectioncode="${data.section_code}" data-createdby="${data.created_by}" class="btn btn-sm btn-warning btnEditKaizen" style="margin-right: 8px;">Edit</button>
      <button class="btn btn-sm btn-danger btnDeleteKaizen" data-id="${
        data.kaizen_id
      }" data-file="${data.kaizen_file}" data-section="${data.section}" data-sectioncode="${data.section_code}" data-createdby="${data.created_by}">Hapus</button>
      <button data-section="${data.section}" data-sectioncode="${data.section_code}" data-createdby="${data.created_by}" class="btn btn-sm btn-danger btnBatalKaizen hidden">Batal</button>
      </td>
      </tr>
      `;
  });

  return `<table class="table table-bordered table-striped">
  <thead class="tableHead bg-primary">
    <tr>
      <th style="width: 5%;">No</th>
      <th style="width: 15%;">Kategori Kaizen</th>
      <th style="width: 30%;">Judul Kaizen</th>
      <th style="width: 20%;">Last Edit</th>
      <th style="width: 10%;">Lampiran</th>
      <th style="width: 10%;">Action</th>
    </tr>
  </thead>
  <tbody>
    ${dt}
  </tbody>
  </table>`;
}
