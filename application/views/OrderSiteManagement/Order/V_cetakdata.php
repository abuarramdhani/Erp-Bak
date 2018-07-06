<!DOCTYPE html>
<html>
<body>
    <table style="width:100%;border: 1px solid black;margin-bottom: 0px;padding-bottom: 0px;">
        <tr>
            <td style="margin-bottom: 0px;padding-bottom: 0px;">
                <img src="<?php echo base_url('/assets/img/logo.png'); ?>" width="40" heigth="60">
            </td>
            <td style="vertical-align: text-top;">
                <b style="font-size: 16px">CV. KARYA HIDUP SENTOSA</b>
                <p style="font-size: 14px">Jl. Magelang No. 144 Yogyakarta</p>
            </td>
            <td></td>
            <td style="vertical-align: text-top;">
                <p style="font-size: 12px">Tgl. Terima GA : </p>
            </td>
            <td><p><?php if($row['tgl_terima']==null || $row['tgl_terima']==''){echo "";}else{ echo date('Y-m-d', strtotime($row['tgl_terima']));}?></p></td>
            <td><img src="<?php echo base_url();?>assets/upload/qrcodeSM/<?php echo $header[0]['no_order'];?>.png" width="50" height="50"></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td></td>
            <td>
                <p style="font-size: 12px">No. Order : </p>
            </td>
            <td><p style="font-size: 12px"><?php echo $header[0]['no_order'];?></p></td>
        </tr>
        <tr>
            <td style="text-align: center; vertical-align: text-bottom;margin-top: 10px" colspan="6">
                <b style="font-size: 18px;"> ORDER KE SEKSI GENERAL AFFAIR (SITE MANAGEMENT) </b>
            </td>
        </tr>
    </table>
    <table style="border-right: 1px solid black;border-left: 1px solid black;width: 100%;margin-top: 0px">
        <tr>
            <td style="width: 13%"><p style="font-size: 12px">Tgl. Order </p></td>
            <td style="width: 2%"> : </td>
            <td style="width: 35%"><p style="font-size: 12px"><?php echo date('Y-m-d', strtotime($header[0]['tgl_order']));?></p></td>
            <td style="text-align: center;width: 50%;border-left: 1px solid black;border-bottom: 1px solid black;" colspan="3"><b style="font-size: 14px">Pemberi Order</b></td>
        </tr>
        <tr>
            <td style="width: 13%"><p style="font-size: 12px">Tgl. Selesai </p></td>
            <td style="width: 2%"> : </td>
            <td style="width: 35%"><p style="font-size: 12px"><?php echo date('Y-m-d', strtotime($header[0]['due_date']));?></p></td>
            <td style="width: 13%;border-left: 1px solid black;"><p style="font-size: 12px">Seksi </p></td>
            <td style="width: 2%"> : </td>
            <td style="width: 35%"><p style="font-size: 12px"><?php echo $header[0]['nama_seksi'];?></p></td>
        </tr>
        <tr>
            <td style="width: 13%"><p style="font-size: 12px">Jenis Order </p></td>
            <td style="width: 2%"> : </td>
            <td style="width: 35%"><p style="font-size: 12px"><?php echo $header[0]['jenis_order']?></p></td>
            <td style="width: 13%;border-left: 1px solid black;"><p style="font-size: 12px">Departemen </p></td>
            <td style="width: 2%"> : </td>
            <td style="width: 35%"><p style="font-size: 12px"><?php echo $header[0]['nama_dept']?></p></td>
        </tr>
    </table>
    <table style="width: 100%;height: 200px" border="1">
        <thead>
            <tr>
                <th style="font-size: 12px;width: 5%;text-align: center;">No. </th>
                <th style="font-size: 12px;width: 7%;text-align: center;">Qty </th>
                <th style="font-size: 12px;width: 8%;text-align: center;">Satuan </th>
                <th style="font-size: 12px;width: 40%;text-align: center;">Keterangan </th>
                <th style="font-size: 12px;width: 40%;text-align: center;">Lampiran </th>
            </tr>
        </thead>
        <tbody>
        <?php $count=0;$no=1;foreach ($lines as $key):?>
            <?php $count++;?>
            <tr>
                <td style="font-size: 12px;text-align: center;"><?php echo $no++;?></td>
                <td style="font-size: 12px;text-align: center;"><?php echo $key['jumlah'];?></td>
                <td style="font-size: 12px;text-align: center;"><?php echo $key['satuan'];?></td>
                <td style="font-size: 12px;padding-left: 5px;"> <?php echo $key['keterangan'];?></td>
                <td style="font-size: 12px;padding-left: 5px;"> <?php echo $key['lampiran'];?></td>
            </tr>
        <?php endforeach; ?>
        <?php if ($count<=12):?>
            <?php for ($i=$count; $i<(12-$count); $i++):?>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <?php endfor;?>
        <?php endif;?>
        </tbody>
    </table>
    <table style="width: 100%; text-align: center;" border="1">
        <tr>
            <td style="font-size: 12px;width: 10%;" rowspan="4">Remarks : 
                <br></br>
                <b><?php if($header[0]['remarks']==='f'){echo "NOT OK";}else{echo "OK";}?></b>
            </td>
            <td style="font-size: 11px;width: 15%;vertical-align: text-top;" rowspan="4">Penerima Order Kepala Seksi
            </td>
            <td style="font-size: 11px;width: 15%;" colspan="4">Disetujui</td>
            <td style="font-size: 11px;width: 15%;vertical-align: text-top;" rowspan="4">Pemberi Order Kepala Seksi
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px;width: 15%;vertical-align: text-top;" rowspan="3">Kepala Unit Penerima Order
                <br></br>
                <br></br>
                <br></br>
                <br></br>
                <br></br>
            </td>
            <td style="font-size: 11px;width: 15%;vertical-align: text-top;" rowspan="3">Direksi
                <br></br>
                <br></br>
                <br></br>
                <br></br>
                <br></br>
            </td>
            <td style="font-size: 11px;width: 15%;vertical-align: text-top;" rowspan="3">Kepala Departemen Pemberi Order
                <br></br>
                <br></br>
                <br></br>
                <br></br>
                <br></br>
            </td>
            <td style="font-size: 11px;width: 15%;vertical-align: text-top;" rowspan="3">Kepala Unit Pemberi Order
                <br></br>
                <br></br>
                <br></br>
                <br></br>
                <br></br>
            </td>
        </tr>
    </table>
</body>
</html>