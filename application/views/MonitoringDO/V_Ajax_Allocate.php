<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblMonitoringDOAllocate" style="font-size:12px;width:100%">
    <thead>
      <tr class="bg-primary">
        <th style="width:5%"><center>NO</center></th>
        <th style="width:20%"><center>NOMORDO</center></th>
        <th style="width:25%"><center>TUJUAN</center></th>
        <th style="width:30%"><center>KOTA</center></th>
        <th><center>STATUS</center></th>
        <th><center>NEXT PROCESS</center></th>
        <th style="width:20%"><center>DETAIL</center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $g): ?>
        <tr>
          <td><center><?php echo $no; ?></center></td>
          <td><center><?php echo $g['DO/SPB'] ?></center></td>
          <td><center><?php echo $g['TUJUAN'] ?></center></td>
          <td><center><?php echo $g['KOTA'] ?></center></td>
          <td><center>Sudah Sudah Ter-allocate</center></td>
          <td><center>Transact</center></td>
          <td><center><button type="button" class="btn btn-info" name="button" style="font-weight:bold;" onclick="detailAllocate(<?php echo $g['DO/SPB'] ?>, <?php echo $no ?>)" data-toggle="modal" data-target="#MyModalAllocate"><i class="fa fa-eye"></i></button> </center></td>
        </tr>
      <?php $no++; endforeach; ?>
    </tr>
    </tbody>
  </table>
</div>

<script type="text/javascript">
  $('#tblMonitoringDOAllocate').DataTable();
</script>
