<div class="panel panel-danger">
    <div class="panel-heading">
        <p class="bold">Item Tidak Dapat Diproses</p>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Quantity</th>
                    <th>UOM</th>
                    <th>NBD</th>
                    <th>Destination Type</th>
                    <th>Organization</th>
                    <th>Location</th>
                    <th>Subinventory</th>
                    <th>Alasan Order</th>
                    <th>Alasan Urgensi</th>
                    <th>Note to Pengelola</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 0;
                foreach ($item_not_oke as $key => $itemx) {
                    $no++; ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $itemx['item_code']; ?></td>
                        <td><?= $itemx['qty']; ?></td>
                        <td><?= $itemx['uom']; ?></td>
                        <td><?= $itemx['nbd']; ?></td>
                        <td><?= $itemx['destination_type']; ?></td>
                        <td><?= $itemx['organization']; ?></td>
                        <td><?= $itemx['location']; ?></td>
                        <td><?= $itemx['subinventory']; ?></td>
                        <td><?= $itemx['alasan_order']; ?></td>
                        <td><?= $itemx['alasan_urgensi']; ?></td>
                        <td><?= $itemx['note_to_pengelola']; ?></td>
                        <td><?= $itemx['notes']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<br>

<?php if ($item_oke) { ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <p class="bold">Item Dapat Diproses</p>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Quantity</th>
                        <th>UOM</th>
                        <th>NBD</th>
                        <th>Destination Type</th>
                        <th>Organization</th>
                        <th>Location</th>
                        <th>Subinventory</th>
                        <th>Alasan Order</th>
                        <th>Alasan Urgensi</th>
                        <th>Note to Pengelola</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no1 = 0;
                    foreach ($item_oke as $key => $item) {
                        $no1++; ?>
                        <tr>
                            <td><?= $no1; ?></td>
                            <td><?= $item['item_code']; ?></td>
                            <td><?= $item['qty']; ?></td>
                            <td><?= $item['uom']; ?></td>
                            <td><?= date('d-M-Y', strtotime($item['nbd'])); ?></td>
                            <td><?= $item['destination_type']; ?></td>
                            <td><?= $item['organization']; ?></td>
                            <td><?= $item['location']; ?></td>
                            <td><?= $item['subinventory']; ?></td>
                            <td><?= $item['alasan_order']; ?></td>
                            <td><?= $item['alasan_urgensi']; ?></td>
                            <td><?= $item['note_to_pengelola']; ?></td>
                            <td><?= $item['notes']; ?></td>
                            <input type="hidden" class="form-control" name="slcOKBinputCode[]" value="<?= $item['inv_item_id']; ?>">
                            <input type="hidden" class="form-control" name="txtOKBinputDescription[]" value="<?= $item['deskripsi']; ?>">
                            <input type="hidden" class="form-control" name="txtOKBinputQty[]" value="<?= $item['qty']; ?>">
                            <input type="hidden" class="form-control" name="slcOKBuom[]" value="<?= $item['uom']; ?>">
                            <input type="hidden" class="form-control" name="txtOKBnbd[]" value="<?= date('d-M-Y', strtotime($item['nbd'])); ?>">
                            <input type="hidden" class="form-control" name="hdnDestinationOKB[]" value="<?= $item['destination_type']; ?>">
                            <input type="hidden" class="form-control" name="organizationOKB[]" value="<?= $item['org_id']; ?>">
                            <input type="hidden" class="form-control" name="locationOKB[]" value="<?= $item['loc_id']; ?>">
                            <input type="hidden" class="form-control" name="subinventoyOKB[]" value="<?= $item['subinventory']; ?>">
                            <input type="hidden" class="form-control" name="txtOKBinputReason[]" value="<?= $item['alasan_order']; ?>">
                            <input type="hidden" class="form-control" name="txtOKBinputUrgentReason[]" value="<?= $item['alasan_urgensi']; ?>">
                            <input type="hidden" class="form-control" name="txtOKBinputNote[]" value="<?= $item['note_to_pengelola']; ?>">
                            <input type="hidden" class="form-control" name="hdnUrgentFlagOKB[]" value="<?= $item['urgent_flag']; ?>">
                            <input type="hidden" class="form-control" name="cutoff[]" value="<?= $item['cut_off']; ?>">
                            <input type="hidden" class="form-control" name="hdnItemCodeOKB[]" value="<?= $item['item_code'] . ' - ' . $item['deskripsi']; ?>">
                            <input type="file" name="fileOKBAttachment<?= $no1; ?>[]" multiple style="display: none">
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>