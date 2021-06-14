<div class="col-md-12">
    <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;table-layout:fixed">
        <thead class="bg-info">
            <tr>
                <th rowspan="2" style="width:5%;">No</th>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">Jumlah Lembar</th>
                <th rowspan="2">Jumlah Pcs</th>
                <th colspan="2">Status / lembar</th>
                <th rowspan="2">Asal</th>
            </tr>
            <tr>
                <th>Sudah Terlayani / Sudah Input</th>
                <th>Belum Terlayani / Belum Input</th>
            </tr>
        </thead>
        <tbody>
        <?php $num=1; $i=0; foreach($hasil as $val){ 
        if ($val['masuk'] != '0') {
        ?>
            <tr>
                <td><?= $num?></td>
                <td><?= $val['tanggal']?></td>
                <td><?= $val['masuk']?></td>
                <td><?= $val['pcs'] ?></td>
                <td><?= $val['sudah'] ?></td>
                <td><?= $val['belum']?></td>
                <td><button type="button" class="btn btn-success" onclick="adddrekap2(<?= $num?>)"> Detail</button></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="6">
                    <div id="drekapmgs<?= $num?>" style="display:none">
                        <table class="datatable table table-bordered table-hover table-striped text-center" style="width: 100%;table-layout:fixed">
                            <thead class="bg-success">
                                <tr>
                                    <th rowspan="2">Asal Gudang</th>
                                    <th colspan="2">Sudah Terlayani / Sudah Input</th>
                                    <th colspan="2">Belum Terlayani / Belum Input</th>
                                </tr>
                                <tr>
                                    <th>Item</th>
                                    <th>Pcs</th>
                                    <th>Item</th>
                                    <th>Pcs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($val['asal'] as $key => $val2) { ?>
                                <tr>
                                    <td><?= $key?>
                                        <input type="hidden" name="tanggal[]" value="<?= $val['tanggal']?>">
                                        <input type="hidden" name="asal[]" value="<?= $key?>">
                                        <input type="hidden" name="lembar_belum[]" value="<?= $val2['lembar_belum']?>">
                                        <input type="hidden" name="lembar_sudah[]" value="<?= $val2['lembar_sudah']?>">
                                    </td>
                                    <td><input type="hidden" name="item_sudah[]" value="<?= $val2['sudah']?>"><?= $val2['sudah']?></td>
                                    <td><input type="hidden" name="pcs_sudah[]" value="<?= $val2['pcs_sudah']?>"><?= $val2['pcs_sudah']?></td>
                                    <td><input type="hidden" name="item_belum[]" value="<?= $val2['belum']?>"><?= $val2['belum'] ?></td>
                                    <td><input type="hidden" name="pcs_belum[]" value="<?= $val2['pcs_belum']?>"><?= $val2['pcs_belum']?></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            <?php $num++; $i++; } } ?>
        </tbody>
    </table>
</div>

<div class="col-md-12 text-right">
    <button type="submit" class="btn btn-lg btn-warning"><i class="fa fa-download"> Download</i></button>
</div>