$('#tblpbi').DataTable({
  "pageLength": 10,
});

const swalRKHToastrAlert = (type, message) => {
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

const updatePBI = (doc, no) => {
  if (doc != '') {
    $.ajax({
      url: baseurl + 'PengirimanBarangInternal/Input/updatePeneriamaan',
      type: 'POST',
      dataType: 'JSON',
      async: true,
      data: {
        doc: doc,
      },
      success: function(result) {
        if (result) {
          swalRKHToastrAlert('info', 'Data Berhasil Diperbarui');
          $('tr[row-id="' + no + '"] button[id="diterima"]').attr('disabled', 'disabled');
          $('tr[row-id="' + no + '"] td center[id="status"]').html('Diterima Seksi Tujuan');
        } else {
          swalRKHToastrAlert('error', 'Gagal Memperbarui Data');
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }
}

$(document).ready(function() {
  $('.select2PBI').select2({
    minimumInputLength: 2,
    placeholder: "Employee",
    ajax: {
      url: baseurl + "PengirimanBarangInternal/Input/employee",
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
              text: `${obj.employee_name} - ${obj.employee_code}`
            }
          })
        }
      }
    }
  })

  $('.select2PBILine').select2({
    minimumInputLength: 3,
    placeholder: "Item Kode",
    ajax: {
      url: baseurl + "PengirimanBarangInternal/Input/listCode",
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
              id: obj.SEGMENT1,
              text: `${obj.SEGMENT1} - ${obj.DESCRIPTION}`
            }
          })
        }
      }
    }
  })

  if ($('#cekapp').val() === 'punyaPBI') {
    $.ajax({
      url: baseurl + 'PengirimanBarangInternal/Input/getSeksiku',
      type: 'GET',
      dataType: 'JSON',
      async: true,
      success: function(result) {
        $('#seksi_pengirim').val(result.seksi)
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }
})


const btnPlusPBI = () => {
  const cekemployee = $('#employee').val();
  console.log(cekemployee);
  if (cekemployee === null) {
    Swal.fire({
      type: 'warning',
      text: 'Harap mengisi form Seksi Tujuan terlebih dahulu!',
    })
  } else {
    let n = $('.cektable tbody tr').length;
    let a = n + 1;
    $('#tambahisi').append(`<tr class="rowbaru" id ="teer${n}">
                              <td class="text-center"><input type="text" class="form-control" name="line_number[]" value="${a}" readonly></td>
                              <td class="text-center"><select class="form-control select2PBILine" id="item_code_${a}" name="item_code[]" onchange="autofill(${a})" required></select></td>
                              <td class="text-center"><input type="text" class="form-control" id="description_${a}" name="description[]" readonly></td>
                              <td class="text-center"><input type="number" class="form-control" name="quantity[]" required></td>
                              <td class="text-center"><input type="text" class="form-control" id="uom_${a}" name="uom[]" readonly></td>
                              <td class="text-center"><input type="text" class="form-control" id="itemtype_${a}" name="item_type[]" readonly></td>
                              <td class="text-center">
                                <a class="btn btn-danger btn-sm btnpbi${a}">
                                <i class="fa fa-minus"></i>
                                </a>
                              </td>
                            </tr>`);

    $('.cektable tbody tr[id="teer' + n + '"] .select2PBILine').select2({
      minimumInputLength: 3,
      placeholder: "Item Kode",
      ajax: {
        url: baseurl + "PengirimanBarangInternal/Input/listCode",
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
                id: obj.SEGMENT1,
                text: `${obj.SEGMENT1} - ${obj.DESCRIPTION}`
              }
            })
          }
        }
      }
    });

    $(document).on('click', '.btnpbi' + a, function() {
      $(this).parents('.rowbaru').remove()
    });
  }

}

const autofill = (n) => {
  const code = $(`#item_code_${n}`).val();
  if (code != '') {
    $.ajax({
      url: baseurl + 'PengirimanBarangInternal/Input/autofill',
      type: 'POST',
      dataType: 'JSON',
      async: true,
      data: {
        code: code,
      },
      success: function(result) {
        $(`#description_${n}`).val(result[0].DESCRIPTION);
        $(`#uom_${n}`).val(result[0].PRIMARY_UOM_CODE);
        $(`#itemtype_${n}`).val(result[0].JENIS);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
    // $.ajax({  // Revisi
    //   url: baseurl + 'PengirimanBarangInternal/Input/cekComponent',
    //   type : 'POST',
    //   dataType : 'JSON',
    //   async : true,
    //   data: {
    //     code : code,
    //   },
    //   success : function(result){
    //     if (result) {
    //       Swal.fire({
    //         type: 'error',
    //         title: 'Oops...',
    //         text:  `Item Code ${code} Sudah Digunakan`,
    //       }).then(_=>{
    //         $(`#item_code_${n}`).select2("val", "");
    //         $(`#description_${n}`).val("");
    //         $(`#uom_${n}`).val("");
    //         $(`#itemtype_${n}`).val("");
    //       })
    //     }else {
    //       $.ajax({
    //         url: baseurl + 'PengirimanBarangInternal/Input/autofill',
    //         type : 'POST',
    //         dataType : 'JSON',
    //         async : true,
    //         data: {
    //           code : code,
    //         },
    //         success : function(result){
    //           $(`#description_${n}`).val(result[0].DESCRIPTION);
    //           $(`#uom_${n}`).val(result[0].PRIMARY_UOM_CODE);
    //           $(`#itemtype_${n}`).val(result[0].JENIS);
    //         },
    //         error: function(XMLHttpRequest, textStatus, errorThrown) {
    //           console.error();
    //         }
    //       })
    //     }
    //   },
    //   error: function(XMLHttpRequest, textStatus, errorThrown) {
    //     console.error();
    //   }
    // })
  }
}

const nama = _ => {
  const employee_code = $('#employee').val();
  $.ajax({
    url: baseurl + 'PengirimanBarangInternal/Input/getSeksimu',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      code: employee_code,
    },
    success: function(result) {
      $(`#seksi_tujuan`).val(result.seksi);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

const detailPBI = d => {
  $.ajax({
    url: baseurl + 'PengirimanBarangInternal/Monitoring/Detail',
    type: 'POST',
    async: true,
    data: {
      nodoc: d,
    },
    beforeSend: function() {
      $('#loading-pbi').show();
      $('#table-pbi-area').hide();
      $(`#nodoc`).html('');
    },
    success: function(result) {
      $('#table-pbi-area').show();
      $('#loading-pbi').hide();
      $(`#nodoc`).html(d);
      $(`#table-pbi-area`).html(result);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}
