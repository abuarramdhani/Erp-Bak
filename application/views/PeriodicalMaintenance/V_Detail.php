<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $datapdf['0']['NAMA_MESIN'] ?></title>
</head>

<body>
    <?php
    ?>
    <table style="border: 2px solid black; border-collapse: collapse; width: 100%;">
        <thead>

            <thead>
                <tr style="background-color: white;">
                    <th rowspan="1" colspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                        URAIAN KERJA
                    </th>
                    <th rowspan="1" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                        STANDAR
                    </th>
                    <th style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                        PERIODE
                    </th>
                    <th rowspan="1" style="border: 1px solid black;border-collapse: collapse; font-size: 12px;  -webkit-transform: rotate(270deg);text-rotate:90">
                        <p>DURASI (menit)</p>
                    </th>
                    <th rowspan="1" style="border: 1px solid black;border-collapse: collapse; font-size: 12px;  -webkit-transform: rotate(270deg);text-rotate:90">
                        <p>KONDISI</p>
                    </th>
                    <th rowspan="1" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                        CATATAN HASIL PREVENTIVE ATAU BILA DITEMUKAN KETIDAKNORMALAN MESIN
                    </th>
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
                        $counth = sizeof(array_unique($arrayR['HEADER'][$datapdf[$i]['KONDISI_MESIN']]));
                        $mergeALT = sizeof($arrayR['KONDISI_MESIN'][$datapdf[$i]['KONDISI_MESIN']]) + $counth + 1;

                        if ($kondisi != $datapdf[$i]['KONDISI_MESIN']) { ?>
                            <?php
                                if ($datapdf[$i]['KONDISI_MESIN'] == 'Mati') {
                            ?>
                                <td bgcolor="#e0e0e0" colspan="8" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;">
                                    A. Pengecekan ketika mesin mati
                                </td>
                            <?php } else if($datapdf[$i]['KONDISI_MESIN'] == 'Beroperasi') {?>
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
                    if (sizeof($arrayR['HEADER'][$datapdf[$i]['HEADER']]) <= sizeof($arrayR['HEADER'][$datapdf[$i]['HEADER']])) {
                        if ($head != $datapdf[$i]['HEADER']) {
                    ?>
                            <?php
                            if ($datapdf[$i]['HEADER'] == null) {
                            ?>
                                <td colspan="7" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; background-color: #ffffff">
                                    - 
                                </td>
                            <?php } else { ?>
                                <td colspan="7" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; background-color: #ffffff">
                                    <?= $datapdf[$i]['HEADER'] ?>
                                </td>
                            <?php } ?>
                        <?php
                            $head = $datapdf[$i]['HEADER'];
                        }
                        ?>
                    <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td style="border: 0px solid black;border-collapse: collapse; text-align: center;font-size: 12px;"></td>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">
                        &nbsp;<?= $i + 1 ?>&nbsp;
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
                        &nbsp;
                    </td>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;"> 
                        &nbsp;&nbsp;
                    </td>
                    <td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">
                    </td>
                </tr>
            <?php
                $no++;
            }  ?>
        </tbody>
        <tbody>
            <tr>
                <td colspan="5" style="border: 1px solid black;border-collapse: collapse; text-align: right;font-size: 12px">Total
                    Durasi
                </td>
                <td colspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: left;font-size: 12px">
                </td>
            </tr>
            <tr>
                <td colspan="5" style="border: 1px solid black;border-collapse: collapse; text-align: right;font-size: 12px">
                    Catatan Temuan Lain lain 
                </td>
                <td colspan="3" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">
                    &nbsp;
                </td>
            </tr>
        </tbody>
    </table>
</body>