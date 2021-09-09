<table class="table table-bordered table-hover table-striped text-center" id="tb_achiev<?= $ket == 'today' ? 1 : 2?>">
  <thead class="bg-primary">
    <tr>
      <th style="width:5%;">No</th>
      <th>Tanggal</th>
      <th>Order</th>
      <th>Quantity</th>
      <th>Persiapan</th>
      <th>Pengelasan</th>
      <th>Pengecatan</th>
    </tr>
  </thead>
  <tbody id="">
    <?php foreach ($data as $key => $value): ?>
      <tr row-id="">
        <td><?php echo $key+1 ?>
            <input type="hidden" id="id_order<?= $key+1?>" value="<?php echo $value['order_number']?>">
        </td>
        <td><?php echo $value['finish_date']?></td>
        <td><?php echo $value['handling_name']?></td>
        <td><?php echo $value['quantity']?></td>
        <td><?php echo $value['persiapan_qty']?></td>
        <td><?php echo $value['pengelasan_qty']?></td>
        <td><?php echo $value['pengecatan_qty']?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
