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

function monitoring_ajx() {
  $.ajax({
    url: baseurl + 'PengirimanBarangInternal/Monitoring/monitoring_ajx',
    type: 'POST',
    async: true,
    beforeSend: function() {
      $('.area-pengiriman').html(`<div id="loadingArea0">
                                     <center><img style="width: 3%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                   </div>`)
    },
    success: function(result) {
      $('.area-pengiriman').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

const hapus_pbi = (no_doc) => {
  Swal.fire({
    title: 'Apakah kamu yakin?',
    text: "Anda tidak akan dapat mengembalikan ini!",
    icon: 'warning',
    showCancelButton: true,
    cancelButtonText: 'Tidak, Jangan Lakukan!',
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus itu!'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: baseurl + 'PengirimanBarangInternal/Input/delete_pbi',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          no_doc: no_doc,
        },
        beforeSend: function() {
          Swal.fire({
            onBeforeOpen: () => {
               Swal.showLoading()
             },
            text: `Sedang menghapus data...`
          })
        },
        success: function(result) {
          if (result === 1) {
            Swal.fire({
              type: 'success',
              title: 'Berhasil menghapus data dengan no document'+ no_doc,
              text: ''
            }).then(_ => {
              monitoring_ajx();
            })
          } else {
            swalRKHToastrAlert('error', 'Gagal menghapus data!');
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  })
}

const update_pbi = (no_doc) => {
  let user_tujuan = $('#employee').val()
  let keterangan = $('#keterangan').val()
  let seksi_tujuan = $('#seksi_tujuan').val()
  let no_transfer_asset = $('#no_transfer_asset').val()
  $.ajax({
    url: baseurl + 'PengirimanBarangInternal/Input/edit_pbi',
    type: 'POST',
    async: true,
    dataType:'JSON',
    data: {
      no_doc : no_doc,
      user_tujuan : user_tujuan,
      keterangan: keterangan,
      seksi_tujuan: seksi_tujuan,
      no_transfer_asset: no_transfer_asset == undefined ? '' : no_transfer_asset,
    },
    beforeSend: function() {
      Swal.fire({
        onBeforeOpen: () => {
           Swal.showLoading()
         },
        text: `Sedang memproses data...`
      })
    },
    success: function(result) {
      if (result) {
        Swal.fire({
          type: `success`,
          text: `Data telah berhasil diperbarui.`,
        }).then(_=>{
          $('#edit_pbi').modal('toggle');
          monitoring_ajx();
        })
      }else {
        Swal.fire({
          type: `danger`,
          text: `Terjadi kesalahan saat memperbarui data.`,
        })
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

const edit_pbi = (no_dok, keterangan, user_tujuan, seksi_tujuan, type, no_trans) => {
  $('.b01dqd').hide()
  $('.select2PBI').val(null)
  $('.area-edit-pbi').html('<h5>Sedang Menyiapkan Data...</h5>')
  $('#nodoc_edit').html(no_dok)
  let html = '';
  if (type == 3) {
    html = `<div class="form-group">
              <label for="tujuan">No Transfer Asset</label>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <input type="text" class="form-control" id="no_transfer_asset" name="no_transfer_asset" value="${no_trans}" autocomplete="off" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <input type="text" class="form-control" id="keterangan" name="keterangan" value="${keterangan}" autocomplete="off" required>
                  </div>
                </div>
              </div>
            </div>
            <center style="margin-bottom: 3px;">
              <button type="button" style="font-weight:bold" onclick="update_pbi('${no_dok}')" class="btn btn-success" name="button"><i class="fa fa-pencil"></i> Update</button>
            </center>`
  }else {
    html = `<div class="form-group">
              <label for="keterangan">Keterangan</label>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <input type="text" class="form-control" id="keterangan" name="keterangan" value="${keterangan}" autocomplete="off" required>
                  </div>
                </div>
              </div>
            </div>
            <center style="margin-bottom: 3px;">
              <button type="button" style="font-weight:bold" onclick="update_pbi('${no_dok}')" class="btn btn-success" name="button"><i class="fa fa-pencil"></i> Update</button>
            </center>`
  }
  $.ajax({
    url: baseurl + 'PengirimanBarangInternal/Input/employee',
    type: 'POST',
    async: true,
    dataType:'JSON',
    data: {
      term : user_tujuan,
    },
    success: function(result) {
      // console.log(result, user_tujuan);
      $('#seksi_tujuan').val(seksi_tujuan);
      var data = {
        id: user_tujuan,
        text: `${result[0].employee_name} - ${result[0].employee_code}`
      };
      var newOption = new Option(data.text, data.id, false, false);
      $('.select2PBI').html(newOption).trigger('change');
      $('.area-edit-pbi').html(html)
      $('.b01dqd').show()
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

const approve = (s, fpb) => {
  $.ajax({
    url: baseurl + 'PengirimanBarangInternal/Monitoring/updateApproval',
    type: 'POST',
    async: true,
    dataType:'JSON',
    data: {
      nodoc : fpb,
      app_stat : s
    },
    beforeSend: function() {
      Swal.fire({
        onBeforeOpen: () => {
           Swal.showLoading()
         },
        text: `Sedang memproses data...`
      })
    },
    success: function(result) {
      if (result == 1) {
        Swal.fire({
          type: `success`,
          title: `Berhasil memperbarui status ${fpb}`,
          showConfirmButton: false,
          timer: 1000
        }).then(_=>{
          if (s == 'Y') {
            $('.status_area_pbi_'+fpb).html('<span class="label label-success" style="font-size:12px;">Approved <b class="fa fa-check-circle"></b>&nbsp;</span>')
            $('.cek_status_'+fpb).html('<h3 style="color:#04b349;margin-top:-10px;"><b style="font-size:15px;">Approved!</b></h3>')
          }else {
            $('.status_area_pbi_'+fpb).html('<span class="label label-danger" style="font-size:12px;">Rejected <b class="fa fa-times-circle"></span>')
            $('.cek_status_'+fpb).html('<h3 style="color:#f22626;margin-top:-10px;"> <b style="font-size:15px">Rejected!</b></h3>')
          }
        })
      }else {
        Swal.fire({
          type: `error`,
          title: `Gagal mengupdate data ${fpb}`,
        })
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

let tableApprv = $('#tblpbiApproval').DataTable({
  "pageLength": 25,
});

function format_pbi(d, no_fpb) {
  return `<div class="detail_${no_fpb}" style="width:95%;float:right"></div>`;
}

const detailItemApproval = (no_fpb, no) => {
  let tr = $(`tr[row-pbi="${no}"]`);
  let row = tableApprv.row(tr);
  if (row.child.isShown()) {
    row.child.hide();
    tr.removeClass('shown');
  } else {
    row.child(format_pbi(row.data(), no_fpb)).show();
    tr.addClass('shown');
    $.ajax({
      url: baseurl + 'PengirimanBarangInternal/Monitoring/DetailApp',
      type: 'POST',
      async: true,
      data: {
        nodoc : no_fpb,
      },
      beforeSend: function() {
        $('.detail_' + no_fpb).html(`<div id="loadingArea0">
                                       <center><img style="width: 3%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                     </div>`)
      },
      success: function(result) {
        $('.detail_' + no_fpb).html(result)
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }
}

const insert_asset = () => {
  // action="<?php echo base_url('PengirimanBarangInternal/Input/SaveAssets') ?>"
  let type = $('#pbi_type').val();
  let tujuan = $('#pbi_tujuan').val();
  let nama_pengirim = $('#ast_nama_pengirim').val();
  let seksi_pengirim = $('#ast_seksi_pengirim').val();
  let nama_tujuan = $('#ast_employee').val();
  let seksi_tujuan = $('#ast_seksi_tujuan').val();
  let keterangan = $('#ast_keterangan').val();
  let no_transfer_asset = $('#ast_no_trans').val();
  let atasan = $('#ast_atasan').val();
  //line
  let line_number  = $('.line_number').map((_, el) => el.value).get()
  let item_code  = $('.item_code').map((_, el) => el.value).get()
  let description  = $('.description').map((_, el) => el.value).get()
  let quantity  = $('.quantity').map((_, el) => el.value).get()
  let uom  = $('.uom').map((_, el) => el.value).get()
  let item_type  = $('.item_type').map((_, el) => el.value).get()

  if (item_code[0] !== '' && seksi_tujuan[0] !== '' && atasan[0] !== '' && keterangan[0] !== '' && no_transfer_asset[0] !== '' ) {
    $.ajax({
      url: baseurl + 'PengirimanBarangInternal/Input/SaveAssets',
      type: 'POST',
      dataType: 'JSON',
      async: true,
      data: {
        nama_pengirim : nama_pengirim,
        seksi_pengirim : seksi_pengirim,
        seksi_tujuan: seksi_tujuan,
        employee_seksi_tujuan : nama_tujuan,
        tujuan : tujuan,
        no_trans : no_transfer_asset,
        type : type,
        atasan : atasan,
        //line
        line_number : line_number,
        item_code : item_code,
        description : description,
        quantity : quantity,
        uom : uom,
        item_type : item_type,
        keterangan : keterangan
      },
      beforeSend: function () {
        Swal.fire({
          onBeforeOpen: () => {
             Swal.showLoading()
           },
          text: `Sedang memproses data...`
        })
      },
      success: function(result) {
        // console.log(result);
        if (result.res == 1) {
          Swal.fire({
            type: `success`,
            title: `Data telah berhasil disimpan !`,
            showConfirmButton: false,
            timer: 1000
          }).then(_=>{
            $.ajax({
              url: baseurl + 'PengirimanBarangInternal/Input/SendEmail',
              type: 'POST',
              dataType: 'JSON',
              async: true,
              data: {
                no_trans : no_transfer_asset,
                atasan : atasan,
                fpb : result.fpb,
                tujuan : tujuan,
                seksi_tujuan: seksi_tujuan,
                employee_seksi_tujuan : nama_tujuan,
                //line
                line_number : line_number,
                item_code : item_code,
                description : description,
                quantity : quantity,
                uom : uom,
                item_type : item_type,
                keterangan : keterangan
              },
              beforeSend: function () {
                Swal.fire({
                  onBeforeOpen: () => {
                     Swal.showLoading()
                   },
                  text: `Sedang mengirim email approval ke atasan (${atasan})`
                })
              },
              success: function(res) {
                if (res == 'Message sent!') {
                  Swal.fire({
                    type: `success`,
                    title: `FPB berhasil dibuat. Silahkan minta approval atasan terlebih dahulu.`,
                  }).then(_=>{
                    function openWindows(){
                        window.location.replace(baseurl+'PengirimanBarangInternal/Input');
                        window.open(baseurl+'PengirimanBarangInternal/Cetak/'+result.fpb);
                    }
                    openWindows();
                  })
                }else {
                  Swal.fire({
                    type: `error`,
                    title: `Opss !`,
                    title: `Gagal Mengirim Email Approval, Cek Koneksi Anda!`,
                  })
                }
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.error();
              }
            })
          })
        }else {
          Swal.fire({
            type: `error`,
            title: `Opss !`,
            title: `Gagal melakukan insert data`,
          })
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }else {
    Swal.fire({
      type: `error`,
      title: `Harap mengisi data dengan lengkap!`,
    })
  }

}

const ast_autofill = (n) => {
  const code = $(`#ast_item_code_${n}`).val();
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
          $(`#ast_description_${n}`).val(code);
          $(`#ast_uom_${n}`).val('PCS');
          $(`#ast_itemtype_${n}`).val('LAIN-LAIN');
        }else {
          $(`#ast_description_${n}`).val(result[0].DESCRIPTION);
          $(`#ast_uom_${n}`).val(result[0].PRIMARY_UOM_CODE);
          $(`#ast_itemtype_${n}`).val(result[0].JENIS);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }
}

const ast_btnPlusPBI = () => {
  const cekemployee = $('#ast_employee').val();
  console.log(cekemployee);
  if (cekemployee === null) {
    Swal.fire({
      type: 'warning',
      text: 'Harap mengisi form Seksi Tujuan terlebih dahulu!',
    })
  } else {
    let n = $('.ast_cektable tbody tr').length;
    let a = n + 1;
    $('#ast_tambahisi').append(`<tr class="rowbaru" id ="ast_teer${n}">
                              <td class="text-center"><input type="text" class="form-control line_number" name="line_number[]" value="${a}" readonly></td>
                              <td class="text-center"><select class="form-control select2PBILine item_code" id="ast_item_code_${a}" name="item_code[]" onchange="ast_autofill(${a})" style="text-transform:uppercase;width:210px !important;" required>
                              <option selected="selected"></option>
                              </select></td>
                              <td class="text-center"><input type="text" class="form-control description" id="ast_description_${a}" name="description[]" readonly></td>
                              <td class="text-center"><input type="number" class="form-control quantity" name="quantity[]" autocomplete="off" required></td>
                              <td class="text-center"><input type="text" class="form-control uom" id="ast_uom_${a}" name="uom[]" readonly></td>
                              <td class="text-center"><input type="text" class="form-control item_type" id="ast_itemtype_${a}" name="item_type[]" readonly></td>
                              <td class="text-center">
                                <a class="btn btn-danger btn-sm ast_btnpbi${a}">
                                <i class="fa fa-minus"></i>
                                </a>
                              </td>
                            </tr>`);

    $('.ast_cektable tbody tr[id="ast_teer' + n + '"] .select2PBILine').select2({
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

    $(document).on('click', '.ast_btnpbi' + a, function() {
      $(this).parents('.rowbaru').remove()
    });
  }

}

const ast_nama = _ => {
  const employee_code = $('#ast_employee').val();
  $.ajax({
    url: baseurl + 'PengirimanBarangInternal/Input/getSeksimu',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      code: employee_code,
    },
    success: function(result) {
      $(`#ast_seksi_tujuan`).val(result.seksi);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}


$('#tblpbi').DataTable({
  "pageLength": 10,
});


const summitpbiarea1 = () => {
  let st = $('#seksi_tujuan').val();
  let ket = $('#ket').val();
  let item_code_1 = $('#item_code_1').val();
  let qty = $('#quantity_1').val();
  // console.log(qty);
  // console.log(item_code_1);
  if (st !== '' && ket !== '' && item_code_1 !== '' && qty !== '') {
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
  let pbi_cek_monitoring = $('#cek-pbi-pengiriman').val();
  if (pbi_cek_monitoring == 'ok') {
    monitoring_ajx();
  }
  $('.ast_select2PBI').select2({
    placeholder: "Atasan",
    ajax: {
      url: baseurl + "PengirimanBarangInternal/Input/atasan_employee",
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
              id: obj.noind,
              text: `${obj.nama} - ${obj.noind}`
            }
          })
        }
      }
    }
  })

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
        $('#ast_seksi_pengirim').val(result.seksi)
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
