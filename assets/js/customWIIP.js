const swalWIPPToastrAlert = (type, message) => {
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

const swalWIPP = (type, title) => {
  Swal.fire({
    type: type,
    title: title,
    text: ''
  })
}
// ========================do something below the alert =================

const cekhover = _ => {
  const jsw = $('#jenisSaveWIIP').val()
  const date = $('#dateSaveWIIP').val()
  const wss = $('#waktuSaveWIIP').val()
  if (jsw === '' || date === '' || wss === '') {
    swalWIPP('info', 'Harap isi form input jenis date dan waktu terlebih dahulu!');
  }
}

const jenisRKH = _ => {
  const jsw = $('#jenisSaveWIIP').val()
  const date = $('#dateSaveWIIP').val()
  const wss = $('#waktuSaveWIIP').val()

  let hdatee =  new Date(date);
  let hdate = hdatee.toString().split(' ');
  if ((hdate[0] === 'Mon' || hdate[0] === 'Tue' || hdate[0] === 'Wed' || hdate[0] === 'Thu') && jsw === 'Reguler') {
    $('#waktuSaveWIIP').val('7')
  }else if ((hdate[0] === 'Fri' || hdate[0] === 'Sat') && jsw === 'Reguler') {
    $('#waktuSaveWIIP').val('6')
  }else {
    $('#waktuSaveWIIP').val('')
  }
}

const print_besar = (kode_item, key, line) => {
  const qty = $(`#qtyl${line}_${key}`).val();
  window.open(baseurl + 'WorkInProcessPackaging/JobManager/LabelBesar/' + kode_item + '_' + qty );
}

const updateTargetPe = _ => {
  let wipp_cek2 = $('.wipp2').val();
  let param = $('#linenumber').html();
  let data_max_target = $('#get_val_target_pe_max').val();
  let d = wipp_cek2;
  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/updateTarget_Pe',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      param: param,
      data: data_max_target,
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      if (result) {
        swalWIPP('success', 'Berhasil mengupdate data taget max.');
        $(`#target_pe_line${param}`).html(data_max_target);
        $('#wipp4').modal('hide');
        $.ajax({
          url: baseurl + 'WorkInProcessPackaging/JobManager/setArrange',
          type: 'POST',
          async: true,
          data: {
            date: d,
          },
          beforeSend: function() {
            $('.lines-area').html(`<div id="loadingArea0">
                                            <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                          </div>`)
          },
          success: function(result) {
            $('.lines-area').html(result)
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.error();
          }
        }).then(_ => {
          $.ajax({
            url: baseurl + 'WorkInProcessPackaging/JobManager/setTarget_Pe',
            type: 'POST',
            dataType: 'JSON',
            async: true,
            data: {
              param: '',
            },
            success: function(result) {
              $('#target_pe_line1').html(result[0].target_max);
              $('#target_pe_line2').html(result[1].target_max);
              $('#target_pe_line3').html(result[2].target_max);
              $('#target_pe_line4').html(result[3].target_max);
              $('#target_pe_line5').html(result[4].target_max);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.error();
            }
          })
        })

      } else {
        swalWIPP('error', 'Terjadi Kesalahan, Coba kembali...')
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

var newRes = '';
const setTargetPe = n => {
  $('#linenumber').html(n);
  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/setTarget_Pe',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      param: n,
    },
    beforeSend: function() {
      $('#get_val_target_pe_max').val(`Loading...`);
    },
    success: function(result) {
      newRes = result;
      $('#get_val_target_pe_max').val(`${newRes[0].target_max}`);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

function arrange(d) {
  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/setArrange',
    type: 'POST',
    async: true,
    data: {
      date: d,
    },
    beforeSend: function() {
      $('.lines-area').html(`<div id="loadingArea0">
                                      <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                    </div>`)
    },
    success: function(result) {
      $('.lines-area').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  }).then(_ => {
    $.ajax({
      url: baseurl + 'WorkInProcessPackaging/JobManager/setTarget_Pe',
      type: 'POST',
      dataType: 'JSON',
      async: true,
      data: {
        param: '',
      },
      success: function(result) {
        $('#target_pe_line1').html(result[0].target_max);
        $('#target_pe_line2').html(result[1].target_max);
        $('#target_pe_line3').html(result[2].target_max);
        $('#target_pe_line4').html(result[3].target_max);
        $('#target_pe_line5').html(result[4].target_max);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  })
}

const saveSplit = _ => {
  const nojob = $(`#job0_wipp1`).val();
  const item = $(`#item0_wipp1`).val();
  const created_at = $(`#created_at`).val();
  const s_item = item.split('=>');

  let qty_tampung = [];
  let target_pe_tampung = [];
  let ca_tampung = [];

  const qty_split = $('.line0wipp').find('.iminhere').toArray();
  qty_split.forEach((v, i) => {
    qty_tampung.push($(v).val());
  })

  const target_pe = $('.line0wipp').find('.andhere').toArray();
  target_pe.forEach((v, i) => {
    target_pe_tampung.push($(v).val());
  })

  const ca = $('.line0wipp').find('.param').toArray();
  if (ca !== '') {
    ca.forEach((v, i) => {
      ca_tampung.push($(v).val());
    })
  }

  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/SaveSplit',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      date: $('#dt').val(),
      nojob: nojob,
      item: s_item[0],
      qty: qty_tampung,
      target_pe: target_pe_tampung,
      created_at: ca_tampung
      // created_at: created_at
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      if (result) {
        Swal.fire({
          type: 'success',
          title: 'Berhasil.',
          text: ''
        }).then(_ => {
          list_Arrage($('#dt').val())
          $('.lines-area').html('')
        })
      } else {
        swalWIPPToastrAlert('error', 'Gagal menyimpan data!, harap isi form waktu shift dan tanggal dengan benar.');
      }
      $('#wipp2').modal('hide');
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

// COLAPSE
const saveSplit_ = (id, no_job, kode_item, nama_item, qty, usage_rate, ssd) => {
    function a() {
      let qty_tampung = [];
      const qty_split = $('.line0wipp'+id).find('.iminhere'+id).toArray();
      qty_split.forEach((v, i) => {
        qty_tampung.push($(v).val());
      })
      const idtrz = $('.tblNewRKH').find('tr[hesoyam="ya"]:last td center').html();
      let html = [];
      qty_tampung.forEach((val, i) => {
        let hhtml = `<tr hesoyam="ya" row="${Number(idtrz)+(Number(i)+1)}">
                        <td><center>${Number(idtrz)+(Number(i)+1)}</center></td>
                        <td><center>${no_job}</center></td>
                        <td><center>${kode_item}</center></td>
                        <td><center>${nama_item}</center></td>
                        <td><center>${val}</center></td>
                        <td><center>${usage_rate}</center></td>
                        <td><center>${ssd}</center></td>
                        <td hidden><center>${qty}</center></td>
                        <td onmouseover="cekhover()">
                          <center>
                            <button type="button" class="btn btn-md btn-primary" name="button" onclick="minusNewRKH(${Number(idtrz)+(Number(i)+1)})"><i class="fa fa-minus-square"></i></button>
                          </center>
                        </td>
                      </tr>`;
              html.push(hhtml)
      })
      console.log(html);
      $('#create-new-rkh').append(html);
    }
    function b() {
      $('.tblNewRKH').find(`tr[row="${id}"]`).remove();
      $('.tblNewRKH').find(`tr[collapse-row="${id}"]`).remove();

      $('.tblNewRKH tr[row]:visible').each(function(i) {
        $(this).find('td:first').text(i + 1);
      })
    }
    function run() {
      let d = $.Deferred(),
      p=d.promise();
      //instead of the loop doing the following has the same output
      p.then(a).then(b);
      d.resolve();
    }
    run();

  // console.log(html);
  // const nojob = $(`#job0${id}_wipp1`).val();
  // const item = $(`#item0${id}_wipp1`).val();
  // const item_name = $(`#item_name${id}`).val();
  //
  // const urs = $('#usage_rate_split'+id).val();
  // let qty_tampung = [];
  // let target_pe_tampung = [];
  // let ca_tampung = [];
  //
  // const qty_split = $('.line0wipp'+id).find('.iminhere'+id).toArray();
  // qty_split.forEach((v, i) => {
  //   qty_tampung.push($(v).val());
  // })
  //
  // const target_pe = $('.line0wipp'+id).find('.andhere'+id).toArray();
  // target_pe.forEach((v, i) => {
  //   target_pe_tampung.push($(v).val());
  // })
  //
  // $.ajax({
  //   url: baseurl + 'WorkInProcessPackaging/JobManager/SaveSplit_',
  //   type: 'POST',
  //   dataType: 'JSON',
  //   async: true,
  //   data: {
  //     date: $('#dateSaveWIIP').val(),
  //     wss: $('#waktuSaveWIIP').val(),
  //     ssd: $('#ssd'+id).val(),
  //     urs: urs,
  //     qty_parrent: $('#qty_split_save'+id).val(),
  //     nojob: nojob,
  //     item: item,
  //     item_name:item_name,
  //     qty: qty_tampung,
  //     target_pe: target_pe_tampung,
  //     created_at: ''
  //     // created_at: created_at
  //   },
  //   beforeSend: function() {
  //     Swal.showLoading()
  //   },
  //   success: function(result) {
  //     if (result === 1) {
  //       Swal.mixin({
  //         toast: true,
  //         position: 'top-end',
  //         showConfirmButton: false,
  //         timer: 2900
  //       }).fire({
  //         customClass: 'swal-font-small',
  //         type: 'success',
  //         title: 'Data berhasil disimpan.'
  //       })
  //     }else if (result === 3) {
  //       swalWIPPToastrAlert('error', `Gagal menyimpan data!, No job ${nojob} dengan tanggal ${$('#dateSaveWIIP').val()} telah tersimpan.`);
  //     }else {
  //       swalWIPPToastrAlert('error', 'Gagal menyimpan data!, harap isi form waktu shift dan tanggal dengan benar.');
  //     }
  //   },
  //   error: function(XMLHttpRequest, textStatus, errorThrown) {
  //     console.error();
  //   }
  // })
}

// INI UNTUK MODAL
const changeQtyValue = t => {
  let a = $(`#qty0_wipp${t}`).val();
  let b = $('#qtySplit').val();
  let b_d = $('#qty_split_save').val();
  let ur = $('#usage_rate_split').val();
  let wss = $('#wss').val();

  let sum = 0;
  const q_q = $('.line0wipp').find('.iminhere').toArray();
  q_q.forEach((v, i) => {
    sum += Math.round($(v).val())
  })

  setTimeout(function() {
    if (Number(b_d - sum) < 0) {
      $(`#qty0_wipp${t}`).val('00');
      $('.btnsplit').attr("hidden", "hidden");
      Swal.fire({
        type: 'info',
        title: 'QTY tidak boleh kurang dari 0',
        text: ''
      }).then(_ => {
        let sum_s = 0;
        const q_p = $('.line0wipp').find('.iminhere').toArray();
        q_p.forEach((v, i) => {
          sum_s += Math.round($(v).val())
        })
        setTimeout(function() {
          $('#qtySplit').val(b_d - sum_s);
        }, 300);
      })
    } else if (Number(b_d - sum) == 0) {
      $('.btnsplit').removeAttr("hidden");
      setTimeout(function() {
        $('#qtySplit').val(b_d - sum);
        $(`#target0_pe${t}`).val(wss / (a / ur));
      }, 200);
    } else {
      $('.btnsplit').attr("hidden", "hidden");
      setTimeout(function() {
        $('#qtySplit').val(b_d - sum);
        let z_z = wss / (a / ur);
        $(`#target0_pe${t}`).val(z_z.toFixed(5));
      }, 200);
    }
  }, 100);
}

//INI UNTUK COLLAPSE
const changeQtyValue_ = (t, i) => {
  let a = $(`#qty0${i}_wipp${t}`).val();
  let b = $(`#qtySplit${i}`).val();
  let b_d = $('#qty_split_save'+i).val();
  let ur = $('#usage_rate_split'+i).val();
  let wss = $('#waktuSaveWIIP').val();

  let sum = 0;
  const q_q = $('.line0wipp'+i).find('.iminhere'+i).toArray();
  q_q.forEach((v, i) => {
    sum += Math.round($(v).val())
  })

  setTimeout(function() {
    if (Number(b_d - sum) < 0) {
      $(`#qty0${i}_wipp${t}`).val('00');
      $('.btnsplit').attr("hidden", "hidden");
      Swal.fire({
        type: 'info',
        title: 'QTY tidak boleh kurang dari 0',
        text: ''
      }).then(_ => {
        let sum_s = 0;
        const q_p = $('.line0wipp'+i).find('.iminhere'+i).toArray();
        q_p.forEach((v, i) => {
          sum_s += Math.round($(v).val())
        })
        setTimeout(function() {
          $('#qtySplit'+i).val(b_d - sum_s);
        }, 300);
      })
    } else if (Number(b_d - sum) == 0) {
      $('.btnsplit'+i).removeAttr("hidden"); //nanti ==============
      setTimeout(function() {
        $('#qtySplit'+i).val(b_d - sum);
        $(`#target0${i}_pe${t}`).val(wss / (a / ur));
      }, 200);
    } else {
      $('.btnsplit'+i).attr("hidden", "hidden"); //nanti ==============
      setTimeout(function() {
        $('#qtySplit'+i).val(b_d - sum);
        let z_z = wss / (a / ur);
        $(`#target0${i}_pe${t}`).val(z_z.toFixed(5));
      }, 200);
    }
  }, 100);
}

const getModalSplit = (nj, qty, kode, desc, target, ur, wss, dt, ct, qty_parrent) => {
  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/getSplit',
    type: 'POST',
    async: true,
    data: {
      nojob: nj,
      date: dt,
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      Swal.close()
      $('.tbl_row_split').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  }).then(_ => {
    $('#jobnumber').html(nj);
    $('#qtySplit').val('0');
    $('#qty_split_save').val(qty_parrent);
    $('#wss').val(wss);
    $('#dt').val(dt);
    $('#created_at').val(ct);
    $('#usage_rate_split').val(ur);

    let cek_s = $('#qty0_wipp1').val();
    if (cek_s == '') {
      $('#target0_pe1').val(target + '%');
      $('#job0_wipp1').val(nj);
      $('#item0_wipp1').val(kode + '=>' + desc);
      $('#qty0_wipp1').val(qty);
      $(`#target0_pe1`).val(wss / (qty / ur).toFixed(5));
    }
  })

}

const photoWIPP = path => {
  console.log(path);
  $('#showPhoto').attr('src', baseurl + path)
}

const update_null = p => {
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
        url: baseurl + 'WorkInProcessPackaging/JobManager/delete_photo',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          id: p,
        },
        beforeSend: function() {
          Swal.showLoading()
        },
        success: function(result) {
          if (result === 1) {
            Swal.fire({
              type: 'success',
              title: 'Berhasil menghapus data.',
              text: ''
            }).then(_ => {
              location.reload();
            })
          }else {
            swalWIPPToastrAlert('error', 'Gagal menghapus data!');
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  })

}

const saveNewRKH = _ => {
  var tableInfo = Array.prototype.map.call(document.querySelectorAll('.tblNewRKH tr[hesoyam="ya"]'), function(tr) {
    return Array.prototype.map.call(tr.querySelectorAll('td center'), function(td) {
      return td.innerHTML;
    });
  });

  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/SaveJobList',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      date: $('#dateSaveWIIP').val(),
      waktu_shift: $('#waktuSaveWIIP').val(),
      data: tableInfo
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      if (result === 1) {
        Swal.fire({
          type: 'success',
          title: 'Berhasil menyimpan.',
          text: ''
        }).then(_ => {
          window.location.replace(baseurl + 'WorkInProcessPackaging/JobManager/ArrangeJobList/' + $('#dateSaveWIIP').val(), );
        })
      }else if (result === 2) {
        swalWIPPToastrAlert('error', 'Gagal menyimpan data!, RKH dengan tanggal '+$('#dateSaveWIIP').val()+' telah ada di database.');
      }else {
        swalWIPPToastrAlert('error', 'Gagal menyimpan data!, mohon isi form waktu shift dan tanggal dengan benar.');
      }
      // else if (result.status === 2) {
      //   swalWIPPToastrAlert('error', 'Gagal menyimpan data! No job '+ result.no_job+', data telah digunakan!');
      // }else if (result === 3) {
      //   swalWIPPToastrAlert('error', 'Gagal menyimpan data! job dengan tanggal '+ $('#dateSaveWIIP').val() +' telah digunakan!');
      // }

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

const minusNewRKH = n => {
  $('.tblNewRKH tr[row="' + n + '"]').remove();
  $('.tblNewRKH tr[row]:visible').each(function(i) {
    $(this).find('td:first').text(i + 1);
  })
}

const product_priority_delete = n => {
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
        url: baseurl + 'WorkInProcessPackaging/JobManager/productPriorityDelete',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          id: n,
        },
        success: function(result) {
          if (result) {
            swalWIPPToastrAlert('success', 'Berhasil menghapus product priority.');
            product_priority();
          } else {
            swalWIPPToastrAlert('error', 'Gagal menghapus product priority!');
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  })

}

const product_priority_save = _ => {
  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/productPrioritySave',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      kode: $('#kode_komponen').val(),
      nama: $('#nama_komponen').val(),
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      if (result === 1) {
        swalWIPP('success', 'Berhasil menambahankan product priority.');
        $('#kode_komponen').select2("val", "");
        $('#nama_komponen').val('');
        $('#wipp1').modal('toggle');
        product_priority();
      } else if (result === 2) {
        swalWIPPToastrAlert('error', 'Komponen telah ada di database.');
      } else {
        swalWIPPToastrAlert('error', 'Tidak bisa menambahankan product priority, harap periksa kembali!');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

function list_Arrage(n) {
  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/lishArrange/' + n,
    type: 'POST',
    async: true,
    beforeSend: function() {
      $('.table-list-arrange').html(`<div id="loadingArea0">
                                      <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                    </div>`)
    },
    success: function(result) {
      $('.table-list-arrange').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

function list_RKH() {
  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/lishRKH',
    type: 'POST',
    async: true,
    beforeSend: function() {
      $('.table-list-RKH').html(`<div id="loadingArea0">
                                      <center><img style="width: 10%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                    </div>`)
    },
    success: function(result) {
      $('.table-list-RKH').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

function job_released() {
  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/JobReleased',
    type: 'POST',
    async: true,
    beforeSend: function() {
      $('.table-job-released').html(`<div id="loadingArea0">
                                      <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                    </div>`)
    },
    success: function(result) {
      $('.table-job-released').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

function product_priority() {
  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/productPriority',
    type: 'POST',
    async: true,
    beforeSend: function() {
      $('.table-product-priority').html(`<div id="loadingArea0">
                                        <center><img style="width: 10%;margin:9px 0 13px 0" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                        </div>`)
    },
    success: function(result) {
      $('.table-product-priority').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

const refreshWIPP = _ => {
  job_released()
}

$(document).ready(function() {
  let wipp_cek = $('.wipp').val();
  let wipp_cek2 = $('.wipp2').val();
  let wipp_cek3 = $('.wipp2_').val();
  let d = wipp_cek2;
  if (wipp_cek) {
    product_priority();
    job_released();
    list_RKH();
  }

  if (wipp_cek3 == 2) {
    list_Arrage(wipp_cek2)
    $.ajax({
      url: baseurl + 'WorkInProcessPackaging/JobManager/cekLineSaved',
      type: 'POST',
      dataType: 'JSON',
      async: true,
      data: {
        date: wipp_cek2
      },
      success: function(result) {
        if (result) {
          $.ajax({
            url: baseurl + 'WorkInProcessPackaging/JobManager/getSavedLineData',
            type: 'POST',
            async: true,
            data: {
              date: d,
            },
            beforeSend: function() {
              $('.lines-area').html(`<div id="loadingArea0">
                                              <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                            </div>`)
            },
            success: function(result) {
              $('.lines-area').html(result)
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.error();
            }
          })
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }


  $('.select2itemcodewipp').select2({
    minimumInputLength: 3,
    placeholder: "Item Kode",
    ajax: {
      url: baseurl + "WorkInProcessPackaging/JobManager/JobReleaseSelected",
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
              id: `${obj.KODE_ASSY}`,
              text: `${obj.KODE_ASSY} - ${obj.DESCRIPTION}`
            }
          })
        }
      }
    }
  })

  $('.select2itemcodewipp2').select2({
    minimumInputLength: 3,
    placeholder: "Item Kode",
    ajax: {
      url: baseurl + "WorkInProcessPackaging/JobManager/JobReleaseSelected",
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
              id: `${obj.KODE_ASSY}`,
              text: `${obj.KODE_ASSY} - ${obj.DESCRIPTION}`
            }
          })
        }
      }
    }
  })
})

$('.select2itemcodewipp').on('change', function() {
  let val = $(this).val();
  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/JobReleaseSelected',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      term: val,
    },
    beforeSend: function() {
      $(`#nama_komponen`).val('Loading...');
    },
    success: function(result) {
      $.ajax({
        url: baseurl + 'WorkInProcessPackaging/JobManager/cek_job',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          job: val,
        },
        success: function(result2) {
          if (result2) {
            swalWIPPToastrAlert('error', 'kode_item tidak ada di database.');
          }else {

          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
      $(`#nama_komponen`).val(result[0].DESCRIPTION);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
})

$('.select2itemcodewipp2').on('change', function() {
  let val = $(this).val();
  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/JobReleaseSelected',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      term: val,
    },
    beforeSend: function() {
      $(`#nama_komponen_update`).val('Loading...');
    },
    success: function(result) {
      $(`#nama_komponen_update`).val(result[0].DESCRIPTION);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
})

// INI UNTUK MODAL
const addrowlinewipp0 = _ => {
  let nojob = $('#job0_wipp1').val();
  let item = $('#item0_wipp1').val();
  let ur = $('#usage_rate_split').val();

  let n = $('.line0wipp tbody tr').length;
  let a = n + 1;
  $('#tambahisiwipp0').append(`<tr class="rowbaru0_wipp" id="wipp0row${n}">
                                  <td>
                                    <center><input type="text" value="${nojob}" class="form-control" name="job0[]" id="job0_wipp${a}" placeholder="ITEM CODE"></center>
                                  </td>
                                  <td><center><input type="text" value="${item}" class="form-control" name="item0[]" id="item0_wipp${a}" placeholder="ITEM"></center></td>
                                  <td><center><input type="number" class="form-control iminhere" name="qty0[]" id="qty0_wipp${a}" oninput="changeQtyValue(${a})" placeholder="QTY"></center></td>
                                  <td><center><input type="number" class="form-control andhere" name="target0[]" id="target0_pe${a}" placeholder="20%"></center></td>
                                  <td hidden></td>
                                  <td>
                                    <center>
                                     <button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp0(${a})" style="border-radius:10px;"name="button"><i class="fa fa-minus-square"></i></button>
                                    </center>
                                  </td>
                                </tr>`);
  // $('.line0wipp tbody tr[id="wipp0row' + n + '"] .select0wipp').select0({
  //   placeholder: "Item Kode",
  // });
}
const minus_wipp0 = n => {
  if (n === 1) {
    swalWIPP('warning', 'Minimal harus ada 1 row yang tersisa');
  } else {
    $('#job0_wipp' + n).parents('.rowbaru0_wipp').remove()

    setTimeout(function() {
      let b_d = $('#qty_split_save').val();
      let sum = 0;
      const q_q = $('.line0wipp').find('.iminhere').toArray();
      q_q.forEach((v, i) => {
        sum += Math.round($(v).val())
      })
      $('#qtySplit').val(b_d - sum);
    }, 200);

  }
}
// END INI UNUTK MODAL

// INI UNTUK COLLAPSE
const addrowlinewipp_0 = id => {
  let nojob = $(`#job0${id}_wipp1`).val();
  let item = $(`#item0${id}_wipp1`).val();
  let ur = $('#usage_rate_split').val();

  let n = $(`.line0wipp${id} tbody tr`).length;
  let a = n + 1;
  $('#tambahisiwipp0'+id).append(`<tr class="rowbaru0_wipp" id="wipp0row${n}">
                                  <td>
                                    <center><input type="text" value="${nojob}" class="form-control" name="job0[]" id="job0${id}_wipp${a}" placeholder="ITEM CODE"></center>
                                  </td>
                                  <td><center><input type="text" value="${item}" class="form-control" name="item0[]" id="item0_wipp${a}" placeholder="ITEM"></center></td>
                                  <td><center><input type="number" class="form-control iminhere${id}" name="qty0[]" id="qty0${id}_wipp${a}" oninput="changeQtyValue_(${a}, ${id})" placeholder="QTY"></center></td>
                                  <td><center><input type="number" class="form-control andhere${id}" name="target0[]" id="target0${id}_pe${a}" placeholder="20%"></center></td>
                                  <td hidden></td>
                                  <td>
                                    <center>
                                     <button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp0_(${a}, ${id})" style="border-radius:10px;"name="button"><i class="fa fa-minus-square"></i></button>
                                    </center>
                                  </td>
                                </tr>`);
  // $('.line0wipp tbody tr[id="wipp0row' + n + '"] .select0wipp').select0({
  //   placeholder: "Item Kode",
  // });
}

const minus_wipp0_ = (n, id) => {
  if (n === 1) {
    swalWIPP('warning', 'Minimal harus ada 1 row yang tersisa');
  } else {
    $(`#job0${id}_wipp${n}`).parents('.rowbaru0_wipp').remove()

    setTimeout(function() {
      let b_d = $('#qty_split_save'+id).val();
      let sum = 0;
      const q_q = $('.line0wipp'+id).find('.iminhere').toArray();
      q_q.forEach((v, i) => {
        sum += Math.round($(v).val())
      })
      $('#qtySplit').val(b_d - sum);
    }, 200);

  }
}
// END COLLAPSE

const addrowlinewipp5 = _ => {

  let n = $('.line5wipp tbody tr').length;
  let a = n + 1;
  $('#tambahisiwipp5').append(`<tr class="rowbaru5_wipp" id="wipp5row${n}">
                          <td>
                            <center>
                              <select class="form-control select5wipp" id="job5_wipp${a}" name="job5[]" style="width:100%" required>
                                <option value="">Komponen Kode</option>
                              </select>
                            </center>
                          </td>
                          <td><center><input type="text" class="form-control" name="item5[]" id="item5_wipp${a}" placeholder="ITEM"></center></td>
                          <td><center><input type="number" class="form-control" name="qty5[]" id="qty5_wipp${a}" placeholder="QTY"></center></td>
                          <td><center><input type="number" class="form-control" name="target5[]" id="target5_pe${a}" placeholder="50%"></center></td>
                          <td><center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp5(${a})" style="border-radius:10px;"name="button"><i class="fa fa-minus-square"></i></button></center></td>
                        </tr>`);
  $('.line5wipp tbody tr[id="wipp5row' + n + '"] .select5wipp').select2({
    placeholder: "Item Kode",
  });
}

const minus_wipp5 = n => {
  $('#jobid5_'+n).remove();
  $('#job5_wipp' + n).parents('.rowbaru5_wipp').remove()
}

const addrowlinewipp4 = _ => {

  let n = $('.line4wipp tbody tr').length;
  let a = n + 1;
  $('#tambahisiwipp4').append(`<tr class="rowbaru4_wipp" id="wipp4row${n}">
                          <td>
                            <center>
                              <select class="form-control select4wipp" id="job4_wipp${a}" name="job4[]" style="width:100%" required>
                                <option value="">Komponen Kode</option>
                              </select>
                            </center>
                          </td>
                          <td><center><input type="text" class="form-control" name="item4[]" id="item4_wipp${a}" placeholder="ITEM"></center></td>
                          <td><center><input type="number" class="form-control" name="qty4[]" id="qty4_wipp${a}" placeholder="QTY"></center></td>
                          <td><center><input type="number" class="form-control" name="target4[]" id="target4_pe${a}" placeholder="40%"></center></td>
                          <td><center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp4(${a})" style="border-radius:10px;"name="button"><i class="fa fa-minus-square"></i></button></center></td>
                        </tr>`);
  $('.line4wipp tbody tr[id="wipp4row' + n + '"] .select4wipp').select2({
    placeholder: "Item Kode",
  });
}

const minus_wipp4 = n => {
  $('#jobid4_'+n).remove();
  $('#job4_wipp' + n).parents('.rowbaru4_wipp').remove()
}


const addrowlinewipp3 = _ => {

  let n = $('.line3wipp tbody tr').length;
  let a = n + 1;
  $('#tambahisiwipp3').append(`<tr class="rowbaru3_wipp" id="wipp3row${n}">
                          <td>
                            <center>
                              <select class="form-control select3wipp" id="job3_wipp${a}" name="job3[]" style="width:100%" required>
                                <option value="">Komponen Kode</option>
                              </select>
                            </center>
                          </td>
                          <td><center><input type="text" class="form-control" name="item3[]" id="item3_wipp${a}" placeholder="ITEM"></center></td>
                          <td><center><input type="number" class="form-control" name="qty3[]" id="qty3_wipp${a}" placeholder="QTY"></center></td>
                          <td><center><input type="number" class="form-control" name="target3[]" id="target3_pe${a}" placeholder="30%"></center></td>
                          <td><center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp3(${a})" style="border-radius:10px;"name="button"><i class="fa fa-minus-square"></i></button></center></td>
                        </tr>`);
  $('.line3wipp tbody tr[id="wipp3row' + n + '"] .select3wipp').select2({
    placeholder: "Item Kode",
  });
}

const minus_wipp3 = n => {
  $('#jobid3_'+n).remove();
  $('#job3_wipp' + n).parents('.rowbaru3_wipp').remove()
}


const addrowlinewipp2 = _ => {

  let n = $('.line2wipp tbody tr').length;
  let a = n + 1;
  $('#tambahisiwipp2').append(`<tr class="rowbaru2_wipp" id="wipp2row${n}">
                          <td>
                            <center>
                              <select class="form-control select2wipp" id="job2_wipp${a}" name="job2[]" style="width:100%" required>
                                <option value="">Komponen Kode</option>
                              </select>
                            </center>
                          </td>
                          <td><center><input type="text" class="form-control" name="item2[]" id="item2_wipp${a}" placeholder="ITEM"></center></td>
                          <td><center><input type="number" class="form-control" name="qty2[]" id="qty2_wipp${a}" placeholder="QTY"></center></td>
                          <td><center><input type="number" class="form-control" name="target2[]" id="target2_pe${a}" placeholder="20%"></center></td>
                          <td><center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp2(${a})" style="border-radius:10px;"name="button"><i class="fa fa-minus-square"></i></button></center></td>
                        </tr>`);
  $('.line2wipp tbody tr[id="wipp2row' + n + '"] .select2wipp').select2({
    placeholder: "Item Kode",
  });
}

const minus_wipp2 = n => {
  $('#jobid2_'+n).remove();
  $('#job2_wipp' + n).parents('.rowbaru2_wipp').remove()
}

const addrowlinewipp = _ => {

  let n = $('.line1wipp tbody tr').length;
  let a = n + 1;
  $('#tambahisiwipp').append(`<tr class="rowbaru_wipp" id="wipprow${n}">
                          <td>
                            <center>
                              <select class="form-control select2wipp" id="job_wipp${a}" name="job[]" style="width:100%" required>
                                <option value="">Komponen Kode</option>
                              </select>
                            </center>
                          </td>
                          <td><center><input type="text" class="form-control" name="item[]" id="item_wipp${a}" placeholder="ITEM"></center></td>
                          <td><center><input type="number" class="form-control" name="qty[]" id="qty_wipp${a}" placeholder="QTY"></center></td>
                          <td><center><input type="number" class="form-control" name="target[]" id="target_pe${a}" placeholder="20%"></center></td>
                          <td><center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp(${a})" style="border-radius:10px;"name="button"><i class="fa fa-minus-square"></i></button></center></td>
                        </tr>`);
  $('.line1wipp tbody tr[id="wipprow' + n + '"] .select2wipp').select2({
    placeholder: "Item Kode",
  });
}

const minus_wipp = n => {
  $('#jobid1_'+n).remove();
  $('#job_wipp' + n).parents('.rowbaru_wipp').remove()
}

$('.tblwiip').DataTable({
  "pageLength": 10,
});

const readFile = input => {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#showPre')
        .attr('src', e.target.result)
        .height(350);
    };
    reader.readAsDataURL(input.files[0]);
  }
}

$('.txtWIIPdate').datepicker({
  "autoclose": true,
  "todayHighlight": true,
  "allowClear" : true,
  "format": 'dd-M-yy'
})

// $.ajax({
//   url: baseurl + 'WorkInProcessPackaging/JobManager/cekNojob',
//   type: 'POST',
//   dataType: 'JSON',
//   async: true,
//   data: {
//     nojob: nj,
//   },
//   beforeSend: function() {
//     Swal.showLoading()
//   },
//   success: function(result) {
//     console.log(result);
//     if (result===1) {
//       Swal.close()
//     }else {
//       Swal.fire({
//         type: 'error',
//         title: `Nomor Job ${nj} telah digunakan sebelumnya.`,
//         text: ''
//       })
//     }
//   },
//   error: function(XMLHttpRequest, textStatus, errorThrown) {
//     console.error();
//   }
// })
