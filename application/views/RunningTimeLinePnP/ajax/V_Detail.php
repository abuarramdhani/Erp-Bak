  <table class="table table-striped table-bordered table-hover text-left" style="font-size:12px;width:50%;float:right">
    <thead>
      <tr class="bg-success">
        <th><center>NO</center></th>
        <th><center>DESCRIPTION</center></th>
        <th><center>QTY</center></th>
        <th><center>UOM</center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $key => $g): ?>
        <tr row-id= "<?php echo $g['ROOT_ASSEMBLY'] ?>" >
          <td><center><?php echo $no ?></center></td>
          <td><center><?php echo $g['DESCRIPTION'] ?></center></td>
          <td><center><?php echo $g['QTY'] ?></center></td>
          <td><center><?php echo $g['UOM'] ?></center></td>
        </tr>
      <?php $no++; endforeach; ?>
    </tbody>
  </table>
  <br>
<script type="text/javascript">
let wipp1 = $('.tblrtlp1').DataTable();
</script>
