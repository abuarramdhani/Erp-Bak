<div class="table-responsive" id="tblSPB">
    <table class="table table-bordered table-hover table-striped text-center" id="my_Table3" style="width: 100%;">
        <thead class="bg-primary">
            <tr>
                <th width="5px">No</th>
                <th>Jenis Dokumen</th>
                <th>No Dokumen</th>
                <th>Item</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Belanja</th>
                <th>Jumlah Belanja</th>
                <th>Transact</th>
                <th>Jumlah Transact</th>
                <th>Packing</th>
                <th>Jumlah Packing</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($value as $val) { ?>
            <tr>
                <td style="width: 5px"><?= $no; ?></td>
                <td width="20px"><input type="hidden" name="jenis_doc[]" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                <td><input type="hidden" name="no_doc[]" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                <td><input type="hidden" name="item[]" value="<?= $val['ITEM']?>"><?= $val['ITEM']?></td>
                <td><input type="hidden" name="desc[]" value="<?= $val['ITEM_DESC']?>"><?= $val['ITEM_DESC']?></td>
                <td><input type="hidden" name="qty[]" value="<?= $val['QTY']?>"><?= $val['QTY']?></td>
                <td><input type="hidden" name="tanggal[]" value="<?= $val['TANGGAL_DIBUAT']?>"><?= $val['TANGGAL_DIBUAT']?></td>
                <td><input type="hidden" name="belanja[]" value="<?= $val['BELANJA']?>"><?= $val['BELANJA']?></td>
                <td><input type="hidden" name="jml_belanja[]" value=""></td>
                <td><input type="hidden" name="transact[]" value="<?= $val['TRANSACT']?>"><?= $val['TRANSACT']?></td>
                <td><input type="hidden" name="jml_transact[]" value=""></td>
                <td><input type="hidden" name="packing[]" value="<?= $val['PACKING']?>"><?= $val['PACKING']?></td>
                <td><input type="hidden" name="jml_packing[]" value=""></td>
            </tr>
            <?php $no++; } ?>
        </tbody>
    </table>
</div>


