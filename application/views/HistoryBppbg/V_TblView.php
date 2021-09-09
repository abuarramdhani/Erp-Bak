<div class="panel-body">
    <div class="row">
        <div class="col-md-3">
            <label>Tanggal Pengebonan : </label><h5><?= $bppbg[0]['TANGGAL'] ?></h5>
        </div>
        <div class="col-md-3">
            <label>Tujuan Gudang : </label><h5><?= $bppbg[0]['TUJUAN_GUDANG'] ?></h5>          
        </div>
        <div class="col-md-3">
            <label>Seksi Pengebon : </label><h5><?= $bppbg[0]['SEKSI_BON'] ?></h5>            
        </div>
        <div class="col-md-3">
            <label>Seksi Pemakai : </label><h5><?= $bppbg[0]['SEKSI_PEMAKAI'] ?></h5>            
        </div>
    </div>
    <br>
    <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
        <thead style="background-color:#6ACEF0">
            <tr>
                <th style="vertical-align: middle; width: 5%;">No</th>
                <th style="vertical-align: middle;">Kode Barang</th>
                <th style="vertical-align: middle;">Deskripsi</th>
                <th style="vertical-align: middle; width: 5%;">Permintaan</th>
                <th style="vertical-align: middle; width: 5%;">Penyerahan</th>
                <th style="vertical-align: middle; width: 5%;">UOM</th>
                <th style="vertical-align: middle; width: 5%;">Branch</th>
                <th style="vertical-align: middle; width: 5%;">Account</th>
                <th style="vertical-align: middle; width: 5%;">Cost Center</th>
                <th style="vertical-align: middle; width: 10%;">Keterangan</th>
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
                }
                else {
                    $style2 = 'color: red;';
                    $icon2 = '<i class="fa fa-close"></i>';
                }

                if ($i['MTI'] == 'Y') {
                    $style3 = 'color: green;';
                    $icon3 = '<i class="fa fa-check"></i>';
                }
                else {
                    $style3 = 'color: red;';
                    $icon3 = '<i class="fa fa-close"></i>';
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
                    <?= $i['PERMINTAAN'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['PENYERAHAN'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['SATUAN'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['KODE_CABANG'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['ACCOUNT'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['COST_CENTER'] ?>
                </td>
                <td style="width: 10%;">
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