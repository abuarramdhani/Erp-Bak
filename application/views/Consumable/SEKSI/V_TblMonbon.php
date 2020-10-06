<table class="table table-bordered">
    <thead class="bg-teal">
        <tr>
            <th class="text-center">Nomor Bon</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Seksi Pengebon</th>
            <th class="text-center">Gudang</th>
            <th class="text-center">Ket</th>
            <th class="text-center">Detail</th>
            <th class="text-center">Cetak Bon</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($monbon as $key => $value) { ?>
            <tr>
                <td class="text-center"><?= $value['NO_BON'] ?></td>
                <td class="text-center"><?= $value['TANGGAL'] ?></td>
                <td class="text-center"><?= $value['SEKSI_BON'] ?></td>
                <td class="text-center"><?= $value['TUJUAN_GUDANG'] ?></td>
                <td class="text-center"><?= $value['KETERANGAN'] ?></td>
                <td class="text-center"><button class="btn btn-info btn-sm" onclick="showdetailbon(this, <?= $value['NO_BON'] ?>)">Lihat</button></td>
                <td class="text-center loadingpprint<?= $value['NO_BON'] ?>"><button class="btn btn-success btn-sm" onclick="printulangkartubon(<?= $value['NO_BON'] ?>)">Print</button></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="6">
                    <div id="det<?= $value['NO_BON'] ?>" style="display:none">
                        <table class="table table-bordered">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center">Item</th>
                                    <th class="text-center">Desc</th>
                                    <th class="text-center">Diminta</th>
                                    <th class="text-center">Diserahkan</th>
                                    <th class="text-center">Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($value['detail'] as $key => $value) { ?>
                                    <tr>
                                        <td class="text-center"><?= $value['KODE_BARANG'] ?></td>
                                        <td class="text-center"><?= $value['NAMA_BARANG'] ?></td>
                                        <td class="text-center"><?= $value['PERMINTAAN'] ?></td>
                                        <td class="text-center"><?= $value['PENYERAHAN'] ?></td>
                                        <td class="text-center"><?= $value['FLAG'] ?></td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>