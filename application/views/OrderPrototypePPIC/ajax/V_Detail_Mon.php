<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left" <?= $no_urut != '0012' ? 'id="tblopp"' : '' ?> style="font-size:12px;">
    <thead>
      <tr class="bg-success">
        <th style="width:15%"><center>Urutan Proses</center></th>
        <th><center>Proses</center></th>
        <th><center>Seksi</center></th>
        <th ><center>No Order Out</center></th>
        <th ><center>Status</center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $key => $g): $tampung[] = ['id' => $g['id'], 'proses' => $g['proses'], 'seksi' => $g['seksi']]; ?>
        <tr row-nya="<?php echo $no ?>">
          <td><center><?php echo $no; ?></center></td>
          <td><center><?php echo $g['proses'] ?></center></td>
          <td><center><?php echo $g['seksi'] ?></center></td>
          <td>
            <center>
              <?php echo $g['no_order_out'] ?>
            </center>
          </td>
          <td>
            <center>
              <?php if (empty($g['status'])) { ?>
                <span class="label label-warning" style="font-size:12px;"><i class="fa fa-check"></i> Pending </span>
              <?php }elseif($g['status'] == 'Y') {?>
                <span class="label label-primary" style="font-size:12px;"><i class="fa fa-check"></i> Order Diterima </span>
              <?php }elseif($g['status'] == 'D') {?>
                <span class="label label-success" style="font-size:12px;"><i class="fa fa-check"></i> Order Selesai Dibuat </span>
              <?php }?>
            </center>
          </td>
        </tr>
      <?php $no++; endforeach; ?>

    </tbody>
  </table>
</div>
<textarea hidden id="opp_tampung_id" rows="8" cols="80"><?php echo json_encode($tampung) ?></textarea>
<script type="text/javascript">
$('#tblopp').DataTable({
  "pageLength": 10,
});
