<table class="table table-bordered table-hover table-striped text-center" id="tb_user_mng" style="width: 100%;">
    <thead style="background-color:#63E1EB">
        <tr class="text-nowrap">
            <th style="width:7%;">No</th>
            <th>User</th>
            <th>Jenis</th>
            <th style="width:15%;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data as $key => $value) {?>
        <tr>
            <td><?= $no?>
                <input type="hidden" id="noind<?= $no?>" value="<?= $value['NO_INDUK']?>">
                <input type="hidden" id="nama<?= $no?>" value="<?= $value['NAMA']?>">
                <input type="hidden" id="jenis<?= $no?>" value="<?= $value['JENIS']?>">
            </td>
            <td><?= $value['NO_INDUK']?> - <?= $value['NAMA']?></td>
            <td><?= $value['JENIS']?></td>
            <td><button class="btn btn-info" onclick="editUser(<?= $no?>)"><i class="fa fa-pencil"></i>
                <button class="btn btn-danger" onclick="deleteUser(<?= $no?>)" style="margin-left:10px"><i class="fa fa-trash"></i></td>
        </tr>
        <?php $no++; }?>
    </tbody>
</table>