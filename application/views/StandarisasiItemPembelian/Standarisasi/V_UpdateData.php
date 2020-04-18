<section class="content-header">
    <h1>Update Standarisasi Item</h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary" style="display:none;">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Data</h3>
                </div>
                <form action="<?= base_url('StandarisasiItemPembelian/Standarisasi/SaveData') ?>" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <table class="table">
                            <tr>
                                <th>Item Code</th>
                                <th>:</th>
                                <td><select class="select2 slcItemSIP" style="width:300px;" name="slcItemSIP" tabindex="1"></select></td>
                                <th>Model</th>
                                <th>:</th>
                                <td><input type="text" class="form-control modelSIP" name="modelSIP" style="width:300px;" tabindex="3"></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <th>:</th>
                                <td><input type="text" class="form-control descSIP" name="descSIP" style="width:300px;" readonly></td>
                                <th>Merk</th>
                                <th>:</th>
                                <td><input type="text" class="form-control merkSIP" name="merkSIP" style="width:300px;" tabindex="4"></td>
                            </tr>
                            <tr>
                                <th>Primary UOM</th>
                                <th>:</th>
                                <td><input type="text" class="form-control uomSIP" name="uomSIP" style="width:300px;" readonly></td>
                                <th>Origin</th>
                                <th>:</th>
                                <td><input type="text" class="form-control originSIP" name="originSIP" style="width:300px;" tabindex="5"></td>
                            </tr>
                            <tr>
                                <th>Kategori Barang</th>
                                <th>:</th>
                                <td><input type="text" class="form-control categorySIP" name="categorySIP" style="width:300px;" readonly></td>
                                <th>Made In</th>
                                <th>:</th>
                                <td><input type="text" class="form-control madeinSIP" name="madeinSIP" style="width:300px;" tabindex="6"></td>
                            </tr>
                            <tr>
                                <th>Buyer</th>
                                <th>:</th>
                                <td><input type="text" class="form-control buyerSIP" name="buyerSIP" style="width:300px;" readonly></td>
                                <th>Supplier Item</th>
                                <th>:</th>
                                <td><input type="text" class="form-control suppItemSIP" name="suppItemSIP" style="width:300px;" tabindex="7"></td>
                            </tr>
                            <tr>
                                <th>Spesifikasi</th>
                                <th>:</th>
                                <td><textarea class="form-control spesifikasiSIP" name="spesifikasiSIP" style="width:300px;" tabindex="2"></textarea></td>
                                <th>Catatan</th>
                                <th>:</th>
                                <td><textarea class="form-control catatanSIP" name="catatanSIP" style="width:300px;" tabindex="8"></textarea></td>
                            </tr>
                            <tr>
                                <th>Cut Off Order</th>
                                <th>:</th>
                                <td><input type="text" name="cutOffSIP" class="form-control" style="width:300px;" tabindex="9"></td>
                                <th>Pembayaran</th>
                                <th>:</th>
                                <td><input type="text" name="pembayaranSIP" class="form-control" style="width:300px;" tabindex="10"></td>
                            </tr>
                            <tr>
                                <th>Kelompok Barang</th>
                                <th>:</th>
                                <td><input type="text" name="kelompokBarangSIP" class="form-control" style="width:300px;" tabindex="11"></td>
                                <th>Jenis Konf.</th>
                                <th>:</th>
                                <td><input type="text" name="jenisKonfSIP" class="form-control" style="width:300px;" tabindex="12"></td>
                            </tr>
                            <tr>
                                <th>Katalog</th>
                                <th>:</th>
                                <td><input type="text" name="katalogSIP" class="form-control" style="width:300px;" tabindex="13"></td>
                                <th>Level Validitas Data</th>
                                <th>:</th>
                                <td><input type="text" name="levelValiditasSIP" class="form-control" style="width:300px;" tabindex="14"></td>
                            </tr>
                            <tr>
                                <th>Import / Lokal</th>
                                <th>:</th>
                                <td><input type="text" name="importLokalSIP" class="form-control" style="width:300px;" tabindex="15"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="UploadCsv" class="btn btn-success">Upload CSV</a>
                            <!-- <button type="button" class="btn btn-success">Upload CSV</button> -->
                            <button type="submit" class="btn btn-primary btnTambahSIP">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="box"> -->
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <p class="bold">List Standarisasi Item</p>
                    </div>
                    <div class="panel-body">
                        <div class="pull-right">
                            <a href="UploadCsv" class="btn btn-success">Import Data From CSV</a>
                        </div><br><br>
                        <div style="overflow: none;">
                            <table class="table table-hover table-striped table-bordered table-responsive tblListdataSIP">
                                <thead class="bg-primary ">
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
                                        <th style="vertical-align:middle;" rowspan="2">ACTION</th>
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
                                        <tr inv="<?= $list['INVENTORY_ITEM_ID']; ?>">
                                            <td><?= $list['ITEM_CODE']; ?></td>
                                            <td><?= $list['DESCRIPTION']; ?></td>
                                            <td><?= $list['PRIMARY_UOM_CODE']; ?></td>
                                            <td><?= $list['BUYER']; ?></td>
                                            <td class="copSIP"><?= $list['CUT_OFF_PEMBELIAN']; ?></td>
                                            <td class="pembSIP"><?= $list['PEMBAYARAN']; ?></td>
                                            <td class="dsSIP"><?= $list['DESKRIPSI_SPESIFIKASI']; ?></td>
                                            <td class="mdlSIP"><?= $list['MODEL']; ?></td>
                                            <td class="merSIP"><?= $list['MERK']; ?></td>
                                            <td class="orSIP"><?= $list['ORIGIN']; ?></td>
                                            <td class="miSIP"><?= $list['MADE_IN']; ?></td>
                                            <td class="supSIP"><?= $list['SUPPLIER_ITEM']; ?></td>
                                            <td class="catSIP"><?= $list['CATATAN']; ?></td>
                                            <td class="kbSIP"><?= $list['KELOMPOK_BARANG']; ?></td>
                                            <td class="cateSIP"><?= $list['CATEGORY']; ?></td>
                                            <td class="jkSIP"><?= $list['JENIS_KONFIRMASI'];?></td>
                                            <td class="katSIP"><?= $list['KATALOG'];?></td>
                                            <td class="lvSIP"><?= $list['LEVEL_VALIDITAS'];?></td>
                                            <td class="ilSIP"><?= $list['IMPORT_LOCAL'];?></td>
                                            <td class="lastSIP"><?= $list['LAST_UPDATE']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btnListSiP" inv="<?= $list['INVENTORY_ITEM_ID']; ?>"><i class="fa fa-edit"></i> Edit&nbsp;&nbsp;&nbsp;&nbsp;</button><br>
                                                <button type="button" class="btn btn-danger btnDeleteSIP" inv="<?= $list['INVENTORY_ITEM_ID']; ?>"><i class="fa fa-trash"></i> Hapus</button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
        </div>
    </div>
