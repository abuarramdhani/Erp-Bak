<?php if (!empty($get)) { ?>
  <?php foreach ($get as $key => $g): ?>
    <tr class="rowbaru0_wipp" id="wipp0row1">
      <td>
        <center><input type="text" value="<?php echo $g['no_job'] ?>" class="form-control" name="job0[]" id="job0_wipp<?php echo $key+1 ?>" placeholder="ITEM CODE"></center>
      </td>
      <td>
        <center><input type="text" value="<?php echo $g['item'] ?>" class="form-control" name="item0[]" id="item0_wipp<?php echo $key+1 ?>" placeholder="ITEM"></center>
      </td>
      <td>
        <center><input type="number" value="<?php echo $g['qty'] ?>" class="form-control iminhere" oninput="changeQtyValue(<?php echo $key+1 ?>)" name="qty0[]" id="qty0_wipp<?php echo $key+1 ?>" placeholder="QTY"></center>
      </td>
      <td>
        <center><input type="number" value="<?php echo $g['target_pe'] ?>" class="form-control andhere" name="target0[]" id="target0_pe<?php echo $key+1 ?>" placeholder="00%"></center>
      </td>
      <td hidden>
        <center><input type="text" value="<?php echo $g['created_at'] ?>" class="form-control param"></center>
      </td>
      <td>
        <center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp0(<?php echo $key+1 ?>)" style="border-radius:10px;" name="button"><i class="fa fa-minus-square"></i></button></center>
      </td>
    </tr>
  <?php endforeach; ?>
<?php }else { ?>
  <tr class="rowbaru0_wipp" id="wipp0row1">
    <td>
      <center><input type="text" class="form-control" name="job0[]" id="job0_wipp1" placeholder="ITEM CODE"></center>
    </td>
    <td>
      <center><input type="text" class="form-control" name="item0[]" id="item0_wipp1" placeholder="ITEM"></center>
    </td>
    <td>
      <center><input type="number" class="form-control iminhere" oninput="changeQtyValue(1)" name="qty0[]" id="qty0_wipp1" placeholder="QTY"></center>
    </td>
    <td>
      <center><input type="number" class="form-control andhere" name="target0[]" id="target0_pe1" placeholder="00%"></center>
    </td>
    <td hidden></td>
    <td>
      <center><button type="button" class="btn btn-sm bg-navy" onclick="minus_wipp0(1)" style="border-radius:10px;" name="button"><i class="fa fa-minus-square"></i></button></center>
    </td>
  </tr>
<?php } ?>
