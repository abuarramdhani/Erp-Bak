<table style="width: 100%;border:1px solid black;border-collapse:collapse;font-family:arial">
    <tr>
        <th style="border:1px solid black;border-collapse:collapse;border-right:none" rowspan="4">
            <img style="height: 60px; width: 50px" src="<?= base_url('assets/img/logo.png'); ?>">
        </th>
        <th style="text-align: left;padding-left:7px;padding-top:10px;width:350px">CV. KARYA HIDUP SENTOSA</th>
        <th style="border:1px solid black;border-collapse:collapse;font-size:12pt" colspan="3">CORRECTIVE ACTION REQUEST (CAR)</th>
    </tr>
    <tr>
        <td rowspan="3" style="text-align: left;padding-left:7px;font-size:8pt;padding-top:0px">Jl. Magelang 144, Yogyakarta (55241), Indonesia<br>
            Phone: (0274) 563217, 556923, 513025, 584874, 512095 (hunting)<br>
            Email: operator1@quick.co.id<br>
            Fax: (0274) 563523 </td>
        <th style="border:1px solid black;border-collapse:collapse;font-size:9pt;width:100px">CAR Number</th>
        <th style="border:1px solid black;border-collapse:collapse;font-size:9pt;text-align:left" colspan="2"><?= $car[0]['CAR_NUM'] ?></th>
    </tr>
    <tr>
        <?php if ($car[0]['CAR_TYPE'] == 'COMPLAIN') {
            $displaycomp = '&#9745;';
            $displaycla = '&#9744;';
        } else {
            $displaycomp = '&#9744;';
            $displaycla = '&#9745;';
        } ?>
        <th style="border:1px solid black;border-collapse:collapse;font-size:9pt">CAR Type</th>
        <th style="border:1px solid black;border-collapse:collapse;font-size:9pt;text-align:left" colspan="2"><span><?= $displaycla ?></span> CLAIM &nbsp;&nbsp;&nbsp;<span><?= $displaycomp ?></span> COMPLAIN</th>
    </tr>
    <tr>
        <?php if ($car[0]['NC_SCOPE'] == 'DELIVERY') {
            $displaydel = '&#9745;';
            $displayqual = '&#9744;';
            $displayquan = '&#9744;';
            $displayot = '&#9744;';
        } else if ($car[0]['NC_SCOPE'] == 'QUALITY') {
            $displaydel = '&#9744;';
            $displayqual = '&#9745;';
            $displayquan = '&#9744;';
            $displayot = '&#9744;';
        } else if ($car[0]['NC_SCOPE'] == 'QUANTITY') {
            $displaydel = '&#9744;';
            $displayqual = '&#9744;';
            $displayquan = '&#9745;';
            $displayot = '&#9744;';
        } else if ($car[0]['NC_SCOPE'] == 'OTHER') {
            $displaydel = '&#9744;';
            $displayqual = '&#9744;';
            $displayquan = '&#9744;';
            $displayot = '&#9745;';
        } ?>
        <th style="border:1px solid black;border-collapse:collapse;font-size:9pt">NC Scope</th>
        <th style="border:1px solid black;border-collapse:collapse;font-size:9pt;text-align:left" colspan="2"><span><?= $displaydel ?></span> Delivery &nbsp;<span><?= $displayqual ?></span> Quality &nbsp; <span><?= $displayquan ?></span> Quantity &nbsp;<span><?= $displayot ?></span> Other</th>
    </tr>
</table>