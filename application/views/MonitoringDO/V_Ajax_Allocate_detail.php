<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblMonitoringAllocateDetail" style="font-size:12px;">
    <thead>
      <tr class="bg-primary">
        <th><center>NO</center></th>
        <!-- <th><center>NOMOR DO</center></th> -->
        <th><center>ITEM CODE</center></th>
        <th><center>ITEM DESKRIPSI</center></th>
        <th><center>QTY REQUEST</center></th>
        <th><center>QTY ALLOCATE</center></th>
        <th><center>ATR</center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $g): ?>
        <tr>
          <td><center><?php echo $no; ?></center></td>
          <!-- <td><center><?php echo $g['DO/SPB'] ?></center></td> -->
          <td><center><?php echo $g['SEGMENT1'] ?></center></td>
          <td><center><?php echo $g['DESCRIPTION'] ?></center></td>
          <td><center><?php echo $g['QTY_REQ'] ?></center></td>
          <td><center><?php echo $g['QTY_ALLOCATED'] ?></center></td>
          <td><center><?php echo $g['ATR'] ?></center></td>
        </tr>
      <?php $no++; endforeach; ?>
    </tr>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $('#tblMonitoringAllocateDetail').DataTable();
</script>
