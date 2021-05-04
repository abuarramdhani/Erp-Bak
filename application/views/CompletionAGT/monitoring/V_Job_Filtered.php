<table class="table table-bordered agt-job-release" style="width:100%">
  <thead>
    <tr class="bg-primary">
      <td> No</td>
      <td> No Job</td>
      <td> Component Code</td>
      <td> Description</td>
      <td> Qty Job</td>
      <td> Remaining Qty</td>
      <td> Date Released</td>
      <td> Item ID</td>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($get as $key => $value): ?>
      <tr>
        <td><center><?php echo $key+1 ?><center></td>
        <td><b><?php echo $value['NO_JOB'] ?></b></td>
        <td><?php echo $value['KODE_ITEM'] ?></td>
        <td><?php echo $value['DESCRIPTION'] ?></td>
        <td><?php echo $value['QTY_JOB'] ?></td>
        <td><?php echo $value['REMAINING_QTY'] ?></td>
        <td><?php echo $value['DATE_RELEASED'] ?></td>
        <td><?php echo $value['PRIMARY_ITEM_ID'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script type="text/javascript">
$('.agt-job-release').DataTable();
</script>
