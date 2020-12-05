<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
            $(document).ready(function () {
            $('.tbpickl').dataTable({
                "scrollX": true,
            
            });
        });
    </script>
<div>
<table class="datatable table table-bordered table-hover table-striped tbpickl text-center" style="width: 100%;">
    <thead class="bg-primary">
        <tr>
            <td rowspan="2">No</td>
            <td rowspan="2">Department</td>
            <td rowspan="2">No Job</td>
            <td rowspan="2">Release Job</td>
            <td rowspan="2">Date Job</td>
            <td rowspan="2">Picklist</td>
            <td rowspan="2">Item Assy</td>
            <td rowspan="2">QTY</td>
            <td rowspan="2">From Subinv</td>
            <td colspan="2">Permintaan Pelayanan</td>
            <td rowspan="2">Action</td>
            <td rowspan="2">Print</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>Shift</td>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1;foreach ($data as $val) { 
        $del = $val['DELIVER'] != '' ? 'disabled' : ''; ?>
        <tr>
            <td><?= $no?></td>
            <td><input type="hidden" id="dept<?= $no?>" value="<?= $val['DEPARTMENT']?>"><?= $val['DEPARTMENT']?></td>
            <td><input type="hidden" id="nojob<?= $no?>" value="<?= $val['JOB_NO'] ?>"><?= $val['JOB_NO'] ?></td>
            <td><input type="hidden" id="release<?= $no?>" value="<?= $val['RELEASE_PPIC']?>"><?= $val['RELEASE_PPIC']?></td>
            <td class="text-nowrap"><input type="hidden" id="date<?= $no?>" value="<?= $val['DATE_JOB']?>"><?= $val['DATE_JOB']?></td>
            <td class="text-nowrap"><input type="hidden" id="picklist<?= $no?>" value="<?= $val['PICKLIST']?>"><?= $val['PICKLIST']?></td>
            <td><input type="hidden" id="item<?= $no?>" value="<?= $val['PRODUK']?>"><?= $val['PRODUK']?> - <?= $val['PRODUK_DESC']?></td>
            <td><input type="hidden" id="qty<?= $no?>" value="<?= $val['START_QUANTITY']?>"><?= $val['START_QUANTITY']?></td>
            <td><input type="hidden" id="from<?= $no?>" value="<?= $val['FROM_SUBINV']?>"><?= $val['FROM_SUBINV']?></td>
            <td><input type="hidden" id="tgl_minta<?= $no?>" value="<?= $val['TGL_PELAYANAN']?>"><?= $val['TGL_PELAYANAN']?></td>
            <td class="text-nowrap"><input type="hidden" id="shift_minta<?= $no?>" value="<?= $val['SHIFT']?>"><?= $val['SHIFT']?></td>
            <td><button type="button" class="btn btn-success" id="refab<?= $no?>" onclick="recallFabrikasi(<?= $no?>)" <?= $del?>>Recall</button></td>
            <td><a href="<?php echo base_url('MonitoringPicklistFabrikasi/BelumApprove/printBelumFabrikasi/'.$val['PICKLIST'].''); ?>" target="_blank" type="button" class="btn btn-danger">Print</a>
            <!-- <a href="<?php echo base_url('MonitoringPicklistFabrikasi/SudahApprove/printFabrikasi/'.$val['PICKLIST'].'/'.$val['DEPARTMENT'].'/'.$val['CREATION_DATE'].''); ?>" target="_blank" type="button" class="btn btn-danger">Print</a>-->
            </td> 
        </tr>
    <?php $no++; }?>
    </tbody>
</table>
</div>