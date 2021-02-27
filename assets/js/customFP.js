const toastFP = (type, message) => {
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
const swalFP = (type, title) => {
  Swal.fire({
    type: type,
    title: title,
    text: ''
  })
}
const toastFPLoading = (pesan) => {
  Swal.fire({
    toast: true,
    position: 'top-end',
    onBeforeOpen: () => {
       Swal.showLoading();
       $('.swal2-loading').children('button').css({'width': '20px', 'height': '20px'})
     },
    text: pesan
  })
}

let fp_ajax1 = null
let fp_ajax2 = null
let fp_ajax_memo = null
let fp_ajax_memo_1 = null
let fpGetComp__ = null;
let fpGetProsesBy__ = null;
// Swal.showLoading()

const fp_isi_uom = (no) =>{
  let mesplit = $('.fp_get_uom_'+no).val().split(' - ');
  $('.fp_uom_hia_'+no).val(mesplit[2])
}

const fp_bp_plus_proses = () => {
  	let n = $(`.fp_tbl_penolong tr`).length;
    let no = Number(n);
  $('.fp_tbl_penolong tbody').append(`<tr row-id="${no}">
                                <td style="text-align:center;vertical-align:middle;width:5%">${no}</td>
                                <td style="width:70%">
                                  <select class="form-control select2FP_Oracle_Second fp_bp_component_code fp_get_uom_${no}" onchange="fp_isi_uom(${no})" style="width:100%" required>
                                    <option value="" selected>Component Code ...</option>
                                  </select>
                                </td>
                                <td style="width:15%">
                                  <input type="number" placeholder="QTY" class="form-control fp_bp_qty" value="">
                                </td>
                                <td style="width:25%">
                                  <input type="text" placeholder="UOM" class="form-control fp_uom_hia_${no}" readonly value="">
                                </td>
                                <td style="vertical-align:middle">
                                  <center><button type="button" name="button" class="btn btn-sm" onclick="fp_bp_minus_proses(${no})"><i class="fa fa-minus-square"></i></button></center>
                                </td>
                              </tr>`)
      $('.select2FP_Oracle_Second').select2({
      minimumInputLength: 3,
      placeholder: "Select Oracle Item",
      ajax: {
        url: baseurl + "FlowProses/SetOracleItem/getOracleItemPenolong",
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
                id: `${obj.SEGMENT1} - ${obj.DESCRIPTION} - ${obj.PRIMARY_UOM_CODE}`,
                text: `${obj.SEGMENT1} - ${obj.DESCRIPTION}`
              }
            })
          }
        }
      }
    })
}

const fp_bp_minus_proses = (no) => {
  $(`.fp_tbl_penolong tr[row-id="${no}"]`).remove();
}

// $('#jenis_proses').on('change', function () {
//   let val = $(this).val();
//   console.log(val);
//   $('#nomor_jenis_proses').val(null)
//   if (val == 'PCR' || val == 'ECR') {
//     $('#fp_1').removeClass("col-md-12");
//     $('#fp_1').addClass("col-md-6");
//     $('#fp_njpnya').html(val)
//     // $('#fp_1').toggleClass('col-md-6')
//     $('.fp_2').fadeIn()
//   }else {
//     $('#fp_1').removeClass("col-md-6");
//     $('#fp_1').addClass("col-md-12");
//     $('.fp_2').hide()
//   }
// })

