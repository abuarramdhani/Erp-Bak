<div class="panel-body text-center">
    <h3>TAMBAH ORGANIZATION GROUP</h3>
</div>
<div class="panel-body">
    <div class="col-md-3 text-right"><label>GROUP NAME :</label></div>
    <div class="col-md-6">
        <input id="nama_group" name="nama" class="form-control" style="text-transform:uppercase" placeholder="Masukkan Nama Group" autocomplete="off">
    </div>
    <div class="col-md-3"><span id="warning_group" style="color:red; font-size:12px"></span></div>
</div>
<div class="panel-body" id="tambahorg_assign">
    <div class="col-md-3 text-right"><label>ORG ASSIGN :</label></div>
    <div class="col-md-6">
        <select id="org_assign1" name="org_assign[]" class="form-control seletc2 getorg_assign" style="width:100%" data-placeholder="Pilih org. assign"></select>
    </div>
    <div class="col-md-1 text-left" id="tambahorg">
        <a href="javascript:void(0);" id="addorgassign" onclick="addorg_assign(6)" class="btn btn-default"><i class="fa fa-plus"></i></a>
    </div>
<br><br></div>
<div class="panel-body text-center">
    <button class="btn btn-success" formaction="<?php echo base_url('MasterItemPIEA/SettingData/saveorg')?>"><i class="fa fa-save"></i> Save</button>
</div>