<?php
$action = ($user == 'B0901' || $user == 'T0016') ? '' : "display:none";
?>
<div class="table-responsive">
    <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable">
        <thead class="bg-success text-nowrap">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th style="width:200px">Nama Peminjam</th>
                <th style="width:200px">Seksi</th>
                <th>Kode Barang</th>
                <th style="width:300px">Nama Barang</th>
                <th>Qty</th>
                <th style="width:300px">Alasan</th>
                <th>PIC</th>
                <th style="width:80px">Status</th>
                <th style="<?= $action?>">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($data as $key => $val) {
            $action2 = ($user == 'B0901' || $user == 'T0016') && $val['STATUS'] == 0 ? '' : "display:none";
            ?>
            <tr>
                <td><input type="hidden" id="id_peminjam<?= $no?>" value="<?= $val['ID_PEMINJAMAN']?>"><?= $no?></td>
                <td><?= $val['CREATION_DATE']?></td>
                <td><?= $val['NAMA_PEMINJAM']?> - <?= $val['NAMANYA']?></td>
                <td><?= $val['SEKSI_PEMINJAM']?></td>
                <td><?= $val['ITEM']?></td>
                <td style="text-align:left"><?= $val['DESKRIPSI']?></td>
                <td><?= $val['QTY']?></td>
                <td style="text-align:left"><?= $val['ALASAN']?></td>
                <td><?= $val['PIC']?></td>
                <td><?= $val['STATUS'] == 0 ? 'Belum Diterima' : 'Sudah Diterima'; ?></td>
                <td style="<?= $action?>">
                    <button type="button" class="btn btn-xs bg-orange" style="<?= $action2?>" onclick="terima_pinjaman(<?= $no?>)">Terima</button>
                </td>
            </tr>
            <?php $no++; }?>
        </tbody>
    </table>
</div>