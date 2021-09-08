<style media="screen">
.btn-group{
margin-bottom: -40px !important;
}
</style>
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
        <td><center><?php echo $value['DATE_RELEASED'] ?></center></td>
        <td><?php echo $value['PRIMARY_ITEM_ID'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script type="text/javascript">
let h87 = [];
for (var i = 0; i < 8; i++) {
  h87.push(i)
}
console.log(h87);
$('.agt-job-release').DataTable({
  select: {
      style: 'multi',
      selector: 'tr'
  },
  dom: 'Bfrtip',
  buttons: [
    'pageLength',
    {
      extend: 'excelHtml5',
      title: 'Job Realase '+ $('.tanggal_agt_job_andon').val(),
      exportOptions: {
        columns: ':visible',
        columns: h87,
      }
    }
   ],
});
</script>
