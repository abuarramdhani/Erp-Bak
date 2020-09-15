    <?php $tambahan = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $tabel = count($data) > 8 ? 'tb_setplan' : 'tb_setplan2'; ?>
    <table class="table table-bordered table-hover table-striped text-center" id="<?= $tabel?>" style="width: 100%;">
    <thead style="background-color:#1DAEF5;color:white">
        <tr>
            <th rowspan="2"  style="background-color:#1DAEF5;color:white">No</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#1DAEF5;color:white">Kode Item</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#1DAEF5;color:white"><?= $tambahan?>Nama Part<?= $tambahan?></th>
            <th rowspan="2" style="background-color:#1DAEF5;color:white"></th>
            <th colspan="<?= $hari?>" >Tanggal</th>
        </tr>
        <tr>
            <?php for ($i=0; $i < $hari ; $i++) { ?>
                <th><?= $i + 1?></th>
            <?php }?>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($data as $key => $value) {?>
        <tr>
            <td><?= $no?>
                <input type="hidden" id="bulan<?= $no?>" name="bulan" value="<?= $bulan?>">
                <input type="hidden" id="id_plan<?= $no?>" name="id_plan[]" value="<?= $value['PLAN_ID']?>">
            </td>
            <td><input type="hidden" id="item<?= $no?>" name="item[]" value="<?= $value['INVENTORY_ITEM_ID']?>"><?= $value['ITEM']?>
            </td>
            <td><?= $value['DESKRIPSI']?></td>
            <td>P</td>
            <?php for ($i=0; $i < $hari ; $i++) { ?>
                <td><input type="number" id="plan<?= $no?><?= $i+1?>" name="plan[]" class="form-control" style="width:70px" value="<?= $value[$i]?>" onchange="saveSetplan(<?= $no?>, <?= ($i+1)?>)"></td>
            <?php }?>
        </tr>
    <?php $no++;}?>
    </tbody>
</table>

<div class="panel-body text-center">
    <!-- <button class="btn btn-md bg-orange" style="font-size:18px" formaction="<?= base_url('MonitoringJobProduksi/SetPlan/savePlan')?>"><i class="fa fa-save"></i> Save</button> -->
    <button type="button" class="btn btn-md bg-orange" style="font-size:18px" onclick="window.location.reload();"><i class="fa fa-save"></i> Save</button>
</div>