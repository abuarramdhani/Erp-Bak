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
<?php foreach ($data as $val) { ?>
<div id="page-border" style="float:left; width:190px;margin-left:10px;">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; text-align:center;margin-top:5px" >
    <tr>
        <td style="font-size:13px;"><br><?= $val['SEGMENT1']?></td>
    </tr>
    <tr>
        <td style="font-size:13px;"><?= $val['DESCRIPTION']?></td>
    </tr>
    <tr>
        <td style="width:40%;"><br><img style="width: 125px;height: 125px" src="<?php echo base_url('img/'.$val['CODE'].'.png'); ?>"></td>
    </tr>
    <tr>
        <td style="font-size: 17px;font-weight:bold"><br><?= $val['CODE']?></td>
    </tr>
</table>
</div>
<?php }?>