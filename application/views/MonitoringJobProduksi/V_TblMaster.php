<table class="table table-bordered table-hover table-striped text-center" id="tb_master_ctgr" style="width: 100%;">
    <thead style="background-color:#63E1EB">
        <tr class="text-nowrap">
            <th style="width:7%;">No</th>
            <th>Kategori</th>
            <th style="width:15%;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data as $key => $value) {?>
        <tr>
            <td><input type="hidden" id="id_kategori<?= $no?>" value="<?= $value['ID_CATEGORY']?>"><?= $no?></td>
            <td><input type="hidden" id="kategori<?= $no?>" value="<?= $value['CATEGORY_NAME']?>"><?= $value['CATEGORY_NAME']?></td>
            <td><button class="btn btn-danger" onclick="deletecategory(<?= $no?>)"><i class="fa fa-trash"></i></td>
        </tr>
        <?php $no++; }?>
    </tbody>
</table>