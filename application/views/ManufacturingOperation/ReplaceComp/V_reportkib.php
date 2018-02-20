<!DOCTYPE html>
<html>
    <head>
        <title>
        </title>
        <style type="text/css">
            body{
                font-size: 9px;
            }
            .text-center {
                text-align: center;
            }
            .table {
                width: 100%;
                max-width: 100%;
            }
            .table-bordered, .table-bordered td {
                border: 1px solid #c3c3c3;
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>
        <div style="width: 100%; display: inline-table;">
            <?php
                $checkout=0; foreach ($jobLineReject as $lr) {
                    if ($checkout!==0 && $checkout%6 == 0) {
                        echo '<div style="page-break-after:always;"></div>';
                    }
            ?>
                <div style="width: 48%; float: left; margin-left: 6px; margin-bottom: 6px;">
                    <div style="display: inline-block; border: 1px solid #b3b3b3; padding: 6px; height: 350px;">
                        <div style="float: left;width: 50%; font-size: 8px">
                            CV KARYA HIDUP SENTOSA
                            <br>
                            YOGYAKARTA
                        </div>
                        <div style="float: right;width: 50%;text-align: right;">
                            Tgl: <?php echo date("Y/m/d"); ?>
                        </div>
                        <div style="width: 100%;text-align: center; font-weight: bold; font-size: 14px">
                            KIB BARANG BERMASALAH
                        </div>
                        <table class="table table-bordered text-center">
                            <tr>
                                <td style="padding: 2px">
                                    <small>Dikembalikan ke Gudang :</small>
                                    <br><b>
                                        <?php echo $lr['subinventory_code']; ?>
                                    </b>
                                </td>
                                <td style="padding: 2px">
                                    <small>No. WIP Return/Line</small>
                                    <br><b>
                                        <?php
                                            foreach ($replacement_number as $rplNumb) {
                                                if ($rplNumb['subinventory_code'] == $lr['subinventory_code']) {
                                                    echo $rplNumb['replacement_number'];
                                                }
                                            }
                                        ?>
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 2px">
                                    <small>Seksi/Subkon ditemukan Barang :</small>
                                    <br><b>
                                        <?php echo $lr['section']; ?>
                                    </b>
                                </td>
                                <td style="padding: 2px">
                                    <small>Seksi/Subkon Pembuat Barang :</small>
                                    <br><b>
                                        <?php
                                            if (empty($lr['section_source'])) {
                                                echo '-';
                                            }else{
                                                echo $lr['section_source'];
                                            }
                                        ?>
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 2px">
                                    <small>No. Job/Batch :</small>
                                    <br><b>
                                        <?php echo $lr['job_number']; ?>
                                    </b>
                                </td>
                                <td style="padding: 2px">
                                    <small>Item Assy</small>
                                    <br><b>
                                        <?php echo $lr['assy_code']; ?>
                                    </b>
                                </td>
                            </tr>
                        </table>
                        <div style="height: 119px">
                            <table class="table" style="margin-bottom: 5px">
                                <tr>
                                    <td style="width: 50%; padding: 2px 2px 0px 3px;">
                                        <small>Kode Barang :</small>
                                    </td>
                                    <td style="text-align: right; padding: 2px 2px 0px 3px;">
                                        <small>Type Product :</small>
                                    </td>
                                    <td style="padding: 3px 3px 0px 3px;">
                                        <small><?php echo $lr['assy_description']; ?></small>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0px 2px 2px 2px;">
                                        <b><?php echo $lr['component_code']; ?></b><br>
                                    </td>
                                    <td style="text-align: right; padding: 0px 2px 2px 2px">
                                        <small>Qty : </small>
                                    </td>
                                    <td style="padding: 0px 2px 2px 2px">
                                        <b><?php echo $lr['return_quantity'].' '.$lr['uom']; ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 2px;" colspan="3">
                                        <small>Description :</small>
                                        <br>
                                        <?php echo $lr['component_description']; ?>
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding: 2px;">
                                        <small>Keterangan Reject :</small>
                                        <br>
                                        <?php echo $lr['return_information']; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <small>
                            Status Barang :
                        </small>
                        <table class="table table-bordered" style="text-align: center; margin-bottom: 5px;">
                            <tr>
                                <td style="padding: 2px;">Diterima</td>
                                <td style="padding: 2px;">Diterima</td>
                                <td style="padding: 2px;">Verifikasi</td>
                                <td style="padding: 2px;" colspan="2">Keputusan QC</td>
                            </tr>
                            <tr>
                                <td rowspan="3">
                                </td>
                                <td rowspan="3">
                                </td>
                                <td rowspan="3">
                                </td>
                                <td style="padding: 2px; text-align: left">
                                    <input type="checkbox"/>
                                    Scrap
                                </td>
                                <td style="padding: 2px; text-align: left">
                                    QTY:
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 2px; text-align: left">
                                    <input type="checkbox"/>
                                    Repair
                                </td>
                                <td style="padding: 2px; text-align: left">
                                    QTY:
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" rowspan="2" style="padding: 2px; text-align: left;height:40px;vertical-align: text-top;">
                                    Catatan :
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 2px;">Seksi Asal</td>
                                <td style="padding: 2px;">Gudang</td>
                                <td style="padding: 2px;">QC</td>
                            </tr>
                        </table>
                        <i style="font-size: 7px;">
                            FRM-WHS-01-PDN-XX
                        </i>
                    </div>
                </div>
            <?php
                $checkout++;
                }
            ?>
        </div>
    </body>
</html>