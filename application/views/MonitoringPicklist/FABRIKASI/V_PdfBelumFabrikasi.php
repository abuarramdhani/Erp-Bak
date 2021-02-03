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
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;font-size: 9px" >
    <!-- <tr>
        <td>Tgl Cetak</td>
        <td>: <?= $val['TGL_CETAK']?></td>
    </tr> -->
    <tr>
        <td>Tgl Job</td>
        <td>: <?= $val['TGL_JOB']?></td>
    </tr>
    <tr>
        <td>Permintaan Pelayanan</td>
        <td>: <?= $pelayanan?></td>
    </tr>
</table>
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; text-align:center;font-size: 10px" >
    <tr>
        <td colspan="2" style="font-size:17px;font-weight:bold;text-decoration: underline;">PICKLIST <?= $val['DEPT_CLASS'] ?></td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:13px;font-weight:bold;">SUBINV : <?= $val['FROM_SUBINVENTORY_CODE']?> (<?= $val['FROM_LOCATOR']?>)</td>
    </tr>
    <tr>
        <td rowspan="6" style="width:40%;"><img style="width: 90px;height: 90px" src="<?php echo base_url('img/'.$val['NO_PICKLIST'].'.png'); ?>"></td>
        <td style="text-align:left;width:50px;">Job :</td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:left;"><?= $val['NO_JOB']?></td>
    </tr>
    <tr>
        <td style="text-align:left;">Item :</td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:left;"><?= $val['KODE_ITEM']?></td>
    </tr>
    <tr>
        <td style="text-align:left;vertical-align:top;">Desc :</td>
    </tr>
    <tr>
        <td style="font-weight:bold;font-size:9px;text-align:left;"><?= $val['DESCRIPTION']?></td>
    </tr>
    <tr>
        <td><?= $val['NO_PICKLIST']?></td>
        <td style="text-align:left;">Qty : <span style="font-weight:bold;"><?= $val['START_QUANTITY']?><span></td>
    </tr>
</table>
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; text-align:center;font-size: 10px" >
    <tr style="background-color: #f0f0f0;vertical-align: middle;">
        <td style="border:1px solid black;width:7%">No</td>
        <td style="border:1px solid black;width:40%">Part</td>
        <td style="border:1px solid black;width:53%">Keterangan</td>
    </tr>
    <?php $no = 1; foreach ($beda as $key => $val) { ?>
        <tr>
            <td style="border:1px solid black"><?= $no?></td>
            <td style="border:1px solid black; font-size:9px"><?= $val['COMPONENT']?> <br> <?= $val['COMP_DESC']?></td>
            <td style="border:1px solid black; font-size:9px"><?= $val['PERBEDAAN']?></td>
        </tr>
    <?php $no++; }?>
</table>
</div>
<?php }?>