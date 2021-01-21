<div class="panel-body text-center">
    <h3>EDIT ORGANIZATION GROUP</h3>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3 text-right"><label>GROUP NAME :</label></div>
    </div>
    <div class="col-md-12">
        <div class="col-md-9">
            <input id="nama_group" name="nama" class="form-control" value="<?= $data[0]['GROUP_NAME']?>" readonly>
            <input type="hidden" id="id_group" name="id_group" value="<?= $id?>">
        </div>
        <div class="col-md-3"><span id="warning_group" style="color:red; font-size:12px"></span></div>
        <br><br>
    </div>
    <div class="col-md-12">
        <div class="col-md-3 text-right"><label style="padding-top:10px">ORG. ASSIGN :</label></div>
    </div>
    <?php 
        for ($i=0; $i < count($org); $i++) { ?>
			<div class="col-md-12 tmborg_assign<?=($i+1)?>">
                <div class="col-md-9">
                    <input id="org_assign<?=($i+1)?>" name="org_assign[]" class="form-control" value="<?=$org[$i] ?>" readonly>
                </div>
                <div class="col-md-1" style="text-align:left">
                    <button class = "btn btn-default tombolhapus<?=($i+1)?>" onclick="tombolapus(<?=($i+1)?>)" type="button"><i class = "fa fa-minus" ></i></button>
                </div>
                <br><br>
            </div>
    <?php }?>
    <div class="col-md-12" id="tambahorg_assign">
                <div class="col-md-9">
                <select id="org_assign<?= ($i+1)?>" name="org_assign[]" class="form-control seletc2 getorg_assign" style="width:100%" data-placeholder="Pilih org. assign"></select>
                </div>
                <div class="col-md-1" style="text-align:left">
                    <a href="javascript:void(0);" id="addorgassign" onclick="addorg_assign(9)" class="btn btn-default"><i class="fa fa-plus"></i></a>
                </div>
        <br><br>
    </div>
</div>
<div class="panel-body text-center">
    <button class="btn btn-success" formaction="<?php echo base_url('MasterItemPIEA/SettingData/updateorg')?>"><i class="fa fa-save"></i> Save</button>
</div>