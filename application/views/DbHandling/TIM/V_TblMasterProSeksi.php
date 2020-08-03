<div style="text-align: right;">
    <button class="btn btn-warning" onclick="tambahmasterprosesseksi()">Tambah </button>
</div>
<br>
<!-- <form name="Orderform" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post"> -->

<table class="table table-bordered" id="masterprosesseksi" style="width: 100%;">
    <thead class="bg-red">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Identitas</th>
            <th class="text-center">Warna</th>
            <th class="text-center">Seksi</th>
            <th class="text-center">Action</th>


        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($masterproseksi as $seksi) {
            if ($seksi['identitas_seksi'] == 'Machining') {
                $bg = '#ffff00';
                $cl = '#ffff00';
            } else if ($seksi['identitas_seksi'] == 'Gudang') {
                $bg = '#cccccc';
                $cl = '#cccccc';
            } else if ($seksi['identitas_seksi'] == 'PnP') {
                $bg = '#ff8080';
                $cl = '#ff8080';
            } else if ($seksi['identitas_seksi'] == 'Sheet Metal') {
                $bg = '#94bd5e';
                $cl = '#94bd5e';
            } else if ($seksi['identitas_seksi'] == 'UPPL') {
                $bg = '#ff00ff';
                $cl = '#ff00ff';
            } else if ($seksi['identitas_seksi'] == 'Perakitan') {
                $bg = '#99ccff';
                $cl = '#99ccff';
            } else if ($seksi['identitas_seksi'] == 'Subkon') {
                $bg = '#ffcc99';
                $cl = '#ffcc99';
            } ?>
            <tr>
                <td class="text-center"><?= $no ?></td>
                <td class="text-center"><?= $seksi['identitas_seksi'] ?></td>
                <td class="text-center">
                    <div style="margin:3px;background-color:<?= $bg ?>;color:<?= $cl ?>">a</div>
                </td>
                <td class="text-center"><?= $seksi['seksi'] ?></td>
                <td class="text-center"><button class="btn btn-default btn-sm" onclick="editmasterprosesseksi(<?= $seksi['id_proses_seksi'] ?>)">Edit</button> <button class="btn btn-danger btn-sm" onclick="hapusmasterprosesseksi(<?= $seksi['id_proses_seksi'] ?>)">Delete</button></td>

            </tr>
        <?php $no++;
        } ?>
    </tbody>

</table>
<!-- </form> -->