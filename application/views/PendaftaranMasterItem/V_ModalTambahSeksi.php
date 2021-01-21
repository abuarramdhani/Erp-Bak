<div class="panel-body text-center">
    <h3>TAMBAH KODE SEKSI</h3>
</div>
<div class="panel-body">
    <div class="col-md-3 text-right"><label>SEKSI :</label></div>
    <div class="col-md-8">
        <select id="seksi" name="seksi" class="form-control settingseksi" placeholder="Masukkan seksi" autocomplete="off" style="width:100%">
            <option></option>
        </select>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-3 text-right"><label>KODE SEKSI :</label></div>
    <div class="col-md-8">
        <input id="kode_seksi" name="kode_seksi" class="form-control" placeholder="Masukkan kode seksi" style="text-transform:uppercase" autocomplete="off">
    </div>
</div>

<div class="panel-body text-center">
    <button class="btn btn-success" formaction="<?php echo base_url('MasterItemPIEA/SettingData/saveseksi')?>"><i class="fa fa-save"></i> Save</button>
</div>