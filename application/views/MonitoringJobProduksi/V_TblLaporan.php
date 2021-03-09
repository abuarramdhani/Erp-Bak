<?php
$tabel = count($data)> 10 ? 'tb_laporan' : 'tb_laporan2';
?>
<form method="post">
<table class="table table-bordered table-hover table-striped text-center" id="<?= $tabel?>" style="width: 100%;">
    <thead style="background-color:#63E1EB">
        <tr>
            <th rowspan="2" style="width:5%;vertical-align:middle;background-color:#63E1EB">No
            <input type="hidden" name="kategori" value="<?= $kategori?>">
            <input type="hidden" name="bulan" value="<?= $bulan?>">
            <input type="hidden" name="hari" value="<?= $hari?>">
            </th>
            <th rowspan="2" style="vertical-align:middle;background-color:#63E1EB">Produk</th>
            <th colspan="<?= $hari?>">Produksi</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#63E1EB">Real Prod</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#63E1EB">Target</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#63E1EB">Pencapaian Produksi (%)</th>
        </tr>
        <tr>
            <?php for ($i=1; $i < $hari+1 ; $i++) { 
                echo '<th>'.$i.'</th>';
            }?>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data as $key => $val) {?>
        <tr>
            <td><?= $no?>
                <input type="hidden" name="item[]" value="<?= $val['SUBCATEGORY_NAME']?>">
                <input type="hidden" name="desc[]" value="">
                <input type="hidden" name="real_prod[]" value="<?= $val['REAL_PROD']?>">
                <input type="hidden" name="target[]" value="<?= $val['TARGET']?>">
                <input type="hidden" name="kecapaian[]" value="<?= round($val['KECAPAIAN_TARGET'],3)?>">
            </td>
            <td><span class="text-nowrap"><?= $val['SUBCATEGORY_NAME']?></td>
            <?php for ($i=1; $i < $hari+1 ; $i++) {  
			        $h = sprintf("%02d", $i);?>
                <td><?= $val['TANGGAL'.$h.''] == 0 ? '' : $val['TANGGAL'.$h.'']; ?>
                    <input type="hidden" name="tanggal<?= $i?>[]" value="<?= $val['TANGGAL'.$h.''] == 0 ? '' : $val['TANGGAL'.$h.'']; ?>">
                </td>
            <?php }?>
            <td><?= $val['REAL_PROD']?></td>
            <td><?= $val['TARGET']?></td>
            <td><?= round($val['KECAPAIAN_TARGET'],3)?></td>
        </tr>
        <?php $no++; }?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">Total</td>
            <?php for ($i=1; $i < $hari+1 ; $i++) { 
			        $h = sprintf("%02d", $i);?>
                <td><?= $total['TANGGAL'.$h.'']?>
                    <input type="hidden" name="ttl_tgl<?= $i?>[]" value="<?=  $total['TANGGAL'.$h.'']?>">
                </td>
            <?php }?>
            <td><input type="hidden" name="ttl_real[]" value="<?= $total['REAL_PROD']?>"><?= $total['REAL_PROD']?></td>
            <td><input type="hidden" name="ttl_target[]" value="<?= $total['TARGET']?>"><?= $total['TARGET']?></td>
            <td><input type="hidden" name="ttl_kecapaian[]" value="<?= round($total['KECAPAIAN_TARGET'],3)?>"><?= round($total['KECAPAIAN_TARGET'],3)?></td>
        </tr>
    </tfoot>
</table>
<div class="panel-body text-right">
    <button class="btn btn-lg btn-info" formtarget="_blank" formaction="<?php echo base_url("MonitoringJobProduksi/LaporanProduksi/laporan_produksi_pdf")?>"><i class="fa fa-print"></i> PDF</button>
    <button class="btn btn-lg btn-success" formaction="<?php echo base_url("MonitoringJobProduksi/LaporanProduksi/DownloadExcel")?>"><i class="fa fa-download"></i> Excel</button>
</div>
</form>