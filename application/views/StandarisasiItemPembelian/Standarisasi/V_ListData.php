<section class="content-header">
    <!-- <h1>Update Data Item</h1> -->
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">List Data Item</h3>
                    <div class="pull-right">
                        <a href="ExportCSV" class="btn btn-success">Export to CSV</a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered table-responsive tblListdataSIP">
                            <thead class="bg-primary">
                                <tr class="text-center">
                                    <th class="bg-primary" style="vertical-align:middle;" rowspan="2">ITEM CODE</th>
                                    <th class="bg-primary" style="vertical-align:middle;" rowspan="2">ITEM DESCRIPTION</th>
                                    <th class="bg-primary" style="vertical-align:middle;" rowspan="2">PRIMARY UOM</th>
                                    <th class="bg-primary" style="vertical-align:middle;" rowspan="2">BUYER</th>
                                    <th style="vertical-align:middle;" rowspan="2">CUT OFF ORDER</th>
                                    <th style="vertical-align:middle;" rowspan="2">PEMBAYARAN</th>
                                    <th colspan="5" style="text-align:center;">STANDAR ITEM BELI /<br> KODE-DESKRIPSI ITEM YANG TERTERA DI PO</th>
                                    <th style="vertical-align:middle;" rowspan="2">SUPPLIER ITEM</th>
                                    <th style="vertical-align:middle;" rowspan="2">CATATAN</th>
                                    <th style="vertical-align:middle;" rowspan="2">KELOMPOK BARANG</th>
                                    <th style="vertical-align:middle;" rowspan="2">KATEGORI BARANG</th>
                                    <th style="text-align:center;" colspan="2">REFERENSI</th>
                                    <th style="vertical-align:middle;" rowspan="2">LEVEL VALIDITAS DATA</th>
                                    <th style="vertical-align:middle;" rowspan="2">IMPORT / LOKAL</th>
                                    <th style="vertical-align:middle;" rowspan="2">LAST UPDATE</th>
                                </tr>
                                <tr class="text-center">
                                    <th>DESKRIPSI SPESIFIKASI</th>
                                    <th>MODEL</th>
                                    <th>MERK</th>
                                    <th>ORIGIN</th>
                                    <th style="border-right:1px solid">MADE IN</th>
                                    <th>JENIS KONF.</th>
                                    <th style="border-right:1px solid">KATALOG</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($ListData as $key => $list) { ?>
                                <tr>
                                    <td><?= $list['ITEM_CODE']; ?></td>
                                    <td><?= $list['DESCRIPTION']; ?></td>
                                    <td><?= $list['PRIMARY_UOM_CODE']; ?></td>
                                    <td><?= $list['BUYER']; ?></td>
                                    <td><?= $list['CUT_OFF_PEMBELIAN']; ?></td>
                                    <td><?= $list['PEMBAYARAN']; ?></td>
                                    <td><?= $list['DESKRIPSI_SPESIFIKASI']; ?></td>
                                    <td><?= $list['MODEL']; ?></td>
                                    <td><?= $list['MERK']; ?></td>
                                    <td><?= $list['ORIGIN']; ?></td>
                                    <td><?= $list['MADE_IN']; ?></td>
                                    <td><?= $list['SUPPLIER_ITEM']; ?></td>
                                    <td><?= $list['CATATAN']; ?></td>
                                    <td><?= $list['KELOMPOK_BARANG']; ?></td>
                                    <td><?= $list['CATEGORY']; ?></td>
                                    <td><?= $list['JENIS_KONFIRMASI'];?></td>
                                    <td><?= $list['KATALOG'];?></td>
                                    <td><?= $list['LEVEL_VALIDITAS'];?></td>
                                    <td><?= $list['IMPORT_LOCAL'];?></td>
                                    <td><?= $list['LAST_UPDATE']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                    <a href="UploadCsv" class="btn btn-success">Import From CSV</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>