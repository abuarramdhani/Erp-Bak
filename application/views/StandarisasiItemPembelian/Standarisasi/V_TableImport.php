<div class="panel panel-warning">
    <div class="panel-heading">
        <p class="bold">List Standarisasi Item</p>
    </div>
    <div class="panel-body">
        <form action="<?= base_url('StandarisasiItemPembelian/Standarisasi/SaveDataImport') ?>" method="post" enctype="multipart/form-data">
            <div style="overflow: none;">
                <table class="table table-hover table-striped table-bordered tblListdataSIP" style="width: 100%;">
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
                            <th style="vertical-align:middle;" colspan="2">REFERENSI</th>
                            <th style="vertical-align:middle;" rowspan="2">LEVEL VALIDITAS DATA</th>
                            <th style="vertical-align:middle;" rowspan="2">IMPORT / LOKAL</th>
                        </tr>
                        <tr>
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
                        <?php foreach ($items as $key => $item) { ?>
                            <tr>
                                <input type="hidden" class="form-control" name="slcItemSIP[]" value="<?= $item['inventory_item_id']; ?>">
                                <td><?= $item['item_code']; ?></td>
                                <td><?= $item['deskripsi']; ?></td>
                                <td><?= $item['uom']; ?></td>
                                <td><?= $item['buyer']; ?></td>
                                <td><input type="text" class="form-control" name="cutOffSIP[]" style="width:200px;" value="<?= $item['cut_off_pembelian']; ?>"></td>
                                <td><input type="text" class="form-control" name="pembayaranSIP[]" style="width:200px;" value="<?= $item['pembayaran']; ?>"></td>
                                <td><input type="text" class="form-control" name="spesifikasiSIP[]" style="width:200px;" value="<?= $item['spesifikasi']; ?>"></td>
                                <td><input type="text" class="form-control" name="modelSIP[]" style="width:200px;" value="<?= $item['model']; ?>"></td>
                                <td><input type="text" class="form-control" name="merkSIP[]" style="width:200px;" value="<?= $item['merk']; ?>"></td>
                                <td><input type="text" class="form-control" name="originSIP[]" style="width:200px;" value="<?= $item['origin']; ?>"></td>
                                <td><input type="text" class="form-control" name="madeinSIP[]" style="width:200px;" value="<?= $item['made_in']; ?>"></td>
                                <td><input type="text" class="form-control" name="suppItemSIP[]" style="width:200px;" value="<?= $item['supplier_item']; ?>"></td>
                                <td><input type="text" class="form-control" name="catatanSIP[]" style="width:200px;" value="<?= $item['catatan']; ?>"></td>
                                <td><input type="text" class="form-control" name="kelompokBarangSIP[]" style="width:200px;" value="<?= $item['kelompok_barang']; ?>"></td>
                                <td><?= $item['category']; ?></td>
                                <td><input type="text" class="form-control" name="jenisKonfSIP[]" style="width:200px;" value="<?= $item['jenis_konfirmasi']; ?>"></td>
                                <td><input type="text" class="form-control" name="katalogSIP[]" style="width:200px;" value="<?= $item['katalog']; ?>"></td>
                                <td><input type="text" class="form-control" name="levelValiditasSIP[]" style="width:200px;" value="<?= $item['level_validitas']; ?>"></td>
                                <td><input type="text" class="form-control" name="importLokalSIP[]" style="width:200px;" value="<?= $item['import_local']; ?>"></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="pull-right">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> SUBMIT</button>
            </div>
        </form>
    </div>
</div>