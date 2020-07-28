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

const saveNewRKHEdit = _ => {
  var tableInfo = Array.prototype.map.call(document.querySelectorAll('.tblNewRKH tr[hesoyam="ya"]'), function(tr) {
    return Array.prototype.map.call(tr.querySelectorAll('td center'), function(td) {
      return td.innerHTML;
    });
  });

  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/SaveJobListEdit',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      date: $('#dateSaveWIIP').val(),
      waktu_shift: $('#waktuSaveWIIP').val(),
      jenis: $('#jenisSaveWIIP').val(),
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
          list_Arrage($('#dateSaveWIIP').val()+'_'+$('#jenisSaveWIIP').val().substring(0, 1));
        })
      }else {
        swalWIPPToastrAlert('error', 'Gagal menyimpan data!, No Job '+result+' telah ada sebelumnya.');
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

const job_released_edit = () => {
  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/JobReleasedEdit',
    type: 'POST',
    async: true,
    beforeSend: function() {
      $('.table-job-released-edit').html(`<div id="loadingArea0">
                                      <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                    </div>`)
    },
    success: function(result) {
      $('.table-job-released-edit').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

let wipp_skrtt = $('.tblwiip12').DataTable({
  "pageLength": 10,
});

function format_wipp_bom(d, kode_item) {
  return `<div class="JobReleaseArea_${kode_item}"></div>`;
}

const detailBOM = (kode_item, no) => {
  let tr = $(`tr[row-bom="${no}"]`);
  let row = wipp_skrtt.row(tr);
  if (row.child.isShown()) {
    row.child.hide();
    tr.removeClass('shown');
  } else {
    row.child(format_wipp_bom(row.data(), kode_item)).show();
    tr.addClass('shown');
    $.ajax({
      url: baseurl + 'WorkInProcessPackaging/JobManager/getDetailBom',
      type: 'POST',
      async: true,
      dataType: 'JSON',
      data: {
        kode_item: kode_item,
      },
      beforeSend: function() {
        $('.JobReleaseArea_' + kode_item).html(`<div id="loadingArea0">
                                                <center><img style="width: 3%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                               </div>`)
      },
      success: function(result) {
        let item = '';
        let push = [];
        result.forEach((v, i) => {
          item = `<tr row-id="${v.ROOT_ASSEMBLY}">
                      <td><center>${v.ROOT_ASSEMBLY}</center></td>
                      <td><center>${v.DESCRIPTION}</center></td>
                      <td><center>${Math.abs(v.QTY)}</center></td>
                      <td><center>${v.UOM}</center></td>
                    </tr>`;
          push.push(item);
        })
        let join = push.join();
        let html = `<table class="table table-striped table-bordered table-hover text-left" style="font-size:12px;width:50%;float:right">
              <thead>
                <tr class="bg-success">
                  <th><center>ROOT_ASSEMBLY</center></th>
                  <th><center>DESCRIPTION</center></th>
                  <th><center>QTY</center></th>
                  <th><center>UOM</center></th>
                </tr>
              </thead>
              <tbody>
              ${join}
              </tbody>
            </table>`
        $('.JobReleaseArea_' + kode_item).html(html)
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.error();
      }
    })
  }
}

const submit_type = () => {
  const type = $('#type_proses_gambar').val();
  if (type === '') {
    swalWIPPToastrAlert('error', 'Pilih salah satu dari 2 tipe proses yang tersedia')
  } else {
    window.location.replace(baseurl + `WorkInProcessPackaging/PhotoManager/Type/${type}`);
  }
}

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

  let hdatee = new Date(date);
  let hdate = hdatee.toString().split(' ');
  if ((hdate[0] === 'Mon' || hdate[0] === 'Tue' || hdate[0] === 'Wed' || hdate[0] === 'Thu') && jsw === 'Reguler') {
    $('#waktuSaveWIIP').val('7')
  } else if ((hdate[0] === 'Fri' || hdate[0] === 'Sat') && jsw === 'Reguler') {
    $('#waktuSaveWIIP').val('6')
  } else {
    $('#waktuSaveWIIP').val('')
  }
}

const print_besar = (kode_item, key, line) => {
  const qty = $(`#qtyl${line}_${key}`).val();
  window.open(baseurl + 'WorkInProcessPackaging/JobManager/LabelBesar/' + kode_item + '_' + qty);
}

const print_kecil = (kode_item, key, line) => {
  const qty = $(`#qtyll${line}_${key}`).val();
  window.open(baseurl + 'WorkInProcessPackaging/JobManager/LabelKecil/' + kode_item + '_' + qty);
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
        // $.ajax({
        //   url: baseurl + 'WorkInProcessPackaging/JobManager/setArrange',
        //   type: 'POST',
        //   async: true,
        //   data: {
        //     date: d,
        //   },
        //   beforeSend: function() {
        //     $('.lines-area').html(`<div id="loadingArea0">
        //                                     <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
        //                                   </div>`)
        //   },
        //   success: function(result) {
        //     $('.lines-area').html(result)
        //   },
        //   error: function(XMLHttpRequest, textStatus, errorThrown) {
        //     console.error();
        //   }
        // })
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
        }).then(_ => {
          arrange(wipp_cek2)
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

    let item_selected = $('.tampungID').map((_, el) => el.value).get()
    item_selected.forEach((val, i) => {
      $(`.id-list-arrange-${val}`).remove()
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
    const qty_split = $('.line0wipp' + id).find('.iminhere' + id).toArray();
    qty_split.forEach((v, i) => {
      qty_tampung.push($(v).val());
    })
    let idtrz = $('.tblNewRKH').find('tr[hesoyam="ya"]:last td:nth-child(1) center').text();
    console.log(idtrz);
    // const idtrz_ = $('.tblNewRKH tr[hesoyam="ya"]').toArray();
    // let idtrz = idtrz_.length;

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
                            <button type="button" onclick="hideSave()" class="btn btn-md bg-navy" data-toggle="collapse" data-target="#Mycollapse${Number(idtrz)+(Number(i)+1)}" aria-expanded="false" aria-controls="collapseExample" name="button"><i class="fa fa-cut"></i></button>
                            <input type="hidden" id="hideSave" value="Y">
                          </center>
                        </td>
                      </tr>
                      <tr collapse-row="${Number(idtrz)+(Number(i)+1)}">
                        <td colspan="8" style="margin:0;padding:0;width:0">
                        <div class="collapse" id="Mycollapse${Number(idtrz)+(Number(i)+1)}">
                          <div class="card card-body" style="padding-top: 10px; padding-bottom: 20px;border-color:transparent">

                          <div class="row">
                            <div class="col-lg-12">
                              <div class="box box-primary box-solid">
                                <div class="box-header with-border">
                                  <div style="float:left">
                                    <h4 style="font-weight:bold;">SPLIT JOB (<span>${no_job}</span>)</h4>
                                  </div>
                                </div>
                                <div class="box-body">
                                  <center>
                                    <div id="loading-pbi" style="display:none;">
                                      <center><img style="width: 5%" src="${baseurl}/assets/img/gif/loading5.gif"></center>
                                    </div>
                                  </center>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                                        <center>
                                          <h4 style="font-weight:bold;display:inline-block;">QTY Avaliable :</h4> <input type="number" readonly value="0" id="qtySplit${Number(idtrz)+(Number(i)+1)}" style="display:inline-block;width:10%;margin-left:10px;" class="form-control" placeholder="QTY">
                                        </center>
                                        <input type="hidden" id="qty_split_save${Number(idtrz)+(Number(i)+1)}" value="${val}" readonly>
                                        <input type="hidden" id="usage_rate_split${Number(idtrz)+(Number(i)+1)}" value="${usage_rate}" readonly>
                                        <input type="hidden" id="ssd${Number(idtrz)+(Number(i)+1)}" value="${ssd}" readonly>
                                        <input type="hidden" id="item_name${Number(idtrz)+(Number(i)+1)}" value="${nama_item}" readonly>
                                        <input type="hidden" id="created_at" value="" readonly>
                                        <br>
                                        <div class="table-responsive">
                                          <table class="table table-striped table-bordered table-hover text-left line0wipp${Number(idtrz)+(Number(i)+1)}" style="font-size:11px;">
                                            <thead>
                                              <tr class="bg-info">
                                                <th style="width:26%">
                                                  <center>JOB</center>
                                                </th>
                                                <th style="width:35%">
                                                  <center>ITEM</center>
                                                </th>
                                                <th style="width:17%">
                                                  <center>QTY</center>
                                                </th>
                                                <th style="width:17%">
                                                  <center>TARGET PPIC (%)</center>
                                                </th>
                                                <th hidden>
                                                  <center>CREATED AT</center>
                                                </th>
                                                <th style="width:5%">
                                                  <center><button type="button" class="btn btn-sm bg-navy" onclick="addrowlinewipp_0(${Number(idtrz)+(Number(i)+1)})" style="border-radius:10px;" name="button"><i class="fa fa-plus-square"></i></button></center>
                                                </th>
                                              </tr>
                                            </thead>
                                            <tbody id="tambahisiwipp0${Number(idtrz)+(Number(i)+1)}" class="tbl_row_split">
                                            <tr class="rowbaru0_wipp" id="wipp0row1">
                                              <td>
                                                <center><input type="text" readonly value="${no_job}" class="form-control" name="job0[]" id="job0${Number(idtrz)+(Number(i)+1)}_wipp1" placeholder="ITEM CODE"></center>
                                              </td>
                                              <td>
                                                <center><input type="text" readonly value="${kode_item}" class="form-control" name="item0[]" id="item0${Number(idtrz)+(Number(i)+1)}_wipp1" placeholder="ITEM"></center>
                                              </td>
                                              <td>
                                                <center><input type="number" value="${val}" class="form-control iminhere${Number(idtrz)+(Number(i)+1)}" oninput="changeQtyValue_(1, ${Number(idtrz)+(Number(i)+1)})" name="qty0[]" id="qty0${Number(idtrz)+(Number(i)+1)}_wipp1" placeholder="QTY"></center>
                                              </td>
                                              <td>
                                                <center><input type="number" value="" class="form-control andhere${Number(idtrz)+(Number(i)+1)}" name="target0[]" id="target0${Number(idtrz)+(Number(i)+1)}_pe1" placeholder="00%"></center>
                                              </td>
                                              <td hidden>
                                                <center><input type="text" value="" class="form-control param"></center>
                                              </td>
                                              <td>
                                                <center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp0_(1, ${Number(idtrz)+(Number(i)+1)})" style="border-radius:10px;" name="button"><i class="fa fa-minus-square"></i></button></center>
                                              </td>
                                            </tr>
                                            </tbody>
                                          </table>
                                          <br>
                                          <center class="btnsplit${Number(idtrz)+(Number(i)+1)}" hidden><button type="button" style="margin-bottom:10px !important;" hidden class="btn bg-navy" onclick="saveSplit_(${Number(idtrz)+(Number(i)+1)}, '${no_job}', '${kode_item}', '${nama_item}', '${val}', '${usage_rate}', '${ssd}')" name="button"><i class="fa fa-sign-in"></i> Append</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          </div>
                        </div>
                        </td>
                      </tr>`;
      html.push(hhtml)
    })
    // console.log(html);
    $('#create-new-rkh').append(html);

  }

  function b() {
    $('.tblNewRKH').find(`tr[row="${id}"]`).remove();
    $('.tblNewRKH').find(`tr[collapse-row="${id}"]`).remove();

    // $('.tblNewRKH tr[row]:visible').each(function(i) {
    //   $(this).find('td:first center').text(i + 1);
    // })

    $('.wipp_hided').show();
    $('#hideSave').val('Y');
  }

  function run() {
    let d = $.Deferred(),
      p = d.promise();
    //instead of the loop doing the following has the same output
    p.then(a).then(b);
    d.resolve();
  }
  run();

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
        $(`#target0_pe${t}`).val(Number((a/(wss/ur))*100)/100);
      }, 200);
    } else {
      $('.btnsplit').attr("hidden", "hidden");
      setTimeout(function() {
        $('#qtySplit').val(b_d - sum);
        let z_z = Number((a/(wss/ur))*100)/100;
        $(`#target0_pe${t}`).val(z_z.toFixed(5));
      }, 200);
    }
  }, 100);
}

