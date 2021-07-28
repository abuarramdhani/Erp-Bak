<table class="table table-bordered table-hover table-striped text-center" id="tb_status">
  <thead class="bg-primary">
    <tr>
      <th style="width:5%;">No</th>
      <th style="width:25%;">Order</th>
      <th>Status</th>
      <th>Tanggal Mulai</th>
      <th>Tanggal Estimasi</th>
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
        <td><?php echo $value['handling_name']?></td>
        <td><?php echo $value['status_name']?></td>
        <?php if ($value['status'] == -1) { ?>
          <td></td>
          <td></td>
          <td><button type="button" class="btn btn-sm btn-danger" style="width:300px" onclick="revisi_order('<?php echo $value['order_number']?>')"><i class="fa fa-pencil"></i> Ajukan Revisi</button></td>
          <td></td>
          <td></td>
        <?php }else { ?>
          <td><?php echo $value['start_date']?></td>
          <td><?php echo $value['plot_enddate']?></td>
          <td><?php echo $value['persiapan_qty']?></td>
          <td><?php echo $value['pengelasan_qty']?></td>
          <td><?php echo $value['pengecatan_qty']?></td>
        <?php }?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
