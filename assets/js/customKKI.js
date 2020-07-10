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

const summitpbiarea1 = () => {
  Swal.fire({
    onBeforeOpen: () => {
       Swal.showLoading()
     },
    text: 'Sedang Memproses Data...',
    timer: 500,
  }).then(_=>{
    Swal.fire({
      type: `success`,
      text: `Data telah berhasil disimpan !`,
    })
  })
}

const summitpbiarea = () => {
  Swal.fire({
    onBeforeOpen: () => {
       Swal.showLoading()
     },
    text: 'Sedang Memproses Data...'
  })
  let ket = $('#inv_keterangan').val();
  if (ket == '') {
    Swal.fire({
      type: 'warning',
      text: `Form keterangan tidak boleh kosong`,
    })
  }
}

const cek_aga_ga_monya = () => {
  // let mo = $('#kki_mo').val();
  // let mo_terakhir = mo.slice(-1).pop();
  //

}

$('.select2MO_PBI').on('select2:unselect', function (e) {
    let data = e.params.data.text;
    $(`.${data}`).remove();
});

const submitMO = () => {
 let mo = $('#kki_mo').val();
 $('#inv_tambahisi').html('');
 $.ajax({
   url: baseurl + 'PengirimanBarangInternal/Input/cek_no_mo',
   type: 'POST',
   dataType: 'JSON',
   async: true,
   data: {
     mo: mo,
   },
   beforeSend: function() {
     Swal.fire({
       onBeforeOpen: () => {
          Swal.showLoading()
        },
       text: 'Sedang Mengecek data'
     }).then(()=>{
       $('.error_ga_ini').html(``)
     })
   },
   success: function(result) {
     console.log(result);
     if (result.status == 0) {
       Swal.fire({
         type: 'error',
         text: `Detail MO ${result.mo} telah ada di database.`,
       })
     }else {
       mo.forEach((vv,i) =>{
         $.ajax({
           url: baseurl + 'PengirimanBarangInternal/Input/getDetailMo',
           type: 'POST',
           dataType: 'JSON',
           async: true,
           data: {
             mo: vv,
           },
           beforeSend: function() {
             Swal.fire({
               onBeforeOpen: () => {
                  Swal.showLoading()
                },
               text: 'Sedang Mengambil data'
             }).then(()=>{
               $('.error_ga_ini').html(``)
             })
           },
           success: function(result) {
             if (result !== 0) {
               Swal.close();
               // Swal.fire({
               //   type: 'success',
               //   text: `Selesai.`,
               // }).then(()=>{
                 // $('#inv_nama_pengirim').val(result[0].FROM_IO);
                 // $('#inv_seksi_pengirim').val(result[0].FROM_SUBINVENTORY_CODE);
                 // $('#inv_employee').val(result[0].TO_IO);
                 // $('#inv_seksi_tujuan').val(result[0].TO_SUBINVENTORY_CODE);
                 let hhtml = [];
                 let n = Number($('.inv_cektable tbody tr').length) + 1;
                 result.forEach((v,i) =>{
                   a = i+n;
                   ht = `<tr class="rowbaru ${vv}" id ="inv_teer1${a}">
                           <td class="text-center"><input type="text" class="form-control" name="line_number[]" value="${a}" readonly></td>
                           <td class="text-center"><input type="text" class="form-control" id="inv_item_code_${a}" value="${v.SEGMENT1}" name="item_code[]" readonly></td>
                           <td class="text-center"><input type="text" class="form-control" id="inv_description_${a}" value="${v.DESCRIPTION}" name="description[]" readonly></td>
                           <td class="text-center"><input type="number" class="form-control" name="quantity[]" value="${v.QUANTITY}" autocomplete="off" readonly></td>
                           <td class="text-center"><input type="text" class="form-control" id="inv_uom_${a}" value="${v.UOM_CODE}" name="uom[]" readonly></td>
                           <td class="text-center">
                            <input type="text" class="form-control" id="inv_itemtype_${a}" value="${v.JENIS}" name="item_type[]" readonly>
                            <input type="hidden" class="form-control" id="inv_mo_${a}" value="${vv}" name="item_mo[]" readonly>
                            <input type="hidden" class="form-control" value="${v.FROM_IO}" name="nama_pengirim[]" readonly>
                            <input type="hidden" class="form-control" value="${v.FROM_SUBINVENTORY_CODE}" name="seksi_pengirim[]" readonly>
                            <input type="hidden" class="form-control" value="${v.TO_IO}" name="employee_seksi_tujuan[]" readonly>
                            <input type="hidden" class="form-control" value="${v.TO_SUBINVENTORY_CODE}" name="seksi_tujuan[]" readonly>
                           </td>
                         </tr>`;
                         hhtml.push(ht);
                 })
                 let html = hhtml.join(' ');
                 $('#inv_tambahisi').append(html);
               // })
             } else {
               Swal.fire({
                 type: 'error',
                 text: `Detail MO ${vv} tidak ditemukan di database.`,
               })
             }
           },
           error: function(XMLHttpRequest, textStatus, errorThrown) {
             console.error();
           }
         })
       })
     }
   },
   error: function(XMLHttpRequest, textStatus, errorThrown) {
     console.error();
   }
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
      beforeSend: function() {
        Swal.showLoading()
      },
      success: function(result) {
        if (result) {
          Swal.close();
          Swal.fire({
            type: 'success',
            title: `FPB berhasil diterima!!!`,
            text: ''
          }).then(_ => {
            location.reload();
          })
        } else {
          Swal.fire({
            type: 'error',
            title: `Gagal Memperbarui Data.`,
            text: ''
          })
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }
}

$(document).ready(function() {
  $('.select2MO_PBI').select2({
    tags: true,
    tokenSeparators: [',', ' ']
  })

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
    tags: true,
    allowClear:true,
    minimumInputLength: 3,
    placeholder: "Item Kode",
    ajax: {
      url: baseurl + "PengirimanBarangInternal/Input/listCode",
      dataType: "JSON",
      type: "POST",
      data: function(params) {
        return {
          term: params.term,
        };
      },
      processResults: function(data) {
        return {
          results: $.map(data, function(obj) {
            return {
              id: obj.SEGMENT1==''?params.term:obj.SEGMENT1,
              text: obj.SEGMENT1==''?params.term:`${obj.SEGMENT1} - ${obj.DESCRIPTION}`,
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
                              <td class="text-center"><select class="form-control select2PBILine" id="item_code_${a}" name="item_code[]" onchange="autofill(${a})" style="text-transform:uppercase;width:210px !important;" required>
                              <option selected="selected"></option>
                              </select></td>
                              <td class="text-center"><input type="text" class="form-control" id="description_${a}" name="description[]" readonly></td>
                              <td class="text-center"><input type="number" class="form-control" name="quantity[]" autocomplete="off" required></td>
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
      tags: true,
      createSearchChoice: function(term, data) {
        if ($(data).filter(function() {
          return this.text.localeCompare(term) === 0;
        }).length === 0) {
          return {
            id: obj.SEGMENT1,
            text: `${obj.SEGMENT1} - ${obj.DESCRIPTION}`
          };
        }
      },
      ajax: {
        url: baseurl + "PengirimanBarangInternal/Input/listCode",
        dataType: "JSON",
        type: "POST",
        tags: true,
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
        if (result == 0) {
          $(`#description_${n}`).val(code);
          $(`#uom_${n}`).val('PCS');
          $(`#itemtype_${n}`).val('LAIN-LAIN');
        }else {
          $(`#description_${n}`).val(result[0].DESCRIPTION);
          $(`#uom_${n}`).val(result[0].PRIMARY_UOM_CODE);
          $(`#itemtype_${n}`).val(result[0].JENIS);
        }
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
