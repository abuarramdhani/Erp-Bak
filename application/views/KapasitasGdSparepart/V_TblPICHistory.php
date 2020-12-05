<?php $tambahan = '&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
<table class="datatable table table-bordered table-hover table-striped text-center" id="tbl_pic_history" style="width: 100%;">
    <thead class="text-nowrap" style="background-color:#47C9FF">
        <tr>
            <th rowspan="2" style="width:5%">No</th>
            <th rowspan="2"><?= $tambahan?>Nama PIC<?= $tambahan?></th>
            <th colspan="3">Pelayanan</th>
            <th colspan="3">Pengeluaran</th>
            <th colspan="3">Packing</th>
        </tr>
        <tr>
            <th><?= $tambahan?>Lembar<?= $tambahan?></th>
            <th><?= $tambahan?>Item<?= $tambahan?></th>
            <th><?= $tambahan?>Pcs<?= $tambahan?></th>
            <th><?= $tambahan?>Lembar<?= $tambahan?></th>
            <th><?= $tambahan?>Item<?= $tambahan?></th>
            <th><?= $tambahan?>Pcs<?= $tambahan?></th>
            <th><?= $tambahan?>Lembar<?= $tambahan?></th>
            <th><?= $tambahan?>Item<?= $tambahan?></th>
            <th><?= $tambahan?>Pcs<?= $tambahan?></th>
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
                <td><?= $val['DOKUMEN_PENGELUARAN']?></td>
                <td><?= $val['ITEM_PENGELUARAN']?></td>
                <td><?= $val['PCS_PENGELUARAN']?></td>
                <td><?= $val['DOKUMEN_PACKING']?></td>
                <td><?= $val['ITEM_PACKING']?></td>
                <td><?= $val['PCS_PACKING']?></td>
            </tr>
        <?php $no++; }?>
    </tbody>
</table>