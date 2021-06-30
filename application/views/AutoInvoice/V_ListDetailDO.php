<div class="panel-body">
    <div class="col-md-12">
        <table class="table table-bordered" id="tbl_Ready_To_Ship_Confirm">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center">NO</th>
                    <th class="text-center">ITEM</th>
                    <th class="text-center">DESCRIPTION</th>
                    <th class="text-center">REQUEST QTY</th>
                    <th class="text-center">UOM</th>
                    <th class="text-center">SHIPPED QTY</th>

                </tr>
            </thead>
            <tbody>
                <?php $angka = 1;
                foreach ($DetailDO as $key => $do) { ?>
                    <tr>
                        <td class="text-center"><?= $angka ?></td>
                        <td class="text-center"><?= $do['SEGMENT1'] ?></td>
                        <td class="text-center"><?= $do['DESCRIPTION'] ?></td>
                        <td class="text-center"><?= $do['REQUESTED_QUANTITY'] ?></td>
                        <td class="text-center"><?= $do['REQUESTED_QUANTITY_UOM'] ?></td>
                        <td class="text-center"><?= $do['SHIPPED_QUANTITY'] ?></td>
                    </tr>
                <?php $angka++;
                } ?>
            </tbody>
        </table>
    </div>
</div>