</section>

<?php foreach ($ListData as $key => $list) { ?>
    <div class="modal fade" id="mdlEditSIP-<?= $list['INVENTORY_ITEM_ID'];?>" style="display: none;">
        <div class="modal-dialog" style="width:1000px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i>Edit Data <b><?= $list['ITEM_CODE'].'('.$list['DESCRIPTION'].')'; ?></b></h4>
                </div>
                <div class="modal-body">
                    <table class="table" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>">
                        <tr>
                            <th>Item Code</th>
                            <th>:</th>
                            <td><input type="text" class="form-control" style="width:300px;" readonly value="<?= $list['ITEM_CODE'];?>"></td>
                            <th>Model</th>
                            <th>:</th>
                            <td><input type="text" class="form-control modelEditSIP" name="modelSIP" style="width:300px;" value="<?= $list['MODEL'];?>" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>"></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <th>:</th>
                            <td><input type="text" class="form-control descEditSIP" name="descSIP" style="width:300px;" readonly value="<?= $list['DESCRIPTION'];?>"></td>
                            <th>Merk</th>
                            <th>:</th>
                            <td><input type="text" class="form-control merkEditSIP" name="merkSIP" style="width:300px;" value="<?= $list['MERK'];?>" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>"></td>
                        </tr>
                        <tr>
                            <th>Primary UOM</th>
                            <th>:</th>
                            <td><input type="text" class="form-control uomEditSIP" name="uomSIP" style="width:300px;" readonly value="<?= $list['PRIMARY_UOM_CODE'];?>"></td>
                            <th>Origin</th>
                            <th>:</th>
                            <td><input type="text" class="form-control originEditSIP" name="originSIP" style="width:300px;" value="<?= $list['ORIGIN'];?>" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>"></td>
                        </tr>
                        <tr>
                            <th>Kategori Barang</th>
                            <th>:</th>
                            <td><input type="text" class="form-control categoryEditSIP" name="categorySIP" style="width:300px;" readonly value="<?= $list['CATEGORY'];?>" ></td>
                            <th>Made In</th>
                            <th>:</th>
                            <td><input type="text" class="form-control madeinEditSIP" name="madeinSIP" style="width:300px;" value="<?= $list['MADE_IN'];?>" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>"></td>
                        </tr>
                        <tr>
                            <th>Buyer</th>
                            <th>:</th>
                            <td><input type="text" class="form-control buyerEditSIP" name="buyerSIP" style="width:300px;" readonly value="<?= $list['BUYER'];?>"></td>
                            <th>Supplier Item</th>
                            <th>:</th>
                            <td><input type="text" class="form-control suppItemEditSIP" name="suppItemSIP" style="width:300px;" value="<?= $list['SUPPLIER_ITEM'];?>" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>"></td>
                        </tr>
                        <tr>
                            <th>Spesifikasi</th>
                            <th>:</th>
                            <td><textarea class="form-control spesifikasiEditSIP" name="spesifikasiSIP" style="width:300px;" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>"><?= $list['DESKRIPSI_SPESIFIKASI'];?></textarea></td>
                            <th>Catatan</th>
                            <th>:</th>
                            <td><textarea class="form-control catatanEditSIP" name="catatanSIP" style="width:300px;" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>"><?= $list['CATATAN'];?></textarea></td>
                        </tr>
                        <tr>
                            <th>Cut Off Order</th>
                            <th>:</th>
                            <td><input type="text" name="cutOffSIP" class="form-control cutOffEditSIP" style="width:300px;" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>" value="<?= $list['CUT_OFF_PEMBELIAN'];?>"></td>
                            <th>Pembayaran</th>
                            <th>:</th>
                            <td><input type="text" name="pembayaranSIP" class="form-control pembayaranEditSIP" style="width:300px;" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>" value="<?= $list['PEMBAYARAN'];?>"></td>
                        </tr>
                        <tr>
                            <th>Kelompok Barang</th>
                            <th>:</th>
                            <td><input type="text" name="kelompokBarangSIP" class="form-control kelompokBarangEditSIP" style="width:300px;" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>" value="<?= $list['KELOMPOK_BARANG'];?>"></td>
                            <th>Jenis Konf.</th>
                            <th>:</th>
                            <td><input type="text" name="jenisKonfSIP" class="form-control jenisKonfEditSIP" style="width:300px;" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>" value="<?= $list['JENIS_KONFIRMASI'];?>"></td>
                        </tr>
                        <tr>
                            <th>Katalog</th>
                            <th>:</th>
                            <td><input type="text" name="katalogSIP" class="form-control katalogEditSIP" style="width:300px;" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>" value="<?= $list['KATALOG'];?>"></td>
                            <th>Level Validitas Data</th>
                            <th>:</th>
                            <td><input type="text" name="levelValiditasSIP" class="form-control levelValiditasEditSIP" style="width:300px;" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>" value="<?= $list['LEVEL_VALIDITAS'];?>"></td>
                        </tr>
                        <tr>
                            <th>Import / Lokal</th>
                            <th>:</th>
                            <td><input type="text" name="importLokalSIP" class="form-control importLokalEditSIP" style="width:300px;" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>" value="<?= $list['IMPORT_LOCAL'];?>"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btnUpdateSIP" inv-id ="<?= $list['INVENTORY_ITEM_ID'];?>">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<?php } ?>