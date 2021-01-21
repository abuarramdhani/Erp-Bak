<div class="panel-body text-center">
    <h3>Masukkan Alamat Email</h3>
    <input type="hidden" id="ket" name="ket" value="<?= $ket?>">
</div>
<div class="panel-body" id="tambah_email">
<div class="col-md-1"></div>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            <input id="email1" name="email[]" class="form-control" placeholder="Masukkan Email" autocomplete="off">
        </div>
    </div>
<div class="col-md-1" style="text-align:left">
    <a href="javascript:void(0);" id="addbarisemail" class="btn btn-default"><i class="fa fa-plus"></i></a>
</div>
</div>

<div class="panel-body text-center">
    <button class="btn btn-success" formaction="<?= base_url('MasterItemTimKode/SettingEmail/saveemail')?>"><i class="fa fa-save"></i> Save</button>
</div>