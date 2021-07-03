<table class="table table-bordered TblMonIntransit" id="Tbl1MonIntransit">
    <thead class="bg-teal">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">No Shipment</th>
            <th class="text-center">No Receipt</th>
            <th class="text-center">Kode Barang</th>
            <th class="text-center">Nama Barang</th>
            <th class="text-center">Tgl Transaksi</th>
            <th class="text-center">Jumlah Hari</th>
            <th class="text-center">From IO</th>
            <th class="text-center">From Subinv</th>
            <th class="text-center">From Locator</th>
            <th class="text-center">To IO</th>
            <th class="text-center">To Subinv</th>
            <th class="text-center">To Locator</th>
            <th class="text-center">Qty Kirim</th>
            <th class="text-center">Qty Terima</th>
            <th class="text-center">Qty Intransit</th>
            <th class="text-center">Comment</th>
            <th class="text-center">Serial Number</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($intransit1 as $key => $item) { ?>
            <tr>
                <td class="text-center"><?= $key + 1 ?></td>
                <td class="text-center"><?= $item['SHIPMENT_NUM'] ?></td>
                <td class="text-center"><?= $item['RECEIPT_NUM'] ?></td>
                <td class="text-center"><?= $item['SEGMENT1'] ?></td>
                <td class="text-center"><?= $item['DESCRIPTION'] ?></td>
                <td class="text-center"><?= $item['CREATION_DATE'] ?></td>
                <td class="text-center"><?= $item['DAYS_COUNT'] ?></td>
                <td class="text-center"><?= $item['FROM_IO'] ?></td>
                <td class="text-center"><?= $item['FROM_SUBINVENTORY'] ?></td>
                <td class="text-center"><?= $item['FROM_LOC'] ?></td>
                <td class="text-center"><?= $item['TO_IO'] ?></td>
                <td class="text-center"><?= $item['TO_SUBINVENTORY'] ?></td>
                <td class="text-center"><?= $item['TO_LOC'] ?></td>
                <td class="text-center"><?= $item['QUANTITY_SHIPPED'] ?></td>
                <td class="text-center"><?= $item['QUANTITY_RECEIVED'] ?></td>
                <td class="text-center"><?= $item['QUANTITY_INTRANSIT'] ?></td>
                <td class="text-center"><?= str_replace('#', '</br>', $item['COMMENTS']) ?></td>
                <td class="text-center"><?= $item['SERIAL_NUMBER'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<table class="table table-bordered TblMonIntransit" id="Tbl2MonIntransit">
    <thead class="bg-teal">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">No Shipment</th>
            <th class="text-center">Jumlah Hari</th>
            <th class="text-center">From IO</th>
            <th class="text-center">From Subinv</th>
            <th class="text-center">From Locator</th>
            <th class="text-center">To IO</th>
            <th class="text-center">To Subinv</th>
            <th class="text-center">To Locator</th>
            <th class="text-center">Qty Intransit</th>
            <th class="text-center">Comment</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($intransit2 as $key => $item) { ?>
            <tr>
                <td class="text-center"><?= $key + 1 ?></td>
                <td class="text-center"><?= $item['SHIPMENT_NUM'] ?></td>
                <td class="text-center"><?= $item['DAYS_COUNT'] ?></td>
                <td class="text-center"><?= $item['FROM_IO'] ?></td>
                <td class="text-center"><?= $item['FROM_SUBINVENTORY'] ?></td>
                <td class="text-center"><?= $item['FROM_LOC'] ?></td>
                <td class="text-center"><?= $item['TO_IO'] ?></td>
                <td class="text-center"><?= $item['TO_SUBINVENTORY'] ?></td>
                <td class="text-center"><?= $item['TO_LOC'] ?></td>
                <td class="text-center"><?= $item['QUANTITY_INTRANSIT'] ?></td>
                <td class="text-center"><?= str_replace('#', '</br>', $item['COMMENTS']) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>