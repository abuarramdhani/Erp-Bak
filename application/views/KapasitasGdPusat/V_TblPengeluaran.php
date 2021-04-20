<?php if (!empty($ket)) { ?>
    <div class="panel-body" style="margin-left:-10px">
        <div class="col-md-12 text-center">
            <label>No Dokumen sudah pernah di input !</label>
        </div>
    </div>
<?php }else{?>
    <div class="panel-body" style="margin-left:-10px">
        <div class="col-md-3">
            <label>Jenis Dokumen :</label>
            <input id="jenis_dokumen" name="jenis_dokumen" class="form-control" readonly>
        </div>
    </div>
    <div class="panel-body">
        <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
            <thead style="background-color:#6ACEF0">
                <tr>
                    <th>No</th>
                    <th>Kode Item</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach ($cek as $i) { ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><input type="hidden" name="item[]" value="<?= $i['KODE_ITEM'] ?>"/><?= $i['KODE_ITEM'] ?></td>
                    <td style="text-align:left;"><input type="hidden" name="desc[]" value="<?= $i['DESCRIPTION'] ?>"/><?= $i['DESCRIPTION'] ?></td>
                    <td><input type="hidden" name="qty[]" value="<?= $i['QUANTITY'] ?>"/><?= $i['QUANTITY'] ?></td>
                <tr>
                <?php $no++;} ?>
            </tbody>
        </table>
    </div>
    <div class="panel-body text-center">
        <button class="btn btn-info" style="color:black"><i class="fa fa-spinner"></i> INPUT</button>
    </div>
<?php }?>
