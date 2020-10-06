<?php $tabel = count($data) > 4 ? 'tb_monjob' : 'tb_monjob2'; 
$tambahan = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
?>
<form method="post">
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
            <td><p>P</p>
                <p style="padding-top:5px">A</p>
                <p>(-)</p>
                <p style="padding-top:5px">C</p>
                <!-- <p>PL</P> -->
            </td>
            <?php for ($i=0; $i < $hari ; $i++) { ?>
                <td><p><?php if($value['plan'.$i.''] != 0){ ?>
                            <button class="btn btn-xs" style="background-color:#68F5C1;font-size:12px" formtarget="_blank" formaction="<?= base_url('MonitoringJobProduksi/Monitoring/simulasi/'.$no.'/'.($i+1).'')?>"><?= $value['plan'.$i.'']?></button>
                        <?php }else { ?>
                            <button type="button" class="btn btn-xs" style="background-color:inherit;height:22px"></button>
                        <?php }?>
                        <input type="hidden" name="plan<?= $no?><?= $i+1?>" value="<?= $value['plan'.$i.'']?>">
                    </p>
                    <p>
                        <?= $value['akt'.$i.''] != '' ? $value['akt'.$i.''] : "<br>" ?>
                        <input type="hidden" name="akt<?= $no?><?= $i+1?>" value="<?= $value['akt'.$i.'']?>">
                    </p>
                    <p><?php $valmin = $value['min'.$i.''] != '' ? '': 'width:20px' ?>
                            <button type="button" class="btn btn-xs" style="background-color:#FFB670;font-size:12px;height:22px;<?= $valmin?>" onclick="commentmin(<?= $no?>, <?= $i+1?>)"><?= $value['min'.$i.'']?></button>
                        <input type="hidden" id="min<?= $no?><?= $i+1?>" name="min<?= $no?><?= $i+1?>" value="<?= $value['min'.$i.'']?>">
                    </p>
                    <p>
                        <?= $value['com'.$i.''] != '' ? $value['com'.$i.''] : "<br>" ?>
                        <input type="hidden" name="com<?= $no?><?= $i+1?>" value="<?= $value['com'.$i.'']?>">
                    </p>
                    <!-- <p></p> -->
                </td>
            <?php }?>
            <td><p><input type="hidden" name="jml_plan<?= $no?>" value="<?= $value['jml_plan']?>"><?= $value['jml_plan']?></p>
                <p style="padding-top:5px"><input type="hidden" name="jml_akt<?= $no?>" value="<?= $value['jml_akt']?>"><?= $value['jml_akt']?></p>
                <p><input type="hidden" name="jml_min<?= $no?>" value="<?= $value['jml_min']?>"><?= $value['jml_min']?></p>
                <p style="padding-top:5px"><input type="hidden" name="jml_com<?= $no?>" value="<?= $value['jml_com']?>"><?= $value['jml_com']?></p>
                <!-- <p><input type="hidden" name="jml_pl<?= $no?>" value=""></p> -->
            </td>
        </tr>
        <?php $no++; }?>
    </tbody>
    <tfoot>
    <?php if($total['item'] != 0) {?>
        <tr>
            <td style="font-weight:bold">Total</td>
            <td><input type="hidden" name="jml_item" value="<?= $total['item']?>"><?= $total['item']?></td>
            <td><p>P</p>
                <p>A</p>
                <p>(-)</p>
                <p>C</p>
                <!-- <p>PL</P> -->
            </td>
            <?php for ($t=0; $t < $hari ; $t++) { ?>
                <td><p><input type="hidden" name="total_plan<?= $t?>" value="<?= $total['ttl_plan'.$t.'']?>"><?= $total['ttl_plan'.$t.'']?></p>
                    <p><input type="hidden" name="total_akt<?= $t?>" value="<?= $total['ttl_akt'.$t.'']?>"><?= $total['ttl_akt'.$t.'']?></p>
                    <p><input type="hidden" name="total_min<?= $t?>" value="<?= $total['ttl_min'.$t.'']?>"><?= $total['ttl_min'.$t.'']?></p>
                    <p><input type="hidden" name="total_com<?= $t?>" value="<?= $total['ttl_com'.$t.'']?>"><?= $total['ttl_com'.$t.'']?></p>
                    <!-- <p>PL</P> -->
                </td>
            <?php }?>
            <td><p><input type="hidden" name="ttl_jml_plan" value="<?= $total['ttl_jml_plan']?>"><?= $total['ttl_jml_plan']?></p>
                <p><input type="hidden" name="ttl_jml_akt" value="<?= $total['ttl_jml_akt']?>"><?= $total['ttl_jml_akt']?></p>
                <p><input type="hidden" name="ttl_jml_min" value="<?= $total['ttl_jml_min']?>"><?= $total['ttl_jml_min']?></p>
                <p><input type="hidden" name="ttl_jml_com" value="<?= $total['ttl_jml_com']?>"><?= $total['ttl_jml_com']?></p>
                <!-- <p>PL</P> -->
            </td>
        </tr>
        <?php }?>
    </tfoot>
</table>
<div class="panel-body text-right">
    <button class="btn btn-lg bg-orange" formaction="<?= base_url("MonitoringJobProduksi/Monitoring/exportJob")?>"><i class="fa fa-download"></i> Download</button>
</div>
</form>