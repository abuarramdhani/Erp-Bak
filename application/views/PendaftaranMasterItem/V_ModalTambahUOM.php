<div class="panel-body text-center">
    <h3>TAMBAH KODE UOM</h3>
</div>
<div class="panel-body">
    <div class="col-md-3 text-right"><label>UOM :</label></div>
    <div class="col-md-7">
        <input id="uom" name="uom" class="form-control" placeholder="Masukkan uom" autocomplete="off">
    </div>
</div>
<div class="panel-body">
    <div class="col-md-3 text-right"><label>KODE UOM :</label></div>
    <div class="col-md-7">
        <input id="kode_uom" name="kode_uom" class="form-control" placeholder="Masukkan kode uom" style="text-transform:uppercase" autocomplete="off" >
    </div>
</div>
<div class="panel-body text-center">
    <button class="btn btn-success" formaction="<?php echo base_url('MasterItemPIEA/SettingData/saveuom')?>"><i class="fa fa-save"></i> Save</button>
</div>