<?php 
// echo "<pre>";print_r($data);exit();
$i = 1;
foreach ($data as $val) { 
    if ($data[0]['size'] == 1) {
        $a = 12;
        $b = 19;
        $c = 17;
        $d = 67;
        $e = 550;
        $f = 19;
        if (str_word_count($val['desc']) > 9 && str_word_count($val['desc']) < 23) {
            $f =12;
        }elseif (str_word_count($val['desc']) > 23) {
            $f =10;
        }
    }elseif ($data[0]['size'] == 2) {
        $a = 12;
        $b = 17;
        $c = 15;
        $d = 65;
        $e = 438;
        $f = 17;
        if (str_word_count($val['desc']) > 8 && str_word_count($val['desc']) < 20) {
            $f =11;
        }elseif (str_word_count($val['desc']) > 20) {
            $f =9;
        }
    }elseif ($data[0]['size'] == 3) {
        $a = 11;
        $b = 15;
        $c = 14;
        $d = 55;
        $e = 365;
        $f = 15;
        if (str_word_count($val['desc']) > 8 && str_word_count($val['desc']) < 18) {
            $f =9;
        }elseif (str_word_count($val['desc']) > 18) {
            $f =7;
        }
    }elseif ($data[0]['size'] == 4) {
        $a = 9;
        $b = 10;
        $c = 11;
        $d = 45;
        $e = 255;
        $f = 10;
        if (str_word_count($val['desc']) > 6 && str_word_count($val['desc']) < 16) {
            $f =8;
        }elseif (str_word_count($val['desc']) > 16) {
            $f =6;
        }
    }

if ($i > 7 && $val['size'] != 4) {
    $i = 1;
    echo '<pagebreak resetpagenum="1" />';
}elseif ($i > 20 && $val['size'] == 4) {
    $i = 1;
    echo '<pagebreak resetpagenum="1" />';
}
    ?>
    <div style="width: <?= $e?>px; float: left; padding-top:27px;padding-left:70px;text-align:center">
    <table style="border-collapse: collapse;width:100%;text-align:center" >
        <tr>
            <td style="width:20%;font-size:<?= $a?>px;border: 1px solid black;font-weight:bold"><?= $val['rak']?></td>
            <td rowspan="2" style="width:60%;font-size:<?= $f?>px;border: 1px solid black;font-weight:bold"><?= $val['desc']?></td>
            <td rowspan="2" style="width:10%;font-size:<?= $a?>px;border-top: 1px solid black">QTY/ UNIT</td>
            <td rowspan="2" style="width:10%;font-size:<?= $c?>px;border-top: 1px solid black;border-right: 1px solid black;font-weight:bold"><?= $val['qty']?></td>
        </tr>
        <tr>
            <td rowspan="3" style="border: 1px solid black"><img style="width: <?= $d?>px;height: <?= $d?>px" src="<?php echo base_url('img/'.$val['kode'].'.png'); ?>"></td>
        </tr>
        <tr>
            <td rowspan="2" style="font-size:<?= $b?>px;border: 1px solid black;font-weight:bold;background-color:#54E3FF"><?= $val['kode']?></td>
            <td rowspan="2" style="font-size:<?= $a?>px;border-top: 1px solid black;border-bottom: 1px solid black;">STD HDL</td>
            <td rowspan="2" style="font-size:<?= $c?>px;border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;font-weight:bold"><?= $val['stp']?></td>
        </tr>
    </table>
    </div>
<?php
$i++;
}
?>