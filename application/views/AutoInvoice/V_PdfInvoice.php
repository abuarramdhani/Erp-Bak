<table style="width: 100%;font-family:Arial, Helvetica, sans-serif;font-size:10pt">
    <tr>
        <td style="width: 83%;"></td>
        <td><?= $Invoice[0]['INVOICE_NUM'] ?></td>
    </tr>
</table>
<br>
<table style="width: 100%;font-family:Arial, Helvetica, sans-serif;font-size:8pt">
    <tr>
        <td><?= $Invoice[0]['SHIP_TO_NAME'] ?></td>
        <td style="width: 50px;"></td>
        <td><?= $Invoice[0]['BILL_TO_NAME'] ?></td>
    </tr>
    <tr>
        <td><?= $Invoice[0]['SHIP_TO_ADDR1'] ?></td>
        <td></td>
        <td><?= $Invoice[0]['BILL_TO_ADDR1'] ?></td>
    </tr>
    <tr>
        <td><?= $Invoice[0]['SHIP_TO_ADDR2'] ?></td>
        <td><?= $Invoice[0]['CURRENCY'] ?></td>
        <td><?= $Invoice[0]['BILL_TO_ADDR2'] ?></td>
    </tr>
</table>
<table style="width: 100%;font-family:Arial, Helvetica, sans-serif;font-size:8pt">
    <tr>
        <td style="width: 65%;"></td>
        <td><?= $Invoice[0]['NPWP'] ?></td>
    </tr>
</table>
<br>
<table style="width: 100%;font-family:Arial, Helvetica, sans-serif;font-size:8pt">
    <tr>
        <td style="padding-left:20px;width:170px"><?= $Invoice[0]['SO_NUM'] ?></td>
        <td style="width:100px"><?= $Invoice[0]['ITEM_SHIP'] ?></td>
        <td style="text-align: center;"><?= $Invoice[0]['KODE_KONSUMEN'] ?></td>
        <td style="text-align: center;"><?= $Invoice[0]['INVOICE_DATE'] ?></td>
        <td style="text-align: center;"><?= $Invoice[0]['TEMPO'] ?></td>
        <td style="text-align: center;"><?= $Invoice[0]['DUE_DATE'] ?></td>
    </tr>
</table>
<br>
<table style="width: 100%;font-family:Arial, Helvetica, sans-serif;font-size:8pt">
    <?php $n = 1;
    foreach ($Invoice as $key => $in) { ?>
        <tr>
            <td style="width:35px"><?= $in['QTY'] ?></td>
            <td style="width:30px"><?= $in['UOM'] ?></td>
            <td style="width:100px"><?= $in['ITEM_CODE'] ?></td>
            <td style=" width:190px"><?= $in['ITEM_DESC'] ?></td>
            <td style="text-align:right"><?= number_format($in['UNIT_PRICE'], 0) ?></td>
            <td style="text-align:right"><?= $in['DISKON'] ?></td>
            <td style="text-align:right"><?= number_format($in['NETTO'], 0) ?></td>
            <td style="padding-left: 20px;text-align:right"><?= number_format($in['DPP'], 0) ?></td>
        </tr>
    <?php $n++;
    } ?>
</table>