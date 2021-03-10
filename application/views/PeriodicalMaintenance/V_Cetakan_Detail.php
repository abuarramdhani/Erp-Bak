<?php
// echo "<pre>";
// print_r(sizeof($arrayR['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']])+sizeof($arrayR['HEADER_MESIN']));
// exit();
?>
<style type="text/css">
    table {
        page-break-inside: avoid;
        width: 100%
    }

    tbody {
        display: block;
        width: 100%;
        page-break-inside: avoid;
    }

    tr {
        page-break-inside: avoid;
        -webkit-region-break-inside: avoid;
    }


    td {
        page-break-inside: avoid;
        font-size: 12px;
    }

    /* table {page-break-before: always;  } 
tr{page-break-inside: avoid;  
           page-break-after: auto;}  */
</style>
<table autosize="1" style="border: 2px solid black; border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="background-color: white;">
            <th rowspan="3" colspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">URAIAN KERJA</th>
            <th rowspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">STANDAR</th>
            <th colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">PERIODE</th>
            <th rowspan="3" style="border: 1px solid black;border-collapse: collapse; font-size: 12px;  -webkit-transform: rotate(270deg);text-rotate:90">
                <!-- <p style="-ms-writing-mode: tb-rl;   -webkit-writing-mode: vertical-rl;    writing-mode: vertical-rl; white-space: nowrap;">
                    DURASI <br> (menit)
                </p> -->
                <p>DURASI (menit)</p>
            </th>
            <th rowspan="3" style="border: 1px solid black;border-collapse: collapse; font-size: 12px;  -webkit-transform: rotate(270deg);text-rotate:90">
                <!-- <p style="-ms-writing-mode: tb-rl;   -webkit-writing-mode: vertical-rl;    writing-mode: vertical-rl;  white-space: nowrap;">
                    KONDISI
                </p> -->
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
            <!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;"></td>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;"></td> -->
            <?php

            // echo $datapdf['0']['TYPE_MESIN']; exit();
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
    <tbody>
        <?php
        $no = 1;
        $b = 0;
        $num = sizeof($datapdf);

        for ($i = 0; $i < sizeof($datapdf); $i++) {
        ?>
            <tr>
                <?php
                if (sizeof($arrayR['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']]) <= sizeof($arrayR['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']])) {
                    $mergeALT = sizeof($arrayR['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']]);
                    if ($alter != $datapdf[$i]['KONDISI_MESIN']) {
                ?>
                        <!-- <td width="10%" rowspan="<?php echo $mergeALT; ?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;"><?= $datapdf[$i]['KONDISI_MESIN'] ?></td> -->
                        <?php

                        if ($datapdf[$i]['KONDISI_MESIN'] == 'Mati') {
                        ?>
                            <td width="10%" rowspan="<?php echo $mergeALT; ?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;text-rotate:90">A. Pengecekan ketika mesin mati</td>

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
                } else {
                    $mergeALT = sizeof($arrayR['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']]);
                    if ($routing_seq != $datapdf[$i]['KONDISI_MESIN']) {
                    ?>
                        <?php

                        if ($datapdf[$i]['KONDISI_MESIN'] == 'Mati') {
                        ?>
                            <td width="10%" rowspan="<?php echo $mergeALT; ?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;text-rotate:90 ">A. Pengecekan ketika mesin mati</td>

                        <?php

                        } else {

                        ?>

                            <td width="10%" rowspan="<?php echo $mergeALT; ?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;text-rotate:90">B. Pengecekan ketika mesin beroperasi</td>
                        <?php

                        }
                        ?> <?php
                    }
                }
                        ?>

                <?php
                if (sizeof($arrayR['HEADER_MESIN'][$datapdf[$i]['HEADER_MESIN']]) <= sizeof($arrayR['HEADER_MESIN'][$datapdf[$i]['HEADER_MESIN']])) {
                    $mergeOPR = sizeof($arrayR['HEADER_MESIN'][$datapdf[$i]['HEADER_MESIN']]);
                    if ($opr_no != $datapdf[$i]['HEADER_MESIN']) {
                ?>
                        <td rowspan="<?php echo $mergeOPR; ?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; text-rotate:90"><?= $datapdf[$i]['HEADER_MESIN'] ?></td>
                    <?php
                        $opr_no = $datapdf[$i]['HEADER_MESIN'];
                    }
                } else {
                    $mergeOPR = sizeof($arrayR['HEADER_MESIN'][$datapdf[$i]['HEADER_MESIN']]);
                    if ($opr_seq1 != $datapdf[$i]['HEADER_MESIN']) {
                    ?>
                        <td rowspan="<?php echo $mergeOPR; ?>" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; text-rotate:90"><?= $datapdf[$i]['HEADER_MESIN'] ?></td>
                <?php
                        $opr_seq1 = $datapdf[$i]['HEADER_MESIN'];
                    }
                }
                ?>
                <!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; "><?= $no ?></td> -->
                <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; "><?= $datapdf[$i]['SUB_HEADER'] ?></td>
                <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf[$i]['STANDAR'] ?></td>
                <!-- <td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf[$i]['PERIODE'] ?></td> -->

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
                <!-- <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"> -->

                <!-- <?= $datapdf[$i]['KONDISI'] ?> -->

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
                <?php
                $b++;
                // if($b  != $num ){
                //     if($b%4 == 0){
                //     echo "<pagebreak>";
                //     }
                // }
                ?>


            </tr>



        <?php

            $no++;

            // if($i  != $num ){
            //     if($i%14 == 0){
            //       echo "<pagebreak>";
            //     }
            //   }

        }

        ?>
    </tbody>
    <tbody>
        <tr>
            <td colspan="6" style="border: 1px solid black;border-collapse: collapse; text-align: right;font-size: 12px">Total Durasi</td>
            <td colspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: left;font-size: 12px"><?= $totalDurasi[0]['TOTAL_DURASI'] ?> Menit</td>
        </tr>
    </tbody>
</table>