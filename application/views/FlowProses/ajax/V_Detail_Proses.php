<button type="button" class="btn btn-primary fp_btn_add_row" name="button" onclick="fp_pe_add_row()" style="position:fixed;bottom:9%;right: 3.8%;border-radius: 50%;z-index: 9999;height: 37px;"> <b class="fa fa-plus-square"></b> </button>
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

<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i> Info!</h4>
    Klik kolom Status untuk setting Active/Inactive <b>proses</b>.
</div>

<p class="text-danger" style="padding-top:10px;margin-bottom:-23px">
*Drag kolom dengan simbol &nbsp;<b class="fa fa-sort"></b>&nbsp; untuk mengatur sequence
</p>

<form class="form_save_operation" action="" method="post">
<input type="hidden" name="fp_id_deteted" value="">
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left datatable-proses-fp" style="font-size:11px;">
    <thead class="bg-primary">
      <tr>
        <th style="text-align:center;">
            Seq
        </th>
        <th style="text-align:center">Select</th>
        <th>
            Operation Code
        </th>
        <th >
            Operation Description
        </th>
        <th>Status</th>
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
        <th>Jenis Proses</th>
        <th>No Jenis Proses</th>
        <th>
            Machine Request
        </th>
        <th>Destination</th>
        <th>
            Resource
        </th>
        <th>
            Machine Number
        </th>
        <th>
            Qty Machine
        </th>
        <th>
            Inspectool
        </th>
        <th>  Measurement Tool</th>
        <th>
            Tool
        </th>
        <th>Tool Exiting</th>
        <th hidden></th>
        <th>Bahan Penolong</th>
    </tr>
    </thead>
    <tbody class="fp_sort" id="fp_comp_detail_proses" >
      <?php foreach ($get as $key => $value): ?>
        <tr onclick="fp_check_click()" row-num="<?php echo $key+1 ?>" row-fp-pb="<?php echo $value['id'] ?>" draggable="true">
          <td style="width:5%" class="drag_flow_proses"><center><b class="fa fa-sort"></b> <span class="fp_seq"><?php echo $key+1 ?></span></center></td>
          <td style="width:5%"> <button type="button" class="btn btn-danger btn-sm" onclick="fp_minus_proses(<?php echo $key+1 ?>)" name="button"> <i class="fa fa-minus"></i> </button> </td>
          <td style=""><input required type="text" name="opetation_code[]" style="width:165px;" value="<?php echo $value['opr_code'] ?>" class="form-control" placeholder="Operation Code"></td>
          <td style=""><input required type="text" name="operation_desc[]" value="<?php echo $value['opr_desc'] ?>" class="form-control" placeholder="Operation Description"></td>
          <?php
            if (empty($value['status']) || $value['status'] == 'Y') {
              $c = "background:#1bc482";
              $stat = "Active";
            }else {
              $c = "background:#e22e2e";
              $stat = "Inactive";
            }
           ?>
          <td style="<?php echo $c ?>;height:auto">
            <?php echo $stat ?>
          </td>
          <td>
            <select required class="form-control select2FP1" style="width:100px;" name="flag[]">
              <option value="">Select...</option>
              <option value="Y" <?php echo $value['inv_item_flag'] == 'Y'?'selected':''?>>Y</option>
              <option value="N" <?php echo $value['inv_item_flag'] == 'N'?'selected':''?>>N</option>
            </select>
          </td>
          <td>
            <select required class="form-control select2FP1" style="width:100px;" name="make_buy[]">
              <option value="">Select...</option>
              <option value="MAKE" <?php echo $value['make_buy'] == 'MAKE'?'selected':''?>>MAKE</option>
              <option value="BUY" <?php echo $value['make_buy'] == 'BUY'?'selected':''?>>BUY</option>
            </select>
          </td>
          <td>
            <select required class="form-control select2FP1" style="width:200px;" name="operation_proses[]">
              <option value="">Select...</option>
              <?php foreach ($proses as $key => $op): ?>
                <option value="<?php echo $op['id'] ?>" <?php echo $value['operation_process'] ==  $op['id'] ? 'selected' : ''?> ><?php echo $op['operation_std'] ?> - <?php echo $op['operation_desc'] ?></option>
              <?php endforeach; ?>
            </select>
          </td>
          <td style="">
            <input type="hidden" name="fp_id_proses[]" value="<?php echo $value['id'] ?>">
            <input required type="text" name="detail_proses[]" value="<?php echo $value['dtl_process'] ?>" class="form-control" placeholder="Detail Proses">
          </td>
          <td>
            <select required class="form-control select2FP1" style="width:100px;" name="jenis_proses[]">
              <option value="">Select...</option>
              <option value="ALT" <?php echo $value['jenis_proses'] == 'ALT' ? 'selected' : '' ?> >ALT</option>
              <option value="ECR" <?php echo $value['jenis_proses'] == 'ECR' ? 'selected' : '' ?> >ECR</option>
              <option value="PCR" <?php echo $value['jenis_proses'] == 'PCR' ? 'selected' : '' ?> >PCR</option>
              <option value="STD" <?php echo $value['jenis_proses'] == 'STD' ? 'selected' : '' ?> >STD</option>
            </select>
          </td>
          <td>
            <?php
            if ($value['jenis_proses'] == 'PCR' || $value['jenis_proses'] == 'ECR') {
              $attr_nom_jen_pro = '';
            }else {
              $attr_nom_jen_pro = 'readonly';
            }
            ?>
            <input type="text" value="<?php echo $value['nomor_jenis_proses'] ?>" name="nomor_jenis_proses[]" <?php echo $attr_nom_jen_pro ?> style="width:120px" class="form-control">
          </td>
          <td>
            <select required class="form-control select2FP1 fp_cek_destinasi" style="width:200px;" name="machine_req[]">
              <option value="">Select...</option>
              <option value="<?php echo $value['machine_req'] ?>" selected><?php echo $value['machine_req'] ?></option>
              <?php foreach ($machine_req as $key => $mr): ?>
                <option value="<?php echo $mr['DESCRIPTION'] ?> - <?php echo $mr['FLEX_VALUE'] ?>" <?php echo $value['machine_req'] ==  $mr['DESCRIPTION'].' - '.$mr['FLEX_VALUE'] ? 'selected' : ''?>><?php echo $mr['DESCRIPTION'] ?> - <?php echo $mr['FLEX_VALUE'] ?></option>
              <?php endforeach; ?>
            </select>
          </td>
          <td>
            <select required class="form-control select2FP1 fp_cek_destinasi" name="destination[]" style="width:100px;">
              <?php foreach ($destination as $key => $dest): ?>
                <option value="<?php echo $dest['DEPARTMENT_CLASS_CODE'] ?>" <?php echo $value['destination'] ==  $dest['DEPARTMENT_CLASS_CODE'] ? 'selected' : ''?>><?php echo $dest['DEPARTMENT_CLASS_CODE'] ?></option>
              <?php endforeach; ?>
            </select>
          </td>
          <td>
            <div class="foresource_loading" style="display:none">
              Memproses...
            </div>
            <div class="foresource">
              <select required class="form-control select2FP1 fp_isi_machine_num" style="width:200px;" name="resource[]">
                <option value="">Select...</option>
                <option value="<?php echo $value['resource'] ?>" selected><?php echo $value['resource'] ?></option>
              </select>
            </div>
            <?php //$c = explode(' - ',$value['resource']); echo $c[0]; ?>
          </td>
          <td >
            <input required type="text" name="machine_num[]" value="<?php echo $value['machine_num'] ?>" class="form-control" placeholder="Machine Num">
          </td>
          <td >
            <input required type="number" style="width:80px" name="qty_machine[]" value="<?php echo $value['qty_machine'] ?>" class="form-control" placeholder="Qty Machine">
          </td>
          <td>
            <select required class="form-control select2FP1 fp_check_inspectool"style="width:100px;" name="inspectool[]">
              <option value="">Select...</option>
              <option value="1" <?php echo $value['inspectool_id'] == 1 ? 'selected' : '' ?>>Yes</option>
              <option value="0" <?php echo $value['inspectool_id'] == 0 ? 'selected' : '' ?>>No</option>
            </select>
          </td>
          <td class="tool_measurement_check">
            <?php if (!empty($value['tool_measurement'])) { ?>
              <select required class="form-control select2FP_Tool_2"  name="tool_measurement[]" style="width:200px;">
                <option value="<?php echo $value['tool_measurement'] ?>" selected><?php echo $value['tool_measurement'] ?></option>
              </select>
            <?php  }else {?>
              <input type="" readonly name="tool_measurement[]" class="form-control" style="width:200px;" value="">
            <?php  } ?>
          </td>
          <td>
           <select required class="form-control select2FP1 fp_check_tool"  name="tool[]" style="width:150px;">
             <option value="">Select...</option>
             <option value="1" <?php echo $value['tool_id'] == 1 ? 'selected' : '' ?>>New</option>
             <option value="2" <?php echo $value['tool_id'] == 2 ? 'selected' : '' ?>>Exiting</option>
             <option value="3" <?php echo $value['tool_id'] == 3 ? 'selected' : '' ?>>Modif</option>
           </select>
          </td>
          <td class="tool_exiting_check">
            <?php if (!empty($value['tool_exiting'])) { ?>
              <select class="form-control select2FP_Tool" required  name="tool_exiting[]" style="width:200px;">
                <option value="<?php echo $value['tool_exiting'] ?>" selected><?php echo $value['tool_exiting'] ?></option>
              </select>
            <?php  }else {?>
              <input type="" readonly name="tool_exiting[]" class="form-control" style="width:200px;" value="">
            <?php  } ?>
          </td>
           <td hidden><?php echo $value['id'] ?></td>
           <td>
             <button type="button" class="btn btn-success" data-target="#modal_fp_bp" data-toggle="modal" onclick="fp_bp_edit_data(<?php echo $value['id'] ?>, '<?php echo $value['opr_code'] ?>')" style="border-radius:7px;" name="button"> <i class="fa fa-eye"></i> </button>
           </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<br>
