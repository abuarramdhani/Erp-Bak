<?php foreach ($car as $c) { ?>
    <!-- Page1 -->
    <strong style="font-size:10pt;font-family:arial">Filled By CV. KHS</strong>
    <table style="width: 100%;border:1px solid black;border-collapse:collapse;font-family:arial;font-size:10pt;">
        <tr>
            <td style="padding-left:10px;padding-top:10px;font-size:10pt" colspan="3"><strong>Requested To</strong></td>
        </tr>
        <tr>
            <td style="padding-left:10px;font-size:10pt;width:125px">Company Name</td>
            <td style="padding-left:10px;font-size:10pt" colspan="2">: <?= $c['SUPPLIER_NAME'] ?></td>
        </tr>
        <tr>
            <td style="padding-left:10px;font-size:10pt">Attendance Name</td>
            <td style="padding-left:10px;font-size:10pt" colspan="2">: <?= $c['ATTENDANCE'] ?></td>
        </tr>
        <tr>
            <td style="padding-left:10px;padding-top:10px;font-size:10pt;border-top:1px solid black;border-collapse:collapse" colspan="3"><strong>Description of Complained/Claimed Product</strong></td>
        </tr>
        <?php $count = sizeof($c['DETAIL']);
        if ($count > 1) {
            $item = 'VARIOUS';
            $qty = 'VARIOUS';
        } else {
            $item = $c['DETAIL'][0]['ITEM_CODE'];
            $qty = $c['DETAIL'][0]['QTY_PO'];
        } ?>

        <?php $count = sizeof($c['PO']);
        if ($count > 1) {
            $po = 'VARIOUS';
        } else {
            $po = $c['DETAIL'][0]['PO_NUMBER'];
        } ?>
        <tr>
            <td style="padding-left:10px;font-size:10pt">Item name</td>
            <td style="padding-left:10px;font-size:10pt" colspan="2">: <?= $item ?></td>
        </tr>
        <tr>
            <td style="padding-left:10px;font-size:10pt">Related PO</td>
            <td style="padding-left:10px;font-size:10pt" colspan="2">: <?= $po ?></td>
        </tr>
        <tr>
            <td style="padding-left:10px;font-size:10pt">Quantity</td>
            <td style="padding-left:10px;font-size:10pt" colspan="2">: <?= $qty ?></td>
        </tr>
        <tr>
            <td style="padding-left:10px;font-size:10pt">Related form</td>
            <td style="padding-left:10px;font-size:10pt" colspan="2">: Penilaian Quality Objective Pembelian Supplier CV KHS Periode <?= $c['PERIODE'] ?></td>
        </tr>
        <tr>
            <td style="padding-left:10px;padding-top:10px;font-size:10pt;border-top:1px solid black;border-collapse:collapse" colspan="3"><strong>Description of Fact Finding</strong></td>
        </tr>
        <tr>
            <td style="padding-left:10px;font-size:10pt;vertical-align:top" rowspan="5" colspan="2"><?= $c['DETAIL'][0]['ROOTCAUSE_CATEGORI'] ?></td>
            <td style="padding-left:10px;font-size:10pt;border:1px solid black; border-collapse:collapse;width:250px;text-align:center;background-color:lightgray"><strong>Approved by,</strong></td>

        </tr>
        <tr>
            <td style="border-left:1px solid black; border-collapse:collapse"><br></td>

        </tr>
        <tr>
            <td style="border-left:1px solid black; border-collapse:collapse"><br></td>

        </tr>
        <tr>
            <td style="border-left:1px solid black; border-collapse:collapse"><br></td>

        </tr>
        <tr>
            <td style="padding-left:10px;font-size:10pt;border:1px solid black; border-collapse:collapse;text-align:center"><?= $c['APPROVER'] ?></td>

        </tr>
        <tr>
            <td style="padding-left:10px;" colspan="2"><strong>CAR ini dikirimkan agar dilakukan perbaikan sehingga kasus serupa tidak terulang di kemudian hari.</strong></td>
            <td style="padding-left:7px;font-size:10pt;border:1px solid black; border-collapse:collapse;font-size:8pt">Date : <?= $c['DETAIL'][0]['APPROVE_DATE'] ?></td>

        </tr>
    </table>
    <p style="text-align: right;margin-bottom:10px;font-size:8pt;font-style:italic;font-family:Arial, Helvetica, sans-serif"><?= $c['KET'] ?></p>
    <strong style="font-size:10pt;font-family:arial;">Filled By Vendor</strong>
    <table style="width: 100%;border:1px solid black;border-collapse:collapse;font-family:arial;font-size:10pt;margin-bottom:10px">
        <tr>
            <td style="padding-left:10px;padding-top:10px;font-size:10pt" colspan="5"><strong>Rootcause Analysis</strong></td>
        </tr>
        <tr>
            <td colspan="5" style="padding-left:10px"><br><br><br><br><br><br><br><br><br></td>
        </tr>
        <tr>
            <td style="padding-left:10px;padding-top:10px;font-size:10pt;border-top:1px solid black;border-collapse:collapse" colspan="5"><strong>Corrective Action</strong></td>
        </tr>
        <tr>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px;border:1px solid black;border-collapse:collapse;width:110px;background-color:lightgray;text-align:center"><strong>Approved By,</strong></td>
            <td style="padding-left:10px;border:1px solid black;border-collapse:collapse;width:110px;background-color:lightgray;text-align:center"><strong>Made By,</strong></td>
        </tr>
        <tr>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px;border-left:1px solid black;border-collapse:collapse;"><br><br><br><br></td>
            <td style="padding-left:10px;border-left:1px solid black;border-collapse:collapse;"></td>
        </tr>
        <tr>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px;border:1px solid black;border-collapse:collapse;"><br></td>
            <td style="padding-left:10px;border:1px solid black;border-collapse:collapse;"><br></td>
        </tr>
        <tr>
            <td style="padding-left:10px">Plan start date: ____________________ </td>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px">Target Completion Date: ____________________</td>
            <td style="padding-left:5px;border:1px solid black;border-collapse:collapse;font-size:8pt">Date :</td>
            <td style="padding-left:5px;border:1px solid black;border-collapse:collapse;font-size:8pt">Date :</td>
        </tr>
    </table>

    <strong style="font-size:10pt;font-family:arial;">Filled By CV. KHS</strong>
    <table style="width: 100%;border:1px solid black;border-collapse:collapse;font-family:arial;font-size:10pt">
        <tr>
            <td style="padding-left:10px;padding-top:10px;font-size:10pt;border-top:1px solid black;border-collapse:collapse" colspan="5"><strong>Verification <br><br><br><br></strong></td>
        </tr>
        <tr>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px;border:1px solid black;border-collapse:collapse;width:110px;background-color:lightgray;text-align:center"><strong>Approved By,</strong></td>
            <td style="padding-left:10px;border:1px solid black;border-collapse:collapse;width:110px;background-color:lightgray;text-align:center"><strong>Verified By,</strong></td>
        </tr>
        <tr>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px;border-left:1px solid black;border-collapse:collapse;"><br><br><br><br></td>
            <td style="padding-left:10px;border-left:1px solid black;border-collapse:collapse;"></td>
        </tr>
        <tr>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px"></td>
            <td style="padding-left:10px;border:1px solid black;border-collapse:collapse;"><br></td>
            <td style="padding-left:10px;border:1px solid black;border-collapse:collapse;"><br></td>
        </tr>
        <tr>
            <td style="padding-left:10px">Action effectiveness : </td>
            <td style="padding-left:10px"><strong>o</strong> Effective</td>
            <td style="padding-left:10px"><strong>o</strong> Need more improvement</td>
            <td style="padding-left:5px;border:1px solid black;border-collapse:collapse;font-size:8pt">Date :</td>
            <td style="padding-left:5px;border:1px solid black;border-collapse:collapse;font-size:8pt">Date :</td>
        </tr>
    </table>
    <pagebreak></pagebreak>
    <!-- Page2 -->
    <strong style="font-size:10pt;font-family:arial;font-style:italic">Attachment</strong>
    <table style="width: 100%;font-family:arial;font-size:8pt;border:1px;border-color:lightgray;border-collapse:collapse;margin-top:10px">
        <tr>
            <th style="text-align: center;border:1px;border-collapse:collapse;background-color:lightgray">PO Number</th>
            <th style="text-align: center;border:1px;border-collapse:collapse;background-color:lightgray">Line</th>
            <th style="text-align: center;border:1px;border-collapse:collapse;background-color:lightgray">Item Code</th>
            <th style="text-align: center;border:1px;border-collapse:collapse;background-color:lightgray">Item Description</th>
            <th style="text-align: center;border:1px;border-collapse:collapse;background-color:lightgray">UoM</th>
            <th style="text-align: center;border:1px;border-collapse:collapse;background-color:lightgray">Qty PO</th>
            <th style="text-align: center;border:1px;border-collapse:collapse;background-color:lightgray">Received Date PO</th>
            <th style="text-align: center;border:1px;border-collapse:collapse;background-color:lightgray">Shipment Date</th>
            <th style="text-align: center;border:1px;border-collapse:collapse;background-color:lightgray">Lppb Number</th>
            <th style="text-align: center;border:1px;border-collapse:collapse;background-color:lightgray">Actual Receipt Date</th>
            <th style="text-align: center;border:1px;border-collapse:collapse;background-color:lightgray">Qty Receipt</th>
            <th style="text-align: center;border:1px;border-collapse:collapse;background-color:lightgray">Notes</th>
            <th style="text-align: center;border:1px;border-collapse:collapse;background-color:lightgray">Detail Rootcause</th>
            <th style="text-align: center;border:1px;border-collapse:collapse;background-color:lightgray">Rootcause Categori</th>

        </tr>
        <?php foreach ($c['DETAIL'] as $val) { ?>
            <tr>
                <td style="text-align: center;"><?= $val['PO_NUMBER'] ?></td>
                <td style="text-align: center;"><?= $val['LINE'] ?></td>
                <td style="text-align: center;"><?= $val['ITEM_CODE'] ?></td>
                <td style="text-align: center;"><?= $val['ITEM_DESCRIPTION'] ?></td>
                <td style="text-align: center;"><?= $val['UOM'] ?></td>
                <td style="text-align: center;"><?= $val['QTY_PO'] ?></td>
                <td style="text-align: center;"><?= $val['RECEIVED_DATE_PO'] ?></td>
                <td style="text-align: center;"><?= $val['SHIPMENT_DATE'] ?></td>
                <td style="text-align: center;"><?= $val['LPPB_NUMBER'] ?></td>
                <td style="text-align: center;"><?= $val['ACTUAL_RECEIPT_DATE'] ?></td>
                <td style="text-align: center;"><?= $val['QTY_RECEIPT'] ?></td>
                <td style="text-align: center;"><?= $val['NOTES'] ?></td>
                <td style="text-align: center;"><?= $val['DETAIL_ROOTCAUSE'] ?></td>
                <td style="text-align: center;"><?= $val['ROOTCAUSE_CATEGORI'] ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>