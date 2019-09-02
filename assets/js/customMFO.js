const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-success",
    cancelButton: "btn btn-danger"
  },
  buttonsStyling: false
});
$(".selectTgl").datepicker({
  autoclose: true,
  format: "dd-mm-yyyy",
  todayHighlight: true
});
$(".selectM").datepicker({
  autoclose: true,
  format: "yyyy-mm",
  minViewMode: 1
});
//Icon Plus effect in Create New bukan Update > Internal and External
function newInput() {
  var count = $(".boxInput").length + 1;
  var html =
    '<div class="col-lg-12 boxInput">' +
    '    <div class="form-group">' +
    "        <label>Verifikasi </label><br />" +
    '        <div class="row">' +
    '            <div class="col-lg-5">' +
    "                <label>Due Date</label>" +
    '                <div class="input-group">' +
    '                    <div class="input-group-addon">' +
    '                        <i class="fa fa-calendar"></i>' +
    "                    </div>" +
    '                     <input type="hidden" name="txtId[]">' +
    '                     <input type="hidden" name="hdnNomorUrut[]" value="' + count + '">' +
    '                    <input type="text"' +
    '                        class="form-control selectTgla" name="txtVerDueDate[]">' +
    "                </div>" +
    "            </div>" +
    '            <div class="col-lg-5">' +
    "                <label>Realisasi</label>" +
    '                <div class="input-group">' +
    '                    <div class="input-group-addon">' +
    '                        <i class="fa fa-calendar"></i>' +
    "                    </div>" +
    '                    <input type="text"' +
    '                        class="form-control selectTgla"' +
    '                        name="txtRealisasi[]">' +
    "                </div>" +
    "            </div>" +
    '            <div class="col-lg-2">' +
    '                <a href="#qw" id="qw" class="btn btn-danger remove_qi"' +
    '                    style="display:none;"' +
    '                    onclick="deleteInput($(this))">' +
    '                    <i class="fa fa-close"></i></a>' +
    "            </div>" +
    "        </div>" +
    '        <div class="row">' +
    '            <div class="col-lg-5">' +
    "                <label>PIC</label>" +
    '                <div class="input-group">' +
    '                    <div class="input-group-addon">' +
    '                        <i class="fa fa-font"></i>' +
    "                    </div>" +
    '                    <input type="text" class="form-control"' +
    '                        placeholder="PIC" name="txtPic[]">' +
    "                </div>" +
    "            </div>" +
    '            <div class="col-lg-5">' +
    "                <label>Catatan</label>" +
    '                    <textarea class="form-control"' +
    '                        placeholder="Catatan" name="txtCat[]"></textarea>' +
    "            </div>" +
    "        </div>" +
    "    </div>" +
    "</div>";
  $(".parentMFO").append(html);
  $(".remove_qi").show();
  $(".selectTgla").datepicker({
    autoclose: true,
    format: "dd-mm-yyyy",
    todayHighlight: true
  });
}
//Icon Plus effect in Update > Internal and External
function newInputEdit() {
  var count = $(".boxInput").length + 0;
  var html =
    '<div class="col-lg-12 boxInput">' +
    '    <div class="form-group">' +
    "        <label>Verifikasi </label><br />" +
    '        <div class="row">' +
    '            <div class="col-lg-5">' +
    "                <label>Due Date</label>" +
    '                <div class="input-group">' +
    '                    <div class="input-group-addon">' +
    '                        <i class="fa fa-calendar"></i>' +
    "                    </div>" +
    '                     <input type="hidden" name="txtId[]">' +
    '                     <input type="hidden" name="hdnNomorUrut[]" value="' + count + '">' +
    '                    <input type="text"' +
    '                        class="form-control selectTgla" name="txtVerDueDate[]">' +
    "                </div>" +
    "            </div>" +
    '            <div class="col-lg-5">' +
    "                <label>Realisasi</label>" +
    '                <div class="input-group">' +
    '                    <div class="input-group-addon">' +
    '                        <i class="fa fa-calendar"></i>' +
    "                    </div>" +
    '                    <input type="text"' +
    '                        class="form-control selectTgla"' +
    '                        name="txtRealisasi[]">' +
    "                </div>" +
    "            </div>" +
    "        </div>" +
    '        <div class="row">' +
    '            <div class="col-lg-5">' +
    "                <label>PIC</label>" +
    '                <div class="input-group">' +
    '                    <div class="input-group-addon">' +
    '                        <i class="fa fa-font"></i>' +
    "                    </div>" +
    '                    <input type="text" class="form-control"' +
    '                        placeholder="PIC" name="txtPic[]">' +
    "                </div>" +
    "            </div>" +
    '            <div class="col-lg-5">' +
    "                <label>Catatan</label>" +
    '                    <textarea class="form-control"' +
    '                        placeholder="Catatan" name="txtCat[]"></textarea>' +
    "            </div>" +
    "        </div>" +
    "    </div>" +
    "</div>";
  $(".parentMFO").append(html);
  $(".remove_qi").show();
  $(".selectTgla").datepicker({
    autoclose: true,
    format: "dd-mm-yyyy",
    todayHighlight: true
  });
}
function deleteInput(ths) {
  ths.closest(".boxInput").remove();
  var count = $(".boxInput").length;
  if (count <= 1) {
    $(".remove_qi").hide();
  }
}
$('a[href^="#qw"]').click(function (e) {
  e.preventDefault();
});
$(document).ready(function () {
  // Get Code and onChange Internal
  $("#codecompMFO").select2({
    allowClear: true,
    tags: true,
    placeholder: "Component Code",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MonitoringFlowOut/InternalInput/getCode",
      dataType: "json",
      type: "GET",
      data: function (params) {
        var queryParameters = {
          term: params.term
        };
        return queryParameters;
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.ITEM,
              text: obj.ITEM
            };
          })
        };
      }
    }
  });
  // Get Code and onChange External
  $("#codecompMFO2").select2({
    allowClear: true,
    tags: true,
    placeholder: "Component Code",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MonitoringFlowOut/ExternalInput/getCode",
      dataType: "json",
      type: "GET",
      data: function (params) {
        var queryParameters = {
          term: params.term
        };
        return queryParameters;
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.ITEM,
              text: obj.ITEM
            };
          })
        };
      }
    }
  });
});
$("#codecompMFO").change(function () {
  $.ajax({
    type: "POST",
    url: baseurl + "MonitoringFlowOut/InternalInput/getNameType",
    data: {
      item: $("#codecompMFO").val()
    },
    dataType: "json",
    beforeSend: function (e) {
      if (e && e.overrideMimeType) {
        e.overrideMimeType("application/json;charset=UTF-8");
      }
    },
    success: function (response) {
      if (response.status == "success") {
        $("#ComponentName").val(response.DESCRIPTION);
        $("#Type").val(response.JENIS_BARANG);
      } else {
        alert("404 Not Found!");
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.responseText);
    }
  });
});
$("#codecompMFO2").change(function () {
  $.ajax({
    type: "POST",
    url: baseurl + "MonitoringFlowOut/ExternalInput/getNameType",
    data: {
      item: $("#codecompMFO2").val()
    },
    dataType: "json",
    beforeSend: function (e) {
      if (e && e.overrideMimeType) {
        e.overrideMimeType("application/json;charset=UTF-8");
      }
    },
    success: function (response) {
      if (response.status == "success") {
        $("#ComponentName").val(response.DESCRIPTION);
        $("#Type").val(response.JENIS_BARANG);
      } else {
        alert("404 Not Found!");
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.responseText);
    }
  });
});
// CRUD Internal
function readInternal(ths) {
  $.ajax({
    method: "GET",
    url: baseurl + "MonitoringFlowOut/InternalView/getQi/" + ths,
    dataType: "json",
    success: function (data) {
      var trHTML = "";
      $.each(data, function (i, item) {
        var pecah = item.d_date.split("-");
        var tglBruDd = pecah[2] + "-" + pecah[1] + "-" + pecah[0];
        var pecah2 = item.realisasi.split("-");
        var tglBruRr = pecah2[2] + "-" + pecah2[1] + "-" + pecah2[0];
        trHTML +=
          '<tr data="' +
          item.id +
          '">' +
          '<td style="text-align:center;">' +
          (i + 1) +
          '</td><td style="text-align:center;">' +
          tglBruDd +
          '</td><td style="text-align:center;">' +
          tglBruRr +
          '</td><td style="text-align:center;">' +
          item.pic +
          '</td><td style="text-align:center;">' +
          item.catatan +
          '</td><td class="text-center"> <button class="btn btn-danger text-center" onclick="delQiInt(' +
          item.id +
          ')"><i class="fa fa-trash"></i></button> </td></tr>';
      });
      $("#modalQi1").html(trHTML);
    }
  });
  $("#readModalInt").modal("show");
}
function delQiInt(ths) {
  $.ajax({
    method: "post",
    url: baseurl + "MonitoringFlowOut/InternalView/delQi/" + ths,
    dataType: "json",
    success: function (response) {
      if (response == 1) {
        $('tr[data="' + ths + '"]').remove();
      } else {
        r;
      }
    }
  });
}
function delInternal(ths) {
  swalWithBootstrapButtons
    .fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      reverseButtons: true
    })
    .then(result => {
      if (result.value) {
        $.ajax({
          method: "post",
          url: baseurl + "MonitoringFlowOut/InternalView/delInternal/" + ths,
          dataType: "json",
          success: function (response) {
            if (response == 1) {
              $('tr[data="' + ths + '"]').remove();
            }
          }
        });

        swalWithBootstrapButtons.fire(
          "Deleted!",
          "Your file has been deleted.",
          "success"
        );
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          "Cancelled",
          "Your imaginary file is safe :)",
          "error"
        );
      }
    });
}
// CRUD External
function readExternal(ths) {
  $.ajax({
    method: "GET",
    url: baseurl + "MonitoringFlowOut/ExternalView/getQi/" + ths,
    dataType: "json",
    success: function (data) {
      var trHTML = "";
      $.each(data, function (i, item) {
        var pecah = item.d_date.split("-");
        var tglBruDd = pecah[2] + "-" + pecah[1] + "-" + pecah[0];
        var pecah2 = item.realisasi.split("-");
        var tglBruRr = pecah2[2] + "-" + pecah2[1] + "-" + pecah2[0];
        trHTML +=
          '<tr data="' +
          item.id +
          '">' +
          '<td style="text-align:center;">' +
          (i + 1) +
          '</td><td style="text-align:center;">' +
          tglBruDd +
          '</td><td style="text-align:center;">' +
          tglBruRr +
          '</td><td style="text-align:center;">' +
          item.pic +
          '</td><td style="text-align:center;">' +
          item.catatan +
          '</td><td class="text-center"> <button class="btn btn-danger text-center" onclick="delQiExt(' +
          item.id +
          ')"><i class="fa fa-trash"></i></button> </td></tr>';
      });
      $("#modalQi2").html(trHTML);
    }
  });
  $("#readModalExt").modal("show");
}
function delQiExt(ths) {
  $.ajax({
    method: "post",
    url: baseurl + "MonitoringFlowOut/ExternalView/delQi/" + ths,
    dataType: "json",
    success: function (response) {
      if (response == 1) {
        $('tr[data="' + ths + '"]').remove();
      } else {
        r;
      }
    }
  });
}
function delExternal(ths) {
  swalWithBootstrapButtons
    .fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      reverseButtons: true
    })
    .then(result => {
      if (result.value) {
        $.ajax({
          method: "post",
          url: baseurl + "MonitoringFlowOut/ExternalView/delExternal/" + ths,
          dataType: "json",
          success: function (response) {
            if (response == 1) {
              $('tr[data="' + ths + '"]').remove();
            }
          }
        });

        swalWithBootstrapButtons.fire(
          "Deleted!",
          "Your file has been deleted.",
          "success"
        );
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          "Cancelled",
          "Your imaginary file is safe :)",
          "error"
        );
      }
    });
}
// CRUD Seksi
function crSeksi() {
  $("#crSeksi").modal("show");
}
function editSeksi(ths) {
  var nama = $("#nama" + ths).html();
  $("#editNamaId").val(ths);
  $("#editNamaSeksi").val(nama);
  $(".btnSubmitSeksi").attr("onclick", "updSeksi(" + ths + ")");
  $("#mdlSeksi").modal("show");
}
function updSeksi() {
  var id = $("#editNamaId").val();
  var nama = $("#editNamaSeksi").val();
  $.ajax({
    method: "POST",
    url: baseurl + "MonitoringFlowOut/Seksi/updSeksi",
    dataType: "json",
    data: {
      id: id,
      newNama: nama
    },
    success: function (response) {
      if (response == 1) {
        $("#nama" + id).html(nama);
        $("#mdlSeksi").modal("hide");
      } else {
        console.log("Error");
      }
    }
  });
}
function delSeksi(ths) {
  swalWithBootstrapButtons
    .fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      reverseButtons: true
    })
    .then(result => {
      if (result.value) {
        $.ajax({
          method: "post",
          url: baseurl + "MonitoringFlowOut/Seksi/delSeksi/" + ths,
          dataType: "json",
          success: function (response) {
            if (response == 1) {
              $('tr[data="' + ths + '"]').remove();
            }
          }
        });
        swalWithBootstrapButtons.fire(
          "Deleted!",
          "Your file has been deleted.",
          "success"
        );
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          "Cancelled",
          "Your imaginary file is safe :)",
          "error"
        );
      }
    });
}
// CRUD Possible Failure
function crPoss() {
  $("#crPoss").modal("show");
}
function editPoss(ths) {
  var poss = $("#poss" + ths).html();
  $("#editId").val(ths);
  $("#editPoss").val(poss);
  $("#mdlUser1").modal("show");
}
function updPoss() {
  var id = $("#editId").val();
  var poss = $("#editPoss").val();
  $.ajax({
    method: "POST",
    url: baseurl + "MonitoringFlowOut/PossibleFailure/updPoss",
    dataType: "json",
    data: {
      id: id,
      newPoss: poss
    },
    success: function (response) {
      if (response == 1) {
        $("#poss" + id).html(poss);
        $("#mdlUser1").modal("hide");
      } else {
        console.log("Error");
      }
    }
  });
}
function delPoss(ths) {
  swalWithBootstrapButtons
    .fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      reverseButtons: true
    })
    .then(result => {
      if (result.value) {
        $.ajax({
          method: "post",
          url: baseurl + "MonitoringFlowOut/PossibleFailure/delPoss/" + ths,
          dataType: "json",
          success: function (response) {
            if (response == 1) {
              $('tr[data="' + ths + '"]').remove();
            }
          }
        });
        swalWithBootstrapButtons.fire(
          "Deleted!",
          "Your file has been deleted.",
          "success"
        );
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          "Cancelled",
          "Your imaginary file is safe :)",
          "error"
        );
      }
    });
}
$(document).ready(function () {
  // Datatable Internal
  $("#MFO").DataTable({
    columnDefs: [{
      targets: "_all",
      orderable: false
    }],
    dom: "frtip",
    orderCellsTop: true,
    scrollX: true,
    scrollY: 500,
    scrollCollapse: true,
    fixedHeader: true
  });
  //Datatable External
  $("#MFO2").DataTable({
    columnDefs: [{
      targets: "_all",
      orderable: false
    }],
    dom: "frtip",
    orderCellsTop: true,
    scrollX: true,
    scrollY: 500,
    scrollCollapse: true,
    fixedHeader: true
  });

  // Datatable CAR Jatuh Tempo
  $("#MfovCAR").DataTable({
    columnDefs: [{
      targets: "_all",
      orderable: false
    }],
    dom: "frtip",
    orderCellsTop: true,
    scrollX: true,
    scrollY: 500,
    scrollCollapse: true,
    fixedHeader: true
  });

  // Datatable Seksi, Possible Failure
  $("#tNoButton").DataTable({
    autoWidth: false,
    scrollY: 500,
    scrollX: false,
    scrollCollapse: true,
    fixedHeader: true,
    dom: "frtp"
  });

  //Tagihan Car
  $("#tCar").DataTable({
    columnDefs: [{
      targets: "_all",
      orderable: false
    }],
    dom: "frtip",
    orderCellsTop: true,
    scrollX: true,
    scrollY: 500,
    scrollCollapse: true,
    fixedHeader: true
  });
});
//GRAFIK
function getGrafMFO() {
    var newblnGrafik = $('#blnGr').val().split('-');
    var monthGraf = newblnGrafik[1];
    var yearGraf = newblnGrafik[0];
    //GRAFIK UNTUK INTERNAL
    var GrafikInt = $.ajax ({
    type: "POST",
    url: baseurl + "MonitoringFlowOut/InternalView/DataGrafikMFO",
    data : {monthGraf : monthGraf, yearGraf : yearGraf},
    dataType: "JSON"
    });
    GrafikInt.success(function grafMFOInt(data) {
      $('#resultGrafMFO').removeClass('none');
      var bhsmonthGraf;
      switch(monthGraf) {
        case '01':
          var bhsmonthGraf = 'Januari';
          break;
        case '02':
          var bhsmonthGraf = 'Februari';
          break;
        case '03':
          var bhsmonthGraf = 'Maret';
          break;
        case '04':
          var bhsmonthGraf = 'April';
          break;
        case '05':
          var bhsmonthGraf = 'Mei';
          break;
        case '06':
          var bhsmonthGraf = 'Juni';
          break;
        case '07':
          var bhsmonthGraf = 'Juli';
          break;
        case '08':
          var bhsmonthGraf = 'Agustus';
          break;
        case '09':
          var bhsmonthGraf = 'September';
          break;
        case '10':
          var bhsmonthGraf = 'Oktober';
          break;
        case '11':
          var bhsmonthGraf = 'November';
          break;
        case '12':
          var bhsmonthGraf = 'Desember';
          break;
      }
      if((data.seksi).length == 0){
        $('#txtInternal').empty();
        $('#chInt').html('<center style="font-weight:bold">Grafik Data Internal pada ' + bhsmonthGraf + ' ' + yearGraf + ' tidak ada</center>');
      } else{
        var cttx1 = document.getElementById('GrafikFlowOutInt').getContext('2d');
        new Chart(cttx1, {
          type: 'bar',
          data: {
            labels: data.seksi,
            datasets: [{
              label: 'Internal',
              data: data.count,
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  userCallback: function(label, index, labels) {
                    if (Math.floor(label) === label) {
                        return label;
                    }
                },
                }
              }]
            }
          }
        });
      }

      funGrafikExt(data);
      $('.grpMnth').css("display", "none");
      $('#btnMfo').css("display", "none");
      $('#freshGraf').css("display", "");
      $('#blnGr2').html('Data Bulan ' + bhsmonthGraf + ' ' + yearGraf);
    });
    GrafikInt.error(function(XMLHttpRequest, textStatus, errorThrown){
      $('#resultGrafMFO').html('Error Found Status : ' + textStatus);
    });
    //GRAFIK UNTUK EXTERNAL
    function funGrafikExt(){
      GrafikExt = $.ajax ({
        type: "POST",
        url: baseurl + "MonitoringFlowOut/ExternalView/DataGrafikMFO",
        data : {monthGraf : monthGraf, yearGraf : yearGraf},
        dataType: "JSON",
      });
      GrafikExt.success(function (data) {
      var bhsmonthGraf;
      switch(monthGraf) {
        case '01':
          var bhsmonthGraf = 'Januari';
          break;
        case '02':
          var bhsmonthGraf = 'Februari';
          break;
        case '03':
          var bhsmonthGraf = 'Maret';
          break;
        case '04':
          var bhsmonthGraf = 'April';
          break;
        case '05':
          var bhsmonthGraf = 'Mei';
          break;
        case '06':
          var bhsmonthGraf = 'Juni';
          break;
        case '07':
          var bhsmonthGraf = 'Juli';
          break;
        case '08':
          var bhsmonthGraf = 'Agustus';
          break;
        case '09':
          var bhsmonthGraf = 'September';
          break;
        case '10':
          var bhsmonthGraf = 'Oktober';
          break;
        case '11':
          var bhsmonthGraf = 'November';
          break;
        case '12':
          var bhsmonthGraf = 'Desember';
          break;
      }
      if((data.seksi).length == 0){
        $('#txtExternal').empty();
        $('#chExt').html('<center style="font-weight:bold">Grafik Data External pada ' + bhsmonthGraf + ' ' + yearGraf + ' tidak ada</center>');
      } else{
        var cttx2 = document.getElementById('GrafikFlowOutExt').getContext('2d');
        new Chart(cttx2, {
          type: 'bar',
          data: {
            labels: data.seksi,
            datasets: [{
              label: 'External',
              data: data.count,
              backgroundColor: 'rgba(255, 159, 64, 0.2)',
              borderColor: 'rgba(255, 159, 64, 1)',
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  userCallback: function(label, index, labels) {
                    if (Math.floor(label) === label) {
                        return label;
                    }
                },
                }
              }]
            }
          }
        });
      }
      })
    }
}
$(document).ready(function () {
  if ($('.fileLamaCar').val() == '' || $('.upCar').val() == '' ) {
    $('#disDDAC').removeAttr("disabled");
    $('#disDDAC').val('');
    $('#disDDAC').attr("placeholder", "Tekan 'Backspace' agar nilai tahun tidak 1970");
    $('#disDDACEd').attr("disabled");    
  } else {
    $('#disDDAC').attr("disabled");
    $('#disDDACEd').removeAttr("disabled");
    $('#disDDACEd').val('');
    $('#disDDACEd').attr("placeholder", "Tekan 'Backspace' agar nilai tahun tidak 1970");
  }
});
$('input[type="file"][name="upCar"]').change(function(){
  $('#disDDACEd').removeAttr("disabled");
  $('#disDDACEd').val('');
  $('#disDDACEd').attr("placeholder", "Tekan 'Backspace' agar nilai tahun tidak 1970");
  $('#disDDAC').removeAttr("disabled");
  $('#disDDAC').val('');
  $('#disDDAC').attr("placeholder", "Tekan 'Backspace' agar nilai tahun tidak 1970");
})
$(document).ready(function () {
  $('#slcSeksiFAjx').select2({
    allowClear: true,
    tags: true,
    placeholder: "Pilih Seksi",
    minimumInputLength: 3,
    ajax: {
      url: baseurl + "MonitoringFlowOut/Seksi/onlySeksi",
      dataType: "JSON",
      type: "POST",
      data: function (params) {
        return {
          term: params.term
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.seksi,
              text: obj.seksi
            };
          })
        };
      }
    }
  });
})
$('#subMfo').on("click", function () {
  $('#ajaxTblInt').html('');
  var txtTglMFO1 = $('#txtTglMFO1').val();
  var txtTglMFO2 = $('#txtTglMFO2').val();
  var slcSeksiFAjx = $('#slcSeksiFAjx').val();
  var tipe = $('#mfoTipe').val();
  if (tipe == 'int'){
    $('#ajaxTblInt').html('');
    $.ajax({
      type: "POST",
      url: baseurl + "MonitoringFlowOut/InternalView/search",
      data: {txtTglMFO1 : txtTglMFO1, txtTglMFO2 : txtTglMFO2, slcSeksiFAjx : slcSeksiFAjx },
      dataType: "html",
      success: function (response) {
        $('#ajaxTblInt').html(response);
      },
      error: function (xhr) {
        alert(xhr.responseText);
      }
    });
  } else if (tipe == 'ext') {
    $('#ajaxTblExt').html('');
    $.ajax({
      type: "POST",
      url: baseurl + "MonitoringFlowOut/ExternalView/search",
      data: {txtTglMFO1 : txtTglMFO1, txtTglMFO2 : txtTglMFO2, slcSeksiFAjx : slcSeksiFAjx },
      dataType: "html",
      success: function (response) {
        $('#ajaxTblExt').html(response);
      },
      error: function (xhr) {
        alert(xhr.responseText);
      }
    });
  } else if (tipe == 'car'){
    $('#ajaxTblCar').html('');
    $.ajax({
      type: "POST",
      url: baseurl + "MonitoringFlowOut/CarJatuhTempo/search",
      data: {txtTglMFO1 : txtTglMFO1, txtTglMFO2 : txtTglMFO2, slcSeksiFAjx : slcSeksiFAjx },
      dataType: "html",
      success: function (response) {
        $('#ajaxTblCar').html(response);        
      },
      error: function (xhr) {
        alert(xhr.responseText);
      }
    });
  } else if (tipe == 'tagInt'){
    $('#ajaxTblTagInt').html('');
    $.ajax({
      type: "POST",
      url: baseurl + "MonitoringFlowOut/TagihanInternal/search",
      data: {txtTglMFO1 : txtTglMFO1, txtTglMFO2 : txtTglMFO2, slcSeksiFAjx : slcSeksiFAjx },
      dataType: "html",
      success: function (response) {
        $('#ajaxTblTagInt').html(response);        
      },
      error: function (xhr) {
        alert(xhr.responseText);
      }
    });
  } else if (tipe == 'tagExt'){
    $('#ajaxTblTagExt').html('');
    $.ajax({
      type: "POST",
      url: baseurl + "MonitoringFlowOut/TagihanExternal/search",
      data: {txtTglMFO1 : txtTglMFO1, txtTglMFO2 : txtTglMFO2, slcSeksiFAjx : slcSeksiFAjx },
      dataType: "html",
      success: function (response) {
        $('#ajaxTblTagExt').html(response);        
      },
      error: function (xhr) {
        alert(xhr.responseText);
      }
    });
  } else {
    alert("Something wrong!");
  }
});


// Last Updated : 02-09-2019