<input type="hidden" id="txt_count_tr_proses_fp" value="<?php echo !empty($get) ? $key+1 : 0 ?>">

<button type="submit" class="btn btn-success" style="border-radius:7px;" name="button"> <i class="fa fa-files"></i> <b>Update Operation</b> </button>
<!-- <button type="button" class="btn btn-success fp_update_proses_component" data-toggle="modal" data-target="#modalfp1" onclick="fp_update_proses_component()" style="border-radius:7px;display:none;" name="button"> <i class="fa fa-pencil"></i> <b>Update Process</b> </button> -->
<button type="button" class="btn btn-danger fp_del_proses" onclick="del_prosess_per_component()" style="border-radius:7px;display:none" name="button"> <i class="fa fa-trash"></i> <b>Delete</b> </button>
<button type="button" class="btn btn-success fp_set_active_proses" onclick="fp_set_inactive_proses()" style="border-radius:7px;float:right;display:none" name="button"> <i class="fa fa-times"></i> <b id="txt_fp_stat">Set Inactive</b> </button>

</form>

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
                        <!-- <li>Jika anda menutup modal form inputan ini, data yang anda isi akan ter-reset.</li> -->
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
// end newest 2021
$(document).ready(function() {
  $('.select2FP1').select2();
  // $('input').on('drag', function(event) {
  //   event.preventDefault();
  // });
});
function runSelect() {
  $('.select2FP_Tool').select2({
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
  });
  $('.select2FP_Tool_2').select2({
    minimumInputLength: 3,
    placeholder: "Select Tool Measurement",
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
}

$().ready(function() {
  runSelect();
})

$(document).ready(function() {
  $('.datatable-proses-fp tbody tr').each((i,v)=>{

    $(v).find('input[name="opetation_code[]"]').on('change', function () {
      if ($(this).val() != '') {
        $.ajax({
          url: baseurl + 'FlowProses/Operation/cekOracleProses',
          type: 'POST',
          async: true,
          dataType: 'JSON',
          data: {
            code: $(this).val(),
          },
          beforeSend: function () {
            toastFPLoading('Sedang mengecek item operation code..')
          },
          success: function (result) {
            if (result !== 0) {
              toastFP('success', 'Data Founded!')
              $(v).find('input[name="operation_desc[]"]').val(result[0].DESCRIPTION)
            }else {
              Swal.fire({
                type: 'warning',
                html: `<b>Data not Found! Please Visit</b> <a style="font-weight:bold" href="http://erp.quick.com/PendaftaranMasterItem" class="text-primary"> <u>Pendaftaran Master Item</u></a>`
              })
            }
          }
        })
      }
    })

    $(v).find('.fp_check_inspectool').on('change', function () {
      let val = $(this).val();
      // console.log(val);
      if (val == 1) {
        $(v).find('.tool_measurement_check').html(`<select class="form-control name="tool_measurement[]" select2FP_Tool_2" required  id="tool_measurement" style="width:200px;"></select>`);
      }else {
        $(v).find('.tool_measurement_check').html(`<input type="" class="form-control" name="tool_measurement[]" readonly id="tool_measurement" style="width:200px;" value="">`);
      }
      runSelect();
    })

    $(v).find('.fp_check_tool').on('change', function () {
      let val = $(this).val();
      if (val == 2) {
        $(v).find('.tool_exiting_check').html(`<select class="form-control select2FP_Tool" name="tool_exiting[]" required  id="tool_exiting" style="width:200px;"></select>`);
      }else {
        $(v).find('.tool_exiting_check').html(`<input type="" class="form-control" readonly name="tool_exiting[]" id="tool_exiting" style="width:200px;" value="">`);
      }
      runSelect();
    })

    $(v).find('select[name="jenis_proses[]"]').on('change', function () {
      let val = $(this).val();
      $(v).find('input[name="nomor_jenis_proses[]"]').val(null)
      if (val == 'PCR' || val == 'ECR') {
        $(v).find('input[name="nomor_jenis_proses[]"]').removeAttr('readonly');
      }else {
        $(v).find('input[name="nomor_jenis_proses[]"]').attr('readonly', 'readonly');
      }
    })

    $(v).find('.foresource').on('click', function () {
      if ($(v).find('select[name="machine_req[]"]').val() == '' || $(v).find('select[name="destination[]"]').val() == '') {
        swalFP('warning', 'Machine Request dan Destination perlu di isi terlebih dahulu!');
      }
      // console.log('cekk');
      // console.log($('#destination').val());
      // console.log($('#machine_req').val());
    })

    if ($(v).find('select[name="destination[]"]').val() != '' && $(v).find('select[name="machine_req[]"]').val() != '') {
      let fp_cek_ = $(v).find('select[name="machine_req[]"]').val();
      let fp_flag_value_ = fp_cek_.split(' - ');

      let destination_ = $(v).find('select[name="destination[]"]');
      let resource_ =  $(v).find('select[name="resource[]"]');
      let foresource_ =  $(v).find('.foresource');
      let foresource_loading_ =$(v).find('.foresource_loading');

      $.ajax({
       url: baseurl + "FlowProses/Operation/getResource",
       type: 'POST',
       dataType: 'JSON',
       data: {
         term: '',
         destination: destination_.val(),
         mechine_req: fp_flag_value_[1],
       },
       beforeSend: function() {
         resource_.html('')
         foresource_.hide()
         foresource_loading_.show();
       },
       success: function(result) {
         // console.log(result)
         foresource_loading_.hide();
         foresource_.show();
         if (result !== null) {
           // $('#resource').append(`<option value="" selected>Select...</option>`);
           $.each(result, function(index, elem) {
             let split_aja = elem.ATTRIBUTE1.split(' - ');
             resource_.append(`<option value="${elem.RESOURCE_CODE}">${elem.RESOURCE_CODE} - ${elem.DESCRIPTION}</option>`);
           });
         }else {
           resource_.html('');
         }

       },
       error: function(XMLHttpRequest, textStatus, errorThrown) {
         // swalFP('error', 'Something was wrong when fetching data...')
        console.error();
       }
     }).done(function () {
       // let cek_ram_resource = $('#fp_tampung_resource_sementara').val();
       // if (cek_ram_resource != '') resource_.val(cek_ram_resource).trigger('change');
     })
    }


    $(v).find('.fp_cek_destinasi').on('change', function() {
      let fp_cek = $(v).find('select[name="machine_req[]"] :selected').text();
      let fp_flag_value = fp_cek.split(' - ');

      let destination__ = $(v).find('select[name="destination[]"]');
      let resource__ =  $(v).find('select[name="resource[]"]');
      let foresource__ =  $(v).find('.foresource');
      let foresource_loading__ =$(v).find('.foresource_loading');

      if (fp_cek != 'Select...' && destination__.val() != '') {
      resource__.val(null).trigger('change')
      //
      // if (fp_ajax2 !=  null) {
      //   fp_ajax2.abort()
      //   // $('.resource_loading_area').html('')
      //   foresource__.show()
      // }

       $.ajax({
        url: baseurl + "FlowProses/Operation/getResource",
        type: 'POST',
        dataType: 'JSON',
        data: {
          term: '',
          destination: destination__.val(),
          mechine_req: fp_flag_value[1],
        },
        beforeSend: function() {
          $(v).find('input[name="machine_num[]"]').val('');
          resource__.html('');
          foresource__.hide();
          foresource_loading__.show();
        },
        success: function(result) {
          // console.log(result)
          foresource_loading__.hide();
          foresource__.show();
          if (result !== null) {
              resource__.append(`<option value="" selected>Select...</option>`);
            $.each(result, function(index, elem) {
              let split_aja = elem.ATTRIBUTE1.split(' - ');
              resource__.append(`<option value="${elem.RESOURCE_CODE}">${elem.RESOURCE_CODE} - ${elem.DESCRIPTION}</option>`);
            });
          }else {
            resource__.html('');
          }

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          // swalFP('error', 'Something was wrong when fetching data...')
         console.error();
        }
      }).done(function () {
        // let cek_ram_resource = $('#fp_tampung_resource_sementara').val();
        // if (cek_ram_resource != '') resource__.val(cek_ram_resource).trigger('change');
      })
     }
   })

   $(v).find('.fp_isi_machine_num').on('change', function() {
       $(v).find('input[name="machine_num[]"]').val('')
       let code = $(v).find('select[name="resource[]"]').val();
       if (code != null) {
         fp_ajax1 = $.ajax({
           url: baseurl + "FlowProses/Operation/getMachineNum",
           type: 'POST',
           dataType: 'JSON',
           data: {
             code: code,
             destination: $(v).find('select[name="destination[]"]').val(),
           },
           beforeSend: function() {
             $(v).find('input[name="machine_num[]"]').val('Sedang Memproses...');
           },
           success: function(result) {

             if (result !== null) {
               let tampong = [];
               $.each(result, function(index, elem) {
                 let spl = elem.ATTRIBUTE1.split(' - ');
                 tampong.push(spl[1])
               });
               $(v).find('input[name="machine_num[]"]').val(tampong.join(', '))
             }else {
               $(v).find('input[name="machine_num[]"]').val('')
             }

           },
           error: function(XMLHttpRequest, textStatus, errorThrown) {
             // swalFP('error', 'Something was wrong when fetching data...')
            $(v).find('input[name="machine_num[]"]').val('')
            console.error();
           }
         })
       }

   })

  })
})

const fp_dt_proses = $('.datatable-proses-fp').DataTable({
  "paging":   false,
  "ordering": false,
  // "info":
  // columnDefs: [
  //   {
  //     orderable: false,
  //     className: 'select-checkbox',
  //     targets: 1
  //   }
  // ],
  select: {
    // style: 'multi',
    style: 'single',
    // selector: 'tr'
    selector: 'td:nth-child(5)'
  },
  order: [[0, 'asc']],
})

function fp_minus_proses(row_num) {
  let tmp_id_del = $(`.datatable-proses-fp tbody tr[row-num="${row_num}"]`).find('input[name="fp_id_proses[]"]').val();
  let val_before = $('input[name="fp_id_deteted"]').val();
  $('input[name="fp_id_deteted"]').val(`${val_before} ${tmp_id_del}`);
  fp_dt_proses.row($(`.datatable-proses-fp tbody tr[row-num="${row_num}"]`)).remove().draw();
  $('.fp_seq').each(function(i){
    $(this).html(i + 1);
   });
}

function fp_pe_add_row() {
  let last_row = $(`.datatable-proses-fp tbody tr`).length;
  if ($('.datatable-proses-fp tbody tr td').html() == 'No data available in table') {
    last_row = 0;
  }
  let next_row = last_row + 1;
  $('.fp_btn_add_row').attr('disabled', 'disabled');
  $('.fp_btn_add_row').removeAttr('onclick');
  $.ajax({
    url: baseurl + 'FlowProses/SetOracleItem/addrow',
    type: 'POST',
    // dataType: 'JSON',
    data: {
      next_row : next_row,
      machine_req : <?php echo json_encode($machine_req) ?>,
      proses : <?php echo json_encode($proses) ?>,
      destination : <?php echo json_encode($destination) ?>
    },
    cache:false,
    beforeSend: function() {
      toastFPLoading('Sedang menyiapkan data penyusun..');
    },
    success: function(result) {
      fp_dt_proses.row.add($(result)).draw();
      Swal.close();
      $('.select2FP1').select2();
      runSelect();

      $('.fp_btn_add_row').removeAttr('disabled');
      $('.fp_btn_add_row').attr('onclick', 'fp_pe_add_row()');
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalFP('error', 'Koneksi Terputus...')
     console.error();
    }
  }).done(()=>{

  })
}

// end newest 2021

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

  function update_fp_bp_submit(id, code) {

    let component_code = $('.fp_bp_component_code_edit').map((_, el) => el.value).get();
    let qty_component = $('.fp_bp_qty_edit').map((_, el) => el.value).get();
    let id_bp = $('.fp_bp_id').map((_, el) => el.value).get();
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
            // fp_detail_bahan_penolong(id, code)
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
    // if (id != '') {
    //
    // }else {
    //   toastFP('warning')
    // }
    $('#edit_fp_pb').html('');
    $('#code_comp_fp_bp').html(code);
    // let tableInfo = Array.prototype.map.call(document.querySelectorAll(`.fp_tbl_dt_${id} tbody tr`), function(tr){
    //   return Array.prototype.map.call(tr.querySelectorAll('td'), function(td){
    //     return td.innerHTML;
    //     });
    //   });
    // console.log(id);
    if (id == 999) {
      $('.btn-fp-bp-update').html(``);
      $('#edit_fp_pb').html(`<tr><td colspan="4">
                                <center><b>Operation belum disimpan di database, harap simpan dulu. </b></center>
                            </td></tr`);
    }else {
      $.ajax({
        url: baseurl + 'FlowProses/Operation/getDetailPB',
        type: 'POST',
        async: true,
        dataType: 'JSON',
        data: {
          id: id,
        },
        beforeSend: function() {
          $('#edit_fp_pb').html(`<tr><td colspan="4">
                                    <center><img style="width: 4%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif">Sedang Mengambil Data </center>
                                </td></tr>`)
        },
        success: function(result) {
          // console.log(result);
          if (result != 0) {
            $('#edit_fp_pb').html('');
            result.forEach((v,i)=>{
              $('#edit_fp_pb').append(`<tr row-id-edit="${Number(i)+1}">
                                        <td style="text-align:center;vertical-align:middle;width:5%">${Number(i)+1}</td>
                                        <td style="width:70%">
                                          <select class="form-control select2FP_Oracle_Second fp_bp_component_code_edit fp_get_uom_${Number(i)+1}" onchange="fp_isi_uom(${Number(i)+1})" style="width:100%" required>
                                            <option value="${v.component_code} - ${v.component_desc} - ${v.uom}" selected>${v.component_code} - ${v.component_desc}</option>
                                          </select>
                                        </td>
                                        <td style="width:15%">
                                          <input type="hidden" class="fp_bp_id" value="${v.id}">
                                          <input type="number" placeholder="QTY" class="form-control fp_bp_qty_edit" value="${v.qty}">
                                        </td>
                                        <td style="width:25%">
                                          <input type="text" placeholder="UOM" class="form-control fp_uom_hia_${Number(i)+1}" readonly value="${v.uom}">
                                        </td>
                                        <td style="vertical-align:middle">
                                          <center><button type="button" name="button" class="btn btn-sm" onclick="fp_bp_minus_proses_edit(${Number(i)+1})"><i class="fa fa-minus-square"></i></button></center>
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

          }else {
            // Swal.close();
            // let html = `<h5 style="text-align:center">Tidak ada bahan penolong pada operation code ini. <br> ( <button style="color:#429fff;border:none;background:transparent;font-weight:bold" data-target="#modal_fp_bp" data-toggle="modal" onclick="fp_bp_empty(${id}, '${code}')"> <i class="fa fa-plus-square"></i>  Tambahkan</button> ) </h5>`
            $('#edit_fp_pb').html('');
          }

          $('.btn-fp-bp-update').html(`<br>
                                      <center>
                                        <button type="button" class="btn btn-success fp_save_update_bp" style="width:30%;margin-bottom:10px;" onclick="update_fp_bp_submit(${id}, '${code}')" name="button"> <i class="fa fa-file"></i> <b>Update</b> </button>
                                      </center>`)
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
    }

  }

  function fp_bp_empty(id, code) {
    $('#edit_fp_pb').html('');
    $('.btn-fp-bp-update').html(`<br>
                                <center>
                                  <button type="button" class="btn btn-success fp_save_update_bp" style="width:30%;margin-bottom:10px;" onclick="update_fp_bp_submit(${id}, '${code}')" name="button"> <i class="fa fa-file"></i> <b>Update</b> </button>
                                </center>`)
  }
  //
  // function fp_dlt_pb(d, id) {
  //   return `<div class="fp_detail_bp${id}"></div>`;
  // }
  //
  // function fp_detail_bahan_penolong(id, code) {
  //   $('#code_comp_fp_bp').html(code);
  //   let tr = $(`tr[row-fp-pb="${id}"]`);
  //   let row = fp_dt_proses.row(tr);
  //   if (row.child.isShown()) {
  //     row.child.hide();
  //     tr.removeClass('shown');
  //   } else {
  //     row.child(fp_dlt_pb(row.data(), id)).show();
  //     tr.addClass('shown');
  //
  //   }
  // }

  // function fp_update_proses_component() {
  //   $('#modalfp1').css({'display':'grid', 'margin-top':'44px'});
  //   $('#fp_tempat_save_operation').html(`Update`);
  //   $('.fp_cek_hidden_untuk_update').hide();
  //   $('.fp_tbl_penolong tbody').html('');
  //   // $('.fp_save_operation').hide()
  //   let data = fp_dt_proses.rows( { selected: true } ).data();
  //   $('#id_pd').val($('#fpsimpanidsementara').val())
  //   $('#component_code').val($('#code_product').html()+' - '+$('#fpsimpanidsementara_desc').val())
  //   $('#fp_judul_form_proses').html('Update Operation');
  //   $('#code_comp_sem').html($('#code_product').html());
  //   $('#fp_id_proses').val(data[0][14]);
  //   $('#opetation_code').val(data[0][2]);
  //   $('#opetaion_desc').val(data[0][3]);
  //   $('#detail_proses').val(data[0][7]);
  //   $('#machine_num').val(data[0][10]);
  //   $('#resource').val(data[0][11]);
  //   $('#flag').val(data[0][4]).trigger('change');
  //   $('#make_buy').val(data[0][5]).trigger('change');
  //   $('#operation_proses').val(data[0][15]).trigger('change');
  //   let item_ = new Option(`${data[0][16]}`, data[0][16], false, false);
  //   $('#machine_req').html(item_).trigger('change');
  //   //destination
  //   $.ajax({
  //     url: baseurl + 'FlowProses/Operation/getDestinasi',
  //     type: 'POST',
  //     dataType: 'JSON',
  //     async: true,
  //     beforeSend: function() {
  //       $('#fp_tampung_resource_sementara').val('')
  //       $('#destination').html('')
  //       $('#destination').val(null).trigger('change');
  //       $('#destination').append(`<option value="" selected>Select...</option>`);
  //       $('#fp_destinasi_view').hide()
  //       $('.destination_loading_area').html(`<div id="loadingArea0">
  //                                           <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Fetching destination data</center>
  //                                         </div>`);
  //     },
  //     success: function(result) {
  //       // console.log(result)
  //       $('.destination_loading_area').html(``);
  //       $('#fp_destinasi_view').show();
  //       $.each(result, function(index, elem) {
  //         $('#destination').append(`<option value="${elem.DEPARTMENT_CLASS_CODE}">${elem.DEPARTMENT_CLASS_CODE}</option>`)
  //       });
  //     },
  //     error: function(XMLHttpRequest, textStatus, errorThrown) {
  //       console.error();
  //     }
  //   }).done(function () {
  //       $('.select2FP1').val(data[0][17]).trigger('change');
  //       $('#fp_tampung_resource_sementara').val(data[0][18])
  //   })
  //   //end
  //   $('#qty_machine').val(data[0][19])
  //   $('#tool').val(data[0][20]).trigger('change')
  //   $('#inspectool').val(data[0][21]).trigger('change')
  //
  //   let tool_exiting_split = data[0][22].split(' _ ');
  //   let tool_exiting = new Option(tool_exiting_split[1], data[0][22], false, false);
  //   $('#tool_exiting').html(tool_exiting).trigger('change');
  //
  //   let tool_measurement_split = data[0][23].split(' _ ');
  //   let tool_measurement = new Option(tool_measurement_split[1], data[0][23], false, false);
  //   $('#tool_measurement').html(tool_measurement).trigger('change');
  //   $('#jenis_proses').val(data[0][24]).trigger('change')
  //   $('#nomor_jenis_proses').val(data[0][25])
  //   let sequence = null;
  //   // $(`.fp_area_gambar_kerja_3`).html(`<div class="box box-primary collapsed-box" style="margin-bottom:13px;background:#e1f0fe">
  //   //                                     <div class="box-header with-border">
  //   //                                       <h3 class="box-title"> <b class="fa fa-cube" style="color:#0f74c7"></b> <b style="color:#0f7ac7">Gambar Kerja</b></h3>
  //   //
  //   //                                       <div class="box-tools pull-right">
  //   //                                         <button type="button" class="btn btn-primary btn-sm" onclick="getgambarkerja_beda_tempat()" data-widget="collapse"><i class="fa fa-eye" style="color:white"></i></b>
  //   //                                         </button>
  //   //                                       </div>
  //   //                                     </div>
  //   //                                     <div class="box-body area-gambar-kerja-kedua" style="display: none;">
  //   //                                     </div>
  //   //                                   </div>`)
  // $(`.fp_area_gambar_kerja_3`).html(`<center style="position: fixed;width: 100%;top:0"><div class="box box-primary collapsed-box" style="margin-bottom:13px;background:#e1f0fe;width:80%;left:7.5px">
  //                                       <div class="box-header with-border" style="width:90%">
  //                                         <h3 class="box-title"> <b class="fa fa-cube" style="color:#0f74c7"></b> <b style="color:#0f7ac7">Gambar Kerja</b></h3>
  //
  //                                         <div class="box-tools pull-right">
  //                                           <button type="button" class="btn btn-primary btn-sm" onclick="getgambarkerja_beda_tempat_()" data-widget="collapse"><i class="fa fa-eye" style="color:white"></i></b>
  //                                           </button>
  //                                         </div>
  //                                       </div>
  //                                       <div class="box-body area-gambar-kerja-kedua" style="display: none;">
  //                                       </div>
  //                                     </div></center>`)
  //   // console.log(sequence);
  // }


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
          if (data_list[4] == 'Active') {
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
        // $('.fp_del_proses').hide();
      }else {
        // $('.fp_del_proses').show();
      }

    }, 50);
  }

  function fp_set_inactive_proses() {
    let type = $('#fp_jenis_produk_ok').html().toLowerCase();
    let idproses = fp_dt_proses.rows( { selected: true } ).data()[0][20];
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
        let seq = {'id':v[20], 'sequence':Number(i)+1, 'operation_code':$(v[2]).val()}
        tampung.push(seq)
      })
      // ============
      // $.ajax({
      //   url: baseurl + 'FlowProses/Operation/UpdateSequence',
      //   type: 'POST',
      //   dataType: 'JSON',
      //   async: true,
      //   data: {
      //     data : tampung,
      //   },
      //   beforeSend: function() {
      //     Swal.fire({
      //       toast: true,
      //       position: 'top-end',
      //       onBeforeOpen: () => {
      //          Swal.showLoading()
      //          $('.swal2-loading').children('button').css({'width': '20px', 'height': '20px'})
      //        },
      //       text: `Sedang memproses sequence...`
      //     })
      //   },
      //   success: function(result) {
      //     if (result) {
      //       toastFP('success', 'Sequence Berhasil Diupdate.');
      //     }else {
      //       swalFP('warning', 'Terjadi kesalahan saat mengupdate sequence');
      //     }
      //   },
      //   error: function(XMLHttpRequest, textStatus, errorThrown) {
      //     Swal.fire({
      //       type: 'error',
      //       title: 'Something was wrong...',
      //       text: ''
      //     })
      //   }
      // })
      // ============
  }, 50);
}
$('.fp_sort').sortable({
  handle: '.drag_flow_proses',
  update: drag_fp
});

//form_save_operation
$('.form_save_operation').on('submit', function (e) {
  e.preventDefault();
  let form = new FormData(this);
  form.append('product_id', $('#fp_selected_product').val());
  form.append('product_component_id', $('#fpsimpanidsementara').val());
  form.append('product_type', $('#fp_jenis_produk_ok').html().toLowerCase());

  $.ajax({
  url: baseurl + 'FlowProses/Operation/UpdateOperationComp',
  type: 'POST',
  // dataType: 'JSON',
  data: form,
  contentType: false,
  cache: false,
  processData:false,
  beforeSend: function() {
    toastFPLoading('Sedang memproses data..')
  },
  success: function(result) {
    if (result == 1) {
      toastFP('success', 'Berhasil memperbarui data');
      fpselectproses();
    }else {
      toastFP('warning', 'Terdapat kesalahan saat memperbaru data, hubungi ICT Produksi');
    }
  },
  error: function(XMLHttpRequest, textStatus, errorThrown) {
  swalFP('error', 'Koneksi Terputus...')
   console.error();
  }
})
})
</script>
