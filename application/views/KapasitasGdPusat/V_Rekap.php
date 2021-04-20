<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:25px"><b><i class="fa fa-book"></i> <?= $Title?></b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label">
                                        <?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?>
                                    </label>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-3">
                                        <label class="text-right">Tanggal Awal</label>
                                        <input id="tglAwal" name="tglAwal" class="form-control pull-right dateKGPRekap" placeholder="yyyy-mm-dd" autocomplete="off">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-right">Tanggal Akhir</label>
                                        <div class="input-group">
                                            <input id="tglAkhir" name="tglAkhir" class="form-control pull-right dateKGPRekap" placeholder="yyyy-mm-dd" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button type="button" onclick="schRekap(this)" class="btn btn-flat" style="background:inherit; text-align:left;padding:0px;padding-left:10px;">
                                                    <i class="fa fa-2x fa-arrow-circle-right" ></i>
                                                </button>    
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" id="tb_Rekap">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <label class="text-right">Tanggal : <?php echo date("d F Y") ?></label>
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
                                                        <td><?= $item_kom?></td>
                                                        <td><?= $jml_selesai_kom?></td>
                                                        <td><?= $jml_tanggungan_kom?></td>
                                                        <td><button type="button" class="btn btn-xs btn-info" onclick="addRinKOM(this)">Rincian</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td colspan="4">
                                                            <div id="RinSelesaiKOM" style="display:none">
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
                                                                        <?php $i= 0 ;$no=1; foreach($selesai_kom as $val) {?>
                                                                        <tr>
                                                                            <td><?= $no; ?></td>
                                                                            <td><?= $val['CREATION_DATE']?></td>
                                                                            <td><?= $val['NO_DOKUMEN']?></td>
                                                                            <td><?= $val['JENIS_DOKUMEN']?></td>
                                                                            <td><?= $val['JUMLAH_ITEM']?></td>
                                                                            <td><?= $val['PIC']?></td>
                                                                            <td><?= $val['MULAI']?></td>
                                                                            <td><?= $val['SELESAI']?></td>
                                                                            <td><?= $val['WAKTU']?></td>
                                                                        </tr>
                                                                        <?php $no++; $i++; }?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="RinTanggunganKOM" style="display:none">
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
                                                                        <?php $i= 0 ;$no=1; foreach($tanggungan_kom as $val) {?>
                                                                        <tr>
                                                                            <td><?= $no; ?></td>
                                                                            <td><?= $val['CREATION_DATE']?></td>
                                                                            <td><?= $val['NO_DOKUMEN']?></td>
                                                                            <td><?= $val['JENIS_DOKUMEN']?></td>
                                                                            <td><?= $val['JUMLAH_ITEM']?></td>
                                                                        </tr>
                                                                        <?php $no++; $i++; }?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PNL</td>
                                                        <td><?= $item_pnl?></td>
                                                        <td><?= $jml_selesai_pnl?></td>
                                                        <td><?= $jml_tanggungan_pnl?></td>
                                                        <td><button type="button" class="btn btn-xs btn-info" onclick="addRinPNL(this)">Rincian</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td colspan="4">
                                                            <div id="RinSelesaiPNL" style="display:none">
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
                                                                        <?php $i= 0 ;$no=1; foreach($selesai_pnl as $val) {?>
                                                                        <tr>
                                                                            <td><?= $no; ?></td>
                                                                            <td><?= $val['CREATION_DATE']?></td>
                                                                            <td><?= $val['NO_DOKUMEN']?></td>
                                                                            <td><?= $val['JENIS_DOKUMEN']?></td>
                                                                            <td><?= $val['JUMLAH_ITEM']?></td>
                                                                            <td><?= $val['PIC']?></td>
                                                                            <td><?= $val['MULAI']?></td>
                                                                            <td><?= $val['SELESAI']?></td>
                                                                            <td><?= $val['WAKTU']?></td>
                                                                        </tr>
                                                                        <?php $no++; $i++; }?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="RinTanggunganPNL" style="display:none">
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
                                                                        <?php $i= 0 ;$no=1; foreach($tanggungan_pnl as $val) {?>
                                                                        <tr>
                                                                            <td><?= $no; ?></td>
                                                                            <td><?= $val['CREATION_DATE']?></td>
                                                                            <td><?= $val['NO_DOKUMEN']?></td>
                                                                            <td><?= $val['JENIS_DOKUMEN']?></td>
                                                                            <td><?= $val['JUMLAH_ITEM']?></td>
                                                                        </tr>
                                                                        <?php $no++; $i++; }?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>FG</td>
                                                        <td><?= $item_fg?></td>
                                                        <td><?= $jml_selesai_fg?></td>
                                                        <td><?= $jml_tanggungan_fg?></td>
                                                        <td><button type="button" class="btn btn-xs btn-info" onclick="addRinFG(this)">Rincian</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td colspan="4">
                                                            <div id="RinSelesaiFG" style="display:none">
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
                                                                        <?php $i= 0 ;$no=1; foreach($selesai_fg as $val) {?>
                                                                        <tr>
                                                                            <td><?= $no; ?></td>
                                                                            <td><?= $val['CREATION_DATE']?></td>
                                                                            <td><?= $val['NO_DOKUMEN']?></td>
                                                                            <td><?= $val['JENIS_DOKUMEN']?></td>
                                                                            <td><?= $val['JUMLAH_ITEM']?></td>
                                                                            <td><?= $val['PIC']?></td>
                                                                            <td><?= $val['MULAI']?></td>
                                                                            <td><?= $val['SELESAI']?></td>
                                                                            <td><?= $val['WAKTU']?></td>
                                                                        </tr>
                                                                        <?php $no++; $i++; }?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="RinTanggunganFG" style="display:none">
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
                                                                        <?php $i= 0 ;$no=1; foreach($tanggungan_fg as $val) {?>
                                                                        <tr>
                                                                            <td><?= $no; ?></td>
                                                                            <td><?= $val['CREATION_DATE']?></td>
                                                                            <td><?= $val['NO_DOKUMEN']?></td>
                                                                            <td><?= $val['JENIS_DOKUMEN']?></td>
                                                                            <td><?= $val['JUMLAH_ITEM']?></td>
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
                                                        <td><?= $realisasi?></td>
                                                        <td><button type="button" class="btn btn-xs btn-info" onclick="addRinPasangBan(this)">Rincian</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td colspan="2">
                                                            <div id="RinPasangBan" style="display:none">
                                                                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                                                                    <thead class="bg-primary">
                                                                        <tr>
                                                                            <th>Keterangan</th>
                                                                            <th>Jumlah</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $i= 0; foreach($pasangban as $val) {?>
                                                                        <tr>
                                                                            <td><?= $val['KET']?></td>
                                                                            <td><?= $val['JUMLAH']?></td>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>