$('#fp_tipe_produk_memo').on('change', function () {
  $('#product_fp_memo').val(null).trigger('change')
  let myval = $(this).val();
  if (fp_ajax_memo_1 != null) {
    fp_ajax_memo_1.abort()
  }
  fp_ajax_memo_1 = $.ajax({
    url: baseurl + "FlowProses/Memo/getComponentMemoProduct",
    type: 'POST',
    // dataType: 'JSON',
    data: {
      type: myval,
    },
    beforeSend: function() {
      $('#table-area-memo-fp').html(`<div id="loadingArea0">
                                          <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Please be patient..</center>
                                        </div>`);
    },
    success: function(result) {
      if (result !== null) {
        $('#table-area-memo-fp').html(result)
      }else {
        swalFP('warning', `Something was wrong when fetching data`);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      // swalFP('error', 'Something was wrong when fetching data, please try again...')
     console.error();
    }
  })
})

const cek_memo_component = (memo, id, type) => {
  if (fp_ajax_memo != null) {
    fp_ajax_memo.abort();
  }
  $('#fp_memo').html(memo)
  fp_ajax_memo = $.ajax({
    url: baseurl + "FlowProses/Memo/getComponentMemo",
    type: 'POST',
    // dataType: 'JSON',
    data: {
      memo: memo,
      memo_id: id,
      type:type
    },
    beforeSend: function() {
      $('.fp-area-memo').html(`<div id="loadingArea0">
                                          <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Loading..</center>
                                        </div>`);
    },
    success: function(result) {
      if (result !== null) {
        $('.fp-area-memo').html(result)
      }else {
        swalFP('warning', `Data is empty with memo number ${memo}`);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      // swalFP('error', 'Something was wrong when fetching data...')
     console.error();
    }
  })
}

// const fp_isi_machine_num = () => {
//   let code = $('#resource').val();
//   // let spl = code.split(' - ');
//   // $('#machine_num').val(spl[1])
//   if (code != null) {
//     fp_ajax1 = $.ajax({
//       url: baseurl + "FlowProses/Operation/getMachineNum",
//       type: 'POST',
//       dataType: 'JSON',
//       data: {
//         code: code,
//         destination: $('#destination').val(),
//       },
//       beforeSend: function() {
//         $('#machine_num').val('...')
//
//       },
//       success: function(result) {
//
//         if (result !== null) {
//           let tampong = [];
//           $.each(result, function(index, elem) {
//             let spl = elem.ATTRIBUTE1.split(' - ');
//             tampong.push(spl[1])
//           });
//           $('#machine_num').val(tampong.join(', '))
//         }else {
//           $('#machine_num').val('')
//         }
//
//       },
//       error: function(XMLHttpRequest, textStatus, errorThrown) {
//         // swalFP('error', 'Something was wrong when fetching data...')
//         $('#machine_num').val('')
//        console.error();
//       }
//     })
//   }
//
// }

// const fp_cek_destinasi = () => {
//   let fp_cek = $('#machine_req :selected').text();
//   let fp_flag_value = fp_cek.split(' - ');
//   // console.log(fp_cek);console.log($('#destination').val());
//
//   if (fp_cek != 'Select...' && $('#destination').val() != '') {
//   $('#resource').val(null).trigger('change')
//   //
//   if (fp_ajax2 !=  null) {
//     fp_ajax2.abort()
//     $('.resource_loading_area').html('')
//     $('#foresource').show()
//   }
//
//   fp_ajax2 = $.ajax({
//     url: baseurl + "FlowProses/Operation/getResource",
//     type: 'POST',
//     dataType: 'JSON',
//     data: {
//       term: '',
//       destination: $('#destination').val(),
//       mechine_req: fp_flag_value[1],
//     },
//     beforeSend: function() {
//       $('#resource').html('')
//       $('#foresource').hide()
//       $('.resource_loading_area').html(`<div id="loadingArea0">
//                                           <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Filtering resource data</center>
//                                         </div>`);
//     },
//     success: function(result) {
//       // console.log(result)
//       $('.resource_loading_area').html(``);
//       $('#foresource').show();
//       if (result !== null) {
//         // $('#resource').append(`<option value="" selected>Select...</option>`);
//         $.each(result, function(index, elem) {
//           let split_aja = elem.ATTRIBUTE1.split(' - ');
//           $('#resource').append(`<option value="${elem.RESOURCE_CODE}">${elem.RESOURCE_CODE} - ${elem.DESCRIPTION}</option>`)
//         });
//       }else {
//         $('#resource').html('')
//       }
//
//     },
//     error: function(XMLHttpRequest, textStatus, errorThrown) {
//       // swalFP('error', 'Something was wrong when fetching data...')
//      console.error();
//     }
//   }).done(function () {
//     let cek_ram_resource = $('#fp_tampung_resource_sementara').val();
//     if (cek_ram_resource != '') $('#resource').val(cek_ram_resource).trigger('change');
//   })
//  }
//
// }

// $('.fp_check_inspectool').on('change', function () {
//   let val = $(this).val();
//   // console.log(val);
//   if (val == 1) {
//     $('.fp_ilang_2').show()
//   }else {
//     $('.select2FP_Tool_2').val(null).trigger('change');
//     $('.fp_ilang_2').hide()
//   }
// })

// $('.fp_check_tool').on('change', function () {
//   let val = $(this).val();
//   // console.log(val);
//   if (val == 2) {
//     $('.fp_ilang').show()
//   }else {
//     $('.select2FP_Tool').val(null).trigger('change');
//     $('.fp_ilang').hide()
//   }
// })

const fp_add_operation_std = () =>{
  $('#id_fp_std').val('')
  $('#operation_std').val('')
  $('#operation_std_group').val('')
  $('#operation_std_desc').val('')
}

// $('#opetation_code').on('change', function () {
//   $.ajax({
//     url: baseurl + 'FlowProses/Operation/cekOracleProses',
//     type: 'POST',
//     async: true,
//     dataType: 'JSON',
//     data: {
//       code: $(this).val(),
//     },
//     beforeSend: function () {
//       Swal.mixin({
//         toast: true,
//         position: 'top-end',
//         showConfirmButton: false,
//         timer: 3000
//       }).showLoading()
//     },
//     success: function (result) {
//       if (result !== 0) {
//         toastFP('success', 'Data Founded!')
//         $('#opetaion_desc').val(result[0].DESCRIPTION)
//         // console.log(result);
//       }else {
//         Swal.fire({
//           type: 'warning',
//           html: `<b>Data not Found! Please Visit</b> <a style="font-weight:bold" href="http://192.168.168.135/khs-PendaftaranMasterItem" class="text-primary"> <u>Pendaftaran Master Item</u></a>`
//         })
//       }
//     }
//   })
// })

const fp_update_opration_std = (id, operation_std, operation_desc, operation_std_group) => {
  // console.log(operation_std_group);
  $('#id_fp_std').val(id)
  $('#operation_std').val(operation_std)
  $('#operation_std_desc').val(operation_desc)
  $('#operation_std_group').val(operation_std_group)
}

const fp_add_account = ()=>{
  $('#title_modal_account_fp').html('Add User');
  $('#fp_id_account').val('')
}

const fp_update_account = (id, des, user_access) =>{
  $('#fp_id_account').val(id)
  $('#title_modal_account_fp').html('Update User');
  let split = des.split(' - ');
  var item_ = new Option(`${split[0]} - ${split[1]}`, split[1], false, false);
  // console.log(item_);
  $('.select2FP').html(item_).trigger('change');
  $('.select2').val(user_access).trigger('change');
}

const detail_no_proses = () =>{
  // Swal.showLoading()
}

const getgambarkerja = (product_id, id, jenis, component_code) => {
  // if (jenis == 'who') {
  //   if($('#fp_status1').is(':checked')) {
  //      jenis = 'Product';
  //   }else if ($('#fp_status2').is(':checked')) {
  //      jenis = 'Prototype';
  //   }
  // }
  $('#fp_code_component').html(component_code)
  $.ajax({
    url: baseurl + 'FlowProses/Operation/gambarkerja',
    type: 'POST',
    data: {
      product_id : product_id,
      product_component_id : id,
      jenis : jenis
    },
    beforeSend: function() {
      $('.area-gambar-kerja').html(`<div id="loadingArea0">
                                      <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                      <center>Loading...</center>
                                    </div>`);
    },
    success: function(result) {
      $('.area-gambar-kerja').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalFP('error', 'Something was wrong...')
    }
  })
}
let fp_ajax_gmb = null;
const getgambarkerja_beda_tempat = () => {
  let product_id = $('#fp_selected_product').val()
  let id = $('#fpsimpanidsementara').val()
  let component_code = $('#code_product').text()
  let jenis = $('#fp_jenis_produk_ok').html();

  $('#fp_code_component').html(component_code)
  if (fp_ajax_gmb == null) {
    fp_ajax_gmb = $.ajax({
      url: baseurl + 'FlowProses/Operation/gambarkerjaBachAdd',
      type: 'POST',
      data: {
        product_id : product_id,
        product_component_id : id,
        jenis : jenis
      },
      beforeSend: function() {
        $('.area-gambar-kerja-kedua').html(`<div id="loadingArea0">
                                              <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                              <center>Loading...</center>
                                            </div>`);
      },
      success: function(result) {
        $('.area-gambar-kerja-kedua').html(result)
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        swalFP('error', 'Something was wrong...')
      }
    })
  }else {
    fp_ajax_gmb = null
  }
}

let fp_ajax_gmb_ = null;
const getgambarkerja_beda_tempat_ = () => {
  let product_id = $('#fp_selected_product').val()
  let id = $('#fpsimpanidsementara').val()
  let component_code = $('#code_product').text()
  let jenis = $('#fp_jenis_produk_ok').html();

  $('#fp_code_component').html(component_code)
  if (fp_ajax_gmb_ == null) {
    fp_ajax_gmb_ = $.ajax({
      url: baseurl + 'FlowProses/Operation/gambarkerjaBachAdd',
      type: 'POST',
      data: {
        product_id : product_id,
        product_component_id : id,
        jenis : jenis
      },
      beforeSend: function() {
        $('.area-gambar-kerja-kedua').html(`<div id="loadingArea0">
                                              <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                              <center>Loading...</center>
                                            </div>`);
      },
      success: function(result) {
        $('#modalfp1').css({'margin-top':'359px'})
        // $('.fp_set_height').css({'top':'-241px'})
        $('.area-gambar-kerja-kedua').html(result)
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        swalFP('error', 'Something was wrong...')
      }
    })
  }else {
    fp_ajax_gmb_ = null
    $('#modalfp1').css({'margin-top':'44px'})
  }
}

const fp_set_oracle_item = (id, code) => {
  $('#hdnFPIdProductComponent').val(id);
  $('#code_comp_item_orecle').html(code);
}
// crevisi buat update nanti
const del_item_oracle = (id) => {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: baseurl + 'FlowProses/SetOracleItem/del_item_oracle',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          id : id,
        },
        beforeSend: function() {
          Swal.showLoading()
        },
        success: function(result) {
          if (result) {
            toastFP('success', 'Data berhasil dihapus.');
            getItemOracle();
          }else {
            swalFP('warning', 'Gagal Menghapus Data, Coba lagi..');
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          Swal.fire({
            type: 'error',
            title: 'Something was wrong...',
            text: ''
          })
        }
      })
    }
  })
}

