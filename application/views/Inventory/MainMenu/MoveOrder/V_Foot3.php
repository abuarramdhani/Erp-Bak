<?php 
// echo "<pre>";
// print_r($dataall);
// exit();
$tanggal = $dataall['head'][0]['PRINT_DATE'] ;
// $date = date_create($tanggal);

$date = str_replace('/', '-', $tanggal);
$newDate = date("d-m-Y", strtotime($date));
?>
<table style="width: 100%; border-left: 0px solid black; border-right: 0px solid black; border-bottom: 0px solid black;position: relative;bottom: 0px;">
        <tr>
            <td style="width: 40% ;border-right: 0px solid black; border-top: 0px solid black;font-size: 14px;" rowspan="3">
                <span><h4 style="color:white;">KETERANGAN : </h4></span>
                <?=$dataall['line'][0]['PRODUK_DESC'];?><br>
                (<?=$dataall['line'][0]['JOB_NO'];?>)
            </td>
            <td style="width: 14% ;height: 10px;font-size: 11px;border-right: 0px solid black; border-top: 0px solid black;color: white;">
                <span>Diterima Oleh,</span><p>
                <span>Tgl. :</span>
            </td>
            <td style="width: 14% ;height: 10px;font-size: 11px;border-right: 0px solid black; border-top: 0px solid black;color: white;">
                <span>Unit Pengeluaran,</span><p>
                <span>Tgl. :</span>
            </td>
            <td style="width: 13% ;height: 10px;font-size: 11px;border-right: 0px solid black; border-top: 0px solid black;color: white;">
                <span>Gudang,</span><p>
                <span>Tgl. :</span>
            </td>
            <td style="width: 12% ;height: 10px;font-size: 11px;border-right: 0px solid black; border-top: 0px solid black;color: white;">
                <span>Disetujui Oleh,</span><p>
                <span>Tgl. :</span>
            </td>
            <td style="width: 12% ;height: 10px;font-size: 11px; border-top: 0px solid black;">
                <span style="color: white;">Pemb. Subkont,</span><p>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $newDate?></span>
            </td>
        </tr>
        <tr>
            <td style="height: 50px;border-right: 0px solid black"></td>
            <td style="height: 50px;border-right: 0px solid black"></td>
            <td style="height: 50px;border-right: 0px solid black"></td>
            <td style="height: 50px;border-right: 0px solid black"></td>
            <td style="height: 50px;"></td>
        </tr>
        <tr>
            <td style="height: 15px;text-align: center;font-size: 11px;border-right: 0px solid black"></td>
            <td style="height: 15px;text-align: center;font-size: 11px;border-right: 0px solid black"></td>
            <td style="height: 15px;text-align: center;font-size: 11px;border-right: 0px solid black"></td>
            <td style="height: 15px;text-align: center;font-size: 11px;border-right: 0px solid black"><?=$dataall['head'][0]['NAMA_SATU']?></td>
            <td style="height: 15px;text-align: center;font-size: 11px;"><?=$dataall['head'][0]['NAMA_DUA']?></td>
        </tr>
    </table>