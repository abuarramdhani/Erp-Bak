<?php $tambahan = '&nbsp;&nbsp;'; ?>
<div class="table-responsive">
<table class="table table-striped table-hovered table-bordered text-center" id="tbl_jenisitem" style="width:100%">
    <thead class="text-nowrap" style="background-color:#55D3F2">
        <tr>
            <th>No</th>
            <th><?= $tambahan?>Tanggal<?= $tambahan?></th>
            <th><?= $tambahan?>No Dokumen<?= $tambahan?></th>
            <th><?= $tambahan?>Jenis Dokumen<?= $tambahan?></th>
            <th><?= $tambahan?>Jenis Item<?= $tambahan?></th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data as $key => $value) {?>
            <tr>
                <td><?= $no?></td>
                <td><?= $value['JAM_INPUT']?></td>
                <td><?= $value['NO_DOKUMEN']?></td>
                <td><?= $value['JENIS_DOKUMEN']?></td>
                <td><?= $value['FINAL']?></td>
            </tr>
        <?php $no++; }?>
    </tbody>
</table>
</div>