<?php
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
                <th rowspan="1" colspan="3"
                    style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                    URAIAN KERJA</th>
                <th rowspan="1"
                    style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                    STANDAR</th>
                <th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                    PERIODE</th>
                <th rowspan="1"
                    style="border: 1px solid black;border-collapse: collapse; font-size: 12px;  -webkit-transform: rotate(270deg);text-rotate:90">

                    <p>DURASI (menit)</p>
                </th>
                <th rowspan="1"
                    style="border: 1px solid black;border-collapse: collapse; font-size: 12px;  -webkit-transform: rotate(270deg);text-rotate:90">

                    <p>
                        KONDISI
                    </p>
                </th>
                <th rowspan="1"
                    style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                    CATATAN HASIL PREVENTIVE ATAU BILA DITEMUKAN KETIDAKNORMALAN MESIN</th>
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

                        if ($datapdf[$i]['KONDISI_MESIN'] == 'Mati') {
                        ?>
            <td width="10%" rowspan="<?php echo $mergeALT; ?>"
                style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;text-rotate:90 ">
                A. Pengecekan ketika mesin mati</td>

            <?php

                        } else if ($datapdf[$i]['KONDISI_MESIN'] == 'Beroperasi'){

                        ?>

            <td width="10%" rowspan="<?php echo $mergeALT; ?>"
                style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;text-rotate:90">
                B. Pengecekan ketika mesin beroperasi</td>
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
            <td colspan="8"
                style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; background-color: #fdd835">
                <?= $datapdf[$i]['HEADER_MESIN'] ?></td>
            <?php
                        $opr_no = $datapdf[$i]['HEADER_MESIN'];
                    }
                    ?>
            <?php
                }
                ?>
        </tr>
        <tr>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">
                &nbsp;&nbsp;<?= $i+1 ?>&nbsp;&nbsp;</td>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: left;font-size: 12px">
                <?= $datapdf[$i]['SUB_HEADER'] ?></td>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">
                <?= $datapdf[$i]['STANDAR'] ?></td>

            <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; ">
                <?= $datapdf[$i]['PERIODE'] ?></td>

            <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"> &nbsp;
                <?= $datapdf[$i]['DURASI'] ?> &nbsp;</td>

            <?php
                if ($datapdf[$i]['KONDISI'] == 'OK') {
                ?>
            <td
                style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; color:blue">
                &nbsp; <b>&#927;</b> &nbsp;</td>

            <?php

                } else if ($datapdf[$i]['KONDISI'] == 'MULAI RUSAK') {

                ?>
            <td
                style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;color:orange">
                &nbsp; <b>&#916;</b> &nbsp;</td>
            <?php

                } else if ($datapdf[$i]['KONDISI'] == 'RUSAK') {

                ?>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;color:red">
                &nbsp; <b>&#935;</b> &nbsp;</td>
            <?php

                } else {

                ?>
            <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;"> &nbsp;
                <b>&#8210; </b> &nbsp;</td>
            <?php

                }
                ?>

            <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">
                <?= $datapdf[$i]['CATATAN'] ?></td>
        </tr>

        <?php
            $no++;
        }  ?>
    </tbody>
    <tbody>
        <tr>
            <td colspan="4"
                style="border: 1px solid black;border-collapse: collapse; text-align: right;font-size: 12px">Total
                Durasi</td>
            <td colspan="4" style="border: 1px solid black;border-collapse: collapse; text-align: left;font-size: 12px">
                <?= $totalDurasi[0]['TOTAL_DURASI'] ?> Menit</td>
        </tr>
    </tbody>

</table>
<table>
    <tbody>
        <tr style="text-align:center; vertical-align:middle">
            <?php
        for ($g = 0; $g < sizeof($gambar); $g++) {
        ?>

            <td>
                <img style="max-width: 250px;max-height: 250px"
                    src="<?php echo base_url($gambar[$g]['FILE_DIR_ADDRESS']); ?>">
            </td>
            &nbsp;

            <?php }?>
        </tr>
    </tbody>
</table>