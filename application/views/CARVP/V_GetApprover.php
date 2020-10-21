<form name="Orderform" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
    <div class="panel-body">
        <div class="col-md-4" style="text-align: right;"><label>No CAR</label></div>
        <div class="col-md-6"><input type="text" name="no_car" readonly class="form-control" value="<?= $no_car ?>"></div>
    </div>
    <div class="panel-body">
        <div class="col-md-4" style="text-align: right;"><label>Approver</label></div>
        <div class="col-md-6">
            <select style="width: 100%;" name="approver_car" id="approver_car" class="form-control select2" data-placeholder="Pilih Approver">
                <option value="B0580">B0580 - HERMAWAN SETIYANTO</option>
            </select>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-md-12" style="text-align: right;">
            <button class="btn btn-success" formaction="<?php echo base_url('CARVP/ListData/sendRequestAppr'); ?>">Req Approve</button>
        </div>
    </div>
</form>