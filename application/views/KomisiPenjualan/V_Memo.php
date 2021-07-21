<?php foreach ($dataSheet as $key => $data) {
    if ($data['keterangan'] == 'TRANSFER') {
        $title = 'TRANSFER';
    } else {
        $title = 'POTONG PIUTANG';
    }
    if ($key != 0) {
        $pagebreak = '<pagebreak></pagebreak>';
    } else {
        $pagebreak = '';
    }
?>
    <?= $pagebreak ?>
    <table style="width:100%;font-size:8pt;font-family:Arial, Helvetica, sans-serif;border: 0.2px solid black;border-collapse:collapse">
        <tr>
            <th style="border: 0.2px solid black;border-collapse:collapse;width:50%;border-right:none" rowspan="3">
                <span style="font-size: 14pt;">MEMO</span>
                <br>
                <?= $title ?> ATAS KOMISI
            </th>
            <th rowspan="3" style="border: 0.2px solid black;border-collapse:collapse;width:10%;border-left:none">
                <img style="height: auto;width:50px" src="<?= base_url('/assets/upload/KomisiPenjualan/Memo' . $data['nomor_urut'] . '.png') ?>">
                <br>
                <span style="font-size:6pt;font-family:Arial, Helvetica, sans-serif;"><?= $data['nomor_memo'] ?></span>
            </th>
            <th style="border: 0.2px solid black;border-collapse:collapse;text-align:left;padding-left:5px">Program</th>
            <th style="border: 0.2px solid black;border-collapse:collapse;text-align:left;padding-left:5px">: <?= $data['program'] ?></th>
        </tr>
        <tr>
            <th style="border: 0.2px solid black;border-collapse:collapse;text-align:left;padding-left:5px">No</th>

            <th style="border: 0.2px solid black;border-collapse:collapse;text-align:left;padding-left:5px">: <?= $data['nomor_memo'] ?></th>

        </tr>
        <tr>
            <th style="border: 0.2px solid black;border-collapse:collapse;text-align:left;padding-left:5px">Tanggal</th>

            <th style="border: 0.2px solid black;border-collapse:collapse;text-align:left;padding-left:5px">: <?= $data['tanggal_memo'] ?></th>

        </tr>
    </table>
    <table style="width:100%;font-size:8pt;font-family:Arial, Helvetica, sans-serif;margin-top:10px">
        <tr>
            <td colspan="4">Dengan Hormat,</td>
        </tr>
        <tr>
            <td colspan="4">Mohon untuk proses <span style="font-weight: bold;"><?= $title ?></span> sebelum tanggal <b><?= $data['target_bayar'] ?></b> untuk Customer : <b><?= $data['relasi'] ?> / <?= $data['kode_relasi'] ?></b></td>
        </tr>
        <tr>
            <td>Nomor Rekening</td>
            <td>: <?= $data['no_rekening'] ?></td>
            <td>Nomor NPWP</td>
            <td>: <?= $data['no_npwp'] ?></td>
        </tr>
        <tr>
            <td>Nama Rekening</td>
            <td>: <?= $data['nama_rekening'] ?></td>
            <td>Nama NPWP</td>
            <td>: <?= $data['nama_npwp'] ?></td>
        </tr>
        <tr>
            <td>Bank / KC</td>
            <td>: <?= $data['nama_bank'] ?> / <?= $data['kc_bank'] ?></td>
            <td>Komisi Netto</td>
            <td>: Rp <?= number_format($data['total_komisi'], 2) ?></td>
        </tr>
    </table>
    <div style="float:left;width:50%;font-size:8pt;font-family:Arial, Helvetica, sans-serif;">
        <b>Detail Perolehan Komisi</b>
        <table style="width:100%;font-size:8pt;font-family:Arial, Helvetica, sans-serif;border:0.2px solid black;border-collapse:collapse">
            <tr>
                <th style="border:0.2px solid black;border-collapse:collapse">Kode</th>
                <th style="border:0.2px solid black;border-collapse:collapse">Nama Produk</th>
                <th style="border:0.2px solid black;border-collapse:collapse">Komisi Bruto</th>

            </tr>
            <tr>
                <td style="border:0.2px solid black;border-collapse:collapse">AAH</td>
                <td style="border:0.2px solid black;border-collapse:collapse">ZEVA</td>
                <td style="border:0.2px solid black;border-collapse:collapse;text-align:right"><?= number_format($data['aah'], 2) ?></td>

            </tr>

            <tr>
                <td style="border:0.2px solid black;border-collapse:collapse">AAB</td>
                <td style="border:0.2px solid black;border-collapse:collapse">G1000</td>
                <td style="border:0.2px solid black;border-collapse:collapse;text-align:right"><?= number_format($data['aab'], 2) ?></td>

            </tr>
            <tr>
                <td style="border:0.2px solid black;border-collapse:collapse">AAG</td>
                <td style="border:0.2px solid black;border-collapse:collapse">BOXER</td>
                <td style="border:0.2px solid black;border-collapse:collapse;text-align:right"><?= number_format($data['aag'], 2) ?></td>

            </tr>
            <tr>
                <td style="border:0.2px solid black;border-collapse:collapse">AAE</td>
                <td style="border:0.2px solid black;border-collapse:collapse">M1000</td>
                <td style="border:0.2px solid black;border-collapse:collapse;text-align:right"><?= number_format($data['aae'], 2) ?></td>

            </tr>
            <tr>
                <td style="border:0.2px solid black;border-collapse:collapse">AAC</td>
                <td style="border:0.2px solid black;border-collapse:collapse">G600</td>
                <td style="border:0.2px solid black;border-collapse:collapse;text-align:right"><?= number_format($data['aac'], 2) ?></td>

            </tr>
            <tr>
                <td style="border:0.2px solid black;border-collapse:collapse">ACA</td>
                <td style="border:0.2px solid black;border-collapse:collapse">ZENA</td>
                <td style="border:0.2px solid black;border-collapse:collapse;text-align:right"><?= number_format($data['aca'], 2) ?></td>

            </tr>

            <tr>
                <td style="border:0.2px solid black;border-collapse:collapse">AAK</td>
                <td style="border:0.2px solid black;border-collapse:collapse">IMPALA</td>
                <td style="border:0.2px solid black;border-collapse:collapse;text-align:right"><?= number_format($data['aak'], 2) ?></td>

            </tr>

            <tr>
                <td style="border:0.2px solid black;border-collapse:collapse">AAL</td>
                <td style="border:0.2px solid black;border-collapse:collapse">CAPUNG METAL</td>
                <td style="border:0.2px solid black;border-collapse:collapse;text-align:right"><?= number_format($data['aal'], 2) ?></td>

            </tr>
            <tr>
                <td style="border:0.2px solid black;border-collapse:collapse">AAN</td>
                <td style="border:0.2px solid black;border-collapse:collapse">CAPUNG RAWA</td>
                <td style="border:0.2px solid black;border-collapse:collapse;text-align:right"><?= number_format($data['aan'], 2) ?></td>

            </tr>

            <tr>
                <td style="border:0.2px solid black;border-collapse:collapse">ADA</td>
                <td style="border:0.2px solid black;border-collapse:collapse">CAKAR BAJA</td>
                <td style="border:0.2px solid black;border-collapse:collapse;text-align:right"><?= number_format($data['ada'], 2) ?></td>

            </tr>
            <tr>
                <td style="border:0.2px solid black;border-collapse:collapse">ADB</td>
                <td style="border:0.2px solid black;border-collapse:collapse">CAKAR BAJA MINI</td>
                <td style="border:0.2px solid black;border-collapse:collapse;text-align:right"><?= number_format($data['adb'], 2) ?></td>

            </tr>
            <tr>
                <td style="border:0.2px solid black;border-collapse:collapse">ADC</td>
                <td style="border:0.2px solid black;border-collapse:collapse">CACAH BUMI</td>
                <td style="border:0.2px solid black;border-collapse:collapse;text-align:right"><?= number_format($data['adc'], 2) ?></td>

            </tr>
            <tr>
                <td style="border:0.2px solid black;border-collapse:collapse">ADD</td>
                <td style="border:0.2px solid black;border-collapse:collapse">KASUARI</td>
                <td style="border:0.2px solid black;border-collapse:collapse;text-align:right"><?= number_format($data['add'], 2) ?></td>

            </tr>
            <tr>
                <td style="border:0.2px solid black;border-collapse:collapse">GAA</td>
                <td style="border:0.2px solid black;border-collapse:collapse">DIESEL ONLY</td>
                <td style="border:0.2px solid black;border-collapse:collapse;text-align:right"><?= number_format($data['gaa'], 2) ?></td>

            </tr>
        </table>
    </div>
    <div>
        <table style="width:100%;font-size:8pt;font-family:Arial, Helvetica, sans-serif;">
            <tr>
                <th style="color:white">a</th>
                <th style="color:white">a</th>
                <th style="color:white">a</th>

            </tr>
            <tr>
                <th style="color:white">a</th>
                <th style="color:white">a</th>
                <th style="color:white">a</th>

            </tr>
            <tr>
                <th style="text-align: left;width:40%;padding-left:20px">Total Komisi Bruto</th>
                <th style="text-align: left;">Rp <?= number_format($data['total_komisi'], 2) ?></th>
                <th></th>
            </tr>
            <tr>
                <th style="text-align: left;width:40%;padding-left:20px"><?= $data['jenis_pph'] ?> (<?= $data['pajak'] ?> %)</th>
                <th style="text-align: left;border-bottom:1px solid black;border-collapse:collapse">Rp <?= number_format($data['potongan_pajak'], 2) ?></th>
                <th></th>
            </tr>
            <tr>
                <th style="text-align: left;width:40%;padding-left:20px">Komisi Netto</th>
                <th style="text-align: left;">Rp <?= number_format($data['nett_ammount'], 2) ?></th>
                <th></th>
            </tr>
        </table>
    </div>
<?php } ?>