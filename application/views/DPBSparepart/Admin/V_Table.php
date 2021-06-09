<table class="table table-bordered table-hover">
    <thead>
        <tr class="bg-primary">
            <th>LINE ID</th>
            <th>ITEM CODE</th>
            <th>DESCRIPTION</th>
            <th>DO/SPB QTY</th>
            <th>REQUEST QTY</th>
            <th>ATR QTY</th>
            <th>Sisa QTY</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_barang as $key => $barang) { ?>
            <tr>
                <td class="lineid"><?= $barang['LINE_ID']; ?></td>
                <td><?= $barang['SEGMENT1']; ?></td>
                <td><?= $barang['DESCRIPTION']; ?></td>
                <td class="spbQty"><?= $barang['REQ_QTY']; ?></td>
                <td width="125px">
                    <input type="number" min="0" max="<?= $barang['REQ_QTY']; ?>" class="form-control noReqQty">
                </td>
                <td class="atrQty"><?= $barang['QTY_ATR']; ?></td>
                <td class="allocateQty"></td>
            </tr>
        <?php } ?>
    </tbody>
</table>