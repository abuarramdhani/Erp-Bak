<?php
// echo "<pre>";
// print_r(sizeof($arrayR['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']])+sizeof($arrayR['HEADER_MESIN']));
// exit();
?>
<style>
    #page-border {
        width: 100%;
        height: 100%;
        border: 1px solid black;
        padding: 5px;
    }

    th.vertical {
        text-align: center;
        white-space: nowrap;
        transform-origin: 50% 50%;
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
    }
</style>
<table style="border: 2px solid black; border-collapse: collapse; width: 100%;">
    <thead>

        <thead>
            <tr style="background-color: white;">
                <th rowspan="3" colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">URAIAN KERJA</th>
                <th rowspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">STANDAR</th>
                <th colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">PERIODE</th>
                <th rowspan="3" style="border: 1px solid black;border-collapse: collapse; font-size: 12px;  -webkit-transform: rotate(270deg);text-rotate:90">

                    <p>DURASI (menit)</p>
                </th>
                <th rowspan="3" style="border: 1px solid black;border-collapse: collapse; font-size: 12px;  -webkit-transform: rotate(270deg);text-rotate:90">

                    <p>
                        KONDISI
                    </p>
                </th>
                <th rowspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">CATATAN HASIL PREVENTIVE ATAU BILA DITEMUKAN KETIDAKNORMALAN MESIN</th>
            </tr>
            <tr>
                <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;"><b>2M</b></td>
                <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;"><b>TH</b></td>
            </tr>
            <tr>

                <?php

                if ($datapdf['0']['PERIODE_CHECK'] == '2 Mingguan') {
                ?>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;color:red;"><b>V</b></td>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;"></td>
                <?php

                } else {

                ?>

                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;"></td>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;color:red;"><b>V</b></td>
                <?php

                }
                ?>
            </tr>
        </thead>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $alter = '#$%';
        $opr_no = '#$%';
        $opr_seq1 = '#$%';

        for ($i = 0; $i < sizeof($datapdf); $i++) {
        ?>
            <tr>
                <?php
                // echo "<pre>";
                // print_r(sizeof($arrayR['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']])+sizeof($arrayR['HEADER_MESIN']));
                // exit();
                if (sizeof($arrayR['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']]) <= sizeof($arrayR['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']])) {
                    $mergeALT0 = sizeof($arrayR['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']]) + sizeof($arrayR['HEADER_MESIN']) + 1;
                    
                    if($mergeALT0%2 == 0){
                        $mergeALT = $mergeALT0 ;
                    } else {
                        $mergeALT = $mergeALT0;
                    }
                    
                    
                    if ($alter != $datapdf[$i]['KONDISI_MESIN']) {
                ?>

                        <?php
                        
                        // echo "<pre>";
                        // print_r($mergeALT);
                        // exit();


                        if ($datapdf[$i]['KONDISI_MESIN'] == 'Mati') {
                        ?>
                            <td width="10%" rowspan="<?php echo $mergeALT; ?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;text-rotate:90 ">A. Pengecekan ketika mesin mati</td>

                        <?php

                        } else {

                        ?>

                            <td width="10%" rowspan="<?php echo $mergeALT; ?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;text-rotate:90">B. Pengecekan ketika mesin beroperasi</td>
                        <?php

                        }
                        ?>
                    <?php
                        $alter = $datapdf[$i]['KONDISI_MESIN'];
                    }
                    ?>
                <?php
                }
                ?>
            </tr>
            <tr>
                <?php
                if (sizeof($arrayR['HEADER_MESIN'][$datapdf[$i]['HEADER_MESIN']]) <= sizeof($arrayR['HEADER_MESIN'][$datapdf[$i]['HEADER_MESIN']])) {
                    if ($opr_no != $datapdf[$i]['HEADER_MESIN']) {
                ?>
                        <td colspan="7" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; background-color: #fdd835"><?= $datapdf[$i]['HEADER_MESIN'] ?></td>
                    <?php
                        $opr_no = $datapdf[$i]['HEADER_MESIN'];
                    }
                    ?>
                <?php
                }
                ?>
            </tr>
            <tr>
                <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf[$i]['SUB_HEADER'] ?></td>
                <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf[$i]['STANDAR'] ?></td>
                
                <?php

                if ($datapdf[$i]['PERIODE'] == '2 Mingguan') {
                ?>
                    <td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; color:green"><?= $datapdf[$i]['PERIODE'] ?></td>

                <?php

                } else {

                ?>

                    <td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; color:blue"><?= $datapdf[$i]['PERIODE'] ?></td>
                <?php

                }
                ?>

                <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"> &nbsp; <?= $datapdf[$i]['DURASI'] ?> &nbsp;</td>

                <?php
                if ($datapdf[$i]['KONDISI'] == 'OK') {
                ?>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; color:blue"> &nbsp; <b>&#927;</b> &nbsp;</td>

                <?php

                } else if ($datapdf[$i]['KONDISI'] == 'MULAI RUSAK') {

                ?>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;color:orange"> &nbsp; <b>&#916;</b> &nbsp;</td>
                <?php

                } else if ($datapdf[$i]['KONDISI'] == 'RUSAK') {

                ?>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;color:red"> &nbsp; <b>&#935;</b> &nbsp;</td>
                <?php

                } else {

                ?>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;"> &nbsp; <b>&#8210; </b> &nbsp;</td>
                <?php

                }
                ?>



                <!-- </td> -->
                <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf[$i]['CATATAN'] ?></td>
            </tr>

        <?php
            $no++;
        }  ?>
    </tbody>
    <tbody>
        <tr>
            <td colspan="5" style="border: 1px solid black;border-collapse: collapse; text-align: right;font-size: 12px">Total Durasi</td>
            <td colspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: left;font-size: 12px"><?= $totalDurasi[0]['TOTAL_DURASI'] ?> Menit</td>
        </tr>
    </tbody>
</table>