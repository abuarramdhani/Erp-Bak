<?php foreach ($data as $val) {
    // echo "<pre>";print_r($val);exit();
    ?>
<style>
td {
    font-family: arial;
}
#page-border{                
    width: 100%;                
    height: 100%;                
    border:2px solid black;   
}       
</style>
<div class="row" id="page-border" style="padding-top:0px;padding-left:0px;padding-right:0px">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;font-size: 10px" >
    <tr>
        <td>Tgl Cetak</td>
        <td>: <?= $val['TGL_CETAK']?></td>
    </tr>
    <tr>
        <td>Tgl Job</td>
        <td>: <?= $val['TGL_JOB']?></td>
    </tr>
</table>
<br>
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; text-align:center;font-size: 12px" >
    <tr>
        <td style="font-size:20px;font-weight:bold;text-decoration: underline">PICKLIST <?= $val['DEPT_CLASS'] ?></td>
    </tr>
    <tr>
        <td style="font-size:15px;font-weight:bold;">SUBINV : <?= $val['FROM_SUBINVENTORY_CODE']?> (<?= $val['FROM_LOCATOR']?>)</td>
    </tr>
    <!-- <tr><td>&nbsp;</td></tr> -->
    <tr>
        <td><img style="width: 110px;height: 110px" src="<?php echo base_url('img/'.$val['NO_PICKLIST'].'.png'); ?>"></td>
    </tr>
    <tr>
        <td style=""><?= $val['NO_PICKLIST']?></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>Job</td>
    </tr>
    <tr>
        <td style="font-weight:bold;"><?= $val['NO_JOB']?></td>
    </tr>
    <tr>
        <td>Item</td>
    </tr>
    <tr>
        <td style="font-weight:bold;"><?= $val['KODE_ITEM']?></td>
    </tr>
    <tr>
        <td>Desc</td>
    </tr>
    <tr>
        <td style="font-weight:bold;font-size:9px"><?= $val['DESCRIPTION']?></td>
    </tr>
    <tr>
        <td>Qty</td>
    </tr>
    <tr>
        <td style="font-weight:bold;"><?= $val['START_QUANTITY']?></td>
    </tr>
</table>
</div>

<!-- view item berbeda -->
<div class="row" id="page-border" style="padding-top:0px;padding-left:0px;padding-right:0px">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;font-size: 10px" >
    <tr>
        <td>Tgl Cetak</td>
        <td>: <?= $val['TGL_CETAK']?></td>
    </tr>
    <tr>
        <td>Tgl Job</td>
        <td>: <?= $val['TGL_JOB']?></td>
    </tr>
</table>
<br>
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; text-align:center;font-size: 12px" >
    <tr>
        <td style="font-size:20px;font-weight:bold;text-decoration: underline" colspan="3">PICKLIST <?= $val['DEPT_CLASS'] ?></td>
    </tr>
    <tr>
        <td style="font-size:15px;font-weight:bold;" colspan="3">SUBINV : <?= $val['FROM_SUBINVENTORY_CODE']?> (<?= $val['FROM_LOCATOR']?>)</td>
    </tr>
    <tr>
        <td style="font-size:15px;font-weight:bold;" colspan="3">PICKLIST : <?= $val['NO_PICKLIST']?></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td colspan="3" style="text-align:left">List Item Berbeda :</td>
    </tr>
    <tr style="background-color: #f0f0f0;vertical-align: middle;">
        <td rowspan="2" style="border:1px solid black;width:40%">Nama Komponen</td>
        <td colspan="2" style="border:1px solid black;width:60%">Perbedaan</td>
    </tr>
    <tr style="background-color: #f0f0f0;vertical-align: middle;">
        <td style="border:1px solid black">Job</td>
        <td style="border:1px solid black">Bom</td>
    </tr>
    <?php foreach ($beda as $key => $val) { 
        $beda = explode(" - ", $val['PERBEDAAN']);
        $job = substr($beda[0], 4);
        $bom = substr($beda[1], 4);?>
        <tr>
            <td style="border:1px solid black"><?= $val['COMPONENT']?></td>
            <td style="border:1px solid black"><?= $job?></td>
            <td style="border:1px solid black"><?= $bom?></td>
        </tr>
    <?php }?>
</table>
</div>
<!-- view item berbeda -->
<?php }?>