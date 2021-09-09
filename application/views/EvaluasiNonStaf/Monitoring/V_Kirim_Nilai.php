
<div class="modal-header" style="font-size:25px;">
    <i class="fa fa-list-alt"></i> Kirim Memo Nilai Training
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <div class="box-body">
        <div class="panel-body">
            <div class="col-md-4 text-right">
                <label>Masukkan File :</label>
            </div>
            <div class="col-md-6">
                <input type="file" name="file_nilai" class="form-control">
                <input type="hidden" name="id" value="<?= $id?>">
                <input type="hidden" name="noind" value="<?= $noind?>">
            </div>
        </div>
        <div class="panel-body">
            <div class="col-md-4 text-right">
                <label>Pilih Atasan :</label>
            </div>
            <div class="col-md-6">
                <select name="atasan" class="form-control select2 slc_atasan_trainee" style="width:100%" data-placeholder="pilih atasan"></select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-info" style="margin-left:15px" formaction="<?php echo base_url("EvaluasiPekerjaNonStaf/Monitoring/submit_nilai_training")?>">Submit</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
</div>