<!-- Table Data -->

<table id="DataNamaAktif" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>No Induk</th>
            <th>Nama</th>
            <th>Departemen</th>
            <th>Bidang</th>
            <th>Unit</th>
            <th>Seksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($FilterAktif as $key => $val) :
            ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $val['noind']; ?></td>
                <td><?= $val['nama']; ?></td>
                <td><?= $val['dept']; ?></td>
                <td><?= $val['bidang']; ?></td>
                <td><?= $val['unit']; ?></td>
                <td><?= $val['seksi']; ?></td>

            </tr>
        <?php endforeach; ?>
</table>