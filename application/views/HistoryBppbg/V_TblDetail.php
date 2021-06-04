<div class="panel-body">
    <p style="float: left;">
        <img style="width: 20mm; height: auto;" src="<?php echo base_url('assets/img/bppbgQRCODE/'.$bon.'.png') ?>">
        <b>SCAN ME!!!</b>
    </p>
    <br>
    <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
        <thead style="background-color:#6ACEF0">
            <tr>
                <th style="vertical-align: middle; width: 5%;">No</th>
                <th style="vertical-align: middle;">Kode Barang</th>
                <th style="vertical-align: middle;">Deskripsi</th>
                <th style="vertical-align: middle;">Seksi Pengebon</th>
                <th style="vertical-align: middle; width: 8%;">Permintaan</th>
                <th style="vertical-align: middle; width: 5%;">Tanggal Pembuatan Bppbg</th>
                <th style="vertical-align: middle; width: 14%;">Keterangan</th>
                <th style="vertical-align: middle; width: 5%;">Status Transact</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach ($bppbg as $i) { ?>
            <?php 
                if ($i['FLAG'] == 'Y') {
                    $style = 'color: green;';
                    $icon = '<i class="fa fa-check"></i>';
                    $color = '#95f576';
                }
                else {
                    $style = 'color: red;';
                    $icon = '<i class="fa fa-close"></i>';
                    $color = '#f06f4f';
                }

                if ($i['KODE_BARANG'] == $item) {
                    $fw = 'font-weight: bold; font-size: 16px;';
                }
                else {
                    $fw = '';
                }
            ?>
            <tr style="background-color: <?= $color ?>; <?= $fw ?>">
                <td style="width: 5%;"><?= $no; ?></td>
                <td><?= $i['KODE_BARANG'] ?></td>
                <td style="text-align:left;"><?= $i['NAMA_BARANG'] ?></td>
                <td><?= $i['SEKSI_BON'] ?></td>
                <td style="width: 8%;"><?= $i['PERMINTAAN'].'  '.$i['SATUAN'] ?></td>
                <td style="width: 10%;"><?= $i['TANGGAL'] ?></td>
                <td style="width: 14%;"><?= $i['KETERANGAN'] ?></td>
                <td style="width: 5%; <?= $style ?>"><?= $icon ?></td>
            </tr>
            <?php $no++;} ?>
        </tbody>
    </table>
</div>