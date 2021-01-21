<?php 
		// echo "<pre>";print_r($fix);exit;?>
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; text-align:center;font-size: 11.5px" >
    <tr>
        <td colspan="3" style="padding-left:7px;border-bottom :0px; border-collapse: collapse; border:0px solid black;vertical-align:bottom;text-align:left;font-size:10px">
            NOTE :
        </td>
        <td colspan="7" style="border-bottom :0px; border-collapse: collapse; border: 0px solid black;height:30px"></td>
        <td rowspan="6" style="width:2px;border-bottom :0px; border-collapse: collapse; border: 0px solid black;">&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr>
        <td style="width: 3%;border-bottom :0px; border-collapse: collapse; border: 0px solid black;vertical-align:top;font-size:10px">(*1)</td>
        <td style="width: 11%;border-bottom :0px; border-collapse: collapse; border: 0px solid black;vertical-align:top;text-align:left;font-size:10px">Status diisi dengan kode :</td>
        <td style="width: 35%;border-bottom :0px; border-collapse: collapse; border: 0px solid black;vertical-align:top;text-align:left;font-size:10px">
            P ==> Pendaftaran Item Baru<br>
            R ==> Revisi<br>
            I ==> Inactive</td>
        <td style="width: 7%;border-bottom :0px; border-collapse: collapse; border: 1px solid black">Spv / Ka. Si. Pengorder</td>
        <td style="width: 7%;border-bottom :0px; border-collapse: collapse; border: 1px solid black">Ass / Ka. Unit Pengorder</td>
        <td style="width: 7%;border-bottom :0px; border-collapse: collapse; border: 1px solid black">Tim Kode Barang / Asset</td>
        <td style="width: 7%;border-bottom :0px; border-collapse: collapse; border: 1px solid black">Ka. Si. Akuntansi</td>
        <td style="width: 7%;border-bottom :0px; border-collapse: collapse; border: 1px solid black">Ka. Si. Pembelian</td>
        <td style="width: 7%;border-bottom :0px; border-collapse: collapse; border: 1px solid black">Ass / Ka. Unit PE</td>
        <td style="width: 7%;border-bottom :0px; border-collapse: collapse; border: 1px solid black">Ka. Si. PIEA</td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 0px solid black;vertical-align:top;font-size:10px">(*2)<br>(*3)<br>(*4)</td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border: 0px solid black;vertical-align:top;text-align:left;font-size:10px">
            UOM : Unit of Measurement; Satuan yang dipakai.<br>
            Dual UOM : Dual Unit of Measurement; Satuan konversi yang dipakai ditulis pada keterangan.<br>
            - Item Make : Tidak melalui approval Seksi Pembelian.<br>
            - Item Buy : Melalui approval Seksi Pembelian.<br>
            - Item Buy Barang Dagang Lain (BDL) Jual : Melalui approval Seksi PIEA langsung, tanpa approval Seksi Pembelian (Ketentuan dapat dilihat pada Memo No. PURSUP-INTM-20-04-009).</td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;vertical-align:middle;"></td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;vertical-align:middle;"></td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;vertical-align:middle;"><?= $data[0]['KET_TKB'] == 1 ? '' : '____' ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;vertical-align:middle;"></td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;vertical-align:middle;"><?= $data[0]['KET_PMB'] == 1 ? '' : '____' ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;vertical-align:middle;"></td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;vertical-align:middle;"></td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 0px solid black;vertical-align:top;font-size:10px">(*5)</td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border: 0px solid black;vertical-align:top;text-align:left;font-size:10px">
            Org. Assign wajib diisi Spv/Kasie pengisi form sesuai dengan Inventory mana saja yang dituju.</td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;vertical-align:bottom;height:5px">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;vertical-align:bottom;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;vertical-align:bottom;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;vertical-align:bottom;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;vertical-align:bottom;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;vertical-align:bottom;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;vertical-align:bottom;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 0px solid black;vertical-align:top;font-size:10px">(*6)<br>(*7)</td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border: 0px solid black;vertical-align:top;text-align:left;font-size:10px">
            Proses Lanjut diisi dengan centang pada kolom yang tersedia.<br>
            Inventory Valuation & Expense Account (Exc Acc) diisi oleh Seksi Akuntansi.</td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:30px"></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black"></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black"></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black"></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black"></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black"></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black"></td>
    </tr>
    <tr>
        <!-- <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;height:20px;font-style:italic;font-weight:bold;font-size:10px;text-align:right;vertical-align:bottom">
            FRM-PDE-00-31 rev03 - 8 April 2020
        </td> -->
        <td colspan="10" style="border-bottom :0px; border-collapse: collapse; border: 0px solid black;height:20px;font-style:italic;font-weight:bold;font-size:10px;text-align:right;vertical-align:bottom">
            FRM-PDE-00-31 rev03 - 8 April 2020
        </td>
    </tr>
</table>

</div>