<table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
    <thead class="bg-primary">
        <tr>
            <th>No</th>
            <th>Jam</th>
            <th>Jenis Dokumen</th>
            <th>No Dokumen</th>
            <th>Jumlah Item</th>
            <th>Jumlah Pcs</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach($hasil as $val){ ?>
        <tr>
            <td style="width: 5px"><?= $no; ?></td>
            <td><input type="hidden" name="jam[]" value="<?= $val['jam']?>"><?= $val['jam']?></td>
            <td><input type="hidden" name="jenis_doc[]" value="<?= $val['jenis']?>"><?= $val['jenis']?></td>
            <td><input type="hidden" name="no_doc[]" value="<?= $val['no_dokumen']?>"><?= $val['no_dokumen']?></td>
            <td><input type="hidden" name="jml_item[]" value="<?= $val['jml_item']?>"><?= $val['jml_item']?></td>
            <td><input type="hidden" name="jml_pcs[]" value="<?= $val['jml_pcs']?>"><?= $val['jml_pcs']?></td>
            </tr>
        <?php $no++; } ?>
    </tbody>
</table>
<div class="panel-heading text-center">
    <button type="submit" class="btn btn-danger" title="save"> Save</button>
</div>