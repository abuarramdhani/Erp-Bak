<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblMonitoringDOAllocate" style="font-size:12px;width:100%">
    <thead>
      <tr class="bg-primary">
        <th><center>NO</center></th>
        <th><center>NOMOR DO</center></th>
        <th><center>NOMOR SO</center></th>
        <th><center>TUJUAN</center></th>
        <th><center>KOTA</center></th>
        <th><center>PLAT NOMOR</center></th>
        <th><center>ASSIGN</center></th>
        <th><center>DETAIL</center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $g): ?>
        <tr>
          <td><center><?php echo $no; ?></center></td>
          <td><center><?php echo $g['DO/SPB'] ?></center></td>
          <td><center><?php echo $g['NO_SO'] ?></center></td>
          <td><center><?php echo $g['TUJUAN'] ?></center></td>
          <td><center><?php echo $g['KOTA'] ?></center></td>
          <td><center><?php echo $g['PLAT_NUMBER'] ?></center></td>
          <td><center><?php echo $g['PETUGAS'] ?></center></td>
          <td><center><button type="button" class="btn btn-info" name="button" style="font-weight:bold;" onclick="detailAllocate('<?php echo $g['DO/SPB'] ?>', <?php echo $no ?>)" data-toggle="modal" data-target="#MyModalAllocate"><i class="fa fa-eye"></i></button> </center></td>
        </tr>
      <?php $no++; endforeach; ?>

    </tbody>
  </table>
</div>

<script type="text/javascript">
  $('#tblMonitoringDOAllocate').DataTable();
</script>
