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
                <input type="hidden" class="nomorr" name="nomor[]" value="<?= $no?>">
                <input type="hidden" id="bulan" name="bulan" value="<?= $bulan?>">
                <input type="hidden" name="kategori" value="<?= $kategori?>">  
                <input type="hidden" id="bulan2" name="bulan2" value="<?= $bulan2?>">
                <input type="hidden" id="kategori2" name="kategori2" value="<?= $kategori2?>">  
                <input type="hidden" name="hari" value="<?= $hari?>">  
                <input type="hidden" class="nama_item" id="item<?= $no?>" name="item<?= $no?>" value="<?= $value['ITEM']?>">
                <input type="hidden" id="desc<?= $no?>" name="desc<?= $no?>" value="<?= $value['DESC']?>"> 
                <input type="hidden" id="inv<?= $no?>" name="inv<?= $no?>" value="<?= $value['INVENTORY_ITEM_ID']?>"> 
                <input type="hidden" name="wip<?= $no?>"> 
                <input type="hidden" name="picklist<?= $no?>"> 
                <input type="hidden" name="fg_tks<?= $no?>"> 
                <input type="hidden" name="mlati<?= $no?>"> 
            </td>

            <td style="text-align:left"><?= $value['ITEM']?><br><?= $value['DESC']?>
                <br><br><span class="loadingwip" name="ini_wip<?= $no?>"></span>
                <br><span class="loadingpick" name="ini_pick<?= $no?>"></span>
                <br><span class="loadinggd" name="ini_gd<?= $no?>"></span>
            </td>
            <td class="text-nowrap"><p>P</p>
                <?php if ($ket == 'All' || $ket == 'PA') { ?>
                    <p style="padding-top:5px">A</p>
                    <p>(A - P)</p>
                <?php }?>
                <?php if ($ket == 'All' || $ket == 'PLP') { ?>
                    <p style="padding-top:5px">PL</p>
                    <p>(PL - P)</P>
                <?php }?>
                <?php if ($ket == 'All' || $ket == 'PC') { ?>
                    <p style="padding-top:5px">C</P>
                    <p>(C - P)</P>
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
                    $ttl_cmin[$i] = $value['cmin'.$i.''] != '' ? $value['cmin'.$i.''] : 0;
                }else {
                    $ttl_plan[$i] += $value['plan'.$i.''] != '' ? $value['plan'.$i.''] : 0;
                    $ttl_akt[$i] += $value['akt'.$i.''] != '' ? $value['akt'.$i.''] : 0;
                    $ttl_min[$i] += $value['min'.$i.''] != '' ? $value['min'.$i.''] : 0;
                    $ttl_com[$i] += $value['com'.$i.''] != '' ? $value['com'.$i.''] : 0;
                    $ttl_pl[$i] += $value['pl'.$i.''] != '' ? $value['pl'.$i.''] : 0;
                    $ttl_plmin[$i] += $value['plmin'.$i.''] != '' ? $value['plmin'.$i.''] : 0;
                    $ttl_cmin[$i] += $value['cmin'.$i.''] != '' ? $value['cmin'.$i.''] : 0;
                }
            ?>
                <td><p><?php if($value['plan'.$i.''] != 0){ ?>
                            <button class="btn btn-xs" style="background-color:#68F5C1;font-size:12px" formtarget="_blank" formaction="<?= base_url('MonitoringJobProduksi/Monitoring/simulasi/'.$no.'/'.($i+1).'')?>"><?= $value['plan'.$i.'']?></button>
                        <?php }else { ?>
                            <button type="button" class="btn btn-xs" style="background-color:inherit;height:22px"></button>
                        <?php }?>
                        <input type="hidden" name="plan<?= $value['INVENTORY_ITEM_ID']?><?= $i+1?>" value="<?= $value['plan'.$i.'']?>">
                    </p>
                <?php if ($ket == 'All' || $ket == 'PA') { ?>
                    <p>
                        <?= $value['akt'.$i.''] != '' ? $value['akt'.$i.''] : "<br>" ?>
                        <input type="hidden" name="akt<?= $value['INVENTORY_ITEM_ID']?><?= $i+1?>" value="<?= $value['akt'.$i.'']?>">
                    </p>
                    <p><?php $valmin = $value['min'.$i.''] != '' ? '': 'width:20px' ?>
                            <button type="button" class="btn btn-xs" style="background-color:#F6D673;font-size:12px;height:22px;<?= $valmin?>" onclick="commentmin(<?= $no?>, <?= $i+1?>, 'MIN')"><?= $value['min'.$i.'']?></button>
                        <input type="hidden" id="min<?= $value['INVENTORY_ITEM_ID']?><?= $i+1?>" name="min<?= $value['INVENTORY_ITEM_ID']?><?= $i+1?>" value="<?= $value['min'.$i.'']?>">
                    </p>
                <?php }?>
                
                <?php if ($ket == 'All' || $ket == 'PLP') { ?>
                    <p>
                        <?= $value['pl'.$i.''] != '' ? $value['pl'.$i.''] : "<br>" ?>
                        <input type="hidden" name="pl<?= $value['INVENTORY_ITEM_ID']?><?= $i+1?>" value="<?= $value['pl'.$i.'']?>">
                    </p>
                    <p><?php $valplmin = $value['plmin'.$i.''] != '' ? '': 'width:20px' ?>
                        <!-- <?= $value['plmin'.$i.''] == '' ? "<br>" : $value['plmin'.$i.''] ?> -->
                        <button type="button" class="btn btn-xs" style="background-color:#FFB670;font-size:12px;height:22px;<?= $valplmin?>" onclick="commentmin(<?= $no?>, <?= $i+1?>, 'PLMIN')"><?= $value['plmin'.$i.'']?></button>
                        <input type="hidden" name="plmin<?= $value['INVENTORY_ITEM_ID']?><?= $i+1?>" value="<?= $value['plmin'.$i.'']?>">
                    </p>
                <?php }?>
                
                <?php if ($ket == 'All' || $ket == 'PC') { ?>
                    <p>
                        <?= $value['com'.$i.''] != '' ? $value['com'.$i.''] : "<br>" ?>
                        <input type="hidden" name="com<?= $value['INVENTORY_ITEM_ID']?><?= $i+1?>" value="<?= $value['com'.$i.'']?>">
                    </p>
                    <p><?php $valcmin = $value['cmin'.$i.''] != '' ? '': 'width:20px' ?>
                        <button type="button" class="btn btn-xs" style="background-color:#F5817F;font-size:12px;height:22px;<?= $valcmin?>" onclick="commentmin(<?= $no?>, <?= $i+1?>, 'CMIN')"><?= $value['cmin'.$i.'']?></button>
                        <input type="hidden" name="cmin<?= $value['INVENTORY_ITEM_ID']?><?= $i+1?>" value="<?= $value['cmin'.$i.'']?>">
                    </p>
                <?php }?>
                </td>
            <?php }?>

            <td><p><input type="hidden" name="jml_plan<?= $no?>" value="<?= $value['jml_plan']?>"><?= $value['jml_plan']?></p>
            <?php if ($ket == 'All' || $ket == 'PA') { ?>
                <p style="padding-top:5px"><input type="hidden" name="jml_akt<?= $no?>" value="<?= $value['jml_akt']?>"><?= $value['jml_akt']?></p>
                <p><input type="hidden" name="jml_min<?= $no?>" value="<?= $value['jml_min']?>"><?= $value['jml_min']?></p>
            <?php }?>
            <?php if ($ket == 'All' || $ket == 'PLP') { ?>
                <p style="padding-top:5px"><input type="hidden" name="jml_pl<?= $no?>" value="<?= $value['jml_pl']?>"><?= $value['jml_pl']?></p>
                <p><input type="hidden" name="jml_plmin<?= $no?>" value="<?= $value['jml_plmin']?>"><?= $value['jml_plmin']?></p>
            <?php }?>
            <?php if ($ket == 'All' || $ket == 'PC') { ?>
                <p><input type="hidden" name="jml_com<?= $no?>" value="<?= $value['jml_com']?>"><?= $value['jml_com']?></p>
                <p><input type="hidden" name="jml_cmin<?= $no?>" value="<?= $value['jml_cmin']?>"><?= $value['jml_cmin']?></p>
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
            <?php if ($ket == 'All' || $ket == 'PA') { ?>
                <p>A</p>
                <p>(A - P)</p>
            <?php }?>
            <?php if ($ket == 'All' || $ket == 'PLP') { ?>
                <p>PL</P>
                <p>(PL - P)</P>
            <?php }?>
            <?php if ($ket == 'All' || $ket == 'PC') { ?>
                <p>C</p>
                <p>(C - P)</p>
            <?php }?>
            </td>
            <?php for ($t=0; $t < $hari ; $t++) { ?>
                <td><p><input type="hidden" name="total_plan<?= $t?>" value="<?= $ttl_plan[$t]?>"><?= $ttl_plan[$t]?></p>
                <?php if ($ket == 'All' || $ket == 'PA') { ?>
                    <p><input type="hidden" name="total_akt<?= $t?>" value="<?= $ttl_akt[$t]?>"><?= $ttl_akt[$t]?></p>
                    <p><input type="hidden" name="total_min<?= $t?>" value="<?= $ttl_min[$t]?>"><?= $ttl_min[$t]?></p>
                <?php }?>
                <?php if ($ket == 'All' || $ket == 'PLP') { ?>
                    <p><input type="hidden" name="total_pl<?= $t?>" value="<?= $ttl_pl[$t] ?>"><?= $ttl_pl[$t] ?></p>
                    <p><input type="hidden" name="total_plmin<?= $t?>" value="<?= $ttl_plmin[$t] ?>"><?= $ttl_plmin[$t] ?></p>
                <?php }?>
                <?php if ($ket == 'All' || $ket == 'PC') { ?>
                    <p><input type="hidden" name="total_com<?= $t?>" value="<?= $ttl_com[$t]?>"><?= $ttl_com[$t]?></p>
                    <p><input type="hidden" name="total_cmin<?= $t?>" value="<?= $ttl_cmin[$t] ?>"><?= $ttl_cmin[$t] ?></p>
                <?php }?>
                </td>
            <?php }?>
            <td><p><input type="hidden" name="ttl_jml_plan" value="<?= $total['ttl_jml_plan']?>"><?= $total['ttl_jml_plan']?></p>
            <?php if ($ket == 'All' || $ket == 'PA') { ?>
                <p><input type="hidden" name="ttl_jml_akt" value="<?= $total['ttl_jml_akt']?>"><?= $total['ttl_jml_akt']?></p>
                <p><input type="hidden" name="ttl_jml_min" value="<?= $total['ttl_jml_min']?>"><?= $total['ttl_jml_min']?></p>
            <?php }?>
            <?php if ($ket == 'All' || $ket == 'PLP') { ?>
                <p><input type="hidden" name="ttl_jml_pl" value="<?= $total['ttl_jml_pl']?>"><?= $total['ttl_jml_pl']?></p>
                <p><input type="hidden" name="ttl_jml_plmin" value="<?= $total['ttl_jml_plmin']?>"><?= $total['ttl_jml_plmin']?></p>
            <?php }?>
            <?php if ($ket == 'All' || $ket == 'PC') { ?>
                <p><input type="hidden" name="ttl_jml_com" value="<?= $total['ttl_jml_com']?>"><?= $total['ttl_jml_com']?></p>
                <p><input type="hidden" name="ttl_jml_cmin" value="<?= $total['ttl_jml_cmin']?>"><?= $total['ttl_jml_cmin']?></p>
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