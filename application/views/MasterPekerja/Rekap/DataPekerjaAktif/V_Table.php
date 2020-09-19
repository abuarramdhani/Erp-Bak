<style>
    #mpk_tbldpa tr td{
        font-size: 12px;
    }
    #mpk_tbldpa th{
        font-size: 12px;
    }
</style>
<table id="mpk_tbldpa" class="table table-bordered table-striped table-hover">
    <thead class="bg-primary">
        <th class="bg-primary">No</th>
        <th class="bg-primary">Seksi/Unit/Bidang/Dept</th>
        <th>Tetap (A)</th>
        <th>Train (E)</th>
        <th>PKL NonStaf (F)</th>
        <th>PKL Staff (Q)</th>
        <th>Kontrak (H)</th>
        <th>Tetap (B)</th>
        <th>Train (D)</th>
        <th>TKPW (G)</th>
        <th>Kontrak (J)</th>
        <th>Magang (L)</th>
        <th>OS (K/P)</th>
        <th>Cabang (C)</th>
        <th>Kontrak Khusus (T)</th>
        <th>Jumlah</th>
    </thead>
    <tbody>
        <?php foreach ($list as $k): ?>
            <tr>
                <td><?= $k['angka'] ?></td>
                <td><?= $k['txt'] ?></td>
                <td><?= $k['a'] ?></td>
                <td><?= $k['e'] ?></td>
                <td><?= $k['f'] ?></td>
                <td><?= $k['q'] ?></td>
                <td><?= $k['h'] ?></td>
                <td><?= $k['b'] ?></td>
                <td><?= $k['d'] ?></td>
                <td><?= $k['g'] ?></td>
                <td><?= $k['j'] ?></td>
                <td><?= $k['l'] ?></td>
                <td><?= $k['k'] ?></td>
                <td><?= $k['c'] ?></td>
                <td><?= $k['t'] ?></td>
                <td><?= $k['jml'] ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>