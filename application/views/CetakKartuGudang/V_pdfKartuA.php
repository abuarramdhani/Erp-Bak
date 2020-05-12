<style>
td {
    font-family:Arial;
}
</style>
<?php
// echo "<pre>";print_r($data);exit();
$i = 1;
foreach ($data as $val) { 
    if ($i > 6) {
        $i = 1;
        echo '<pagebreak resetpagenum="1" />';
    }
    ?>
    <div style="width: 210px; float: left; padding-top:50px;padding-left:80px;text-align:center">
        <table style="border-collapse: collapse;width:100%;text-align:center" >
            <tr>
                <td style="width: 50%;font-size:90px;border: 1px solid black;font-weight:bold">2</td>
                <td style="width: 50%;border: 1px solid black;"><img style="width: 75px;height: 75px" src="<?php echo base_url('img/'.$val['engine'].'_'.$val['body'].'.png'); ?>"></td>
            </tr>
            <tr>
                <td colspan="2" style="font-size:15px;border: 1px solid black;font-weight:bold">A360</td>
            </tr>
            <tr>
                <td style="font-size:9px;border: 1px solid black;text-align:left">NO. ENGINE</td>
                <td style="font-size:9px;border: 1px solid black;"><?= $val['engine']?></td>
            </tr>
            <tr>
                <td style="font-size:9px;border: 1px solid black;text-align:left">NO. BODY</td>
                <td style="font-size:9px;border: 1px solid black;"><?= $val['body']?></td>
            </tr>
            <tr>
                <td style="font-size:9px;border: 1px solid black;text-align:left">COUNTER WEIGHT</td>
                <td style="font-size:9px;border: 1px solid black;"><?= $val['weight']?></td>
            </tr>
            <tr>
                <td style="font-size:9px;border: 1px solid black;text-align:left">3 POINT LINK</td>
                <td style="font-size:11px;border: 1px solid black;">&#10003;</td>
            </tr>
            <tr>
                <td style="font-size:9px;border: 1px solid black;text-align:left">ATAP</td>
                <td style="font-size:11px;border: 1px solid black;">&#10003;</td>
            </tr>
            <tr>
                <td style="font-size:9px;border: 1px solid black;text-align:left">TGL PRODUKSI</td>
                <td style="font-size:9px;border: 1px solid black;"></td>
            </tr>
            <tr>
                <td style="font-size:9px;border: 1px solid black;text-align:left">MANUAL BOOK</td>
                <td style="font-size:11px;border: 1px solid black;">&#10003;</td>
            </tr>
            <tr>
                <td style="font-size:9px;border: 1px solid black;text-align:left">TOOL SET</td>
                <td style="font-size:11px;border: 1px solid black;">&#10003;</td>
            </tr>
            <tr>
                <td style="font-size:9px;border: 1px solid black;text-align:left">KUNCI KONTAK</td>
                <td style="font-size:11px;border: 1px solid black;">&#10003;</td>
            </tr>
        </table>
        </div>
<?php
$i++;
}
?>
