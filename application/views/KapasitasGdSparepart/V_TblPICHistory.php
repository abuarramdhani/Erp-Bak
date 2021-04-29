<table class="datatable table table-bordered table-hover table-striped text-center" id="tbl_pic_history" style="width:100%">
    <thead class="text-nowrap" style="background-color:#47C9FF">
        <tr>
            <th rowspan="2" style="width:5%">No</th>
            <th rowspan="2">Nama PIC</th>
            <th colspan="3">Pelayanan</th>
            <th colspan="3">Packing</th>
        </tr>
        <tr>
            <th>Lembar</th>
            <th>Item</th>
            <th>Pcs</th>
            <th>Lembar</th>
            <th>Item</th>
            <th>Pcs</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach($datapic as $val){ ?>
            <tr id="baris<?= $no?>">
                <td style="width:5%"><?= $no; ?></td>
                <td><?= $val['PIC']?></td>
                <td><?= $val['DOKUMEN_PELAYANAN']?></td>
                <td><?= $val['ITEM_PELAYANAN']?></td>
                <td><?= $val['PCS_PELAYANAN']?></td>
                <td><?= $val['DOKUMEN_PACKING']?></td>
                <td><?= $val['ITEM_PACKING']?></td>
                <td><?= $val['PCS_PACKING']?></td>
            </tr>
        <?php $no++; }?>
    </tbody>
</table>