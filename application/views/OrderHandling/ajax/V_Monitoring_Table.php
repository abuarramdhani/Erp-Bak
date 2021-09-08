<table class="table table-bordered table-hover text-center" id="tb_order">
  <thead class="bg-primary">
    <tr>
      <th style="width:5%;">No</th>
      <th>Nama Pengorder</th>
      <th>Seksi Pengorder</th>
      <th>Order</th>
      <th>QTY</th>
      <th>Due Date</th>
      <th>Gambar</th>
      <th>Approval</th>
    </tr>
  </thead>
  <tbody id="">
    <?php foreach ($data as $key => $value): ?>
      <tr row-id="">
        <td><?php echo $key+1 ?>
            <input type="hidden" id="id_order<?= $key+1?>" value="<?php echo $value['order_number']?>">
            <input type="hidden" id="id_revisi<?= $key+1?>" value="<?php echo $value['revision_number']?>">
        </td>
        <td><?php echo $value['created_by']?> - <?php echo $value['pengorder']?></td>
        <td><?php echo $value['section_name']?></td>
        <td><?php echo $value['handling_name']?></td>
        <td><?php echo $value['quantity']?></td>
        <td><?php echo $value['due_date']?></td>
        <td>
          <?php if (empty($value['design'])) { ?>
              <button class="btn btn-default" disabled><i class="fa fa-picture-o"></i></button>
          <?php }else { ?>
            <a href="<?php echo base_url("./assets/upload/OrderTimHandling/design/".$value['design']."")?>" target="_blank">
              <button class="btn btn-default"><i class="fa fa-picture-o"></i></button>
            </a>
          <?php }?>
        </td>
        <td class="text-center text-nowrap">
          <button type="button" id="btn_approve" class="btn btn-success" onclick="approveOrder('<?php echo $value['order_number']?>', <?php echo $value['revision_number']?>)"><i class="fa fa-check"></i></button>
          <button type="button" id="btn_reject" class="btn btn-danger" onclick="rejectOrder('<?php echo $value['order_number']?>', <?php echo $value['revision_number']?>)"><i class="fa fa-close"></i></button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
