<!DOCTYPE html>
<html>
    <head>
        <title>
        </title>
        <link href="<?php echo base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css') ?>" rel="stylesheet" type="text/css">
        <style type="text/css">
            body{
                font-size: 10px;
            }
        </style>
    </head>
    <body>
        <div style="width: 100%; display: inline-table;">
            <?php foreach ($jobLine as $ln) { ?>
                <div style="width: 50%; float: left;">
                    <div style="display: inline-block; border: 1px solid #b3b3b3;padding: 10px;">
                        <div style="float: left;width: 50%;">
                            CV Karya Hidup Sentosa
                            <br>
                            Yogyakarta
                        </div>
                        <div style="float: right;width: 50%;text-align: right;">
                            Tgl: <?php echo date("Y/m/d"); ?>
                        </div>
                        <div style="width: 100%;text-align: center;">
                            <h4 style="font-weight: bold;">
                                KIB BARANG BERMASALAH
                            </h4>
                        </div>
                        <table class="table table-bordered text-center">
                            <tr>
                                <td style="padding: 4px">
                                    Dikembalikan ke Gudang :
                                    <br><b>
                                        KOM1-DM
                                    </b>
                                </td>
                                <td style="padding: 4px">
                                    No. WIP Return/Line
                                    <br><b>
                                        KOM1-180108001 / 1
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Seksi/Subkon ditemukan Barang :
                                    <br><b>
                                        PERAKITAN B
                                    </b>
                                </td>
                                <td>
                                    Seksi/Subkon Pembuat Barang :
                                    <br><b>
                                        SHEET METAL
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    No. Job/Batch :
                                    <br><b>
                                        D180010001
                                    </b>
                                </td>
                                <td>
                                    Item Assy
                                    <br><b>
                                        AAL5C0A001BY-1
                                    </b>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                    Kode Barang:
                                    <br>
                                </td>
                                <td>
                                    Type Product:
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Description:
                                    <br>
                                </td>
                                <td>
                                    QTY:
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Keterangan Reject:
                                    <br>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <span>
                            Status Barang:
                        </span>
                        <table class="table table-bordered" style="text-align: center">
                            <tr>
                                <td>
                                    Diterima
                                </td>
                                <td>
                                    Diterima
                                </td>
                                <td>
                                    Verifikasi
                                </td>
                                <td colspan="2">
                                    Keputusan QC
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="3">
                                </td>
                                <td rowspan="3">
                                </td>
                                <td rowspan="3">
                                </td>
                                <td style="text-align: left">
                                    <input type="checkbox"/>
                                    Scrap
                                </td>
                                <td style="text-align: left">
                                    QTY:
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left">
                                    <input type="checkbox"/>
                                    Repair
                                </td>
                                <td style="text-align: left">
                                    QTY:
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" rowspan="2" style="text-align: left;height:40px;vertical-align: text-top;">
                                    Catatan :
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Seksi Asal
                                </td>
                                <td>
                                    Gudang
                                </td>
                                <td>
                                    QC
                                </td>
                            </tr>
                        </table>
                        <i style="font-size: 7px">
                            FRM-WHS-01-PDN-XX
                        </i>
                    </div>
                </div>
            <?php } ?>
        </div>
    </body>
</html>