<h5 style="font-weight:bold;font-size:16px;">Detail Item <?php echo $get[0]['DOC_NUMBER'] ?></h5>
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblpbidetail" style="font-size:12px;">
    <thead>
      <tr class="bg-primary">
        <th><center>NO</center></th>
        <th><center>ITEM CODE</center></th>
        <th><center>ITEM DESCRIPTION</center></th>
        <th><center>QUANTITY</center></th>
        <th><center>UOM</center></th>
        <th><center>ITEM TYPE</center></th>
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
        </tr>
      <?php $no++; endforeach; ?>
    </tr>
    </tbody>
  </table>
</div>
<?php if ($get[0]['FLAG_APPROVE_ASET'] == 'Y'){?>
  <center><h3 style="color:#04b349;margin-top:-10px;"><b style="font-size:15px;">Approved!</b></h3></center>
<?php }elseif ($get[0]['FLAG_APPROVE_ASET'] == 'R') { ?>
  <center><h3 style="color:#f22626;margin-top:-10px;"> <b style="font-size:15px">Rejected!</b></h3></center>
<?php }else { ?>
  <center class="cek_status_<?php echo $get[0]['DOC_NUMBER'] ?>">
    <button type="button" onclick="approve('Y', '<?php echo $get[0]['DOC_NUMBER'] ?>')" class="btn btn-sm btn-primary" style="font-weight:bold;" name="button">
      <b class="fa fa-check-circle"></b> Approve
    </button>
    <button type="button" onclick="approve('R', '<?php echo $get[0]['DOC_NUMBER'] ?>')" class="btn btn-sm btn-danger" style="font-weight:bold;" name="button">
      <b class="fa fa-times-circle"></b> Reject
    </button>
  </center>
<?php } ?>

<br>
<!-- <script type="text/javascript">
  $('#tblpbidetail').DataTable();
</script> -->
