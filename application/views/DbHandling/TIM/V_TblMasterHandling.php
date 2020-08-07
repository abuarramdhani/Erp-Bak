<div style="text-align: right;">
    <button class="btn btn-success" onclick="tambahmasterhandling()">Tambah </button>
</div>
<br>
<!-- <form name="Orderform" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post"> -->

<table class="table table-bordered" id="masterhandling" style="width: 100%;">
    <thead class="bg-yellow">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Sarana Handling</th>
            <th class="text-center">Kode Handling</th>
            <th class="text-center">Action</th>


        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($masterhandling as $master) { ?>
            <tr>
                <input type="hidden" id="idhandling<?= $nomor ?>" value="<?= $master['id_master_handling'] ?>" />
                <td class="text-center"><?= $nomor ?></td>
                <td class="text-center"><input type="hidden" id="saranahandling<?= $nomor ?>" value="<?= $master['nama_handling'] ?>" /><?= $master['nama_handling'] ?></td>
                <td class="text-center"><input type="hidden" id="kodehandling<?= $nomor ?>" value="<?= $master['kode_handling'] ?>" /><?= $master['kode_handling'] ?></td>
                <td class="text-center"><button class="btn btn-default btn-sm" onclick="editmasterhandling(<?= $master['id_master_handling'] ?>)">Edit</button> <button class="btn btn-danger btn-sm" onclick="hapusmasterhandling(<?= $master['id_master_handling'] ?>)">Delete</button></td>

            </tr>
        <?php $nomor++;
        } ?>
    </tbody>

</table>
<!-- </form> -->