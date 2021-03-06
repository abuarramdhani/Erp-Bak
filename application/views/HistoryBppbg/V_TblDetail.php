<div class="panel-body">
    <div class="row">
        <div class="col-md-4">
            <p style="float: left;">
                <img style="width: 20mm; height: auto;" src="<?php echo base_url('assets/img/bppbgQRCODE/'.$bon.'.png') ?>">
                <b>SCAN ME!!!</b>
            </p>            
        </div>
        <div class="col-md-4">
            <h5><b>Tanggal Pengebonan : </b><br><?= $bppbg[0]['TANGGAL'] ?></h5>
            <h5><b>Tujuan Gudang : </b><br><?= $bppbg[0]['TUJUAN_GUDANG'] ?></h5>            
        </div>
        <div class="col-md-4">
            <h5><b>Seksi Pengebon : </b><br><?= $bppbg[0]['SEKSI_BON'] ?></h5>
            <h5><b>Seksi Pemakai : </b><br><?= $bppbg[0]['SEKSI_PEMAKAI'] ?></h5>
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
                <th style="vertical-align: middle; width: 15%;">Keterangan</th>
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

                if ($i['KODE_BARANG'] == $item) {
                    $fw = 'font-weight: bold; font-size: 16px;';
                }
                else {
                    $fw = '';
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

                if ($i['MMT'] == 'Y' && $i['FLAG'] == 'Y') {
                    $color = '#95f576';
                }
                elseif ($i['MMT'] == 'N' && $i['FLAG'] == 'N') {
                    $color = '';
                }
                elseif ($i['MMT'] == 'Y' && $i['FLAG'] == 'N') {
                    $color = '#fae48e';
                }
                else {
                    $color = '#f06f4f';
                }
            ?>
            <tr style="background-color: <?= $color ?>; <?= $fw ?>">
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
                <td style="width: 15%;">
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