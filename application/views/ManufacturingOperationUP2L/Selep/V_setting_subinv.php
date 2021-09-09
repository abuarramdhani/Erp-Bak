<form id="form-submit-up2l-setting-subinv" method="post" autocomplete="off">
<div class="table-responsive" style="height:350px;overflow:auto !important">
  <table style="width:100%" class="table table-bordered text-center up2l_ss_88">
      <thead class="bg-primary">
        <tr>
          <td style="width:30%">No Induk</td>
          <td>Sub. Inventory</td>
          <td></td>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($get as $key => $value): ?>
          <tr>
            <td>
              <input type="text" class="form-control" name="no_induk[]" style="text-transform:uppercase" value="<?php echo $value['no_induk'] ?>" required>
            </td>
            <td>
              <?php $cek_sub_inv = explode(',', $value['subinv']);
              $idx = 'a';
              foreach ($cek_sub_inv as $key2 => $value2) {
                $tampung_cek[$idx] = $value2;
                $idx++;
              }
              ?>
              <select class="select2232" name="subinv[<?php echo $key ?>][]" style="width:100%" tabindex="-1"  required multiple>
                <option value=""></option>
                <option value="INT-FDY" <?= !empty(array_search('INT-FDY', $tampung_cek)) ? 'selected' : '' ?>>INT-FDY - GUDANG INTERNAL UNIT FOUNDRY</option>
                <option value="INT-FDYTKS" <?= !empty(array_search('INT-FDYTKS', $tampung_cek)) ? 'selected' : '' ?>>INT-FDYTKS - GUDANG INTERNAL UNIT FOUNDRY DI TUKSONO</option>
                <option value="FDY-PM" <?= !empty(array_search('FDY-PM', $tampung_cek)) ? 'selected' : '' ?>>FDY-PM - GUDANG FOUNDRY DI PUSAT</option>
                <option value="FDY-TKS" <?= !empty(array_search('FDY-TKS', $tampung_cek)) ? 'selected' : '' ?>>FDY-TKS - GUDANG FOUNDRY DI TUKSONO</option>
              </select>
            </td>
            <td> <button type="button" class="btn btn-sm btn-default" name="button" onclick="up2l_min_selep_setting_subinv(this)"> <i class="fa fa-times"></i> </button> </td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
</div>
<center><button type="submit" class="btn btn-success" name="button" style="font-weight:bold;margin-top:10px;margin-bottom:10px;width:20%"> <i class="fa fa-save"></i> Save </button>

</form>

<script type="text/javascript">
  $('.select2232').select2({
    tags: true,
    tokenSeparators: [',']
  });
  function up2l_min_selep_setting_subinv(b) {
   $(b).parent().parent('tr').remove();
  }
  function up2l_add_selep_setting_subinv() {
    let no = Number($('.up2l_ss_88 tbody tr').length);
    $('.up2l_ss_88 tbody').append(`<tr>
      <td>
        <input type="text" class="form-control" name="no_induk[]" style="text-transform:uppercase" value="" required>
      </td>
      <td>
        <select class="select2232" name="subinv[${no}][]" style="width:100%" tabindex="-1" multiple required>
          <option value=""></option>
          <option value="INT-FDY" >INT-FDY - GUDANG INTERNAL UNIT FOUNDRY</option>
          <option value="INT-FDYTKS">INT-FDYTKS - GUDANG INTERNAL UNIT FOUNDRY DI TUKSONO</option>
          <option value="FDY-PM">FDY-PM - GUDANG FOUNDRY DI PUSAT</option>
          <option value="FDY-TKS">FDY-TKS - GUDANG FOUNDRY DI TUKSONO</option>
        </select>
      </td>
      <td> <button type="button" class="btn btn-sm btn-default" name="button" onclick="up2l_min_selep_setting_subinv(this)"> <i class="fa fa-times"></i> </button> </td>
    </tr>`);

    $('.select2232').select2({
      tags: true,
      tokenSeparators: [',']
    });
  }

  $('#form-submit-up2l-setting-subinv').on('submit', function(th) {
    th.preventDefault();
    let form_data  = new FormData(this);
    $.ajax({
      url: baseurl + 'ManufacturingOperationUP2L/Selep/update_user_subinv',
      type: 'POST',
      data : form_data,
      contentType: false,
      cache: false,
      processData: false,
      dataType: "JSON",
      beforeSend: function() {
        // $('#modalUP2LCompleteJob').modal('hide');
        Swal.fire({
          onBeforeOpen: () => {
             Swal.showLoading();
             $('.swal2-loading').children('button').css({'width': '40px', 'height': '40px'})
           },
          text: 'Sedang menyimpan data..'
        })
      },
      success: function(result_2) {
        if (result_2 == 200) {
          swalup2l('success', 'Data berhasil tersimpan.')
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalup2l('error', XMLHttpRequest);
       console.error();
      }
    })
  })
</script>
