<hr>
<div class="agt_alert_area">

</div>
<p class="label label-warning" style="font-size:13px;" title="primary_item_id"> <?php echo $item_id ?> </p>
<p class="label label-success" style="font-size:13px;margin-left:5px;"> <i class="fa fa-tag"></i> Menampilkan dari job yang tertua</p>
<br>
<br>
<table class="table table-bordered" style="width:100%">
  <tr class="bg-primary">
    <td> No</td>
    <td> No Job</td>
    <td> Kode Item</td>
    <td> Description</td>
    <td> Qty Job</td>
    <td> Remaining Qty</td>
    <td> Remaining WIP</td>
    <td> Creation Date</td>
    <td hidden style="text-align:center"> Action</td>
  </tr>
  <?php $value = $old_job; //foreach ($old_job as $key => $value): ?>
    <tr>
      <td><center><?php echo 1//$key+1 ?><center></td>
      <td><b><?php echo $value['NO_JOB'] ?></b></td>
      <td><?php echo $value['KODE_ITEM'] ?></td>
      <td><?php echo $value['DESCRIPTION'] ?></td>
      <td><?php echo $value['QTY_JOB'] ?></td>
      <td><?php echo $value['REMAINING_QTY'] ?></td>
      <td><?php echo $value['REMAINING_WIP'] ?></td>
      <td><?php echo $value['CREATION_DATE'] ?></td>
      <td hidden>
        <center>
            <button type="button" class="btn btn-success submitagtjob" name="button" onclick="update_pos_1('<?php echo $value['NO_JOB'] ?>', '<?php echo $value['KODE_ITEM'] ?>', '<?php echo $value['DESCRIPTION'] ?>', '<?php echo $value['ITEM_ID'] ?>')">
             <b><i class="fa fa-send"></i> Send</b>
           </button>
         <center>
       </td>
    </tr>
  <?php //endforeach; ?>
</table>
