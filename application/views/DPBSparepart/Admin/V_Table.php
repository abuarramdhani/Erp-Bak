<table class="table table-bordered table-hover">
    <thead>
        <tr class="bg-primary">
            <th>ITEM CODE</th>
            <th>DESCRIPTION</th>
            <th>REQUEST QTY</th>
            <th>ATR QTY</th>
            <th>Sisa QTY</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_barang as $key => $barang) { ?>
            <tr>
                <td><?= $barang['SEGMENT1'];?></td>
                <td><?= $barang['DESCRIPTION'];?></td>
                <td><?= $barang['REQ_QTY'];?></td>
                <td><?= $barang['QTY_ATR'];?></td>
                <td><?= $barang['ATR_SISA'];?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>