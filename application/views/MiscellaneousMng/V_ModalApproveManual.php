<div class="modal-header text-center" style="background-color:#49D3F5;font-size:18px">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <label>UPLOAD DOKUMEN APPROVAL</label>
</div>
<div class="modal-body">
    <div class="panel-body">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <input type="file" class="form-control" id="app_manual" name="app_manual" accept=".png, .jpeg, .jpg">
            <input type="hidden" name="id" value="<?= $id?>">
            <input type="hidden" name="nodoc" value="<?= $nodoc?>">
            <input type="hidden" name="io" value="<?= $io?>">
            <input type="hidden" name="tgl_transact" value="<?= $tgl_transact?>">
            <input type="hidden" name="status" value="<?= $status?>">
            <input type="hidden" name="pic" value="<?= $pic?>">
            <input type="hidden" name="ket" value="<?= $ket?>">
        </div>
    </div>
    <div class="panel-body text-center">
        <button class="btn btn-success" formaction="<?= base_url("MiscellaneousCosting/Request/ApproveManual")?>">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left:20px">Cancel</button>
    </div>
</div>