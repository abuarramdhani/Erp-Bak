<div class="panel-body">
    <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
        <thead style="background-color:#6ACEF0">
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Deskripsi</th>
                <th>Account</th>
                <th>Cost Center</th>
                <th>Seksi Pengebon</th>
                <th>Seksi Pemakai</th>
                <th>Gudang</th>
                <th>Tanggal Pembuatan Bppbg</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach ($bppbg as $i) { ?>
            <tr>
                <td><?= $no; ?></td>
                <td><?= $i['KODE_BARANG'] ?></td>
                <td style="text-align:left;"><?= $i['NAMA_BARANG'] ?></td>
                <td><?= $i['ACCOUNT'] ?></td>
                <td><?= $i['COST_CENTER'] ?></td>
                <td><?= $i['SEKSI_BON'] ?></td>
                <td><?= $i['PEMAKAI'] ?></td>
                <td><?= $i['TUJUAN_GUDANG'] ?></td>
                <td><?= $i['TANGGAL'] ?></td>
            <tr>
            <?php $no++;} ?>
        </tbody>
    </table>
</div>