$('#modalfpItem').on('hidden.bs.modal', function () {
  $('.select2FP_Oracle').val(null).trigger('change');
  // $('.select2FP_ORG').val(null).trigger('change');
})

const update_fp_oracle_item = (id, org, code, inventory_item_id) => {

  let get = $(`#txtGetOracleItem${id}`).html()
  let split = get.split(' <br> ');
  // let split_org = org.split('-');

  $('#hdnFPIdProductComponent').val(id);
  $('#code_comp_item_orecle').html(code);

  // var org_ = new Option(split_org[1], split_org[0], false, false);
  // $('.select2FP_ORG').append(org_).trigger('change');

  var item_ = new Option(`${split[0]} - ${split[1]}`, inventory_item_id, false, false);
  $('.select2FP_Oracle').html(item_).trigger('change');
  // console.log(item_);
}

const save_oracle_item = () =>{
  let item_code_desc = $('.select2FP_Oracle option:selected').text();
  let item_id = $('.select2FP_Oracle').val();
  let id_product_component =  $('#hdnFPIdProductComponent').val()
  let cd = item_code_desc.split(' - ');
  // let org = $('.select2FP_ORG').val()+'-'+$('.select2FP_ORG option:selected').html();
  let product = $('#fp_selected_product').val();
  // console.log(cd);
  $.ajax({
    url: baseurl + 'FlowProses/SetOracleItem/save_oracle_item',
    type: 'POST',
    dataType: 'JSON',
    data: {
      code_component : cd[0],
      description : cd[1],
      inventory_item_id : item_id,
      product_component_id : id_product_component,
      product_id : product,
      org : null
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      if (result) {
        toastFP('success', 'Item Oracle Berhasil Diperbarui..');
        $('#modalfpItem').modal('toggle')
        let hhtml = `<span data-toggle="modal" data-target="#modalfpItem" id="txtGetOracleItem${id_product_component}"  onclick="update_fp_oracle_item('${id_product_component}', '', '${cd[0]}', '${item_id}')">${cd[0]} <br> ${cd[1]}</span>`
        $(`.fp_item_oracle_replace${id_product_component}`).html(hhtml)
        // getItemOracle();
        // fpselectcomponent()
        $('.select2FP_Oracle').val(null).trigger('change');
      }else {
        swalFP('error', 'Terjadi Kesalahan Saat Menyimpan Data')
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalFP('error', 'Something was wrong...')
    }
  })

}

const cek_org = () => {
  // if ($('.select2FP_ORG').val() == null) {
  //   swalFP('warning', 'Pilih Organization terlebih dahulu !!')
  // }
}

$('.select2FP_ORG').on('change', function () {
    // let fp_org = $(this).val();
    // $('.select2FP_Oracle').val(null).trigger('change');

})

$(document).ready(function() {
  $('#fp_tipe_produk_memo').val('Product').trigger('change');
  if ($('#cek_flow_ald').val() == 1) {
    getItemOracle();
  }
  $('.select2FP1').select2()
  $('.select2FP200121').select2()
  $('.select2FP21').select2({
    tags: true,
  })

  $('.select2FP').select2({
    minimumInputLength: 2,
    placeholder: "Employee",
    ajax: {
      url: baseurl + "FlowProses/ManagementAccount/employee",
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
  $('.select2FP_Oracle').select2({
  minimumInputLength: 3,
  placeholder: "Select Oracle Item",
  ajax: {
    url: baseurl + "FlowProses/SetOracleItem/getOracleItem",
    dataType: "JSON",
    type: "POST",
    data: function(params) {
      return {
        term: params.term,
        org: 81
      };
    },
    processResults: function(data) {
      return {
        results: $.map(data, function(obj) {
          return {
            id: obj.INVENTORY_ITEM_ID,
            text: `${obj.SEGMENT1} - ${obj.DESCRIPTION}`
          }
        })
      }
    }
  }
})
$('.select2_fp_machine_req').select2({
  // minimumInputLength: 2,
  placeholder: "Select Machine Req",
  ajax: {
    url: baseurl + "FlowProses/SetOracleItem/get_machine_req",
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
            id: `${obj.DESCRIPTION} - ${obj.FLEX_VALUE}`,
            text: `${obj.DESCRIPTION} - ${obj.FLEX_VALUE}`
          }
        })
      }
    }
  }
})
  // $('.select2FP_Tool').select2({
  //   minimumInputLength: 3,
  //   placeholder: "Select Tool Exiting",
  //   ajax: {
  //     url: baseurl + "FlowProses/SetOracleItem/getTool",
  //     dataType: "JSON",
  //     type: "POST",
  //     data: function(params) {
  //       return {
  //         term: params.term
  //       };
  //     },
  //     processResults: function(data) {
  //       return {
  //         results: $.map(data, function(obj) {
	//            return {
  //               id:`${obj.fs_no_order} _ (${obj.fs_nm_tool}) - ${obj.fs_kd_komp} ${obj.fs_nm_komp}`,
  //               text: `(${obj.fs_nm_tool}) - ${obj.fs_kd_komp} ${obj.fs_nm_komp}`
  //           };
  //         })
  //       }
  //     }
  //   }
  // })

  $('.select2FP_Tool_2').select2({
    minimumInputLength: 3,
    placeholder: "Select Tool Exiting",
    ajax: {
      url: baseurl + "FlowProses/SetOracleItem/getTool",
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
                id:`${obj.fs_no_order} _ (${obj.fs_nm_tool}) - ${obj.fs_kd_komp} ${obj.fs_nm_komp}`,
                text: `(${obj.fs_nm_tool}) - ${obj.fs_kd_komp} ${obj.fs_nm_komp}`
            };
          })
        }
      }
    }
  })

  $('.fp_proses_destinasi').select2({
    minimumInputLength: 2,
    placeholder: "Select Destination",
    ajax: {
      url: baseurl + "FlowProses/Operation/getDestinasi",
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
                id:obj.DEPARTMENT_CLASS_CODE,
                text: `${obj.DEPARTMENT_CLASS_CODE}`
            }
          })
        }
      }
    }
  })

})

