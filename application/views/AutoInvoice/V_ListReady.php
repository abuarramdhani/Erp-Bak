<div class="panel-body">
    <div class="col-md-12">
        <table class="table table-bordered" id="tbl_Ready_To_Ship_Confirm">
            <thead class="bg-teal">
                <tr>
                    <th class="text-center"><input type="checkbox" class="PilihSemuaReady"></th>
                    <th class="text-center">NO DO</th>
                    <th class="text-center">NO SPB</th>
                    <th class="text-center">SO NUMBER</th>
                    <th class="text-center">OU</th>
                    <th class="text-center">ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php $angka = 1;
                foreach ($DoReady as $key => $red) { ?>
                    <tr>
                        <td class="text-center"><input type="checkbox" class="daftarReady" id="daftarReady<?= $angka ?>" data-row="<?= $angka ?>" /></td>
                        <td class="text-center"><input type="hidden" class="nom_DO" data-row="<?= $angka ?>" id="nom_DO<?= $angka ?>" value="<?= $red['NO_DO'] ?>" /><?= $red['NO_DO'] ?></td>
                        <td class="text-center"><input type="hidden" class="nom_SPB" data-row="<?= $angka ?>" id="nom_SPB<?= $angka ?>" value="<?= $red['NO_SPB'] ?>" /><?= $red['NO_SPB'] ?></td>
                        <td class="text-center"><input type="hidden" class="nom_SO" data-row="<?= $angka ?>" id="nom_SO<?= $angka ?>" value="<?= $red['SO_NUMBER'] ?>" /><?= $red['SO_NUMBER'] ?></td>
                        <td class="text-center"><input type="hidden" class="ou_DO" data-row="<?= $angka ?>" id="ou_DO<?= $angka ?>" value="<?= $red['OU'] ?>" /><?= $red['OU'] ?></td>
                        <td class="text-center"><button class="btn btn-default btn-sm" onclick="DetDo(<?= $red['NO_DO'] ?>)">Detail</button></td>
                    </tr>
                <?php $angka++;
                } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-1">
        <label>Action</label>
    </div>
    <div class="col-md-3">
        <select class="form-control select2 slcProcesShip" data-placeholder="Select" style="width:100%">
            <option></option>
            <option value="P">Process</option>
        </select>
    </div>
    <div class="col-md-1" style="text-align: left;">
        <button class="btn btn-success ProcessShipConfirm" onclick="ProcessShipConfirm()">OK</button>
    </div>
    <div class="col-md-2 loading_process" style="text-align: left;"></div>
</div>