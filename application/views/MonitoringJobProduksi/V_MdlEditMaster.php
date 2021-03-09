<div class="modal-header" style="font-size:25px;background-color:#63E1EB">
    <i class="fa fa-list-alt"></i> Edit Master Kategori
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <div class="panel-body">
        <div class="col-md-3 text-right">
            <label>Kategori:</label>
        </div>
        <div class="col-md-6">
            <input id="kategori" class="form-control" style="text-transform:uppercase" value="<?= $kategori?>">
            <input type="hidden" id="id_kategori" value="<?= $id?>">
        </div>
    </div>
    <div class="panel-body" id="tambah_subkategori2">
        <?php foreach ($sub_kategori as $key => $sub) { ?>
        <div>
            <div class="col-md-3 text-right"><?= $key == 0 ? '<label>SubKategori:</label>' : ''; ?></div>
            <div class="col-md-6">
                <input class="form-control" style="text-transform:uppercase" value="<?= $sub['SUBCATEGORY_NAME']?>" readonly>
            </div>
            <br><br>
        </div>
        <?php }?>
        <div>
            <div class="col-md-3 text-right"><?= empty($sub_kategori) ? '<label>SubKategori:</label>' : ''; ?></div>
            <div class="col-md-6">
                <input name="sub_kategori2[]" class="form-control" style="text-transform:uppercase" placeholder="Masukkan SubKategori">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn bg-default" style="margin-left:15px" onclick="tmb_subkategori2()"><i class="fa fa-plus"></i></button>
            </div>
        <br><br>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-md-12 text-center">
            <button type="button" class="btn bg-orange" style="margin-left:15px" onclick="updateCategory(this)"><i class="fa fa-check"></i> Save</button>
        </div>
    </div>
</div>