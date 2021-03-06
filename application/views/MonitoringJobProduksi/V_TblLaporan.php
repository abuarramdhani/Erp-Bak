<form method="post">
<?php
$tabel = count($data)> 10 ? 'tb_laporan' : 'tb_laporan2';
if ($kategori != 15 && $kategori != 19) { // view kategori bukan sparepart
?>
<table class="table table-bordered table-hover table-striped text-center" id="<?= $tabel?>">
    <thead style="background-color:#63E1EB">
        <tr>
            <th rowspan="2" style="width:25px;vertical-align:middle;background-color:#63E1EB">No
            <input type="hidden" name="kategori" value="<?= $kategori?>">
            <input type="hidden" name="bulan" value="<?= $bulan?>">
            <input type="hidden" name="hari" value="<?= $hari?>">
            </th>
            <th rowspan="2" style="width:200px;vertical-align:middle;background-color:#63E1EB">Produk</th>
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
        <?php $no = 1; foreach ($data as $key => $val) { ?>
        <tr>
            <td><?= $no?>
                <input type="hidden" name="bulan[]" value="<?= $bulan?>">
                <input type="hidden" name="item[]" value="<?= $val['DESKRIPSI']?>">
                <input type="hidden" name="desc[]" value="<?= $val['DESKRIPSI']?>">
                <input type="hidden" name="real_prod[]" value="<?= $val['REAL_PROD']?>">
                <input type="hidden" name="target[]" value="<?= $val['TARGET']?>">
                <input type="hidden" name="kecapaian[]" value="<?= number_format(!empty($val['TARGET']) && $val['TARGET'] != 0 ? ($val['REAL_PROD'] / $val['TARGET']) * 100 : 0 ,2) ?>">
            </td>
            <td><?= $val['DESKRIPSI']?></td>
            <?php for ($i=1; $i < $hari+1 ; $i++) {  
			        $h = sprintf("%02d", $i);?>
                <td><?= $val['TANGGAL'.$h.''] == 0 ? '' : $val['TANGGAL'.$h.'']; ?>
                    <input type="hidden" name="tanggal<?= $i?>[]" value="<?= $val['TANGGAL'.$h.''] == 0 ? '' : $val['TANGGAL'.$h.'']; ?>">
                </td>
            <?php }?>
            <td><?= $val['REAL_PROD']?></td>
            <td><?= $val['TARGET']?></td>
            <td><?= number_format(!empty($val['TARGET']) && $val['TARGET'] != 0 ? ($val['REAL_PROD'] / $val['TARGET']) * 100 : 0 ,2) ?></td>
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
            <td><?php $ttl = number_format(!empty($total['TARGET']) && $total['TARGET'] != 0 ? ($total['REAL_PROD'] / $total['TARGET']) * 100 : 0 ,2);?>
                <input type="hidden" name="ttl_kecapaian[]" value="<?= $ttl?>"><?= $ttl?></td>
        </tr>
    </tfoot>
</table>
<?php }else { // view kategori sparepart ?>
<table class="table table-bordered table-hover table-striped text-center" id="<?= $tabel?>">
    <thead style="background-color:#63E1EB">
        <tr>
            <th rowspan="2" style="width:25px;vertical-align:middle;background-color:#63E1EB">No
            <input type="hidden" name="kategori" value="<?= $kategori?>">
            <input type="hidden" name="bulan" value="<?= $bulan?>">
            <input type="hidden" name="hari" value="<?= $hari?>">
            </th>
            <th rowspan="2" style="width:200px;vertical-align:middle;background-color:#63E1EB">Produk</th>
            <th colspan="<?= $hari?>">Produksi</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#63E1EB">Target</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#63E1EB">WOS / JOB</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#63E1EB">% JOB PPIC</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#63E1EB">Completion INT-ASSY + NO PACKG</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#63E1EB">% Completion ASSY</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#63E1EB">In YSP</th>
            <th rowspan="2" style="vertical-align:middle;background-color:#63E1EB">YSP</th>
        </tr>
        <tr>
            <?php for ($i=1; $i < $hari+1 ; $i++) { 
                echo '<th>'.$i.'</th>';
            }?>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; 
        $total_wos = $total_comp = $total_real = 0;
        foreach ($data as $key => $val) {
        $wosjob     = number_format(!empty($val['TARGET']) && $val['TARGET'] != 0 ? ($val['WOS_JOB'] / $val['TARGET']) * 100 : 0 ,2);
        $completion = number_format(!empty($val['TARGET']) && $val['TARGET'] != 0 ? ($val['COMPLETION'] / $val['TARGET']) * 100 : 0 ,2);
        $kecapaian  = number_format(!empty($val['TARGET']) && $val['TARGET'] != 0 ? ($val['REAL_PROD'] / $val['TARGET']) * 100 : 0 ,2);
        $wos        = $val['WOS_JOB'] > $val['TARGET'] ? $val['TARGET'] : $val['WOS_JOB'];
        $comp       = $val['COMPLETION'] > $val['TARGET'] ? $val['TARGET'] : $val['COMPLETION'];
        $real       = $val['REAL_PROD'] > $val['TARGET'] ? $val['TARGET'] : $val['REAL_PROD'];
        $total_wos  += $wos;
        $total_comp  += $comp;
        $total_real  += $real;
        ?>
        <tr>
            <td><?= $no?>
                <input type="hidden" name="bulan[]" value="<?= $bulan?>">
                <input type="hidden" name="item[]" value="<?= $val['DESKRIPSI']?>">
                <input type="hidden" name="desc[]" value="<?= $val['DESKRIPSI']?>">
                <input type="hidden" name="real_prod[]" value="<?= $real?>">
                <input type="hidden" name="target[]" value="<?= $val['TARGET']?>">
                <input type="hidden" name="wosjob[]" value="<?= $wos?>">
                <input type="hidden" name="completion[]" value="<?= $comp?>">
                <input type="hidden" name="wosjob2[]" value="<?= $wosjob > 100 ? number_format(100,2) : $wosjob?>">
                <input type="hidden" name="completion2[]" value="<?= $completion > 100 ? number_format(100,2) : $completion?>">
                <input type="hidden" name="kecapaian[]" value="<?= $kecapaian > 100 ? number_format(100,2) : $kecapaian?>">
            </td>
            <td><?= $val['DESKRIPSI']?></td>
            <?php for ($i=1; $i < $hari+1 ; $i++) {  
			        $h = sprintf("%02d", $i);?>
                <td><?= $val['TANGGAL'.$h.''] == 0 ? '' : $val['TANGGAL'.$h.'']; ?>
                    <input type="hidden" name="tanggal<?= $i?>[]" value="<?= $val['TANGGAL'.$h.''] == 0 ? '' : $val['TANGGAL'.$h.'']; ?>">
                </td>
            <?php }?>
            <td><?= $val['TARGET']?></td>
            <td><?= $val['WOS_JOB']?></td>
            <td><?= $wosjob > 100 ? number_format(100,2) : $wosjob?></td>
            <td><?= $comp?></td>
            <td><?= $completion > 100 ? number_format(100,2) : $completion?></td>
            <td><?= $real?></td>
            <td><?= $kecapaian > 100 ? number_format(100,2) : $kecapaian?></td>
        </tr>
        <?php $no++; }?>
    </tbody>
    <tfoot>
        <?php 
        $ttl_wosjob = number_format(!empty($total['TARGET']) && $total['TARGET'] != 0 ? ($total_wos / $total['TARGET']) * 100 : 0 ,2);
        $ttl_comp   = number_format(!empty($total['TARGET']) && $total['TARGET'] != 0 ? ($total_comp / $total['TARGET']) * 100 : 0 ,2);
        $ttl_capai  = number_format(!empty($total['TARGET']) && $total['TARGET'] != 0 ? ($total_real / $total['TARGET']) * 100 : 0 ,2);
        $wosjobnya  = $total_wos > $total['TARGET'] ? $total['TARGET'] : $total_wos;
        $compnya    = $total_comp > $total['TARGET'] ? $total['TARGET'] : $total_comp;
        $pencapaian = $total_real > $total['TARGET'] ? $total['TARGET'] : $total_real;
        ?>
        <tr>
            <td colspan="2">Total</td>
            <?php for ($i=1; $i < $hari+1 ; $i++) { 
			        $h = sprintf("%02d", $i);?>
                <td><?=  $total['TANGGAL'.$h.'']?>
                    <input type="hidden" name="ttl_tgl<?= $i?>[]" value="<?=  $total['TANGGAL'.$h.'']?>">
                </td>
            <?php }?>
            <td><input type="hidden" name="ttl_target[]" value="<?= $total['TARGET']?>"><?= $total['TARGET']?></td>
            <td><input type="hidden" name="ttl_wosjob[]" value="<?= $total_wos?>"><?= $total_wos?></td>
            <td><input type="hidden" name="ttl_wosjob2[]" value="<?= $ttl_wosjob > 100 ? number_format(100,2) : $ttl_wosjob?>"><?= $ttl_wosjob > 100 ? number_format(100,2) : $ttl_wosjob?></td>
            <td><input type="hidden" name="ttl_completion[]" value="<?= $compnya?>"><?= $compnya?></td>
            <td><input type="hidden" name="ttl_completion2[]" value="<?= $ttl_comp > 100 ? number_format(100,2) : $ttl_comp?>"><?= $ttl_comp > 100 ? number_format(100,2) : $ttl_comp?></td>
            <td><input type="hidden" name="ttl_real[]" value="<?= $pencapaian?>"><?= $pencapaian?></td>
            <td><input type="hidden" name="ttl_kecapaian[]" value="<?= $ttl_capai > 100 ? number_format(100,2) : $ttl_capai?>"><?= $ttl_capai > 100 ? number_format(100,2) : $ttl_capai?></td>
        </tr>
    </tfoot>
</table>
<?php }?>
<div class="panel-body text-right">
    <button class="btn" formaction="<?php echo base_url("MonitoringJobProduksi/LaporanProduksi/detail_laporan")?>"><i class="fa fa-download"></i> DETAIL</button>
    <button class="btn btn-success" formaction="<?php echo base_url("MonitoringJobProduksi/LaporanProduksi/DownloadExcel")?>"><i class="fa fa-download"></i> EXCEL</button>
    <button class="btn btn-success" formaction="<?php echo base_url("MonitoringJobProduksi/LaporanProduksi/laporan_produksi_excel2")?>"><i class="fa fa-download"></i> EXCEL ALL</button>
    <button class="btn btn-info" formtarget="_blank" formaction="<?php echo base_url("MonitoringJobProduksi/LaporanProduksi/laporan_produksi_pdf")?>"><i class="fa fa-print"></i> PDF</button>
    <button class="btn btn-info" formtarget="_blank" formaction="<?php echo base_url("MonitoringJobProduksi/LaporanProduksi/laporan_produksi_pdf2")?>"><i class="fa fa-print"></i> PDF ALL</button>
</div>
</form>