<?php
$no = 1;
for ($i=0; $i < count($org); $i++) { 
?>
    <div class="tmborg_assign<?= $no?>">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <input id="org_assign<?= $no?>" name="org_assign[]" class="form-control" value="<?= $org[$i]?>" readonly>
        </div>
        <div class="col-md-1" style="text-align:left">
            <button class = "btn btn-default tombolhapus<?= ($i+1)?>" onclick="tombolapus(<?= ($i+1)?>)" type="button"><i class = "fa fa-minus" ></i></button>
        </div>
    <br><br></div>
<?php $no++; }?>
<div class="tambahorg_assign">
    <div class="col-md-3"></div>
    <div class="col-md-6">
    <select id="org_assign<?= ($i+1)?>" name="org_assign[]" class="form-control seletc2 getorg_assign" style="width:100%" data-placeholder="Pilih org. assign"></select>
    </div>
    <div class="col-md-1" style="text-align:left">
        <a href="javascript:void(0);" id="addorgassign" onclick="addorg_assign(6)" class="btn btn-default"><i class="fa fa-plus"></i></a>
    </div>
<br><br></div>