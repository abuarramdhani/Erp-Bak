<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblMonitoringDOSudahCetak" style="font-size:12px;width:100%">
    <thead>
      <tr class="bg-primary">
        <th style="width:5%"><center>NO</center></th>
        <th style="width:15%"><center>NOMOR DO</center></th>
        <th style="width:25%"><center>TUJUAN</center></th>
        <th style="width:15%"><center>KOTA</center></th>
        <th><center>PETUGAS</center></th>
        <th><center>DETAIL</center></th>
        <th><center>CETAK</center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $g): ?>
        <tr>
          <td><center><?php echo $no; ?></center></td>
          <td><center><?php echo $g['REQUEST_NUMBER'] ?></center></td>
          <td><center><?php echo $g['TUJUAN'] ?></center></td>
          <td><center><?php echo $g['KOTA'] ?></center></td>
          <td><center><?php echo $g['PETUGAS'] ?></center></td>
          <td><center><button type="button" class="btn btn-info" name="button" style="font-weight:bold;" onclick="detailTransact(<?php echo $g['REQUEST_NUMBER'] ?>, <?php echo $no ?>)" data-toggle="modal" data-target="#MyModalTransact"><i class="fa fa-eye"></i></button> </center></td>
          <td>
            <center>
              <a href="<?php echo base_url('MonitoringDO/SettingDO/PDF2/'.$g['REQUEST_NUMBER']) ?>" target="_blank" onclick="clickCetak(<?php echo $g['REQUEST_NUMBER'] ?>)" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a>
            </center>
          </td>
        </tr>
      <?php $no++; endforeach; ?>
    </tr>
    </tbody>
  </table>
</div>

<script type="text/javascript">
  $('#tblMonitoringDOSudahCetak').DataTable();
</script>
