<?php foreach ($data as $val) {
    // echo "<pre>";print_r($val);exit();
    ?>
<div class="row" style="padding-top:20px;padding-left:0px;padding-right:0px">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;text-align:center" >
    <tr>
        <td><?= date('d M Y')?></td>
    </tr>
</table>
</div>
<br>
<div class="row" style="padding-top:10px;padding-left:0px;padding-right:0px">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; text-align:center" >
    <tr>
        <td style="border-top:1px solid black;">&nbsp;&nbsp;</td>
    </tr>
    <tr>
        <td>NO JOB : <?= $val['JOB_NO']?></td>
    </tr>
    <tr>
        <td>NO PICKLIST : <?= $val['PICKLIST']?></td>
    </tr>
    <tr>
        <td><img style="width: 150px;height: 150px" src="<?php echo base_url('img/'.$val['PICKLIST'].'.png'); ?>"></td>
    </tr>
    <tr>
        <td><?= $val['PRODUK']?></td>
    </tr>
    <tr>
        <td><?= $val['PRODUK_DESC']?></td>
    </tr>
    <tr>
        <td><?= $val['FROM_SUBINV']?></td>
    </tr>
</table>
</div>
<?php }?>