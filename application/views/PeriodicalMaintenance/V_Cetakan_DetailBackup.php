<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $datapdf['0']['DOCUMENT_NUMBER'] ?></title>
</head>

<body>
    <?php
    ?>
    <table style="border: 2px solid black; border-collapse: collapse; width: 100%;">
        <thead>

            <thead>
                <tr style="background-color: white;">
                    <th rowspan="1" colspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                        URAIAN KERJA</th>
                    <th rowspan="1" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                        STANDAR</th>
                    <th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                        PERIODE</th>
                    <th rowspan="1" style="border: 1px solid black;border-collapse: collapse; font-size: 12px;  -webkit-transform: rotate(270deg);text-rotate:90">

                        <p>DURASI (menit)</p>
                    </th>
                    <th rowspan="1" style="border: 1px solid black;border-collapse: collapse; font-size: 12px;  -webkit-transform: rotate(270deg);text-rotate:90">

                        <p>
                            KONDISI
                        </p>
                    </th>
                    <th rowspan="1" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                        CATATAN HASIL PREVENTIVE ATAU BILA DITEMUKAN KETIDAKNORMALAN MESIN</th>
                </tr>
            </thead>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $kondisi = '#$%';
            $head = '#$%';

            for ($i = 0; $i < sizeof($datapdf); $i++) {
            ?>
                <tr>
                    <?php
                    if (sizeof($arrayR['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']]) <= sizeof($arrayR['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']])) {
                        $counth = sizeof(array_unique($arrayR['HEADER_MESIN'][$datapdf[$i]['KONDISI_MESIN']]));
                        $mergeALT = sizeof($arrayR['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']]) + $counth + 1;

                        if ($kondisi != $datapdf[$i]['KONDISI_MESIN']) { ?>
                            <?php
                            if ($datapdf[$i]['KONDISI_MESIN'] == 'Mati') {
                            ?>
                                <td bgcolor="#e0e0e0" colspan="8" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                                    A. Pengecekan ketika mesin mati
                                </td>
                            <?php } else if ($datapdf[$i]['KONDISI_MESIN'] == 'Beroperasi') { ?>
                                <td bgcolor="#e0e0e0" colspan="8" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                                    B. Pengecekan ketika mesin beroperasi
                                </td>
                            <?php } else { ?>
                                <td bgcolor="#e0e0e0" colspan="8" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                                    -
                                </td>
                            <?php
                                }
                            ?>
                        <?php
                            $kondisi = $datapdf[$i]['KONDISI_MESIN'];
                            }
                        ?>
                    <?php
                        }
                    ?>
                </tr>
                <tr>
                    <td style="border: 0px solid black;border-collapse: collapse; text-align: center;font-size: 12px;"></td>
                    <?php
                    if (sizeof($arrayR['HEADER_MESIN'][$datapdf[$i]['HEADER_MESIN']]) <= sizeof($arrayR['HEADER_MESIN'][$datapdf[$i]['HEADER_MESIN']])) {
                        if ($head != $datapdf[$i]['HEADER_MESIN']) {
                    ?>
                        <?php
                            if ($datapdf[$i]['HEADER_MESIN'] == null) { ?>
                            <td colspan="7" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; background-color: #ffffff">
                                -
                            </td>
                        <?php } else { ?>
                            <td colspan="7" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; background-color: #ffffff">
                                <?= $datapdf[$i]['HEADER_MESIN'] ?>
                            </td>
                        <?php } ?>
                        <?php
                            $head = $datapdf[$i]['HEADER_MESIN'];
                        }
                        ?>
                    <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td style="border: 0px solid black;border-collapse: collapse; text-align: center;font-size: 12px;"></td>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">
                        &nbsp;&nbsp;<?= $i + 1 ?>&nbsp;&nbsp;
                    </td>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: left;font-size: 12px">
                        <?= $datapdf[$i]['SUB_HEADER'] ?>
                    </td>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">
                        <?= $datapdf[$i]['STANDAR'] ?>
                    </td>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; ">
                        <?= $datapdf[$i]['PERIODE'] ?>
                    </td>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"> 
                        &nbsp; <?= $datapdf[$i]['DURASI'] ?> &nbsp;
                    </td>

                    <?php if ($datapdf[$i]['KONDISI'] == 'OK') { ?>
                        <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; color:blue">
                            &nbsp; <b>&#927;</b> &nbsp;
                        </td>
                    <?php } else if ($datapdf[$i]['KONDISI'] == 'MULAI RUSAK') { ?>
                        <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;color:orange">
                            &nbsp; <b>&#916;</b> &nbsp;
                        </td>
                    <?php } else if ($datapdf[$i]['KONDISI'] == 'RUSAK') { ?>
                        <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;color:red">
                            &nbsp; <b>&#935;</b> &nbsp;
                        </td>
                    <?php } else { ?>
                        <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;"> 
                            &nbsp;<b>&#8210; </b> &nbsp;
                        </td>
                    <?php
                        }
                    ?>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">
                        <?= $datapdf[$i]['CATATAN'] ?>
                    </td>
                </tr>
            <?php
                $no++;
            }  ?>
        </tbody>
        <tbody>
            <tr>
                <td colspan="5" style="border: 1px solid black;border-collapse: collapse; text-align: right;font-size: 12px">Total
                    Durasi</td>
                <td colspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: left;font-size: 12px">
                    <?php echo $totalDurasi[0]['TOTAL_DURASI'] ?> Menit <?php
                                                                        $init = $totalDurasi[0]['TOTAL_DURASI'] * 60;
                                                                        $hours = floor($init / 3600);
                                                                        $minutes = floor(($init / 60) % 60);
                                                                        $seconds = $init % 60;

                                                                        echo "($hours jam $minutes menit $seconds detik)";
                                                                        ?></td>
            </tr>
            <tr>
                <td colspan="5" style="border: 1px solid black;border-collapse: collapse; text-align: right;font-size: 12px">
                    Catatan Temuan Lain lain 
                </td>
                <?php
                    if ($datapdf['0']['CATATAN_TEMUAN'] == null) {
                ?>
                    <td colspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"> - </td> 
                <?php } else { ?>
                    <td colspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">
                        <?= $datapdf['0']['CATATAN_TEMUAN'] ?>
                    </td>
                <?php } ?>
            </tr>
        </tbody>
    </table>
</body>