<div class="panel-body">
    <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
        <thead style="background-color:#4698DB;color:white">
            <tr>
                <th>No</th>
                <th>No Dokumen</th>
                <th>Gudang</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>PIC</th>
                <th>Status</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($value as $i) {?>
            <tr>
                <td><?= $no?>
                    <input type="hidden" id="no_dokumen<?= $no?>">
                </td>
                <td><?= $i['header']['NO_DOKUMEN'] ?></td>
                <td><?= $i['header']['GUDANG'] ?></td>
                <td><?= $i['header']['JAM_MULAI'] ?></td>
                <td><?= $i['header']['JAM_SELESAI'] ?></td>
                <td><?= $i['header']['PIC'] ?></td>
                <td><?= $i['header']['statusket'] ?></td>
                <td><button class="btn btn-sm btn-success" onclick="addDetailKGP(<?= $no?>)">Detail</button></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="7">
                    <div id="detail<?= $no?>" style="display:none">
                    <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
                    <thead style="background-color:#63E6D0;color:black">
                            <tr>
                                <th>No</th>
                                <th>Kode Item</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no2 = 1; foreach ($i['detail'] as $v) {?>
                            <tr>
                                <td><?= $no2?>
                                    <input type="hidden" id="kode_item_<?= $no?>_<?= $no2?>">
                                </td>
                                <td><?= $v['KODE_ITEM'] ?></td>
                                <td style="text-align:left"><?= $v['DESCRIPTION'] ?></td>
                                <td><?= $v['QUANTITY'] ?></td>
                                <td><?= $v['STATUS'] ?></td>
                            </tr>
                            <?php $no2++; }?>
                        </tbody>
                    </table>
                    </div>
                </td>
            </tr>
            <?php $no++; }?>
        </tbody>
    </table>
</div>