<?php 
    // foreach ($ekspedisi as $eks) {
    ?>
<!-- <div class="row" style="padding-top:20px;padding-left:10px;padding-right:10px">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;" >
    <tr>
        <td style="width: 60%;font-weight:bold ">PT. <?= $eks?></td>
        <td colspan="2" style="width: 40%; border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold">MANIVEST PENYERAHAN PAKET</td>
    </tr>
    <tr>
        <td style="width: 60%;font-weight:bold ">PERWAKILAN, YOGYAKARTA</td>
        <td style="width: 20%; border:1px solid black; border-bottom :0px; border-collapse: collapse;font-size:12px;">Diterima dari : CV. KHS</td>
        <td style="width: 20%; border:1px solid black; border-bottom :0px; border-collapse: collapse;font-size:12px">Tgl : <?= date('d M Y')?></td>
    </tr>
</table>
</div> -->

<div class="row" style="padding-top:75px;padding-left:10px;padding-right:10px;">

<?= $urut != '0' ? '<pagebreak resetpagenum="1" />' : '' ?>
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;" >
    <thead>
        <tr>
            <th style="width: 5%;border:1px solid black;">NO</th>
            <th style="width: 13%;border:1px solid black;">NO. STTT</th>
            <th style="width: 22%;border:1px solid black;">NO. SP/DOSP/SPB</th>
            <th style="width: 35%;border:1px solid black;">TUJUAN</th>
            <th style="width: 10%;border:1px solid black;">JML COLLY</th>
            <th style="width: 15%;border:1px solid black;">BERAT (KG)</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; 
        // foreach($data as $val){
            for ($i=0; $i < count($data) ; $i++) { 
        
            if ($i != 0 && $data[$i]['no_dokumen'] == $data[$i-1]['no_dokumen']) { ?>
                <tr>
                    <td style="height:30px;border:1px solid black;text-align:center;"><?= $data[$i]['berat']?></td>
                </tr>
           <?php } else {?>
        <tr>
            <td rowspan="<?= $data[$i]['jumlah']?>" style="height:30px;border:1px solid black;text-align:center;"><?= $no?></td>
            <td rowspan="<?= $data[$i]['jumlah']?>" style="height:30px;border:1px solid black;"></td>
            <td rowspan="<?= $data[$i]['jumlah']?>" style="height:30px;border:1px solid black;text-align:center;"><?= $data[$i]['no_dokumen']?></td>
            <td rowspan="<?= $data[$i]['jumlah']?>" style="height:30px;border:1px solid black;"><?= $data[$i]['tujuan']?></td>
            <td rowspan="<?= $data[$i]['jumlah']?>" style="height:30px;border:1px solid black;text-align:center;"><?= $data[$i]['jumlah']?></td>
            <td style="height:30px;border:1px solid black;text-align:center;"><?= $data[$i]['berat']?></td>
        </tr>
        <?php $no++; } 
        
    
    }
        
        if (count($data) < 28) {
            $kurang = 28 - $i;
            for ($a=0; $a < $kurang; $a++) { 
                echo '<tr>
                        <td style=\'height:30px;border:1px solid black;\'></td>
                        <td style=\'height:30px;border:1px solid black;\'></td>
                        <td style=\'height:30px;border:1px solid black;\'></td>
                        <td style=\'height:30px;border:1px solid black;\'></td>
                        <td style=\'height:30px;border:1px solid black;\'></td>
                        <td style=\'height:30px;border:1px solid black;\'></td>
                    </tr>';
            }
        }else {
            // echo '<pagebreak />';
            // $krg = count($data) - 30;
            // $kurang = 30 - $krg;
            // for ($a=0; $a < $kurang; $a++) { 
            //     echo '<tr>
            //             <td style=\'height:30px;border:1px solid black;\'></td>
            //             <td style=\'height:30px;border:1px solid black;\'></td>
            //             <td style=\'height:30px;border:1px solid black;\'></td>
            //             <td style=\'height:30px;border:1px solid black;\'></td>
            //             <td style=\'height:30px;border:1px solid black;\'></td>
            //             <td style=\'height:30px;border:1px solid black;\'></td>
            //         </tr>';
            // }
        }
        ?>
    </tbody>
</table>
</div>

<?php 



?>

<!-- <div class="row" style="padding-top:20px;padding-left:10px;padding-right:10px;padding-bottom:240px">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;" >
    <tr>
        <td style="width: 40%;"></td>
        <td style="width: 30%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold;font-size:12px">Yang menyerahkan,</td>
        <td style="width: 30%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold;font-size:12px">Yang menyerahkan,</td>
    </tr>
    <tr>
        <td style="width: 40%;"></td>
        <td style="width: 30%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold;font-size:12px">CV. KHS</td>
        <td style="width: 30%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold;font-size:12px">PT. <?= $eks?></td>
    </tr>
    <tr>
        <td style="width: 40%;"></td>
        <td style="width: 30%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold;font-size:12px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width: 30%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold;font-size:12px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr>
        <td style="width: 40%;"></td>
        <td style="width: 30%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold;font-size:12px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="width: 30%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold;font-size:12px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr>
        <td style="width: 40%;"></td>
        <td style="width: 30%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold;font-size:12px">(.....................)</td>
        <td style="width: 30%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold;font-size:12px">(.....................)</td>
    </tr>
</table>
</div> -->
<?php //}?>