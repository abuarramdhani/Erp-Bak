<div class="box box-info box-solid">
    <div class="panel-body">
        <div class="col-md-1">
            <label>Item :</label>
        </div>
        <div class="col-md-4">
            <select id="kode_item" class="form-control select2 kodeitem" style="width:100%" data-placeholder="pilih Item"></select>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn bg-orange" style="margin-left:15px" onclick="tambahItemList(this)"><i class="fa fa-plus"></i> Tambah</button>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-hover table-striped text-center" id="tb_itemlist" style="width: 100%;">
            <thead style="background-color:#5FEBC4">
                <tr class="text-nowrap">
                    <th style="width:7%;">No</th>
                    <th style="width:7%;"><button type="button" class="btn btn-xs" style="background-color:inherit" onclick="updateflagAll()"><i id="btn_check_all" style="font-size:15px" class="fa fa-square-o"></i></button>
                        <input type="hidden" id="flag_all"></th>
                    <th>Kode Item</th>
                    <th>Deskripsi Item</th>
                    <th style="width:15%;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($data as $key => $val) {
                $check = $val['FLAG'] == 'Y' ? ' fa-check-square-o' : 'fa-square-o';   
                ?>
                <tr>
                    <td><?= $no?>
                        <input type="hidden" id="inv_id<?= $no?>" value="<?= $val['INVENTORY_ITEM_ID']?>">
                        <input type="hidden" id="kategori<?= $no?>" value="<?= $val['CATEGORY_NAME']?>">
                        <input type="hidden" id="subkategori<?= $no?>" value="<?= $val['ID_SUBCATEGORY']?>">
                        <input type="hidden" id="flag<?= $no?>" class="flag_all" value="<?= $val['FLAG']?>">
                    </td>
                    <td><button type="button" class="btn btn-xs" style="background-color:inherit" onclick="updateflag(<?= $no?>)"><i id="btn_check<?= $no?>" style="font-size:15px" class="fa <?= $check?> check_all"></i></button></td>
                    <td><input type="hidden" id="item<?= $no?>" value="<?= $val['ITEM']?>"><?= $val['ITEM']?></td>
                    <td><?= $val['DESKRIPSI']?></td>
                    <td><button class="btn btn-danger" onclick="deleteitemList(<?= $no?>)"><i class="fa fa-trash"></i></td>
                </tr>
                <?php $no++; }?>
            </tbody>
        </table>
    </div>
</div>