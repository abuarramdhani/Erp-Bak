
<div class="box box-primary collapsed-box" style="margin-bottom:13px;background:#e1f0fe">
  <div class="box-header with-border">
    <h3 class="box-title"> <b class="fa fa-cube" style="color:#0f74c7"></b> <b style="color:#0f7ac7">Gambar Kerja (<span id="fp_code_product_2"></span>)</b></h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-primary btn-sm" onclick="getgambarkerja_beda_tempat()" data-widget="collapse"><i class="fa fa-eye" style="color:white"></i></b>
      </button>
    </div>
  </div>
  <div class="box-body area-gambar-kerja-kedua collapse" style="display: none;">
  </div>
</div>

<p class="text-danger" style="padding-top:10px;margin-bottom:-23px">
*Drag kolom dengan simbol &nbsp;<b class="fa fa-sort"></b>&nbsp; untuk mengatur sequence
</p>
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left datatable-proses-fp" style="font-size:11px;">
    <thead class="bg-primary">
      <tr>
        <th style="text-align:center; width:5%">
            Seq
        </th>
        <th style="text-align:center">Select</th>
        <th>
            Operation Code
        </th>
        <th >
            Operation Description
        </th>
        <th>
            Flag
        </th>
        <th>
            Make Buy
        </th>
        <th>
            Proses
        </th>
        <th>
            Detail Proses
        </th>
        <th>Status</th>
        <th>
            Machine Req
        </th>
        <th>
            Machine Num
        </th>
        <th>
            Resource
        </th>
        <th>
            Inspectool
        </th>
        <th>
            Tool
        </th>
        <th hidden></th>
        <th hidden></th>
        <th hidden></th>
        <th hidden></th>
        <th hidden></th>
        <th hidden></th>
        <th hidden></th>
        <th hidden></th>
        <th hidden></th>
        <th hidden></th>
        <th hidden></th>
        <th hidden></th>
        <th>Bahan Penolong</th>
    </tr>
    </thead>
    <tbody class="fp_sort" id="fp_comp_detail_proses" >
      <?php foreach ($get as $key => $value): ?>
        <tr onclick="fp_check_click()" row-fp-pb="<?php echo $value['id'] ?>" draggable="true">
          <td style="width:5%" class="drag_flow_proses"><center><b class="fa fa-sort"></b> <span class="fp_seq"><?php echo $key+1 ?></span></center></td>
          <td style="width:5%"></td>
          <td style="width:7.12%"><?php echo $value['opr_code'] ?></td>
          <td style="width:10%"><?php echo $value['opr_desc'] ?></td>
          <td style="width:7.12%"><?php echo $value['inv_item_flag'] ?></td>
          <td style="width:7.12%"><?php echo $value['make_buy'] ?></td>
          <td style="width:7.12%"><?php echo $value['operation_std'] ?> - <?php echo $value['operation_desc'] ?></td>
          <td style="width:10%"><?php echo $value['dtl_process'] ?></td>
          <?php
            if (empty($value['status']) || $value['status'] == 'Y') {
              $c = "background:#1bc482";
              $stat = "Active";
            }else {
              $c = "background:#e22e2e";
              $stat = "Inactive";
            }
           ?>
          <td style="<?php echo $c ?>;width:7.12%;height:auto">
            <?php echo $stat ?>
          </td>
          <td style="width: 7.12%"><?php $mq = explode(' - ',$value['machine_req']); echo $mq[0] ?></td>
          <td style="width: 7.12%"><?php echo $value['machine_num'] ?></td>
          <td style="width: 7.12%"><?php $c = explode(' - ',$value['resource']); echo $c[0]; ?></td>
          <td style="width: 7.12%">
          <?php
            if ($value['inspectool_id'] == 1) {
              echo "Yes";
            }elseif ($value['inspectool_id'] == 0) {
              echo "No";
            }
           ?>
          </td>
          <td style="width: 7.12%"><?php
            if ($value['tool_id'] == 1) {
              echo "New";
            }elseif ($value['tool_id'] == 2) {
              echo "Exiting";
            }else {
              echo "Modif";
            }
           ?></td>
           <td hidden><?php echo $value['id'] ?></td>
           <td hidden><?php echo $value['operation_process'] ?></td>
           <td hidden><?php echo $value['machine_req'] ?></td>
           <td hidden><?php echo $value['destination'] ?></td>
           <td hidden><?php echo $value['resource'] ?></td>
           <td hidden><?php echo $value['qty_machine'] ?></td>
           <td hidden><?php echo $value['tool_id'] ?></td>
           <td hidden><?php echo $value['inspectool_id'] ?></td>
           <td hidden><?php echo $value['tool_exiting'] ?></td>
           <td hidden><?php echo $value['tool_measurement'] ?></td>
           <td hidden><?php echo $value['jenis_proses'] ?></td>
           <td hidden><?php echo $value['nomor_jenis_proses'] ?></td>
           <td>
             <button type="button" class="btn btn-success" onclick="fp_detail_bahan_penolong(<?php echo $value['id'] ?>, '<?php echo $value['opr_code'] ?>')" style="border-radius:7px;" name="button"> <i class="fa fa-eye"></i> </button>
           </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<br>
