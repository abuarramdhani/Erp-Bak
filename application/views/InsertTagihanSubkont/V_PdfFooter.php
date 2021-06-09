<div style="border: 1px solid black;border-collapse:collapse;width:100%;border-top:none;">
    <?php

    $created_date = explode('-', $list_tagihan[0]['creation_date']);
    $date = $created_date[2];
    $bulan = $created_date[1];
    $tahun = $created_date[0];

    if ($bulan == 01) {
        $bulan = 'Januari';
    } else if ($bulan == 02) {
        $bulan = 'Februari';
    } else if ($bulan == 03) {
        $bulan = 'Maret';
    } else if ($bulan == 04) {
        $bulan = 'April';
    } else if ($bulan == 05) {
        $bulan = 'Mei';
    } else if ($bulan == 06) {
        $bulan = 'Juni';
    } else if ($bulan == 07) {
        $bulan = 'Juli';
    } else if ($bulan == 08) {
        $bulan = 'Agustus';
    } else if ($bulan == 09) {
        $bulan = 'September';
    } else if ($bulan == 10) {
        $bulan = 'Oktober';
    } else if ($bulan == 11) {
        $bulan = 'November';
    } else if ($bulan == 12) {
        $bulan = 'Desember';
    }

    ?>
    <table style="width: 100%;font-size:8pt;font-family:Arial, Helvetica, sans-serif">
        <tr>
            <td style="width: 70%;"></td>
            <td>Yogyakarta, <?= $date . ' ' . $bulan . ' ' . $tahun ?></td>
        </tr>
        <tr>
            <td style="width: 70%;"></td>
            <td>Hormat Kami,</td>
        </tr>
        <tr>
            <td style="width: 70%;"></td>
            <td style="text-align: center;"><i style="font-size: 7pt;">dibuat digital oleh <?= $list_tagihan[0]['creation_by'] ?> <br> pada tgl <?= $date . ' ' . $bulan . ' ' . $tahun ?> <br><br></i>
                ( <?= $list_tagihan[0]['creation_by'] ?> )
            </td>
        </tr>
    </table>
</div>