<table class="datatable table table-bordered table-hover table-striped text-center text-nowrap" id="tblcutting" style="width: 100%;">
    <thead class="bg-success">
    <tr>
        <th rowspan="3" style="vertical-align:middle;">No</th>
        <th rowspan="3" style="vertical-align:middle;">Item</th>
        <th rowspan="3" style="vertical-align:middle;">Description</th>
        <th colspan="2" style="vertical-align:middle;">Stok</th>
        <th colspan="3" style="vertical-align:middle;">Onhand TR-TKS</th>
        <th colspan="6" style="vertical-align:middle;">Rata-Rata Transaksi Per Bulan</th>
        <th rowspan="3" style="vertical-align:middle;">Outstanding</th>
        <th rowspan="3" style="vertical-align:middle;">MOQ</th>
        <th rowspan="3" style="vertical-align:middle;">Lead Time PP</th>
        <th rowspan="3" style="vertical-align:middle;">Keterangan</th>
    </tr>
    <tr>
        <th rowspan="2" style="vertical-align:middle;">Min</th>
        <th rowspan="2" style="vertical-align:middle;">Max</th>
        <th rowspan="2" style="vertical-align:middle;">Baru</th>
        <th rowspan="2" style="vertical-align:middle;">Resharp</th>
        <th rowspan="2" style="vertical-align:middle;">Tumpul</th>
        <th colspan="2" style="vertical-align:middle;" class="bg-info">Baru</th>
        <th colspan="2" style="vertical-align:middle;" class="bg-danger">Resharp</th>
        <th colspan="2" style="vertical-align:middle;" class="bg-warning">Tumpul</th>
    </tr>
    <tr>
        <th class="bg-info">IN</th>
        <th class="bg-info">OUT</th>
        <th class="bg-danger">IN</th>
        <th class="bg-danger">OUT</th>
        <th class="bg-warning">IN</th>
        <th class="bg-warning">OUT</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($data as $val) {?>
        <tr>
            <td><?= $no?></td>
            <td><?= $val['ITEM']?></td>
            <td><?= $val['DESCRIPTION']?></td>
            <td><?= $val['MIN']?></td>
            <td><?= $val['MAX']?></td>
            <td><?= $val['TKS_N']?></td>
            <td><?= $val['TKS_R']?></td>
            <td><?= $val['TKS_T']?></td>
            <td><?= $val['RATA_BARU_IN']?></td>
            <td><?= $val['RATA_BARU_OUT']?></td>
            <td><?= $val['RATA_RESHARP_IN']?></td>
            <td><?= $val['RATA_RESHARP_OUT']?></td>
            <td><?= $val['RATA_TUMPUL_IN']?></td>
            <td><?= $val['RATA_TUMPUL_OUT']?></td>
            <td><?= $val['OUTSTANDING']?></td>
            <td><?= $val['MOQ']?></td>
            <td><?= $val['LEADTIME']?></td>
            <td></td>
        </tr>
    <?php $no++; }?>
    </tbody>
</table>