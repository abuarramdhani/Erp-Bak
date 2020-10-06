<strong>Seksi : <?= $nama_seksi ?></strong>
<br>
<br>
<table class="table table-bordered" id="tbl_moneed" style="width: 100%;">
    <thead class="bg-red">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Item</th>
            <th class="text-center">Desc</th>
            <th class="text-center">Qty</th>
            <th class="text-center">Uom</th>
            <th class="text-center">Tgl Input</th>
            <th class="text-center">Status</th>
            <th class="text-center">Tgl Approve PPIC</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($monneed as $key => $value) { ?>
            <tr>
                <td class="text-center"><?= $no ?></td>
                <td class="text-center"><?= $value['item_code'] ?></td>
                <td class="text-center"><?= $value['desc'] ?></td>
                <td class="text-center"><?= $value['quantity'] ?></td>
                <td class="text-center"><?= $value['uom'] ?></td>
                <td class="text-center"><?= $value['creation_date'] ?></td>
                <td class="text-center"><?= $value['status'] ?></td>
                <?php if ($value['ppic_approve_date'] == null) { ?>
                    <td class="text-center"><strong>-</strong></td>
                <?php } else { ?>
                    <td class="text-center"><?= $value['ppic_approve_date'] ?></td>
                <?php } ?>
            </tr>
        <?php $no++;
        } ?>
    </tbody>
</table>