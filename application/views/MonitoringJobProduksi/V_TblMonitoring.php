<form method="post" target="_blank">
<table class="table table-bordered table-hover table-striped text-center" id="tb_monjob" style="width: 100%;">
    <thead style="background-color:#60BCEB">
        <tr class="text-nowrap">
            <th rowspan="2" style="width:7%;vertical-align:middle;background-color:#60BCEB">No</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#60BCEB">Kode Item</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#60BCEB">Nama Part</th>
            <th rowspan="2" style="background-color:#60BCEB"></th>
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
                <input type="hidden" name="bulan<?= $no?>" value="<?= $bulan?>">
                <input type="hidden" name="kategori<?= $no?>" value="<?= $kategori?>">    
            </td>
            <td><input type="hidden" name="item<?= $no?>" value="<?= $value['ITEM']?>"><?= $value['ITEM']?></td>
            <td><input type="hidden" name="desc<?= $no?>" value="<?= $value['DESC']?>"><?= $value['DESC']?></td>
            <td><p>P</p>
                <p>A</p>
                <p>(-)</p>
            </td>
            <?php for ($i=0; $i < $hari ; $i++) { ?>
                <td><p><?php if($value['plan'.$i.''] != 0){ ?>
                            <button class="btn btn-xs" style="background-color:#68F5C1" formaction="<?= base_url('MonitoringJobProduksi/Monitoring/simulasi/'.$no.'/'.($i+1).'')?>"><?= $value['plan'.$i.'']?></button>
                        <?php }else { ?>
                            <br>
                        <?php }?>
                        <input type="hidden" name="plan<?= $no?><?= $i+1?>" value="<?= $value['plan'.$i.'']?>">
                    </p>
                    <p><?= $value['akt'.$i.''] != '' ? $value['akt'.$i.''] : "<br>" ?></p>
                    <p style="<?= $value['min'.$i.''] == 'invalid' ? 'color:red' : ''; ?>">
                        <?= $value['min'.$i.''] != '' ? ($value['min'.$i.''] < 0 ? 0 : $value['min'.$i.'']) : "<br>" ?>
                    </p>
                </td>
            <?php }?>
        </tr>
        <?php $no++; }?>
    </tbody>
</table>
</form>