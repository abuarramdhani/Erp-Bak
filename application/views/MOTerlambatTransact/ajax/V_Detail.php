  <div class="box-body bg-primary" style="border-radius:7px;margin-bottom:15px; font-size:14px;">
    <div class="form-group">
      <div class="row">
        <div class="col-md-12">
          <label for="">Alasan Keterlambatan</label>
          <textarea id="alasan_<?php echo $line_id ?>" style="width:100%;color:black;text-transform:uppercase;border-radius:5.5px;" cols="70"><?php echo $alasan ?></textarea>
          <center><button type="button" onclick="update_mtt('<?php echo $line_id ?>')" class="btn btn-sm btn-default"><i class="fa fa-space-shuttle"></i>Update</button> </center>
        </div>
      </div>
    </div>
  </div>
