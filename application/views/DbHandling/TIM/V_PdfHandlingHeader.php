<table style="width: 100%;border:1px solid black;border-collapse:collapse;">
    <tr>
        <td style="border:1px solid black;border-collapse:collapse;width:9%" rowspan="2">
            <img style="height: 80; width: 65px" src="<?= base_url('assets/img/logo.png'); ?>">
        </td>
        <td style=" border:1px solid black;border-collapse:collapse;text-align:center;font-size:22pt;font-weight:bold" colspan="2">STANDARD HANDLING</td>
        <td style="border:1px solid black;border-collapse:collapse;width:11%" rowspan="2">
            <img style="height: 80px; width: 80px" src="<?= base_url('assets/img/logohandling.png'); ?>">

        </td>
    </tr>
    <tr>
        <td style="border:1px solid black;border-collapse:collapse;text-align:center;font-size:14pt;" colspan="2">CV. Karya Hidup Sentosa</td>
    </tr>
</table>
<table style="width: 100%;border:1px solid black;border-collapse:collapse;border-top:none;">
    <tr>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-top:none;width:10%;border-right:none;border-bottom:none"><strong>Doc. No</strong></td>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-top:none;width:40%;border-left:none;border-bottom:none">:&nbsp;&nbsp;&nbsp;&nbsp;<strong><?= $dataHandling[0]['doc_number'] ?></strong></td>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-top:none;width:15%;border-right:none;border-bottom:none"><strong>Rev. No</strong></td>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-top:none;width:35%;border-left:none;border-bottom:none">:&nbsp;&nbsp;&nbsp;&nbsp;<b><?= sprintf("%02d", $dataHandling[0]['rev_no']) ?></b></td>
    </tr>
    <tr>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-right:none;border-top:none"><strong>Rev. Date</strong></td>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-left:none;border-top:none">:&nbsp;&nbsp;&nbsp;&nbsp;<strong><?= date('d M Y', strtotime($dataHandling[0]['last_update_date'])) ?></strong></td>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-right:none;border-top:none"><strong>Page. No</strong></td>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-left:none;border-top:none">:&nbsp;&nbsp;&nbsp;&nbsp;<strong>{PAGENO} of {nbpg}</strong></td>
    </tr>
    <tr>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-top:none;width:10%;border-right:none;border-bottom:none"><strong>Nama Part</strong></td>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-top:none;border-left:none;border-bottom:none">:&nbsp;&nbsp;&nbsp;&nbsp;<strong><?= $dataHandling[0]['nama_komponen'] ?></strong></td>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-top:none;width:10%;border-right:none;border-bottom:none"><strong>Sarana Handling</strong></td>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-top:none;border-left:none;border-bottom:none">:&nbsp;&nbsp;&nbsp;&nbsp;<strong><?= $dataHandling[0]['sarana'] ?></strong></td>
    </tr>
    <tr>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-right:none;border-top:none"><strong>Kode Part</strong></td>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-left:none;border-top:none">:&nbsp;&nbsp;&nbsp;&nbsp;<strong><?= $dataHandling[0]['kode_komponen'] ?></strong></td>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-right:none;border-top:none"><strong>Qty / Berat</strong></td>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-left:none;border-top:none">:&nbsp;&nbsp;&nbsp;&nbsp;<strong><?= $dataHandling[0]['qty_handling'] ?> / <?= $dataHandling[0]['berat'] ?></strong></td>
    </tr>
    <tr>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-top:none;width:10%;border-right:none;border-bottom:none"><strong>Motto</strong></td>
        <td style="padding-left:10px;font-size:10pt;border:1px solid black;border-collapse:collapse;border-top:none;border-left:none;border-bottom:none" colspan="3">:</td>
    </tr>
    <tr>
        <td style="padding-left:10px;font-size:8pt;border:1px solid black;border-collapse:collapse;border-left:none;border-top:none;border-bottom:none" colspan="4"><strong>Kualitas diri pekerja CV.KHS tercermin dari kualitas komponen yang dihasikannya.<br> Komponen <i>BERSIH, RAPI, TIDAK CACAT,</i> dan <i>STANDARD</i></strong></td>
    </tr>
</table>