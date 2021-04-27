<div style="border: 1px solid black;border-collapse:collapse;width:100%;border-bottom:none;">
    <table style="border-bottom:1px solid black;border-collapse:collapse;width:100%;font-size:10pt;font-family:Arial, Helvetica, sans-serif;border-bottom:none">
        <tr>
            <th style="width: 20%;text-align:left;height:20px">Nama Subkontraktor</th>
            <td>: <?= $list_tagihan[0]['vendor_name'] ?> </td>
        </tr>
        <tr>
            <th style="text-align:left;border-bottom: 1px solid black;border-collapse:collapse;height:20px">Alamat</th>
            <td style="border-bottom: 1px solid black;border-collapse:collapse">: <?= $alamat_vendor[0]['ADDRESS'] ?></td>
        </tr>
        <tr>
            <th colspan="2" style="height: 20px;">SURAT TAGIHAN PEMBAYARAN</th>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;border-bottom: 1px solid black;border-collapse:collapse;height:20px">NO : <?= $list_tagihan[0]['nomor_tagihan'] ?></td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 8pt;height:20px">Kepada Yth :</td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: left;font-size: 8pt;height:20px">CV. KARYA HIDUP SENTOSA</th>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 8pt;height:20px">JL. Magelang, KM. 144, Yogyakarta 55241</td>
        </tr>
    </table>
</div>