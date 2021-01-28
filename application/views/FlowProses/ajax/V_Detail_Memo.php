<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left datatable-memo-fp" style="font-size:11px;">
    <thead class="bg-primary">
      <tr>
        <th style="width:5%;text-align:center">No</th>
        <th style="width:20%">Component Code</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get as $key => $value): ?>
        <tr>
          <td style="text-align:center"><?php echo $key+1 ?></td>
          <td style="text-align:left"><?php echo $value['component_code'] ?></td>
          <td style="text-align:left"><?php echo $value['component_name'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php if ($cek == 0){ ?>
    <center id="fp_kodisi_btn_memo"><button type="button" class="btn btn-success" onclick="update_status_component('<?php echo $memo ?>')" style="border-radius:7px;width:35%;margin-bottom:7px" name="button"> <i class="fa fa-check-square"></i> <b>Approve Memo(<?php echo $memo ?>)</b> </button> </center>
  <?php }else { ?>
    <center id="fp_kodisi_btn_memo"><button type="button" class="btn btn-warning" onclick="update_status_component_cancel('<?php echo $memo ?>')" style="border-radius:7px;width:35%" name="button"> <i class="fa fa-times"></i> <b>Unset Memo(<?php echo $memo ?>)</b> </button></center>
  <?php } ?>
</div>
<script type="text/javascript">
  $('.datatable-memo-fp').DataTable()

  function update_status_component(memo) {
    fp_ajax_memo = $.ajax({
      url: baseurl + "FlowProses/Memo/updateComponentMemo",
      type: 'POST',
      dataType: 'JSON',
      data: {
        memo: memo,
        type: '<?php echo $type ?>'
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
          toastFP('success', `Komponen Berhasil Ditambahkan.`);
          $('#fp_kodisi_btn_memo').html(`<button type="button" class="btn btn-warning" onclick="update_status_component_cancel('<?php echo $memo ?>')" style="border-radius:7px;width:35%" name="button"> <i class="fa fa-times"></i> <b>Cancel Memo(<?php echo $memo ?>)</b> </button>`)
          $('#modalfpmemocomponent').modal('toggle')
          $(`#fp_status_<?= $memo_id ?>`).html(`<center><span class="btn-success" name="button" style="padding:4px;border-radius:5px;width:70%;font-weight:bold">Approved!</span></center>`)
        }else if (2) {
          toastFP('danger', `Terjadi Kesalahan`);
        }else{
          toastFP('warning', `Data kosong dengan no memo ${memo}`);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        swalFP('error', 'Something was wrong!')
       console.error();
      }
    })
  }

  function update_status_component_cancel(memo) {
    fp_ajax_memo = $.ajax({
      url: baseurl + "FlowProses/Memo/updateComponentMemoCancel",
      type: 'POST',
      dataType: 'JSON',
      data: {
        memo: memo,
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
          toastFP('success', `Komponen Berhasil Diurungkan.`);
          $('#fp_kodisi_btn_memo').html(`<button type="button" class="btn btn-success" onclick="update_status_component('<?php echo $memo ?>')" style="border-radius:7px;width:35%" name="button"> <i class="fa fa-check-square"></i> <b>Accept Memo(<?php echo $memo ?>)</b> </button>`)
          $('#modalfpmemocomponent').modal('toggle')
          $(`#fp_status_<?= $memo_id ?>`).html(`<center><span class="btn-warning" name="button" style="padding:4px;border-radius:5px;width:70%;font-weight:bold">Unsetting</span></center>`)

        }else if (2) {
          toastFP('danger', `Terjadi Kesalahan`);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        swalFP('error', 'Something was wrong!')
       console.error();
      }
    })
  }
</script>
