<?php $tabel = count($data) > 4 ? 'tb_monjob' : 'tb_monjob2'; 
$tambahan = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
?>
<form method="post" target="_blank">
<table class="table table-bordered table-hover table-striped text-center" id="<?= $tabel?>" style="width: 100%; font-size:12px">
    <thead style="background-color:#60BCEB">
        <tr class="text-nowrap">
            <th rowspan="2" style="width:5%;vertical-align:middle;background-color:#60BCEB">No</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#60BCEB"><?= $tambahan?>Item<?= $tambahan?></th>
            <th rowspan="2" style="background-color:#60BCEB"></th>
            <th colspan="<?= $hari?>" >Tanggal</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#60BCEB">Jumlah</th>
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
                <input type="hidden" name="item<?= $no?>" value="<?= $value['ITEM']?>">
                <input type="hidden" name="desc<?= $no?>" value="<?= $value['DESC']?>"> 
            </td>
            <td><?= $value['ITEM']?><br><?= $value['DESC']?></td>
            <td><p>P</p>
                <p>A</p>
                <p>(-)</p>
            </td>
            <?php for ($i=0; $i < $hari ; $i++) { ?>
                <td><p><?php if($value['plan'.$i.''] != 0){ ?>
                            <button class="btn btn-xs" style="background-color:#68F5C1;font-size:12px" formaction="<?= base_url('MonitoringJobProduksi/Monitoring/simulasi/'.$no.'/'.($i+1).'')?>"><?= $value['plan'.$i.'']?></button>
                        <?php }else { ?>
                            <button type="button" class="btn btn-xs" style="background-color:inherit;height:22px"></button>
                        <?php }?>
                        <input type="hidden" name="plan<?= $no?><?= $i+1?>" value="<?= $value['plan'.$i.'']?>">
                    </p>
                    <p><?= $value['akt'.$i.''] != '' ? $value['akt'.$i.''] : "<br>" ?></p>
                    <p style="<?= $value['min'.$i.''] == 'invalid' ? 'color:red' : ''; ?>">
                        <?= $value['min'.$i.''] != '' ? $value['min'.$i.''] : "<br>" ?>
                    </p>
                </td>
            <?php }?>
            <td><p><?= $value['jml_plan']?></p><p><?= $value['jml_akt']?></p><p><?= $value['jml_min']?></p></td>
        </tr>
        <?php $no++; }?>
    </tbody>
</table>
</form>