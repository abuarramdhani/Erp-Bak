// ==================alert==================

const swalMSJToastrAlert = (type, message) => {
  Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  }).fire({
    customClass: 'swal-font-small',
    type: type,
    title: message
  })
}

const swalMSJ = (type, title) => {
  Swal.fire({
    type: type,
    title: title,
    text: ''
  })
}

// ==================/alert===================

let tblmsj = $('#tblmsj').DataTable({
  // scrollY: "350px",
  // paging: false,
  columnDefs: [{
    orderable: false,
    className: 'select-checkbox',
    targets: 1
  }],
  select: {
    style: 'multi',
    selector: 'td:nth-child(2)'
  },
  order: [
    [0, 'asc']
  ],
  initComplete: function () {
      this.api().columns([5]).every( function () {
          var column = this;
          var select = $('#tujuan_isj')
              .on('change', function () {
                  var val = $.fn.dataTable.util.escapeRegex(
                      $(this).val()
                  );
                  column
                      .search(val)
                      .draw();
              } );
      } );
  }
});

const setMSJ2 = () => {

  var get = tblmsj.rows({
    selected: true
  }).data()
  var getDataMSJ = []

  for (var i = 0; i < get.length; i++) {
    getDataMSJ.push(tblmsj.rows({
      selected: true
    }).data()[i])
  }

  let tampung_setMSJ2 = [];
  getDataMSJ.forEach((v, i) => {
    tampung_setMSJ2.push(v[2])
  })

  $.ajax({
    url: baseurl + 'MonitoringSuratJalan/TerimaFPB/Update2',
    type: 'POST',
    async: true,
    dataType: 'JSON',
    data: {
      nodoc: tampung_setMSJ2,
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      console.log(result);
      if (result) {
        tblmsj.rows().deselect();
        getDataMSJ.forEach((v, i) => {
          $('tr[row-id="' + v[0] + '"]').addClass("disabled");
          $('tr[row-id="' + v[0] + '"] td:nth-child(2)').attr('onClick','gaole(' + v[0] + ')');
        })
        swalMSJ('success', 'Selesai.')
      } else {
        swalMSJ('error', 'Terdapat Kesalahan.')
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })

}

const gaole = (tr) => {
  swalMSJ('error', '')
  Swal.fire({
    type: 'error',
    title: 'No FPB Sudah Digunakan Sebelumnya.',
    timer: 1500,
    showConfirmButton  : false
  }).then(_ =>{
    $('tr[row-id="' + tr + '"]').removeClass("selected")
  })
}

const checked_msj = () => {
  console.log('aaaa');
  if ($('tr[data="msj_header"] input[id="check-all-msj"]').iCheck('check')) {
    tblmsj.rows().select();
  } else if ($('tr[data="msj_header"] input[id="check-all-msj"]').iCheck('uncheck')) {
    tblmsj.rows().deselect();
  }
}

const setMSJ3 = () => {
  const dari = $('#dari').val();
  const ke = $('#tujuan_isj').val();
  const jn = $('#jenis_kendaraan').val();
  const sopir_name = $('#nama_sopir').val();
  const sopir_ind = $('#noind_sopir').val();
  const plat = `${$('#plat1').val()} ${$('#plat2').val()} ${$('#plat3').val()}`

  if (dari !== '' && ke !== '' && jn !== '') {

    if (sopir_name != '' && sopir_ind != '' && $('#plat1').val() != '' && $('#plat2').val() != '' && $('#plat3').val() != '') {

      var get = tblmsj.rows({
        selected: true
      }).data()
      var getDataMSJ = []

      for (var i = 0; i < get.length; i++) {
        getDataMSJ.push(tblmsj.rows({
          selected: true
        }).data()[i])
      }

      let tampung_setMSJ2 = [];
      getDataMSJ.forEach((v, i) => {
        tampung_setMSJ2.push(v[2])
      })

      $.ajax({
        url: baseurl + 'MonitoringSuratJalan/InputSuratJalan/Update3',
        type: 'POST',
        async: true,
        dataType: 'JSON',
        data: {
          nodoc: tampung_setMSJ2,
          dari: dari,
          ke: ke,
          jn: jn,
          sopir_name: sopir_name,
          sopir_ind: sopir_ind,
          plat: plat
        },
        beforeSend: function() {
          Swal.showLoading()
        },
        success: function(result) {
          console.log(result);
          if (result) {
            tblmsj.rows().deselect();
            getDataMSJ.forEach((v, i) => {
              $('tr[row-id="' + v[0] + '"]').addClass("disabled");
              $('tr[row-id="' + v[0] + '"] td:nth-child(2)').attr('onClick','gaole(' + v[0] + ')');
            })
            swalMSJ('success', 'Selesai.')
          } else {
            swalMSJ('error', 'Terdapat Kesalahan.')
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      }).done(_ => {
        $('#noind_sopir').select2("val", "");
        $('#nama_sopir').val('');
        $('#plat1').val('')
        $('#plat2').val('')
        $('#plat3').val('')
      })

    } else {
      swalMSJ('error', 'Harap isi form data secara lengkap terlebih dahulu.')
    }
  } else {
    swalMSJ('error', 'Form input Lokasi Pengirim, Tujuan dan Jenis Kendaraaan Tidak Boleh Kosong.')
  }
}

const detailMSJ = d => {
  $.ajax({
    url: baseurl + 'MonitoringSuratJalan/TerimaFPB/Detail',
    type: 'POST',
    async: true,
    data: {
      nodoc: d,
    },
    beforeSend: function() {
      $('#loading-msj').show();
      $('#table-msj-area').hide();
      $(`#nodoc_msj`).html('');
    },
    success: function(result) {
      $('#table-msj-area').show();
      $('#loading-msj').hide();
      $(`#nodoc_msj`).html(d);
      $(`#table-msj-area`).html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

const detailSJ = j => {
  $.ajax({
    url: baseurl + 'MonitoringSuratJalan/Monitoring/Detail_SJ',
    type: 'POST',
    async: true,
    data: {
      no_sj: j,
    },
    beforeSend: function() {
      $('#loading-msj').show();
      $('#table-msj-area').hide();
      $(`#nodoc_msj`).html('');
    },
    success: function(result) {
      $('#table-msj-area').show();
      $('#loading-msj').hide();
      $(`#nodoc_msj`).html(j);
      $(`#table-msj-area`).html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

const nama_msj = () => {
  const noind = $('#noind_sopir').val();
  $.ajax({
    url: baseurl + 'MonitoringSuratJalan/InputSuratJalan/getName',
    type: 'POST',
    dataType: 'JSON',
    data: {
      noind: noind,
    },
    success: function(result) {
      $('#nama_sopir').val(result[0].employee_name)
      if ($('#no_induk')) {
        $('#no_induk').val(result[0].employee_code)
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

$(document).ready(function() {
  $('.select2MSJ').select2({
    minimumInputLength: 2,
    placeholder: "Nama Sopir",
    ajax: {
      url: baseurl + "MonitoringSuratJalan/InputSuratJalan/Employee",
      dataType: "JSON",
      type: "POST",
      data: function(params) {
        return {
          term: params.term
        };
      },
      processResults: function(data) {
        return {
          results: $.map(data, function(obj) {
            return {
              id: obj.employee_code,
              text: `${obj.employee_code} - ${obj.employee_name}`
            }
          })
        }
      }
    }
  })
})

const editSJ = (sj, no) => {
  $('#nosj_msj').html(sj);
  $.ajax({
    url: baseurl + 'MonitoringSuratJalan/Monitoring/getEdit',
    type: 'POST',
    dataType: 'JSON',
    data: {
      sj: sj,
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      Swal.close()
      let plat = result[0].PLAT_NUMBER;
      let split_plat = plat.split(' ');
      let option = `<option value="${result[0].NO_INDUK}" selected>${result[0].NO_INDUK} - ${result[0].NAMA_SUPIR}</option>`

      $('#noind_sopir').html(option).trigger('change')
      $('#nama_sopir').val(result[0].NAMA_SUPIR)
      $('#no_induk').val(result[0].NO_INDUK)
      $('#plat1').val(split_plat[0])
      $('#plat2').val(split_plat[1])
      $('#plat3').val(split_plat[2])
      $('#row').val(no)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

const updateSJ = _ => {
  const no_sj = $('#nosj_msj').html();
  const nama_sopir = $('#nama_sopir').val();
  const no_induk = $('#no_induk').val();
  const plat = `${$('#plat1').val()} ${$('#plat2').val()} ${$('#plat3').val()}`;
  $.ajax({
    url: baseurl + 'MonitoringSuratJalan/Monitoring/updateSJ',
    type: 'POST',
    dataType: 'JSON',
    data: {
      no_sj: no_sj,
      nama_sopir: nama_sopir,
      noind_sopir: no_induk,
      plat: plat,
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      if (result) {
        swalMSJ('success', 'Berhasil Update.')
        $(`tr[row="${$('#row').val()}"] td[id="sopir_up"] center`).html(nama_sopir)
        $(`tr[row="${$('#row').val()}"] td[id="plat_up"] center`).html(plat.toUpperCase())
      } else {
        swalMSJ('error', 'Terjadi Kesalahan.')
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  }).done(_ => {
    $('#editmsj').modal('hide');
    console.log('hai');
  })
}
