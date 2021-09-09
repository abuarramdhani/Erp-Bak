<!-- Modal Before-->
<div class="form-group" style="margin-bottom:10px">
  <div style="text-align:center">
  <?php
  $foto_before = explode(", ", $getGambarBefore[0]['foto_before']);
  foreach ($foto_before as $key => $value): ?>
    <img src="http://produksi.quick.com/api-audit/assets/img/photo_before/<?php echo $value?>" class="img-fluid img-thumbnail" style="width:65%;border-radius:10px" alt="<?php echo $value?>"> <br>
    <label style="margin-bottom:12px"><?php echo $value ?></label> <br>
  <?php endforeach; ?>
  </div>
</div>
<div class="modal-footer" style="margin-bottom:-15px">
  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>
