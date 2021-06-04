<div class="panel-body">
    <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
        <thead style="background-color:#6ACEF0">
            <tr>
                <th style="vertical-align: middle; width: 5%;">No</th>
                <th style="vertical-align: middle;">Kode Barang</th>
                <th style="vertical-align: middle;">Deskripsi</th>
                <th style="vertical-align: middle; width: 5%;">Account</th>
                <th style="vertical-align: middle; width: 5%;">Cost Center</th>
                <th style="vertical-align: middle;">Seksi Pengebon</th>
                <th style="vertical-align: middle; width: 15%;">Seksi Pemakai</th>
                <th style="vertical-align: middle; width: 8%;">Gudang</th>
                <th style="vertical-align: middle; width: 5%;">Tanggal Pembuatan Bppbg</th>
                <th style="vertical-align: middle; width: 14%;">Keterangan</th>
                <th style="vertical-align: middle; width: 5%;">Transact Android</th>
                <th style="vertical-align: middle; width: 5%;">Material Transaction</th>
                <th style="vertical-align: middle; width: 5%;">MTI</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach ($bppbg as $i) { ?>
            <?php 
                if ($i['FLAG'] == 'Y') {
                    $style = 'color: green;';
                    $icon = '<i class="fa fa-check"></i>';
                }
                else {
                    $style = 'color: red;';
                    $icon = '<i class="fa fa-close"></i>';
                }

                if ($i['MMT'] == 'Y') {
                    $style2 = 'color: green;';
                    $icon2 = '<i class="fa fa-check"></i>';
                    // $color = '#95f576';
                }
                else {
                    $style2 = 'color: red;';
                    $icon2 = '<i class="fa fa-close"></i>';
                    // $color = '#f06f4f';
                }

                if ($i['MTI'] == 'Y') {
                    $style3 = 'color: green;';
                    $icon3 = '<i class="fa fa-check"></i>';
                    // $color = '#95f576';
                }
                else {
                    $style3 = 'color: red;';
                    $icon3 = '<i class="fa fa-close"></i>';
                    // $color = '#f06f4f';
                }
            ?>
            <tr>
                <td style="width: 5%;">
                    <?= $no; ?>
                </td>
                <td>
                    <?= $i['KODE_BARANG'] ?>
                </td>
                <td style="text-align:left;">
                    <?= $i['NAMA_BARANG'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['ACCOUNT'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['COST_CENTER'] ?>
                </td>
                <td>
                    <?= $i['SEKSI_BON'] ?>
                </td>
                <td style="width: 15%;">
                    <?= $i['SEKSI_PEMAKAI'] ?>
                </td>
                <td style="width: 8%;">
                    <?= $i['TUJUAN_GUDANG'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['TANGGAL'] ?>
                </td>
                <td style="width: 14%;">
                    <?= $i['KETERANGAN'] ?>
                </td>
                <td style="width: 5%; <?= $style ?>">
                    <?= $icon ?>
                </td>
                <td style="width: 5%; <?= $style2 ?>">
                    <?= $icon2 ?>
                </td>
                <td style="width: 5%; <?= $style3 ?>">
                    <?= $icon3 ?>
                </td>
            </tr>
            <?php $no++;} ?>
        </tbody>
    </table>
</div>