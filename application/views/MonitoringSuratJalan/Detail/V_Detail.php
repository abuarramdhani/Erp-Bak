<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblpbidetail" style="font-size:12px;">
    <thead>
      <tr class="bg-primary">
        <th><center>NO</center></th>
        <th><center>ITEM CODE</center></th>
        <th><center>ITEM DESKRIPSI</center></th>
        <th><center>QUANTITY</center></th>
        <th><center>UOM</center></th>
        <th><center>ITEM TYPE</center></th>
        <th><center>NO MO</center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $g): ?>
        <tr>
          <td><center><?php echo $no; ?></center></td>
          <td><center><?php echo $g['ITEM_CODE'] ?></center></td>
          <td><center><?php echo $g['DESCRIPTION'] ?></center></td>
          <td><center><?php echo $g['QUANTITY'] ?></center></td>
          <td><center><?php echo $g['UOM'] ?></center></td>
          <td><center><?php echo $g['ITEM_TYPE'] ?></center></td>
          <td><center><?php echo !empty($g['NO_MOVE_ORDER'])?$g['NO_MOVE_ORDER']:'-' ?></center></td>
        </tr>
      <?php $no++; endforeach; ?>
    </tr>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $('#tblpbidetail').DataTable();
</script>
