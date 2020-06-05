<style>
td {
    font-family:Arial;
}
</style>
<?php
// echo "<pre>";print_r($data);exit();
$i = 1; $no = 1;
foreach ($data as $val) { 
    if ($i > 6) {
        $i = 1;
        echo '<pagebreak resetpagenum="1" />';
    }
    if ($no > 9 && $no < 99) {
        $w1 = 30;
        $w2 = 70;
        $f = 100;
        $q = 110;
        $b = 14.5;
        $a = 21;
        $sty = 'padding-bottom:28px;padding-top:30px';
    }elseif ($no > 99) {
        $w1 = 10;
        $w2 = 90;
        $f = 100;
        $q = 140;
        $b = 20;
        $a = 30;
        $sty = 'padding-bottom:60px;padding-top:60px';
    }else{
        $w1 = 50;
        $w2 = 50;
        $f = 90;
        $q = 75;
        $b = 9;
        $a = 15;
        $sty = '';
    }
    ?>
    <div style="width: 210px; float: left; padding-top:50px;padding-left:80px;text-align:center">
        <table style="border-collapse: collapse;width:100%;text-align:center" >
            <tr>
                <td style="width: <?= $w1?>%;font-size:<?= $f?>px;border: 1px solid black;font-weight:bold;<?= $sty?>"><?= $no?></td>
                <td style="width: <?= $w2?>%;border: 1px solid black;"><img style="width: <?= $q?>px;height: <?= $q?>px" src="<?php echo base_url('img/'.$val['engine'].'_'.$val['body'].'.png'); ?>"></td>
            </tr>
            <tr>
                <td colspan="2" style="font-size:<?= $a?>px;border: 1px solid black;font-weight:bold">A360</td>
            </tr>
            <tr>
                <td style="font-size:<?= $b?>px;border: 1px solid black;text-align:left">NO. ENGINE</td>
                <td style="font-size:<?= $b?>px;border: 1px solid black;"><?= $val['engine']?></td>
            </tr>
            <tr>
                <td style="font-size:<?= $b?>px;border: 1px solid black;text-align:left">NO. BODY</td>
                <td style="font-size:<?= $b?>px;border: 1px solid black;"><?= $val['body']?></td>
            </tr>
            <tr>
                <td style="font-size:<?= $b?>px;border: 1px solid black;text-align:left">COUNTER WEIGHT</td>
                <td style="font-size:<?= $b?>px;border: 1px solid black;"><?= $val['weight']?></td>
            </tr>
            <tr>
                <td style="font-size:<?= $b?>px;border: 1px solid black;text-align:left">3 POINT LINK</td>
                <td style="font-size:11px;border: 1px solid black;">&#10003;</td>
            </tr>
            <tr>
                <td style="font-size:<?= $b?>px;border: 1px solid black;text-align:left">ATAP</td>
                <td style="font-size:11px;border: 1px solid black;">&#10003;</td>
            </tr>
            <tr>
                <td style="font-size:<?= $b?>px;border: 1px solid black;text-align:left">TGL PRODUKSI</td>
                <td style="font-size:<?= $b?>px;border: 1px solid black;"></td>
            </tr>
            <tr>
                <td style="font-size:<?= $b?>px;border: 1px solid black;text-align:left">MANUAL BOOK</td>
                <td style="font-size:11px;border: 1px solid black;">&#10003;</td>
            </tr>
            <tr>
                <td style="font-size:<?= $b?>px;border: 1px solid black;text-align:left">TOOL SET</td>
                <td style="font-size:11px;border: 1px solid black;">&#10003;</td>
            </tr>
            <tr>
                <td style="font-size:<?= $b?>px;border: 1px solid black;text-align:left">KUNCI KONTAK</td>
                <td style="font-size:11px;border: 1px solid black;">&#10003;</td>
            </tr>
        </table>
        </div>
<?php
$i++; $no++;
}
?>
