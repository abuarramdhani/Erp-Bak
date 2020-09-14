<table class="table table-bordered table-hover table-striped text-center" id="tb_monsimulasi" style="width: 100%;">
    <thead style="background-color:#5EC7EB">
        <tr>
            <th style="width:7%;">No</th>
            <th>Kode Item</th>
            <th>Deskripsi Item</th>
            <th>Gudang Asal</th>
            <th>Locator</th>
            <th>Unit</th>
            <th>Jumlah Yang Dibutuhkan</th>
            <th>ATT</th>
            <th>MO</th>
            <th>Stok</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data as $val) { ?>
            <tr>
                <td><?= $no?></td>
                <td><?= $val['ASSY_CODE']?></td>
                <td><?= $val['ASSY_DESC']?></td>
                <td><?= $val['GUDANG_ASAL']?></td>
                <td><?= $val['LOCATOR_ASAL']?></td>
                <td><?= $val['UOM_ASSY']?></td>
                <td><?= $val['REQUIRED_QUANTITY']?></td>
                <td><?= $val['ATT']?></td>
                <td><?= $val['MO']?></td>
                <td><?= $val['KURANG']?></td>
            </tr>
        <?php $no++;}?>
    </tbody>
</table>