<input type="hidden" id="txt_count_tr_proses_fp" value="<?php echo !empty($get) ? $key+1 : 0 ?>">

<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalfp1" onclick="add_prosess_per_component()" style="border-radius:7px;" name="button"> <i class="fa fa-plus"></i> <b>Add Process</b> </button>
<button type="button" class="btn btn-success fp_update_proses_component" data-toggle="modal" data-target="#modalfp1" onclick="fp_update_proses_component()" style="border-radius:7px;display:none;" name="button"> <i class="fa fa-pencil"></i> <b>Update Process</b> </button>
<button type="button" class="btn btn-danger fp_del_proses" onclick="del_prosess_per_component()" style="border-radius:7px;display:none" name="button"> <i class="fa fa-trash"></i> <b>Delete</b> </button>
<button type="button" class="btn btn-success fp_set_active_proses" onclick="fp_set_inactive_proses()" style="border-radius:7px;float:right;display:none" name="button"> <i class="fa fa-times"></i> <b id="txt_fp_stat">Set Inactive</b> </button>

<div class="modal fade bd-example-modal-lg" id="modal_fp_bp" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left;margin-top:6px;">
                  <h4 style="font-weight:bold;display:inline;">Setting Bahan Penolong (<span id="code_comp_fp_bp"></span>)</h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <h6 style="margin-top:-2px;"> <b>NB :</b>
                      <ul style="margin-top: 5px;margin-left: -23px;">
                        <li>Jika anda menutup modal form inputan ini, data yang anda isi akan ter-reset.</li>
                        <li><b>Form Input Component Code</b> dapat dicari berdasarkan code_component atau description</li>
                      </ul>
                    </h6>
                    <table class="table table-bordered fp_tbl_penolong_edit" style="margin-top:13px;">
                      <thead style="font-weight:bold">
                        <tr>
                          <td style="text-align:center;vertical-align:middle;width:5%">No</td>
                          <td style="width:70%;vertical-align:middle">
                            Component Code
                          </td>
                          <td style="width:15%;vertical-align:middle">
                            Quantity
                          </td>
                          <td style="width:25%">
                            UOM
                          </td>
                          <td style="vertical-align:middle">
                            <center><button type="button" name="button" class="btn btn-sm" onclick="fp_bp_plus_proses_edit()"><i class="fa fa-plus-square"></i></button></center>
                          </td>
                      </thead>
                      <tbody id="edit_fp_pb">

                      </tbody>
                    </table>
                    <div class="btn-fp-bp-update" style="margin-top:-10px;">

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
</div>

<script type="text/javascript">