//INI UNTUK COLLAPSE
const changeQtyValue_ = (t, i) => {
  let a = $(`#qty0${i}_wipp${t}`).val();
  let b = $(`#qtySplit${i}`).val();
  let b_d = $('#qty_split_save' + i).val();
  let ur = $('#usage_rate_split' + i).val();
  let wss = $('#waktuSaveWIIP').val();

  let sum = 0;
  const q_q = $('.line0wipp' + i).find('.iminhere' + i).toArray();
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
        const q_p = $('.line0wipp' + i).find('.iminhere' + i).toArray();
        q_p.forEach((v, i) => {
          sum_s += Math.round($(v).val())
        })
        setTimeout(function() {
          $('#qtySplit' + i).val(b_d - sum_s);
        }, 300);
      })
    } else if (Number(b_d - sum) == 0) {
      $('.btnsplit' + i).removeAttr("hidden"); //nanti ==============
      setTimeout(function() {
        $('#qtySplit' + i).val(b_d - sum);
        $(`#target0${i}_pe${t}`).val(Number((a/(wss/ur))*100)/100);
      }, 200);
    } else {
      $('.btnsplit' + i).attr("hidden", "hidden"); //nanti ==============
      setTimeout(function() {
        $('#qtySplit' + i).val(b_d - sum);
        // let z_z = wss / (a / ur);
        let z_z = Number((a/(wss/ur))*100)/100;
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
  // console.log(path);
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
          } else {
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
      jenis: $('#jenisSaveWIIP').val(),
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
          window.location.replace(baseurl + 'WorkInProcessPackaging/JobManager/ArrangeJobList/' + $('#dateSaveWIIP').val() + '_' + $('#jenisSaveWIIP').val().substring(0, 1));
        })
      } else if (result === 2) {
        swalWIPPToastrAlert('error', 'Gagal menyimpan data!, RKH dengan tanggal ' + $('#dateSaveWIIP').val() + ' dengan jenis '+ $('#jenisSaveWIIP').val() +' telah ada di database.');
      } else {
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
    $(this).find('td:first').html(`<center>${i + 1}</center>`);
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
        beforeSend: function() {
          Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
          }).fire({
            customClass: 'swal-font-small',
            type: 'info',
            title: 'Sedang menghapus...'
          })
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

              $.ajax({
                url: baseurl + 'WorkInProcessPackaging/JobManager/getTargetMaxPE',
                type: 'POST',
                dataType: 'JSON',
                async: true,
                data: {
                  param: '',
                },
                success: function(result) {
                  $('#target_pe_line1').html() == '' ? $('#target_pe_line1').html(result[0].target_max) : '';
                  $('#target_pe_line2').html() == '' ? $('#target_pe_line2').html(result[1].target_max) : '';
                  $('#target_pe_line3').html() == '' ? $('#target_pe_line3').html(result[2].target_max) : '';
                  $('#target_pe_line4').html() == '' ? $('#target_pe_line4').html(result[3].target_max) : '';
                  $('#target_pe_line5').html() == '' ? $('#target_pe_line5').html(result[4].target_max) : '';
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                  console.error();
                }
              })

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

      $(`#nama_komponen`).val(result[0].DESCRIPTION);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
})

