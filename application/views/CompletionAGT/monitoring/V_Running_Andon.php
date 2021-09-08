<br>
<!-- <div class="alert bg-primary alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">
      <i class="fa fa-close"></i>
    </span>
  </button>
  <strong>Sekilas Info! </strong> Klik pada running pos untuk mengedit pos</strong>
</div> -->
<table class="table table-bordered agt-running-andon" style="width:100%">
  <thead>
    <tr class="bg-primary">
      <td> No</td>
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
        <td><center><?php echo $key+1 ?></center></td>
        <td><?php echo $value['KODE_ITEM'] ?></td>
        <td><?php echo $value['DESCRIPTION'] ?></td>
        <td><b><?php echo $value['NO_JOB'] ?></b></td>
        <td><b><?php echo $value['SERIAL'] ?></b></td>
        <!-- onclick="agt_update_pos('<?php //echo $value['ITEM_ID'] ?>', '<?php //echo $value['STATUS_JOB'] ?>', '<?php //echo $value['NO_JOB'] ?>')" -->
        <td> <center><button type="button" class="btn btn-sm" name="button" style="font-weight:bold"><?php echo $value['STATUS_JOB'] ?></button><center> </td>
        <td><?php echo $value['TIMER_POS_1'] ?></td>
        <td><?php echo $value['TIMER_POS_2'] ?></td>
        <td><?php echo $value['TIMER_POS_3'] ?></td>
        <td><?php echo $value['TIMER_POS_4'] ?></td>
        <td><?php echo $value['DATE_TIME'] ?></td>
        <td>
          <center>
            <button type="button" class="btn btn-sm btn-danger" name="button" style="width:40px;" onclick="del_agt_andon_pos('<?php echo $value['ITEM_ID'] ?>', 1, '<?php echo $value['DATE_TIME'] ?>')"> <i class="fa fa-trash"></i> </button>
          </center>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script type="text/javascript">
  $('.agt-running-andon').DataTable();
</script>
