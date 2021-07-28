<table class="datatable table table-bordered table-hover table-striped text-center" id="tb_plot" style="width:100%">
  <thead style="background-color:#6CCCFA">
    <tr>
      <th style="width:5%;">No</th>
      <th style="">Order</th>
      <th style="">QTY</th>
      <th style="">Due Date</th>
      <th style="">Action</th>
    </tr>
  </thead>
  <tbody id="">
    <?php foreach ($data as $key => $value): ?>
      <tr row-id="">
        <td><?php echo $key+1 ?>
            <input type="hidden" id="id_order<?= $key+1?>" value="<?php echo $value['order_number']?>">
        </td>
        <td><?php echo $value['handling_name']?></td>
        <td><?php echo $value['quantity']?></td>
        <td><?php echo $value['due_date']?></td>
        <td>
          <button type="button" id="btn_approve" class="btn btn-sm btn-success" onclick="periode_plotting('<?php echo $value['order_number']?>', <?= $value['revision_number']?>)"><i class="fa fa-check"></i> Plot</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