// const fp_cek_resource = () => {
//   if ($('#machine_req').val() == '' || $('#destination').val() == '') {
//     swalFP('warning', 'Harap memilih mechine_req dan destination terlebih dahulu!');
//   }
//   // console.log('cekk');
//   // console.log($('#destination').val());
//   // console.log($('#machine_req').val());
// }

const report = () => {
  let product = $('#fp_selected_product').val();
  // let type = '';
  // if($('#fp_status1').is(':checked') && product != '') {
  //    type = $('#fp_status1').val()
  // }else if ($('#fp_status2').is(':checked') && product != '') {
  //    type = $('#fp_status2').val()
  // }else {
  //   swalFP('error', 'Isi dengan lengkap!')
  // }
  if (product != '') {
    window.open(baseurl + `FlowProses/Operation/Report/Master/${product}`);
  }else {
    swalFP('error', 'Isi dengan lengkap!')
  }
}

function getItemOracle() {
  $.ajax({
    url: baseurl + 'FlowProses/SetOracleItem/getDataItemOracle',
    type: 'POST',
    // dataType: 'JSON',
    beforeSend: function() {
      $('#table-fp-area-oracle-item').html(`<div id="loadingArea0">
                                  <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                </div>`);
    },
    success: function(result) {
      $('#table-fp-area-oracle-item').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalFP('error', 'Something was wrong...')
    }
  })
}

