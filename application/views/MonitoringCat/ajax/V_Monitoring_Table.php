<form method="post" target="_blank">
<div class="table-responsive">
<table class="table table-bordered table-hover text-center cat_datatable" style="width:100%">
  <thead class="bg-primary">
    <tr>
      <th style="width:5%;">No</th>
      <th>Code</th>
      <th>No LPPB</th>
      <th>Item Code</th>
      <th>Item Name</th>
      <th>Quantity</th>
      <th>Transaction Date</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="">
    <?php foreach ($data as $key => $value): ?>
      <tr row-id="">
        <td><?php echo $key+1 ?>
            <input type="hidden" id="inv<?= $key+1?>" name="inv[]" value="<?php echo $value['INVENTORY_ITEM_ID'] ?>">
        </td>
        <td><input type="hidden" id="code<?= $key+1?>" name="code[]" value="<?php echo $value['CODE'] ?>"><?php echo $value['CODE'] ?></td>
        <td><input type="hidden" id="receipt_num<?= $key+1?>" name="receipt_num[]" value="<?php echo $value['RECEIPT_NUM'] ?>"><?php echo $value['RECEIPT_NUM'] ?></td>
        <td><input type="hidden" id="kode_item<?= $key+1?>" name="kode_item[]" value="<?php echo $value['SEGMENT1'] ?>"><?php echo $value['SEGMENT1'] ?></td>
        <td><input type="hidden" id="nama_item<?= $key+1?>" name="nama_item[]" value="<?php echo $value['DESCRIPTION'] ?>"><?php echo $value['DESCRIPTION'] ?></td>
        <td><input type="hidden" id="qty<?= $key+1?>" name="qty[]" value="<?php echo $value['QUANTITY'] ?>"><?php echo $value['QUANTITY'] ?></td>
        <td><input type="hidden" id="transaction_date<?= $key+1?>" name="transaction_date[]" value="<?php echo $value['TRANSACTION_DATE'] ?>"><?php echo $value['TRANSACTION_DATE'] ?></td>
        <td><button type="button" class="btn btn-danger" <?= $value['STATUS_OUT'] == 'N' ? '' : 'disabled'?> onclick="deletemoncat('<?= $value['CODE']?>')"><i class="fa fa-trash"></i></button>
            <button class="btn btn-warning" formaction="<?php echo base_url("MonitoringCat/Monitoring/cetak_cat/".$value['CODE']."")?>"><i class="fa fa-print"></i></button></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
</form>