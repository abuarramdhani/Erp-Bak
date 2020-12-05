<table style="border-collapse:collapse" width="100%">
    <tr>
        <th style="border:1px solid black;" colspan="2" rowspan="7">
            <img src="<?= base_url('/assets/img/quick-logo.jpg');?>" alt="" style="max-width:100px; max-height:150px;">
        </th>
        <th style="border-top:1px solid black; width:500px; height:10px;" colspan="7"></th>
        <th style="border-left:1px solid black; border-top:1px solid black; width:150px; height:10px;" colspan="2"></th>
        <th style="border-top:1px solid black; height:10px;"></th>
        <th style="border-top:1px solid black; border-right:1px solid black; width:100px; height:10px;"></th>
        <th style="border-top:1px solid black; border-right:1px solid black; height:10px; width:200px;"></th>
    </tr>
    <tr>
        <th style="height:10px;" colspan="7">CV KARYA HIDUP SENTOSA</th>
        <td style="border-left:1px solid black; width:10px; height:10px; font-size:10px; padding-left:2mm;" colspan="2">Purchasing approved date</td>
        <td style="height:10px;">:</td>
        <td style="height:10px; font-size:10px"><?= $headers[0]['APPROVED_DATE'];?></td>
        <th style="border-right:1px solid black; border-left:1px solid black;height:10px;"></th>
    </tr>
    <tr>
        <th style="border-bottom:1px solid black; height:10px;" colspan="7"></th>
        <th style="border-left:1px solid black; border-right:1px solid black; height:10px;" colspan="4"></th>
        <th style="border-right:1px solid black; height:10px;"></th>
    </tr>
    <tr>
        <th style="border-right:1px solid black; height:10px;" colspan="7"></th>
        <td style="height:10px; font-size:10px; padding-left:2mm;" colspan="2">creation date</td>
        <td style="height:10px;">:</td>
        <td style="border-right:1px solid black; height:10px; font-size:10px"><?= $headers[0]['CREATION_DATE'];?></td>
        <th style="border-right:1px solid black; height:10px;"></th>
    </tr>
    <tr>
        <th style="border-right:1px solid black; height:10px; font-size:20px;" colspan="7">ORDER KEBUTUHAN BARANG DAN JASA</th>
        <th style="border-right:1px solid black; height:10px;" colspan="4"></th>
        <th style="border-right:1px solid black; height:10px;"></th>
    </tr>
    <tr>
        <th style="border-right:1px solid black; height:10px;" colspan="7"></th>
        <td style="height:10px; font-size:10px; padding-left:2mm;" colspan="2">created by</td>
        <td style="height:10px;">:</td>
        <td style="border-right:1px solid black; height:10px; font-size:10px"><?= $headers[0]['NOIND'].', '.$headers[0]['CREATOR'];?></td>
        <th style="border-right:1px solid black; height:10px;"></th>
    </tr>
    <tr>
        <th style="border-right:1px solid black; border-bottom:1px solid black; height:10px;" colspan="7"></th>
        <th style="border-bottom:1px solid black; height:10px;" colspan="4"></th>
        <td style="border:1px solid black; height:10px; font-size:10px; text-align:center"></td>
    </tr>
    <tr>
        <th style="border:1px solid black;" colspan="14">Order Lines Details</th>
    </tr>
</table>


