<div class="table-responsive">
<table class="table table-bordered table-hover text-center cat_datatable" style="width:100%">
  <thead class="bg-primary">
    <tr>
      <th style="width:5%;">No</th>
      <th>Item Code</th>
      <th>Item Name</th>
      <th>Conversion</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="">
    <?php foreach ($data as $key => $value): ?>
      <tr row-id="">
        <td><?php echo $key+1 ?>
            <input type="hidden" id="inv<?= $key+1?>" name="inv[]" value="<?php echo $value['INVENTORY_ITEM_ID'] ?>">
            <input type="hidden" id="item<?= $key+1?>" name="item[]" value="<?php echo $value['SEGMENT1'] ?>">
            <input type="hidden" id="conversion<?= $key+1?>" name="conversion[]" value="<?php echo floatval($value['CONVERSION']) ?>">
        </td>
        <td><?php echo $value['SEGMENT1'] ?></td>
        <td><?php echo $value['DESCRIPTION'] ?></td>
        <td><?php echo floatval($value['CONVERSION']); ?></td>
        <td><button type="button" class="btn btn-info" onclick="editsettingcat(<?= $value['INVENTORY_ITEM_ID']?>, <?= ($key+1)?>)"><i class="fa fa-pencil"></i></button>
            <button type="button" class="btn btn-danger" onclick="deletesettingcat(<?= $value['INVENTORY_ITEM_ID']?>)"><i class="fa fa-trash"></i></button></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>