const gantiKomp = (param) => {
  let val = $(`.kode_item_upd_${param}`).val();
  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/JobReleaseSelected',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      term: val,
    },
    beforeSend: function() {
      $(`#nama_komponen_update_${param}`).val('Loading...');
    },
    success: function(result) {
      $(`#nama_komponen_update_${param}`).val(result[0].DESCRIPTION);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

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
  $('#tambahisiwipp0' + id).append(`<tr class="rowbaru0_wipp" id="wipp0row${n}">
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
      let b_d = $('#qty_split_save' + id).val();
      let sum = 0;
      const q_q = $('.line0wipp' + id).find('.iminhere').toArray();
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

const minus_wipp5 = (n, id_job_list) => {
  $('#jobid5_' + n).remove();
  $('#job5_wipp' + n).parents('.rowbaru5_wipp').remove()
  let total_sebelumnya = $('#total_ppic_5').html()

  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/getappendToJobList',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      id_job: id_job_list,
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      Swal.close()

      let setelah_dikurangi = Number(total_sebelumnya.substring(0, total_sebelumnya.trim().length - 1)) - Number((Number(result[0].qty) / (Number(result[0].waktu_satu_shift) / Number(result[0].usage_rate))) * 100 / 100)
      if (setelah_dikurangi === 'NaN') {
        setelah_dikurangi = 0;
      }

      $('#total_ppic_5').html(`${setelah_dikurangi.toFixed(3)}%`);
      let n = $('.tblwiip4 tbody tr:last td:first-child center').html();
      if (n === undefined) {
        n = 0
      }
      let a = Number(n) + 1;
      $('#tambahisilistjobyangadadiarrange').append(`<tr class="id-list-arrange-${id_job_list}">
                                                        <td>
                                                          <center>${a}</center>
                                                        </td>
                                                        <td>
                                                          <center>${result[0].no_job}</center>
                                                        </td>
                                                        <td>
                                                          <center>${result[0].kode_item}</center>
                                                        </td>
                                                        <td>
                                                          <center>${result[0].nama_item}</center>
                                                        </td>
                                                        <td style="background:rgba(58, 149, 215, 0.3)">
                                                          <center>${result[0].qty}</center>
                                                        </td>
                                                        <td>
                                                          <center>${result[0].usage_rate}</center>
                                                        </td>
                                                        <td>
                                                          <center>${result[0].scedule_start_date}</center>
                                                        </td>
                                                        <td style="background:rgba(58, 149, 215, 0.3)">
                                                          <center>
                                                          ${(Number(result[0].qty)/(Number(result[0].waktu_satu_shift)/Number(result[0].usage_rate)))*100/100}%
                                                          </center>
                                                        </td>
                                                        <td>
                                                          <center><button type="button" class="btn btn-md bg-navy" onclick="getModalSplit('${result[0].no_job}', '${result[0].qty_parrent != '' ? result[0].qty_parrent : result[0].qty}', '${result[0].kode_item}', '${result[0].nama_item}', '${Number(result[0].waktu_satu_shift)/(Number(result[0].qty)/Number(result[0].usage_rate))}',
                                                          '${result[0].usage_rate}', '${result[0].waktu_satu_shift}', '${result[0].date_target}', '${result[0].create_at}', '${result[0].qty_parrent}')" data-toggle="modal" data-target="#wipp2" name="button"><i class="fa fa-cut"></i> <b>Split</b></button></center>
                                                          <input type="hidden" id="id_job_list" value="${id_job_list}">
                                                        </td>
                                                        <td hidden><center>${id_job_list}</center></td>
                                                        <td hidden><center>${(Number(result[0].waktu_satu_shift)/(Number(result[0].qty)/Number(result[0].usage_rate)))}</center></td>
                                                      </tr>`);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
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

const minus_wipp4 = (n, id_job_list) => {
  $('#jobid4_' + n).remove();
  $('#job4_wipp' + n).parents('.rowbaru4_wipp').remove()
  let total_sebelumnya = $('#total_ppic_4').html()

  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/getappendToJobList',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      id_job: id_job_list,
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      Swal.close()
      let setelah_dikurangi = Number(total_sebelumnya.substring(0, total_sebelumnya.trim().length - 1)) - Number((Number(result[0].qty) / (Number(result[0].waktu_satu_shift) / Number(result[0].usage_rate))) * 100 / 100)
      // // console.log(setelah_dikurangi);
      // // console.log(total_sebelumnya.substring(0, total_sebelumnya.trim().length - 1));
      if (setelah_dikurangi === 'NaN') {
        setelah_dikurangi = 0;
      }
      $('#total_ppic_4').html(`${setelah_dikurangi.toFixed(3)}%`);
      let n = $('.tblwiip4 tbody tr:last td:first-child center').html();
      if (n === undefined) {
        n = 0
      }
      let a = Number(n) + 1;
      $('#tambahisilistjobyangadadiarrange').append(`<tr class="id-list-arrange-${id_job_list}">
                                                      <td>
                                                        <center>${a}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].no_job}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].kode_item}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].nama_item}</center>
                                                      </td>
                                                      <td style="background:rgba(58, 149, 215, 0.3)">
                                                        <center>${result[0].qty}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].usage_rate}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].scedule_start_date}</center>
                                                      </td>
                                                      <td style="background:rgba(58, 149, 215, 0.3)">
                                                        <center>
                                                        ${(Number(result[0].qty)/(Number(result[0].waktu_satu_shift)/Number(result[0].usage_rate)))*100/100}%
                                                        </center>
                                                      </td>
                                                      <td>
                                                        <center><button type="button" class="btn btn-md bg-navy" onclick="getModalSplit('${result[0].no_job}', '${result[0].qty_parrent != '' ? result[0].qty_parrent : result[0].qty}', '${result[0].kode_item}', '${result[0].nama_item}', '${Number(result[0].waktu_satu_shift)/(Number(result[0].qty)/Number(result[0].usage_rate))}',
                                                        '${result[0].usage_rate}', '${result[0].waktu_satu_shift}', '${result[0].date_target}', '${result[0].create_at}', '${result[0].qty_parrent}')" data-toggle="modal" data-target="#wipp2" name="button"><i class="fa fa-cut"></i> <b>Split</b></button></center>
                                                        <input type="hidden" id="id_job_list" value="${id_job_list}">
                                                      </td>
                                                      <td hidden><center>${id_job_list}</center></td>
                                                      <td hidden><center>${(Number(result[0].waktu_satu_shift)/(Number(result[0].qty)/Number(result[0].usage_rate)))}</center></td>
                                                    </tr>`);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
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

const minus_wipp3 = (n, id_job_list) => {
  $('#jobid3_' + n).remove();
  $('#job3_wipp' + n).parents('.rowbaru3_wipp').remove()
  let total_sebelumnya = $('#total_ppic_3').html()

  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/getappendToJobList',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      id_job: id_job_list,
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      Swal.close()
      let setelah_dikurangi = Number(total_sebelumnya.substring(0, total_sebelumnya.trim().length - 1)) - Number((Number(result[0].qty) / (Number(result[0].waktu_satu_shift) / Number(result[0].usage_rate))) * 100 / 100)
      if (setelah_dikurangi === 'NaN') {
        setelah_dikurangi = 0;
      }

      $('#total_ppic_3').html(`${setelah_dikurangi.toFixed(3)}%`);
      let n = $('.tblwiip4 tbody tr:last td:first-child center').html();
      if (n === undefined) {
        n = 0
      }
      let a = Number(n) + 1;
      $('#tambahisilistjobyangadadiarrange').append(`<tr class="id-list-arrange-${id_job_list}">
                                                      <td>
                                                        <center>${a}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].no_job}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].kode_item}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].nama_item}</center>
                                                      </td>
                                                      <td style="background:rgba(58, 149, 215, 0.3)">
                                                        <center>${result[0].qty}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].usage_rate}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].scedule_start_date}</center>
                                                      </td>
                                                      <td style="background:rgba(58, 149, 215, 0.3)">
                                                        <center>
                                                        ${(Number(result[0].qty)/(Number(result[0].waktu_satu_shift)/Number(result[0].usage_rate)))*100/100}%
                                                        </center>
                                                      </td>
                                                      <td>
                                                        <center><button type="button" class="btn btn-md bg-navy" onclick="getModalSplit('${result[0].no_job}', '${result[0].qty_parrent != '' ? result[0].qty_parrent : result[0].qty}', '${result[0].kode_item}', '${result[0].nama_item}', '${Number(result[0].waktu_satu_shift)/(Number(result[0].qty)/Number(result[0].usage_rate))}',
                                                        '${result[0].usage_rate}', '${result[0].waktu_satu_shift}', '${result[0].date_target}', '${result[0].create_at}', '${result[0].qty_parrent}')" data-toggle="modal" data-target="#wipp2" name="button"><i class="fa fa-cut"></i> <b>Split</b></button></center>
                                                        <input type="hidden" id="id_job_list" value="${id_job_list}">
                                                      </td>
                                                      <td hidden><center>${id_job_list}</center></td>
                                                      <td hidden><center>${(Number(result[0].waktu_satu_shift)/(Number(result[0].qty)/Number(result[0].usage_rate)))}</center></td>
                                                    </tr>`);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
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

const minus_wipp2 = (n, id_job_list) => {
  $('#jobid2_' + n).remove();
  $('#job2_wipp' + n).parents('.rowbaru2_wipp').remove()
  let total_sebelumnya = $('#total_ppic_2').html()

  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/getappendToJobList',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      id_job: id_job_list,
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      Swal.close()
      console.log(result);
      let setelah_dikurangi = Number(total_sebelumnya.substring(0, total_sebelumnya.trim().length - 1)) - Number((Number(result[0].qty) / (Number(result[0].waktu_satu_shift) / Number(result[0].usage_rate))) * 100 / 100)
      if (setelah_dikurangi === 'NaN') {
        setelah_dikurangi = 0;
      }

      $('#total_ppic_2').html(`${setelah_dikurangi.toFixed(3)}%`);

      let n = $('.tblwiip4 tbody tr:last td:first-child center').html();
      if (n === undefined) {
        n = 0
      }
      let a = Number(n) + 1;
      $('#tambahisilistjobyangadadiarrange').append(`<tr class="id-list-arrange-${id_job_list}">
                                                      <td>
                                                        <center>${a}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].no_job}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].kode_item}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].nama_item}</center>
                                                      </td>
                                                      <td style="background:rgba(58, 149, 215, 0.3)">
                                                        <center>${result[0].qty}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].usage_rate}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].scedule_start_date}</center>
                                                      </td>
                                                      <td style="background:rgba(58, 149, 215, 0.3)">
                                                        <center>
                                                        ${(Number(result[0].qty)/(Number(result[0].waktu_satu_shift)/Number(result[0].usage_rate)))*100/100}%
                                                        </center>
                                                      </td>
                                                      <td>
                                                        <center><button type="button" class="btn btn-md bg-navy" onclick="getModalSplit('${result[0].no_job}', '${result[0].qty_parrent != '' ? result[0].qty_parrent : result[0].qty}', '${result[0].kode_item}', '${result[0].nama_item}', '${Number(result[0].waktu_satu_shift)/(Number(result[0].qty)/Number(result[0].usage_rate))}',
                                                        '${result[0].usage_rate}', '${result[0].waktu_satu_shift}', '${result[0].date_target}', '${result[0].create_at}', '${result[0].qty_parrent}')" data-toggle="modal" data-target="#wipp2" name="button"><i class="fa fa-cut"></i> <b>Split</b></button></center>
                                                        <input type="hidden" id="id_job_list" value="${id_job_list}">
                                                      </td>
                                                      <td hidden><center>${id_job_list}</center></td>
                                                      <td hidden><center>${(Number(result[0].waktu_satu_shift)/(Number(result[0].qty)/Number(result[0].usage_rate)))}</center></td>
                                                    </tr>`);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

const addLaneArrange = (line, target_pe, no, id) => {
  let target_pe_max = $('#target_pe_line' + line).html();
  // let item_selected = $('.item-selected-arrange-'+no).html();
  let item_selected = Array.prototype.map.call(document.querySelectorAll(`.item-selected-arrange-${no} td center`), function(td) {
    return td.innerHTML;
  });
  let tampung_pe = $('.tampung_pe_' + line).map((_, el) => el.value).get();
  tampungan = 0;
  tampung_pe.forEach((val, i) => {
    tampungan += Number(val);
  })

  let count_to_cek = Number(tampungan) + Number(target_pe);

  let getJob = $('.get-job-' + line).map((_, el) => el.value).get();

  // update count PPIC
  let total_sebelumnya = $('#total_ppic_' + line).html()
  let total_ppic_setelah_ditambahkan = Number(item_selected[7].trim().substring(0, item_selected[7].trim().length - 1)) + Number(total_sebelumnya.substring(0, total_sebelumnya.trim().length - 1));
  $('#total_ppic_' + line).html(`${total_ppic_setelah_ditambahkan.toFixed(3)}%`);

  if (getJob.includes(item_selected[1])) {
    swalWIPP('warning', `Pada Line ${line} sudah terdapat no job ${item_selected[1]}`);
  } else {
    if (count_to_cek > target_pe_max) {
      swalWIPP('warning', `Jumlah Target PE (${count_to_cek.toFixed(5)}) > Target PE Max (${target_pe_max})`)
    } else {
      let n = $(`.line${line}wipp tbody tr`).length;
      let a = n + 1;
      $(`#tambahisiwipp${line}`).append(`<tr class="rowbaru${line}_wipp" id="wipp${line}row1">
                                          <td>
                                            <center>
                                              <input type="text" class="form-control" id="job${line}_wipp${a}" name="job${line}[]" value="${item_selected[1]}" readonly>
                                            </center>
                                          </td>
                                          <td><center><input type="text" class="form-control" value="${item_selected[2]}" name="item${line}[]" id="item${line}_wipp${a}" readonly placeholder="ITEM"></center></td>
                                          <td><center><input type="number" class="form-control" value="${item_selected[4]}" name="qty${line}[]" id="qty${line}_wipp${a}" readonly placeholder="QTY"></center></td>
                                          <td>
                                           <center>
                                           <input type="text" class="form-control" value="${item_selected[7].trim().substring(0, item_selected[7].trim().length - 1)}" placeholder="50%" readonly>
                                           <input type="hidden" class="form-control tampung_pe_${line}" name="target${line}[]" value="${target_pe}" id="target${line}_pe${a}" placeholder="50%">
                                           </center>
                                          </td>
                                          <td><center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp${line}(${a}, ${id})" style="border-radius:10px;"name="button"><i class="fa fa-minus-square"></i></button></center></td>
                                        </tr>
                                        <input type="hidden" name="id_job_list${line}[]" id="jobid${line}_${a}" value="${id}">
                                        `);
      $('.item-selected-arrange-' + item_selected[0]).remove()
      $('.id-list-arrange-' + id).remove()
    }
  }



}

const addrowlinewipp = (cek, line) => {
  $('.areaplusitem').html('');
  $('#ini-line').html(line);
  if (cek === 0) {
    $('#infoAddItem').html('Ada Dos')
  } else {
    $('#infoAddItem').html('Tidak Ada Dos')
  }
  let get = $('.nojob').html();
  let tableInfo = Array.prototype.map.call(document.querySelectorAll('#tambahisilistjobyangadadiarrange tr'), function(tr) {
    return Array.prototype.map.call(tr.querySelectorAll('td center'), function(td) {
      return td.innerHTML;
    });
  });
  let tampung
  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/bedaindosNbukandos',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      data: tableInfo,
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      Swal.close()
      if (cek === 0) {
        tampung = result.adados;
      } else if (cek === 1) {
        tampung = result.gaadados;
      }
      if (tampung == '') {
        $('.areaplusitem').html('<tr><td colspan="9"><center>Data is empty.</center></td></tr>')
      }
      //// console.log(tampung);
      tampung.forEach((val, i) => {
        $('.areaplusitem').append(`<tr class="item-selected-arrange-${i+1}">
                                    <td>
                                      <center>${i+1}</center>
                                    </td>
                                    <td>
                                      <center>${val[1]}</center>
                                    </td>
                                    <td>
                                      <center>${val[2]}</center>
                                    </td>
                                    <td>
                                      <center>${val[3]}</center>
                                    </td>
                                    <td style="background:rgba(58, 149, 215, 0.3)">
                                      <center>${val[4]}</center>
                                    </td>
                                    <td>
                                      <center>${val[5]}</center>
                                    </td>
                                    <td>
                                      <center>${val[6]}</center>
                                    </td>
                                    <td style="background:rgba(58, 149, 215, 0.3)">
                                      <center>
                                      ${val[7]}
                                      </center>
                                    </td>
                                    <td>
                                      <center><button type="button" onclick="addLaneArrange(${line}, ${val[10]}, ${i+1}, ${val[9]})" class="btn btn-md bg-navy" name="button"><i class="fa fa-mail-forward"></i> <b>ADD</b></button></center>
                                    </td>
                                    <td hidden>${val[9]}</td>
                                  </tr>`);
      })
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      // swalWIPP('error', 'Data kosong, data tidak ditemukan di detail bom.');
      Swal.close()
      console.error();
    }
  })


}

const minus_wipp1 = (n, id_job_list) => {
  $('#jobid1_' + n).remove();
  $('#job1_wipp' + n).parents('.rowbaru1_wipp').remove()

  let total_sebelumnya = $('#total_ppic_1').html()

  $.ajax({
    url: baseurl + 'WorkInProcessPackaging/JobManager/getappendToJobList',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      id_job: id_job_list,
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      Swal.close()

      let setelah_dikurangi = Number(total_sebelumnya.substring(0, total_sebelumnya.trim().length - 1)) - Number((Number(result[0].qty) / (Number(result[0].waktu_satu_shift) / Number(result[0].usage_rate))) * 100 / 100)
      if (setelah_dikurangi === 'NaN') {
        setelah_dikurangi = 0;
      }

      // // console.log(Number(total_sebelumnya.substring(0, total_sebelumnya.trim().length - 1)));
      // // console.log(Number((Number(result[0].waktu_satu_shift)/(Number(result[0].qty)/Number(result[0].usage_rate)))*result[0].qty));
      // // console.log(setelah_dikurangi);

      $('#total_ppic_1').html(`${setelah_dikurangi.toFixed(3)}%`);

      let n = $('.tblwiip4 tbody tr:last td:first-child center').html();
      if (n === undefined) {
        n = 0
      }
      let a = Number(n) + 1;
      $('#tambahisilistjobyangadadiarrange').append(`<tr class="id-list-arrange-${id_job_list}">
                                                      <td>
                                                        <center>${a}</center>
                                                      </td>
                                                      <td>
                                                        <center class="nojob">${result[0].no_job}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].kode_item}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].nama_item}</center>
                                                      </td>
                                                      <td style="background:rgba(58, 149, 215, 0.3)">
                                                        <center>${result[0].qty}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].usage_rate}</center>
                                                      </td>
                                                      <td>
                                                        <center>${result[0].scedule_start_date}</center>
                                                      </td>
                                                      <td style="background:rgba(58, 149, 215, 0.3)">
                                                        <center>
                                                        ${(Number(result[0].qty)/(Number(result[0].waktu_satu_shift)/Number(result[0].usage_rate)))*100/100}%
                                                        </center>
                                                      </td>
                                                      <td>
                                                        <center><button type="button" class="btn btn-md bg-navy" onclick="getModalSplit('${result[0].no_job}', '${result[0].qty_parrent != '' ? result[0].qty_parrent : result[0].qty}', '${result[0].kode_item}', '${result[0].nama_item}', '${Number(result[0].waktu_satu_shift)/(Number(result[0].qty)/Number(result[0].usage_rate))}',
                                                        '${result[0].usage_rate}', '${result[0].waktu_satu_shift}', '${result[0].date_target}', '${result[0].create_at}', '${result[0].qty_parrent}')" data-toggle="modal" data-target="#wipp2" name="button"><i class="fa fa-cut"></i> <b>Split</b></button></center>
                                                        <input type="hidden" id="id_job_list" value="${id_job_list}">
                                                      </td>
                                                      <td hidden><center>${id_job_list}</center></td>
                                                      <td hidden><center>${(Number(result[0].waktu_satu_shift)/(Number(result[0].qty)/Number(result[0].usage_rate)))}</center></td>
                                                    </tr>`);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error();
    }
  })
}

$('.tblwiip').DataTable({
  "pageLength": 10,
});

const readFile = input => {
  if (input.files && input.files[0]) {
    let reader = new FileReader();

    reader.onload = function(e) {
      $('#showPre')
        .attr('src', e.target.result)
        .height(350);
    };
    reader.readAsDataURL(input.files[0]);
  }
}

const readFileForEdit = input => {
  if (input.files && input.files[0]) {
    let reader = new FileReader();

    reader.onload = function(e) {
      $('#showPreEdit')
        .attr('src', e.target.result)
        .height(350);
    };
    reader.readAsDataURL(input.files[0]);
  }
}

$('.txtWIIPdate').datepicker({
  "autoclose": true,
  "todayHighlight": true,
  "allowClear": true,
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
//     // console.log(result);
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


// saveSplit_

// // console.log(html);
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