function getOPS() {
  $.ajax({
    url: baseurl + 'FlowProses/Operation/Operationstd',
    type: 'POST',
    // dataType: 'JSON',
    beforeSend: function() {
      $('.table-area-std').html(`<div id="loadingArea0">
                                  <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                </div>`);
    },
    success: function(result) {
      $('.table-area-std').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalFP('error', 'Something was wrong...')
    }
  })
}

const saveOperationStd = () => {
  let operation_std = $('#operation_std').val();
  let operation_std_group = $('#operation_std_group').val();
  let operation_std_desc = $('#operation_std_desc').val();
  if (operation_std != '' && operation_std_group != '' && operation_std_desc != '') {
    let ajaxx = $.ajax({
                url: baseurl + 'FlowProses/Operation/saveOperationstd',
                type: 'POST',
                dataType: 'JSON',
                data: {
                  id: $('#id_fp_std').val(),
                  operation_std : operation_std,
                  operation_desc : operation_std_group,
                  operation_std_group : operation_std_desc,
                },
                beforeSend: function() {
                  Swal.showLoading()
                },
                success: function(result) {
                  if (result) {
                    toastFP('success', 'Berhasil Menyimpan Data.');
                    $('#modalfp1').modal('toggle')
                    getOPS();
                  }else {
                    swalFP('warning', 'Gagal Mengambil Data, Coba lagi..');
                  }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                  swalFP('error', 'Something was wrong...')
                }
              })
  }else {
    swalFP('warning', 'Isi Form Input Dengan Lengkap');
  }

}

