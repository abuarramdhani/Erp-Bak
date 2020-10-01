<div class="panel-body">
    <div class="col-md-12">
        <table class="table table-bordered" id="detail_CAR" style="width: 100%;">
            <thead class="bg-green">
                <tr>
                    <th class="text-center">PO Number</th>
                    <th class="text-center">Item Code</th>
                    <th class="text-center">Item Description</th>
                    <th class="text-center">UoM</th>
                    <th class="text-center">Qty PO</th>
                    <th class="text-center">Received Date PO</th>
                    <th class="text-center">Shipment Date</th>
                    <th class="text-center">LPPB Number</th>
                    <th class="text-center">Actual Receive Date</th>
                    <th class="text-center">Qty Receipt</th>
                    <th class="text-center">Notes</th>
                    <th class="text-center">Detail Rootcause</th>
                    <th class="text-center">Rootcause Category</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($datatoview as $v) { ?>
                    <tr>
                        <td class="text-center"><?= $v['PO_NUMBER'] ?></td>
                        <td class="text-center"><?= $v['ITEM_CODE'] ?></td>
                        <td class="text-center"><?= $v['ITEM_DESCRIPTION'] ?></td>
                        <td class="text-center"><?= $v['UOM'] ?></td>
                        <td class="text-center"><?= $v['QTY_PO'] ?></td>
                        <td class="text-center"><?= $v['RECEIVED_DATE_PO'] ?></td>
                        <td class="text-center"><?= $v['SHIPMENT_DATE'] ?></td>
                        <td class="text-center"><?= $v['LPPB_NUMBER'] ?></td>
                        <td class="text-center"><?= $v['ACTUAL_RECEIPT_DATE'] ?></td>
                        <td class="text-center"><?= $v['QTY_RECEIPT'] ?></td>
                        <td class="text-center"><?= $v['NOTES'] ?></td>
                        <td class="text-center"><?= $v['DETAIL_ROOTCAUSE'] ?></td>
                        <td class="text-center"><?= $v['ROOTCAUSE_CATEGORI'] ?></td>
                    </tr>
                <?php $i++;
                } ?>
            </tbody>
        </table>
    </div>
</div>