function fp_bp_plus_proses_edit() {
    let n = $(`.fp_tbl_penolong_edit tr`).length;
    let no = Number(n);
  $('.fp_tbl_penolong_edit tbody').append(`<tr row-id-edit="${no}">
                                <td style="text-align:center;vertical-align:middle;width:5%">${no}</td>
                                <td style="width:70%">
                                  <select class="form-control select2FP_Oracle_Second fp_bp_component_code_edit fp_get_uom_${no}" onchange="fp_isi_uom(${no})" style="width:100%" required>
                                    <option value="" selected>Component Code ...</option>
                                  </select>
                                </td>
                                <td style="width:15%">
                                  <input type="number" placeholder="QTY" class="form-control fp_bp_qty_edit" value="">
                                </td>
                                <td style="width:25%">
                                  <input type="text" placeholder="UOM" class="form-control fp_uom_hia_${no}" readonly value="">
                                </td>
                                <td style="vertical-align:middle">
                                  <center><button type="button" name="button" class="btn btn-sm" onclick="fp_bp_minus_proses_edit(${no})"><i class="fa fa-minus-square"></i></button></center>
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

function fp_bp_minus_proses_edit(no) {
  $(`.fp_tbl_penolong_edit tr[row-id-edit="${no}"]`).remove();
}

  const fp_dt_proses = $('.datatable-proses-fp').DataTable({
    "paging":   false,
    "ordering": false,
    // "info":
    columnDefs: [
      {
        orderable: false,
        className: 'select-checkbox',
        targets: 1
      }
    ],
    select: {
      style: 'multi',
      // style: 'single', selector: 'tr'
      selector: 'td:nth-child(2)'
    },
    order: [[0, 'asc']],
  })

  function update_fp_bp_submit(id, code) {

    let component_code = $('.fp_bp_component_code_edit').map((_, el) => el.value).get()
    let qty_component = $('.fp_bp_qty_edit').map((_, el) => el.value).get()
    let id_bp = $('.fp_bp_id').map((_, el) => el.value).get()
    if (component_code != '') {
      let tampung_bahan_penolong = [];
      component_code.forEach((v,i) => {
        let split_hh = v.split(" - ");
        let item_list_f = {
          'component_code':split_hh[0],
          'component_desc':split_hh[1],
          'uom':split_hh[2],
          'qty':qty_component[i],
          'id_operation':id,
          'id':id_bp[i]
        }
        tampung_bahan_penolong.push(item_list_f);
      })
      $.ajax({
        url: baseurl + 'FlowProses/Operation/update_adjuvant',
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
            text: `Sedang memproses data...`
          })
        },
        success: function(results) {
          if (results) {
            toastFP('success', 'Bahan Penolong Berhasil Diupdate.')
            $('#modal_fp_bp').modal('toggle');
            fp_detail_bahan_penolong(id, code)
          }else {
            toastFP('warning', 'Terjadi Kesalahan Saat Menginput Bahan Penolong!.')
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          toastFP('error', 'Terjadi Kesalahan saat mengambil data!')
        }
      })
    }else {
      toastFP('warning', 'Item Tidak Boleh Kosong!')
    }
  }



  function fp_bp_edit_data(id, code) {
    $('#edit_fp_pb').html('');
    let tableInfo = Array.prototype.map.call(document.querySelectorAll(`.fp_tbl_dt_${id} tbody tr`), function(tr){
      return Array.prototype.map.call(tr.querySelectorAll('td'), function(td){
        return td.innerHTML;
        });
      });
     tableInfo.forEach((v,i)=>{
       $('#edit_fp_pb').append(`<tr row-id-edit="${v[0]}">
                                 <td style="text-align:center;vertical-align:middle;width:5%">${v[0]}</td>
                                 <td style="width:70%">
                                   <select class="form-control select2FP_Oracle_Second fp_bp_component_code_edit fp_get_uom_${v[0]}" onchange="fp_isi_uom(${v[0]})" style="width:100%" required>
                                     <option value="${v[1]} - ${v[2]} - ${v[4]}" selected>${v[1]} - ${v[2]}</option>
                                   </select>
                                 </td>
                                 <td style="width:15%">
                                   <input type="hidden" class="fp_bp_id" value="${v[5]}">
                                   <input type="number" placeholder="QTY" class="form-control fp_bp_qty_edit" value="${v[3]}">
                                 </td>
                                 <td style="width:25%">
                                   <input type="text" placeholder="UOM" class="form-control fp_uom_hia_${v[0]}" readonly value="${v[4]}">
                                 </td>
                                 <td style="vertical-align:middle">
                                   <center><button type="button" name="button" class="btn btn-sm" onclick="fp_bp_minus_proses_edit(${v[0]})"><i class="fa fa-minus-square"></i></button></center>
                                 </td>
                               </tr>`)
     })

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

     $('.btn-fp-bp-update').html(`<br>
                                 <center>
                                   <button type="button" class="btn btn-success fp_save_update_bp" style="width:30%;margin-bottom:10px;" onclick="update_fp_bp_submit(${id}, '${code}')" name="button"> <i class="fa fa-file"></i> <b>Update</b> </button>
                                 </center>`)

  }

  function fp_bp_empty(id, code) {
    $('#edit_fp_pb').html('');
    $('.btn-fp-bp-update').html(`<br>
                                <center>
                                  <button type="button" class="btn btn-success fp_save_update_bp" style="width:30%;margin-bottom:10px;" onclick="update_fp_bp_submit(${id}, '${code}')" name="button"> <i class="fa fa-file"></i> <b>Update</b> </button>
                                </center>`)
  }

  function fp_dlt_pb(d, id) {
    return `<div class="fp_detail_bp${id}"></div>`;
  }

  function fp_detail_bahan_penolong(id, code) {
    $('#code_comp_fp_bp').html(code);
    let tr = $(`tr[row-fp-pb="${id}"]`);
    let row = fp_dt_proses.row(tr);
    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass('shown');
    } else {
      row.child(fp_dlt_pb(row.data(), id)).show();
      tr.addClass('shown');
      $.ajax({
        url: baseurl + 'FlowProses/Operation/getDetailPB',
        type: 'POST',
        async: true,
        dataType: 'JSON',
        data: {
          id: id,
        },
        beforeSend: function() {
          $('.fp_detail_bp' + id).html(`<div id="loadingArea0">
                                          <center><img style="width: 3%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                        </div>`)
        },
        success: function(result) {
          // console.log(result);
          if (result != 0) {
            let item
            let push = [];
            $('#edit_fp_pb').html('');

            result.forEach((v, i) => {
              item = `<tr style="text-align:center">
                        <td>${Number(i)+1}</td>
                        <td>${v.component_code}</td>
                        <td>${v.component_desc}</td>
                        <td>${v.qty}</td>
                        <td>${v.uom}</td>
                        <td hidden>${v.id}</td>
                      </tr>`;
              push.push(item);
              })

            let join = push.join(' ');
            let html = `<h5 style="font-weight:bold">Detail Bahan Penolong ( <button data-target="#modal_fp_bp" data-toggle="modal" style="color:#429fff;border:none;background:transparent" onclick="fp_bp_edit_data(${id}, '${code}')"> <i class="fa fa-pencil-square"></i>  Edit</button> )<h5>
                        <table ondragstart="return false" draggable="false" class="table table-striped table-bordered table-hover text-left fp_tbl_dt_${id}" style="font-size:12px;width:100%;float:right">
                         <thead>
                          <tr class="bg-success">
                            <th><center>NO</center></th>
                            <th><center>COMPONENT CODE</center></th>
                            <th><center>DESCRIPTION</center></th>
                            <th><center>QTY</center></th>
                            <th><center>UOM</center></th>
                            <th hidden><center></center></th>
                          </tr>
                        </thead>
                        <tbody>
                         ${join}
                        </tbody>
                      </table>`;
            $('.fp_detail_bp' + id).html(html)

          }else {
            $('#edit_fp_pb').html('');
            let html = `<h5 style="text-align:center">Tidak ada bahan penolong pada operation code ini. <br> ( <button style="color:#429fff;border:none;background:transparent;font-weight:bold" data-target="#modal_fp_bp" data-toggle="modal" onclick="fp_bp_empty(${id}, '${code}')"> <i class="fa fa-plus-square"></i>  Tambahkan</button> ) </h5>`
            $('.fp_detail_bp' + id).html(html)
          }

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }
  }

  function fp_update_proses_component() {
    $('#modalfp1').css({'display':'grid', 'margin-top':'44px'});
    $('#fp_tempat_save_operation').html(`Update`);
    $('.fp_cek_hidden_untuk_update').hide();
    $('.fp_tbl_penolong tbody').html('');
    // $('.fp_save_operation').hide()
    let data = fp_dt_proses.rows( { selected: true } ).data();
    $('#id_pd').val($('#fpsimpanidsementara').val())
    $('#component_code').val($('#code_product').html()+' - '+$('#fpsimpanidsementara_desc').val())
    $('#fp_judul_form_proses').html('Update Operation');
    $('#code_comp_sem').html($('#code_product').html());
    $('#fp_id_proses').val(data[0][14]);
    $('#opetation_code').val(data[0][2]);
    $('#opetaion_desc').val(data[0][3]);
    $('#detail_proses').val(data[0][7]);
    $('#machine_num').val(data[0][10]);
    $('#resource').val(data[0][11]);
    $('#flag').val(data[0][4]).trigger('change');
    $('#make_buy').val(data[0][5]).trigger('change');
    $('#operation_proses').val(data[0][15]).trigger('change');
    let item_ = new Option(`${data[0][16]}`, data[0][16], false, false);
    $('#machine_req').html(item_).trigger('change');
    //destination
    $.ajax({
      url: baseurl + 'FlowProses/Operation/getDestinasi',
      type: 'POST',
      dataType: 'JSON',
      async: true,
      beforeSend: function() {
        $('#fp_tampung_resource_sementara').val('')
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
    }).done(function () {
        $('.select2FP1').val(data[0][17]).trigger('change');
        $('#fp_tampung_resource_sementara').val(data[0][18])
    })
    //end
    $('#qty_machine').val(data[0][19])
    $('#tool').val(data[0][20]).trigger('change')
    $('#inspectool').val(data[0][21]).trigger('change')

    let tool_exiting_split = data[0][22].split(' _ ');
    let tool_exiting = new Option(tool_exiting_split[1], data[0][22], false, false);
    $('#tool_exiting').html(tool_exiting).trigger('change');

    let tool_measurement_split = data[0][23].split(' _ ');
    let tool_measurement = new Option(tool_measurement_split[1], data[0][23], false, false);
    $('#tool_measurement').html(tool_measurement).trigger('change');
    $('#jenis_proses').val(data[0][24]).trigger('change')
    $('#nomor_jenis_proses').val(data[0][25])
    let sequence = null;
    // $(`.fp_area_gambar_kerja_3`).html(`<div class="box box-primary collapsed-box" style="margin-bottom:13px;background:#e1f0fe">
    //                                     <div class="box-header with-border">
    //                                       <h3 class="box-title"> <b class="fa fa-cube" style="color:#0f74c7"></b> <b style="color:#0f7ac7">Gambar Kerja</b></h3>
    //
    //                                       <div class="box-tools pull-right">
    //                                         <button type="button" class="btn btn-primary btn-sm" onclick="getgambarkerja_beda_tempat()" data-widget="collapse"><i class="fa fa-eye" style="color:white"></i></b>
    //                                         </button>
    //                                       </div>
    //                                     </div>
    //                                     <div class="box-body area-gambar-kerja-kedua" style="display: none;">
    //                                     </div>
    //                                   </div>`)
  $(`.fp_area_gambar_kerja_3`).html(`<center style="position: fixed;width: 100%;top:0"><div class="box box-primary collapsed-box" style="margin-bottom:13px;background:#e1f0fe;width:80%;left:7.5px">
                                        <div class="box-header with-border" style="width:90%">
                                          <h3 class="box-title"> <b class="fa fa-cube" style="color:#0f74c7"></b> <b style="color:#0f7ac7">Gambar Kerja</b></h3>

                                          <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="getgambarkerja_beda_tempat_()" data-widget="collapse"><i class="fa fa-eye" style="color:white"></i></b>
                                            </button>
                                          </div>
                                        </div>
                                        <div class="box-body area-gambar-kerja-kedua" style="display: none;">
                                        </div>
                                      </div></center>`)
    // console.log(sequence);
  }


  function del_prosess_per_component() {

    let type = $('#fp_jenis_produk_ok').html().toLowerCase();
    let id_product_component = $('#fpsimpanidsementara').val();
    // delete area
    let data_list = fp_dt_proses.rows( { selected: true } ).data();
    let tampung_id_proses = [];
    for (var i = 0; i < data_list.length; i++) {
      tampung_id_proses.push(data_list[i][14]);
    }

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
          url: baseurl + 'FlowProses/Operation/del_prosess_per_component',
          type: 'POST',
          dataType: 'JSON',
          async: true,
          data: {
            id : tampung_id_proses,
          },
          beforeSend: function() {
            Swal.showLoading()
          },
          success: function(result) {
            if (result) {
              toastFP('success', 'Selesai.');
              $.ajax({
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
                    setTimeout(function () {
                      let tampung = [];
                      // $('.fp_sequence_proses').show();
                      $('.fp_seq').each(function(i){
                        $(this).html(i + 1);
                       });
                       var tableInfo = Array.prototype.map.call(document.querySelectorAll('tbody#fp_comp_detail_proses tr'), function(tr){
                         return Array.prototype.map.call(tr.querySelectorAll('td'), function(td){
                           return td.innerHTML;
                           });
                         });
                        tableInfo.forEach((v,i)=>{
                          let seq = {'id':v[14], 'sequence':Number(i)+1, 'operation_code':v[2]}
                          tampung.push(seq)
                        })
                        // console.log(tableInfo);
                        // ============
                        $.ajax({
                          url: baseurl + 'FlowProses/Operation/UpdateSequence',
                          type: 'POST',
                          dataType: 'JSON',
                          async: true,
                          data: {
                            data : tampung,
                          },
                          success: function(result) {
                            if (result) {
                              toastFP('success', 'Sequence Berhasil Diupdate.');
                            }else {
                              toastFP('warning', 'Terjadi kesalahan saat mengupdate sequence');
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
                        // ============
                    }, 50);
                  }else {
                    swalFP('warning', 'Gagal Mengambil Data, Coba lagi..');
                    $('.fp_search_area').show()
                    $('.fp-table-area').html(``);
                  }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                  swalFP('error', 'Something was wrong...')
                  $('.fp_search_area').show()
                  $('.fp-table-area').html(``);
                }
              })
            }else {
              swalFP('warning', 'Gagal Melakukan Update Data, Coba lagi..');
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

  // =================== hia ===============

  // ============hia============
  }

  function fp_check_click() {
    setTimeout(function () {
      let data_list = fp_dt_proses.rows( { selected: true } ).data()[0];
      if (fp_dt_proses.rows( { selected: true } ).data()[1] == undefined) {
        if (data_list != undefined) {
          if (data_list[8] == 'Active') {
            $('#txt_fp_stat').html('Set Inactive');
            $(".fp_set_active_proses").css("background", "#DD4B38");
          }else {
            $('#txt_fp_stat').html('Set Active');
            $(".fp_set_active_proses").css("background", "");

          }
          $('.fp_set_active_proses').show();
          $('.fp_update_proses_component').show();
        }else {
          $('.fp_set_active_proses').hide();
          $('.fp_update_proses_component').hide();
        }
      }else {
        $('.fp_set_active_proses').hide();
        $('.fp_update_proses_component').hide();
      }

      if (fp_dt_proses.rows( { selected: true } ).data()[0] == undefined) {
        $('.fp_del_proses').hide();
      }else {
        $('.fp_del_proses').show();
      }

    }, 50);
  }

  function fp_set_inactive_proses() {
    let type = $('#fp_jenis_produk_ok').html().toLowerCase();
    let idproses = fp_dt_proses.rows( { selected: true } ).data()[0][14];
    // console.log(idproses);
    let id_product_component = $('#fpsimpanidsementara').val();

    $.ajax({
      url: baseurl + 'FlowProses/Operation/set_inactive_proses',
      type: 'POST',
      dataType: 'JSON',
      async: true,
      data: {
        id : idproses,
        type : type,
      },
      beforeSend: function() {
        Swal.showLoading()
      },
      success: function(result) {
        if (result) {
          toastFP('success', 'Sukses mengganti status.');
          fpselectproses()
        }else {
          Swal.fire({
            type: 'warning',
            title: 'Gagal Melakukan Update Data, Coba lagi..',
            text: ''
          })
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

// drag event area
const drag_fp = () => {
  let tampung = [];
  console.log('Sequence Updated');
  setTimeout(function () {
    // $('.fp_sequence_proses').show();
    $('.fp_seq').each(function(i){
      $(this).html(i + 1);
     });
     var tableInfo = Array.prototype.map.call(document.querySelectorAll('tbody tr'), function(tr){
       return Array.prototype.map.call(tr.querySelectorAll('td'), function(td){
         return td.innerHTML;
         });
       });
      tableInfo.forEach((v,i)=>{
        let seq = {'id':v[14], 'sequence':Number(i)+1, 'operation_code':v[2]}
        tampung.push(seq)
      })
      // ============
      $.ajax({
        url: baseurl + 'FlowProses/Operation/UpdateSequence',
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: {
          data : tampung,
        },
        beforeSend: function() {
          Swal.fire({
            toast: true,
            position: 'top-end',
            onBeforeOpen: () => {
               Swal.showLoading()
               $('.swal2-loading').children('button').css({'width': '20px', 'height': '20px'})
             },
            text: `Sedang memproses sequence...`
          })
        },
        success: function(result) {
          if (result) {
            toastFP('success', 'Sequence Berhasil Diupdate.');
          }else {
            swalFP('warning', 'Terjadi kesalahan saat mengupdate sequence');
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
      // ============
  }, 50);
}
$('.fp_sort').sortable({
  handle: '.drag_flow_proses',
  update: drag_fp
});

</script>
