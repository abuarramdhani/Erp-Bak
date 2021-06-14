<div class="modal-header" style="font-size:25px;">
    <i class="fa fa-list-alt"></i> Edit Master Kategori
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <div class="panel-body">
        <div class="col-md-2 text-right">
            <label>Kategori:</label>
        </div>
        <div class="col-md-8">
            <input id="kategorii" class="form-control" style="text-transform:uppercase" value="<?= $kategori?>">
            <input type="hidden" id="id_kategori" value="<?= $id?>">
        </div>
    </div>
    <div class="panel-body">
        <div class="col-md-2 text-right">
            <label>Bulan:</label>
        </div>
        <div class="col-md-3">
            <?php for ($i=1; $i < 5 ; $i++) { 
                $month = explode(",", $data_kategori[0]['MONTH']);
                $cek = in_array(sprintf("%02d", $i), $month) ? 'fa-check-square-o' : 'fa-square-o';
                $cek2 = in_array(sprintf("%02d", $i), $month) ? 'Y' : 'N';
                $bulan = date('F', mktime(0, 0, 0, $i, 10))?>
                <p onclick="save_bulan(<?= $i?>, <?= $id?>)">
                    <i id="bulan<?= $i?>" class="fa <?= $cek?>"></i> <?= $bulan?>
                    <input type="hidden" id="ket_bulan<?= $i?>" value="<?= $cek2?>">
                </p>
            <?php }?>
        </div>
        <div class="col-md-3">
            <?php for ($i=5; $i < 9 ; $i++) { 
                $month = explode(",", $data_kategori[0]['MONTH']);
                $cek = in_array(sprintf("%02d", $i), $month) ? 'fa-check-square-o' : 'fa-square-o';
                $cek2 = in_array(sprintf("%02d", $i), $month) ? 'Y' : 'N';
                $bulan = date('F', mktime(0, 0, 0, $i, 10))?>
                <p onclick="save_bulan(<?= $i?>, <?= $id?>)">
                    <i id="bulan<?= $i?>" class="fa <?= $cek?>"></i> <?= $bulan?>
                    <input type="hidden" id="ket_bulan<?= $i?>" value="<?= $cek2?>">
                </p>
            <?php }?>
        </div>
        <div class="col-md-3">
            <?php for ($i=9; $i < 13 ; $i++) { 
                $month = explode(",", $data_kategori[0]['MONTH']);
                $cek = in_array(sprintf("%02d", $i), $month) ? 'fa-check-square-o' : 'fa-square-o';
                $cek2 = in_array(sprintf("%02d", $i), $month) ? 'Y' : 'N';
                $bulan = date('F', mktime(0, 0, 0, $i, 10))?>
                <p onclick="save_bulan(<?= $i?>, <?= $id?>)">
                    <i id="bulan<?= $i?>" class="fa <?= $cek?>"></i> <?= $bulan?>
                    <input type="hidden" id="ket_bulan<?= $i?>" value="<?= $cek2?>">
                </p>
            <?php }?>
        </div>
    </div>
    <div class="panel-body">
        <div>
            <div class="col-md-2 text-right"><label>Gudang:</label></div>
            <div class="col-md-4">
                <select name="gudang[]" class="form-control select2 getsubinv2" style="width:100%" data-placeholder="PILIH GUDANG">
                    <option value="<?= $gudang1?>"><?= $gudang1?></option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="gudang[]" class="form-control select2 getsubinv2" style="width:100%" data-placeholder="PILIH GUDANG">
                    <option value="<?= $gudang2?>"><?= $gudang2?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="panel-body" id="tambah_subkategori2">
        <?php foreach ($sub_kategori as $key => $sub) { ?>
        <div>
            <div class="col-md-2 text-right"><?= $key == 0 ? '<label>SubKategori:</label>' : ''; ?></div>
            <div class="col-md-8">
                <input class="form-control" style="text-transform:uppercase" value="<?= $sub['SUBCATEGORY_NAME']?>" readonly>
            </div>
            <br><br>
        </div>
        <?php }?>
        <div>
            <div class="col-md-2 text-right"><?= empty($sub_kategori) ? '<label>SubKategori:</label>' : ''; ?></div>
            <div class="col-md-8">
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