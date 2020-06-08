<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left tblwiip4" style="font-size:12px;">
    <thead>
      <tr class="bg-info">
        <th>
          <center>NO</center>
        </th>
        <th>
          <center>NO JOB</center>
        </th>
        <th>
          <center>KODE ITEM</center>
        </th>
        <th>
          <center>NAMA ITEM</center>
        </th>
        <th>
          <center>QTY</center>
        </th>
        <th>
          <center>USAGE RATE</center>
        </th>
        <th>
          <center>SCHEDULED START DATE </center>
        </th>
        <th>
          <center>TARGET PE </center>
        </th>
        <th>
          <center>ACTION </center>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get as $key => $g): ?>
        <tr>
          <td>
            <center><?php echo $key+1 ?></center>
          </td>
          <td>
            <center><?php echo $g['no_job'] ?></center>
          </td>
          <td>
            <center><?php echo $g['kode_item'] ?></center>
          </td>
          <td>
            <center><?php echo $g['nama_item'] ?></center>
          </td>
          <td style="background:rgba(58, 149, 215, 0.3)">
            <center><?php !empty($g['qty_split']) ? $qty = $g['qty_split'] : $qty = $g['qty']; echo $qty; ?></center>
          </td>
          <td>
            <center><?php echo $g['usage_rate'] ?></center>
          </td>
          <td>
            <center><?php echo $g['scedule_start_date'] ?></center>
          </td>
          <td style="background:rgba(58, 149, 215, 0.3)">
            <center>
            <?php
              $h = $g['waktu_satu_shift']/($g['qty']/$g['usage_rate']);
              !empty($g['target_pe_split']) ? $pe = $g['target_pe_split'] : $pe = $h;
              echo $pe.'%';
            ?></center>
          </td>
          <td>
            <center><button type="button" class="btn btn-md bg-navy" onclick="getModalSplit('<?php echo $g['no_job'] ?>', '<?php !empty($g['qty_parrent']) ? $qt = $g['qty_parrent'] : $qt = $g['qty']; echo $qt ?>', '<?php echo $g['kode_item'] ?>', '<?php echo $g['nama_item'] ?>', '<?php echo $h ?>', '<?php echo $g['usage_rate'] ?>', '<?php echo $g['waktu_satu_shift'] ?>', '<?php echo $g['date_target'] ?>', '<?php echo $g['create_at'] ?>')" data-toggle="modal" data-target="#wipp2" name="button"><i class="fa fa-cut"></i> <b>Split</b></button></center>
          </td>
        </tr>
      <?php endforeach; ?>

    </tbody>
  </table>
</div>
<script type="text/javascript">
$('.tblwiip4').DataTable({
  "pageLength": 10,
});
</script>
