<!-- Modal After -->
<div class="form-group" style="margin-bottom:10px">
  <div style="text-align:center">
    <?php
      $foto_after = explode(", ", $getGambarAfter[0]['foto_after']);
      foreach ($foto_after as $key => $value): ?>
      <img src="<?php echo base_url('assets/upload/MenjawabTemuanAudite/Handling/'.$value)?>" class="img-fluid img-thumbnail" alt="<?php echo $value?>" style="width:65%;border-radius:10px"> <br>
      <label style="margin-bottom:12px"><?php echo $value ?></label><br>
    <?php endforeach; ?>
  </div>
</div>
<div class="modal-footer" style="margin-bottom:-15px">
  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>
