<table class="table table-striped table-bordered table-hover text-left " id="detailDO" style="font-size:12px;">
  <thead>
    <tr class="bg-primary">
      <th><center>NO</center></th>
      <th><center>ITEM KODE</center></th>
      <th><center>ITEM DESKRIPSI</center></th>
      <th><center>REQUEST QUANTITY</center></th>
      <th><center>QUANTITY ATR</center></th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; $atr = 1; $warn = 1; foreach ($get as $g):
      if ($g['QUANTITY'] > $g['AV_TO_RES']) {
        $styleSetting = 'style="background:rgba(210, 90, 90, 0.49)"';
        $warn = 0;
      }else {
        $styleSetting = '';
      }
      ?>
      <tr <?php echo $styleSetting ?>>
        <td><center><?php echo $no ?></center></td>
        <td><center><?php echo $g['SEGMENT1'] ?></center></td>
        <td><center><?php echo $g['DESCRIPTION'] ?></center></td>
        <td><center><?php echo $g['QUANTITY'] ?></center></td>
        <td><center><?php echo $g['AV_TO_RES'] ?></center></td>
      </tr>

    <?php $no++; endforeach; ?>
  </tbody>
</table>
<input type="hidden" name="cekdodo" id="checkDODO" value="<?php echo $warn; ?>">
<input type="hidden" name="" id="user_mdo">
<input type="hidden" name="" id="headerid_mdo">
<input type="hidden" name="" id="rm_mdo">
<input type="hidden" name="" id="row_id">
<input type="hidden" name="" id="order_number">
<input type="hidden" name="" id="plat_number">

<input type="hidden" name="" id="atr_tampung_gan" value="<?php $no = 1; $atr = 1; foreach ($get as $g){
  if ($g['AV_TO_RES'] == '0' || $g['AV_TO_RES'] < '0') {
    echo $g['INVENTORY_ITEM_ID'].',';
  }
}
?>
">

<center><button type="button" class="btn btn-success" name="button" style="font-weight:bold;" onclick="approveMD()">ASSIGN</button> </center>
<br>
<script type="text/javascript">
  $('#detailDO').DataTable();
</script>
