<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblMonitoringDOSudahCetak" style="font-size:12px;width:100%">
    <thead>
      <tr class="bg-primary">
        <th style="width:5px"><center>NO</center></th>
        <th style="width:10px"><center>NO.DOK</center></th>
        <th style="width:10px"><center>TUJUAN</center></th>
        <th style="width:10px"><center>KOTA</center></th>
        <th style="width:10px"><center>PLAT NOMOR</center></th>
        <th style="width:5px"><center>PETUGAS</center></th>
        <th style="width:5px"><center>DETAIL</center></th>
        <th style="width:5px"><center>CETAK</center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $g): ?>
        <tr>
          <td><center><?php echo $no; ?></center></td>
          <td><center><?php echo $g['DO/SPB'] ?></center></td>
          <td><center><?php echo $g['TUJUAN'] ?></center></td>
          <td><center><?php echo $g['KOTA'] ?></center></td>
          <td><center><?php echo $g['PLAT_NUMBER'] ?></center></td>
          <td><center><?php echo $g['PETUGAS'] ?></center></td>
          <td><center><button type="button" class="btn btn-info" name="button" style="font-weight:bold;" onclick="GetSudahCetakDetail('<?php echo $g['DO/SPB'] ?>', <?php echo $no ?>)" data-toggle="modal" data-target="#MyModalTransact"><i class="fa fa-eye"></i></button> </center></td>
          <td>
            <center>
              <a href="<?php echo base_url('MonitoringDO/SettingDO/PDF2/'.$g['DO/SPB']) ?>" target="_blank" onclick="clickCetak('<?php echo $g['DO/SPB'] ?>')" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a>
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
