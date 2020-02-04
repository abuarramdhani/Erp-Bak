<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblMonitoringDOTransact" style="font-size:12px;width:100%">
    <thead>
      <!-- <tr class="bg-primary">
        <th style="width:5%"><center>NO</center></th>
        <th style="width:15%"><center>NOMOR DO</center></th>
        <th style="width:25%"><center>TUJUAN</center></th>
        <th style="width:15%"><center>KOTA</center></th>
        <th><center>STATUS</center></th>
        <th><center>NEXT PROCESS</center></th>
        <th style="width:20%"><center>DETAIL</center></th>
        <th style="width:20%"><center>CETAK</center></th>
      </tr> -->
      <tr class="bg-primary">
        <th><center>NO</center></th>
        <th><center>NOMOR DO</center></th>
        <th><center>NOMOR SO</center></th>
        <th><center>TUJUAN</center></th>
        <th><center>KOTA</center></th>
        <th><center>PLAT NOMOR</center></th>
        <th><center>ASSIGN</center></th>
        <th><center>DETAIL</center></th>
        <th style="width:20%"><center>CETAK</center></th>
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
          <td><center><button type="button" class="btn btn-info" name="button" style="font-weight:bold;" onclick="detailTransact(<?php echo $g['DO/SPB'] ?>, <?php echo $no ?>)" data-toggle="modal" data-target="#MyModalTransact"><i class="fa fa-eye"></i></button> </center></td>
          <td>
            <center>
              <a href="<?php echo base_url('MonitoringDO/PDF/'.$g['DO/SPB']) ?>" target="_blank" onclick="dodo3()" class="btn btn-danger">Cetak</a>
            </center>
          </td>
        </tr>
        <!-- <tr>
          <td><center><?php echo $no; ?></center></td>
          <td><center><?php echo $g['DO/SPB'] ?></center></td>
          <td><center><?php echo $g['TUJUAN'] ?></center></td>
          <td><center><?php echo $g['KOTA'] ?></center></td>
          <td><center>Sudah transact</center></td>
          <td><center>Cetak DO</center></td>
          <td><center><button type="button" class="btn btn-info" name="button" style="font-weight:bold;" onclick="detailTransact(<?php echo $g['DO/SPB'] ?>, <?php echo $no ?>)" data-toggle="modal" data-target="#MyModalTransact"><i class="fa fa-eye"></i></button> </center></td>
          <td>
            <center>
              <a href="<?php echo base_url('MonitoringDO/PDF/'.$g['DO/SPB']) ?>" target="_blank" onclick="dodo3()" class="btn btn-danger">Cetak</a>
            </center>
          </td>
        </tr> -->
      <?php $no++; endforeach; ?>
    </tr>
    </tbody>
  </table>
</div>

<script type="text/javascript">
  $('#tblMonitoringDOTransact').DataTable();
</script>
