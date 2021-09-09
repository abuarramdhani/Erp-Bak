<!-- Modal Edit SH -->
<table style="width:100%;margin-top:20px;margin-bottom:35px;font-size:14px">
  <tr>
    <td hidden><input type="text" name="id" value="<?php echo $getSH['id'] ?>"></td>
    <td style="width:23%"><b>Sarana Handling</b></td>
    <td style="width:3%"><b>:</b></td>
    <td style="width:74%"><input type="text" name="editsh" class="form-control" required value="<?php echo $getSH['sarana'] ?>"></td>
  </tr>
  <tr>
    <td style="width:23%;padding-top:15px"><b>Last Update</b></td>
    <td style="width:3%;padding-top:15px"><b>:</b></td>
    <td style="width:74%;padding-top:15px"><input type="text" class="form-control" value="<?php echo $getSH['last_update_date'].' By '.$getSH['last_update_by'] ?>" readonly></td>
  </tr>
</table>
<div class="modal-footer" style="margin-bottom:-15px">
  <button type="button" class="btn btn-success" onclick="updateSH()" style="margin-left:-15px"><i class="fa fa-save"></i> Save</button>
  <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Close</button>
</div>
