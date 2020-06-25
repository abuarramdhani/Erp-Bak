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
<table class="datatable table table-bordered table-hover table-striped tbpickl text-center" id="tb_sdhppic" style="width: 100%;">
    <thead class="bg-primary">
        <tr>
            <td>No</td>
            <td>Department</td>
            <td>No Job</td>
            <td>Release Job</td>
            <td>Date Job</td>
            <td>Picklist</td>
            <td>Item Assy</td>
            <td>QTY</td>
            <td>From Subinv</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($data as $val) {
        $del = $val['DELIVER'] != '' ? 'disabled' : ''; ?>
        <tr>
            <td><?= $no?></td>
            <td><input type="hidden" id="dept<?= $no?>" value="<?= $val['DEPARTMENT']?>"><?= $val['DEPARTMENT']?></td>
            <td><input type="hidden" id="nojob<?= $no?>" value="<?= $val['JOB_NO']?>"><?= $val['JOB_NO']?></td>
            <td><input type="hidden" id="release<?= $no?>" value="<?= $val['REALASE_GUDANG']?>"><?= $val['REALASE_GUDANG']?></td>
            <td><input type="hidden" id="date<?= $no?>" value="<?= $val['DATE_JOB']?>"><?= $val['DATE_JOB']?></td>
            <td><input type="hidden" id="picklist<?= $no?>" value="<?= $val['PICKLIST']?>"><?= $val['PICKLIST']?></td>
            <td><input type="hidden" id="item<?= $no?>" value="<?= $val['PRODUK']?>"><?= $val['PRODUK']?> - <?= $val['PRODUK_DESC'] ?></td>
            <td><input type="hidden" id="qty<?= $no?>" value="<?= $val['START_QUANTITY']?>"><?= $val['START_QUANTITY']?></td>
            <td><input type="hidden" id="from<?= $no?>" value="<?= $val['FROM_SUBINV']?>"><?= $val['FROM_SUBINV']?></td>
            <td><button type="button" class="btn btn-success" id="regud<?= $no?>" onclick="recallGudang(<?= $no?>)" <?= $del?>>Recall</button></td>
        </tr>
    <?php $no++; }?>
    </tbody>
</table>
</div>