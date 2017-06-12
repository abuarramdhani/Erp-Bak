<!-- Modal -->
<?php $no=1; foreach ($header as $h) { ?>
<form method="post" action="<?php echo base_url(''); ?>SalesOrder/BranchApproval/NewClaims/Action/<?php echo $h['HEADER_ID'];?>">
<div class="modal fade" id="approve<?php echo $h['HEADER_ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">APPROVED CLAIMS <?php echo $h['HEADER_ID']; ?></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" name="actionType" value="approved"/>
          <input type="hidden" value="<?php echo $this->session->userid; ?>" name="userUpdate" />
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Claim Character</label>
              <div class="input-group">
                <input type="radio" name="Priority" value="Perlu jawaban klaim ekstern"> Perlu jawaban klaim ekstern <br>
                <input type="radio" name="Priority" value="Keluhan Pelanggan"> Keluhan Pelanggan (Tidak perlu jawaban klaim ekstern) <br>
                <input type="radio" name="Priority" value="Tidak perlu jawaban klaim ekstern"> Kesalahan Penggunaan (Tidak perlu jawaban klaim ekstern)
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>A Preliminary Investigation and Remediation</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="glyphicon glyphicon-remove"></i>
                </div>
                <textarea row="3" type="text" class="form-control" name="note" placeholder="A Preliminary Investigation and Remediation" data-toggle="tooltip" data-placement="top" title="Masukkan detail investigasi awal dan saran perbaikan" required></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
        <button type="submit" class="btn btn-primary">SUBMIT</button>
      </div>
    </div>
  </div>
</div>
</form>
<?php } ?>