<form method="post" target="_blank" action="<?php echo base_url("MonitoringCat/InputCat/cetak_cat")?>">
<div class="table-responsive">
<table class="table table-bordered table-hover text-center cat_datatable" style="width:100%">
  <thead class="bg-primary">
    <tr>
      <th style="width:5%;">No</th>
      <th>No LPPB</th>
      <th>Item Code</th>
      <th>Item Name</th>
      <th>Quantity</th>
      <th>UOM</th>
      <th>Transaction Date</th>
      <th>Jumlah Pail</th>
    </tr>
  </thead>
  <tbody id="">
    <?php foreach ($data as $key => $value): ?>
      <tr row-id="">
        <td><?php echo $key+1 ?>
            <input type="hidden" name="inv[]" value="<?php echo $value['INVENTORY_ITEM_ID'] ?>">
        </td>
        <td><input type="hidden" name="receipt_num[]" value="<?php echo $value['RECEIPT_NUM'] ?>"><?php echo $value['RECEIPT_NUM'] ?></td>
        <td><input type="hidden" name="kode_item[]" value="<?php echo $value['SEGMENT1'] ?>"><?php echo $value['SEGMENT1'] ?></td>
        <td><input type="hidden" name="nama_item[]" value="<?php echo $value['DESCRIPTION'] ?>"><?php echo $value['DESCRIPTION'] ?></td>
        <td><input type="hidden" name="qty[]" value="<?php echo $value['QUANTITY'] ?>"><?php echo $value['QUANTITY'] ?></td>
        <td><input type="hidden" name="uom[]" value="<?php echo $value['PRIMARY_UNIT_OF_MEASURE'] ?>"><?php echo $value['PRIMARY_UNIT_OF_MEASURE'] ?></td>
        <td><input type="hidden" name="transaction_date[]" value="<?php echo $value['TRANSACTION_DATE'] ?>"><?php echo $value['TRANSACTION_DATE'] ?></td>
        <td><input type="hidden" name="pail[]" value="<?php echo $value['PAIL'] ?>"><?php echo $value['PAIL'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
<div class="panel-body text-right">
    <button type="submit" class="btn btn-lg btn-warning"><i class="fa fa-print"></i> Cetak</button>
</div>
</form>