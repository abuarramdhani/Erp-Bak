$(document).ready(function () {
  $("#slcNoind")
    .select2({
      minimumInputLength: 2,
      allowClear: true,
      placeholder: "Isi noind",
      ajax: {
        url: baseurl + "SystemIntegration/KaizenPekerjaTks/input/getEmployees",
        type: "get",
        dataType: "json",
        delay: 250,
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
                text: a.noind,
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
    });
});
