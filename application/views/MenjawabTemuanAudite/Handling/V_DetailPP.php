<!-- Modal Edit PP -->
<!-- <form class="form-horizontal" autocomplete="off" enctype="multipart/form-data" action="<?php //echo base_url('MenjawabTemuanAudite/Handling/updatePP') ?>" method="post"> -->
<table style="width:100%;margin-top:20px;margin-bottom:35px;font-size:14px">
  <tr>
    <td hidden><input type="text" name="id" value="<?php echo $getPP['id'] ?>"></td>
    <td style="width:23%"><b>Poin Penyimpangan</b></td>
    <td style="width:3%"><b>:</b></td>
    <td style="width:74%"><input type="text" name="editpp" class="form-control" required value="<?php echo $getPP['poin'] ?>"></td>
  </tr>
  <tr>
    <td style="width:23%;padding-top:15px"><b>Last Update</b></td>
    <td style="width:3%;padding-top:15px"><b>:</b></td>
    <td style="width:74%;padding-top:15px"><input type="text" class="form-control" value="<?php echo $getPP['last_update_date'].' By '.$getPP['last_update_by'] ?>" readonly></td>
  </tr>
</table>
<div class="modal-footer" style="margin-bottom:-15px">
  <button type="button" class="btn btn-success" onclick="updatePP()" style="margin-left:-15px"><i class="fa fa-save"></i> Save</button>
  <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Close</button>
</div>
<!-- </form> -->
