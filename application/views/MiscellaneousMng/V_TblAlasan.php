<table class="datatable table table-bordered table-hover table-striped text-center" id="tbl_req" style="width: 100%;">
    <thead class="bg-orange">
    <tr>
        <th style="width: 7%">No</th>
        <th>Alasan</th>
        <th style="width: 17%">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($data as $val) {
    ?>
        <tr>
            <td><?= $no?>
                <input type="hidden" id="id<?= $no?>" name="id<?= $no?>" value="<?= $val['id']?>">
            </td>
            <td class="text-nowrap" style="text-align:left"><?= $val['alasan']?></td>
            <td><button class="btn btn-sm btn-danger" onclick="delAlasan(<?= $no?>)"><i class="fa fa-trash"></i></button></td>
        </tr>
    <?php $no++; }?>
    </tbody>
</table>