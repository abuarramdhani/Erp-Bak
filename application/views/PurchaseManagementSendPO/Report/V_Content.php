<html>
    <head>
        <style type="text/css">
            table{
                font-family: 'Times New Roman';
                font-size: 12px;
            }
            .table {
                width: 100%;
            }
            .table-head td {
                padding: 1px 3px;
            }
            .table-line td {
                padding: 4px 3px;
            }
            .title-spb{
                padding-top: 20px;
            }
            .table-bordered, .table-bordered td {
                border-left: 1px solid #8f8f8f;
                border-right: 1px solid #8f8f8f;
                border-collapse: collapse;
            }
            .table-no-border td {
                border : 0;
            }
            .hor-center {
                text-align: center;
            }
            .hor-right {
                text-align: right;
            }
            .tr-hor-mid td {
                text-align: center;
                vertical-align: middle;
            }
            .ver-center {
                vertical-align: middle;
            }
            .ver-top {
                vertical-align: top;
            }
        </style>
    </head>
    <body >
        <?php
            $p=1;
            $hal = 1;

            $COMPANY_NAME = $RESULT[0]['COMPANY_NAME'];
            $SITE = $RESULT[0]['SITE'];
            $ADDRESS = $RESULT[0]['ADDRESS'];
            $PHONE_NUMBER = $RESULT[0]['PHONE_NUMBER'];
            $EMAIL_ADDRESS = $RESULT[0]['EMAIL_ADDRESS'];
            $PERSON_IN_CHARGE = $RESULT[0]['PERSON_IN_CHARGE'];
        ?>
        <table class="table table-head table ">
            <tr>
                <td  class="no-right" colspan="7" >
                    <table width="100%" class="table-no-border">
                        <tr>
                            <td width="22%">COMPANY NAME</td>
                            <td width="2%">:</td>
                            <td width="76%" class="company_name"> <b><?php echo $COMPANY_NAME; ?></b></td>
                        </tr>
                        <tr>
                            <td>SITE</td>
                            <td>:</td>
                            <td><?php echo $SITE; ?></td>
                        </tr>
                        <tr>
                            <td>ADDRESS</td>
                            <td>:</td>
                            <td><?php echo $ADDRESS; ?></td>
                        </tr>
                        <tr>
                            <td>PHONE NUMBER</td>
                            <td>:</td>
                            <td><?php echo $PHONE_NUMBER; ?></td>
                        </tr>
                        <tr>
                            <td>EMAIL ADDRESS</td>
                            <td>:</td>
                            <td><?php echo $EMAIL_ADDRESS; ?></td>
                        </tr>
                        <tr>
                            <td>PERSON IN CHARGE</td>
                            <td>:</td>
                            <td><?php echo $PERSON_IN_CHARGE; ?></td>
                        </tr>
                    </table>
                </td>
                <td class="ver-top">
                    <table width="100%" class="table-no-border">
                        <tr>
                            <td >NO : </td>
                        </tr>
                        <tr>
                            <td>TANGGAL : </td>
                        </tr>
                        <tr>
                            <td>PO : <?php echo $NO_PO; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="hor-center"><img  style=" float:right;  opacity: 1 ; width:18mm; padding:;  height:auto;" src="<?php echo base_url('img/'.$NO_PO_QR.'.png'); ?>" /></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="8" class="hor-center title-spb">
                    <h3>SURAT PENGIRIMAN BARANG</h3>
                </td>
            </tr>
            <tr>
                <td colspan="8">
                    <table width="100%" class="table-no-border">
                        <tr>
                            <td>Kepada Yth.<br/>
                                CV. Karya Hidup Sentosa<br/>
                                Jl. Magelang No 144 Yogyakarta
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
        <div style="height: 100%; border-top: 0; border-bottom: 0; ">
            <table width="100%" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%" style="border-bottom:1px solid #8f8f8f;"></th>
                        <th width="7%" style="border-bottom:1px solid #8f8f8f;"></th>
                        <th width="7%" style="border-bottom:1px solid #8f8f8f;"></th>
                        <th width="7%" style="border-bottom:1px solid #8f8f8f;"></th>
                        <th width="8%" style="border-bottom:1px solid #8f8f8f;"></center></th>
                        <th width="14%" style="border-bottom:1px solid #8f8f8f;"></th>
                        <th width="22%" style="border-bottom:1px solid #8f8f8f;"></th>
                        <th width="15%" style="border-bottom:1px solid #8f8f8f;"></th>
                        <th width="15%" style="border-bottom:1px solid #8f8f8f;"></th>
                    </tr>
                    <tr class="tr-hor-mid" >
                        <td width="5%" style="border-top:1px solid #8f8f8f;border-bottom:1px solid #8f8f8f;"  rowspan="2">NO</td>
                        <td width="21%" style="border-top:1px solid #8f8f8f;border-bottom:1px solid #8f8f8f;" class="btm" colspan="3">QTY</td>
                        <td width="8%" style="border-top:1px solid #8f8f8f;border-bottom:1px solid #8f8f8f;" rowspan="2">UOM</td>
                        <td width="14%" style="border-top:1px solid #8f8f8f;border-bottom:1px solid #8f8f8f;" rowspan="2">ITEM CODE</td>
                        <td width="22%" style="border-top:1px solid #8f8f8f;border-bottom:1px solid #8f8f8f;" rowspan="2">ITEM DESCRIPTION</td>
                        <td width="15%" style="border-top:1px solid #8f8f8f;border-bottom:1px solid #8f8f8f;" rowspan="2">GDG</td>
                        <td width="15%" style="border-top:1px solid #8f8f8f;border-bottom:1px solid #8f8f8f;" rowspan="2">KET</td>
                    </tr>
                    <tr class="tr-hor-mid">
                        <td width="7%" style="border-bottom:1px solid #8f8f8f;" >Plan</td>
                        <td width="7%" style="border-bottom:1px solid #8f8f8f;">Kirim</td>
                        <td width="7%" style="border-bottom:1px solid #8f8f8f;">Act</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for ($x = 0; $x < sizeof($DETAIL); $x++){
                    ?>
                    <tr>
                        <td width="5%"><center><?php echo $x+1?></center></td>
                        <td width="7%"><center><?php echo $DETAIL[$x][0]['QTY_PLAN'] ?></center></td>
                        <td width="7%"></td>
                        <td width="7%"></td>
                        <td width="8%"><center><?php echo $DETAIL[$x][0]['UOM_CODE'] ?></center></td>
                        <td width="14%"><?php echo $DETAIL[$x][0]['KODE_BARANG'] ?></td>
                        <td width="22%"><?php echo $DETAIL[$x][0]['ITEM_DESCRIPTION'] ?></td>
                        <td width="15%"><?php echo $DETAIL[$x][0]['LOCATION_CODE'] ?></td>
                        <td width="15%"><?php echo $DETAIL[$x][0]['NOTE_TO_VENDOR'] ?></td>
                    </tr>
                    <tr>
                        <td width="5%" style="border-bottom:1px solid #8f8f8f;"></td>
                        <td width="7%" style="border-bottom:1px solid #8f8f8f;"></td>
                        <td width="7%" style="border-bottom:1px solid #8f8f8f;"></td>
                        <td width="7%" style="border-bottom:1px solid #8f8f8f;"></td>
                        <td width="8%" style="border-bottom:1px solid #8f8f8f;"></center></td>
                        <td width="14%" style="border-bottom:1px solid #8f8f8f;"></td>
                        <td width="22%" style="border-bottom:1px solid #8f8f8f;"></td>
                        <td width="15%" style="border-bottom:1px solid #8f8f8f;"></td>
                        <td width="15%" style="border-bottom:1px solid #8f8f8f;"></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table><br><br>
            <table class="table table-head table ">
                <tr>
                    <td>
                    <table class="table-no-border hor-center" width="100%">
                        <tr>
                            <td width="30%"></td>
                            <td width="40%">&nbsp;</td>
                            <td width="30%">___________, ____/____/_______</td>
                        </tr>
                        <tr>
                            <td>Diterima Oleh,</td>
                            <td></td>
                            <td>Dikirim Oleh,</td>
                        </tr>
                        <tr>
                            <td height="40px">&nbsp;</td>
                            <td></td>
                            <td height="40px">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
                            <td></td>
                            <td>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
                        </tr>
                    </table>
                    </td>
                </tr>
			</table>
        </div>
    </body>
</html>
