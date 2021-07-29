<table class="table table-bordered tbl_cst_3" style="width:100%">
  <thead class="bg-primary">
    <tr>
      <th class="text-center" style="vertical-align:middle;width:5%;">No</th>
      <th class="text-center" style="vertical-align:middle;width:35%;">Nama Item</th>
      <th class="text-center" style="vertical-align:middle;width:18%">Item Code</th>
      <th class="text-center" style="vertical-align:middle;width:17%">Quantity</th>
      <th class="text-center" style="vertical-align:middle;width:17%">UOM</th>
      <th class="text-center" style="width:8%">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($get as $key => $value): ?>
      <tr>
        <td class="text-center"><?php echo $key+1 ?></td>
        <td class="text-center"><?php echo $value['DESCRIPTION'] ?></td>
        <td class="text-center"><?php echo $value['SEGMENT1'] ?></td>
        <td class="text-center"><?php echo $value['REQ_QUANTITY'] ?></td>
        <td class="text-center"><?php echo $value['PRIMARY_UOM_CODE'] ?></td>
        <td class="text-center">
          <button class="btn btn-sm btn-success text-bold" style="width:105px" onclick="approvekebutuhan('<?php echo $value['ITEM_ID'] ?>', '1', this)"><i class="fa fa-check-square-o"></i> Approve</button>
          <button class="btn btn-sm btn-default text-bold mt-1" style="width:105px" onclick="approvekebutuhan('<?php echo $value['ITEM_ID'] ?>', '2', this)"><i class="fa fa-times"></i> Reject</button>
        </td>
      </tr>
    <?php endforeach; ?>

  </tbody>
</table>



<script type="text/javascript">
  let tabel_cst_3 = $('.tbl_cst_3').DataTable()
  function runupdate(item_id, status, reason) {
    $.ajax({
    url: baseurl + 'consumabletimv2/action/updatestatusitemkebutuhan',
    type: 'POST',
    data : {
      item_id : item_id,
      status : status,
      reason : reason
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
        detailapprovalcst(<?php echo $kodesie ?>);
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

  function cstreject(item_id, status) {
    let alasan = $(`.alasan_${item_id}`).val();
    runupdate(item_id, status, alasan)
  }

  function approvekebutuhan(item_id, status, th) {
    if (status == 2) {
      console.log(item_id, 'ini itemid');
      let tr = $(th).parent().parent('tr');
      let row = tabel_cst_3.row(tr);
      if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
      } else {
        row.child(`<div class="form-group" style="width:100%;padding:13px;background:#ececec;border-radius:7px;">
                      <label for="">Alasan Reject</label>
                      <table style="width:100%">
                        <tr>
                          <td style="width:85%"><input type="text" style="width:100%" name="name" class="form-control alasan_${item_id}"></td>
                          <td><button type="button" class="btn btn-default ml-2 text-bold" style="width:100%" name="button" onclick="cstreject(${item_id}, ${status})"> <i class="fa fa-save"></i> Submit</button></td>
                        </tr>
                      </table>
                    </div>`).show();
        tr.addClass('shown');
      }
    }else if (status == 1) {
      runupdate(item_id, status, '')
    }
  }
</script>
