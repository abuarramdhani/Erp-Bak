<div class="panel-body">
    <button type="button" class="btn btn-info" id="btn_importPlan" data-toggle="modal" data-target="#mdlimportsetplan"><i class="fa fa-upload"></i> Upload</button>
    <button class="btn btn-success" style="margin-left:20px" id="btn_exportPlan" formaction="<?= base_url('MonitoringJobProduksi/SetPlan/exportPlan')?>"><i class="fa fa-download"></i> Download</button>
</div>
    <?php $tabel = count($data) > 8 ? 'tb_setplan' : 'tb_setplan2'; ?>
    <table class="table table-bordered table-hover table-striped text-center" id="<?= $tabel?>">
    <thead style="background-color:#1DAEF5;color:white" class="text-nowrap">
        <tr>
            <th rowspan="2"  style="vertical-align:middle;background-color:#1DAEF5;color:white">No</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#1DAEF5;color:white">Kode Item</th>
            <th rowspan="2" style="width:150px;vertical-align:middle;background-color:#1DAEF5;color:white">Nama Part</th>
            <th rowspan="2" style="background-color:#1DAEF5;color:white"></th>
            <th colspan="<?= $hari?>" >Tanggal</th>
            <th rowspan="2">Jumlah</th>
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
                <input type="hidden" id="bulan2<?= $no?>" name="bulan2" value="<?= $bulan2?>">
                <input type="hidden" id="kategori2<?= $no?>" name="kategori2" value="<?= $kategori2?>">
                <input type="hidden" id="subcategory<?= $no?>" name="subcategory[]" value="<?= $value['ID_SUBCATEGORY']?>">
                <input type="hidden" id="id_plan<?= $no?>" name="id_plan[]" value="<?= $value['PLAN_ID']?>">
                <input type="hidden" id="item<?= $no?>" name="item[]" value="<?= $value['INVENTORY_ITEM_ID']?>">
                <input type="hidden" id="kode_item<?= $no?>" name="kode_item[]" value="<?= $value['ITEM']?>">
                <input type="hidden" id="desc<?= $no?>" name="desc[]" value="<?= $value['DESKRIPSI']?>">
            </td>
            <td class="text-nowrap"><?= $value['ITEM']?>
            </td>
            <td><?= $value['DESKRIPSI']?></td>
            <td>P</td>
            <?php for ($i=0; $i < $hari ; $i++) { ?>
                <td><input type="number" id="plan<?= $value['INVENTORY_ITEM_ID']?>_<?= $i+1?>" name="plan[]" class="form-control plan<?= $no?>" style="width:70px" value="<?= $value[$i]?>"  onchange="sumSetplan(<?= $no?>, <?= ($i+1)?>, <?= $value['INVENTORY_ITEM_ID']?>)"></td>
                <input type="hidden" id="ket<?= $value['INVENTORY_ITEM_ID']?>_<?= ($i+1)?>" class="ket_jumlah" value="<?= !empty($value[$i]) ? 1 : 0?>">
            <?php }?>
            <td id="jml<?= $no?>"><?= $value['JUMLAH']?></td>
        </tr>
    <?php $no++;}?>
    </tbody>
</table>

<div class="panel-body">
    <div class="col-md-7 text-right">
        <button class="btn btn-md bg-orange" id="btn_savePlan" formaction="<?= base_url('MonitoringJobProduksi/SetPlan/savePlan')?>"><i class="fa fa-save"></i> Save</button>
        <!-- <button type="button" class="btn btn-md btn-success" id="btn_create_job" onclick="create_job_otomatis(this)"><i class="fa fa-check"></i> Create Job</button> -->
    </div>
    <div class="col-md-1">
        <!-- <span class="text-nowrap" id="ket_create_job" style="font-size:25px;font-weight:bold;"></span> -->
    </div>
    <div class="col-md-4 text-right">
        <!-- <button type="button" class="btn btn-md bg-primary" style="margin-right:-30px" onclick="window.location.reload();"><i class="fa fa-download"></i> Export</button> -->
    </div>
</div>