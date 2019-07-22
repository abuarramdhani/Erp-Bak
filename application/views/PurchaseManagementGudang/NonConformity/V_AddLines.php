<table class="table table-bordered text-center" id="tblLinesNonC">
    <thead class="bg-primary">
        <tr>
            <th><input type="checkbox" class="minimal checkBoxAllNonC"></th>
            <th>Line Number</th>
            <th>Item Code</th>
            <th>Item Description</th>
            <th>Qty Receipt</th>
            <!-- <th>Qty Billed</th> -->
            <th>Qty Reject</th>
            <!-- <th>Unit Price</th> -->
            <th>Qty PO</th>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($dataLines as $key => $data) { ?>
        <tr class="lineListNonC" data-row="<?php echo $no; ?>">
            <td><input type="checkbox" class="minimal checkBoxNonC" item="<?php echo $data['ITEM_ID']; ?>" desc="<?= $data['DESCRIPTION']; ?>" qtyRecipt="<?= $data['QTY_RECEIPT']; ?>" qtyBilled="<?= $data['QUANTITY_BILLED']; ?>" qtyReject="<?= $data['REJECTED']; ?>" unitPrice="<?= $data['UNIT_PRICE']; ?>" qtyPo="<?= $data['QUANTITY']; ?>" currency="<?= $data['CURRENCY']; ?>" data-row="<?= $no; ?>" po="<?= $data['NO_PO']; ?>" line="<?= $data['LINE_NUM']; ?>" status="<?= $data['CLOSED_CODE']; ?>" lppb="<?= $data['NO_LPPB']; ?>" buyer="<?= $data['BUYER']; ?>" noind="<?= $data['NATIONAL_IDENTIFIER'];?>"></td>
            <td><?php echo $data['LINE_NUM']; ?></td>
            <td><?php echo $data['ITEM_ID']; ?></td>
            <td><?php echo $data['DESCRIPTION']; ?></td>
            <td><?php echo $data['QTY_RECEIPT']; ?></td>
            <!-- <td><?php echo $data['QUANTITY_BILLED']; ?></td> -->
            <td><?php echo $data['REJECTED']; ?></td>
            <!-- <td><?php echo $data['UNIT_PRICE']; ?></td> -->
            <td><?php echo $data['QUANTITY']; ?></td>
        </tr>
    <?php $no++; } ?>
    </tbody>
</table>