const fp_search = () => {
  $('#fp_tipe_search').val('se');
  let product = $('#fp_selected_product').val();
  let product_name = $('#fp_selected_product option:selected').text();
  // let type = '';
  // if($('#fp_status1').is(':checked') && product != '') {
  //    type = $('#fp_status1').val()
  // }else if ($('#fp_status2').is(':checked') && product != '') {
  //    type = $('#fp_status2').val()
  // }else {
  //   swalFP('error', 'Isi dengan lengkap!')
  // }

  if (product != '') {
  fpGetComp__ = $.ajax({
      url: baseurl + 'FlowProses/Operation/GetComp',
      type: 'POST',
      // dataType: 'JSON',
      async: true,
      data: {
        product_id : product,
        // type : type,
      },
      beforeSend: function() {
        $('#type_produk').html(`${product_name}`)
        $('.fpselectcomponent').show()
        $('.fp_search_area').hide()
        $('.fp-table-area').html(`<div id="loadingArea0">
                                    <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Please be patient...</center>
                                  </div>`);
      },
      success: function(result) {
        if (result != 0) {
          $('.fp-table-area').html(result);
          fpGetComp__ = null;
        }else {
          swalFP('warning', 'Gagal Mengambil Data, Coba lagi..');
          $('.fp_search_area').show()
          $('.fp-table-area').html(``);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        swalFP('error', 'Request Dibatalkan...')
        $('.fp_search_area').show()
        $('.fp-table-area').html(``);
      }
    })
  }else {
    swalFP('error', 'Isi dengan lengkap!')
  }
}

const add_prosess_per_component = () => {
  fp_ajax_gmb = null;
  $('#modalfp1').css({'display':'grid', 'margin-top':'44px'})
  $('.collapse').collapse('hide')
  $('#fp_tempat_save_operation').html(`Save`)
  $('#jenis_proses').val(null).trigger('change')

  $('.fp_tbl_penolong tbody').html('')
  $('.fp_cek_hidden_untuk_update').show()

  $('#nomor_jenis_proses').val(null)
  $('#fp_id_proses').val(null)
  $('.select2_fp_machine_req').val(null).trigger('change');
  $('.select2_fp_machine_req').html(null).trigger('change');

  $('#tool_exiting').html(null).trigger('change');
  $('#tool_measurement').html(null).trigger('change');

  $('#fp_tampung_resource_sementara').val('') // untuk update
  // $('#resource').val(null).trigger('change')
  setTimeout(function () {
    $('#resource').html('')
  }, 50);

  $('#fp_judul_form_proses').html('Add Operation');
  $('.select2').val(null).trigger('change');
  $("#reset_fp")[0].reset();
  $('#id_pd').val($('#fpsimpanidsementara').val())
  $('#component_code').val($('#code_product').html()+' - '+$('#fpsimpanidsementara_desc').val())
  $('#code_comp_sem').html($('#code_product').html())
  $('.fp_save_operation').show()

  // url: baseurl + "FlowProses/Operation/getDestinasi",
  $.ajax({
    url: baseurl + 'FlowProses/Operation/getDestinasi',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    beforeSend: function() {
      $('#destination').html('')
      $('#destination').val(null).trigger('change');
      $('#destination').append(`<option value="" selected>Select...</option>`);
      $('#fp_destinasi_view').hide()
      $('.destination_loading_area').html(`<div id="loadingArea0">
                                          <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Fetching destination data</center>
                                        </div>`);
    },
    success: function(result) {
      // console.log(result)
      $('.destination_loading_area').html(``);
      $('#fp_destinasi_view').show();
      $.each(result, function(index, elem) {
        $('#destination').append(`<option value="${elem.DEPARTMENT_CLASS_CODE}">${elem.DEPARTMENT_CLASS_CODE}</option>`)
      });
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })

  $(`.fp_area_gambar_kerja_3`).html(`<center style="position: fixed;width: 100%;top:0"><div class="box box-primary collapsed-box" style="margin-bottom:13px;background:#e1f0fe;width:80%;left:7.5px">
                                      <div class="box-header with-border">
                                        <h3 class="box-title"> <b class="fa fa-cube" style="color:#0f74c7"></b> <b style="color:#0f7ac7">Gambar Kerja</b></h3>

                                        <div class="box-tools pull-right">
                                          <button type="button" class="btn btn-primary btn-sm" onclick="getgambarkerja_beda_tempat_()" data-widget="collapse"><i class="fa fa-eye" style="color:white"></i></b>
                                          </button>
                                        </div>
                                      </div>
                                      <div class="box-body area-gambar-kerja-kedua" style="display: none;">
                                      </div>
                                    </div></center>`)


  if (fp_ajax2 !=  null) {
    fp_ajax2.abort()
    $('.resource_loading_area').html('')
    $('#foresource').show()
  }
  if (fp_ajax1 !=  null) fp_ajax1.abort()
}

const fpselectproduct = () => {
  fp_ajax_gmb = null;
  $('.fp_search_area').show()
  $('.fpselectproses').hide()
  $('.fpselectcomponent').hide()
  $('.fpselectcheckoperation').hide()
  $('.fpselectprosescheckoperation').hide()
  $('.fp-table-area').html(``);
  if (fpGetComp__ != null ) {
    fpGetComp__.abort();
  }
  if (fpGetProsesBy__ != null) {
    fpGetProsesBy__.abort();
  }

}

const fpselectcomponent = () => {
  fp_ajax_gmb = null;
  $('.fpselectproses').hide()
  $('.fp_search_area').hide()
  $('.btn_fp_operation').attr('disabled', true);
  if (fpGetProsesBy__ != null) {
    fpGetProsesBy__.abort();
  }
  fp_search()
}

const fpselectcheckoperation = () => {
  $('.fpselectprosescheckoperation').hide()
  $('.fp_search_area').hide()
  $('.btn_fp_operation').attr('disabled', true);
  fp_check_operation()
}

const fpselectproses = () => {
  fp_ajax_gmb = null;
  let type = $('#fp_jenis_produk_ok').html().toLowerCase();
  let id_product_component = $('#fpsimpanidsementara').val();

  fpGetProsesBy__ = $.ajax({
    url: baseurl + 'FlowProses/Operation/GetProsesByComponent',
    type: 'POST',
    // dataType: 'JSON',
    async: true,
    data: {
      product_component_id : id_product_component,
      type : type,
    },
    beforeSend: function() {
      $('.fp-table-area').html(`<div id="loadingArea0">
                                  <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Loading...</center>
                                </div>`);
    },
    success: function(result) {
      if (result != 0) {
        $('.fp-table-area').html(result);
        $('#fp_code_product_2').html($('#code_product').html())
        fpGetProsesBy__ = null;
      }else {
        swalFP('warning', 'Gagal Mengambil Data, Coba lagi..');
        $('.fp_search_area').show()
        $('.fp-table-area').html(``);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalFP('error', 'Request Dibatalkan...')
      $('.fp_search_area').show()
      $('.fp-table-area').html(``);
      console.error();
    }
  })
}

$('.dt-fp-std').DataTable()
$('.datatable-account-fp').DataTable({
    dom: 'rtpi',
})

if($('#fp_status1').is(':checked') && $('#fp_selected_product').val() == '') {
  swalFP('error', 'Select product type !')
}else if ($('#fp_status2').is(':checked') && $('#fp_selected_product').val() == '') {
}

// const fp_check_operation = () => {
//   $('#fp_tipe_search').val('co');
//   let product = $('#fp_selected_product').val();
//   let product_name = $('#fp_selected_product option:selected').text();
//   let type = '';
//
//   if($('#fp_status1').is(':checked') && product != '') {
//      type = $('#fp_status1').val()
//   }else if ($('#fp_status2').is(':checked') && product != '') {
//      type = $('#fp_status2').val()
//   }else {
//     swalFP('error', 'Isi dengan lengkap!')
//   }
//
//   if (type != '') {
//     $.ajax({
//       url: baseurl + 'FlowProses/Operation/GetCompCheckOperation',
//       type: 'POST',
//       // dataType: 'JSON',
//       async: true,
//       data: {
//         product_id : product,
//         type : type,
//       },
//       beforeSend: function() {
//         $('#type_produk_check_operation').html(`${product_name} - ${type.toUpperCase()}`)
//         $('.fpselectcheckoperation').show()
//         $('.fp_search_area').hide()
//         $('.fp-table-area').html(`<div id="loadingArea0">
//                                     <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Please be patient...</center>
//                                   </div>`);
//       },
//       success: function(result) {
//         if (result != 0) {
//           $('.fp-table-area').html(result);
//         }else {
//           swalFP('warning', 'Gagal Mengambil Data, Coba lagi..');
//           $('.fp_search_area').show()
//           $('.fp-table-area').html(``);
//         }
//       },
//       error: function(XMLHttpRequest, textStatus, errorThrown) {
//         swalFP('error', 'Something was wrong...')
//         $('.fp_search_area').show()
//         $('.fp-table-area').html(``);
//       }
//     })
//   }
// }

const tableflowproses = $('.dt-fp-comp').DataTable({
  search: {
  "caseInsensitive": false
  },
  initComplete: function() {},
  processing: true,
  serverSide: true,
  "order": [],
  "ajax": {
    url: baseurl + 'FlowProses/Operation/fpssc',
    type: "POST",
  },
  "bSort": false,
  // lengthMenu: [ 10, 25, 50, 75, 100 , 1000],
})

$('#product_fp').change(function() {
  if ($('#fp_tipe_produk').val() == 'product') {
    tableflowproses.search($(this).val()).draw();
  }
})

$('#fp_tipe_produk').on('change', function () {
  let product_type = $(this).val();
  if (product_type == 'product') {
    $('#product_fp').val(null).trigger('change');
    $('.fp_area_component').show();
    $('.fp_area_prototype').html('');
    tableflowproses.ajax.reload()
  }else {
    $('#product_fp').val(null).trigger('change');
    $('.fp_area_component').hide()
    $.ajax({
      url: baseurl + 'FlowProses/Operation/prototype_comp',
      type: 'POST',
      beforeSend : function() {
        $('.fp_area_prototype').html(`<div id="loadingArea0">
                                    <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Loading...</center>
                                  </div>`);
      },
      success: function(result) {
        $('.fp_area_prototype').html(result)
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastFP('error', 'Terjadi Kesalahan saat mengambil data!')
      }
    })
  }
})

const saveOperation_fp = () =>{
  if (fp_ajax2 !=  null) {
    fp_ajax2.abort()
    $('.resource_loading_area').html('')
    $('#foresource').show()
  }
  if (fp_ajax1 !=  null) fp_ajax1.abort()

  let count_tr = $('#txt_count_tr_proses_fp').val()
  $('#edit_fp_pb').html('');
  let oc = $('#opetation_code').val()
  let fl = $('#flag').val()
  let pr = null
  let mr = $('#machine_req').val()
  let to = $('#tool').val()
  let od = $('#opetaion_desc').val()
  let mb = $('#make_buy').val()
  let dp = $('#detail_proses').val()
  let mn = $('#machine_num').val();
  let ip = $('#inspectool').val()
  let re = $('#resource').val()
  let op = $('#operation_proses').val()
  let id_comp = $('#id_pd').val();
  let sequence = Number(count_tr) + 1;
  // console.log(sequence);
  let product_id = $('#fp_selected_product').val();

  let tool_exiting = $('#tool_exiting').val();
  let tool_measurement = $('#tool_measurement').val();
  let type = $('#fp_jenis_produk_ok').html().toLowerCase();
  // if($('#fp_status1').is(':checked')) {
  //    type = $('#fp_status1').val()
  // }else {
  //    type = $('#fp_status2').val()
  // }

  $.ajax({
    url: baseurl + 'FlowProses/Operation/SaveOpr',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      opr_code : oc,
      inv_item_flag : fl,
      process : pr,
      machine_req : mr,
      tool_id : to,
      opr_desc : od,
      make_buy : mb,
      dtl_process : dp,
      machine_num : mn,
      inspectool_id : ip,
      resource : re,
      product_component_id : id_comp,
      product_type : type,
      operation_process : op,
      sequence: sequence,
      product_id: product_id,
      tool_exiting: tool_exiting == '' ? null : tool_exiting,
      tool_measurement: tool_measurement == '' ? null : tool_measurement,
      qty_machine: $('#qty_machine').val(),
      destination: $('#destination').val(),
      id:$('#fp_id_proses').val(),
      jenis_proses: $('#jenis_proses').val(),
      nomor_jenis_proses: $('#nomor_jenis_proses').val() == '' ? null : $('#nomor_jenis_proses').val()
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      console.log(result);
      if (result.success == 1) {
        toastFP('success', 'Berhasil Menyimpan Data Operation.')

        let component_code = $('.fp_bp_component_code').map((_, el) => el.value).get()
        let qty_component = $('.fp_bp_qty').map((_, el) => el.value).get()
        let tampung_bahan_penolong = [];
        component_code.forEach((v,i) => {
          let split_hh = v.split(" - ");
          let item_list_f = {
            'component_code':split_hh[0],
            'component_desc':split_hh[1],
            'uom':split_hh[2],
            'qty':qty_component[i],
            'id_operation':result.id
          }
          tampung_bahan_penolong.push(item_list_f);
        })

        if (tampung_bahan_penolong == '') {
          console.log('tidak ada bahan penolong');
          $('#modalfp1').modal('toggle');
          $('.select2_fp_machine_req').val(null).trigger('change')
          fpselectproses()
        }else {
          $.ajax({
            url: baseurl + 'FlowProses/Operation/add_adjuvant',
            type: 'POST',
            dataType: 'JSON',
            data: {
              master: tampung_bahan_penolong
            },
            beforeSend : function() {
              Swal.fire({
                toast: true,
                position: 'top-end',
                onBeforeOpen: () => {
                   Swal.showLoading()
                   $('.swal2-loading').children('button').css({'width': '20px', 'height': '20px'})
                 },
                text: `Sedang memproses data bahan penolong...`
              })
            },
            success: function(results) {
              if (results) {
                toastFP('success', 'Bahan Penolong Berhasil Disimpan.')
                $('#modalfp1').modal('toggle');
                $('.select2_fp_machine_req').val(null).trigger('change')
                fpselectproses()
              }else {
                toastFP('warning', 'Terjadi Kesalahan Saat Menginput Bahan Penolong!.')
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              toastFP('error', 'Terjadi Kesalahan saat mengambil data!')
            }
          })
        }

      }else {
        swalFP('warning', 'Gagal Melakukan Insert Data.')
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalFP('error', 'Isi Form Input Dengan Lengkap!!!')
    }
  })
}


//grafik AREA
function getFamilykuis(e) {
	var range = e.dataPoint.range;
	var ke = e.dataPoint.key;
	$('#chartFPDKomp2,.tbl-comp').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading12.gif"></center>' );
	$.ajax({
		url: baseurl+"FlowProses/Grafik/getGrafik",
		type: "POST",
		data:{
			range:range,
			ke : ke
		},
		success:function (result) {
			var array2 = [];
			var htmls = '';
			var data = JSON.parse(result);
	        var array = $.map(data['recapDay'], function(value) {
	            return [value];
	        });
	        var arrayke = $.map(data['ke'], function(value) {
	            return [value];
	        });

		        for (var i = 0; i < array.length; i++) {
		        	array2.push({ x:new Date(array[i]['tgl']),y : Number(array[i]['su']) })
	            	}
	        var arrayComp = $.map(data['recapComp'], function(value) {
	            return [value];
	        });
			setTimeout(function () {
				var chart3 = new CanvasJS.Chart("chartFPDKomp2", {

                animationEnabled: true,
                theme: "light2",
                title:{
                  text: "Detail Minggu "+arrayke[0]['ke']
                },
                axisY:{
                  includeZero: false
                },
                data : [{
                    type: "area",
                    dataPoints:array2
                }]
              });
              chart3.render();
			},1500);
			setTimeout(function () {
				if (arrayComp.length > 0 ) {
					for (var i = 0; i < arrayComp.length; i++) {
			        	htmls += '<tr>';
			        	htmls += '<td style="width:27%"><center>'+arrayComp[i]['tgl']+'</center></td>';
			        	htmls += '<td style="padding:5px;">'+arrayComp[i]['cd_comp']+' di Produk '+arrayComp[i]['desc_prod']+'</td>';
			        	htmls += '</tr>'
		            	}
		            $('.tbl-comp').html(htmls);
				}else{
					htmls += 'Tidak ada input data komponen di minggu ke '+arrayke[0]['ke'];
		            $('.tbl-comp').html(htmls);
				}
			},1500);
		}
	})
}
