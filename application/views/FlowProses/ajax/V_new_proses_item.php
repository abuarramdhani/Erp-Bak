<tr onclick="fp_check_click()" row-num="<?php echo $next_row ?>" row-fp-pb="" draggable="true">
  <td style="width:5%" class="drag_flow_proses"><center><b class="fa fa-sort"></b> <span class="fp_seq"><?php echo $next_row ?></span></center></td>
  <td style="width:5%"><button type="button" class="btn btn-danger btn-sm" onclick="fp_minus_proses(<?php echo $next_row ?>)" name="button"> <i class="fa fa-minus"></i> </button></td>
  <td style=""><input required type="text" name="opetation_code[]" style="width:165px;" value="" class="form-control" placeholder="Operation Code"></td>
  <td style=""><input required type="text" name="operation_desc[]" value="" class="form-control" placeholder="Operation Description"></td>
  <td style="background:#1bc482;height:auto">
    Active
  </td>
  <td>
    <select required class="form-control select2FP1" style="width:100px;" name="flag[]">
      <option value="">Select...</option>
      <option>Y</option>
      <option>N</option>
    </select>
  </td>
  <td>
    <select required class="form-control select2FP1" style="width:100px;" name="make_buy[]">
      <option value="">Select...</option>
      <option value="MAKE">MAKE</option>
      <option value="BUY">BUY</option>
    </select>
  </td>
  <td>
    <select required class="form-control select2FP1" style="width:200px;" name="operation_proses[]">
      <option value="">Select...</option>
      <?php foreach ($proses as $key => $op): ?>
        <option value="<?php echo $op['id'] ?>"><?php echo $op['operation_std'] ?> - <?php echo $op['operation_desc'] ?></option>
      <?php endforeach; ?>
    </select>
  </td>
  <td style="">
    <input type="hidden" name="fp_id_proses[]" value="">
    <input required type="text" name="detail_proses[]" value="" class="form-control" placeholder="Detail Proses">
  </td>
  <td>
    <select required class="form-control select2FP1" style="width:100px;" name="jenis_proses[]">
      <option value="">Select...</option>
      <option value="ALT">ALT</option>
      <option value="ECR">ECR</option>
      <option value="PCR">PCR</option>
      <option value="STD">STD</option>
    </select>
  </td>
  <td>
    <input type="text" value="" name="nomor_jenis_proses[]" readonly style="width:120px" class="form-control">
  </td>
  <td>
    <select required class="form-control select2FP1 fp_cek_destinasi" style="width:200px;" name="machine_req[]">
      <option value="">Select...</option>
      <?php foreach ($machine_req as $key => $mr): ?>
        <option value="<?php echo $mr['DESCRIPTION'] ?> - <?php echo $mr['FLEX_VALUE'] ?>"><?php echo $mr['DESCRIPTION'] ?> - <?php echo $mr['FLEX_VALUE'] ?></option>
      <?php endforeach; ?>
    </select>
  </td>
  <td>
    <select required class="form-control select2FP1 fp_cek_destinasi" name="destination[]" style="width:100px;">
      <option value="">Select...</option>
      <?php foreach ($destination as $key => $dest): ?>
        <option value="<?php echo $dest['DEPARTMENT_CLASS_CODE'] ?>"><?php echo $dest['DEPARTMENT_CLASS_CODE'] ?></option>
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
      </select>
    </div>
  </td>
  <td >
    <input required type="text" name="machine_num[]" value="" class="form-control" placeholder="Machine Num">
  </td>
  <td >
    <input required type="number" style="width:80px" name="qty_machine[]" value="" class="form-control" placeholder="Qty Machine">
  </td>
  <td>
    <select required class="form-control select2FP1 fp_check_inspectool"style="width:100px;" name="inspectool[]">
      <option value="">Select...</option>
      <option value="1">Yes</option>
      <option value="0">No</option>
    </select>
  </td>
  <td class="tool_measurement_check">
    <input type="" readonly name="tool_measurement[]" class="form-control" style="width:200px;" value="">
  </td>
  <td>
   <select required class="form-control select2FP1 fp_check_tool"  name="tool[]" style="width:150px;">
     <option value="">Select...</option>
     <option value="1">New</option>
     <option value="2">Exiting</option>
     <option value="3">Modif</option>
   </select>
  </td>
  <td class="tool_exiting_check">
    <input type="" readonly name="tool_exiting[]" class="form-control" style="width:200px;" value="">
  </td>
 <td hidden></td>
 <td>
   <button type="button" class="btn btn-success" onclick="fp_bp_edit_data(999,'')" data-target="#modal_fp_bp" data-toggle="modal" style="border-radius:7px;" name="button"> <i class="fa fa-eye"></i> </button>
 </td>
 <script type="text/javascript">
 $(document).ready(function() {
   $('input').on('drop', function(event) {
     event.preventDefault();
   });
 });
  function runSelect22() {
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

   $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('.fp_cek_destinasi').on('change', function() {
   let fp_cek = $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('select[name="machine_req[]"] :selected').text();
   let fp_flag_value = fp_cek.split(' - ');

   let destination__ = $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('select[name="destination[]"]');
   let resource__ =  $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('select[name="resource[]"]');
   let foresource__ =  $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('.foresource');
   let foresource_loading__ =$('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('.foresource_loading');

   if (fp_cek != 'Select...' && destination__.val() != '') {
   resource__.val(null).trigger('change');

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
       $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('input[name="machine_num[]"]').val('');
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

 $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('.fp_isi_machine_num').on('change', function() {
     $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('input[name="machine_num[]"]').val('')
     let code = $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('select[name="resource[]"]').val();
     if (code != null) {
       fp_ajax1 = $.ajax({
         url: baseurl + "FlowProses/Operation/getMachineNum",
         type: 'POST',
         dataType: 'JSON',
         data: {
           code: code,
           destination: $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('select[name="destination[]"]').val(),
         },
         beforeSend: function() {
           $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('input[name="machine_num[]"]').val('Sedang Memproses...');
         },
         success: function(result) {

           if (result !== null) {
             let tampong = [];
             $.each(result, function(index, elem) {
               let spl = elem.ATTRIBUTE1.split(' - ');
               tampong.push(spl[1])
             });
             $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('input[name="machine_num[]"]').val(tampong.join(', '))
           }else {
             $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('input[name="machine_num[]"]').val('')
           }

         },
         error: function(XMLHttpRequest, textStatus, errorThrown) {
           // swalFP('error', 'Something was wrong when fetching data...')
          $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('input[name="machine_num[]"]').val('')
          console.error();
         }
       })
     }

 })

 $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('select[name="jenis_proses[]"]').on('change', function () {
   let val = $(this).val();
   $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('input[name="nomor_jenis_proses[]"]').val(null)
   if (val == 'PCR' || val == 'ECR') {
     $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('input[name="nomor_jenis_proses[]"]').removeAttr('readonly');
   }else {
     $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('input[name="nomor_jenis_proses[]"]').attr('readonly', 'readonly');
   }
   // runSelect();
 })

 $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('.fp_check_inspectool').on('change', function () {
   let val = $(this).val();
   // console.log(val);
   if (val == 1) {
     $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('.tool_measurement_check').html(`<select class="form-control select2FP_Tool_2" required name="tool_measurement[]" id="tool_measurement" style="width:200px;"></select>`);
   }else {
     $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('.tool_measurement_check').html(`<input type="" class="form-control" readonly name="tool_measurement[]" id="tool_measurement" style="width:200px;" value="">`);
   }
   runSelect22();
 })

 $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('.fp_check_tool').on('change', function () {
   let val = $(this).val();
   if (val == 2) {
     $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('.tool_exiting_check').html(`<select class="form-control select2FP_Tool" required name="tool_exiting[]"  id="tool_exiting" style="width:200px;"></select>`);
   }else {
     $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('.tool_exiting_check').html(`<input type="" class="form-control" readonly id="tool_exiting" name="tool_exiting[]" style="width:200px;" value="">`);
   }
   runSelect22();
 })

 $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('input[name="opetation_code[]"]').on('change', function () {
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
           $('.datatable-proses-fp tbody tr[row-num="<?php echo $next_row ?>"]').find('input[name="operation_desc[]"]').val(result[0].DESCRIPTION)
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

 </script>
</tr>
