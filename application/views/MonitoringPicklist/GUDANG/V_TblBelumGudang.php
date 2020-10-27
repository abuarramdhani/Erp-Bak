<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
            $(document).ready(function () {
            $('.tbpickl').dataTable({
                "scrollX": true,
            
            });
            $('.tbpickl2').dataTable({
                "scrollX": true,
                "scrollY": 500,
                "paging":false
            });
            var refreshId = setInterval(function()
            {
                $("#notiffabrks").load(notifgudang());
            }, 3000);
        });
    </script>
<div>
<?php $class = count($data) < 11 ? 'tbpickl' : 'tbpickl2';?>
<table class="datatable table table-bordered table-hover table-striped <?= $class?> text-center" id="tb_sdhppic" style="width: 100%;">
    <thead class="bg-primary">
        <tr>
            <td rowspan="2">No</td>
            <td rowspan="2" style="width:5%" class="text-center check_semua">
                <span class='btn check_semua' style="background-color:inherit" id='check_semua' onclick="ceksemua()"><i id="cekall" class="fa fa-square-o"></i></span>
                <input type="hidden" id="tandacekall" value="cek">
                <input type="hidden" class="baris" value="0">
            </td>
            <td rowspan="2">Department</td>
            <td rowspan="2">No Job</td>
            <td rowspan="2">Release Job</td>
            <td rowspan="2">Date Job</td>
            <td rowspan="2">Picklist</td>
            <td rowspan="2">Item Assy</td>
            <td rowspan="2">QTY</td>
            <td rowspan="2">From Subinv</td>
            <td rowspan="2">Locator</td>
            <td colspan="2">Permintaan Pelayanan</td>
            <td rowspan="2">Action</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>Shift</td>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; $x = 0; foreach ($data as $val) {
        $del = $val['DELIVER'] != '' ? 'disabled' : ''; 
        $cek = $val['DELIVER'] == '' ? 'onclick="inicek('.$no.')"' : '';
        $btn = $val['DELIVER'] == '' ? 'aktif' : '';  
        if ($val['DELIVER'] == '') { $x++; }  ?>
        <tr>
            <td><input type="hidden" id="baris" class="baris" value="<?= $x?>">
            <input type="hidden" id="deliver<?= $no?>" value="<?= $val['DELIVER']?>"><?= $no?></td>
            <td><span class="btn check_semua" style="background-color:inherit" id="cek<?= $no?>" <?= $cek?> <?= $del?>><i id="ceka<?= $no?>" class="fa fa-square-o bisacek ceka<?= $del?>"></i></span>
                <input type="hidden" class="tandasemua<?= $del?>" name="tandacek[]" id="tandacek<?= $no?>" value="cek"></td>
            <td><input type="hidden" id="dept<?= $no?>" value="<?= $val['DEPARTMENT']?>"><?= $val['DEPARTMENT']?></td>
            <td><input type="hidden" id="nojob<?= $no?>" class="nojob<?= $del?>" value="<?= $val['JOB_NO']?>"><?= $val['JOB_NO']?></td>
            <td><input type="hidden" id="release<?= $no?>" value="<?= $val['REALASE_FABRIKASI']?>"><?= $val['REALASE_FABRIKASI']?></td>
            <td class="text-nowrap"><input type="hidden" id="date<?= $no?>" value="<?= $val['DATE_JOB']?>"><?= $val['DATE_JOB']?></td>
            <td class="text-nowrap"><input type="hidden" id="picklist<?= $no?>" class="picklist<?= $del?>" value="<?= $val['PICKLIST']?>"><?= $val['PICKLIST']?></td>
            <td style="text-align:left"><input type="hidden" id="item<?= $no?>" value="<?= $val['PRODUK']?>"><?= $val['PRODUK']?> - <?= $val['PRODUK_DESC'] ?></td>
            <td><input type="hidden" id="qty<?= $no?>" value="<?= $val['START_QUANTITY']?>"><?= $val['START_QUANTITY']?></td>
            <td><input type="hidden" id="from<?= $no?>" value="<?= $val['FROM_SUBINV']?>"><?= $val['FROM_SUBINV']?></td>
            <td><input type="hidden" id="locator<?= $no?>" value="<?= $val['LOCATOR']?>"><?= $val['LOCATOR']?></td>
            <td><input type="hidden" id="tgl_pelayanan<?= $no?>" value="<?= $val['TGL_PELAYANAN']?>"><?= $val['TGL_PELAYANAN']?></td>
            <td class="text-nowrap"><input type="hidden" id="shift<?= $no?>" value="<?= $val['SHIFT']?>"><?= $val['SHIFT']?></td>
            <!-- <td><input type="button" class="btn btn-warning" id="cek<?= $no?>" value="cek" onclick="cekGudang(<?= $no?>)"></td> -->
            <td><button type="button" class="btn btn-success <?= $btn?>" onclick="modalapproveGD(<?= $no?>)">Detail</button></td>
        </tr>
    <?php $no++; }?>
    </tbody>
</table>
</div>
<br>
<div class="col-md-12 text-right">
    <input type="button" class="btn btn-warning" id="appsemua" disabled="disabled" style="width: 150px" onclick="approveGudang2(this)" value="Approve Selected (0)">
</div>


<div class="modal fade" id="mdlapprovegd" tabindex="-1" role="dialog" aria-labelledby="myModalDetail">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 style="text-align:center">Detail</h3>
            <!-- <div id="datahidden"></div> -->
			</div>
			<div class="modal-body">
            <div id="dataapprove"></div>
		    </div>
            <div class="modal-footer">
		</div>
		</div>
	</div>
</div>