<table class="table table-bordered tbl_cst_4" style="width:100%">
  <thead class="bg-primary">
    <tr>
      <th class="text-center" style="vertical-align:middle;width:5%;">No</th>
      <th class="text-center" style="vertical-align:middle;width:35%;">Nama Item</th>
      <th class="text-center" style="vertical-align:middle;width:18%">Item Code</th>
      <th class="text-center" style="vertical-align:middle;width:17%">UOM</th>
      <th class="text-center" style="vertical-align:middle;width:17%">Creted By</th>
      <th class="text-center" style="width:8%">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($get as $key => $value): ?>
      <tr>
        <td class="text-center"><?php echo $key+1 ?></td>
        <td class="text-center"><?php echo $value['DESCRIPTION'] ?></td>
        <td class="text-center"><?php echo $value['SEGMENT1'] ?></td>
        <td class="text-center"><?php echo $value['PRIMARY_UOM_CODE'] ?></td>
        <td class="text-center"><?php echo $value['PENGAJUAN_BY'] ?></td>
        <td class="text-center">
          <button class="btn btn-sm btn-success text-bold" style="width:105px" onclick="runupdate2('<?php echo $value['ITEM_ID'] ?>', '1', this)"><i class="fa fa-check-square-o"></i> Approve</button>
          <button class="btn btn-sm btn-default text-bold mt-1" style="width:105px" onclick="runupdate2('<?php echo $value['ITEM_ID'] ?>', '2', this)"><i class="fa fa-times"></i> Reject</button>
        </td>
      </tr>
    <?php endforeach; ?>

  </tbody>
</table>


<script type="text/javascript">
  let tabel_cst_4 = $('.tbl_cst_4').DataTable()
  function runupdate2(item_id, status, th) {
    $.ajax({
    url: baseurl + 'consumabletimv2/action/updatestatusitem',
    type: 'POST',
    data : {
      item_id : item_id,
      status : status
    },
    cache: false,
    dataType: "JSON",
    beforeSend: function() {
      swaCSTLoading('Processing data..')
    },
    success: function(result) {
      if (result == 200) {
        if (status == 1) {
          swaCSTLarge('success', `Item successfully approved`);
        }else if (status == 2) {
          swaCSTLarge('success', `Item successfully rejected`);
        }
        detailapprovalcstitem(<?php echo $kodesie ?>);
      }else {
        swaCSTLarge('warning', 'Terjadi Kesalahan Saat Melakukan Approve Data! Harap Coba lagi');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaCSTLarge('error', XMLHttpRequest);
     console.error();
    }
    })
  }

</script>
