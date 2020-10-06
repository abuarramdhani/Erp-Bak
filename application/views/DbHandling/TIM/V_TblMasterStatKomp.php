<div style="text-align: right;">
    <button class="btn bg-teal" onclick="tambahmasterstatkomp()">Tambah </button>
</div>
<br>
<!-- <form name="Orderform" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post"> -->

<table class="table table-bordered" id="masterstatkomp" style="width: 100%;">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Kode Status</th>
            <th class="text-center">Nama Status</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($dataa as $master) { ?>
            <tr>
                <input type="hidden" id="idstatus<?= $nomor ?>" value="<?= $master['id_status_komponen'] ?>" />
                <td class="text-center"><?= $nomor ?></td>
                <td class="text-center"><input type="hidden" id="status<?= $nomor ?>" value="<?= $master['kode_status'] ?>" /><?= $master['kode_status'] ?></td>
                <td class="text-center"><input type="hidden" id="kodestatus<?= $nomor ?>" value="<?= $master['status'] ?>" /><?= $master['status'] ?></td>
                <td class="text-center"><button class="btn btn-default btn-sm" onclick="editmasterstatkomp(<?= $master['id_status_komponen'] ?>)">Edit</button> <button class="btn btn-danger btn-sm" onclick="deletestatkomp(<?= $master['id_status_komponen'] ?>)">Delete</button></td>
            </tr>
        <?php $nomor++;
        } ?>
    </tbody>

</table>
<!-- </form> -->