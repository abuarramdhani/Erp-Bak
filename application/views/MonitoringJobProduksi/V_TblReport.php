<form method="post">
<?php foreach ($data as $key => $val) { 
    $tabel = count($val[0]) > 3 ? 'tb_monjob' : 'tb_monjob2'; 
    $tambahan = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    // echo "<pre>";print_r($data);exit();
?>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-1">
            <label>Kategori
            <input type="hidden" name="kategori[]" value="<?= $val['kategori']?>">  
            <input type="hidden" name="kategori2[]" value="<?= $val['kategori2']?>">  
            <input type="hidden" name="bulan[]" value="<?= $bulan?>">  
            <input type="hidden" name="tglawal[]" value="<?= $tglawal?>">  
            <input type="hidden" name="tglakhir[]" value="<?= $tglakhir?>">  
            </label>
        </div>
        <div class="col-md-10">
            <label>: <?= $val['kategori']?></label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-1">
            <label>Periode</label>
        </div>
        <div class="col-md-10">
            <label>: <?= $tglawal?>/<?= $bulan?> - <?= $tglakhir?>/<?= $bulan?></label>
        </div>
    </div>
</div>
<table class="table table-bordered table-hover table-striped text-center <?= $tabel?>" style="width: 100%; font-size:12px">
    <thead style="background-color:#60BCEB">
        <tr class="text-nowrap">
            <th rowspan="2" style="width:5%;vertical-align:middle;background-color:#60BCEB">No
            </th>
            <th rowspan="2" style="vertical-align:middle;background-color:#60BCEB"><?= $tambahan?>Item<?= $tambahan?></th>
            <th rowspan="2" style="background-color:#60BCEB"></th>
            <th colspan="<?= $tglakhir - $tglawal +1?>" >Tanggal</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#60BCEB">Jumlah</th>
        </tr>
        <tr>
            <?php for ($i=$tglawal; $i < ($tglakhir+1) ; $i++) { ?>
                <th><?= $i?></th>
            <?php }?>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($val[0] as $key2 => $value) {?>
        <tr>
            <td><?= $no?>
                <input type="hidden" name="nomor<?= $key?>[]" value="<?= $no?>">
                <input type="hidden" id="item<?= $no?>" name="item<?= $key?><?= $no?>" value="<?= $value['ITEM']?>">
                <input type="hidden" id="desc<?= $no?>" name="desc<?= $key?><?= $no?>" value="<?= $value['DESC']?>"> 
                <input type="hidden" id="inv<?= $no?>" name="inv<?= $key?><?= $no?>" value="<?= $value['INVENTORY_ITEM_ID']?>"> 
            </td>

            <td><?= $value['ITEM']?><br><?= $value['DESC']?></td>
            <td class="text-nowrap"><p>P</p>
                <p>A</p>
                <p>(A - P)</p>
                <p>PL</p>
                <p>(PL - P)</P>
                <p>C</P>
                <p>(C - P)</P>
            </td>
            <?php for ($i=0; $i < $hari ; $i++) { 
                if ($key2 == 0) {
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
            }
            $n = 0;
            for ($i=($tglawal-1); $i < ($tglakhir) ; $i++) { 
            ?>
                <td><p><?= $value['plan'.$i.''] != '' ? $value['plan'.$i.''] : "<br>" ?>
                        <input type="hidden" name="plan<?= $val['kategori2']?><?= $value['INVENTORY_ITEM_ID']?><?= $n?>" value="<?= $value['plan'.$i.'']?>">
                    </p>
                    <p>
                        <?= $value['akt'.$i.''] != '' ? $value['akt'.$i.''] : "<br>" ?>
                        <input type="hidden" name="akt<?= $val['kategori2']?><?= $value['INVENTORY_ITEM_ID']?><?= $n?>" value="<?= $value['akt'.$i.'']?>">
                    </p>
                    <p><?= $value['min'.$i.''] != '' ? $value['min'.$i.''] : "<br>" ?>
                        <input type="hidden" id="min<?= $no?><?= $n?>" name="min<?= $val['kategori2']?><?= $value['INVENTORY_ITEM_ID']?><?= $n?>" value="<?= $value['min'.$i.'']?>">
                    </p>
                
                    <p>
                        <?= $value['pl'.$i.''] != '' ? $value['pl'.$i.''] : "<br>" ?>
                        <input type="hidden" name="pl<?= $val['kategori2']?><?= $value['INVENTORY_ITEM_ID']?><?= $n?>" value="<?= $value['pl'.$i.'']?>">
                    </p>
                    <p><?= $value['plmin'.$i.''] != '' ? $value['plmin'.$i.''] : "<br>" ?>
                        <input type="hidden" name="plmin<?= $val['kategori2']?><?= $value['INVENTORY_ITEM_ID']?><?= $n?>" value="<?= $value['plmin'.$i.'']?>">
                    </p>
                
                    <p>
                        <?= $value['com'.$i.''] != '' ? $value['com'.$i.''] : "<br>" ?>
                        <input type="hidden" name="com<?= $val['kategori2']?><?= $value['INVENTORY_ITEM_ID']?><?= $n?>" value="<?= $value['com'.$i.'']?>">
                    </p>
                    <p><?= $value['cmin'.$i.''] != '' ? $value['cmin'.$i.''] : "<br>" ?>
                        <input type="hidden" name="cmin<?= $val['kategori2']?><?= $value['INVENTORY_ITEM_ID']?><?= $n?>" value="<?= $value['cmin'.$i.'']?>">
                    </p>
                </td>
            <?php $n++; }?>

            <td><p><input type="hidden" name="jml_plan<?= $key?><?= $no?>" value="<?= $value['jml_plan']?>"><?= $value['jml_plan']?></p>
                <p><input type="hidden" name="jml_akt<?= $key?><?= $no?>" value="<?= $value['jml_akt']?>"><?= $value['jml_akt']?></p>
                <p><input type="hidden" name="jml_min<?= $key?><?= $no?>" value="<?= $value['jml_min']?>"><?= $value['jml_min']?></p>
                <p><input type="hidden" name="jml_pl<?= $key?><?= $no?>" value="<?= $value['jml_pl']?>"><?= $value['jml_pl']?></p>
                <p><input type="hidden" name="jml_plmin<?= $key?><?= $no?>" value="<?= $value['jml_plmin']?>"><?= $value['jml_plmin']?></p>
                <p><input type="hidden" name="jml_com<?= $key?><?= $no?>" value="<?= $value['jml_com']?>"><?= $value['jml_com']?></p>
                <p><input type="hidden" name="jml_cmin<?= $key?><?= $no?>" value="<?= $value['jml_cmin']?>"><?= $value['jml_cmin']?></p>
            </td>
        </tr>
        <?php $no++; }?>
    </tbody>
    <tfoot>
    <?php if($no-1 > 0) {?>
        <tr>
            <td style="font-weight:bold">Total</td>
            <td><input type="hidden" name="jml_item<?= $key?>" value="<?= $no-1?>"><?= $no-1?></td>
            <td><p>P</p>
                <p>A</p>
                <p>(A - P)</p>
                <p>PL</P>
                <p>(PL - P)</P>
                <p>C</p>
                <p>(C - P)</p>
            </td>
            <?php $m = 0; for ($t=($tglawal-1); $t < ($tglakhir) ; $t++) { ?>
                <td><p><input type="hidden" name="total_plan<?= $key?><?= $m?>" value="<?= $ttl_plan[$t]?>"><?= $ttl_plan[$t]?></p>
                    <p><input type="hidden" name="total_akt<?= $key?><?= $m?>" value="<?= $ttl_akt[$t]?>"><?= $ttl_akt[$t]?></p>
                    <p><input type="hidden" name="total_min<?= $key?><?= $m?>" value="<?= $ttl_min[$t]?>"><?= $ttl_min[$t]?></p>
                    <p><input type="hidden" name="total_pl<?= $key?><?= $m?>" value="<?= $ttl_pl[$t] ?>"><?= $ttl_pl[$t] ?></p>
                    <p><input type="hidden" name="total_plmin<?= $key?><?= $m?>" value="<?= $ttl_plmin[$t] ?>"><?= $ttl_plmin[$t] ?></p>
                    <p><input type="hidden" name="total_com<?= $key?><?= $m?>" value="<?= $ttl_com[$t]?>"><?= $ttl_com[$t]?></p>
                    <p><input type="hidden" name="total_cmin<?= $key?><?= $m?>" value="<?= $ttl_cmin[$t] ?>"><?= $ttl_cmin[$t] ?></p>
                </td>
            <?php $m++; }?>
            <td><p><input type="hidden" name="ttl_jml_plan<?= $key?>" value="<?= $val[1]['ttl_jml_plan']?>"><?= $val[1]['ttl_jml_plan']?></p>
                <p><input type="hidden" name="ttl_jml_akt<?= $key?>" value="<?= $val[1]['ttl_jml_akt']?>"><?= $val[1]['ttl_jml_akt']?></p>
                <p><input type="hidden" name="ttl_jml_min<?= $key?>" value="<?= $val[1]['ttl_jml_min']?>"><?= $val[1]['ttl_jml_min']?></p>
                <p><input type="hidden" name="ttl_jml_pl<?= $key?>" value="<?= $val[1]['ttl_jml_pl']?>"><?= $val[1]['ttl_jml_pl']?></p>
                <p><input type="hidden" name="ttl_jml_plmin<?= $key?>" value="<?= $val[1]['ttl_jml_plmin']?>"><?= $val[1]['ttl_jml_plmin']?></p>
                <p><input type="hidden" name="ttl_jml_com<?= $key?>" value="<?= $val[1]['ttl_jml_com']?>"><?= $val[1]['ttl_jml_com']?></p>
                <p><input type="hidden" name="ttl_jml_cmin<?= $key?>" value="<?= $val[1]['ttl_jml_cmin']?>"><?= $val[1]['ttl_jml_cmin']?></p>
            </td>
        </tr>
        <?php }?>
    </tfoot>
</table>
<br><br>
<?php }?>
<div class="panel-body text-right">
    <button class="btn btn-lg bg-orange" formaction="<?= base_url("MonitoringJobProduksi/Monitoring/exportReport")?>"><i class="fa fa-download"></i> Download</button>
</div>
</form>