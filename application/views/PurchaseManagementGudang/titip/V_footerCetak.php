<div style="width:32.5cm; height:2.6cm">
    <table style="border-collapse: collapse">
        <tr>
            <td style="border:1px solid grey; height:0.9cm; width:5.5cm;"></td>
            <td style="border:1px solid grey; height:0.9cm; width:5.9cm;"></td>
            <td style="border:1px solid grey; height:0.9cm; width:1.5cm;"></td>
            <td style="border:1px solid grey; height:0.9cm; width:1.5cm;"></td>
            <td style="border:1px solid grey; height:0.9cm; width:3.8cm;"></td>
            <td style="border:1px solid grey; height:0.9cm; width:6cm; text-align: right; font-size:14px;"><b><?php echo $head[0]['HARGA_TOTAL'];?></b></td>
            <td style="border:1px solid grey; height:0.9cm; width:8.2cm;"></td>
        </tr>
        <tr>
            <td style="border:1px solid grey; height:0.9cm; width:5.5cm; text-align:center; font-size:11px"><?php echo $head[0]['CF_APPROVER_2'];?></td>
            <td style="border:1px solid grey; height:0.9cm; width:5.9cm; text-align:center; font-size:11px"><?php echo $head[0]['CF_APPROVER_1'];?></td>
            <td style="border:1px solid grey; height:0.9cm; width:1.5cm; text-align:center; font-size:11px; max-width:1.5cm; word-wrap: break-word"><?php echo $head[0]['BUYER'];?></td>
            <td style="border:1px solid grey; height:0.9cm; width:1.5cm; text-align:center; font-size:11px; max-width:1.5cm; word-wrap: break-word"><?php echo $head[0]['CF_ADMIN_PO'];?></td>
            <td style="border:1px solid grey; height:0.9cm; width:3.8cm;"></td>
            <td style="border:1px solid grey; height:0.9cm; width:6cm; text-align:right; font-size:14px;"><b>170000</b></td>
            <td style="border:1px solid grey; height:0.9cm; width:8.2cm; text-align:center"><b style="font-size:14px"><?php echo $head[0]['LOCATION_CODE'];?><br><span style="font-size:10px;"><?php echo $head[0]['SHIP_TO_ADDREAS']?></span></b></td>
        </tr>
        <tr>
            <td style="border:1px solid grey; height:0.9cm; width:5.5cm;"></td>
            <td style="border:1px solid grey; height:0.9cm; width:5.9cm;"></td>
            <td style="border:1px solid grey; height:0.9cm; width:1.5cm;"></td>
            <td style="border:1px solid grey; height:0.9cm; width:1.5cm;"></td>
            <td style="border:1px solid grey; height:0.9cm; width:3.8cm;"></td>
            <td style="border:1px solid grey; height:0.9cm; width:6cm; text-align:right; font-size:14px;"><b><?php echo ($head[0]['HARGA_TOTAL']+ 170000) ?></b></td>
            <td style="border:1px solid grey; height:0.9cm; width:8.2cm; text-align:right; font-size:8px"><?php echo $head[0]['CF_ADMIN_DIST'];?></td>
        </tr>
    </table>
</div>