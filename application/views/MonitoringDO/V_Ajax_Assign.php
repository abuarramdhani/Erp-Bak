<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblMonitoringAssign" style="font-size:12px;width:100%">
    <thead>
      <tr class="bg-primary">
        <th style="width:5px"><center>NO</center></th>
        <th style="width:70px"><center>NO.DOK</center></th>
        <th style="width:70px"><center>NOMOR SO</center></th>
        <th><center>TUJUAN</center></th>
        <th style="width:100px"><center>KOTA</center></th>
        <th style="width:70px"><center>PLAT NOMOR</center></th>
        <th style="width:70px"><center>ASSIGN</center></th>
        <th style="width:50px"><center>TGL PENGIRIMAN</center></th>
        <th style="width:15px"><center>DETAIL</center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $g): ?>
        <tr row-id="<?php echo $no ?>">
          <td><center><?php echo $no; ?></center></td>
          <td><center><?php echo $g['DO/SPB'] ?></center></td>
          <td><center><?php echo $g['NO_SO'] ?></center></td>
          <td><center><?php echo $g['TUJUAN'] ?></center></td>
          <td><center><?php echo $g['KOTA'] ?></center></td>
          <td><center><?php echo $g['PLAT_NUMBER'] ?></center></td>
          <td><center><?php echo $g['PETUGAS'] ?></center></td>
          <td><center><?php echo strtoupper(date("d-M-Y", strtotime($g['TGL_KIRIM']))) ?></center></td>

          <td><center><button type="button" class="btn btn-info" name="button" style="font-weight:bold;" onclick="detailAssign('<?php echo $g['DO/SPB'] ?>', <?php echo $no ?>)" data-toggle="modal" data-target="#MyModalAssign"><i class="fa fa-eye"></i></button> </center></td>
        </tr>
      <?php $no++; endforeach; ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $('#tblMonitoringAssign').DataTable();
</script>
