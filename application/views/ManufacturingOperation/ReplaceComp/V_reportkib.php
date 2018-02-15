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
            <?php foreach ($jobLineReject as $lr) { ?>
                <div style="width: 48%; float: left; margin: 8px;">
                    <div style="display: inline-block; border: 1px solid #b3b3b3; padding: 8px;">
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
                                <td style="padding: 3px">
                                    <small>Dikembalikan ke Gudang :</small>
                                    <br><b>
                                        <?php echo $lr['subinventory_code']; ?>
                                    </b>
                                </td>
                                <td style="padding: 3px">
                                    <small>No. WIP Return/Line</small>
                                    <br><b>
                                        <?php echo $replacement_number; ?>
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 3px">
                                    <small>Seksi/Subkon ditemukan Barang :</small>
                                    <br><b>
                                        <?php echo $lr['section']; ?>
                                    </b>
                                </td>
                                <td style="padding: 3px">
                                    <small>Seksi/Subkon Pembuat Barang :</small>
                                    <br><b>
                                        <?php echo $lr['section_source']; ?>
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 3px">
                                    <small>No. Job/Batch :</small>
                                    <br><b>
                                        <?php echo $lr['job_number']; ?>
                                    </b>
                                </td>
                                <td style="padding: 3px">
                                    <small>Item Assy</small>
                                    <br><b>
                                        <?php echo $lr['assy_code']; ?>
                                    </b>
                                </td>
                            </tr>
                        </table>
                        <table class="table">
                            <tr>
                                <td style="width: 50%; padding: 3px 3px 0px 3px;">
                                    <small>Kode Barang :</small>
                                </td>
                                <td style="text-align: right; padding: 3px 3px 0px 3px;">
                                    <small>Type Product :</small>
                                </td>
                                <td style="padding: 3px 3px 0px 3px;">
                                    <small><?php echo $lr['assy_description']; ?></small>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0px 3px 3px 3px;">
                                    <b><?php echo $lr['component_code']; ?></b><br>
                                </td>
                                <td style="text-align: right; padding: 0px 3px 3px 3px">
                                    <small>QTY : </small>
                                </td>
                                <td style="padding: 0px 3px 3px 3px">
                                    <b><?php echo $lr['return_quantity']; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 3px;" colspan="3">
                                    <small>Description :</small>
                                    <br>
                                    <?php echo $lr['component_description']; ?>
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding: 3px;">
                                    <small>Keterangan Reject :</small>
                                    <br>
                                    <?php echo $lr['return_information']; ?>
                                </td>
                            </tr>
                        </table>
                        <span>
                            Status Barang:
                        </span>
                        <table class="table table-bordered" style="text-align: center">
                            <tr>
                                <td style="padding: 3px;">Diterima</td>
                                <td style="padding: 3px;">Diterima</td>
                                <td style="padding: 3px;">Verifikasi</td>
                                <td style="padding: 3px;" colspan="2">Keputusan QC</td>
                            </tr>
                            <tr>
                                <td rowspan="3">
                                </td>
                                <td rowspan="3">
                                </td>
                                <td rowspan="3">
                                </td>
                                <td style="padding: 3px; text-align: left">
                                    <input type="checkbox"/>
                                    Scrap
                                </td>
                                <td style="padding: 3px; text-align: left">
                                    QTY:
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 3px; text-align: left">
                                    <input type="checkbox"/>
                                    Repair
                                </td>
                                <td style="padding: 3px; text-align: left">
                                    QTY:
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" rowspan="2" style="padding: 3px; text-align: left;height:40px;vertical-align: text-top;">
                                    Catatan :
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 3px;">Seksi Asal</td>
                                <td style="padding: 3px;">Gudang</td>
                                <td style="padding: 3px;">QC</td>
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