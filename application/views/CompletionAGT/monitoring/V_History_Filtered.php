<style media="screen">
.btn-group{
margin-bottom: -40px !important;
}
</style>
  <table class="table table-bordered agt-history-filtered" style="width:100%">
    <thead>
      <tr class="bg-primary">
        <td> No</td>
        <td > Item ID</td>
        <td> Component Code</td>
        <td> Component Name</td>
        <td> No Job</td>
        <td> Serial</td>
        <td> Running Pos</td>
        <td> Time Post 1</td>
        <td> Time Post 2</td>
        <td> Time Post 3</td>
        <td> Time Post 4</td>
        <td> Creation Date</td>
        <td> Action</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get as $key => $value): ?>
        <tr>
          <td><?php echo $key+1 ?></td>
          <td ><?php echo $value['ITEM_ID'] ?></td>
          <td><?php echo $value['KODE_ITEM'] ?></td>
          <td><?php echo $value['DESCRIPTION'] ?></td>
          <td><b><?php echo $value['NO_JOB'] ?></b></td>
          <td><b><?php echo $value['SERIAL'] ?></b></td>
          <td><center><button type="button" class="btn btn-sm" name="button" style="font-weight:bold"><?php echo $value['STATUS_JOB'] ?></button><center> </td>
          <td><?php echo $value['TIMER_POS_1'] ?></td>
          <td><?php echo $value['TIMER_POS_2'] ?></td>
          <td><?php echo $value['TIMER_POS_3'] ?></td>
          <td><?php echo $value['TIMER_POS_4'] ?></td>
          <td><?php echo $value['DATE_TIME'] ?></td>
          <td>
            <center>
              <button type="button" class="btn btn-sm btn-danger" <?php echo $value['STATUS_JOB'] != 'POS_5' ? 'disabled' : '' ?> name="button" style="width:40px;" onclick="del_agt_andon_pos('<?php echo $value['ITEM_ID'] ?>', 3, '<?php echo $value['DATE_TIME'] ?>')"> <i class="fa fa-trash"></i> </button>
            </center>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script type="text/javascript">
  let h87 = [];
  for (var i = 0; i < 12; i++) {
    h87.push(i)
  }
  $('.agt-history-filtered').DataTable({
    columnDefs: [
      {orderable: false, targets: [12]},
    ],
    select: {
        style: 'multi',
        selector: 'tr'
    },
    dom: 'Bfrtip',
    buttons: [
      'pageLength',
      {
        extend: 'excelHtml5',
        title: 'History Andon ~ Exported At <?php echo date('d-m-y') ?>',
        exportOptions: {
          columns: ':visible',
          columns: h87,
        }
      }
     ],
  });
</script>
