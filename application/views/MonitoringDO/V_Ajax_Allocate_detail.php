<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblMonitoringAllocateDetail" style="font-size:12px;">
    <thead>
      <tr class="bg-primary">
        <th><center>NO</center></th>
        <th><center>NOMOR DO</center></th>
        <th><center>ITEM CODE</center></th>
        <th><center>ITEM DESKRIPSI</center></th>
        <th><center>QUANTITY</center></th>
        <th><center>STOCK</center></th>
        <th><center>PETUGAS</center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $g): ?>
        <tr>
          <td><center><?php echo $no; ?></center></td>
          <td><center><?php echo $g['DO/SPB'] ?></center></td>
          <td><center><?php echo $g['SEGMENT1'] ?></center></td>
          <td><center><?php echo $g['DESCRIPTION'] ?></center></td>
          <td><center><?php echo $g['QUANTITY'] ?></center></td>
          <td><center><?php echo $g['STOCK'] ?></center></td>
          <td><center><?php echo $g['PETUGAS'] ?></center></td>
        </tr>
      <?php $no++; endforeach; ?>
    </tr>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $('#tblMonitoringAllocateDetail').DataTable();
</script>
