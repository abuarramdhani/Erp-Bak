<?php $no = 0;
$num = 0;
foreach ($jml_cetak as $hitung) {
    $num += $hitung;
}
$b = 0;
$index = 0;
foreach ($list as $a) { 
    $no++;
    for ($i=0; $i < $jml_cetak[$index]; $i++) { 

       ?>
    <div  width= "49,5%"  style="float: left;">
        <table style="border: 1px solid black; padding: 0px; border-collapse: collapse; overflow: wrap;">
            <tr>
                <th rowspan="2" style="text-align: center; border-right: 1px solid black;">
                    <img width="8%" style="height:30px; width: 30px" src="<?= base_url('assets/img/logo.png') ;?>" style="display:block;"></th>
                <th style="font-size: 8px; text-align: center; border-right: 1px solid black; border-bottom: 1px solid black; background:<?= $a['warna_atas']?>; width: 150px;"><b>CV. KARYA HIDUP<br>SENTOSA</b></th>
                <th colspan="2" style="font-size: 8px; text-align: center; border-bottom: 1px solid black; background:<?= $a['warna_atas']?>; width: 200px;"><b>KARTU KANBAN CUTTING<br>TOOLS</b></th>
            </tr>
            <tr>
                <th style="font-size: 8px; text-align: center; border-right: 1px solid black; background:<?= $a['warna_atas']?>;">Jl. Magelang No. 144 Yogyakarta</th>
                <th style="font-size: 8px;text-align: center; border-right: 1px solid black; height: 18px; background: <?= $a['warna_atas']?>;"><b><?php echo $a['Kanban']['0']['SEKSI']; ?></b></th> 
                <th style="font-size: 8px;text-align: center; background:<?= $a['warna_atas']?>;"><b>BPPCT&nbsp;<?= $a['No_bppbgt'];?></b>
                <!-- <br><p style="font-size: 7px"><?php echo $a['Idunix']; ?></p> -->
            </th>
            </tr>
        </table>
        <table width="100%" style="margin-top: 2px;border: 1px solid black; padding: 0px; border-collapse: collapse; overflow: wrap;" bgcolor="<?= $a['warna_bawah']?>">
            <tr>
              <td colspan="2" style="font-size: 9px; text-align: left; border-right: 1px solid black; border-bottom: 1px solid black;"> Cost Center</td>
              <td style="font-size: 7px; text-align: center; border-right: 1px solid black; border-bottom: 1px solid black;"><b><?php echo $a['Cost_center']; ?></b></td>
              <td style="font-size: 9px; text-align: left; border-right: 1px solid black; border-bottom: 1px solid black;"> Line</td>
              <td colspan="2" style="font-size: 7px; text-align: center; border-bottom: 1px solid black; height: 20px;"><b><?php echo $a['Kanban']['0']['LINE']; ?></b></td>
            </tr>
            <tr>
              <td style="font-size: 9px; text-align: left; border-right: 1px solid black;"> Desc</td>
              <td colspan="2" style="font-size:7px; text-align: center; border-right: 1px solid black; height: 20px;"><b><?php echo $a['Desc'];?></b></td>
              <td colspan="2" style="font-size: 9px; text-align: left; border-right: 1px solid black;"> No. Mesin</td>
              <td style="font-size: 7px; text-align: center;"><b>
                    <?php 
                    for ($k=0; $k < $a['Jumlahmesin']; $k++) { 
                    echo $a['Kanban3'][$k]['NO_MESIN'];
                    echo (' ');
                    } 
                    ?>
                    </b></td>
            </tr>
        </table>
        <table width="100%" style="margin-top: 2px; margin-bottom:10px; border: 1px solid black; padding: 0px;border-collapse: collapse; overflow: wrap;">
            <thead>
                <tr style="background: <?= $a['warna_header']?>">
                    <th align="center" style="font-size: 7px; border-right: 1px solid black; border-bottom: 1px solid black; height: 13px;"><b>Item No</b></th>
                    <th align="center" style="font-size: 7px; border-right: 1px solid black; border-bottom: 1px solid black;"><b>Kode Barang</b></th>
                    <th align="center" style="font-size: 7px; border-right: 1px solid black; border-bottom: 1px solid black;"><b>Nama Barang</b></th>
                    <th align="center" style="font-size: 7px; border-right: 1px solid black; border-bottom: 1px solid black;"><b>Merk</b></th>
                    <th align="center" style="font-size: 7px; border-right: 1px solid black; border-bottom: 1px solid black;"><b>Std Qty</b></th>
                    <th align="center" style="font-size: 7px; border-right: 1px solid black; border-bottom: 1px solid black;"><b>QR Code</b></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="center" style="font-size: 22px; border-right: 1px solid black;"><b><?php echo $no; ?></b></td>
                    <td align="center" style="font-size: 10px; border-right: 1px solid black;"><?php echo $a['Kode_barang']; ?></td>
                    <td align="center" style="font-size: 10px; border-right: 1px solid black;"><?php echo $a['Kanban2']['0']['DESCRIPTION']; ?></td>
                    <td align="center" style="font-size: 10px; border-right: 1px solid black;"><?php echo  $a['Kanban2']['0']['MERK']; ?></td>
                    <td align="center" style="font-size: 14px; border-right: 1px solid black;"><b>1</b></td>
                    <td align="center" style="font-size: 10px;"><img style="height: 50px; width: 50px"  src="<?php echo base_url('assets/img/'.$a['Idunix'].'.png');?>"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div width= "49,5%"  style="float: right;">
        <table style="border: 1px solid black; padding: 0px; border-collapse: collapse; overflow: wrap;">
            <tr>
                <td height="32px" width="80%" style="font-size: 12px; border-right: 1px solid black; text-align: center; background: yellow"><b><u>ALUR KARTU KANBAN</u></b></td>
                <td rowspan="3" style="text-align: center; font-size: 20px;" ><b><?php echo $i+1 ?> / <?php echo $a['Jumlah_cetak']; ?></b></td>
            </tr>
            <tr>
                <td height="60px" width="80%" style="font-size: 10px; border-right: 1px solid black; border-top: 1px solid black; text-align: center;">TOOL WAREHOUSE<b style="font-size: 12px"> → </b><?php echo $a['Alur_kanban']; ?><b style="font-size: 12px"> → </b>TOOL WAREHOUSE</td>
            </tr>
            <tr>
                <td height="60.5px" width="80%" style="font-size: 10px;padding: 10px;border-right: 1px solid black; border-top: 1px solid black; text-align: center;">Jika Menemukan KARTU ini selain di jalur tersebut, harap kartu dikembalikan ke TOOL WAREHOUSE.</td>
            </tr>
        </table>
    </div>
<div style="clear:both;"></div>
<?php 
$b++;
if($b  != $num ){
  if($b%7 == 0){
    echo "<pagebreak>";
}
}
}
$index++;

}
?>

