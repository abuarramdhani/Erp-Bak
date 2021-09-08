<table class="datatable table table-bordered table-hover table-striped text-center" id="tb_mesin" style="width: 100%">
    <thead class="bg-primary">
        <tr>
            <th style="width: 5%">No</th>
            <th>Proses</th>
            <th style="width: 15%">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($data as $key => $val) { ?>
        <tr>
            <td><?= $no?></td>
            <td><?= $val['nama_mesin']?></td>
            <td>
                <button type="button" class="btn btn-info" onclick="edit_mesin_otm(<?= $val['id_mesin']?>, '<?= $val['nama_mesin']?>')"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger" onclick="delete_mesin_otm(<?= $val['id_mesin']?>)"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
    <?php $no++; }?>
    </tbody>
</table>