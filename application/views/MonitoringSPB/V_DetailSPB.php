<div class="panel-body">
    <div class="col-md-12">
        <table class="table table-bordered" id="detail_CAR" style="width: 100%;">
            <thead class="bg-green">
                <tr>
                    <th class="text-center">Line</th>
                    <th class="text-center">Item Code</th>
                    <th class="text-center">Item Description</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Qty Allocate</th>
                    <th class="text-center">Qty Deliver</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($line as $v) { ?>
                    <tr>
                        <td class="text-center"><?= $v['LINE_SPB'] ?></td>
                        <td class="text-center"><?= $v['KODE_ITEM'] ?></td>
                        <td class="text-center"><?= $v['ITEM_DESC'] ?></td>
                        <td class="text-center"><?= $v['QTY'] ?></td>
                        <td class="text-center"><?= $v['QTY_ALLOCATE'] ?></td>
                        <td class="text-center"><?= $v['QTY_DELIVER'] ?></td>

                    </tr>
                <?php $i++;
                } ?>
            </tbody>
        </table>
    </div>
</div>