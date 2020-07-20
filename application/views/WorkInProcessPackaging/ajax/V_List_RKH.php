<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left tblwiip3" style="font-size:12px;">
    <thead>
      <tr class="bg-info">
        <th style="width:5%"><center>No</center></th>
        <th style="width:25%">TANGGAL</th>
        <th style="width:25%">WAKTU 1 SHIFT</th>
        <th style="width:45%"><center>ACTION </center></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($pp as $key => $p): ?>
        <?php
         if ($p['waktu_satu_shift'] == 7 || $p['waktu_satu_shift'] == 6) {
           $style = '';
         }else {
           $style = 'rgba(255, 0, 84, 0.29)';
         }
         ?>
        <tr style="background:<?php echo $style ?>">
          <td><?php echo $key+1 ?></td>
          <td><?php echo $p['date_target'] ?></td>
          <td><?php echo $p['waktu_satu_shift'] ?> Jam</td>
          <td>
            <center>
            <a class="btn btn-md bg-navy" href="<?php echo base_url('WorkInProcessPackaging/JobManager/Label/'.$p['date_target'].'')?>"><i class="fa fa-print"></i> Label</a>
            <a class="btn btn-md bg-navy" href="<?php echo base_url('WorkInProcessPackaging/JobManager/ArrangeJobList/'.$p['date_target'].'')?>"> <i class="fa fa-edit"></i> <b>Edit</b></a>
          </center>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $('.tblwiip3').DataTable();
</script>
