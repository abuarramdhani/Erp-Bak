$(document).ready(() => {
  // Data Table
  $('#aksesList').DataTable();
  // Select2 Live Search
  $('.select-pekerja').select2({
    ajax: {
      url: 'HakAksesPresensiHarian/ajax/showPekerja',
      dataType: 'json',
      method: 'GET',
      data: (a) => {
        return {
          key: a.term,
        }
      },
      processResults: (data) => {
        return {
          results: $.map(data, (item) => {
            return {
              id: item.noind,
              text: item.noind + " - " + item.nama,
            }
          })
        }
      },
    },
    minimumInputLength: 2,
    placeholder: "Silahkan pilih",
    allowClear: true,
  })

  $('.select-seksi').select2({
    ajax: {
      url: 'HakAksesPresensiHarian/ajax/showSeksi',
      dataType: 'json',
      method: 'GET',
      data: (a) => {
        return {
          key: a.term.toUpperCase(),
        }
      },
      processResults: (data) => {
        return {
          results: $.map(data, (item) => {
            return {
              id: item.kodesie + "-" + item.seksi,
              text: item.kodesie + " - " + item.seksi,
            }
          }),
        }
      },
    },
    minimumInputLength: 2,
    placeholder: "Silahkan pilih",
    allowClear: true,
  })

  // Utilities
  const btnDel = () => {
    $('.del-row').each(function () {
      $(this).on('click', function () {
        $(this).parents('tr').remove()
      })
    })
  }
  const clearModal = () => {
    $('#tableAkses').html("")
    $("#deleteSeksi").hide()
    $('.select-pekerja').prop('disabled', false)
    $('.select-pekerja').select2('val', '')
    $('.select-pekerja').attr('id', 'select-pekerja-add')
  }
  const fixIndex = () => {
    let index = 1
    $('#tableAkses > tr').each(function () {
      $(this).find('td:eq(0)').text(index++)
    })
  }

  $('#add-akses-pekerja').on('click', () => {
    clearModal()
  })

  // Show Akses
  $('.detailAkses').on('click', function () {
    $('.select-pekerja').prop('disabled', true)
    $("#deleteSeksi").show()

    let noind = $(this).data("noind");
    let nama = $(this).data("nama");

    let option = $("<option selected></option>")
      .val(noind)
      .text(noind + " - " + nama);

    $('.select-pekerja').append(option).trigger('change')

    $.ajax({
      url: 'HakAksesPresensiHarian/ajax/showAkses',
      beforeSend: () => {
        $("#tableAkses").html('<tr><td colspan="4"><center>loading...</center></td></tr>');
      },
      method: 'GET',
      dataType: "json",
      data: {
        noind: noind
      },
      success: (res) => {
        $('#namaPekerja').attr('value', res.nama)
        let tableRow;
        let indexRow = 1;
        res.forEach((row) => {
          tableRow += `
    				<tr>
    					<td>${indexRow++}</td>
    					<td>${row.kodesie}</td>
    					<td>${row.seksi}</td>
    					<td><button class="btn btn-danger btn-sm del-row"><i class="fa fa-minus"></i></button></td>
    				</tr>
          `
        })
        $('#tableAkses').html(tableRow)
        btnDel()
      },
    })
  })

  // Add Akses 
  $('.add-akses').on('click', () => {
    let kodesie = $('.select-seksi').val()
    let pekerja = $('.select-pekerja').val()

    if (kodesie == null) {
      swal.fire("Isi Seksi terlebih dahulu", "", "warning")
      return
    }
    if (pekerja == null) {
      swal.fire("Isi perkerja terlebih dahulu", "", "warning")
      return
    }

    let existedSie = []
    $('#tableAkses > tr').each(function () {
      let siekode = $(this).find('td:eq(1)').text().trim()
      existedSie.push(siekode)
    })

    kodesieNum = kodesie.split('-')[0]
    deptName = kodesie.split('-')[1]
    pekerjaName = pekerja.split('-')[1]

    if (existedSie.includes(kodesieNum)) {
      swal.fire('Seksi Sudah Ada', '', 'warning')
      return
    }

    let index = 1;
    let aksesSeksi = `
      <tr>
        <td>${index++}</td>
        <td>${kodesieNum}</td>
        <td>${deptName}</td>
        <td><button class="btn btn-danger btn-sm del-row"><i class="fa fa-minus"></i></button></td>
      </tr>
    `
    $('#tableAkses').append(aksesSeksi)
    fixIndex()
    btnDel()
  })

  // Save Akses
  $('.btn-save').on('click', () => {
    let noind = $('.select-pekerja').val().split('-')[0]

    if ($('#tableAkses').children().length === 0) {
      swal.fire("Akses Masih Kosong", "", "warning")
      return false
    }

    // $.ajax({
    //   url: 'HakAksesPresensiHarian/ajax/getNoind',
    //   method: 'GET',
    //   dataType: 'json',
    //   success: (res) => {
    //     if (res.indexOf(noind) > -1) {
    //       swal.fire("Pekerja Sudah Mempunyai Hak Mohon Edit Hak Pekerja", "", "warning")
    //       return false
    //     }
    //   }
    // })

    let kodesie = []
    $('#tableAkses > tr').each(function () {
      let siekode = $(this).find('td:eq(1)').text().trim()
      kodesie.push(siekode)
    })

    $.ajax({
      url: 'HakAksesPresensiHarian/ajax/addAkses',
      method: 'POST',
      dataType: 'json',
      data: {
        noind: noind,
        kodesie: JSON.stringify(kodesie)
      },
      success: (res) => {
        swal.fire("Data Berhasil Disimpan", "", "success").then((res) => location.reload())
      },
    })
  })

  $('.hapus-akses').on('click', () => {
    let noind = $('.select-pekerja').val().split('-')[0]

    swal.fire({
      title: "Yakin untuk menghapus akses ?",
      text: "Akses akun akan terhapus",
      type: "warning",
      showCancelButton: !0,
    }).then((res) => {
      if (res.value) {
        $.ajax({
          url: 'HakAksesPresensiHarian/ajax/deleteAkses',
          method: 'POST',
          data: {
            noind: noind
          },
          success: (res) => {
            console.log(res)
            swal.fire('Success Menghapus Data', '', 'success').then(location.reload())
          }
        })
      }
    })
  })
})
