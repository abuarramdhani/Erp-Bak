<?php $tabel = count($data) > 3 ? 'tb_monjob' : 'tb_monjob2'; 
$tambahan = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
?>
<form method="post">
<table class="table table-bordered table-hover table-striped text-center" id="<?= $tabel?>" style="width: 100%; font-size:12px">
    <thead style="background-color:#60BCEB">
        <tr class="text-nowrap">
            <th rowspan="2" style="width:5%;vertical-align:middle;background-color:#60BCEB">No
                <input type="hidden" name="ket" value="<?= $ket?>">
            </th>
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
                <input type="hidden" name="nomor[]" value="<?= $no?>">
                <input type="hidden" id="bulan" name="bulan" value="<?= $bulan?>">
                <input type="hidden" name="kategori" value="<?= $kategori?>">  
                <input type="hidden" id="bulan2" name="bulan2" value="<?= $bulan2?>">
                <input type="hidden" id="kategori2" name="kategori2" value="<?= $kategori2?>">  
                <input type="hidden" name="hari" value="<?= $hari?>">  
                <input type="hidden" id="item<?= $no?>" name="item<?= $no?>" value="<?= $value['ITEM']?>">
                <input type="hidden" id="desc<?= $no?>" name="desc<?= $no?>" value="<?= $value['DESC']?>"> 
                <input type="hidden" id="inv<?= $no?>" name="inv<?= $no?>" value="<?= $value['INVENTORY_ITEM_ID']?>"> 
            </td>

            <td><?= $value['ITEM']?><br><?= $value['DESC']?></td>
            <td class="text-nowrap"><p>P</p>
                <?php if ($ket != 'PLP') { ?>
                    <p style="padding-top:5px">A</p>
                    <p>(A - P)</p>
                <?php }?>
                <?php if ($ket != 'PA') { ?>
                    <p style="padding-top:5px">PL</p>
                    <p>(PL - P)</P>
                <?php }?>
                <?php if ($ket == 'All') { ?>
                    <p>C</P>
                <?php }?>
            </td>
            <?php for ($i=0; $i < $hari ; $i++) { 
                if ($key == 0) {
                    $ttl_plan[$i] = $value['plan'.$i.''] != '' ? $value['plan'.$i.''] : 0;
                    $ttl_akt[$i] = $value['akt'.$i.''] != '' ? $value['akt'.$i.''] : 0;
                    $ttl_min[$i] = $value['min'.$i.''] != '' ? $value['min'.$i.''] : 0;
                    $ttl_com[$i] = $value['com'.$i.''] != '' ? $value['com'.$i.''] : 0;
                    $ttl_pl[$i] = $value['pl'.$i.''] != '' ? $value['pl'.$i.''] : 0;
                    $ttl_plmin[$i] = $value['plmin'.$i.''] != '' ? $value['plmin'.$i.''] : 0;
                }else {
                    $ttl_plan[$i] += $value['plan'.$i.''] != '' ? $value['plan'.$i.''] : 0;
                    $ttl_akt[$i] += $value['akt'.$i.''] != '' ? $value['akt'.$i.''] : 0;
                    $ttl_min[$i] += $value['min'.$i.''] != '' ? $value['min'.$i.''] : 0;
                    $ttl_com[$i] += $value['com'.$i.''] != '' ? $value['com'.$i.''] : 0;
                    $ttl_pl[$i] += $value['pl'.$i.''] != '' ? $value['pl'.$i.''] : 0;
                    $ttl_plmin[$i] += $value['plmin'.$i.''] != '' ? $value['plmin'.$i.''] : 0;
                }
            ?>
                <td><p><?php if($value['plan'.$i.''] != 0){ ?>
                            <button class="btn btn-xs" style="background-color:#68F5C1;font-size:12px" formtarget="_blank" formaction="<?= base_url('MonitoringJobProduksi/Monitoring/simulasi/'.$no.'/'.($i+1).'')?>"><?= $value['plan'.$i.'']?></button>
                        <?php }else { ?>
                            <button type="button" class="btn btn-xs" style="background-color:inherit;height:22px"></button>
                        <?php }?>
                        <input type="hidden" name="plan<?= $no?><?= $i+1?>" value="<?= $value['plan'.$i.'']?>">
                    </p>
                <?php if ($ket != 'PLP') { ?>
                    <p>
                        <?= $value['akt'.$i.''] != '' ? $value['akt'.$i.''] : "<br>" ?>
                        <input type="hidden" name="akt<?= $no?><?= $i+1?>" value="<?= $value['akt'.$i.'']?>">
                    </p>
                    <p><?php $valmin = $value['min'.$i.''] != '' ? '': 'width:20px' ?>
                            <button type="button" class="btn btn-xs" style="background-color:#FFB670;font-size:12px;height:22px;<?= $valmin?>" onclick="commentmin(<?= $no?>, <?= $i+1?>, 'MIN')"><?= $value['min'.$i.'']?></button>
                        <input type="hidden" id="min<?= $no?><?= $i+1?>" name="min<?= $no?><?= $i+1?>" value="<?= $value['min'.$i.'']?>">
                    </p>
                <?php }?>
                
                <?php if ($ket != 'PA') { ?>
                    <p>
                        <?= $value['pl'.$i.''] != '' ? $value['pl'.$i.''] : "<br>" ?>
                        <input type="hidden" name="pl<?= $no?><?= $i+1?>" value="<?= $value['pl'.$i.'']?>">
                    </p>
                    <p><?php $valplmin = $value['plmin'.$i.''] != '' ? '': 'width:20px' ?>
                        <!-- <?= $value['plmin'.$i.''] == '' ? "<br>" : $value['plmin'.$i.''] ?> -->
                        <button type="button" class="btn btn-xs" style="background-color:#F6D673;font-size:12px;height:22px;<?= $valplmin?>" onclick="commentmin(<?= $no?>, <?= $i+1?>, 'PLMIN')"><?= $value['plmin'.$i.'']?></button>
                        <input type="hidden" name="plmin<?= $no?><?= $i+1?>" value="<?= $value['plmin'.$i.'']?>">
                    </p>
                <?php }?>
                
                <?php if ($ket == 'All') { ?>
                    <p>
                        <?= $value['com'.$i.''] != '' ? $value['com'.$i.''] : "<br>" ?>
                        <input type="hidden" name="com<?= $no?><?= $i+1?>" value="<?= $value['com'.$i.'']?>">
                    </p>
                <?php }?>
                </td>
            <?php }?>

            <td><p><input type="hidden" name="jml_plan<?= $no?>" value="<?= $value['jml_plan']?>"><?= $value['jml_plan']?></p>
            <?php if ($ket != 'PLP') { ?>
                <p style="padding-top:5px"><input type="hidden" name="jml_akt<?= $no?>" value="<?= $value['jml_akt']?>"><?= $value['jml_akt']?></p>
                <p><input type="hidden" name="jml_min<?= $no?>" value="<?= $value['jml_min']?>"><?= $value['jml_min']?></p>
            <?php }?>
            <?php if ($ket != 'PA') { ?>
                <p style="padding-top:5px"><input type="hidden" name="jml_pl<?= $no?>" value="<?= $value['jml_pl']?>"><?= $value['jml_pl']?></p>
                <p><input type="hidden" name="jml_plmin<?= $no?>" value="<?= $value['jml_plmin']?>"><?= $value['jml_plmin']?></p>
            <?php }?>
            <?php if ($ket == 'All') { ?>
                <p><input type="hidden" name="jml_com<?= $no?>" value="<?= $value['jml_com']?>"><?= $value['jml_com']?></p>
            <?php }?>
            </td>
        </tr>
        <?php $no++; }?>
    </tbody>
    <tfoot>
    <?php if($no-1 > 0) {?>
        <tr>
            <td style="font-weight:bold">Total</td>
            <td><input type="hidden" name="jml_item" value="<?= $no-1?>"><?= $no-1?></td>
            <td><p>P</p>
            <?php if ($ket != 'PLP') { ?>
                <p>A</p>
                <p>(A - P)</p>
            <?php }?>
            <?php if ($ket != 'PA') { ?>
                <p>PL</P>
                <p>(PL - P)</P>
            <?php }?>
            <?php if ($ket == 'All') { ?>
                <p>C</p>
            <?php }?>
            </td>
            <?php for ($t=0; $t < $hari ; $t++) { ?>
                <td><p><input type="hidden" name="total_plan<?= $t?>" value="<?= $ttl_plan[$t]?>"><?= $ttl_plan[$t]?></p>
                <?php if ($ket != 'PLP') { ?>
                    <p><input type="hidden" name="total_akt<?= $t?>" value="<?= $ttl_akt[$t]?>"><?= $ttl_akt[$t]?></p>
                    <p><input type="hidden" name="total_min<?= $t?>" value="<?= $ttl_min[$t]?>"><?= $ttl_min[$t]?></p>
                <?php }?>
                <?php if ($ket != 'PA') { ?>
                    <p><input type="hidden" name="total_pl<?= $t?>" value="<?= $ttl_pl[$t] ?>"><?= $ttl_pl[$t] ?></p>
                    <p><input type="hidden" name="total_plmin<?= $t?>" value="<?= $ttl_plmin[$t] ?>"><?= $ttl_plmin[$t] ?></p>
                <?php }?>
                <?php if ($ket == 'All') { ?>
                    <p><input type="hidden" name="total_com<?= $t?>" value="<?= $ttl_com[$t]?>"><?= $ttl_com[$t]?></p>
                <?php }?>
                </td>
            <?php }?>
            <td><p><input type="hidden" name="ttl_jml_plan" value="<?= $total['ttl_jml_plan']?>"><?= $total['ttl_jml_plan']?></p>
            <?php if ($ket != 'PLP') { ?>
                <p><input type="hidden" name="ttl_jml_akt" value="<?= $total['ttl_jml_akt']?>"><?= $total['ttl_jml_akt']?></p>
                <p><input type="hidden" name="ttl_jml_min" value="<?= $total['ttl_jml_min']?>"><?= $total['ttl_jml_min']?></p>
            <?php }?>
            <?php if ($ket != 'PA') { ?>
                <p><input type="hidden" name="ttl_jml_pl" value="<?= $total['ttl_jml_pl']?>"><?= $total['ttl_jml_pl']?></p>
                <p><input type="hidden" name="ttl_jml_plmin" value="<?= $total['ttl_jml_plmin']?>"><?= $total['ttl_jml_plmin']?></p>
            <?php }?>
            <?php if ($ket == 'All') { ?>
                <p><input type="hidden" name="ttl_jml_com" value="<?= $total['ttl_jml_com']?>"><?= $total['ttl_jml_com']?></p>
            <?php }?>
            </td>
        </tr>
        <?php }?>
    </tfoot>
</table>
<div class="panel-body text-right">
    <?php $export = $ket == 'All' ? 'exportJob' : 'exportJobPLA'?>
    <button class="btn btn-lg bg-orange" formaction="<?= base_url("MonitoringJobProduksi/Monitoring/".$export."")?>"><i class="fa fa-download"></i> Download</button>
</div>
</form>