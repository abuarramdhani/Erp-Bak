<div class="panel-body">
    <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
        <thead style="background-color:#6ACEF0">
            <tr>
                <th style="vertical-align: middle; width: 5%;">No</th>
                <th style="vertical-align: middle; width: 13%;">Kode Barang</th>
                <th style="vertical-align: middle;">Deskripsi</th>
                <th style="vertical-align: middle; width: 5%;">Qty</th>
                <th style="vertical-align: middle; width: 5%;">Qty Allocate</th>
                <th style="vertical-align: middle; width: 5%;">Qty Transact</th>
                <th style="vertical-align: middle; width: 5%;">To Org</th>
                <th style="vertical-align: middle; width: 10%;">To Subinventory</th>
                <th style="vertical-align: middle; width: 13%;">To Locator</th>
                <th style="vertical-align: middle; width: 5%;">UOM</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach ($detail as $i) { ?>
            <tr>
                <td style="width: 5%;">
                    <?= $no; ?>
                </td>
                <td style="width: 13%; text-align:left;">
                    <?= $i['ITEM_CODE'] ?>
                </td>
                <td style="text-align:left;">
                    <?= $i['DESCRIPTION'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['QUANTITY'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['QUANTITY_DETAILED'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['QUANTITY_DELIVERED'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['TO_ORGANIZATION'] ?>
                </td>
                <td style="width: 10%;">
                    <?= $i['TO_SUBINVENTORY_CODE'] ?>
                </td>
                <td style="width: 13%;">
                    <?= $i['TO_LOCATOR'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['UOM_CODE'] ?>
                </td>
            </tr>
            <?php $no++;} ?>
        </tbody>
    </table>
</div>