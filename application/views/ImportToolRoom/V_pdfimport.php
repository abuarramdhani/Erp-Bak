<?php 
$h = count($data);
if ($h > 40) {
    $h2 = ((295 * 210 / $h )/$h).'px';
    $f = 10 - ($h/15);
}elseif ($h > 12 && $h < 40) {
    $h1 = 2 * $h;
    $h2 = ((295 * 210 / $h1 )/$h).'px';
    $f = 10 - ($h/15);
}else{
    $f = 13;
    $h2 = '200px';
}
// $urut != 0 ? '<pagebreak resetpagenum="1" />' : '' ;
foreach ($data as $val) {
    // echo "<pre>";print_r($data);exit();
?>
<div style="width: 60mm; float: left; padding-top:5px">
<table style="border-collapse: collapse;width:10%;" >
    <tr>
        <td><img style="width: <?= $h2?>;height: <?= $h2?>" src="<?php echo base_url('img/'.$val['item'].'.png'); ?>"></td>
    </tr>
    <tr>
        <td style="font-size:<?= $f?> px"><?= $val['item']?></td>
    </tr>
    <tr>
        <td style="font-size:<?= $f?>px"><?= $val['desc']?></td>
    </tr>
</table>
</div>
<?php } ?>
<pagebreak resetpagenum="1" />