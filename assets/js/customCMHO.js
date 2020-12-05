let state = {
  kd_memo: "",
};

function setValue(id, newValue) {
  var s = document.getElementById(id);
  s.value = newValue;
}

function setHeader(id, header) {
  return (document.getElementById(id).innerHTML = header);
}

function setSelectValue(id, idVal, newValue) {
  var $newOption = $("<option selected='selected'></option>")
    .val(idVal)
    .text(newValue);

  $(id).append($newOption).trigger("change");
}

$(document).ready(function () {
  $("#reservation1").daterangepicker();
  $("#reservation2").daterangepicker();
  $("#datepicker").datepicker({
    autoclose: true,
  });

  const tb1 = $("#tb1").DataTable({
    scrollX: true,
    scrollCollapse: true,
  });

  let tableModal = $("#tb4").DataTable({
    retrieve: !0,
    aaSorting: [],
  });

  //Date picker
  $("#datemomen")
    .datepicker({
      autoclose: true,
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
    })
    .val(moment().format("YYYY"));

  $("button#carimemo").on("click", function () {
    var loading = baseurl + "assets/img/gif/loadingquick.gif";

    const data = {
      year: $("#datemomen").val(),
    };

    if (data.year == "") {
      return swal.fire({
        title: "Peringatan",
        text: "Anda Harus Memilih Tahun",
        type: "warning",
        allowOutsideClick: false,
      });
    } else {
      $.ajax({
        method: "GET",
        url: baseurl + "ADMSeleksi/Menu/Cetak/search_daftar_memo",
        beforeSend: function () {
          swal.fire({
            html:
              "<div><img style='width: 320px; height:auto;'src='" +
              loading +
              "'><br> <p>Sedang Proses....</p></div>",
            customClass: "swal-wide",
            showConfirmButton: false,
            allowOutsideClick: false,
          });
        },
        data: data,
        dataType: "html",
        success(tableRow) {
          swal.close();
          $("#tb4").DataTable().clear().destroy();
          $("table#tb4 tbody").html(tableRow);

          // reinitialize again listener on table rows with this listener
          addEventListonerToTb4;

          // initialize again datatable
          tableModal = $("#tb4").DataTable({
            retrieve: true,
            aaSorting: [],
          });
        },
      });
    }
  });

  $("button#refresh").on("click", function () {
    var loading = baseurl + "assets/img/gif/loadingquick.gif";

    $.ajax({
      method: "GET",
      url: baseurl + "ADMSeleksi/Menu/Cetak/get_refresh_data_memo",
      beforeSend: function () {
        swal.fire({
          html:
            "<div><img style='width: 320px; height:auto;'src='" +
            loading +
            "'><br> <p>Sedang Proses....</p></div>",
          customClass: "swal-wide",
          showConfirmButton: false,
          allowOutsideClick: false,
        });
      },
      dataType: "html",
      success(tableRow) {
        swal.close();
        $("#tb4").DataTable().clear().destroy();
        $("table#tb4 tbody").html(tableRow);

        tableModal = $("#tb4").DataTable({
          retrieve: true,
          aaSorting: [],
        });

        console.log(tableRow);
      },
    });
  });

  function addEventListonerToTb4() {
    $("#tb4 tbody").on("dblclick", "tr", function () {
      //
      var table = tableModal.row(this).data();
      console.log("table value is: ", table);
      var loading = baseurl + "assets/img/gif/loadingquick.gif";
      const data = {
        kdmemo: table && table[5] ? table[5] : $(this).attr("id"),
      };

      state.kd_memo = data.kdmemo;
      $.ajax({
        method: "GET",
        url: baseurl + "ADMSeleksi/Menu/Cetak/get_daftar_memo",
        data: data,
        beforeSend: function () {
          swal.fire({
            html:
              "<div><img style='width: 320px; height:auto;'src='" +
              loading +
              "'><br> <p>Sedang Proses....</p></div>",
            customClass: "swal-wide",
            showConfirmButton: false,
            allowOutsideClick: false,
          });
        },
        dataType: "json",
        success(response) {
          var dataRes = response.data;
          let arr = Object.keys(dataRes).map(function (e) {
            return dataRes[e];
          });

          console.log(arr);
          setValue("inp-no-surat", arr[0]["nosurat"]);
          setValue("datepicker", arr[0]["tanggal"]);
          setValue("inp-periode-test", arr[0]["periode"]);
          setValue("inp-jabatan-tujuan", arr[0]["jbttujuan"]);
          setValue("inp-seksi-tujuan", arr[0]["seksitujuan"]);
          setValue("inp-jabatan-pengirim", arr[0]["jbtpengirim"]);
          setValue("inp-seksi-pengirim", arr[0]["seksipengirim"]);
          setValue("inp-tembusan1", arr[0]["tembusan1"]);
          setValue("inp-tembusan2", arr[0]["tembusan2"]);
          setValue("inp-tembusan3", arr[0]["tembusan3"]);
          setValue("inp-tembusan4", arr[0]["tembusan4"]);
          setValue("inp-tembusan5", arr[0]["tembusan5"]);

          setSelectValue("#slc-hal-surat", "idhal", arr[0]["hal"]);
          setSelectValue("#slc-gender-tujuan", "idgender", arr[0]["jenis"]);
          setSelectValue(
            "#slc-nama-pengirim",
            "idnamapengirim",
            arr[0]["nmpengirim"]
          );
          setSelectValue(
            "#slc-nama-tujuan",
            "idnamatujuan",
            arr[0]["nmtujuan"]
          );
        },
      });

      $.ajax({
        method: "GET",
        url: baseurl + "ADMSeleksi/Menu/Cetak/get_daftar_nilai",
        data: data,
        dataType: "json",
        success(response) {
          var dataRes = response.data;
          let arr = Object.keys(dataRes).map(function (e) {
            return dataRes[e];
          });
          const mapArray = response.data.map((item, index) => {
            let it = Object.keys(item).map(function (e) {
              return item[e];
            });
            it.unshift(index + 1);
            return it;
          });
          for (let key = 0; key < arr.length; key++) {
            const element = key;
            console.log(element);
            setHeader("cv", arr[key]["ncv"]);
            setHeader("cp", arr[key]["ncp"]);
            setHeader("ap", arr[key]["nap"]);
            setHeader("nb", arr[key]["nnb"]);
            setHeader("sf", arr[key]["nsf"]);
            setHeader("s5", arr[key]["ns5"]);
            setHeader("hdl", arr[key]["nhdl"]);
            setHeader("bgab", arr[key]["nbgab"]);
            setHeader("bcc1", arr[key]["nbcc1"]);
            setHeader("cc1", arr[key]["ncc1"]);
            setHeader("cc2", arr[key]["ncc2"]);
            setHeader("bcm1", arr[key]["nbcm1"]);
            setHeader("bcm2", arr[key]["nbcm2"]);
            setHeader("cm1", arr[key]["ncm1"]);
            setHeader("cm2", arr[key]["ncm2"]);
            setHeader("abu", arr[key]["nabu"]);
          }
          tb1.clear();
          tb1.rows.add(mapArray);
          tb1.draw();
          swal.close();
          $(".myModal").modal("hide");
        },
      });
    });
  }
  // call
  addEventListonerToTb4();

  $(document).on("click", "button#pdf", function () {
    const url = baseurl + "ADMSeleksi/Menu/Cetak/export_pdf";
    const data = {
      kdmemo: state.kd_memo,
    };

    if (data.kdmemo == "") {
      swal.fire({
        title: "Peringatan",
        text: "Anda Belum Mencari Data",
        type: "warning",
        allowOutsideClick: false,
      });
    } else {
      const param = $.param(data);
      window.open(`${url}?${param}`, "_blank");
    }
  });
});
