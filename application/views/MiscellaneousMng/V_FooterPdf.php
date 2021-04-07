<?php 
		// echo "<pre>";print_r($approver);exit;?>
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; text-align:center;" >
    <tr>
        <td style="width: 30%;border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:30px;text-align:left">Catatan / Keterangan</td>
        <td style="width: 10%;border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:30px">KA. Seksi</td>
        <td style="width: 10%;border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:30px">Ka. Seksi Utama / Aska. / Ka. Unit <sup style="font-size:9px">2</sup></td>
        <td style="width: 10%;border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:30px">Ka. Seksi PPC <sup style="font-size:9px">3</sup></td>
        <td style="width: 10%;border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:30px">Waka. / Ka. Department <sup style="font-size:9px">4</sup></td>
        <td style="width: 10%;border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:30px">Ka. Seksi Akt. Biaya</td>
        <td style="width: 10%;border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:30px">Aska. / Ka. Unit Akt</td>
        <td style="width: 10%;border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:30px">Waka. / Ka. Dept. Keuangan <sup style="font-size:9px">5</sup></td>
    </tr>
    <tr>
        <td rowspan="3" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;"></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:50px"><?= !empty($approver['tgl_seksi']) ? 'Approved' : ''; ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:50px"><?= !empty($approver['tgl_askanit']) ? 'Approved' : ''; ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:50px"><?= !empty($approver['tgl_ppc']) ? 'Approved' : ''; ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:50px"><?= !empty($approver['tgl_kadep']) ? 'Approved' : ''; ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:50px"><?= !empty($approver['tgl_costing']) ? 'Approved' : ''; ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:50px"><?= !empty($approver['tgl_akt']) ? 'Approved' : ''; ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:50px"><?= !empty($approver['tgl_input']) ? 'Approved' : ''; ?></td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:25px;font-size:10px"><?= $approver['pic_seksi']?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:25px;font-size:10px"><?= $approver['pic_askanit']?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:25px;font-size:10px"><?= $approver['pic_ppc']?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:25px;font-size:10px"><?= $approver['pic_kadep']?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:25px;font-size:10px"><?= $approver['pic_costing']?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:25px;font-size:10px"><?= $approver['pic_akt']?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:25px;font-size:10px"><?= $approver['pic_input']?></td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:25px;font-size:10px"><?= $approver['tgl_seksi']?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:25px;font-size:10px"><?= $approver['tgl_askanit']?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:25px;font-size:10px"><?= $approver['tgl_ppc']?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:25px;font-size:10px"><?= $approver['tgl_kadep']?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:25px;font-size:10px"><?= $approver['tgl_costing']?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:25px;font-size:10px"><?= $approver['tgl_akt']?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:25px;font-size:10px"><?= $approver['tgl_input']?></td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 0px solid black;font-style:italic;font-size:10px;text-align:left;vertical-align:top">
            Note :
        </td>
        <td colspan="7" style="border-bottom :0px; border-collapse: collapse; border: 0px solid black;font-style:italic;font-size:10px;text-align:left;vertical-align:top;padding-left:-250px">
            <p>1. Pilih salah satu. Pilih ISSUE jika ingin mengeluarkan barang dari on hand oracle, pilih RECEIPT jika ingin memasukkan barang ke on hand oracle.</p>
            <p>2. Minimal approval oleh Kasie. Utama Seksi yang bersangkutan.</p>
            <p>3. Khusus untuk Foundry tidak perlu mengetahui Ka. Seksi PPC, cukup sampai Ka. Seksi Utama / Aska / Ka. Unit saja.</p>
            <p>4. Approval hingga Waka. / Ka. Dept Produksi jika barang yang akan di-miscellaneous merupakan barang besar / barang unit.</p>
            <p>5. Approval hingga Waka. / Ka. Dept. Keuangan jika barang yang akan di-miscellaneous merupakan barang besar / barang unit.</p>
        </td>
    </tr>
    <tr>
        <td colspan="8" style="border-bottom :0px; border-collapse: collapse; border: 0px solid black;height:20px;font-style:italic;font-weight:bold;font-size:10px;text-align:left;vertical-align:bottom">
            No Form : FRM-F&A-06-05  Rev.02
        </td>
    </tr>
</table>

</div>