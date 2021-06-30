<?php $num=1; $i=0; foreach($hasil as $val){ 
// echo "<pre>"; print_r($val[$i]); exit();
if ($val['item_kom'] == '0' 
&& $val['jml_selesai_kom'] == '0' 
&& $val['jml_tanggungan_kom'] == '0' 
&& $val['item_pnl'] == '0' 
&& $val['jml_selesai_pnl'] == '0' 
&& $val['jml_tanggungan_pnl'] == '0' 
&& $val['item_fg'] == '0' 
&& $val['jml_selesai_fg'] == '0' 
&& $val['jml_tanggungan_fg'] == '0'
&& $val['item_mat'] == '0' 
&& $val['jml_selesai_mat'] == '0' 
&& $val['jml_tanggungan_mat'] == '0') {
    
} else{
?>
<div class="box-body">
    <div class="panel-body">
        <div class="col-md-12">
            <label class="text-right">Tanggal : <?php echo $val['tanggal'] ?></label>
        </div>
        <div class="col-md-12">
            <label class="text-right">Pengeluaran</label>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                <thead>
                    <tr>
                        <th>Gudang</th>
                        <th>Masuk (Item)</th>
                        <th>Selesai</th>
                        <th>Tanggungan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>KOM</td>
                        <td><?= $val['item_kom']?></td>
                        <td><?= $val['jml_selesai_kom']?></td>
                        <td><?= $val['jml_tanggungan_kom']?></td>
                        <td><button type="button" class="btn btn-xs btn-info" onclick="addRinKOM_src(this, <?= $num?>)">Rincian</button></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4">
                            <div id="RinSelesaiKOM<?= $num?>" style="display:none">
                                <center><label>Terselesaikan</label></center>
                                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Creation Date</th>
                                            <th>No Dokumen</th>
                                            <th>Jenis Dokumen</th>
                                            <th>Jumlah Item</th>
                                            <th>PIC</th>
                                            <th>Mulai</th>
                                            <th>Selesai</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i= 0 ;$no=1; foreach($val['selesai_kom'] as $sls) {?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $sls['CREATION_DATE']?></td>
                                            <td><?= $sls['NO_DOKUMEN']?></td>
                                            <td><?= $sls['JENIS_DOKUMEN']?></td>
                                            <td><?= $sls['JUMLAH_ITEM']?></td>
                                            <td><?= $sls['PIC']?></td>
                                            <td><?= $sls['MULAI']?></td>
                                            <td><?= $sls['SELESAI']?></td>
                                            <td><?= $sls['WAKTU']?></td>
                                        </tr>
                                        <?php $no++; $i++; }?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="RinTanggunganKOM<?= $num?>" style="display:none">
                                <center><label>Tanggungan</label></center>
                                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Creation Date</th>
                                            <th>No Dokumen</th>
                                            <th>Jenis Dokumen</th>
                                            <th>Jumlah Item</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i= 0 ;$no=1; foreach($val['tanggungan_kom'] as $tng) {?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $tng['CREATION_DATE']?></td>
                                            <td><?= $tng['NO_DOKUMEN']?></td>
                                            <td><?= $tng['JENIS_DOKUMEN']?></td>
                                            <td><?= $tng['JUMLAH_ITEM']?></td>
                                        </tr>
                                        <?php $no++; $i++; }?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>PNL</td>
                        <td><?= $val['item_pnl']?></td>
                        <td><?= $val['jml_selesai_pnl']?></td>
                        <td><?= $val['jml_tanggungan_pnl']?></td>
                        <td><button type="button" class="btn btn-xs btn-info" onclick="addRinPNL_src(this, <?= $num?>)">Rincian</button></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4">
                            <div id="RinSelesaiPNL<?= $num?>" style="display:none">
                                <center><label>Terselesaikan</label></center>
                                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Creation Date</th>
                                            <th>No Dokumen</th>
                                            <th>Jenis Dokumen</th>
                                            <th>Jumlah Item</th>
                                            <th>PIC</th>
                                            <th>Mulai</th>
                                            <th>Selesai</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i= 0 ;$no=1; foreach($val['selesai_pnl'] as $sls) {?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $sls['CREATION_DATE']?></td>
                                            <td><?= $sls['NO_DOKUMEN']?></td>
                                            <td><?= $sls['JENIS_DOKUMEN']?></td>
                                            <td><?= $sls['JUMLAH_ITEM']?></td>
                                            <td><?= $sls['PIC']?></td>
                                            <td><?= $sls['MULAI']?></td>
                                            <td><?= $sls['SELESAI']?></td>
                                            <td><?= $sls['WAKTU']?></td>
                                        </tr>
                                        <?php $no++; $i++; }?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="RinTanggunganPNL<?= $num?>" style="display:none">
                                <center><label>Tanggungan</label></center>
                                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Creation Date</th>
                                            <th>No Dokumen</th>
                                            <th>Jenis Dokumen</th>
                                            <th>Jumlah Item</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i= 0 ;$no=1; foreach($val['tanggungan_pnl'] as $tng) {?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $tng['CREATION_DATE']?></td>
                                            <td><?= $tng['NO_DOKUMEN']?></td>
                                            <td><?= $tng['JENIS_DOKUMEN']?></td>
                                            <td><?= $tng['JUMLAH_ITEM']?></td>
                                        </tr>
                                        <?php $no++; $i++; }?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>FG</td>
                        <td><?= $val['item_fg']?></td>
                        <td><?= $val['jml_selesai_fg']?></td>
                        <td><?= $val['jml_tanggungan_fg']?></td>
                        <td><button type="button" class="btn btn-xs btn-info" onclick="addRinFG_src(this, <?= $num?>)">Rincian</button></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4">
                            <div id="RinSelesaiFG<?= $num?>" style="display:none">
                                <center><label>Terselesaikan</label></center>
                                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Creation Date</th>
                                            <th>No Dokumen</th>
                                            <th>Jenis Dokumen</th>
                                            <th>Jumlah Item</th>
                                            <th>PIC</th>
                                            <th>Mulai</th>
                                            <th>Selesai</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i= 0 ;$no=1; foreach($val['selesai_fg'] as $sls) {?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $sls['CREATION_DATE']?></td>
                                            <td><?= $sls['NO_DOKUMEN']?></td>
                                            <td><?= $sls['JENIS_DOKUMEN']?></td>
                                            <td><?= $sls['JUMLAH_ITEM']?></td>
                                            <td><?= $sls['PIC']?></td>
                                            <td><?= $sls['MULAI']?></td>
                                            <td><?= $sls['SELESAI']?></td>
                                            <td><?= $sls['WAKTU']?></td>
                                        </tr>
                                        <?php $no++; $i++; }?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="RinTanggunganFG<?= $num?>" style="display:none">
                                <center><label>Tanggungan</label></center>
                                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Creation Date</th>
                                            <th>No Dokumen</th>
                                            <th>Jenis Dokumen</th>
                                            <th>Jumlah Item</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i= 0 ;$no=1; foreach($val['tanggungan_fg'] as $tng) {?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $tng['CREATION_DATE']?></td>
                                            <td><?= $tng['NO_DOKUMEN']?></td>
                                            <td><?= $tng['JENIS_DOKUMEN']?></td>
                                            <td><?= $tng['JUMLAH_ITEM']?></td>
                                        </tr>
                                        <?php $no++; $i++; }?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>MAT</td>
                        <td><?= $val['item_mat']?></td>
                        <td><?= $val['jml_selesai_mat']?></td>
                        <td><?= $val['jml_tanggungan_mat']?></td>
                        <td><button type="button" class="btn btn-xs btn-info" onclick="addRinMAT_src(this, <?= $num?>)">Rincian</button></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4">
                            <div id="RinSelesaiMAT<?= $num?>" style="display:none">
                                <center><label>Terselesaikan</label></center>
                                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Creation Date</th>
                                            <th>No Dokumen</th>
                                            <th>Jenis Dokumen</th>
                                            <th>Jumlah Item</th>
                                            <th>PIC</th>
                                            <th>Mulai</th>
                                            <th>Selesai</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i= 0 ;$no=1; foreach($val['selesai_mat'] as $sls) {?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $sls['CREATION_DATE']?></td>
                                            <td><?= $sls['NO_DOKUMEN']?></td>
                                            <td><?= $sls['JENIS_DOKUMEN']?></td>
                                            <td><?= $sls['JUMLAH_ITEM']?></td>
                                            <td><?= $sls['PIC']?></td>
                                            <td><?= $sls['MULAI']?></td>
                                            <td><?= $sls['SELESAI']?></td>
                                            <td><?= $sls['WAKTU']?></td>
                                        </tr>
                                        <?php $no++; $i++; }?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="RinTanggunganMAT<?= $num?>" style="display:none">
                                <center><label>Tanggungan</label></center>
                                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Creation Date</th>
                                            <th>No Dokumen</th>
                                            <th>Jenis Dokumen</th>
                                            <th>Jumlah Item</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i= 0 ;$no=1; foreach($val['tanggungan_mat'] as $tng) {?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $tng['CREATION_DATE']?></td>
                                            <td><?= $tng['NO_DOKUMEN']?></td>
                                            <td><?= $tng['JENIS_DOKUMEN']?></td>
                                            <td><?= $tng['JUMLAH_ITEM']?></td>
                                        </tr>
                                        <?php $no++; $i++; }?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <label class="text-right">Pasang Ban</label>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                <thead>
                    <tr>
                        <th>Target</th>
                        <th>Realisasi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>100</td>
                        <td><?= $val['realisasi']?></td>
                        <td><button type="button" class="btn btn-xs btn-info" onclick="addRinPasangBan_src(this, <?= $num?>)">Rincian</button></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2">
                            <div id="RinPasangBan<?= $num?>" style="display:none">
                                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>Keterangan</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i= 0; foreach($val['pasangban'] as $pb) {?>
                                        <tr>
                                            <td><?= $pb['KET']?></td>
                                            <td><?= $pb['JUMLAH']?></td>
                                        </tr>
                                        <?php $i++; }?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $num++; $i++; } } ?>