<div class="col-lg-12">
    <table class="table table-bordered table-stripped text-center">
        <thead>
            <tr class="bg-primary">
                <th>No</th>
                <th>Item</th>
                <th>MOQ</th>
                <th>FLM</th>
                <th>OnHand</th>
                <th>ATT</th>
                <th>ATR</th>
                <th>Subinventory Code</th>
                <th>Organization Code</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=0; foreach ($getStock as $key => $stock) { $no++; 
                if ($stock['MOQ'] == null) {
                    $stock['MOQ'] = '-';
                }
                if ($stock['FLM'] == null) {
                    $stock['FLM'] = '-';
                }
                if ($stock['ONHAND'] == null) {
                    $stock['ONHAND'] = '-';
                }
                if ($stock['SUBINVENTORY_CODE'] == null) {
                    $stock['SUBINVENTORY_CODE'] = '-';
                }
                if ($stock['ORGANIZATION_CODE'] == null) {
                    $stock['ORGANIZATION_CODE'] = '-';
                }
            ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $stock['ITEM']; ?></td>
                    <td><?= $stock['MOQ']; ?></td>
                    <td><?= $stock['FLM']; ?></td>
                    <td><?= $stock['ONHAND']; ?></td>
                    <td><?= $stock['ATT']; ?></td>
                    <td><?= $stock['ATR']; ?></td>
                    <td><?= $stock['SUBINVENTORY_CODE']; ?></td>
                    <td><?= $stock['ORGANIZATION_CODE']; ?></td>
                </tr>
            <?php }?>
        </tbody>
    </table><br>
    <div class="panel panel-success">
        <div class="panel-heading">
            <p class="bold">Outstanding PO</p>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-stripped text-center">
                <thead>
                    <tr>
                        <th>PO Number</th>
                        <th>Line Number</th>
                        <th>Promised Date</th>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>PR Number</th>
                        <th>Requestor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($outstandingPO as $key => $outstanding) { ?>
                        <tr>
                            <td><?= $outstanding['PO_NUMBER']; ?></td>
                            <td><?= $outstanding['LINE_NUM']; ?></td>
                            <td><?= $outstanding['PROMISED_DATE']; ?></td>
                            <td><?= $outstanding['NAMA_BARANG']; ?></td>
                            <td><?= $outstanding['QTY']; ?></td>
                            <td><?= $outstanding['PR_NUMBER']; ?></td>
                            <td><?= $outstanding['REQUESTOR']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>