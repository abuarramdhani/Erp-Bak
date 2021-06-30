<table class="table table-bordered table-hover table-striped tblListBarangDPS">
    <thead>
        <tr>
            <th>Line Number</th>
            <th>Kode Barang</th>
            <th>Deskripsi</th>
            <th>Quantity</th>
            <th>Quantity Allocate</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detail_dpb as $key => $detail) { ?>
            <tr>
                <td><?= $detail['LINE_NUMBER']; ?></td>
                <td><?= $detail['KODE_BARANG']; ?></td>
                <td><?= $detail['DESCRIPTION']; ?></td>
                <td><?= $detail['QUANTITY']; ?></td>
                <td><?= $detail['QUANTITY_ALLOCATE']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>